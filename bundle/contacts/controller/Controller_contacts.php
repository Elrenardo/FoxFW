<?php
/*--------
By      : Teysseire Guillaume
Date    : 17/02/2016
Update  : 17/02/2016
Licence : © Copyright
Version : 1.0
-------------------------
*/
class Controller_contacts
{
	//--------------------------------------------------------------------------------

	public function __construct()
    {
    	FoxFWKernel::addVendor('foxFW/FoxFWbdd.php');
    }

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public function view()
	{
		//$list = FoxFWbdd::bdd('contacts','getAll');
		$list = [];
		$list_groupe = FoxFWbdd::bdd('contacts','getListValTable',array('table'=>'groupe'));
		if( !isset($list_groupe['groupe']))
			$list_groupe['groupe'] = [];

		return $GLOBALS['Twig']->render( FoxFWKernel::getView('contacts_liste'), 
			array(
				'list'  => $list,
				'groupe'=> $list_groupe['groupe']
			));
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public function add()
	{
		$list_groupe = FoxFWbdd::bdd('contacts','getListValTable',array('table'=>'groupe'));
		if( !isset($list_groupe['groupe']))
			$list_groupe['groupe'] = [];
		return $GLOBALS['Twig']->render( FoxFWKernel::getView('contacts_add'), array('groupe'=> $list_groupe['groupe']));
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public function confirmAdd()
	{
		//préparation de la structure
		$tab = array();
		$tab['nom']         = $_POST['nom'];
		$tab['prenom']      = $_POST['prenom'];
		$tab['email']       = $_POST['email'];
		$tab['telfixe']     = $_POST['telfixe'];
		$tab['telportable'] = $_POST['telportable'];
		$tab['fax']         = $_POST['fax'];
		$tab['structure']   = $_POST['structure'];
		$tab['intitule']    = $_POST['intitule'];
		$tab['groupe']      = $_POST['groupe'];
		$tab['commentaire'] = $_POST['commentaire'];

		//Ajouter
		FoxFWbdd::bdd('contacts','add',$tab );
		//Redirection vers la page d'accueil des contacts
		FoxFWKernel::loadRouter('contacts_view');
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public function delete( $params )
	{
		//préparation de la structure
		$tab = array();
		$tab['id'] = $params['id'];

		//Ajouter
		FoxFWbdd::bdd('contacts', 'del', $tab );
		//Redirection vers la page d'accueil des contacts
		FoxFWKernel::loadRouter('contacts_view');
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public function edit( $params )
	{
		//préparation de la structure
		$contact = FoxFWbdd::bdd('contacts','get',array('id'=>$params['id']));

		$list_groupe = FoxFWbdd::bdd('contacts','getListValTable',array('table'=>'groupe'));
		if( !isset($list_groupe['groupe']))
			$list_groupe['groupe'] = [];
		
		return $GLOBALS['Twig']->render( FoxFWKernel::getView('contacts_add'), array(
			'groupe'=> $list_groupe['groupe'],
			'data' => $contact
		));
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public function confirmEdit()
	{
		//préparation de la structure
		$tab = array();
		$tab['id']          = $_POST['id'];
		$tab['nom']         = $_POST['nom'];
		$tab['prenom']      = $_POST['prenom'];
		$tab['email']       = $_POST['email'];
		$tab['telfixe']     = $_POST['telfixe'];
		$tab['telportable'] = $_POST['telportable'];
		$tab['fax']         = $_POST['fax'];
		$tab['structure']   = $_POST['structure'];
		$tab['intitule']    = $_POST['intitule'];
		$tab['groupe']      = $_POST['groupe'];
		$tab['commentaire'] = $_POST['commentaire'];

		//Ajouter
		FoxFWbdd::bdd('contacts','upgrade',$tab );
		//Redirection vers la page d'accueil des contacts
		FoxFWKernel::loadRouter('contacts_view');
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public function search()
	{
		$groupe = '';
		if( isset($_POST['groupe']))
			$groupe = 'AND groupe=\''.$_POST['groupe'].'\'';

		$search = $_POST['search'];
		//préparation de la structure
		$list = FoxFWbdd::sql('SELECT * FROM contacts WHERE
		(( nom LIKE ?) OR ( prenom LIKE ?) OR ( telfixe LIKE ?) OR ( telportable LIKE ?) OR ( structure LIKE ?) OR ( email LIKE ?)) '.$groupe,
		[
			$search.'%',
			$search.'%',
			$search.'%',
			$search.'%',
			$search.'%',
			$search.'%'
		]);
		
		$list_groupe = FoxFWbdd::bdd('contacts','getListValTable',array('table'=>'groupe'));
		if( !isset($list_groupe['groupe']))
			$list_groupe['groupe'] = [];
		return $GLOBALS['Twig']->render( FoxFWKernel::getView('contacts_liste'), 
			array(
				'list'  => $list,
				'groupe'=> $list_groupe['groupe']
			));
	}

};