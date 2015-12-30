<?php
/*--------
By      : Teysseire Guillaume
Date    : 12/03/2015
Update  : 24/09/2015
Licence : © Copyright
Version : 1.0
-------------------------
*/
class Controller_page
{
	private $page;
	//--------------------------------------------------------------------------------

	public function __construct()
    {
    	//FoxFWKernel::addVendor('foxFW/FoxFWPage.php');
    	FoxFWKernel::addModel('Page');
    	$this->page = new Page();

    	if( !is_dir( _WEB.'/page' ))
    		mkdir( _WEB.'/page', 0755, true);
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
			'titre'  => 'Pages & Articles',
			'router' => 'Page_viewListeAllPage',
			'panel'  => FoxFWKernel::getView('pages_panelAdmin')
		);
		return $ret;
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public function viewAddPage( $params )
	{
		//affichage
		return $GLOBALS['Twig']->render( FoxFWKernel::getView('pages_addPage'));
	}


	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public function confirmAddPage( $params )
	{
		//traitement de l'ajout
		$data = array(
			'titre' => $_POST['titre'],
			'tag'   => $_POST['tag'],
			'auteur'=> $_POST['auteur'],
			'path'  => htmlspecialchars_decode($_POST['path']),
			'body'  => htmlspecialchars_decode($_POST['body']),
			'type'  => $_POST['type'],
			'twig'  => htmlspecialchars_decode($_POST['twig'])
		);

		//ajout de la page
		$id_url = $this->page->add( $data );

		//Ajout des documents de upload_files

		FoxFWKernel::addController('Upload_files');
		Upload_files::deplacer( _WEB.'page/'.$id_url );

		//envoyer a la page
		FoxFWKernel::loadRouter('Page_viewPage',$id_url );
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public function viewUpdatePage( $params )
	{
		$id   = $params['id'];
		$data = $this->page->get( $id );

		if( $data == NULL )
			FoxFWKernel::loadRouter('error404');

		return $GLOBALS['Twig']->render( FoxFWKernel::getView('pages_addPage'), array('data'=>$data));
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public function confirmEditPage( $params )
	{
		$data = array(
			'titre' => $_POST['titre'],
			'tag'   => $_POST['tag'],
			'path'  => htmlspecialchars_decode($_POST['path']),
			'body'  => htmlspecialchars_decode($_POST['body']),
			'type'  => $_POST['type'],
			'twig'  => htmlspecialchars_decode($_POST['twig'])
		);

		$id_url = $this->page->update( $_POST['id'], $data );

		//Ajout des documents de upload_files
		FoxFWKernel::addController('Upload_files');
		Upload_files::deplacer( _WEB.'page/'.$id_url );

		//router vers page
		FoxFWKernel::loadRouter('Page_viewPage',$id_url );
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public function removepage( $params )
	{
		//supprimer page
		$id_url = $this->page->remove( $params['id'] );

		//supprimer fichier image attacher
		FoxFWFile::delTree( _WEB.'page/'.$id_url );

		//routage sur la liste des pages
		FoxFWKernel::loadRouter('Page_viewListeAllPage');
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public function searchPage( $params )
	{
		$search = '';
		if( isset($_POST['search']))
			$search = $_POST['search'];

		if( isset($params['id']))
			$search = $params['id'];

		if( empty($search))
			FoxFWKernel::loadrouter('index');
		
		$liste = $this->page->search( $search );
		return $GLOBALS['Twig']->render( FoxFWKernel::getView('pages_listePageGraphique'), array('titre'=>'Recherche de "'.$search.'"','liste'=>$liste));
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public function searchAdminPage( $params )
	{
		$search = '';
		if( isset($_POST['search']))
			$search = $_POST['search'];

		if( isset($params['id']))
			$search = $params['id'];

		if( empty($search))
			FoxFWKernel::loadrouter('index');
		
		$liste = $this->page->search( $search );
		return $GLOBALS['Twig']->render( FoxFWKernel::getView('pages_listePage'), array('titre'=>'Recherche de "'.$search.'"','liste'=>$liste));
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public function viewPage( $params )
	{
		$id     = $params['id'];
		$data   = $this->page->getByUrl( $id );
		if( $data == NULL )
			FoxFWKernel::loadRouter('error404');

		//renvoyé les images attaché a cette page
		FoxFWKernel::addController('Upload_files');
		$files = Upload_files::getFilesDir( _WEB.'page/'.$id.'/' );

		//rendu
		return $GLOBALS['Twig']->render( $data['twig'], array(
			'page'=>$data,
			'id_page'=>$data->id,
			'files' =>$files ));
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public function viewListePage( $params )
	{
		if( isset( $params['id'] ))
			$data = $this->page->liste( array('order_by'=>'titre', 'type'=>$params['id'] ) );
		else
			$data = $this->page->liste( array('order_by'=>'titre' ) );

		return $GLOBALS['Twig']->render( FoxFWKernel::getView('pages_listePage'), array('liste'=>$data));
	}
};