<?php
namespace application\controllers;
use system\Controller;
use system\View;
use system\Session;
use system\helper\Input;
use system\helper\Pagination;
use application\models\Contact;
use application\models\User;
use application\models\Billet;
use \Exception;

class Admin extends Controller {

	// si vrai la fonction peu être appelé by le type de request
    // ex: get_index(), post_index(), put_index() or delete_index()
	public $restful = true;

	public function __construct()
	{
		parent::__construct();
		if(User::isLoged())
		{
			if($this->login->getAdmin() == 0)
			{
				header('HTTP/1.1 401 Unauthorized');
				header('Location: '.$this->data['base_url'].'error/401');
				\system\Session::setFlash('<strong>Vous ne pouvez pas accéder a cette page.</strong>', "danger");
				exit;
			}
		}
		else
		{
			header('HTTP/1.1 401 Unauthorized');
			header('Location: '.$this->data['base_url'].'error/401');
			\system\Session::setFlash('<strong>Vous ne pouvez pas accéder a cette page.</strong>', "danger");
			exit;
		}
	}

	public function get_messages()
	{
		$allContact = new Contact();
		$this->data['allContact'] = $allContact->find(array('limit' => 6, 'order' => "id_contact DESC"));
		View::make('admin.messages', $this->data);
	}

	public function post_messages()
	{
		$allContact = new Contact();
		if (isset($_POST['action']) && $_POST['action'] == 'delete')
		{
			if(!isset($_POST['id_contact']))
			{
				\system\Session::setFlash('<strong>Impossible de supprimer le message.</strong><br>Vous ne devez pas modifier le forumulaire.', "danger");
				die("false");
			}

			if($this->login->getAdmin() > 0)
			{
				$allContact->delete(array('id_contact'=> $_POST['id_contact']));
				die("true");
			}
		}
		die("false");
	}

	public function get_users($arg)
	{

		$page = (isset($arg[0]) && isset($arg[1]) && ($arg[0] == 'page') && intval($arg[1])) ? $arg[1] : 0;

		$allUser = new User();

		$pager = new Pagination();
		$pager->num_results = $allUser->count();
		$pager->limit = $this->data['nbr_ligne_pagination'];
		$pager->page = $page;
		$pager->menu_link = $this->data['base_url'];
		$pager->menu_link_suffix = 'admin/users';
		$pager->css_class = 'pagination';
		$pager->run();

		$this->data['pagination'] = $pager;
		$this->data['allMembre'] = $allUser->find(array('limit' => "$pager->offset, $pager->limit", 'order' => "id_user DESC"));

		View::make('admin.users', $this->data);
	}

	public function get_articles($arg)
	{
		$page = (isset($arg[0]) && isset($arg[1]) && ($arg[0] == 'page') && intval($arg[1])) ? $arg[1] : 0;

		$allBillet = new Billet();

		$pager = new Pagination();
		$pager->num_results = $allBillet->count();
		$pager->limit = $this->data['nbr_ligne_pagination'];
		$pager->page = $page;
		$pager->menu_link = $this->data['base_url'];
		$pager->menu_link_suffix = 'admin/articles';
		$pager->css_class = 'pagination';
		$pager->run();

		$this->data['pagination'] = $pager;
		$this->data['allBillet'] = $allBillet->find(array('limit' => "$pager->offset, $pager->limit", 'order' => "id_billet DESC"));

		View::make('admin.articles', $this->data);
	}

	public function post_add_articles($arg)
	{
		if(isset($_POST['action']))
		{
			if ($_POST['action'] == 'add')
			{
				$allBillet = new Billet();

				$categorie = "";
				if(isset($_POST['art']))
					$categorie .= "{$_POST['art']},";
				if(isset($_POST['voyages']))
					$categorie .= "{$_POST['voyages']},";
				if(isset($_POST['animaux']))
					$categorie .= "{$_POST['animaux']},";
				if(isset($_POST['nature']))
					$categorie .= "{$_POST['nature']},";
				if(isset($_POST['nourriture']))
					$categorie .= "{$_POST['nourriture']},";
				if(isset($_POST['dev']))
					$categorie .= "{$_POST['dev']},";


				$save = $allBillet->insert(array('title'=> $_POST['title'], 'chapo'=> $_POST['chapo'], 'image'=> $_POST['image'], 'created'=> date('Y-m-d H:i:s'), 'content'=>$_POST['content'], 'categorie'=> trim($categorie, ","), 'id_user'=> $this->login->getID(), 'login'=> $this->login->getPseudo()));
				if($save)
					\system\Session::setFlash("<strong>Bravo:</strong> Votre billet a bien été posté.", "success");
				else
				{
					\system\Session::setFlash('<strong>Impossible de poster votre billet.', "danger");
				}
			}
		}
		$this->get_articles($arg);
	}

	public function post_delete_articles($arg)
	{
		if(isset($_POST['action']))
		{
			if ($_POST['action'] == 'delete')
			{
				if(!isset($_POST['id_billet']))
				{
					\system\Session::setFlash('<strong>Impossible de supprimer votre billet.</strong><br>Vous ne devez pas modifier le forumulaire.', "danger");
					die("false");
				}
				else
				{
					$allBillet = new Billet();
					$allBillet->delete(array('id_billet'=> $_POST['id_billet']));
					$allBillet->delete(array('ref_id'=> $_POST['id_billet']), 'comment');
					die("true");
				}
			}
		}
	}

