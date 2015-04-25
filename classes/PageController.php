<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 25.04.15
 * Time: 4:26
 */

class PageController

{

    function createPage($name, $desc){
        $resp = array("error"=>false);

        if ($name!= ""&& $desc!= "" ){
            $page = new Page($name, $desc);

            Db::execQuery("INSERT INTO pages (name, desc) VALUES (".$this->name.", ".$this->desc.")");
            $resp["pageId"] = mysql_insert_id();
        }else{
            $resp = array("error"=>true, "errorMsg"=>"something get wrong");
        }


        print_r($resp);


    }


    function deletePage($id)
    {
        $resp = array("error" => false);
        if ($id) {
            Db::execQuery("DELETE * FROM Pages WHERE Pages.id = " . "$id");
            $resp = array("error" => false);
        }
        else {
            $resp = array("error" => true, "errorMsg" => "something got wrong")
            }


        print_r($resp);
    }


    }


