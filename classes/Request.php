<?


class Request{

	private $action, $params, $post, $files;

	public function __construct($path, $post, $files){
		$this->buildRequest($path, $post, $files);	
	}

	public function getAction(){
		return $this->action;
	}

	public function getParam($index = null){
		if($index !== null)
			return ($rv = $this->params[$index])?$rv:false;
		return $this->params;
	}
	
	public function getPost($index = null){
		if($index !== null)
			return ($rv = $this->post[$index])?$rv:false;
		return $this->post;
	}
    
    public function getFiles(){
        return $this->files;
    }

	public function getVar($name){	
		if(($key = array_search($name, $this->params)) !== false){
			return ($val = $this->params[$key+1])?$val:false;
		}
	  		return false;	
	}

	public function getBack(){
		if($this->params[BACK_PARAM_NAME]){

		}
	}

	private function buildRequest($path, $post){
	    $requestArray = array();	    

	    if(strlen($path) > MAX_URL_LENGTH){
	    	new error('security', 'Too long url (max:'.MAX_URL_LENGTH.')', __LINE__, __FILE__);
	    }

	    # отчистка get частей
		 if($preArray = explode("/", trim($path))){ //удалить пробелы с концов строки
		 	foreach ($preArray as $key => $value) {
		 		if(trim($value))
		 		 $requestArray[$key] = trim($value);
		 	    else
		 	     unset($requestArray[$key]);
		 	}
		 }

		 $requestArray = array_values($requestArray);

		 $this->action = $requestArray[0];
		  unset($requestArray[0]);

		$this->params = array_values($requestArray);
		$this->post = $post;	
        
        
        if ($_FILES['upload']) {
            $this->files = self::reArrayFiles($_FILES['upload']);            
        }
        
	}
    
    static function reArrayFiles(&$file_post) {

        $file_ary = array();
        $file_count = count($file_post['name']);
        $file_keys = array_keys($file_post);
    
        for ($i=0; $i<$file_count; $i++) {
            foreach ($file_keys as $key) {
                $file_ary[$i][$key] = $file_post[$key][$i];
            }
        }
    
        return $file_ary;
    }
}


?>