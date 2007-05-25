function openedit(what) {
    document.getElementsByName("editwhat")[0].value = what;
    window.open("admin_frogpad.php","editor","width=980,height=710,screenX=5,screenY=5,scrollbars=NO");
}

var mux = 'block';
function hideDiv(divId){ 
	var arr = document.getElementById(divId);
	if ( arr!= null ) { 
		if (arr.style.display == 'none') {
			arr.style.display = 'block';
		} else {
			arr.style.display = 'none';
		}
	}
}
function toggleDivs(){ 
	var arr = getElementsByClassName('hiddencat');
	
	for(var i=0; i<arr.length;i++) {
		arr[i].style.display = mux;
	}
	mux = (mux == 'block') ? 'none':'block';
}

function getElementsByClassName (cl){
	var retnode = [];
	var elem = document.getElementsByTagName('*');
	
	for (var i = 0; i < elem.length; i++) {
		if (elem[i].className == cl) retnode.push(elem[i]);
	}
	return retnode;
}

function xmlhttpPost(strURL, titleStr) {
    var xmlHttpReq = false;
	
	updatepage("<div class='style3'><b>Loading...</b></div>");
    if (window.XMLHttpRequest) {
        xmlHttpReq = new XMLHttpRequest();
    }
    else if (window.ActiveXObject) {
        xmlHttpReq = new ActiveXObject("Microsoft.XMLHTTP");
    }
    var url = "admin_ajax.php?page=";
    url = url + strURL + "&title=" + titleStr;
    xmlHttpReq.open('GET', url, true);
    xmlHttpReq.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xmlHttpReq.onreadystatechange = function() {
        if (xmlHttpReq.readyState == 4) {
            updatepage(xmlHttpReq.responseText);
        }
    }
    xmlHttpReq.send(null);
}

function updatepage(str){
    document.getElementById('maincontent').innerHTML = str;
}