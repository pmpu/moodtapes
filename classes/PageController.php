<?php


define("MOODS_PER_PAGE", 15);

class PageController
{
   
    
    
    
    public static function save(Page $page){
        if($page->getId()){
            Db::execQuery("UPDATE pages SET name = '".$page->getName()."', 
                                            description = '".$page->getDesc()."',
                                            color_bg = '".$page->getColorBg()."'
                                            WHERE id = '".$page->getId()."'");
        }else{
            Db::execQuery("INSERT INTO pages (name, description, color_bg) VALUES 
                        ('".$page->getName()."', 
                        '".$page->getDesc()."',
                        '".$page->getColorBg()."'
                        )");
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
    
    public static function tieTag(Page $page, Tag $tag){
        db::execQuery("INSERT IGNORE INTO page_tag (page, tag) 
                VALUES ('".$page->getId()."', '".$tag->getId()."')");
    }
    
    
    
    public static function getPageById($id){
        $id = (int) $id;
        return Db::getObjectByQuery("SELECT * FROM pages WHERE id = '".$id."'", "Page");
    }
    
    public static function getPagesByTag($tag, $p = 1, $per_page = MOODS_PER_PAGE){
        self::getPages($p, $per_page, "LEFT JOIN page_tag ON pages.id = page_tag.page 
                                    LEFT JOIN tags ON tags.id = page_tag.tag WHERE tags.name LIKE '".$tag."%'");
        
    }
    
    public static function getPages($p = 1, $per_page = MOODS_PER_PAGE, $query = ""){
        $resp = array();
        $resp["error"] = false;
        
        if($p < 1) $p = 1;        
                
        $p = (int) $p;
        $per_page = (int) $per_page;
        
        $pages = Db::getObjectsByQuery("SELECT pages.* FROM pages ".$query." ORDER BY pages.id DESC LIMIT ".($p-1)*$per_page.", ".$per_page."", "Page");
        
        $resp['pages'] = array();
        foreach($pages as $key=>$page){
            $music = self::getPageMusic($page);
            $images = self::getPageImages($page);
            $tags = self::getPageTags($page);
            
            $resp_page = array();
            $resp_page['id'] = (int)$page->getId();
            $resp_page['name'] = $page->getName();
            $resp_page['desc'] = $page->getDesc();
            $resp_page['color_bg'] = $page->getColorBg();
            $resp_page['music'] = array();
            $resp_page['images'] = array();
            $resp_page['tags'] = array();
            
            if($music){
                foreach($music as $key=>$m){
                    $resp_page['music'][] = array(
                        "title" => $m->getTitle(),
                        "artist" => $m->getArtist(),
                        "file" => MusicController::getMusicUrl($m)
                    );
                }
            }
            
            if($images){
                foreach($images as $key=>$image){
                    $resp_page['images'][] = array(                        
                        "file" => ImageController::getImageUrl($image)
                    );
                }
            }
            
            if($tags){
                foreach($tags as $key=>$tag){
                    $resp_page['tags'][] = $tag->getName();
                }
            }  
            
            
            
            $resp['pages'][] = $resp_page;
        }
        
        echo json_encode($resp);
    }
    
    public static function getPage($id){
        $resp = array();
        $resp["error"] = false;
        
        if($page = self::getPageById($id)){
            $music = self::getPageMusic($page);
            $images = self::getPageImages($page);
            $tags = self::getPageTags($page);
            
            $resp['name'] = $page->getName();
            $resp['desc'] = $page->getDesc();
            $resp['color_bg'] = $page->getColorBg();
            $resp['music'] = array();
            $resp['images'] = array();
            $resp['tags'] = array();
            
            
            
            if($music){
                foreach($music as $key=>$m){
                    $resp['music'][] = array(
                        "title" => $m->getTitle(),
                        "artist" => $m->getArtist(),
                        "file" => MusicController::getMusicUrl($m)
                    );
                }
            }
            
            if($images){
                foreach($images as $key=>$image){
                    $resp['images'][] = array(                        
                        "file" => ImageController::getImageUrl($image)
                    );
                }
            } 
            
            if($tags){
                foreach($tags as $key=>$tag){
                    $resp['tags'][] = $tag->getName();
                }
            }        
        }else{
            $resp["error"] = true;
            $resp["errorMsg"] = "not_found";
        }
        
        
        echo json_encode($resp);       
        
    }
    
    public static function getPageMusic(Page $page){
        return Db::getObjectsByQuery("SELECT music.* FROM music
                                    LEFT JOIN page_music ON music.id = page_music.music
                                    LEFT JOIN pages ON pages.id = page_music.page
                                    WHERE pages.id = '".$page->getId()."'", "Music");
    }
    
    public static function getPageImages(Page $page){
        return Db::getObjectsByQuery("SELECT images.* FROM images
                                    LEFT JOIN page_image ON images.id = page_image.image
                                    LEFT JOIN pages ON pages.id = page_image.page
                                    WHERE pages.id = '".$page->getId()."'", "Image");
    }
    
    public static function getPageTags(Page $page){
        return Db::getObjectsByQuery("SELECT tags.* FROM tags
                                    LEFT JOIN page_tag ON tags.id = page_tag.tag
                                    LEFT JOIN pages ON pages.id = page_tag.page
                                    WHERE pages.id = '".$page->getId()."'", "Tag");
    }
    
    
    
    

    function createPage($name, $desc, $music, $images, $tags, $colorBg){
        $resp = array();
        $resp["error"] = false;
        
        if(!$colorBg) $colorBg = "white";
        
        $usr = UserController::currentUser();
        
        if($usr){
            if (Utils::checkName($name)){
                if (Utils::checkDesc($desc)){
                    $page = new Page(); 
                    $page->setName($name); 
                    $page->setDesc($desc);
                    $page->setColorBg($colorBg);
                                        
                    $page = self::save($page);
                    
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
                    
                    if($tags){
                        foreach($tags as $key=>$tag){
                            if(!$t = TagController::getTagByName($tag)){
                                $t = new Tag();
                                $t->setName($tag);
                                $t = TagController::save($t);
                            }
                            
                            self::tieTag($page, $t);
                        }    
                    }
                    
                    
                    $resp["pageId"] = $page->getId();
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


