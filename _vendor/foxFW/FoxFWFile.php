<?php
/*--------
By      : Teysseire Guillaume
Date    : 12/03/2015
Update  : 01/12/2015
Licence : © Copyright
Version : 1.1
-------------------------
*/
class FoxFWFile
{
	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	//Gestion JSON
	public static function readJson( $file )
	{
		$json = file_get_contents( $file );
        return (array)json_decode($json);
	}

	public static function writeJson( $file, $data, $add = true )
	{
		if( $add )
			return file_put_contents( $file, json_encode($data), FILE_APPEND );
		else
			return file_put_contents( $file, json_encode($data) );
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	//Gestion Storage json avec compression
	public static function store($file, $datas )
	{
		return file_put_contents($file,gzdeflate(json_encode($datas)));
	}
    
    public static function unstore( $file )
    {
    	return (array)json_decode(gzinflate(file_get_contents($file)),true);
    }

    //--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	/* erreur code : >0: upload, -1: trop gros, -2:erreur extension */
	public static function uploadFile( $destination, $max_size = NULL, $tab_ext = NULL )
	{
		$ret = array();
		$error = false;

		//verifier les erreurs du fichier
		foreach ($_FILES as $file_name )
		if (!$file_name['error'])
		{
			$error = false;

			//verifier taille du fichier
			if( isset( $max_size ))
			if ( $file_name['size'] > $max_size)
			{
				array_push ( $ret, -1 );
				$error = true;
			}

			//verifier extension
			if( isset( $tab_ext ))
			{
				$extension_upload = strtolower( substr( strrchr( $file_name['name'], '.') ,1) );
				if ( !in_array($extension_upload,$extensions_valides) ) 
				{
					array_push ( $ret, -2 );
					$error = true;
				}
			}

			//si pas d'erreur on continu
			if( !$error )
			{
				//transfert fichier
				$nom = $destination.FoxFWFile::encodeString( $file_name['name'] );

				//transfert du fichier a ca bonne destination
				move_uploaded_file( $file_name['tmp_name'], $nom );
				//ajout nom du fichier
				array_push( $ret, $nom );
			}
		}
		return $ret;
	}

    //--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public static function encodeString($str, $charset='utf-8')
	{
	     $string = strtolower(htmlentities($sString, ENT_NOQUOTES, $charset ));
	     $string = preg_replace("/&(.)(uml);/", "$1e", $string);
	     $string = preg_replace("/&(.)(acute|cedil|circ|ring|tilde|uml);/", "$1", $string);
	     $string = preg_replace("/([^a-z0-9]+)/", "-", html_entity_decode($string));
	     $string = trim($string, "-");
	     return $string;
	}

    //--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public static function delTree( $dir, $racine = true )
	{
	    $files = array_diff(scandir($dir), array('.','..'));
	    foreach ($files as $file)
	    {
	      (is_dir("$dir/$file")) ? FoxFWFile::delTree("$dir/$file") : unlink("$dir/$file");
	    }
	    if( $racine ) 
	    	return rmdir($dir);
	    return NULL;
  	}

    //--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
  	public static function getExtension( $file )
  	{
  		$extension = strrchr($file,'.');//trouve le . du fichier
		return substr($extension,1);//enleve le .
  	}

  	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public static function sizeFile( $file )
	{
		$taille = filesize( $file );

		if ($taille >= 1073741824)
			$taille = (round($taille / 1073741824 * 100) / 100)." Go";
		elseif ($taille >= 1048576)
			$taille = (round($taille / 1048576 * 100) / 100)." Mo";
		elseif ($taille >= 1024)
			$taille = (round($taille / 1024 * 100) / 100)." Ko";
		else
			$taille = $taille . " o";
		
		if($taille==0)
			$taille="-";

		return $taille; 
	}
};