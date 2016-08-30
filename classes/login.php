<?php
class login extends ACore {
		
	protected function obr() {
		$login = strip_tags(mysql_real_escape_string($_POST['login']));
		$password = strip_tags(mysql_real_escape_string($_POST['password']));
		
		if(!empty($login) AND !empty($password)) {
			$password = md5($password);
			
			$query = "SELECT id FROM users WHERE login='$login' AND password = '$password'";
			
			$result = mysql_query($query);
			
			if(!$result) {
				exit(mysql_error());
			} 
			
			if(mysql_num_rows($result) == 1) {
				$_SESSION['user'] = TRUE;
				header("Location:?option=admin");
				exit();
			}
			else {
				exit("такого пользователя нет");
			}
			
		}
		else {
			exit("Заполните обязательные поля");
		}
	}
	
	
	public function get_content() {
		
		
		echo '<div id="container">';
		echo "<h1>Авторизация</h1>";
		echo '<div id="content">';
print <<<HEREDOC
<form id='for' enctype='multipart/form-data' action='' method='POST'>
<p>Логин:
<p><input type='text' name='login'></p>

<p>Пароль:
<p><input type='password' name='password'></p>

<p><input type='submit' name='button' value='Сохранить'></p></form>
HEREDOC;
		echo"</div>
			";
	}
}
?>