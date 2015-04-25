<?


class ImageController {
    
    
    
    public function save(Image $image){
         if($image->getId()){
            Db::execQuery("UPDATE images SET md5 = '".mysql_escape_string($image->getMd5())."'
                                WHERE id = '".$image->getId()."'");
        }else{
            Db::execQuery("INSERT INTO images (md5) VALUES 
                        ('".mysql_escape_string($image->getMd5())."')");
            $image->setId(mysql_insert_id());
        }
        
        return $image;
    }
    
    public static function getImageById($id){
        return Db::getObjectByQuery("SELECT * FROM images WHERE id = '".$id."'", "Image");
    }
    
    public static function getImageByMd5($md5){
        return Db::getObjectByQuery("SELECT * FROM images WHERE md5 = '".$md5."'", "Image");
    }
        
    
    public static function getUserImages(User $usr){
        $resp = array();
        $resp["error"] = false;
        
        $images = Db::getObjectsByQuery("SELECT images.* FROM images 
                                LEFT JOIN user_image ON images.id = user_image.image
                                LEFT JOIN users ON user_image.user = users.id
                                WHERE users.id = '".$usr->getId()."'", "Image");
        
        $resp['images'] = array();
                
        if($images){
            foreach($images as $key=>$image){
                $resp['images'][] = array(
                    "id" => $image->getId(),
                    "file" => self::getImageUrl($image)
                );
            }    
        }
        
        
        echo json_encode($resp);
        
    }
    
    public static function getImageUrl(Image $img){
        return ROOT."/images/".$img->getMd5().".png";
    }
     
    
    
    
    
    public function upload($files){
        $resp = array();
        $resp["error"] = false;
        
        $usr = UserController::currentUser();
    
        if($usr){
            foreach($files as $key=>$file){
                if(!$file['error']){
                    if(Utils::isImage($file["tmp_name"])){
                        // its image
                        $md5 = md5_file($file["tmp_name"]);
                        $new_path = ROOT."/images/".$md5.".png";  
                        
                        $img = new SimpleImage($file["tmp_name"]);
                        $img->save($new_path);
                        
                        if(file_exists($new_path)){
                            $i = null;
                            if(!($i = self::getImageByMd5($md5))){                                
                                $i = new Image();                             
                                $i->setMd5($md5);
                                $this->save($i);
                            }                            
                            
                            // tie with user
                            UserController::tieImage($usr, $i);                                                       

                        }else{
                            $resp["error"] = true;
                            $resp["errorMsg"] = "upld_move_error";
                            echo json_encode($resp);
                            return;
                        }
                    }else{
                        $resp["error"] = true;
                        $resp["errorMsg"] = "not image";
                        echo json_encode($resp);
                        return;
                    } 
                    
                    
                        
                      
                }else{
                    $resp["error"] = true;
                    $resp["errorMsg"] = "upld_error";
                    echo json_encode($resp);
                    return;
                }
            }
        }else{
            $resp["error"] = true;
            $resp["errorMsg"] = "need_auth";
        }
        
        echo json_encode($resp);
    }
    
    
    
    
    
}




?>