<?


class MusicController {
    
    
    
    public function save(Music $music){
         if($music->getId()){
            Db::execQuery("UPDATE music SET artist = '".mysql_escape_string($music->getArtist())."', 
                                            title = '".mysql_escape_string($music->getTitle())."',
                                            md5 = '".mysql_escape_string($music->getMd5())."'
            WHERE id = '".$music->getId()."'");
        }else{
            Db::execQuery("INSERT INTO pages (artist, title, md5) VALUES 
                        ('".mysql_escape_string($music->getArtist())."',
                         '".mysql_escape_string($music->getTitle())."',
                         '".mysql_escape_string($music->getMd5())."'
                         )");
            $music->setId(mysql_insert_id());
        }
        
        return $music;
    }
    
    public function upload($files){
        $resp = array();
        $resp["error"] = false;
        
        $usr = UserController::currentUser();
        
        if($usr){
            foreach($files as $key=>$file){
                if(!$file['error']){
                    $mp3_mimes = array('audio/mpeg3', 'audio/x-mpeg-3'); 
                    if (!in_array(mime_content_type($file["tmp_name"]), $mp3_mimes)) {
                        $md5 = md5_file($file["tmp_name"]);
                        $id3_reader = new Id3v2;
                        $id3 = $id3_reader->read($file["tmp_name"]);
                        $new_path = ROOT."/music/".$md5.".mp3";
                        
                        print_r($id3);
                        
                        if(move_uploaded_file($file["tmp_name"], $new_path)){
                            $m = new Music();
                            
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