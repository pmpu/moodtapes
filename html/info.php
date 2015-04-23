<?php
echo "Fuck yeah";
phpinfo();

new DbHandler();

class DbHandler extends Handler {
	function __construct(){
		echo "construct";
	}

}

?>
