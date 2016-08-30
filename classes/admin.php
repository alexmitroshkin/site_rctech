<?php

class admin extends ACore_Admin {
	protected function obr() {
		
	}
	
	public function get_content() {
		
		$query = "SELECT id_news,zagolovok FROM news";
		$result = mysql_query($query);
		if(!$result) {
			exit(mysql_error());
		}
		
		echo '<div id="contain">';
		echo "<h1>Административная панель</h1>";
		echo "<h2 class='title'><a style='color:red' href='?option=add_news'>Добавить новую новость</a></h2>
			<h2 class='title'><a style='color:red' href='?option=pasteimage'>Добавить новое изображение</a></h2><hr>";
		
		
		if (isset($_GET['logout'])) {
			unset($_SESSION['res']);
			echo 'Выход успешен';
		}
		
		echo '<div id="con">';
		$row = array();
		for($i = 0; $i < mysql_num_rows($result);$i++) {
			$row = mysql_fetch_array($result,MYSQL_ASSOC);
			printf("<div class='post'>
				<div class='col'>
				<div class='articl'>
				<h2 class='title'>
				<a class='a' href='?option=update_news&amp;id_news=".$row['id_news']."'>".$row['zagolovok']."</a> | <a style='color:red' href='?option=delete_news&amp;delete=".$row['id_news']."'>Удалить</a>
				</h2>
				<div class='clear'></div>
				</div>
				</div>
				</div>");
		}
		echo '</div>';
		
		
		echo "<a href='?option=logout'>Выйти</a>
		</div>";
	}
}
?>