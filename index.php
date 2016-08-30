<?php
header("Content-Type:text/html;charset=UTF-8");

require_once("files/config.php");
require_once("classes/ACore.php");
require_once("classes/ACore_Admin.php");

if (!(isset($_GET['option']))) {
	$class = 'main';
}
else {
	$class = trim(strip_tags($_GET['option']));
}
if(file_exists("classes/".$class.".php")) {
	include("classes/".$class.".php");
	if(class_exists($class)) {
		
		$obj = new $class;
		$obj->get_body();
	}
	else {
		exit("<p>Не правильные данные для входа</p>");
	}
}
else {
	exit("<p>Не правильный адресс</p>");
}
?>