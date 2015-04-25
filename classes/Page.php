<?php




Class Page{
   private $id;
   private $name;
   private  $desc;

    function __construct($p = null) {
        if($p){
            $this->id = $p['id'];
            $this->name = $p['name'];
            $this->desc = $p['desc'];    
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

        $this->desc = $val;
        return $this;

    }

    function getDesc()
    {
       return $this->desc;

    }



}
