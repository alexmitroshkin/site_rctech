<?php
session_start();
session_regenerate_id(true);
session_set_cookie_params(0, 'students/rctech');
session_name("rctech_admin");


abstract class ACore_Admin {
	
	
	protected $db;
	
	public function __construct() {
		
		if(!$_SESSION['user']) {
			header("Location:?option=login");
		}
	
		$this->db = mysql_connect(HOST,USER,PASSWORD);
		if(!$this->db) {
			exit("Ошибка соединения с базой данных".mysql_error());
		}
		if(!mysql_select_db(DB,$this->db)) {
			exit("Нет такой базы данных".mysql_error());
		}
		mysql_set_charset('UTF8');			
	}
	
	protected function get_header() {
		echo '<!DOCTYPE html>
		<html>
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
			<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
			<link href="images/favicon.ico" rel="shortcut icon" type="image/x-icon">
			<link rel="stylesheet" href="css/style.css">
			<title>
			</title>
			<script src="script/jquery.min.js" type="text/javascript"></script>
			<script src="script/other.js" type="text/javascript"></script>
			<script src="script/1.js" type="text/javascript"></script>
		</head>

		<body>
		<div id="headers"><a href="?option=admin"><img src="images/logo.jpg" alt="logo"/></a>
		<div class="clear"></div>
		</div>';
	}
		
	protected function get_footer() {
		echo "</body>
		</html>";
	}
		
	
	public function get_body() {
		
		if($_POST || $_GET['delete']) {
			$this->obr();
		}
		$this->get_header();
		$this->get_content();		
		$this->get_footer();
	}
	
	abstract function get_content();
	
	protected function get_news() {
		$query = "SELECT id_menu, title_menu FROM menu";
		$result = mysql_query($query);
		if(!$result) {
			exit(mysql_error());
		}
		$row = array();
		for($i = 0; $i < mysql_num_rows($result);$i++) {
			$row[] = mysql_fetch_array($result,MYSQL_ASSOC);
		}
		
		return $row;
	}
	protected function get_image() {
		$query = "SELECT id FROM images";
		$result = mysql_query($query);
		if(!$result) {
			exit(mysql_error());
		}
		$row = array();
		for($i = 0; $i < mysql_num_rows($result);$i++) {
			$row[] = mysql_fetch_array($result,MYSQL_ASSOC);
		}
		
		return $row;
	}
	
			
	protected function get_text_news($id_news) {
		$query = "SELECT id_news,images,zagolovok, anons, text,day_author,nomer FROM news WHERE id_news='$id_news'";
		$result = mysql_query($query);
		if(!$result) {
			exit(mysql_error());
		}
		$row = array();
		$row = mysql_fetch_array($result,MYSQL_ASSOC);
		
		return $row;
	}
}

?>