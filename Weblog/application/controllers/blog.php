<?php
namespace application\controllers;
use system\Controller;
use system\View;
use system\Config;
use system\helper\Input;
use system\helper\Pagination;
use application\models\Billet;
use application\models\Comment;
use application\models\Contact;
use application\models\User;

class Blog extends Controller {

	public function action_index($arg)
	{
		$allBillet = new Billet();
		$allComment = new Comment();

		$page = (isset($arg[0]) && isset($arg[1]) && ($arg[0] == 'page') && intval($arg[1])) ? $arg[1] : 0;

		$pager = new Pagination();
		$pager->num_results = $allBillet->count();
		$pager->limit = $this->data['nbr_ligne_pagination'];
		$pager->page = $page;
		$pager->menu_link = $this->data['base_url'];
		$pager->menu_link_suffix = 'blog/index';
		$pager->css_class = 'pagination';
		$pager->run();

		$this->data['pagination'] = $pager;
		$this->data['allBillet'] = $allBillet->find(array('limit' => "$pager->offset, $pager->limit", 'order' => "id_billet DESC"));

		foreach ($this->data['allBillet'] as $value)
		{
			$allComment->findAll('billet', $value->id_billet);
			$value->count = $allComment->count;
		}
		View::make('blog.index', $this->data);
	}

	public function action_contact()
	{
		if(isset($_POST['emailc']) && isset($_POST['subject']) && isset($_POST['message']))
		{
			$message = nl2br($_POST['message']);
			$message = preg_replace ("/(\r|\n|\r\n)/", "", $message);

			if(!Input::inject($_POST['emailc']) && !Input::inject($_POST['subject']) && !Input::inject($message) && filter_var($_POST['emailc'], FILTER_VALIDATE_EMAIL))
			{
				$contact = new Contact();
				$contact->insert(array('email' => $_POST['emailc'], 'sujet'=> $_POST['subject'], 'message'=> $message, 'created'=> date('Y-m-d H:i:s')));
				\system\Session::setFlash("<strong>Bravo:</strong> Votre message a bien été envoyé.", "success");
			}
			else
				\system\Session::setFlash('<strong>Impossible d\'envoyer votre message.</strong>', "danger");
		}
		View::make('blog.contact', $this->data);
	}

	public function action_categorie($categorie)
	{
		if(!isset($categorie[0]))
			$categorie[0] = "%";

		$categorie = implode('%', explode(" ", $categorie[0]));

		$allBillet = new Billet();
		$allComment = new Comment();

		$page = (isset($arg[1]) && isset($arg[2]) && ($arg[1] == 'page') && intval($arg[2])) ? $arg[2] : 0;

		$pager = new Pagination();
		$pager->num_results = $allBillet->count(array('categorie' => "%$categorie%"));
		$pager->limit = $this->data['nbr_ligne_pagination'];
		$pager->page = $page;
		$pager->menu_link = $this->data['base_url'];
		$pager->menu_link_suffix = 'categorie/'.$categorie[0];
		$pager->css_class = 'pagination';
		$pager->run();

		$this->data['pagination'] = $pager;
		$this->data['allBillet'] = $allBillet->find(array('limit' => "$pager->offset, $pager->limit", 'order' => "id_billet DESC", 'conditions'=> array('categorie'=> "%$tag%")));

		foreach ($this->data['allBillet'] as $value)
		{
			$allComment->findAll('billet', $value->id_billet);
			$value->count = $allComment->count;
		}
		View::make('blog.index', $this->data);
	}

	public function action_search($search)
	{
		if(!isset($search[0]))
			$search[0] = "%";

		$search = implode('%', explode(" ", $search[0]));

		$allBillet = new Billet();
		$allComment = new Comment();

		$page = (isset($search[1]) && isset($search[2]) && ($search[1] == 'page') && intval($search[2])) ? $search[2] : 0;

		$pager = new Pagination();
		$pager->num_results = $allBillet->count(array('content' => "%$search%"));
		$pager->limit = $this->data['nbr_ligne_pagination'];
		$pager->page = $page;
		$pager->menu_link = $this->data['base_url'];
		$pager->menu_link_suffix = 'search/'.$search[0];
		$pager->css_class = 'pagination';
		$pager->run();

		$this->data['pagination'] = $pager;
		$this->data['allBillet'] = $allBillet->find(array('limit' => "$pager->offset, $pager->limit", 'order' => "id_billet DESC", 'conditions'=> array('content'=> "%$search%")));

		foreach ($this->data['allBillet'] as $value)
		{
			$allComment->findAll('billet', $value->id_billet);
			$value->count = $allComment->count;
		}
		View::make('blog.index', $this->data);
	}

