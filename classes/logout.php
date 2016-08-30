<?php
class logout extends ACore {
	public function get_content() {
		$_SESSION = array();
		session_destroy();
		echo "Выход успешен";
	}
}	
?>