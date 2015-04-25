<?php

class ApiController{
  private $request;
  
	public function ApiController($request){	      
		$this->request = $request;
        Db::connectDatabase();
        
	}
	
	public function processRequest(){
	   $cusr = UserController::currentUser();
	   switch($this->request->getAction()){
	       case "":
              Header("Location: /all");
           break;
	       
           case "signup":
            $uc = new UserController();
            $uc->signup($this->request->getPost("email"), $this->request->getPost("password"), $this->request->getPost("name"));
           break;
           case "signin":
            
            $uc = new UserController();
            $uc->signin($this->request->getPost("email"), $this->request->getPost("password"));
           break;
           case "create":
            $pc = new PageController();
            $pc->createPage($this->request->getPost("name"),
                      $this->request->getPost("desc"), 
                      $this->request->getPost("music"),
                      $this->request->getPost("images"),
                      $this->request->getPost("tags"));
           break;
           
           case "mood":
                PageController::getPage($this->request->getParam(0));
           break;
           
           case "all":
                PageController::getPages($this->request->getParam(1));
           break;
           
           case "tag":
                PageController::getPagesByTag($this->request->getParam(0),
                 $this->request->getParam(2));
           break;
           
           case "upload_music":
                $mc = new MusicController();
                $mc->upload($this->request->getFiles());
           break;
           case "upload_images":
                $ic = new ImageController();
                $ic->upload($this->request->getFiles());
           break;
           
           case "get_uploaded_images":
                ImageController::getUserImages($cusr);
           break;
           case "get_uploaded_music":
                MusicController::getUserMusic($cusr);
           break;
           
           default:
             echo json_encode(array("error"=>true, "errorMsg" => "not_found"));
	   }
	   
      
    }
}
?>