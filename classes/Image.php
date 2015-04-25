<?

class Image {
    private $id, $md5;
    
    function __construct($m = null){
        if($m){
            $this->setId($m['id']);
            $this->setMd5($m['md5']);
        }
    }
    
    
    public function getId(){return $this->id;}
    public function getMd5(){return $this->md5;}


    public function setId($val){$this->id = (int) $val; return $this;}
    public function setMd5($val){$this->md5 = $val; return $this;}  
    
}


?>