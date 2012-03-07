<?php

	require("db_login.php");
	
	if(!isset($_POST['title']) || !isset($_POST['author']) || !isset($_POST['image_url']) )
	{
		die("Some parameter was not set");
	}
	
	$title = mysql_real_escape_string($_POST['title']);
	$author = mysql_real_escape_string($_POST['author']);
	$url = mysql_real_escape_string($_POST['image_url']);
	
	if(strlen($title) > 128 || strlen($author) > 128 || strlen($image_url) > 512)
	{
		die("Title, author name or url is too long");
	}
	
	$query = sprintf("INSERT INTO cs179.books(author, title, image_url) VALUES ('$author', '$title', '$url')");
	mysql_query($query);
	
	echo json_encode(mysql_insert_id());
?>