<?


class TagController {
    
    
    public static function getTagByName($name){
        return Db::getObjectByQuery("SELECT * FROM tags WHERE name = '".mysql_escape_string($name)."'", "Tag");
    }
    
    public static function save(Tag $tag){
        if($tag->getId()){
            Db::execQuery("UPDATE tags SET name = '".mysql_escape_string($tag->getNane())."'
                                WHERE id = '".$tag->getId()."'");
        }else{
            Db::execQuery("INSERT INTO tags (name) VALUES 
                        ('".mysql_escape_string($tag->getName())."')");
            $tag->setId(mysql_insert_id());
        }
        
        return $tag;                
    }
}

?>