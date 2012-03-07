<form id="addcomment" name="addcomment">
	<textarea cols="3" rows="15" id="comment" name="comment" placeholder="Add your comment here"></textarea></br>
	<input type="hidden" id="bookid" name="bookid" value=\"".$id."\">
	<input type="submit" value="Add comment" />
</form>

<script src="http://code.jquery.com/mobile/1.0.1/jquery.mobile-1.0.1.min.js" type="text/javascript"></script>

var form = $("#addcommment");

form.submit(function() {
	var comment_var = $("#comment");
	var book_id =$("#bookid");
	
	$.ajax({
		url: "add_comments.php",
		type: "POST",
		data: {book_uid:book_id, comment:comment_var},
		success: function() {
			var p = $("<p>").text(comment);
			$("#comment" + book_id);
		}
	});
	
	return false;
	
})