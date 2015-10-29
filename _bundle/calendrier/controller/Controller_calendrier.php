<?php
/*--------
By      : Teysseire Guillaume
Date    : 12/03/2015
Update  : 24/09/2015
Licence : © Copyright
Version : 1.0
-------------------------
*/
class Controller_calendrier
{
	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public function __construct() 
    {
    	FoxFWKernel::addModel('Evenement');
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
			'titre'  => 'Calendrier',
			'router' => 'calendrier_listeEvent',
			'panel'  => FoxFWKernel::getView('calendrier_panelAdmin')
		);
		return $ret;
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
    public function index( $params )
	{
		//update année calendrier
		if( isset($_SESSION['calendrier_year']))
			$_SESSION['calendrier_year'] += intval($params['id']);

		FoxFWKernel::loadRouter('index');
	}

    //--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public function viewCalendrier( $params )
	{
		if( !isset($_SESSION['calendrier_year']))
			$_SESSION['calendrier_year']  = date('Y');

		$dates = current(Evenement::getAll( $_SESSION['calendrier_year'] ));

		//liste event
    	$liste_event = Evenement::listeAll( $_SESSION['calendrier_year'] );
    	$event       = Evenement::listeAll( time() );

		return $GLOBALS['Twig']->render( FoxFWKernel::getView('calendrier_calendrier'), 
			array(
			'months'      => Evenement::$months,
			'jours'       => Evenement::$days,
			'years'       => $_SESSION['calendrier_year'],
			'years_time'  => strtotime( $_SESSION['calendrier_year'].'-01-01' ),
			'dates'       => $dates,
			'liste_event' => $liste_event,
			'event'       => $event,
			'tagColor'    => $GLOBALS['Config']['Calendrier']['tag'],
			'moisActuel'  => date('n')
		));
	}

    //--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public function viewListEvenement( $params )
	{
		$event = Evenement::listeAll( time() );
		return $GLOBALS['Twig']->render( FoxFWKernel::getView('calendrier_viewListe'), array(
			'event'=>$event,
			'tagColor'=>$GLOBALS['Config']['Calendrier']['tag']
		));
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public function viewAllListEvenement( $params )
	{
		$event = Evenement::listeAll( 0 );
		return $GLOBALS['Twig']->render( FoxFWKernel::getView('calendrier_viewListe'), array(
			'event'=>$event,
			'tagColor'=>$GLOBALS['Config']['Calendrier']['tag']
		));
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public function viewListeTag( $params )
	{
		$event = Evenement::listeTag( time(), $params['id'] );
		return $GLOBALS['Twig']->render( FoxFWKernel::getView('calendrier_viewListe'), array(
			'event'=>$event,
			'tagColor'=>$GLOBALS['Config']['Calendrier']['tag']
		));
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public function calendrier_view( $params )
	{
		$event = Evenement::getUrl( $params['id'] );
		
		if( !empty( $event ))
			return $GLOBALS['Twig']->render( FoxFWKernel::getView('calendrier_view'), array(
				'event'=>$event,
				'tagColor'=>$GLOBALS['Config']['Calendrier']['tag']
			));
		
		FoxFWKernel::loadRouter('error404');
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public function viewListDate( $params )
	{
		$event = Evenement::liste( $params['id'], 99 );
		return $GLOBALS['Twig']->render( FoxFWKernel::getView('calendrier_viewListe'), array(
			'event'=>$event,
			'tagColor'=>$GLOBALS['Config']['Calendrier']['tag']
		));
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public function addEvenement( $params )
	{
		return $GLOBALS['Twig']->render( FoxFWKernel::getView('calendrier_addEvent'), array(
			'type'=>$GLOBALS['Config']['Calendrier']['tag']
		));
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public function confirmAddEvenement( $params )
	{
		//traitement de l'ajout
		$data = array(
			'date'    => strtotime($_POST['date'])+($_POST['date_heur']*60*60),
			'dateEnd' => strtotime($_POST['dateEnd'])+($_POST['dateEnd_heur']*60*60),
			'titre'   => $_POST['titre'],
			'body'    => htmlspecialchars_decode($_POST['body']),
			'lieu'    => $_POST['lieu'],
			'tag'     => $_POST['tag']
		);

		//Ajout event
		$id = Evenement::add( $data );
		//voir les evenements
		FoxFWKernel::loadRouter('calendrier_view',$id);
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public function removeEvenement( $params )
	{
		Evenement::remove( $params['id'] );
		FoxFWKernel::loadRouter('calendrier_listeEvent');
	}

	 //--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public function editEvenement( $params )
	{
		$event = Evenement::get( $params['id'] );

		$event->dateDay  = date('m/d/Y', $event->date );
		$event->dateHour = date('H', $event->date );

		$event->dateEndDay  = date('m/d/Y', $event->date_end );
		$event->dateEndHour = date('H', $event->date_end );

		return $GLOBALS['Twig']->render( FoxFWKernel::getView('calendrier_addEvent'), 
			array( 
				'data'=>$event, 
				'type'=>$GLOBALS['Config']['Calendrier']['tag']
		));
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public function confirmEditEvenement( $params )
	{
		//traitement de l'ajout
		$data = array(
			'id'      => $_POST['id'],
			'date'    => strtotime($_POST['date'])+($_POST['date_heur']*60*60),
			'dateEnd' => strtotime($_POST['dateEnd'])+($_POST['dateEnd_heur']*60*60),
			'titre'   => $_POST['titre'],
			'body'    => htmlspecialchars_decode($_POST['body']),
			'lieu'    => $_POST['lieu'],
			'tag'     => $_POST['tag']
		);

		//update event
		$id = Evenement::edit( $data );
		//voir les evenements
		FoxFWKernel::loadRouter('calendrier_view',$id);
	}

};