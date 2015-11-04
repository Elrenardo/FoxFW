<?php
/*--------
By      : Teysseire Guillaume
Date    : 12/03/2015
Update  : 24/09/2015
Licence : © Copyright
Version : 1.0
-------------------------
*/
//--------------------------------------
/* panel administration inclu au site */
//--------------------------------------

//twig menu admin
$GLOBALS['Twig']->addFunction( new Twig_SimpleFunction('viewPanelAdmin',
function()
{
	//verifier si le cache menu admin existe
	$url = _CACHE.$GLOBALS['Config']['PanelAdmin']['cache'];
	if( !file_exists( $url ) )
	{
		//trouver tout les controller en analisant les routes
		$controller = array();
		$menu       = array();

		//construction corps
		foreach ($GLOBALS['Route'] as $key => $value)
		{
			$tab = explode('#',$value->controller ); 
			if( !in_array($tab[0], $controller) )
			if( isset($GLOBALS['Config']['Controller'][ $tab[0] ]))
			if( file_exists( $GLOBALS['Config']['Controller'][ $tab[0] ] ))
			{
				array_push( $controller, $tab[0] );
				
				//include le controller et recupérer le tableau du menu
				require_once $GLOBALS['Config']['Controller'][ $tab[0] ];
				$c = new $tab[0]();

				if( method_exists( $c, $GLOBALS['Config']['PanelAdmin']['method'] ))
				{
					$buffer = $c->{ $GLOBALS['Config']['PanelAdmin']['method'] }();//method admin
					if( $buffer != NULL )
						array_push( $menu, $buffer );
				}
				unset( $c );
			}
		}
		//si cache actif
		if( $GLOBALS['Config']['FoxFW']['cache'] )
			file_put_contents( $url, json_encode( $menu ) );
	}
	else
		$menu = json_decode( file_get_contents( $url ), true);

	//recupéré le contenu du menu et verifier les roles
	foreach ($menu as $key => $value)
	{
		//FoxFWKernel::debug( $value['panel'] );
		if( isset( $menu[ $key ]['role']))
		{
			if( $GLOBALS['User']->isRole( $menu[ $key ]['role'] ))
				$menu[ $key ]['panel'] = $GLOBALS['Twig']->render( $value['panel'], array() );
			else
				unset($menu[ $key ]);
		}
		else
			$menu[ $key ]['panel'] = $GLOBALS['Twig']->render( $value['panel'], array() );
	}

	//compilation de la vue
	return $GLOBALS['Twig']->render( FoxFWKernel::getView( $GLOBALS['Config']['PanelAdmin']['render'] ) ,array('menu'=>$menu ));
},array('is_safe' => array('html')) ));