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
            echo "hello"; 
           break;
           default:
             echo "no such action";
	   }
	   
      
    }
}
?>