	public function post_articles($arg)
	{
		if(isset($_POST['action']))
		{
			if ($_POST['action'] == 'edit')
			{
				if(!isset($_POST['id_billet']))
				{
					\system\Session::setFlash('<strong>Impossible de récupérer votre billet.</strong><br>Vous ne devez pas modifier le forumulaire.', "danger");
					die("false");
				}
				else
				{
					$allBillet = new Billet();
					$retour = $allBillet->findFirst(array('conditions'=> array('id_billet'=> $_POST['id_billet'])));
					die(json_encode($retour));
				}
			}
		}
	}

	public function post_update_articles($arg)
	{
		if(isset($_POST['action']))
		{
			if ($_POST['action'] == 'edit')
			{
				if(!isset($_POST['id_billet']))
				{
					\system\Session::setFlash('<strong>Impossible de récupérer votre billet.</strong><br>Vous ne devez pas modifier le forumulaire.', "danger");
					$this->get_articles($arg);
				}
				else
				{
					$allBillet = new Billet();
					$categorie = "";
					if(isset($_POST['art']))
						$categorie .= "{$_POST['art']},";
					if(isset($_POST['voyages']))
						$categorie .= "{$_POST['voyages']},";
					if(isset($_POST['animaux']))
						$categorie .= "{$_POST['animaux']},";
					if(isset($_POST['nature']))
						$categorie .= "{$_POST['nature']},";
					if(isset($_POST['nourriture']))
						$categorie .= "{$_POST['nourriture']},";
					if(isset($_POST['dev']))
						$categorie .= "{$_POST['dev']},";

					$save = $allBillet->update(array('title'=> $_POST['title'], 'chapo'=> $_POST['chapo'], 'image'=> $_POST['image'], 'created'=> date('Y-m-d H:i:s'), 'categorie'=> trim($categorie, ","),'content'=>$_POST['content'], 'id_user'=> $this->login->getID(), 'login'=> $this->login->getPseudo()), array('id_billet' => $_POST['id_billet']));
					if($save)
						\system\Session::setFlash("<strong>Bravo:</strong> Votre billet a bien été édité.", "success");
					else
					{
						\system\Session::setFlash('<strong>Impossible de poster votre billet', "danger");
					}
					$this->get_articles($arg);
				}
			}
		}
	}

	public function post_add_user($arg)
	{
		if(isset($_POST['action']))
		{
			if ($_POST['action'] == 'add')
			{
				$allUser = new User();

				$level = $_POST['level'];
				if($this->login->getAdmin() < 2)
					if($_POST['level'] > 1)
						$level = 1;

				$save = $allUser->insert(array('username'=> $_POST['username'], 'nom'=> $_POST['nom'], 'prenom'=> $_POST['prenom'], 'password'=> md5($_POST['password']), 'email'=> $_POST['email'], 'admin'=> $level));
				if($save)
					\system\Session::setFlash("<strong>Bravo:</strong> L'utilisateur a bien été ajouté.", "success");
				else
				{
					\system\Session::setFlash('<strong>Impossible de créer l\'utilisateur', "danger");
				}
			}
		}
		$this->get_users($arg);
	}

	public function post_user($arg)
	{
		if(isset($_POST['action']))
		{
			if ($_POST['action'] == 'edit')
			{
				if(!isset($_POST['id_user']))
				{
					\system\Session::setFlash('<strong>Impossible de récuperer votre billet.</strong><br>Vous ne devez pas modifier le forumulaire.', "danger");
					die("false");
				}
				else
				{
					$allUser = new User();
					$retour = $allUser->findFirst(array('conditions'=> array('id_user'=> $_POST['id_user'])));
					die(json_encode($retour));
				}
			}
		}
	}

	public function post_delete_user($arg)
	{
		if(isset($_POST['action']))
		{
			if ($_POST['action'] == 'delete')
			{
				if(!isset($_POST['id_user']) || !isset($_POST['admin']) || $_POST['admin'] > 1)
				{
					\system\Session::setFlash('<strong>Impossible de supprimer l\'utilisateur.</strong><br>Vous ne devez pas modifier le forumulaire.', "danger");
					die("false");
				}
				else
				{
					$allUser = new User();
					$allUser->delete(array('id_user'=> $_POST['id_user']));
					die("true");
				}
			}
		}
	}

	public function post_update_user($arg)
	{
		if(isset($_POST['action']))
		{
			if ($_POST['action'] == 'edit')
			{
				if(!isset($_POST['id_user']) || !isset($_POST['level']))
				{
					\system\Session::setFlash('<strong>Impossible de récuperer votre utilisateur.</strong><br>Vous ne devez pas modifier le forumulaire.', "danger");
					$this->get_users($arg);
				}
				else
				{
					$allUser = new User();
					$user2 = new User($_POST['id_user']);

					if($user2->getAdmin() > $this->login->getAdmin())
					{
						\system\Session::setFlash('<strong>Impossible d\'éditer un utilisateur avec un rang supérieur à vous.</strong><br>Vous ne devez pas modifier le forumulaire.', "danger");
						$this->get_users($arg);
						return;
					}



					$level = $_POST['level'];
					if($this->login->getAdmin() < 2)
						if($_POST['level'] > 1)
							$level = 1;

					$password = $_POST['password2'];
					if(!empty($_POST['password']))
						$password = md5($_POST['password']);

					$save = $allUser->update(array('nom'=> $_POST['nom'], 'prenom'=> $_POST['prenom'], 'admin'=> $level, 'password'=> $password, 'email'=> $_POST['email']), array('id_user' => $_POST['id_user']));
					if($save)
						\system\Session::setFlash("<strong>Bravo:</strong> Votre utilisateur a bien été modifié.", "success");
					else
					{
						\system\Session::setFlash('<strong>Impossible de poster votre billet.', "danger");
					}
					$this->get_users($arg);
				}
			}
		}
	}
}