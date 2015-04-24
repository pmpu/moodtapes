<?php

class ApiController{
  private $request;
  
	public function ApiController($request){	      
		$this->request = $request;
        
	}
	
	public function processRequest(){
	   switch($this->request->getAction()){
	       case "":
              echo "main page";
           break;
	       case "hello":
            echo "hello ".$this->request->getParam(1); 
           break;
           case "dbcheck":
            Db::connectDatabase();
            print_r(Db::getElementByQuery("SELECT * FROM users"));
             
           break;
           default:
             echo "no such action";
	   }
	   
      
    }
}
?>