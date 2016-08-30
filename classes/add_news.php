<?php

class add_news extends ACore_Admin {
	
	protected function obr() {
	
		
		$image = $_POST['image'];
		$zagolovok = $_POST['zagolovok'];
		$anons = $_POST['anons'];
		$text = $_POST['text'];
		$day_author = $_POST['day_author'];
		$nomer = $_POST['nomer'];
		
		if(empty($zagolovok) || empty($anons) || empty($text) || empty($day_author) || empty($nomer)) {
			exit("Не заполнены обязательные поля");
		}
		$query = " INSERT INTO `rctech`.`news`
						(`id_news`, `images`, `zagolovok`, `anons`, `text`, `day_author`, `nomer`) 
					VALUES (NULL,'$image','$zagolovok','$anons','$text','$day_author','$nomer')";
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
		echo '<div id="wrapper">
		<div id="contain">';
		echo '<div id="con">';
		if(isset($_SESSION['res'])) {
			echo $_SESSION['res'];
			unset($_SESSION['res']);
		}
		$nomer = $this->get_news();
		$image = $this->get_image();
		
print <<<HEREDOC
<form enctype='multipart/form-data' action='?option=add_news' method='POST'>

<p>Заголовок статьи:
<p><input type='text' name='zagolovok' style='width:420px;'></p>

<p>Изображение:
<p><select name='image'>
HEREDOC;
foreach($image as $item) {
		echo "<option value='".$item['id']."'>".$item['id']."</option>";
	}
	echo "</select></p>";
print <<<HEREDOC
<p>Краткое описание:
<p><textarea name='anons' cols='50' rows='7'></textarea></p>

<p>Текст:
<p><textarea name='text' cols='50' rows='7'></textarea></p>

<p>День и автор:
<p><input type='text' name='day_author' style='width:420px;'></p>

<p><select name='nomer'>
HEREDOC;

	foreach($nomer as $item) {
		echo "<option value='".$item['id_menu']."'>".$item['title_menu']."</option>";
	}
			echo "</select></p>
			<p><input type='submit' name='button' value='Сохранить'></p></form>";
			echo"</div>
				 </div>
				 </div>";
	}
}
?>