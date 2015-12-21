<?php
/*
	::FoxFWKernel::
	V3.52
*/

/*--------
By      : Teysseire Guillaume
Date    : 12/03/2015
Update  : 21/12/2015
Licence : © Copyright
Version : 3.52
-------------------------
*/

/*
//Kernel:
	FoxFWKernel::build( $config_url );
	FoxFWKernel::controller( $method, $params );
	FoxFWKernel::addVendor( $file );
	FoxFWKernel::addModel( $name );
	FoxFWKernel::addBundleFile( $file );
	FoxFWKernel::addFile( $file );
	FoxFWKernel::merge_object( $obj, $obj_add );

//Routage URL:
	FoxFWKernel::router( $id, $add = '' );
	FoxFWKernel::loadRouter( $id, $add = '');
	FoxFWKernel::path( $url );
	FoxFWKernel::bundlePath( $path = '' );

//Gestion document:
	FoxFWKernel::URLencode($str, $charset='utf-8');
	FoxFWKernel::getTokenForm();

//Debug:
	FoxFWKernel::debug( $var );
	FoxFWKernel::scriptTimeStart();
	FoxFWKernel::scriptTimeStop();
	FoxFWKernel::writelog( $message );
*/



class FoxFWKernel
{
	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public static function build( $config_url, $cache_config )
	{
		//Début session
		@session_start();

		//security
		FoxFWKernel::security();

		//Chargement de la configuration
		$GLOBALS['Config'] = FoxFWKernel::buildConfiguration( $config_url, $cache_config );
		
		//verifier la syntaxe JSON
		if( $GLOBALS['Config'] == NULL )
			die( $config_url.': syntaxe error !');

		//activier ou pas les erreurs PHP
		if( !$GLOBALS['Config']['FoxFW']['php_error'] )
			error_reporting(0);

		//-------------------------------------------------------------
		//Default constante
		foreach ($GLOBALS['Config']['Define'] as $key => $value)
			define( $key , $value);

		//Dépendences
		foreach ($GLOBALS['Config']['Require'] as $key => $value)
			FoxFWKernel::addVendor( $value );

		//model
		foreach ($GLOBALS['Config']['Model'] as $key => $value)
			FoxFWKernel::addBundleFile( $value );

		//Route
		if( !isset($GLOBALS['Config']['Route']))
			exit('No route defined !');
		$GLOBALS['Route'] = FoxFWKernel::ObjJsonFileBuild( $GLOBALS['Config']['Route'], 'route.json' );
		if( $GLOBALS['Route'] == NULL )
			die( 'Route syntaxe error !');

		//-------------------------------------------------------------
		//Configuration RedBean ORM
		$co = $GLOBALS['Config']['RedBean'];
		R::setup( $co['connect'], $co['user'], $co['pass'] );

		//-------------------------------------------------------------
		//Chargement User
		$GLOBALS['User'] = new FoxFWUsers();

		//-------------------------------------------------------------
		//création de la table de routage
		$GLOBALS['Router'] = new AltoRouter();
		$GLOBALS['Router']->setBasePath( $GLOBALS['Config']['AltoRouter']['BasePath'].'/' );

		//Chargement des routes dans AltoRouter
		foreach ($GLOBALS['Route'] as $key => $value)
		{
			$GLOBALS['Router']->map( 
				$value->method,
				$value->path, 
				$value->controller, 
				$key);
		}

		//-------------------------------------------------------------
		//Configuration de twig
		$cache = false;
		if( $GLOBALS['Config']['FoxFW']['cache'] )
			$cache = _CACHE;


		Twig_Autoloader::register();

		$loader          = new \Twig_Loader_Filesystem('./');
		$GLOBALS['Twig'] = new \Twig_Environment($loader, array( 'cache' => $cache ));

		//twig extension function User !
		$GLOBALS['Twig']->addGlobal('User', $GLOBALS['User'] );

		//-------------------------------------------------------------
		//security formulaire
		FoxFWKernel::securityFormSend();

		//twig function ajout d'un token de securite au formulaire
		$GLOBALS['Twig']->addFunction( new Twig_SimpleFunction('securityForm',
		function()
		{
			$token = FoxFWKernel::getTokenPost();
			$var  = '<input type="hidden" name="tf_t" value="'.$token['token'].'"/>';
			$var .= '<input type="hidden" name="tf_u" value="'.$token['clef'].'"/>';
			return $var;
		},array('is_safe' => array('html')) ));

		//-------------------------------------------------------------
		//extension du Kernel !
		if( isset( $GLOBALS['Config']['Addon'] ))
		foreach ($GLOBALS['Config']['Addon'] as $key => $value)
			if( file_exists( _BUNDLE.$value ))
				require_once _BUNDLE.$value;

		//-------------------------------------------------------------
		//traitement de la page
		$etat  = 404;
		$match = $GLOBALS['Router']->match();//recuperer la page charger

		//controller principal
		if($match)
		if( $GLOBALS['User']->isRole( $GLOBALS['Route'][ $match['name'] ]->firewall ))//FireWall
		{
			$etat = FoxFWKernel::controller( $match['target'], $match['params'] );
			//si pas d'erreur
			if( $etat == 200 )
				return;
		}
		else
			$etat = 401;

		//Erreur controller
		$error = $GLOBALS['Config']['FoxFW']['controller_error'].'#e'.$etat;
		if( FoxFWKernel::controller( $error, array() ) == 200 )
			return;

		//Default error serveur
		header('HTTP/1.0 500 Not Found');
		echo 'Erreur interne du serveur !';
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public static function controller( $controller, $params )
	{
		$controller = explode('#', $controller );

		if( !isset( $GLOBALS['Config']['Controller'][ $controller[0] ] ))
		{
			echo 'Error config controller: '.$controller[0].'<br/>';
			return 500;
		}

		//inclure le controller
		if( !class_exists( $controller[0] ))
		{
			$file = $GLOBALS['Config']['Controller'][ $controller[0] ];
			if( file_exists( $file ))
				require_once $file;
			else
				return 500;
		}

		//création et execution du controller
		$obj_controller = new $controller[0]();
		if( method_exists( $obj_controller, $controller[1] ))
			echo $obj_controller->{ $controller[1] }( $params );
		else
			return 500;
		return 200;
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	private static function security()
	{
		//temps de recharge formulaire
		if( !isset( $_SESSION['_security_time'] ))
			$_SESSION['_security_time'] = time();

		//nettoyage des variables GET
		$_GET = array_map('htmlspecialchars', $_GET);

		//nettoyage cookie
		$_COOKIE = array_map('htmlspecialchars', $_COOKIE);

		//traitement des variables POST
		if( count($_POST) > 0) //si le tableau est pas vide
		{
			//anti-bruteforce
			if( time() < $_SESSION['_security_time']+2 )
				sleep(3);
			$_SESSION['_security_time'] = time();

			//nettoyage variable POST
			$_POST = array_map('htmlspecialchars', $_POST);
		}

		//L'adresse de la page (si elle existe) qui a conduit le client à la page courante
		if(isset($_SERVER['HTTP_REFERER'])
		&& $_SERVER['HTTP_REFERER']!=''
		&& substr($_SERVER['HTTP_REFERER'], 7, strlen($_SERVER['SERVER_NAME'])) != $_SERVER['SERVER_NAME'])
		{
			$_POST = array();
			$_GET  = array();
			sleep(5);//anti-bruteforce
		}
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	private static function securityFormSend()
	{
		//token des formulaires
		if( !isset($_SESSION['form_token']) )
			$_SESSION['form_token'] = FoxFWCrypte::randomString( 20 );

		if( count($_POST) > 0)
		{
			//verifier que le token existe dans le formulaire
			if( isset($_POST['tf_t']) && isset($_POST['tf_u']))
			{
				if( $GLOBALS['User']->isLogin() )
				{
					$clef = FoxFWCrypte::decrypte( $_POST['tf_u'], $_SESSION['form_token'] );
					if( $clef != $GLOBALS['User']->getClef() )
					{
						sleep(10);
						FoxFWKernel::loadRouter('index');
					}
				}

				if( $_POST['tf_t'] != $_SESSION['form_token'] )
				{
					sleep(3);
					FoxFWKernel::loadRouter('index');
				}
			}
			else
				die('Security: Error Form !');

			//recharge du token
			$_SESSION['form_token'] = FoxFWCrypte::randomString( 20 );
		}
	}
	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	/* return $tab['token'], $tab['clef'] */
	public static function getTokenPost()
	{
		$tab = array();
		$tab['token'] = $_SESSION['form_token'];

		//si le joueur n'st pas co, on met ca clef qui change a toute les pages
		$tab['clef'] = $GLOBALS['User']->getClef();
		if( $GLOBALS['User']->isLogin() )
			$tab['clef'] = FoxFWCrypte::crypte( $tab['clef'], $_SESSION['form_token'] );

		return $tab;
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public static function router( $id, $add = '' )
	{
		//si la route existe
		if( isset( $GLOBALS['Route'][$id] ))
		{
			//supprime les [ ... ]
			$path = $GLOBALS['Route'][ $id ]->path;
			$pos = strpos( $path, '[');
			if( $pos !== false )
			{
				$l = strlen($path);
				$path = substr( $path, 0, $pos-$l );
			}
			return FoxFWKernel::path( $path.$add );
		}
	    return '#';
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public static function path( $url = '' )
	{
	    return 'http://'.$_SERVER['HTTP_HOST'].'/'.$GLOBALS['Config']['AltoRouter']['BasePath'].$url;
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public static function loadRouter( $id, $add = '')
	{
		header('Location: '.FoxFWKernel::router($id, $add) );
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	// 
	// $path = bundle#fichier
	//--------------------------------------------------------------------------------
	public static function bundlePath( $path = '' )
	{
		$tab = explode('#', $path);
		if( empty($tab[1]) )
			return '#';

	    return FoxFWKernel::path( _BUNDLE.$tab[0].'/web/'.$tab[1] );
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public static function debug( $var )
	{
		echo '<pre>';
		var_dump( $var );
		echo '</pre>';
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public static function addVendor( $file )
	{
		return FoxFWKernel::addFile( _VENDOR.$file );
	}
	
	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public static function addModel( $name )
	{
		if( !class_exists( $name ))
		{
			$path = $GLOBALS['Config']['Model'][ $name ];
			return FoxFWKernel::addFile( $path );
		}
		return false;
	}
	
	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public static function addController( $controller )
	{
		if( !class_exists( $controller ))
		{
			$path = $GLOBALS['Config']['Controller'][ $controller ];
			return FoxFWKernel::addFile( $path );
		}
		return false;
	}
	
	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public static function addBundleFile( $file )
	{
		return FoxFWKernel::addFile( _BUNDLE.$file );
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public static function addFile( $file )
	{
		$file = $file;
		if( file_exists( $file ))
		{
			require_once $file;
			return true;
		}
		return false;
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public static function getView( $name )
	{
		if( isset( $GLOBALS['Config']['View'][ $name ] ))
			return $GLOBALS['Config']['View'][ $name ];
		return $GLOBALS['Config']['FoxFW']['view_error'];
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public static function URLencode($str, $charset='utf-8')
	{
	    return FoxFWFile::encodeString( $str, $charset );
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public static function ObjJsonFileBuild( $tab, $file_output )
	{
		$ret = array();
		$url = _CACHE.$file_output;

		//si le fichier n'existe pas ont le construit
		if( !file_exists($url))
		{
			foreach ($tab as $key => $value)
			{
				$data = FoxFWFile::readJson( _BUNDLE.$value );
				foreach ($data as $_key => $_value)
					$ret[$_key] = $_value;
			}
			//creation d'un fichier unique
			if( $GLOBALS['Config']['FoxFW']['cache'] )
				FoxFWFile::writeJson( $url, $ret );
			return $ret;
		}
		//lire le fichier car il existe
		return FoxFWFile::readJson($url);
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	private static function buildConfiguration( $config_start, $cache_config )
	{
		//Verifier si une compilation de la configuratino existe déja
		if( file_exists( $cache_config ) )
			return json_decode( file_get_contents( $cache_config ),true);

		//chargement configuration basique
		$config = json_decode( file_get_contents( $config_start ),true);
		if( $config == NULL )
			exit('Config .json error !');

		//-------------------------------------------------------
		//preparation structure
		$config['Controller'] = [];
		$config['Model']      = [];
		$config['View']       = [];

		//-------------------------------------------------------

		//recherche configuration des bundles
		if( !isset($config['Bundle']))
		{
			$config['Bundle'] = [];
			$bundle_url       = $config['Define']['_BUNDLE'];

			$bundle = scandir( $bundle_url );
			//création de la configuration
			foreach ($bundle as $key => $value)
			if( $value != '.' )
			if( $value != '..' )
			{
				$config['Bundle'][ $value ] = $bundle_url.$value.'/';

				$file = $bundle_url.$value.'/config.json';
				if( file_exists( $file ) )
				{
					//chargement et fusion de la configuration
					$data   = json_decode( file_get_contents( $file ),true);
					$config = FoxFWKernel::merge_object( $config, $data );
				}
			}
		}

		//recupére les paths des fichiers ce trouvant dans le dossier
		$searchAddFile = function( $dossier )
		{
			$ret = [];
			//Detections des objects
			if(file_exists($dossier))
			{
				$scan = scandir( $dossier );
				foreach ($scan as $key2 => $value2)
				if( $value2 != '.' )
				if( $value2 != '..' )
				{
					$tab = explode('.',$value2);

					$ret[ $tab[0] ] = $dossier.$value2;
				}
			}
			return $ret;
		};

		//-------------------------------------------------------
		//chargement controller / model / view
		foreach ($config['Bundle'] as $key => $value)
		{
			//Detections des controllers
			$config['Controller'] += $searchAddFile( $value.'controller/' );
			//Detection des models
			$config['Model']      += $searchAddFile( $value.'model/' );
			//Detection des view
			$config['View']       += $searchAddFile( $value.'view/' );
		}
		//-------------------------------------------------------
		//Surcharge des bundles par le bundle master
		if( isset($config['MasterBundle'])) 
		{
			//Detections des controllers
			$tab = $searchAddFile( $config['MasterBundle'].'controller/' );
			foreach ($tab as $key => $value)
				$config['Controller'][ $key ] = $value;

			//Detection des models
			$tab = $searchAddFile( $config['MasterBundle'].'model/' );
			foreach ($tab as $key => $value)
				$config['Model'][ $key ] = $value;
			
			//Detection des view
			$tab = $searchAddFile( $config['MasterBundle'].'view/' );
			foreach ($tab as $key => $value)
				$config['View'][ $key ] = $value;
		}
		
		/*$tab = $searchAddFile( $path ); //Marche pas: $config['View'] += $searchAddFile( $path );
		foreach ($tab as $key => $value)
			$config['View'][ $key ] = $value;*/

		//-------------------------------------------------------
		//compilation de la config si cache ON
		if( isset($config['FoxFW'] ))
		if($config['FoxFW']['cache'])
			file_put_contents($cache, json_encode( $config ));

		//-------------------------------------------------------
		return $config;
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public static function merge_object( $obj, $obj_add )
	{
		if( $obj_add == NULL )
			exit('FoxFWKernel: Error file(s) config .json !');

		//fusion des tableaus
		foreach ($obj_add as $key => $value)
		{
			if( !isset( $obj[$key] ))
				$obj[ $key ] = array();

			//remplissage contenu
			foreach ($value as $key2 => $value2)
				$obj[ $key ][ $key2 ] = $value2;
		}
		return $obj;
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public static function scriptTimeStart()
	{
		session_start();

		if( !isset($_SESSION['FoxWFSTS']))
			$_SESSION['FoxWFSTS'] = 0;
		if( !isset($_SESSION['FoxWFSTS2']))
			$_SESSION['FoxWFSTS2'] = 0;

		$_SESSION['FoxWFSTST'] = microtime(true);
	}
	public static function scriptTimeStop()
	{
		$timestart = $_SESSION['FoxWFSTST'];
		//Fin du code PHP
		$timeend=microtime(true);
		$time=$timeend-$timestart;

		//stat
		$_SESSION['FoxWFSTS' ] += $time;
		$_SESSION['FoxWFSTS2'] += 1;
		 
		//Afficher le temps d'éxecution
		$page_load_time = number_format($time, 3);
		$msg = '<div style="position:fixed;bottom:0px; left:0px; background-color:yellow;">';
		$msg .= "Debut du script: ".date("H:i:s", $timestart);
		$msg .= "<br>Fin du script: ".date("H:i:s", $timeend);
		$msg .= "<br><b>Script execute en " . $page_load_time . " sec</b>";
		$msg .= "<br/>Moyenne script : ".number_format($_SESSION['FoxWFSTS' ]/$_SESSION['FoxWFSTS2'],3).' sur '.$_SESSION['FoxWFSTS2'].'/20';
		$msg .= '</div>';

		if( $_SESSION['FoxWFSTS2'] == 20 )
		{
			$_SESSION['FoxWFSTS' ] =0;
			$_SESSION['FoxWFSTS2'] =0;
		}
		echo $msg;
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public static function writelog( $msg )
	{
		if( isset($GLOBALS['Config']['FoxFW']['log_output']))
			return;

		$file = $GLOBALS['Config']['FoxFW']['log_output'];
		file_put_contents( $file, ('['.date("Y-m-d H:i:s").'] =>'.$msg.'\n'), FILE_APPEND );
	}
};