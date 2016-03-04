<?php
/*--------
By      : Teysseire Guillaume
Date    : 17/02/2016
Update  : 17/02/2016
Licence : © Copyright
Version : 1.0
-------------------------
Utilisation

1) verifier les tables d'entrer
FoxFWbdd::verifTab( $tab, $array_verif );

2) effectuer la request
FoxFWbdd::bdd( $bdd, $method, $params );
Method => params:
 add            => id, ...
 del            => id
 upgrade        => id, ...
 get            => id
 getAll         => table
 getAllLimit    => table, min, max
getListValTable => table


Autres:
FoxFWbdd::sql( $req, $tab );
FoxFWbdd::echoJson( $tab );
FoxFWbdd::convertRBtoObj( $obj );
*/
class FoxFWbdd
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
	//$tab = {} 
	//$array_verif = []
	//--------------------------------------------------------------------------------
    static public function verifTab( $tab, $array_verif )
    {
    	foreach ($tab as $key => $value)
    	{
    		if( !in_array($key, $array_verif))
    			return false;
    	}
    	return true;
    }

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	static public function bdd( $bdd, $method, $params = NULL )
	{
		switch( $method )
		{
			//--------------------------------------------------------
			case 'add':
				//traitement
				$elem = R::dispense( $bdd );
				foreach( $params as $key => $value )
				{
					$elem->{$key} = $value;
				}
				//default valeur pour les ajouts
				$elem->time_create = time();
				$elem->update      = time();
				R::store( $elem );
				return true;
			break;

			//--------------------------------------------------------
			case 'del':
				if( isset($params['id']))
				{
					$obj = R::findOne( $bdd, 'id=?', [ $params['id'] ]);
					R::trash( $obj );
					return true;
				}
			break;

			//--------------------------------------------------------
			case 'upgrade':
				if( isset($params['id']))
				{
					$elem = R::load( $bdd, $params['id'] );
					foreach( $params as $key => $value )
					{
						$elem->{$key} = $value;
					}
					$elem->update = time();
					R::store( $elem );
					return true;
				}
			break;

			//--------------------------------------------------------
			case 'get':
				if( isset($params['id']))
				{
					return FoxFWbdd::convertRBtoObj( R::load( $bdd, $params['id'] ));
				}
			break;

			//--------------------------------------------------------
			case 'getAll':
				if( !isset($params['table']))
					$params['table'] = '*';

				return R::getAll('SELECT '.$params['table'].' FROM '.$bdd );
			break;

			//--------------------------------------------------------
			case 'getAllLimit':
				if( isset($params['min']))
				if( isset($params['max']))
				{
					if( !isset($params['table']))
						$params['table'] = '*';

					return R::getAll('SELECT '.$params['table'].' FROM '.$bdd.' LIMIT ?,?', [ $params['min'], $params['max'] ]);
				}
			break;

			//--------------------------------------------------------
			case 'getListValTable':
				if( !isset($params['table']))
					$params['table'] = '*';

				$ret = [];
				$rep = R::getAll('SELECT '.$params['table'].' FROM '.$bdd );
				foreach ($rep as $key => $value)
				{
					foreach ( $value as $key2 => $value2)
					{
						if( !isset($ret[ $key2 ]))
							$ret[ $key2 ] = array();

						if( $value2 != '')
						if( array_search( $value2, $ret[ $key2 ]) === false)
							array_push( $ret[ $key2 ], $value2 );
					}
				}
				return $ret;
			break;

			//--------------------------------------------------------
			case 'search':
				$prep = 'SELECT * FROM '.$bdd.' WHERE ';
				
				$search = $params['search'];
				$params['search'] = NULL;
				
				$tab = array();
				$compte = 0;
				foreach ($params as $key => $value)
				{
					if( $compte != 0 )
						$prep .= ' OR ';
					$compte++;
					$prep .= '( '.$key.' LIKE ?)';
					array_push( $tab, $search.'%' );
				}

				return R::getAll( $prep, $tab );
			break;
		}
		return false;
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//$tab_champ = {'name':{'after':'%','before':'%'}, ... }
	//$tab_select = 'name,id,test, ... '
	//--------------------------------------------------------------------------------
	/*public function search( $bdd, $tab_champ, $select )
	{
		$req = 'SELECT '.$select.' FROM '.$bdd.' WHERE ';
		
		foreach ($tab_champ as $key => $value)
		{
			$req .= '('.$key.' LIKE ?)';
			//TODO
		}
		//TODO
	}*/

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	static public function sql( $req, $tab )
	{
		return R::getAll( $req, $tab );
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	static public function echoJson( $tab )
	{
		header('Content-Type: application/json');
		return json_encode($tab);
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//convertit les objets type Redbean en objet simple
	//--------------------------------------------------------------------------------
	static public function convertRBtoObj( $obj )
	{
		$tab = [];
		foreach($obj as $key => $value)
		{
			$tab[ $key ] = $value;
		}
		return $tab;
	}

};