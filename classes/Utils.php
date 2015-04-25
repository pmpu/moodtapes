<?


class Utils{
    
    public static function  checkEmail($str){
        return filter_var($str, FILTER_VALIDATE_EMAIL);
    }    
}


?>