	public function action_article($arg)
	{
		if(!isset($arg[0]))
			$arg[0] = 1;

		$allBillet = new Billet();
		$this->data['billet'] = $allBillet->findFirst(array('conditions'=> array('id_billet'=> $arg[0])));

		$comments_cls = new Comment();

		if(User::isLoged() && isset($_POST['action']))
		{
			if ($_POST['action'] == 'comment')
			{
				$save = $comments_cls->save('billet', $this->data['billet']->id_billet, $this->login->getPseudo(), $this->login->getEmail());
				if($save)
					\system\Session::setFlash("<strong>Bravo:</strong> Votre commentaire a bien été posté.", "success");
				else
				{
					$errors = "<ul>";
					foreach ($comments_cls->errors as $value)
						$errors .= "<li>$value</li>";
					$errors .= "</ul>";
					\system\Session::setFlash('<strong>Impossible de poster votre commentaire</strong> pour les raisons suivantes: '.$errors, "danger");
				}
			}
			elseif ($_POST['action'] == 'select-edit')
			{
				if(!isset($_POST['id_comment']))
					\system\Session::setFlash('<strong>Impossible d\'éditer votre commentaire.</strong><br>Vous ne devez pas modifier le forumulaire.', "danger");
				else
				{
					$retour = $comments_cls->findFirst(array('fields' => 'content','conditions'=> array('id_comment'=> $_POST['id_comment'])));
					die($retour->content);
				}
			}
			elseif ($_POST['action'] == 'edit')
			{
				if(!isset($_POST['content']) || !isset($_POST['id_comment']))
					\system\Session::setFlash('<strong>Impossible d\'éditer votre commentaire.</strong><br>Vous ne devez pas modifier le forumulaire.', "danger");
				elseif(empty($_POST['content']))
					\system\Session::setFlash('<strong>Impossible d\'éditer votre commentaire.</strong><br>Vous n\'avez pas mis de message.', "danger");
				elseif($this->login->getAdmin() > 0)
					$comments_cls->update(array('content'=> $_POST['content']), array('id_comment'=> $_POST['id_comment']));
				else
					$comments_cls->update(array('content'=> $_POST['content']), array('id_comment'=> $_POST['id_comment'], 'username' => $this->login->getPseudo()));
			}
			elseif ($_POST['action'] == 'delete')
			{
				if(!isset($_POST['parent_id']) || !isset($_POST['id_comment']))
				{
					\system\Session::setFlash('<strong>Impossible d\'éditer votre commentaire.</strong><br>Vous ne devez pas modifier le forumulaire.', "danger");
					die("false");
				}
				elseif($_POST['parent_id'] == $_POST['id_comment'])
				{
					if($this->login->getAdmin() > 0)
					{
						$comments_cls->delete(array('id_comment'=> $_POST['id_comment']));
						$comments_cls->delete(array('parent_id'=> $_POST['parent_id']));
					}
					else
					{
						$comments_cls->delete(array('id_comment'=> $_POST['id_comment'], 'username' => $this->login->getPseudo()));
						$comments_cls->delete(array('parent_id'=> $_POST['parent_id'], 'username' => $this->login->getPseudo()));
					}
				}
				else
				{
					if($this->login->getAdmin() > 0)
						$comments_cls->delete(array('id_comment'=> $_POST['id_comment']));
					else
						$comments_cls->delete(array('id_comment'=> $_POST['id_comment'], 'username' => $this->login->getPseudo()));
				}
				die("true");
			}
		}
		elseif(User::isLoged() == false && isset($_POST['action']))
		{
			if ($_POST['action'] == 'comment')
			{
				$save = $comments_cls->save('billet', $this->data['billet']->id_billet, "Anonyme", "Anonyme@Anonyme.fr");
				if($save)
					\system\Session::setFlash("<strong>Bravo:</strong> Votre commentaire a bien été posté.", "success");
				else
				{
					$errors = "<ul>";
					foreach ($comments_cls->errors as $value)
						$errors .= "<li>$value</li>";
					$errors .= "</ul>";
					\system\Session::setFlash('<strong>Impossible de poster votre commentaire</strong> pour les raisons suivantes: '.$errors, "danger");
				}
			}
		}

		$this->data['comments'] = @$comments_cls->findAll('billet', $this->data['billet']->id_billet);
		$this->data['count'] = $comments_cls->count;

		View::make('blog.article', $this->data);
	}
}