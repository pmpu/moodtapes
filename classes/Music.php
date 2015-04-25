<?

class Music {
    private $id, $artist, $title, $md5;
    
    function __construct($m = null){
        if($m){
            $this->setId($m['id']);
            $this->setArtist($m['artist']);
            $this->setTitle($m['title']);
            $this->setMd5($m['md5']);
        }
    }
    
    
    public function getId(){return $this->id;}
    public function getArtist(){return $this->artist;}
    public function getTitle(){return $this->title;}
    public function getMd5(){return $this->md5;}


    public function setId($val){$this->id = (int) $val; return $this;}
    public function setArtist($val){$this->artist = $val; return $this;}
    public function setTitle($val){$this->title = $val; return $this;}
    public function setMd5($val){$this->md5 = $val; return $this;}  
    
}


?>