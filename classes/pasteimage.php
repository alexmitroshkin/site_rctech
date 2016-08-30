<?php
class pasteimage extends ACore_Admin {
	protected function obr() {
		// Проверяем пришел ли файл
		if( !empty( $_FILES['image']['name'] ) ) {
		  // Проверяем, что при загрузке не произошло ошибок
		  if ( $_FILES['image']['error'] == 0 ) {
			// Если файл загружен успешно, то проверяем - графический ли он
			if( substr($_FILES['image']['type'], 0, 5)=='image' ) {
			  // Читаем содержимое файла
			  $image = file_get_contents( $_FILES['image']['tmp_name'] );
			  // Экранируем специальные символы в содержимом файла
			  $image = mysql_escape_string( $image );
			  // Формируем запрос на добавление файла в базу данных
			$type = $_POST['type'];
			$query=" INSERT INTO `rctech`.`images` (`id`, `image`, `type`) VALUES(NULL, '$image','$type')";
			}//echo "Запись добавлена <p><a href='admin.php'>назад</a>";
		  }
		}
		else {
			exit("Необходимо загрузить изображение");
		}
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
print <<<HEREDOC
<form enctype='multipart/form-data' action='?option=pasteimage' method='POST'>


<p>Изображение:
<p><input type='file' name='image'></p>
<p>Расширение:
<p><select name='type'>
<option value="jpeg">jpeg</option>
<option value="gif">gif</option>
<option value="png">png</option>
</select></p>
HEREDOC;
			echo "<p><input type='submit' name='button' value='Сохранить'></p>
			<p><a href='?option=admin'>назад</a></form>";
			echo"</div>
				 </div>
				 </div>";
	}
}	
?>