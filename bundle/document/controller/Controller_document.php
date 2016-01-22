<?php
/*--------
By      : Teysseire Guillaume
Date    : 12/03/2015
Update  : 04/11/2015
Licence : © Copyright
Version : 1.2
-------------------------
*/
class Controller_document
{
	private $path;

    //--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public function __construct() 
    {
    	if( !isset( $_SESSION['foxfw_document_path'] ))
    		$_SESSION['foxfw_document_path'] = '';

    	FoxFWKernel::addVendor('foxFW/FoxFWUrl.php');
		$this->path = new FoxFWUrl( _HOME, $_SESSION['foxfw_document_path'] );
    }

    //--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public function __destruct()
	{
		$_SESSION['foxfw_document_path'] = $this->path->getPath();
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
			'titre'  => 'Document',
			'router' => 'Document_view',
			'panel'  => ''
		);
		return $ret;
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public function view( $params )
	{

		//si c'est un repertoire
		$rep = true;

		$document = array();

		//si ont ce déplace dans le repertoire
		if( isset($_GET['dir']) )
		{
			//si on demande de revenir en arriére
			if( $_GET['dir'] == '..' )
			{
				$this->path->retrograde();
			}
			else
			{
				//si c'est un dossier
				if( is_dir( $this->path->get() . $_GET['dir'] ))
					$this->path->addDir( $_GET['dir'] );
			}
		}


		//si ont demande un fichier
		if( isset($_GET['file']))
		if( file_exists( $_GET['file'] ))
		{
			$file = $_GET['file'];

			//si modifier un fichier
			if( !isset($_GET['noEdit']))
				$_GET['noEdit'] = false;

			//ce n'est pas un repertoir
			$rep = false;

			//extension fichier
			$extension = FoxFWFile::getExtension( $file );

			//config document
			$document['fichier'] = $file;
			$document['url']     = FoxFWKernel::router('index') . $file;
			$document['type']    = $extension;
			$document['path']    = $file;
			$document['body']    = '';
			$document['edit']    = !$_GET['noEdit'];

			//chargement du body
			switch( $extension )
			{
				case 'txt':
				case 'html':
				case 'js':
				case 'css':
				case 'json':
				case 'tpl':
				case 'php':
					$document['body'] = file_get_contents( $document['path'] );
				break;
			}
		}

		//lister repertoire
		$files = array();
		$dirs  = array();
		if( $dh = opendir( $this->path->get() ))
		{
			while (false !== ($filename = readdir($dh)) )
			{
	    		if( is_dir($this->path->get().$filename))
	    			array_push( $dirs, $filename);
	    		else
	    			array_push( $files, $filename);
    		}
		}
		else
			die('Dossier inconu !');

		//render
		return $GLOBALS['Twig']->render( FoxFWKernel::getView('Document_view') ,
		array(
			'path'     => $this->path->get(),
		 	'file'     => $files,
		 	'dir'      => $dirs,
		 	'rep'      => $rep,
		 	'document' => $document
		));
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public function addDir( $params )
	{
		if(!isset($_GET['name']))
			FoxFWKernel::loadRouter('index');

		$url = $this->path->get().'/'.FoxFWFile::encodeString( $_GET['name'] );
		mkdir( $url, 0777, true );
		FoxFWKernel::loadRouter('Document_view');
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public function removeDir( $params )
	{
		FoxFWFile::delTree( $this->path->get() );
		$this->path->retrograde();
		FoxFWKernel::loadRouter('Document_view');
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public function removeFile( $params )
	{
		if( !isset($_GET['name']) )
			FoxFWKernel::loadRouter('index');

		unlink( $_GET['name'] );
		FoxFWKernel::loadRouter('Document_view');
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public function upload( $params )
	{
		FoxFWFile::uploadFile($this->path->get());
	}


	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public function confirmEditFile( $params )
	{
		$_POST['file'] = htmlspecialchars_decode($_POST['file']);
		$_POST['body'] = htmlspecialchars_decode($_POST['body']);
		
		file_put_contents( $_POST['file'], $_POST['body'] );
		FoxFWKernel::loadRouter('Document_view');
	}
};