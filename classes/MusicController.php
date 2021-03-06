<?


class MusicController {
    
    
    
    public function save(Music $music){
         if($music->getId()){
            Db::execQuery("UPDATE music SET artist = '".mysql_escape_string($music->getArtist())."', 
                                            title = '".mysql_escape_string($music->getTitle())."',
                                            md5 = '".mysql_escape_string($music->getMd5())."'
            WHERE id = '".$music->getId()."'");
        }else{
            Db::execQuery("INSERT INTO music (artist, title, md5) VALUES 
                        ('".mysql_escape_string($music->getArtist())."',
                         '".mysql_escape_string($music->getTitle())."',
                         '".mysql_escape_string($music->getMd5())."'
                         )");
            $music->setId(mysql_insert_id());
        }
        
        return $music;
    }
    
    public static function getMusicById($id){
        return Db::getObjectByQuery("SELECT * FROM music WHERE id = '".$id."'", "Music");
    }
    
    public static function getMusicByMd5($md5){
        return Db::getObjectByQuery("SELECT * FROM music WHERE md5 = '".$md5."'", "Music");
    }
    
    public static function getUserMusic(User $usr){
        $resp = array();
        $resp["error"] = false;
        
        $music = Db::getObjectsByQuery("SELECT music.* FROM music 
                                LEFT JOIN user_music ON music.id = user_music.music
                                LEFT JOIN users ON user_music.user = users.id
                                WHERE users.id = '".$usr->getId()."'", "Music");
        
        $resp['music'] = array();
                
        if($music){
            foreach($music as $key=>$m){
                $resp['music'][] = array(
                    "id" => $m->getId(),
                    "file" => self::getMusicUrl($m)
                );
            }    
        }
        
        
        echo json_encode($resp);
        
    }
    
     public static function getMusicUrl(Music $music){
        return "/music/".$music->getMd5().".mp3";
     }
    
     
    
    
    
    
    public function upload($files){
        $resp = array();
        $resp["error"] = false;
        
        $usr = UserController::currentUser();
    
        if($usr){
            foreach($files as $key=>$file){
                if(!$file['error']){
                    $mp3_mimes = array('audio/mpeg', 'audio/mpeg3', 'audio/x-mpeg-3', 'application/octet-stream'); 
                    
                    if (in_array(mime_content_type($file["tmp_name"]), $mp3_mimes)) {
                        $md5 = md5_file($file["tmp_name"]);
                        $new_path = ROOT."/music/".$md5.".mp3";                       
                       
                        
                        if(move_uploaded_file($file["tmp_name"], $new_path)){
                            $m = null;
                            if(!($m = self::getMusicByMd5($md5))){   
                                
                                $id3 = new ID3($new_path);
                                $id3->getInfo();
                                $m = new Music();
                                $m->setArtist($id3->getArtist());
                                $m->setTitle($id3->getTitle());
                                $m->setMd5($md5);
                                $this->save($m);
                            }                            
                            
                            // tie with user
                            UserController::tieMusic($usr, $m);
                                                        

                        }else{
                            $resp["error"] = true;
                            $resp["errorMsg"] = "upld_move_error";
                            echo json_encode($resp);
                            return;
                        }
                    }else{
                        $resp["error"] = true;
                        $resp["errorMsg"] = "only_mp3";
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