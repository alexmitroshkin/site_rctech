<?php
class menu extends ACore {
	
	public function get_content() {
		echo '<div id="container">';
		if(!$_GET['id_menu']) {
			echo 'Не правильные данные для вывода меню';
		}
		else {
			$id_menu = (int)$_GET['id_menu'];
			if(!$id_menu) {
				echo 'Не правильные данные для вывода меню';
			}
			else {
				$query1 = "SELECT id_menu,title_menu FROM menu WHERE id_menu='$id_menu'";
				$result1 = mysql_query($query1);
				if(!$result1) {
					exit(mysql_error());
				}
				$row1 = mysql_fetch_array($result1,MYSQL_ASSOC);
				printf("<h1>%s</h1>"
						,$row1['title_menu']);
			}
			
		}
		echo '<div id="content">';
		$query = "SELECT id,id_news,images,zagolovok,anons,text,day_author,nomer FROM news,images WHERE news.nomer='$id_menu' AND images.id=news.images ORDER BY day_author ASC";
		$result = mysql_query($query);
		if(!$result) {
			exit(mysql_error());
		}
		$row = array();
		for($i = 0; $i < mysql_num_rows($result);$i++) {
			$row = mysql_fetch_array($result,MYSQL_ASSOC);
			printf("<div class='post_box'>
				<div class='one_col'>
				<div class='articleinner'>
				<div class='thumbnailarea'>
				<a class='thumblink' title='Открыть ".$row['zagolovok']."' href='?option=view&amp;id_news=".$row['id_news']."'>
				<img src='files/image.php?id=".$row['id']."' alt='основная картинка'></a>
				</div>
				<h2 class='indextitle'>
				<a class='a' href='?option=view&amp;id_news=".$row['id_news']."' title='Открыть ".$row['zagolovok']."'>".$row['zagolovok']."</a>
				</h2>
				<span class='date'>".$row['day_author']."</span>
				".$row['anons']."
				<p style='text-align: justify;'><a rel='nofollow' href='?option=view&amp;id_news=".$row['id_news']."' class='more-link'><span class='more-link'>Под кат!</span></a></p>
				<div class='clear'></div>
				</div>
				</div>
				</div>");
		}
		echo '</div>';
	

	
			
	}
}
?>