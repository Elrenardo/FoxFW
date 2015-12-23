<?php
/*
	GESTION DES UTILISATEURS
	V2.1

	//Require:
	require_once _VENDOR.'/foxFW/crypte.php';
*/
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
/*
create( $email, $password, $role = '', $active = true );
login( $email, $password );
/!\ loginClef( $clef );
deconnexion();

isRole( $role );
addRole( $role );
removeRole( $role );
isLogin();
connectPersiste();
delete( id );

setPassword( $password );
getEmail();
setEmail( $email );
getEtat();
setEtat( $etat );
getInfo();
getClef();
getId();

/!\ Users::existe( $email ); //renvoi la clef de l'utilisateur !!

FoxFWUsers::ListeUsers();
FoxFWUsers::SearchUsers( $search );
*/
//--------------------------------------------------------------------------------
//--------------------------------------------------------------------------------
//
//
//
//--------------------------------------------------------------------------------

define( 'clef_cookie', 'zX8dzRefdqV8qd4qHP6');
//Class principale ORM Users
class FoxFWUsers
{
	private $orm;
	private $update;
	private $change;

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public function __construct()
	{
		$this->change = false;
		$this->update = false;

		$clef = NULL;
		if( isset($_SESSION['FoxFWUsersCo'] ))
			$clef = $_SESSION['FoxFWUsersCo'];
		else
		if( isset( $_COOKIE['FoxFWUser']) )
			$clef = FoxFWCrypte::decrypte( htmlspecialchars($_COOKIE['FoxFWUser']), clef_cookie );

		//connexion par clef
		if( $clef != NULL)
		if( $this->loginClef( $clef ))
			return;

		//creation object UsersORM
		$this->build();
		$this->updateConnect();
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	public function __destruct()
	{
        //sauvegarde memory
        if( $this->update )
        if( $this->change )
        	R::store( $this->orm );
    }

    //--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	private function build( $email = '', $password = '')
	{
		//creation object UsersORM
		$this->orm             = R::dispense( 'foxfwusers' );

		$this->orm->clef       = FoxFWCrypte::randomString( 20 );
	
		$this->orm->password   = FoxFWCrypte::crypte( $password, $this->orm->clef );
		$this->orm->email      = $email;
		$this->orm->roles      = 'ANONYME';
		$this->orm->etat       = true;
	
		$this->orm->info_co    = 'Undefined';
	}

    //--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
    //création users
    public function create( $email, $password, $role = '', $active = true )
    {
    	$email    = htmlspecialchars( $email );
    	$password = htmlspecialchars( $password );
    	$role     = htmlspecialchars( $role );

    	if( FoxFWUsers::existe( $email ) != NULL )
    		return false;

		$this->change = true;
		$this->update = true;
		$this->build( $email, $password );
		$this->updateConnect();
		$this->addRole('MEMBRE');

		//cookie connexion persiste
		if( $active )
			$this->connectPersiste();

		//Ajout role
		if( $role != '' )
			$this->addRole( $role );
		return true;
    }

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	//test si la connexion est ok, renvoie true !
	public function login( $email, $password )
	{
		$email    = htmlspecialchars( $email );
		$password = htmlspecialchars( $password );

		$user = R::findOne( 'foxfwusers', 'email=? AND etat>0', [ $email ] );

		if( $user == NULL )
			return false;

		if( $password != FoxFWCrypte::decrypte( $user->password, $user->clef ))
			return false;

		$_SESSION['FoxFWUsersCo'] = $user->clef;

		$this->orm    = $user;
		$this->update = true;
		$this->updateConnect();
		return true;
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public function loginClef( $clef )
	{
		$user = FoxFWUsers::getUserClef( $clef );
		if( $user != NULL )
		{
			$this->orm = $user;
			$this->update = true;
			$this->updateConnect();
			return true;
		}
		return false;
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public function deconnexion()
	{
		if( !$this->update )
			return;
		setcookie( 'FoxFWUser' , '', time()-1,'/');
		unset( $_SESSION['FoxFWUsersCo'] );
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	//roles disponible ( return true ok )
	public function isRole( $role )
	{
		$role = htmlspecialchars( $role );
		$p = explode('|',$this->orm->roles );
		foreach ($p as $key => $value)
			if( $value == $role )
				return true;
		return false;
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	//ajouter un role
	public function addRole( $role )
	{
		//si le role existe déja ?
		if( strstr( $this->orm->roles, $role))
			return;

		$this->change = true;
		$role = htmlspecialchars( $role );
		$this->orm->roles .= '|'.$role;
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	//ajouter un role
	public function removeRole( $role )
	{
		$this->change = true;
		$role = htmlspecialchars( $role );

		//suppression du role en trop
		$r = explode('|', $this->orm->roles );
		$l = array();
		for( $i=0; $i<count($r); $i++ )
		if( $r[$i] != $role )
			array_push( $l, $r[$i] );

		$this->orm->roles = implode('|', $l );
	}


	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	//si on est connecte
	public function isLogin()
	{
		if( $this->update )
			return true;
		return false;
	}


	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	private function updateConnect()
	{
		if( $this->update )
		if( !isset($_SESSION['FoxFWUsersCo']))
		{
			$this->change = true;
			$_SESSION['FoxFWUsersCo'] = $this->orm->clef;
		}
		$this->orm->info_co = $_SERVER["REMOTE_ADDR"].' le '.date("Y-m-d H:i:s").' avec '.$_SERVER["HTTP_USER_AGENT"];
	}


	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public function connectPersiste()
	{
		if( !$this->update )
			return;
		$expire = time()+(365*24*3600);
		$clef   = FoxFWCrypte::crypte($this->orm->clef, clef_cookie);
		setcookie( 'FoxFWUser' , $clef, $expire, '/' );
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	static public function delete( $id )
	{
		$id = htmlspecialchars( $id );
		return R::exec('DELETE FROM foxfwusers WHERE id=?',[$id]);
	}


	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public static function ListeUsers()
	{
		return R::find( 'foxfwusers', 'ORDER by email DESC' );
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public static function SearchUsers( $search )
	{
		return R::find( 'foxfwusers',  'email LIKE ? ORDER by roles DESC', [ '%'.$search.'%' ] );
	}




	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	//----- ASCENSEUR ----
	public function setPassword( $password )
	{
		$this->change = true;
		$password = htmlspecialchars( $password );
		$this->orm->password = FoxFWCrypte::crypte( $password, $this->orm->clef );
	}
	public function getEmail()
	{
		return $this->orm->email;
	}
	public function setEmail( $email )
	{
		$this->change = true;
		$email = htmlspecialchars( $email );
		$this->orm->email = $email;
	}
	public function getEtat()
	{
		return $this->orm->etat;
	}
	public function setEtat( $etat )
	{
		$etat = htmlspecialchars( $etat );
		$this->orm->etat = $etat;
	}
	public function getInfo()
	{
		return $this->orm->info_co;
	}
	public function getClef()
	{
		return $this->orm->clef;
	}
	public static function existe( $email )
	{
		$i = R::findOne( 'foxfwusers', 'email=?', [ $email ] );
		if( $i == NULL )
			return NULL;
		return $i->clef;
	}
	private static function getUserClef( $clef )
	{
		return R::findOne( 'foxfwusers', 'clef=? AND etat>0', [ $clef ] );
	}
	public function getId()
	{
		return $this->orm->id;
	}
};