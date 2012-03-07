

$(document).ready(function() {
	
	// Check for favourites in local storage
	var array = JSON.parse(localStorage.getItem('normann'));
	//console.log(array);
	if (array != null) {
		for (var i = 0; i < array.length; i++) {
			// If a book is stored, then check it and set background-color to green
			$("#checkbox" + array[i]).attr('checked','checked');
			$("#check" + array[i]).css('background-color', '#00CC33');
		}
	}
	
	// Handler of comment adding form
	var forms = $("form.comment_form");
	forms.submit(function() {
		var $this = $(this);
		var comment = $this.find(".comment_c").val();
		var book_id = $this.find(".hidID").val();
		
		
		$this.find(".comment_c").val("");
		
		// Check if comment is blank or if book id is invalid
		if (comment === "" || book_id < 1) {
			alert("Sorry buddy, no blank comments!");
			return false;
		}
		
		$.ajax({
			// Add comment
			url: "add_comments.php",
			type: "POST",
			data: {book_uid:book_id, comment:comment},
			success: function() {
				var $comment = $("<p class=\"comment" + book_id + "\">" + comment + "</p>");
				$("#comments" + book_id).children('.comments').append($comment);
				$comment.show();
			}
		});
		return false;
	});
	
	// Add book form
	var form = $("#addbook");
	form.submit(function() {
		
		var title_var = $("#title").val();
		var author_var = $("#author").val();
		var url_var = $("#url").val();
		
		// Make sure that there is a title and an author
		if (title_var === "" || author_var === "") {
			alert("Dude, you forgot either title and/or author!");
			return false;
		}
		
		$.ajax({
			// Add book to database
			url: "add_books.php",
			type: "POST",
			data: {author:author_var, title:title_var, image_url:url_var},
			success: function(data) {
				$("#wrapper").append("<hr><div class='checks' id='check" + data + "'>")
				$("#wrapper").append("<p><img src=\"" + url_var + "\" height=\"100\" width=\"50\"></img>" + title_var + "<br>Written by: " + author_var + "</p>");
				$("#wrapper").append("<button type=\"button\" onClick='removeBook(" + data + ")'>Remove \"" + title_var + "\"</button>")
				$("#wrapper").append("<p><a href=\"\" onClick=\"return displayComments(" + data + ")\">0 comment(s)</a></p>");
				$("#wrapper").append("<div id='comments" + data + "'><div class='comments'></div><div class='form_pack'>");
				$("#wrapper").append("<form id=\"form" + data + "\" class=\"comment_form\"><input type='text' id='formcom" + data + "' class=\"comment_c\" placeholder='Add comment here'/><input type='hidden' class='hidID' value='" + data + "'><input id=\"formsub" + data + "\" type='submit' value='Add comment' /></form></div></div></div>");
			}
		});
		
		return false;	
	});
});

function removeBook(id) {
	if (id < 1) {
		return false;
	}
	// Remove book from database
	$.ajax({
		url: "remove_book.php",
		type: "POST",
		data: {uid:id},
	});
	// Hide displayed book
	$("#check" + id).hide();
	return false;
}

function checkFunction(checkbox, id) {
	// Change background color and store favourite in local storage
	if (checkbox.checked) {
		$("#check" + id).css('background-color', '#00CC33');
		if(typeof(localStorage) === 'undefined') {
			alert("You do not support local storage!");
		} else {
			try{
				var array = JSON.parse(localStorage.getItem('normann'));
				if (array == null) {
					array = [id];
				} else {
					array.push(id);
				}
				localStorage.setItem('normann', JSON.stringify(array));
			} catch (e) {
				alert("Local storage went wrong");
			}
		}
	} else {
		$("#check" + id).css('background-color', 'transparent');
		try {
			var array = JSON.parse(localStorage.getItem('normann'));
			if(array != null) { 
				console.log(array);
				var j = -1;
				for (var i = 0; i < array.length; i++) {
					if (array[i] == id) {
						j = i;
					}
				}
				if (j > -1) {
					array.splice(j, 1);
				}
				if (array == null) {
					localStorage.clear();
				} else {
					localStorage.setItem('normann', JSON.stringify(array));
				}
			}
		} catch (e) {
			alert("Local storage went wrong");
		}
	}
	return false;
}


function displayComments(id) {
	// Show or hide comments
	if ($("#form" + id).css('display') === "none") {
		$(".comment" + id).show();
		$("#form" + id).show();
		$("#form" + id).children().show();
		$("#form" + id).children().children().show();
		$("#form" + id).children().children().children().show();
	} else {
		$(".comment" + id).hide();
		$("#form" + id).hide();
	}
	return false;
}
