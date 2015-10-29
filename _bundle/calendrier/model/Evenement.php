<?php
/*--------
By      : Teysseire Guillaume
Date    : 12/03/2015
Update  : 24/09/2015
Licence : © Copyright
Version : 1.0
-------------------------
*/
class Evenement
{
	//Attribue
	public static $days   = array('Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi','Dimanche');
	public static $months = array('Janvier','Fevrier','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre');

	//Methode
	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	//renvoi un tableau avec les jours de l'année au complet
	static public function getAll( $year )
	{
		$r = array();

		$date = strtotime( $year.'-01-01' );

		while( date('Y',$date) <= $year )
		{
			$y = date('Y',$date);
			$m = date('n',$date);
			$d = date('j',$date);
			$w = str_replace('0','7',date('w',$date));

			$r[$y][$m][$d] = $w;

			$date = strtotime( date('Y-m-d',$date).' +1 DAY' );
		}

		return $r;
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	static public function get( $id )
	{
		return R::load( 'evenement', $id );
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	static public function getUrl( $url )
	{
		return R::findOne( 'evenement', 'url=?', [$url] );
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	/*
	date
	titre
	body
	lieu
	tag
	*/
	static public function add( $tab )
	{
		//Recherce URL dispo pour l'évent
		$compte = 0;
        $buffer = FoxFWKernel::URLencode( $tab['titre'] );
        while( !empty(R::find( 'evenement', 'url=?', [ $buffer ])) )
        {
            $compte++;
            $buffer = FoxFWKernel::URLencode( $tab['titre'].'-'.$compte );
        }

        //Création événement
		$event           = R::dispense( 'evenement' );
		$event->url      = $buffer;
		$event->date     = $tab['date'];
		$event->date_end = $tab['dateEnd'];
		$event->titre    = $tab['titre'];
		$event->body     = $tab['body'];
		$event->lieu     = $tab['lieu'];
		$event->tag      = $tab['tag'];

		R::store( $event );
		return $event->url;
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	/*
	id
	date
	titre
	body
	lieu
	tag
	*/
	static public function edit( $tab )
	{
		$event = R::load( 'evenement', $tab['id'] );
		if( $event->id == 0 )
            return;

        if( isset($tab['date']) )
			$event->date = $tab['date'];

		if( isset($tab['dateEnd']) )
			$event->date_end = $tab['dateEnd'];

		if( isset($tab['titre']) )
			$event->titre = $tab['titre'];

		if( isset($tab['body']) )
			$event->body = $tab['body'];

		if( isset($tab['lieu']) )
			$event->lieu = $tab['lieu'];

		if( isset($tab['tag']) )
			$event->tag  = $tab['tag'];

		R::store( $event );
		return $event->url;
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	static public function remove( $id )
	{
        $event = R::load( 'evenement', $id );
        if( $event->id == 0 )
            return false;
        R::trash( $event );
        return true;
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	static public function liste( $time_min , $limit = 10)
	{
		$time_min = intVal( $time_min );
		return R::find( 'evenement', 'date_end >= '.$time_min.' ORDER by date LIMIT 0,'.$limit );
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	static public function listeAll( $time_min )
	{
		return R::find( 'evenement', 'date_end >= ? ORDER by date',[$time_min]);
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	static public function listeTag( $time_min, $tag )
	{
		return R::find( 'evenement', 'date_end >= ? AND tag=? ORDER by date',[$time_min, $tag] );
	}

};