<?php

class PageController
{
   
    
    
    
    public function save(Page $page){
        if($page->getId()){
            Db::execQuery("UPDATE pages SET name = '".$page->getName()."', 
                                            description = '".$page->getDesc()."'
                                            WHERE id = '".$page->getId()."'");
        }else{
            Db::execQuery("INSERT INTO pages (name, description) VALUES 
                        ('".mysql_escape_string($page->getName())."', '".mysql_escape_string($page->getDesc())."')");
            $page->setId(mysql_insert_id());
        }
        
        return $page;
    }

    function createPage($name, $desc){
        $resp = array();
        $resp["error"] = false;
        
        $usr = UserController::currentUser();
        
        if($usr){
            if (Utils::checkName($name)){
                if (Utils::checkDesc($desc)){
                    $page = new Page(); 
                    $page->setName($name); 
                    $page->setDesc($desc);
                    $pageId = $this->save($page);
                    $resp["pageId"] = $pageId;
                }else{
                    $resp["error"] = true;
                    $resp["errorMsg"] = "description is too small";
                }
            }else{
                $resp["error"] = true;
                $resp["errorMsg"] = "name is too small";
            }    
        }else{
            $resp["error"] = true;
            $resp["errorMsg"] = "need_auth";
        }
        
        


        echo json_encode($resp);

    }

}


