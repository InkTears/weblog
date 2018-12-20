<?php
namespace system;
use application\models\User;

abstract class Controller {

    // si vrai la fonction peu être appelé par le type de request
    // ex: get_index(), post_index(), put_index() or delete_index()
	public $restful = false;

	protected $data = array();
	public $login;

	public function __construct()
	{
		$this->data =  Config::$application;
		$this->data['loged'] = false;

		if(User::isLoged())
		{
			$this->login = new User(Session::get('membre'));
			$this->data['loged'] = true;
			$this->data['member'] = $this->login;
		}

	}
}