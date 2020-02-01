//dtn:  Set up the Ajax connections

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

//dtn: This is the revert for the Warning Overlay page... it turns it from the dark background back to the normal view.
function revert() {
	document.getElementById('overlaypage').style.display = "none";
	document.getElementById('warning').style.display = "block";
}

//dtn: This is the warning window.  It sets up the gay overlay background with the window in the middle asking if you are sure you want to deleted whatever.
function warning(id,val1,chrKEY,val2,count) {

	// This specifically finds the height of the entire internal window (the page) that you are currently in.
	if( typeof( window.innerWidth ) == 'number' ) {
		//Non-IE
		myWidth = window.innerWidth;
		myHeight = window.innerHeight;
	} else if( document.documentElement && ( document.documentElement.clientWidth || document.documentElement.clientHeight ) ) {
		//IE 6+ in 'standards compliant mode'
		myWidth = document.documentElement.clientWidth;
		myHeight = document.documentElement.clientHeight;
	} else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) {
		//IE 4 compatible
		myWidth = document.body.clientWidth;
		myHeight = document.body.clientHeight;
	}

	// This specifically find the SCROLL height.  Example, you have scrolled down 200 pixels
	if( typeof( window.pageYOffset ) == 'number' ) {
		//Netscape compliant
		scrOfY = window.pageYOffset;
		scrOfX = window.pageXOffset;
	} else if( document.body && ( document.body.scrollLeft || document.body.scrollTop ) ) {
		//DOM compliant
		scrOfY = document.body.scrollTop;
		scrOfX = document.body.scrollLeft;
	} else if( document.documentElement && ( document.documentElement.scrollLeft || document.documentElement.scrollTop ) ) {
		//IE6 standards compliant mode
		scrOfY = document.documentElement.scrollTop;
		scrOfX = document.documentElement.scrollLeft;
	} else {
		scrOfY = 0;
		scrOfX = 0;
	}

	// document.body.scrollHeight <-- Finds the entire SCROLLable height of the document.
	if (window.innerHeight && window.scrollMaxY) { // Firefox
		document.getElementById('gray').style.height = (window.innerHeight + window.scrollMaxY) + "px";
	} else if (document.body.scrollHeight > document.body.offsetHeight){ // all but Explorer Mac
		document.getElementById('gray').style.height = yWithScroll = document.body.scrollHeight + "px";
	} else { // works in Explorer 6 Strict, Mozilla (not FF) and Safari
		document.getElementById('gray').style.height = document.body.scrollHeight + "px";
  	}

	document.getElementById('gray').style.width = (myWidth + scrOfX) + "px";
	
//	if(scrOfY != 0) {
		document.getElementById('message').style.top = scrOfY+"px";
//	} 
	
	document.getElementById('delName').innerHTML = val1;
	document.getElementById('idDel').value = id;
	document.getElementById('chrKEY').value = chrKEY;
	document.getElementById('overlaypage').style.display = "block";
	document.getElementById('tblName').value = val2;
	document.getElementById('tblcount').value = count;
}

//dtn: This is the basic delete item script.  It uses GET's instead of Posts
function delItem(address) {
	var id = document.getElementById('idDel').value;
	var chrKEY = document.getElementById('chrKEY').value;
	ajax = startAjax();
	
	if(ajax) {
		ajax.open("GET", address + id + "&chrKEY=" + chrKEY);
	
		ajax.onreadystatechange = function() { 
			if(ajax.readyState == 4 && ajax.status == 200) { 
				showNotice(id,ajax.responseText);
				// alert(ajax.responseText);
			} 
		} 
		ajax.send(null); 
	}
} 

//dtn: This is used to erase a line from the sort list.
function showNotice(id, type) {
	var tbl = '';
	tbl = document.getElementById('tblName').value;
	var count = document.getElementById('tblcount').value;
	//alert(tbl + 'tr' + id + count);
	document.getElementById(tbl + 'tr' + id + count).style.display = "none";
	if(document.getElementById('resultCount')) {
		var rc = document.getElementById('resultCount');
		rc.innerHTML = parseInt(rc.innerHTML) - 1;
	}
	
	repaint(tbl);
	revert();
}

