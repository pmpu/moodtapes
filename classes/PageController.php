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
    
    public static function tieImage(Page $page, Image $image){
        db::execQuery("INSERT IGNORE INTO page_image (page, image) 
                VALUES ('".$page->getId()."', '".$image->getId()."')");
    }
    
     public static function tieMusic(Page $page, Music $music){
        db::execQuery("INSERT IGNORE INTO page_music (page, music) 
                VALUES ('".$page->getId()."', '".$music->getId()."')");
    }

    function createPage($name, $desc, $music, $images){
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
                    
                    if($music){
                        foreach($music as $key=>$m_id){
                            if($m = MusicController::getMusicById($m_id)){
                                self::tieMusic($page, $m);
                            }
                        }    
                    }
                    
                    if($images){
                        foreach($images as $key=>$i_id){
                            if($i = ImageController::getImageById($i_id)){
                                self::tieImage($page, $i);
                            }
                        }    
                    }
                    
                    
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


