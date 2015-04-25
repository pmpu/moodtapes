<?php

class ApiController{
  private $request;
  
	public function ApiController($request){	      
		$this->request = $request;
        Db::connectDatabase();
        
	}
	
	public function processRequest(){
	   switch($this->request->getAction()){
	       case "":
              echo "main page";
           break;
	       case "hello":
            echo "hello ".$this->request->getParam(1); 
           break;
           case "createUser":
            $uc = new UserController();
            $uc->createUser($this->request->getPost("email"));
           break;
           case "dbcheck":            
           
           print_r(Db::getElementByQuery("SELECT * FROM users"));
             print_r($_POST);
           break;
           default:
             echo "no such action";
	   }
	   
      
    }
}
?>