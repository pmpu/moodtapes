<?php
require_once "config.php";
	$controller = new ApiController(new Request($_GET['req'], $_POST, $_FILES));
	$controller->processRequest();
?>