<?php




Class Page{
   private $id;
   private $name;
   private  $description;
   private  $color_bg;
   private  $color_controls;

    function __construct($p = null) {
        if($p){
            $this->id = $p['id'];
            $this->name = $p['name'];
            $this->description = $p['description']; 
            $this->color_bg = $p['color_bg'];   
            $this->color_controls = $p['color_controls'];   
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
    
    function getColorBg(){return $this->color_bg;}
    function getColorControls(){return $this->color_controls;}
    
    function setColorBg($val){$this->color_bg = $val;}
    function setColorControls($val){$this->color_controls = $val;}
    



}
