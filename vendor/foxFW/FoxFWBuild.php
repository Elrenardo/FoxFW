<?php
/*
	::FoxFWBuild::
	V1.00
*/

/*--------
By      : Teysseire Guillaume
Date    : 05/01/2016
Update  : 05/01/2016
Licence : © Copyright
Version : 1.00
-------------------------
*/

class FoxFWBuild
{
	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public static function build( $config_start, $cache_config )
	{
		//Verifier si une compilation de la configuration existe déja
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

		//ajout configuration bundle home
		$file = $config['Define']['_MBUNDLE'].'config.json';
		$config['Bundle']['MasterBundle'] = $config['Define']['_MBUNDLE'];
		if( file_exists( $file ))
		{
			//chargement et fusion de la configuration
			$data   = json_decode( file_get_contents( $file ),true);
			$config = FoxFWKernel::merge_object( $config, $data );	
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
			file_put_contents($cache_config, json_encode( $config ));

		//-------------------------------------------------------
		return $config;
	}
};