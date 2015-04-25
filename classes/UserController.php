<?php 

class UserController{

	private $request;
	function __construct($request)
	{
		$this->request = $request;
	}

	public function getUserById($id){
		$id = (int)$id;
		$user_a = Db::getElementByQuery("SELECT * FROM users WHERE id = ".$id);
		if ($user_a != null){
			return new User($user_a);
		}
		return null;
	}

	public function save(User $user){
		if ($user->getId())
		{
			Db::execQuery("UPDATE users SET
									 email='".$user->getEmail()."', 
									 password_md5='".$user->getPasswordMd5()."',
									 name='".$user->getName()."',
									 session='".$user->getSession()."'
				");
		}else{ 
			Db::execQuery("INSERT INTO users (email, password_md5, name, session) 
							VALUES('".$user->getEmail()."', '".$user->getPasswordMd5()."',
								'".$user->getName()."', '".$user->getSession()."')

				");
			$user->setId(mysql_insert_id());

		}

		return $user;

	}
	public function signup($email, $password){
		$resp = [];
		$resp["error"] = false;

		if (strlen($email) != 0){
			if(strlen($password) >= 5){

			}else{
				$resp["error"] = true;
				$resp["errorMsg"] = "password must be at least 5 symbols long";
			}
		}else{
			$resp["error"] = true;
			$resp["errorMsg"] = "wrong email";
		}

		print_r($resp);
	}
}


 ?>