<?php
namespace application\models;
use system\Model;
use system\Session;
use system\helper\Input;
use \Exception;

class User extends Model
{
	private $id_user;
	private $username;
	private $password;
	private $email;
	private $admin;
	private $nom;
	private $prenom;

	// Si l'utilisateur est déjà connecté, cette fonction ira dans la bdd lire les infos sur l'utilisateur désigné
	// Variables utilisées :
	function __construct($idMembre = null)
	{
		parent::__construct();

		if(!is_null($idMembre))
		{
			$ligne = $this->findFirst(array('conditions'=> array('id_user' => $idMembre)));

			// Si ligne !== false le membre existe
			if($ligne !== FALSE)
			{
			    $this->id_user = $ligne->id_user;
			    $this->username = $ligne->username;
			    $this->password = $ligne->password;
			    $this->email = $ligne->email;
			    $this->admin = $ligne->admin;
			    $this->nom = $ligne->nom;
			    $this->prenom = $ligne->prenom;
			}
		}
	}

	public static function inscription($pseudo, $motDePasse, $motDePasse2, $email)
	{
		// Connexion sql
		$pdo = new User();

		if(Input::inject(array($pseudo, $motDePasse, $motDePasse2, $email)))
			throw new Exception('INJECT');

		if(strlen(trim($pseudo)) < 4 || strlen(trim($pseudo)) > 23)
			throw new Exception('SHORT_LOGIN');

		if(strlen(trim($motDePasse)) < 4 || strlen(trim($motDePasse)) > 23)
			throw new Exception('SHORT_PASSWORD');

		if(strcmp($motDePasse, $motDePasse2))
			throw new Exception('PASSWORD_NOT_MATCH');

		if(!filter_var($email, FILTER_VALIDATE_EMAIL))
			throw new Exception('EMAIL_INVALIDE');

		//On crypte le mot de passe :
		$motDePasseCrypt = md5($motDePasse);

		if(self::pseudoDejaUtilise($pseudo))
			throw new Exception('LOGIN_ALREADY_USE');

		return $pdo->insert(array('username'=>$pseudo, 'password'=>$motDePasseCrypt, 'email'=> $email));
	}


	public static function pseudoDejaUtilise($pseudo)
	{
		// Connexion sql
		$pdo = new User();

		$ligne = $pdo->findFirst(array('fields' => 'id_user', 'conditions'=> array('username' => $pseudo)));

		//Si il y a un résultat c'est que l'utilisateur existe déjà
		//print_r($ligne);
		return ($ligne !== FALSE)? true: false;
	}


	public static function emailDejaUtilise($email)
	{
		// Connexion sql
		$pdo = new User();

		$ligne = $pdo->findFirst(array('fields' => 'id_user', 'conditions'=> array('email' => $email)));

		//Si il y a un résultat c'est que l'email est déjà utilisée
		//print_r($ligne);
		return ($ligne !== FALSE)? true: false;
	}

	public static function connexion($pseudoUtilisateur, $motDePasse, $varSession)
	{
		$retour = false;

		// Connexion sql
		$pdo = new User();

		// Anti injection
		if(Input::inject(array($pseudoUtilisateur, $motDePasse, $varSession)))
			throw new Exception('INJECT');

		//On crypte le mot de passe si md5 activé dans le config :
		$motDePasseCrypt = md5($motDePasse);

		$ligne = $pdo->findFirst(array('fields' => 'id_user', 'conditions'=> array('username' => $pseudoUtilisateur, 'password' => $motDePasseCrypt)));

		//Si il y a un résultat c'est que l'utilisateur c'est bien connecté
		if($ligne !== FALSE)
		{
			Session::set($varSession, $ligne->id_user);
			//$_SESSION[$varSession] = $ligne->id_user;
			$retour = true; //On retourne true pour dire que tout c'est bien passé
		}
		//Sinon c'est que le mot de passe ou le nom d'utilisateur n'est pas bon
		else
		{
			$retour = false;//Si c'est pas bon on renvoie false
		}
		return $retour;
	}

	public static function deconnexion($varSession){
		Session::destroy();
		return (Session::get($varSession) == false) ?  false : true;
	}

	public function sauvegarderLUtilisateur()
	{
		return $this->update(array('username'=>$this->username, 'password'=>$this->password, 'email'=>$this->email, 'admin'=>$this->admin, 'nom'=>$this->nom, 'prenom'=>$this->prenom), array('id_user'=>$this->id_user));
	}

	public static function supprimerLUtilisateur($id_membre)
	{
		$pdo = new User();
		return $pdo->delete(array('id_user'=>$id_membre));
	}

	public static function isLoged()
	{
		return isset($_SESSION['membre'])? true : false;
	}

	public function isAdmin()
	{
		return ($this->admin > 99)? true: false;
	}

	/*
	 * Renvoie true si l'utilisateur a le droit rentré en paramètre
	 * Renvoie false si l'utilisateur n'a pas le droit ou si ce dernier n'existe pas
	 */
	public function getID()
	{
		return $this->id_user;
	}
	public function getPseudo()
	{
		return $this->username;
	}
	public function getmotDePasse()
	{
		return $this->password;
	}
	public function getEmail()
	{
		return $this->email;
	}
	public function getAdmin()
	{
		return $this->admin;
	}
	public function getNom()
	{
		return $this->nom;
	}
	public function getPrenom()
	{
		return $this->prenom;
	}
	public function getPseudoName()
	{
		return (!empty($this->nom) && !empty($this->prenom)) ? $this->prenom." ".$this->nom : $this->username;
	}

	/** Les SETEURS **/
	public function setPseudo($nvPseudo)
	{
		if($nvPseudo != "")
			$this->username = $nvPseudo;
	}
	public function setEmail($nvEmail)
	{
		if($nvEmail != "")
			$this->email = $nvEmail;
	}
	public function setMotDePasse($nvPassword)
	{
		if($nvPassword != "")
			$this->password = md5($nvPassword);
	}

	public function setAdmin($level)
	{
		if($level != "")
			$this->admin = $level;
	}

	public function setNom($nom)
	{
		if($nom != "")
			$this->nom = $nom;
	}

	public function setPrenom($prenom)
	{
		if($prenom != "")
			$this->prenom = $prenom;
	}
}
?>