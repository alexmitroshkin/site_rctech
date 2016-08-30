<?php
class main extends ACore {

	public function get_content() {
		echo '<div id="container">';
		echo "<h1>Главное</h1>";
		
		
		
		echo '<div id="content">';
		$query = "SELECT id,news.id_news,news.images,news.zagolovok,news.anons,news.text,news.day_author,news.nomer,menu.title_menu 
		FROM news,menu,images 
		WHERE news.nomer=menu.id_menu AND images.id=news.images ORDER BY day_author ASC";
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