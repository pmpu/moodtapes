<?php 

class UserController{


	function __construct()
	{
		
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
	public function signup($email, $password, $name){
		$resp = [];
		$resp["error"] = false;

		if (Utils::checkEmail($email)){
			if(!Db::getElementByQuery("SELECT * FROM users WHERE email='".$email."'")){
				if(strlen($password) >= 5){
					if (strlen($name) >= 5){
						$usr = new User();
						$usr->setName($name);
						$usr->setPasswordMd5(md5($password.DB_SALT));
						$usr->setEmail($email);
						$usr->setSession(Utils::randString());
						$this->save($usr);
						$resp["session"] = $usr->getSession();
					}
				}else{
					$resp["error"] = true;
					$resp["errorMsg"] = "password must be at least 5 symbols long";
				}
			}else{
				$resp["error"] = true;
				$resp["errorMsg"] = "user with such email already exists";
			}
			
		}else{
			$resp["error"] = true;
			$resp["errorMsg"] = "wrong email";
		}

		print_r($resp);
	}

	public function signin($email, $password){
		$resp = [];
		$resp["error"] = false;



		if (strlen($email) != 0){
			if(strlen($password) >= 5){
				$password_md5 = md5($password.DB_SALT);
				$usr = Db::getObjectByQuery("SELECT * FROM users WHERE email='".$email."' 
					AND password_md5 = '".$password_md5."' ", "User");
				if ($usr)
				{
					$usr->setSession(Utils::randString());
					$this->save($usr);
					$resp["session"] = $usr->getSession();
					print_r($resp);
					return;
				}
			}
		}

		$resp["error"] = true;
		$resp["errorMsg"] = "wrong email or password";
		print_r($resp);
	}

}


 ?>