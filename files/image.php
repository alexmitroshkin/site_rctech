<?php
include 'config_image.php';
if(isset($_GET['id'])){
	$id = (int)$_GET['id'];
	if ($id > 0) {
		$query = "SELECT image,type FROM images WHERE id=".$id."";
		$type = mysql_fetch_array(mysql_query($query));
		$res = mysql_query($query);
		if (mysql_num_rows($res) == 1) {
			$image = mysql_fetch_array($res);
			header("Content-type:image/".$type['type']."");
			echo $image['image'];
		}
	}
}
?>