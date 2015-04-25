<?php




Class Page{
   private $id;
    private $name;
    private  $desc;

    function __construct($p) {


        $this->id = $p['id'];
        $this->name = $p['name'];
        $this->desc = $p['desc'];





}

    function setName($name)
    {
        $this->name = $name;
        return $this;

    }

    function getName($page)
    {

        return $this->name;
    }



    function setDesc($desc)
    {

        $this->desc = $desc;
        return $this;

    }

    function getDesc()
    {

       return $this->desc;

    }



}
