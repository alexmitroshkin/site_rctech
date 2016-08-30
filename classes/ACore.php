<?php
session_name("rctech");
session_set_cookie_params(0, 'students/rctech');
session_regenerate_id(true);
abstract class ACore {
	
	
	protected $db;
	
	public function __construct() {
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
			<title>';
			
		if($_GET['option']=='main') {
			echo "Главное";
		}
		if(isset($_GET['id_menu'])) {
			$title = (int)$_GET['id_menu'];
			if(!$title) {
				echo 'Не правильные данные для вывода меню';
			}
			else {
				$query1 = "SELECT id_menu,title_menu FROM menu WHERE id_menu='$title'";
				$result1 = mysql_query($query1);
				if(!$result1) {
					exit(mysql_error());
				}
				$row1 = mysql_fetch_array($result1,MYSQL_ASSOC);
				printf("%s"
						,$row1['title_menu']);
			}
		}
		if(isset($_GET['id_news'])) {
			$title = (int)$_GET['id_news'];
			if(!$title) {
				echo 'Не правильные данные для вывода меню';
			}
			else {
				$query = "SELECT id_news,zagolovok FROM news WHERE id_news='$title'";
				$result = mysql_query($query);
				if(!$result) {
					exit(mysql_error());
				}
				$row = mysql_fetch_array($result,MYSQL_ASSOC);
				printf("%s"
						,$row['zagolovok']);
			}
		}
				
		echo '	
			</title>
			<script src="script/jquery.min.js" type="text/javascript"></script>
			<script src="script/other.js" type="text/javascript"></script>
			<script src="script/1.js" type="text/javascript"></script>
		</head>

		<body>
		<div id="headers"><a href="#"><img src="images/logo.jpg" alt="logo"/></a>
		<div class="clear"></div>
		</div>';
	}
		
	protected function get_menu() {
		$row = $this->menu_array();
		
		echo '<div class="cssmenu">
			<ul>';
		echo "<li><a href='?option=main'>Главное</a></li>";	
		
		foreach($row as $item) {
			printf("<li><a href='?option=menu&amp;id_menu=%s'>%s</a></li>
					",$item['id_menu'],$item['title_menu']);		
		}
		echo '</ul>
			<div class="clear"></div>
			</div>		
			<div class="clear"></div>';			
	}
	
	
	protected function get_menu_adaptive() {
		$row = $this->menu_array();
		
		echo '<div class="mobilenavcontainer"> 
			<div class="clear"></div>
			<div class="mobilenavigation">
			<ul id="mobilenav">';
		echo "<li><a href='?option=main' class='display'>Главное</a></li>";	
		foreach($row as $item) {
			printf("<li><a href='?option=menu&amp;id_menu=%s' class='display'>%s</a>
					",$item['id_menu'],$item['title_menu']);
				echo "</li>";				
		}
		echo '</ul> 
			<a href="#" id="pull">Menu</a>  
			</div> 
			<div class="clear"></div>
			</div>';			
	}
	
	protected function menu_array() {
		$query = "SELECT id_menu,title_menu FROM menu";
		$result = mysql_query($query);
		if(!$result) {
			exit(mysql_error());
		}
		
		$row = array();
		
		for($i = 0;$i < mysql_num_rows($result); $i++) {
			$row[] = mysql_fetch_array($result, MYSQL_ASSOC);
		}
		return $row;
	}
	
		
	protected function get_slider() {
	    $query = "SELECT news.id_news,news.images,news.zagolovok,news.anons,news.text,news.day_author,news.nomer,menu.title_menu,id FROM news,menu,images WHERE news.nomer=menu.id_menu AND images.id=news.images";
		$res = mysql_query($query);
		
		if(!$res) {
			exit(mysql_error());
		}
		$row = array();
		
		echo '<div id="wrapper">
			<div id="slider">
			<div class="slider_wrapper">
			<ul class="slider-article">';
		
		for($i = 0;$i < mysql_num_rows($res); $i++) {
			$row = mysql_fetch_array($res, MYSQL_ASSOC);
			printf("<li>
					<figure>
					<a href='?option=view&amp;id_news=".$row['id_news']."'>
					<img src='files/image.php?id=".$row['id']."' alt=''></a>
					<figcaption>
					<h3><a href='?option=view&amp;id_news=".$row['id_news']."'>".$row['zagolovok']."</a></h3>
					</figcaption>
					</figure>
					</li>"
					);
		}
		echo '</ul>
		</div>
		<a class="prev" href="#"><span>Назад</span></a>
		<a class="next" href="#"><span>Вперед</span></a>
		</div>';		
		
	}
		
	protected function get_sidebar() {
		echo "<div id='sidebar'>
		<section class='ac-container'>";
		
		$query = "SELECT id,title,text FROM mini";
		$result = mysql_query($query);
		if(!$result) {
			exit(mysql_error());
		}
		$row = array();
		for($i = 0; $i < mysql_num_rows($result);$i++) {
			$row = mysql_fetch_array($result,MYSQL_ASSOC);
			printf("<div>
				<input id='ac-$i'  type='checkbox' >
					<label for='ac-$i'>%s</label>
						<article class='ac-small'>
							<p>%s</p>
						</article>
			</div>",$row['title'],$row['text']);
		}
		echo "</section>
		</div>
		</div>
		</div>";
	}
	
	protected function get_footer() {
		echo "<div class='clear'></div>
		<footer><img src='images/valid_html.png' alt=''>
		<img src='images/vcss-blue.gif' alt=''>
		<p >
		<a class='b' href = '?option=admin'> Админ </a>
		</footer>
		</body>
		</html>";
	}
	
	
	
	public function get_body() {
	if($_POST) {
			$this->obr();
		}
		$this->get_header();
		$this->get_menu();
		$this->get_menu_adaptive();
		$this->get_slider();
		$this->get_content();
		$this->get_sidebar();
		$this->get_footer();
	}
	
	abstract function get_content();
	
}
?>