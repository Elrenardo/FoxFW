<?php
/*--------
By      : Teysseire Guillaume
Date    : 12/03/2015
Update  : 24/09/2015
Licence : © Copyright
Version : 1.0
-------------------------
*/
//--------------------------------------------------------------------------------
//--------------------------------------------------------------------------------
//
//
//
//--------------------------------------------------------------------------------
//twig extension function path !
$GLOBALS['Twig']->addFunction( new Twig_SimpleFunction('path',
function( $url )
{
    return FoxFWKernel::path( $url );
}));

//--------------------------------------------------------------------------------
//--------------------------------------------------------------------------------
//
//
//
//--------------------------------------------------------------------------------
//twig extension function router !
$GLOBALS['Twig']->addFunction( new Twig_SimpleFunction('router',
function( $id, $add = '' )
{
	return FoxFWKernel::router( $id, $add );
}));

//--------------------------------------------------------------------------------
//--------------------------------------------------------------------------------
//
//
//
//--------------------------------------------------------------------------------
//twig extension function controller
$GLOBALS['Twig']->addFunction( new Twig_SimpleFunction('controller',
function( $method, $params = array() )
{
	$error = FoxFWKernel::controller( $method, $params );
	if( $error != 200 )
		die('Error Controller Twig Appel ! ');
},array('is_safe' => array('html')) ));

//--------------------------------------------------------------------------------
//--------------------------------------------------------------------------------
//
//
//
//--------------------------------------------------------------------------------
//renvoi la view
$GLOBALS['Twig']->addFunction( new Twig_SimpleFunction('getView',
function( $view )
{
	return FoxFWKernel::getView( $view );
}));

//--------------------------------------------------------------------------------
//--------------------------------------------------------------------------------
//
//
//
//--------------------------------------------------------------------------------
//decodage des htmlspecialchars
$GLOBALS['Twig']->addFunction( new Twig_SimpleFunction('htmlspecialchars_decode',
function( $text )
{
    return  htmlspecialchars_decode( $text );
}));

//--------------------------------------------------------------------------------
//--------------------------------------------------------------------------------
//
//
//
//--------------------------------------------------------------------------------
//time to date !
$GLOBALS['Twig']->addFunction( new Twig_SimpleFunction('timeToDate',
function( $time )
{
    return date("d/m/Y à H:i \H", $time );
}));

//--------------------------------------------------------------------------------
//--------------------------------------------------------------------------------
//
//
//
//--------------------------------------------------------------------------------
//renvoi l'extension d'un fichier
$GLOBALS['Twig']->addFunction( new Twig_SimpleFunction('getExtension',
function( $file )
{
    return FoxFWFile::getExtension( $file );
}));

//--------------------------------------------------------------------------------
//--------------------------------------------------------------------------------
//
//
//
//--------------------------------------------------------------------------------
//renvoi le nom d'un fichier via une URL
$GLOBALS['Twig']->addFunction( new Twig_SimpleFunction('getNameFile',
function( $url )
{
	$explode = explode('/',$url );
    return $explode[ count($explode)-1 ];
}));