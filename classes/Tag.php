<?


class Tag {
    private $id, $name;
    
    function __construct($t = null){
        if($t){
            $this->setId($t['id']);
            $this->setName($t['name']);
        }
    }
    
    
    public function setId($val){$this->id = (int)$val;}
    public function setName($val){$this->name = $val;}
    
    public function getId(){return $this->id;}
    public function getName(){return $this->name;}
}


?>