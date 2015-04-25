<?php 

class User{
	private $id, $name, $email, $password_md5, $session;
	function __construct($u){
		if($u){
			$this->id = $u["id"];
			$this->name = $u["name"];
			$this->email = $u["email"];
			$this->password_md5 = $u["password_md5"];
			$this->session = $u["session"];	
		}		
	}
	public function getId(){
		return $this->id;
	}
		public function getName(){
		return $this->name;
	}
	public function getEmail(){
		return $this->email;
	}
	public function getPasswordMd5(){
		return $this->password_md5;
	}

	public function getSession(){
		return $this->session;
	}

	public function setId($val){
		 $this->id = (int)$val;
		 return $this;
	}
		public function setName($val){
		 $this->name = $val;
		 return $this;
	}
	public function setEmail($val){
		 $this->email = $val;
		 return $this;
	}
	public function setPasswordMd5($val){
		 $this->password_md5 = $val;
		 return $this;
	}

	public function setSession($val){
		 $this->session = $val;
		 return $this;
	}
}

 ?>