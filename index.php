<?php
	require("db_login.php");
	
	// TODO 1: Set a query that would return all the posts from the table
	$query = "SELECT * FROM cs179.books";
	
	// TODO 3: Change query to filter posts by if the keyword is found in the comments associated with the post
	
	// TODO 1: Perform query
	$results = mysql_query($query);
	
?>
<!DOCTYPE html>

<html>

<head>
	<title>Book club</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.0.1/jquery.mobile-1.0.1.min.css" />
	<link rel="stylesheet" type="text/css" href="style.css" />
	<script src="http://code.jquery.com/jquery-1.6.4.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.0.1/jquery.mobile-1.0.1.min.js"></script>
	<script src="operator.js" type="text/javascript"></script>
</head>

<body>
	<div data-role="page">
		<div id='wrapper'>
			<div data-role="header">
				<h1>Welcome to the Book club!</h1>
			</div>
			<div data-role="content">
				<form id="addbook" name="addbook">
					<input type="text" id="title" name="title" placeholder="Title" /> <br />
					<input type="text" id="author" name="author" placeholder="Author" /> <br />
					<input type ="text" id="url" name="url" placeholder="Picture URL (optional)"/> <br />
					<input type="submit" value="Add book" />
				</form>
			<br>
			<hr>
			<h2>Recommended books</h2>
			
				<?php
					// TODO 1: Display every result from the query with title linked to url, and description	
					while ($row = mysql_fetch_array($results)) {
						$id = $row['uid'];
						$author = $row['author'];
						$title = $row['title'];
						$url = $row['image_url'];
						$comments = mysql_query("SELECT * FROM cs179.comments WHERE book_uid =".$id);
						$num_com = mysql_num_rows($comments);
						print("<hr><div class='checks' id='check".$id."'>");
						print("<img src=".$url." height=\"100\" width=\"70\"></img><br><br><span class='titles'> ".$title."</span><br><span class='authors'>Written by: ".$author."</span><br><label class='styled'><input type='checkbox' id=\"checkbox".$id."\" name=\"checkbox".$id."\" onclick='checkFunction(this, ".$id.")' class='styled'>Store as favorite</label><br>");
						print("<button type=\"button\" onclick='removeBook(".$id.")'>Remove \"".$title."\"</button>");

						print("<p style=\"display:inline\" ><a href=\"\" onclick=\"return displayComments(".$id.")\">".$num_com." comment(s)</a></p>");
						print("<div id=\"comments".$id."\">");
						print("<div class='comments'>");
						while($num_com > 0 && $comment = mysql_fetch_array($comments)) {
							print ("<p class=\"comment".$id."\">".$comment['comment']."</p>");
						}
						print("</div>");
						print("<div class='form_pack'>");
						$comment_form = "<form id=\"form".$id."\" class=\"comment_form\"><input type='text' id='formcom".$id."' class=\"comment_c\" placeholder='Add comment here'/><input type='hidden' class='hidID' value='".$id."'><input id=\"formsub".$id."\" type='submit' value='Add comment' /></form>";
						print($comment_form);
						print("<br></div></div></div>");
					}
				?>
			</div>
		</div>
	</div>
</body>

</html>