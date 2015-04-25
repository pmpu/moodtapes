<?
class db{
    public static function connectDatabase($server = DB_ADDRESS, $user = DB_USER, $password = DB_PASSWORD, $dbname = DB_NAME){      
        if(mysql_connect($server, $user, $password)){
            mysql_select_db($dbname);
            
              if($me = mysql_error()) new error("mysql", $me, __LINE__, __FILE__);
        }
    }
    public static function getElementByQuery($query){                      
        if( $resource = mysql_query($query)){   
      
            if($me = mysql_error()) new error("mysql", $me, __LINE__, __FILE__);
             return mysql_fetch_array($resource);
        }
        return null;
    }
    public static function getObjectByQuery($query, $className, $params = null){
        if( $resource = mysql_query($query)){         
            if($me = mysql_error()) new error("mysql", $me, __LINE__, __FILE__);
             return mysql_fetch_object($resource, $className, $params);
        }
        return null;
    }
    public static function getElementsByQuery($query){
        if($resource = mysql_query($query)){
            if($me = mysql_error()) new error("mysql", $me, __LINE__, __FILE__);
                $items = array();
                    while($item = mysql_fetch_array($resource))
                      $items[] = $item; 
                return $items;
        }
        return null;
    }
    public static function getObjectsByQuery($query, $className, $params = null){
        if($resource = mysql_query($query)){
            if($me = mysql_error()) new error("mysql", $me, __LINE__, __FILE__);
                $items = array();
                    while($params?($item = mysql_fetch_object($resource, $className, $params)):($item = mysql_fetch_object($resource, $className)))
                      $items[] = $item; 
                return $items;
        }
        return null;
    }
    public static function execQuery($query){
        mysql_query($query);
          if($me = mysql_error()) new error("mysql", $me, __LINE__, __FILE__);
    }
}