<?php
/*--------
By      : Teysseire Guillaume
Date    : 12/03/2015
Update  : 24/09/2015
Licence : © Copyright
Version : 1.0
-------------------------
*/
class Controller_index
{
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
		FoxFWKernel::addVendor('foxFW/FoxFWPage.php');

		//liste new article
    	$page = new FoxFWPage();
    	$liste = $page->liste(array('max'=>20,'type'=>'Article'));

		//return $GLOBALS['Twig']->render( _BUNDLE.'foxfw/view/index.html.twig', array('liste'=>$liste));
		return $GLOBALS['Twig']->render( FoxFWKernel::getView('foxfw_index'), array('liste'=>$liste));
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
			'panel'   => FoxFWKernel::getView('foxfw_panelAdmin')
		);
		return $ret;
	}

    //--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public function debug( $params )
	{
		return $GLOBALS['Twig']->render( FoxFWKernel::getView('foxfw_debug'), array());
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
		FoxFWKernel::loadRouter('index');
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public function viewRouter( $params )
	{
		return $GLOBALS['Twig']->render( FoxFWKernel::getView('foxfw_viewRouter'), array('router'=>$GLOBALS['Route']));
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

		return $GLOBALS['Twig']->render( FoxFWKernel::getView('foxfw_viewConfiguration'), array('config'=>$config,'phphinfo'=>$phpinfo));
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public function viewMVC( $params )
	{
		return $GLOBALS['Twig']->render( FoxFWKernel::getView('foxfw_viewMVC'), 
			array('model'     => $GLOBALS['Config']['Model'],
				  'view'      => $GLOBALS['Config']['View'],
				  'controller'=> $GLOBALS['Config']['Controller']));
	}
};