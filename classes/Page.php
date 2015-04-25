<?php




Class Page{
   private $id;
   private $name;
   private  $description;

    function __construct($p = null) {
        if($p){
            $this->id = $p['id'];
            $this->name = $p['name'];
            $this->description = $p['description'];    
        }
    }
    
    function getId(){return $this->id;}
    function setId($val){$this->id = (int) $val;}

    function setName($val)
    {
        $this->name = $val;
        return $this;
    }

    function getName()
    {
        return $this->name;
    }



    function setDesc($val)
    {

        $this->description = $val;
        return $this;

    }

    function getDesc()
    {
       return $this->description;

    }



}
