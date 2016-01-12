<?php
/*--------
By      : Teysseire Guillaume
Date    : 23/12/2015
Update  : 24/12/2015
Licence : © Copyright
Version : 1.1
-------------------------
*/
class Controller_PanelAdmin
{
	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public function __construct() 
    {
    	
    }

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
    public function index( $params )
	{
		return $GLOBALS['Twig']->render( FoxFWKernel::getView('pattern_admin'));
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
    public function viewMenu( $params )
	{
		//verifier si le cache menu admin existe
		$url = _CACHE.$GLOBALS['Config']['Admin']['cache'];
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

					if( method_exists( $c, $GLOBALS['Config']['Admin']['method'] ))
					{
						$buffer = $c->{ $GLOBALS['Config']['Admin']['method'] }();//method admin
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
			if( !empty( $value['panel'] ))
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
		return $GLOBALS['Twig']->render( FoxFWKernel::getView('pattern_admin_menu') ,array('menu'=>$menu ));
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	static public function viewPanelAdmin()
	{
		$ret = array(
			'titre'  => 'Configuration',
			'router' => '#',
			'role'   => 'CONFIG',
			'panel'   => FoxFWKernel::getView('admin_panelAdmin')
		);
		return $ret;
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public function viderCache( $params )
	{
		//vider le cache mais on garde le dossier
		FoxFWFile::delTree( _CACHE, false);
		FoxFWKernel::loadRouter('PanelAdmin_view');
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public function viewRouter( $params )
	{
		return $GLOBALS['Twig']->render( FoxFWKernel::getView('admin_viewRouter'), array('router'=>$GLOBALS['Route']));
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public function viewConfiguration( $params )
	{
		$config = json_decode(json_encode($GLOBALS['Config']),true);

		ob_start();
			phpinfo();
			$phpinfo = ob_get_contents();
		ob_get_clean();

		return $GLOBALS['Twig']->render( FoxFWKernel::getView('admin_viewConfiguration'), array('config'=>$config,'phphinfo'=>$phpinfo));
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public function viewMVC( $params )
	{
		return $GLOBALS['Twig']->render( FoxFWKernel::getView('admin_viewMVC'), 
			array('model'     => $GLOBALS['Config']['Model'],
				  'view'      => $GLOBALS['Config']['View'],
				  'controller'=> $GLOBALS['Config']['Controller']));
	}
};