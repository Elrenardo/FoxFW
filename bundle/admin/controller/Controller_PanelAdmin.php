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
    public function view( $params )
	{
		return $GLOBALS['Twig']->render( FoxFWKernel::getView('admin_index'));
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
    public function viewMenu( $params )
	{
		$data = array();
		foreach ($GLOBALS['config']['Admin'] as $key => $value)
		{
			$tab = FoxFWFile::readJson( $value );
			$data[ $key ] = FoxFWFile::readJson( $value );
		}

		return $GLOBALS['Twig']->render( FoxFWKernel::getView('pattern_admin_menu'),
			array('menu'=>$data));
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

		//copier le phpinfo() dans une variable
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