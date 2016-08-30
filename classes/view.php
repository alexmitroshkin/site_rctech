<?php
class view extends ACore {
	
	public function get_content() {
		echo '<div id="container">';
		
		if(!$_GET['id_news']) {
			echo 'Не правильные данные для вывода статьи';
		}
		else {
			$id_news = (int)$_GET['id_news'];
			if(!$id_news) {
				echo 'Не правильные данные для вывода статьи';
			}
			else {
				$query1 = "SELECT id_news, zagolovok FROM news WHERE id_news='$id_news'";
				$result1 = mysql_query($query1);
				if(!$result1) {
					exit(mysql_error());
				}
				$row1 = mysql_fetch_array($result1,MYSQL_ASSOC);
				printf("<h1>%s</h1>"
						,$row1['zagolovok']);
			}
		}
		echo '<div id="content">';
		$query = "SELECT id,id_news,images,zagolovok,text,day_author,nomer 
		FROM news,images 
		WHERE id_news='$id_news' AND images.id=news.images";
		$result = mysql_query($query);
		if(!$result) {
			exit(mysql_error());
		}
		else{
		$row = mysql_fetch_array($result,MYSQL_ASSOC);
		print("<div class='post_box'>
				<div class='one_col'>
				<div class='articleinner'>
				<div class='thumbnailarea'>
				<a class='a'><img src='files/image.php?id=".$row['id']."' alt=''></a>
				</div>
				<h2 class='indextitle'>
				</h2>
				<span class='date'>".$row['day_author']."</span>
				".$row['text']."
				<div class='clear'></div>
				</div>
				</div>
				</div>");
		}		
		echo '</div>';
	}
}
?>