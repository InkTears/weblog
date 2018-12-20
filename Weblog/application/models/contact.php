<?php
namespace application\models;
use system\Model;

class Contact extends Model
{
	public static function counts()
	{
		$contact = new Contact();
		return $contact->count();
	}
}
