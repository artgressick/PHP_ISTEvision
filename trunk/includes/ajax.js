function startAjax() {
	var ajax = false;
	try { 
		ajax = new XMLHttpRequest(); // Firefox, Opera 8.0+, Safari
	} catch (e) {
	    // Internet Explorer
	    try { ajax = new ActiveXObject("Msxml2.XMLHTTP");
	    } catch (e) {
			try { ajax = new ActiveXObject("Microsoft.XMLHTTP");
	        } catch (e) {
	        	alert("Your browser does not support AJAX!");
	        }
	    }
	}
	return ajax;
}

/*

// This is just an example of a ajax function
function check_in_product(bf, tracking) {
	ajax = startAjax();
	var address = bf + "ajax_delete.php?postType=checkin&tracking=" + tracking;
	if(ajax) {
		ajax.open("GET", address);
		ajax.onreadystatechange = function() { 
			if(ajax.readyState == 4 && ajax.status == 200) { 
//				alert(ajax.responseText);
				var result=ajax.responseText;
				if(result != '') { //saved
					document.getElementById('errors').innerHTML = result;
					document.getElementById('tracking_number').value = '';
					document.getElementById('tracking_number').focus();
				} else { // error
					document.getElementById('tracking_number').value = '';
					document.getElementById('tracking_number').focus();
				}
			} 
		} 
		ajax.send(null); 
	}
}
*/

function add_comment(bf,video_id,field) {
	ajax = startAjax();
	var comment = document.getElementById(field).value;
//	comment = comment.replace("'",'&#39;');
//	comment = comment.replace('"','&quot');
	
	var address = bf + "ajax_functions.php?function=add_comment&video_id=" + video_id + "&comment=" + comment;
	if(ajax) {
		ajax.open("GET", address);
		ajax.onreadystatechange = function() { 
			if(ajax.readyState == 4 && ajax.status == 200) { 
//				alert(ajax.responseText);
				var result=ajax.responseText;
				if(result != '') { //saved
					get_comments(bf,video_id);
					document.getElementById('comment').value = '';
					char_counter('comment', 'char_count', 500);
					alert('Thanks, your comment has been added.');
				} else { // error
					alert('An unknown error has occurred while trying to add your comment.');
				}
			} 
		} 
		ajax.send(null); 
	}
	
}

function get_comments(bf,video_id) {
	ajax = startAjax();
//	comment = comment.replace("'",'&#39;');
//	comment = comment.replace('"','&quot');
	
	var address = bf + "ajax_functions.php?function=get_comments&video_id=" + video_id;
	if(ajax) {
		ajax.open("GET", address);
		ajax.onreadystatechange = function() { 
			if(ajax.readyState == 4 && ajax.status == 200) { 
//				alert(ajax.responseText);
				var result=ajax.responseText;
				if(result != '') { //saved
					document.getElementById('comments').innerHTML = result;
				}
			} 
		} 
		ajax.send(null); 
	}

}

function hide_comment(bf,id,video_id) {
	ajax = startAjax();
//	comment = comment.replace("'",'&#39;');
//	comment = comment.replace('"','&quot');

	var address = bf + "ajax_functions.php?function=hide_comment&id=" + id;
	if(ajax) {
		ajax.open("GET", address);
		ajax.onreadystatechange = function() { 
			if(ajax.readyState == 4 && ajax.status == 200) { 
//				alert(ajax.responseText);
				var result=ajax.responseText;
				if(result != '') { //saved
					get_comments(bf,video_id)
				}
			} 
		} 
		ajax.send(null); 
	}

}

function show_comment(bf,id,video_id) {
	ajax = startAjax();
//	comment = comment.replace("'",'&#39;');
//	comment = comment.replace('"','&quot');
	
	var address = bf + "ajax_functions.php?function=show_comment&id=" + id;
	if(ajax) {
		ajax.open("GET", address);
		ajax.onreadystatechange = function() { 
			if(ajax.readyState == 4 && ajax.status == 200) { 
//				alert(ajax.responseText);
				var result=ajax.responseText;
				if(result != '') { //saved
					get_comments(bf,video_id)
				}
			} 
		} 
		ajax.send(null); 
	}

}