<?php
/*--------
By      : Teysseire Guillaume
Date    : 12/03/2015
Update  : 24/09/2015
Licence : © Copyright
Version : 1.0
-------------------------
*/
define('crypteUSER','fCr854s1d4Fq5d5Qqs84Ksd64');
class Controller_user
{
	public function __construct() 
    {
    }
	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public function login( $params )
	{
		//si message a afficher au login
		$msg = '';
		if( isset( $_GET['msg']) )
			$msg = htmlentities( $_GET['msg']);
		return $GLOBALS['Twig']->render( FoxFWKernel::getView('users_login'), array('msg'=>$msg));
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public function confirmLogin()
	{
		//login
		if( isset( $_POST['email'] ))
		if( isset( $_POST['password'] ))
		if( $GLOBALS['User']->login( $_POST['email'], $_POST['password'] ))
		{
			//garder connexion
			if( isset($_POST['reload']) )
			if( $_POST['reload'])
				$GLOBALS['User']->connectPersiste();

			FoxFWKernel::loadRouter('index');
			return;
		}
		FoxFWKernel::loadRouter('user_login','?msg=Erreur Identifiant');
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public function deconnexion()
	{
		$GLOBALS['User']->deconnexion();
		FoxFWKernel::loadRouter('index');
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public function inscription()
	{
		//si message a afficher au login
		$msg = '';
		if( isset( $_GET['msg']) )
			$msg = htmlentities( $_GET['msg']);

		return $GLOBALS['Twig']->render( FoxFWKernel::getView('users_inscription'), array('msg'=>$msg));
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public function delete( $params )
	{
		if( isset( $params['id'] ))
			FoxFWUsers::delete( $params['id'] );
		FoxFWKernel::loadRouter('user_viewListeUsers');
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public function confirmInscription()
	{
		//si le formulaire blague est remplit !!
		if( isset( $_POST['blaque'] ))
		if( $_POST['blaque'] != '' )
		{
			sleep(30);
			FoxFWKernel::loadRouter('index');
		}

		//Jeton d'inscription si ont vien de s'inscrire
		if( isset( $_SESSION['inscription']))
			return $GLOBALS['Twig']->render( FoxFWKernel::getView('foxfw_error'), array(
			'error'=>'409',
			'message'=>'Securité: Vous venez de vous enregistrez !'));

		//Demande d'inscription
		if( isset( $_POST['email'] ))
		if( isset( $_POST['password'] ))
		if( isset( $_POST['password2'] ))
		{
			if( $_POST['password'] != $_POST['password2'] )
				return $GLOBALS['Twig']->render( FoxFWKernel::getView('users_inscription'), array('msg'=>'Les passwords ne sont pas identiques !'));

			//nouvelle utilisateur
			if( !$GLOBALS['User']->create( $_POST['email'], $_POST['password'] ))
				return $GLOBALS['Twig']->render( FoxFWKernel::getView('users_inscription'), array('msg'=>'Email déjà utilisé !'));
			
			//connexion
			$GLOBALS['User']->login( $_POST['email'], $_POST['password'] );

			//jetons de 1 insciption max par session
			$_SESSION['inscription'] = 1;
		}
		FoxFWKernel::loadRouter('index');
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public function passLost()
	{
		$msg = '';
		if( isset( $_GET['msg']) )
			$msg = htmlentities( $_GET['msg']);
		return $GLOBALS['Twig']->render( FoxFWKernel::getView('users_passlost'), array('msg'=>$msg));
	}
	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public function confirmPassLost()
	{
		if( !isset( $_POST['email'] ))
			FoxFWKernel::loadRouter('index');

		//trouver le compte !
		$user = FoxFWUsers::existe( $_POST['email'] );
		if( $user == NULL )
			return $GLOBALS['Twig']->render( FoxFWKernel::getView('users_passlost'), array('msg'=>'Cette Email n\'existe pas !'));
		

		// On définit le corps du message
   		$code = @md5('P8lit'.$user.'y4Ol');//ligne 171


		//envoi le message de reset du password
		FoxFWKernel::addVendor( 'PHPMailer/class.phpmailer.php' );
		
   		$mail = new PHPMailer();
 		$mail->charSet= "UTF-8";

 		//Emetteur
   		$mail->setFrom( $GLOBALS['Config']->FoxFW->email, 'Mailer');

   		//email HTML
   		$mail->isHTML(true);

   		// Définition du sujet/objet
   		$mail->Subject = "Changement de mot de passe !";

   		//corps du mail
   		$mail->Body = $GLOBALS['Twig']->render( FoxFWKernel::getView('users_pattern_mail_change_mdp'), array('url'=>FoxFWKernel::path( 'user/passlost/'.$code ) ));
 
   		// Il reste encore à ajouter au moins un destinataire
   		// (ou plus, par plusieurs appel à cette méthode)
   		$mail->AddAddress( $_POST['email'], "Utilisateur");
 
 		//Envoyer le message
   		if(!$mail->send())
   		{
		    echo 'Message could not be sent.';
		    echo 'Mailer Error: ' . $mail->ErrorInfo;
		    exit();
		}

   		//jeton secu
   		$_SESSION['CHANGEPASSWORD'] = $user;
		return $GLOBALS['Twig']->render( FoxFWKernel::getView('users_passlost'), array('msg'=>'Email envoyé !'));
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public function changePassLost( $params )
	{
		if( !isset($params["clef"]))
			return;
		//decodage clef
		$clef = $params["clef"];

		//verification de la clef USER
		if( !isset( $_SESSION['CHANGEPASSWORD'] ))
			FoxFWKernel::loadRouter('index');

		//verification si le code est le meme
		if( @md5('P8lit'.$_SESSION['CHANGEPASSWORD'].'y4Ol') == $clef)//ligne 136
		{
			//connexion utilisateur et affichage page change password
			$GLOBALS['User']->loginClef( $_SESSION['CHANGEPASSWORD'] );
			unset( $_SESSION['CHANGEPASSWORD'] );

			return $GLOBALS['Twig']->render( FoxFWKernel::getView('users_newpassword'), array());
		}
		unset( $_SESSION['CHANGEPASSWORD'] );

		//erreur ...
		FoxFWKernel::loadRouter('index');
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public function changePassword()
	{
		if( !$GLOBALS['User']->isLogin() )
			FoxFWKernel::loadRouter('index');

		$msg = '';
		if( isset( $_GET['msg']) )
			$msg = htmlentities( $_GET['msg']);
		return $GLOBALS['Twig']->render( FoxFWKernel::getView('users_newpassword'), array('msg'=>$msg));
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public function confirmChangePassword()
	{
		//si ont est connecte
		if( !$GLOBALS['User']->isLogin() )
			FoxFWKernel::loadRouter('index');

		//changement de mot de passe
		if( isset($_POST['password']))
		if( isset($_POST['passwordR']))
		{
			$pass0 = htmlentities($_POST['password']);
			$pass1 = htmlentities($_POST['passwordR']);
			if( $pass0 == $pass1 )
			{
				$GLOBALS['User']->setPassword( $pass0 );
				return $GLOBALS['Twig']->render( FoxFWKernel::getView('users_newpassword'), array('msg'=>'Mot de passe modifié !'));
			}
		}
		FoxFWKernel::loadRouter('index');
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public function viewListeUsers()
	{
		$users = FoxFWUsers::ListeUsers();
		
		$tab_grade = $GLOBALS['Config']['Roles'];
		foreach ($users as $key )
		{
			$grade = explode( '|', $key['roles'] );
			//suppresion des 2 premier grade commun a tout le monde
			array_shift( $grade );
			array_shift( $grade );
			$key['roles'] = $grade;
		}
		return $GLOBALS['Twig']->render( FoxFWKernel::getView('users_listeUsers'), array('users'=>$users,'roles'=>$tab_grade));
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public function searchListeUsers()
	{
		$users = FoxFWUsers::SearchUsers( $_POST['search'] );
		
		$tab_grade = $GLOBALS['Config']['Roles'];
		foreach ($users as $key )
		{
			$grade = explode( '|', $key['roles'] );
			//suppresion des 2 premier grade commun a tout le monde
			array_shift( $grade );
			array_shift( $grade );
			$key['roles'] = $grade;
		}

		return $GLOBALS['Twig']->render( FoxFWKernel::getView('users_listeUsers'), array('users'=>$users,'roles'=>$tab_grade));
	}

	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public function updateRole()
	{
		//ajout du role
		$user = new FoxFWUsers();
		$user->loginClef( $_POST['clef'] );
		
		if( isset($_POST['add']))
			$user->addRole( $_POST['role'] );
		if( isset($_POST['del']))
			$user->removeRole( $_POST['role'] );

		FoxFWKernel::loadRouter('user_viewListeUsers');
	}


	//--------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------
	//
	//
	//
	//--------------------------------------------------------------------------------
	public function panelUser()
	{
		return $GLOBALS['Twig']->render( FoxFWKernel::getView('user_panel'));
	}
};