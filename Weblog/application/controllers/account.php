<?php
namespace application\controllers;
use system\Controller;
use system\View;
use system\Session;
use system\helper\Input;
use application\models\User;
use \Exception;

class Account extends Controller {

	// si vrai la fonction peu être appelé by le type de request
    // ex: get_index(), post_index(), put_index() or delete_index()
	public $restful = true;

	public function get_index()
	{
		View::make('account.index', $this->data);
	}

	public function post_index()
	{
		if(isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['email']) && isset($_POST['epassword1']) && isset($_POST['epassword2']))
		{
			if(!Input::inject($_POST['nom']) && !Input::inject($_POST['prenom']) && !Input::inject($_POST['email']) && !Input::inject($_POST['prenom']) && !Input::inject($_POST['epassword1']) && !Input::inject($_POST['epassword2'])  && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
			{		
				$this->login->setNom($_POST['nom']);
				$this->login->setPrenom($_POST['prenom']);
				$this->login->setEmail($_POST['email']);

				$this->login->update(array('email'=>$_POST['email']), array('username'=> $this->login->getPseudo()), 'comment');

				if(!empty($_POST['epassword1']) || !empty($_POST['epassword2']))
				{
					if($_POST['epassword1'] == $_POST['epassword2'])
					{
						$this->login->setMotDePasse($_POST['epassword1']);
						\system\Session::setFlash("<strong>Bravo:</strong> Votre profil a bien été édité.", "success");
						$this->login->sauvegarderLUtilisateur();
					}
					else
						\system\Session::setFlash('<strong>Impossible d\'éditer votre profil</strong> car vos mot de passe ne sont pas iddentiques.', "danger");
				}
				else
				{
					\system\Session::setFlash("<strong>Bravo:</strong> Votre profil a bien été édité.", "success");
					$this->login->sauvegarderLUtilisateur();
				}
			}
			else
				\system\Session::setFlash('<strong>Impossible d\'éditer votre profil.</strong>', "danger");
		}
		// $this->login->setPseudo("Roberts");
		// $this->login->setEmail("robert@roberts.org");
		// $this->login->sauvegarderLUtilisateur();
		View::make('account.index', $this->data);
	}


	public function post_register()
	{
		try {
			if (!isset($_POST["username"]) || !isset($_POST["password"]) || !isset($_POST["password2"]) || !isset($_POST["email"]))
				throw new Exception('EMPTY_POST');

			if(!User::inscription($_POST["username"], $_POST["password"], $_POST["password2"], $_POST["email"]))
				throw new Exception('ERREUR_INSCRIPTION');

			\system\Session::setFlash("<strong>Info:</strong> Merci de votre inscription! Veuillez vous connecter pour continuer", "success");

		}
		catch(Exception $e){
			\system\Session::setFlash('<strong>Erreur:</strong>  '.$e->getMessage(), "danger");
		}

		\system\Router::redirect('blog','action_index');
	}

	public function post_login()
	{
		try {
			if (!isset($_POST["username"]) || !isset($_POST["password"]))
				throw new Exception('EMPTY_POST');

			if(!User::connexion($_POST["username"], $_POST["password"], 'membre'))
				throw new Exception('ERREUR_CONNEXION');

				\system\Session::setFlash("<strong>Info:</strong> Félicitations pour ta connexion.", "success");
				$this->login = new User(Session::get('membre'));
				$this->data['loged'] = true;
				$this->data['member'] = $this->login;

		}
		catch(Exception $e){
			\system\Session::setFlash('<strong>Erreur:</strong> '.$e->getMessage(), "danger");
		}
			
		\system\Router::redirect('blog','action_index');
	}

	public function get_logout()
	{
		User::deconnexion('membre');
		\system\Session::setFlash("<strong>Info:</strong> Déconnexion effectué.");
		\system\Router::redirect('blog','action_index');
	}
}