<?


class Utils{
    
    public static function  checkEmail($str){
        return filter_var($str, FILTER_VALIDATE_EMAIL);
    } 
    
    public static function checkName($str){
        return strlen($str) > 4;
    }  
    
    public static function checkDesc($str){
        return strlen($str) > 4;
    }  
    
   public static function randString($length = 16) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    
    public static function isImage($file)
    {
        $fh = fopen($file,'rb');
        if ($fh) { 
            $bytes = fread($fh, 6); // read 6 bytes
            fclose($fh);            // close file
    
            if ($bytes === false) { // bytes there?
                return false;
            }
    
            // ok, bytes there, lets compare....
    
            if (substr($bytes,0,3) == "\xff\xd8\xff") { 
                return 'image/jpeg';
            }
            if ($bytes == "\x89PNG\x0d\x0a") { 
                return 'image/png';
            }
            if ($bytes == "GIF87a" or $bytes == "GIF89a") { 
                return 'image/gif';
            }
    
            return 'application/octet-stream';
        }
        return false;
    }
}


?>