<?php
/*--------
By      : Teysseire Guillaume
Date    : 12/03/2015
Update  : 23/12/2015
Licence : © Copyright
Version : 1.1
-------------------------
*/
class Controller_error
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
	public function e400()
	{
		return $GLOBALS['Twig']->render( FoxFWKernel::getView('error_error'), array(
			'error'=>'400',
			'message'=>'La syntaxe de la requête est erronée !'));
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public function e401()
	{
		//header('Location: '.FoxFWKernel::router('user_login') );
		
		return $GLOBALS['Twig']->render( FoxFWKernel::getView('error_error'), array(
			'error'=>'401',
			'message'=>'<b style="color:red;">Une authentification/Roles est nécessaire pour accéder à la ressource !</b><br/><a href="'.FoxFWKernel::router('user_login').'"> - Se connecter - </a>'));
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public function e404()
	{
		return $GLOBALS['Twig']->render( FoxFWKernel::getView('error_error'), array(
			'error'=>'404',
			'message'=>'Ressource non trouvée'));
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public function e500()
	{
		return $GLOBALS['Twig']->render( FoxFWKernel::getView('error_error'), array(
			'error'=>'500',
			'message'=>'Erreur interne du serveur !'));
	}
};