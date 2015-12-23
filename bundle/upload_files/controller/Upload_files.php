<?php
/*--------
By      : Teysseire Guillaume
Date    : 12/03/2015
Update  : 02/11/2015
Licence : © Copyright
Version : 1.1
-------------------------
*/
/*
::Gestion et mise en buffer de document::
- require: FoxFWUser, Twig, FoxFWFile

TWIG FUNCTION
Upload_files::view()

METHOD NORMAL
Upload_files::add()
Upload_files::deplacer( $new_rep )
Upload_files::removeFileBuffer( $params )
Upload_files::getFilesDir( $path )
Upload_files::getUrlBuffer()


*/
class Upload_files
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
	//Affiche le systéme d'upload 
	public static function view()
	{
		$path = Upload_files::getUrlBuffer();

		//lister repertoire
		$files = Upload_files::getFilesDir( $path );

		//affichage
		return $GLOBALS['Twig']->render( FoxFWKernel::getView('upload_files_view'),array('upload_buffer'=>$files));
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	//Affiche le systéme d'upload 
	public static function viewEdit( $path_dir )
	{
		$path = Upload_files::getUrlBuffer();

		//verifier si le repertoire existe sinon ont le creer
		if( !is_dir( $path ) )
			mkdir( $path, 0755, true);

		//lister repertoire
		$files = Upload_files::getFilesDir( $path );
		$dir   = Upload_files::getFilesDir( $path_dir );

		//affichage
		return $GLOBALS['Twig']->render( FoxFWKernel::getView('upload_files_view'),array(
			'upload_buffer'=>$files,
			'path_dir'=> $dir ));
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	//Fonction a appelé pour uploadé de nouveaux fichier
	public static function add( $params )
	{
		$path = Upload_files::getUrlBuffer();
		
		if( !is_dir( $path ))
			mkdir( $path, 0755, true );

		FoxFWFile::uploadFile( $path );
		return '';
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	//deplace les fichier en attante dans leurs nouveaux repertoire
	public static function deplacer( $new_rep )
	{
		//verifier si le repertoire de destination existe
		if( !is_dir( $new_rep ) )
			mkdir( $new_rep, 0755, true );

		//deplacer fichier
		$path = Upload_files::getUrlBuffer();
		$files  = Upload_files::getFilesDir( $path );
		foreach ($files as $key => $value)
		{
			//deplacer fichier avec rename( old, new )
			$i = $new_rep.'/'.$key;
			rename( $value , $i );
			chmod( $i, 0755 );
		}
		return '';
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	//deplace les fichier en attante dans leurs nouveaux repertoire
	public static function removeFileBuffer( $params )
	{
		$path = Upload_files::getUrlBuffer().urldecode($params['id']);
		unlink( $path );
		return '';
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	//deplace les fichier en attante dans leurs nouveaux repertoire
	public static function removeFile( $params )
	{
		unlink( urldecode($params['id']) );
		return '';
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	/* renvoi la liste des fichiers dans un repertoire*/
	public static function getFilesDir( $path )
	{
		//lister repertoire
		$files = array();
		if( is_dir( $path ))
		if( $dh = opendir( $path ))
		{
			while (false !== ($filename = readdir($dh)) )
			{
	    		if( !is_dir($path.$filename))
	    		{
	    			$files[ $filename] = $path.$filename;
	    		}
    		}
		}
		else
			return array();

		return $files;
	}


	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public static function getUrlBuffer()
	{
		return _WEB.$GLOBALS['Config']['Upload_files']['path_buffer'].$GLOBALS['User']->getId().'/';
	}
};