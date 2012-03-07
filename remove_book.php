<?php

	require("db_login.php");
	
	if(!isset($_POST['uid']))
	{
		die("This is not a book");
	}
	
	$uid = mysql_real_escape_string($_POST['uid']);
	
	$query = sprintf("DELETE FROM cs179.books WHERE uid='$uid'");
	mysql_query($query);
	
	echo json_encode("Done");
//	echo json_encode(mysql_insert_id());
?>