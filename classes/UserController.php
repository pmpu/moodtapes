<?php 

class UserController{


	function __construct()
	{
		
	}
    
    public static function currentUser(){
        return UserController::getUserBySession($_POST["session"]);
    }

	public static function getUserById($id){
		$id = (int)$id;
		$user_a = Db::getElementByQuery("SELECT * FROM users WHERE id = ".$id);
		if ($user_a != null){
			return new User($user_a);
		}
		return null;
	}
    
    public static function tieMusic(User $user, Music $music){
        db::execQuery("INSERT IGNORE INTO user_music (user, music) 
                VALUES ('".$user->getId()."', '".$music->getId()."')");
    }
    
    public static function tieImage(User $user, Image $image){
        db::execQuery("INSERT IGNORE INTO user_image (user, image) 
                VALUES ('".$user->getId()."', '".$image->getId()."')");
    }
    
    public static function tiePage(User $user, Page $page){
        db::execQuery("INSERT IGNORE INTO user_page (user, page) 
                VALUES ('".$user->getId()."', '".$page->getId()."')");
    }  
    
    
    
    public static function getUserBySession($session){
        return Db::getObjectByQuery("SELECT * FROM users WHERE session = '".mysql_escape_string($session)."'", "User");
    }

	public function save(User $user){
		if ($user->getId())
		{
			Db::execQuery("UPDATE users SET
									 email='".$user->getEmail()."', 
									 password_md5='".$user->getPasswordMd5()."',
									 name='".$user->getName()."',
									 session='".$user->getSession()."' WHERE id = '".$user->getId()."'
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
		$resp = array();
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
					}else{
    					$resp["error"] = true;
    					$resp["errorMsg"] = "name must be at least 5 symbols long";
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

		echo json_encode($resp);
	}

	public function signin($email, $password){
		$resp = array();
		$resp["error"] = false;

    

		if (Utils::checkEmail($email)){
			if(strlen($password) >= 5){
				$password_md5 = md5($password.DB_SALT);
                
				$usr = Db::getObjectByQuery("SELECT * FROM users WHERE email='".$email."' 
					AND password_md5 = '".$password_md5."' ", "User");
				if ($usr)
				{
					$usr->setSession(Utils::randString());
                    
					$this->save($usr);
					$resp["session"] = $usr->getSession();
					echo json_encode($resp);
                    
					return;
				}
			}
		}

		$resp["error"] = true;
		$resp["errorMsg"] = "wrong email or password";
		echo json_encode($resp);
	}

}


 ?>