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
		return $GLOBALS['Twig']->render( FoxFWKernel::getView('index'), array('liste'=>$liste));
	}
};