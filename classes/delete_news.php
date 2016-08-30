<?php

class delete_news extends ACore_Admin {
	public function obr() {
		if(isset($_GET['delete'])) {
			$id_news = (int)$_GET['delete'];
			
			$query = "DELETE FROM news WHERE id_news='$id_news'";
			
			if(mysql_query($query)) {
				$_SESSION['res'] = "Удалено";
				header("Location:?option=admin");
				exit();
			}
			else {
				exit("Ошибка удаления");
			}
		}
		else {
			exit("Не верные данные для этой страницы");
		}
	}
	
	public function get_content() {
		
	}
}
?>