//dtn: This is the quick delete used on the sort list pages.  It's the little hoverover x on the right side.
function quickdel(address, idEntity, fatherTable, attribute) {
	ajax = startAjax();
	
	if(ajax) {
		ajax.open("GET", address);
	
		ajax.onreadystatechange = function() { 
			if (ajax.readyState == 4 && ajax.status == 200) { 
				alert(ajax.responseText);
				document.getElementById(fatherTable + 'tr' + idEntity).style.display = "none";
				repaintmini(fatherTable);
			} 
		} 
		ajax.send(null); 
	}
} 

//dtn: Function added to get rid of the first line in the sort columns if there are no values in the sort table yet.
//		Ex: "There are no People in this table" ... that gets erased and replaced with a real entry
function noRowClear(fatherTable) {
	var val = document.getElementById(fatherTable).getElementsByTagName("tr");
	if(val.length <= 2 && val[1].innerHTML.length < 100) {
		var tmp = val[0].innerHTML
		document.getElementById(fatherTable).innerHTML = "";
		document.getElementById(fatherTable).innerHTML = tmp;
	}
}

//dtn: This is the main function to POST information through Ajax
function postInfo(url, parameters) {
	ajax = startAjax();
	ajax.open('POST', url, true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.setRequestHeader("Content-length", parameters.length);
	ajax.setRequestHeader("Connection", "close");
	ajax.send(parameters);
	
	ajax.onreadystatechange = function() { 
   		if(ajax.readyState == 4 && ajax.status == 200) {
			//alert(ajax.responseText);
   			//document.getElementById('showinfo').innerHTML = ajax.responseText;
   		}
  	}
}

function IsNumeric(sText) {
	var ValidChars = "0123456789.";
	var IsNumber=true;
	var Char;
	for (i = 0; i < sText.length && IsNumber == true; i++) { 
		Char = sText.charAt(i); 
		if (ValidChars.indexOf(Char) == -1) {
			IsNumber = false;
		}
	}
	return IsNumber;
}

function IsWhole(sText) {
	var ValidChars = "0123456789";
	var IsNumber=true;
	var Char;
	for (i = 0; i < sText.length && IsNumber == true; i++) { 
		Char = sText.charAt(i); 
		if (ValidChars.indexOf(Char) == -1) {
			IsNumber = false;
		}
	}
	return IsNumber;
}



function update_server_time(bf) {
	ajax = startAjax();
	var address = bf + "ajax_delete.php?postType=gettime";

	if(ajax) {
		ajax.open("GET", address);
		ajax.onreadystatechange = function() { 
			if(ajax.readyState == 4 && ajax.status == 200) { 
//				alert(ajax.responseText);
				var servertime = ajax.responseText;
				document.getElementById('server_time').value = servertime;
			} 
		} 
		ajax.send(null); 
	}
}

function getcurrentevent(bf) {
	ajax = startAjax();
	var address = bf + "ajax_delete.php?postType=getcurrentevent";
		
	if(ajax) {
		ajax.open("GET", address);
		ajax.onreadystatechange = function() { 
			if(ajax.readyState == 4 && ajax.status == 200) { 
//				alert(ajax.responseText);
				document.getElementById('current_event').innerHTML = ajax.responseText;
				getupcomingevents(bf,document.getElementById('end_time').value);
			} 
		} 
		ajax.send(null); 
	}
}

function getupcomingevents(bf,endtime) {
	ajax = startAjax();
	var address = bf + "ajax_delete.php?postType=getupcomingevents&endtime=" + endtime;

	if(ajax) {
		ajax.open("GET", address);
		ajax.onreadystatechange = function() { 
			if(ajax.readyState == 4 && ajax.status == 200) { 
//				alert(ajax.responseText);
                
				document.getElementById('TickerVertical').innerHTML = ajax.responseText;
			} 
		} 
		ajax.send(null); 
	}
}

function getserverdate(bf) {
	ajax = startAjax();
	var address = bf + "ajax_delete.php?postType=getdate";

	if(ajax) {
		ajax.open("GET", address);
		ajax.onreadystatechange = function() { 
			if(ajax.readyState == 4 && ajax.status == 200) { 
//				alert(ajax.responseText);
				var servertime = ajax.responseText;
				document.getElementById('server_time').value = servertime;
			} 
		} 
		ajax.send(null); 
	}
}

function getjsonevents(bf,location_id) {
	ajax = startAjax();
	var address = bf + "ajax_delete.php?postType=getevents&location_id="+location_id;

	if(ajax) {
		ajax.open("GET", address);
		ajax.onreadystatechange = function() { 
			if(ajax.readyState == 4 && ajax.status == 200) { 
//				alert(ajax.responseText);
				//var servertime = ajax.responseText;
				myJSONevents = ajax.responseText;
				eval(myJSONevents);
				
				if(JSONevents.current) {
					document.getElementById('cevent_title').innerHTML = JSONevents.current.title;
					document.getElementById('cevent_presenter').innerHTML = JSONevents.current.presenter;
					document.getElementById('cevent_times').innerHTML = JSONevents.current.times;
					document.getElementById('cevent_description').innerHTML = JSONevents.current.description;
					document.getElementById('no_event').style.display = 'none';
					document.getElementById('inner_current').className = 'innerbody';
					document.getElementById('current_event').style.display = '';
				} else {
					document.getElementById('current_event').style.display = 'none';
					document.getElementById('no_event').style.display = '';
					document.getElementById('inner_current').className = 'no_current_event';
					document.getElementById('cevent_title').innerHTML = '';
					document.getElementById('cevent_presenter').innerHTML = '';
					document.getElementById('cevent_times').innerHTML = '';
					document.getElementById('cevent_description').innerHTML = '';
				}

				if(JSONevents.nextevents.length > 0) {
					var nevents = document.getElementById('next_events');
					var tabla = document.createElement("table");
					tabla.setAttribute("id","table_next_events");
					tabla.setAttribute("width","100%");
//					tabla.setAttribute('style', 'border:1px solid #999;');
					var row = document.createElement("tr");
//					alert(JSONevents.nextevents.length);
					var td1 = document.createElement("td");
					td1.setAttribute('style', 'vertical-align:top;');
					var rbg = 0;
					var c = 0;
					var bgcolor = '';
					for (i=0;i<JSONevents.nextevents.length;i++) {
						if(rbg == 0) {
							bgcolor = '#638541';
							rbg++;
						} else if(rbg == 1) {
							bgcolor = '#3b6f9c';
							rbg++;
						} else if(rbg == 2) {
							bgcolor = '#8e7e42';
							rbg++;
						} else if(rbg >= 3) {
							bgcolor = '#7676ab';
							rbg = 0;
						}
					
						if(c >= 13) {
							row.appendChild(td1);
							var td1 = document.createElement("td");
							td1.setAttribute('style', 'width:50%;vertical-align:top;');
							c = 0;
						}
						var tdcell = "<table cellpadding='5' cellspacing='0' style='background-color:"+bgcolor+"; width:100%;border:1px solid #999; font-size:16px;'><tr><td style='white-space:nowrap; width:140px; text-align:right;'>"+JSONevents.nextevents[i]['times']+"</td><td>"+JSONevents.nextevents[i]['title']+"</td><td style='width:150px; white-space:nowrap;'>"+JSONevents.nextevents[i]['presenter']+"</td></tr></table>";
						td1.innerHTML += tdcell;
						c++;
					}
					row.appendChild(td1);
					tabla.appendChild(row);
					nevents.innerHTML = '';
					nevents.appendChild(tabla);
					document.getElementById('next_events').style.display = '';
					document.getElementById('inner_next').className = 'innerbody';
					document.getElementById('no_next_event').style.display = 'none';
				} else {
					document.getElementById('next_events').innerHTML = '';
					document.getElementById('inner_next').className = 'no_more_events';
					document.getElementById('next_events').style.display = 'none';
					document.getElementById('no_next_event').style.display = '';
					
//					alert(document.getElementById('inner_next').class);
				}

				
				
				//document.getElementById("session_name").innerHTML = JSONdata.session_name;
			} 
		} 
		ajax.send(null); 
	}
}

