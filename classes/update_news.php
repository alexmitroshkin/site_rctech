<?php

class update_news extends ACore_Admin {
	
	protected function obr() {
		
		$image = $_POST['image'];		
		$id_news =  $_POST['id_news'];
		$zagolovok =  $_POST['zagolovok'];
		$anons =  $_POST['anons'];
		$text =  $_POST['text'];
		$day_author =  $_POST['day_author'];
		$nomer =  $_POST['nomer'];
		
		if(empty($zagolovok) || empty($anons) || empty($text) || empty($day_author) || empty($nomer)) {
			exit("Не заполнены обязательные поля");
		}
		$query = "UPDATE  news SET images='$image',zagolovok='$zagolovok',anons='$anons',text='$text',day_author='$day_author',nomer='$nomer' WHERE id_news='$id_news'";
		if(!mysql_query($query)) {
			exit(mysql_error());
		}
		else {
			$_SESSION['res'] = "Изменения сохранены";
			header("Location:?option=admin");
			exit;
		}			
	}
	
	public function get_content() {
		
		if(isset($_GET['id_news'])){
			$id_news = (int)$_GET['id_news'];
		}
		else {
			exit ('Не правильные данные для этой страницы');
		}
		$news = $this->get_text_news($id_news);
		
		echo '<div id="wrapper">
		<div id="contain">';
		echo '<div id="con">';
		if($_SESSION['res']) {
			echo $_SESSION['res'];
			unset($_SESSION['res']);
		}
		$nomer = $this->get_news();
		$image = $this->get_image();
print <<<HEREDOC
<form enctype='multipart/form-data' action='?option=update_news' method='POST'>
<p>Заголовок статьи:<br />
<input type='text' name='zagolovok' style='width:420px;' value='$news[zagolovok]'>
<input type='hidden' name='id_news' style='width:420px;' value='$news[id_news]'>

<p>Изображение:
<p><select name='image'>
HEREDOC;
foreach($image as $item) {
		if($news['images'] == $item['id']) {
		echo "<option selected value='".$item['id']."'>".$item['id']."</option>";
		}
		else {
			echo "<option value='".$item['id']."'>".$item['id']."</option>";
		}
	}
	echo "</select></p>";
print <<<HEREDOC
<p>Краткое описание:
<p><textarea name='anons' cols='50' rows='7'>$news[anons]</textarea></p>

<p>Текст:
<p><textarea name='text' cols='50' rows='7'>$news[text]</textarea></p>

<p>День и автор:
<p><input type='text' name='day_author' style='width:420px;' value='$news[day_author]'></p>
<input type='hidden' name='day_author' style='width:420px;' value='$news[day_author]'>
<p><select name='nomer'>
HEREDOC;
foreach($nomer as $item) {
	if($news['nomer'] == $item['id_menu']) {
		echo "<option selected value='".$item['id_menu']."'>".$item['title_menu']."</option>";
	}
	else {
		echo "<option value='".$item['id_menu']."'>".$item['title_menu']."</option>";
	}
}
	echo "</select></p>
		<p><input type='submit' name='button' value='Сохранить'></p></form>";
	echo"</div>
		 </div>
		 </div>";
	}
}
?>