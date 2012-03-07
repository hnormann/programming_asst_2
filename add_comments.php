<?php

	require("db_login.php");
	
	if(!isset($_POST['book_uid']) || !isset($_POST['comment']) )
	{
		die("Some parameter was not set");
	}
	
	$book_uid = mysql_real_escape_string($_POST['book_uid']);
	$comment = mysql_real_escape_string($_POST['comment']);
	
	if(strlen($book_uid) > 16 || strlen($comment) > 512)
	{
		die("Unknown book or comment is too long");
	}
	
	$query = sprintf("INSERT INTO cs179.comments(book_uid, comment) VALUES ('$book_uid', '$comment')");
	mysql_query($query);
	
	header("Location: index.php");
	
?>