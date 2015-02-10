//--------------------------------
// START - Document Ready Functions
//--------------------------------
$().ready(function(){
    $("head > link#noscriptcss").remove();
});
//--------------------------------
// END - Document Ready Functions
//--------------------------------


function popUp(url, target, width, height, pos_x, pos_y) {
    if (typeof pos_x =="undefined") { pos_x = "center"; }
    if (typeof pos_y =="undefined") { pos_y = "middle"; }

    var x;
    var y;

    // get x pos
    switch (pos_x) {
        case "left":
            x = 0;
            break;
        case "right":
            x = screen.width - width;
            break;
        default: //center
            x = screen.width/2 - width/2;
            break;
    }

    // get y pos
    switch (pos_y) {
        case "top":
            y = 0;
            break;
        case "bottom":
            y = screen.height - height;
            break;
        default: //middle
            y = screen.height/2 - height/2;
            break;
    }

    window.open(url, target, 'width='+width+',height='+height+',left='+x+',top='+y+',screenX='+x+',screenY='+y+',scrollbars=YES,location=YES,status=YES');
}

function popTab(url, target) {
    window.open(url, target);
}



/**
* From http://www.massless.org/mozedit/
*/
function mozWrap(txtarea, open, close)
{
        var selLength = txtarea.textLength;
        var selStart = txtarea.selectionStart;
        var selEnd = txtarea.selectionEnd;
        var scrollTop = txtarea.scrollTop;

        if (selEnd == 1 || selEnd == 2)
        {
                selEnd = selLength;
        }

        var s1 = (txtarea.value).substring(0,selStart);
        var s2 = (txtarea.value).substring(selStart, selEnd)
        var s3 = (txtarea.value).substring(selEnd, selLength);

        txtarea.value = s1 + open + s2 + close + s3;
        txtarea.selectionStart = selEnd + open.length + close.length;
        txtarea.selectionEnd = txtarea.selectionStart;
        txtarea.focus();
        txtarea.scrollTop = scrollTop;

        return;
}

///////////////////////////////////////////////
//// Short string by cutting in the middle ////
///////////////////////////////////////////////
function cut_in_string (string, maxlength, replacement)
{
	if (string.length > maxlength) {
		var part_lenght = Math.ceil(maxlength/2)-Math.ceil(replacement.length/2);
		var string_start = string.substr(0, part_lenght);
		var string_end = string.substr(-1*part_lenght);
		string = string_start+replacement+string_end;
	}
	return string;
}

//////////////////////////
//// htmlspecialchars ////
//////////////////////////
function htmlspecialchars(str,typ) {
    if(typeof str=="undefined") str="";
    if(typeof typ!="number") typ=2;
    typ=Math.max(0,Math.min(3,parseInt(typ)));
    var from=new Array(/&/g,/</g,/>/g);
    var to=new Array("&amp;","&lt;","&gt;");
    if(typ==1 || typ==3) {from.push(/'/g); to.push("&#039;");}
    if(typ==2 || typ==3) {from.push(/"/g); to.push("&quot;");}
    for(var i in from) str= str.replace(from[i],to[i]);
    return str;
}


//////////////////////////////////////////////////////////////////////////////////////
//Einfachen Code einfügen (B,I,U, etc.) => Keine Abfrage
//////////////////////////////////////////////////////////////////////////////////////
function insert(eName, aTag, eTag) {
  var input = document.getElementById(eName);
  input.focus();
  /* für Internet Explorer */
  if(typeof document.selection != 'undefined') {
    /* Einfügen des Formatierungscodes */
    var range = document.selection.createRange();
    var insText = range.text;
    range.text = aTag + insText + eTag;
    /* Anpassen der Cursorposition */
    range = document.selection.createRange();
    if (insText.length == 0) {
      range.move('character', -eTag.length);
    } else {
      range.moveStart('character', aTag.length + insText.length + eTag.length);
    }
    range.select();
  }
  /* für neuere auf Gecko basierende Browser */
  else if(typeof input.selectionStart != 'undefined')
  {
    /* Anpassen der Cursorposition nach dem einfügen */
    var selection_start = input.selectionStart;
    var selection_end = input.selectionEnd;
    var insText = input.value.substring(selection_start, selection_end);
    var pos;
    if (insText.length == 0) {
      pos = selection_start + aTag.length;
    } else {
      pos = selection_start + aTag.length + insText.length + eTag.length;
    }
    mozWrap(input, aTag, eTag)
    input.selectionStart = pos;
    input.selectionEnd = pos;
  }
  /* für die übrigen Browser */
  else
  {
    /* Abfrage der Einfügeposition */
    var pos = input.value.length;
    /* Einfügen des Formatierungscodes */
    var insText = prompt("Bitte gib den zu formatierenden Text ein:");
    input.value = input.value.substr(0, pos) + aTag + insText + eTag + input.value.substr(pos);
  }
}
//////////////////////////////////////////////////////////////////////////////////////
//Mittel Komplexen Code einfügen (IMG, CIMG, etc.) => Abfrage bei nicht Markiertem Text
//////////////////////////////////////////////////////////////////////////////////////
function insert_mcom(eName, aTag, eTag, Frage, Vorgabe) {
  var input = document.getElementById(eName);
  input.focus();
  /* für Internet Explorer */
  if(typeof document.selection != 'undefined') {
    /* Einfügen des Formatierungscodes */
    var range = document.selection.createRange();
    var insText = range.text;
    if (insText.length == 0) {
      /* Ermittlung des einzufügenden Textes*/
      insText = prompt(Frage, Vorgabe);
      if (insText == null) {
        insText = "";
      }
    }
    range.text = aTag + insText + eTag;
    /* Anpassen der Cursorposition */
    range = document.selection.createRange();
    if (insText.length == 0) {
      range.move('character', -eTag.length);
    } else {
      range.moveStart('character', aTag.length + insText.length + eTag.length);
    }
    range.select();
  }
  /* für neuere auf Gecko basierende Browser */
  else if(typeof input.selectionStart != 'undefined')
  {
    /* Anpassen der Cursorposition nach dem einfügen */
    var selection_start = input.selectionStart;
    var selection_end = input.selectionEnd;
    var insText = input.value.substring(selection_start, selection_end);
    var addText = "";

    /* Ermittlung des einzufügenden Textes*/
    if (insText.length == 0) {
      addText = prompt(Frage, Vorgabe);
      if (addText == null) {
        addText = "";
      }
      insText = addText;
    }

    var pos;
    if (insText.length == 0) {
      pos = selection_start + aTag.length;
    } else {
      pos = selection_start + aTag.length + insText.length + eTag.length;
    }

    mozWrap(input, aTag+addText, eTag)
    input.selectionStart = pos;
    input.selectionEnd = pos;
  }
  /* für die übrigen Browser */
  else
  {
    /* Abfrage der Einfügeposition */
    var pos = input.value.length;
    /* Einfügen des Formatierungscodes */
    var insText = prompt(Frage, Vorgabe);
    if (insText == null) {
      insText = "";
    }
    input.value = input.value.substr(0, pos) + aTag + insText + eTag + input.value.substr(pos);
  }
}
//////////////////////////////////////////////////////////////////////////////////////
//Komplexen Code einfügen (FONT, SIZE, COLOR, etc.) => Abfrage wird immer durchgeführt
//////////////////////////////////////////////////////////////////////////////////////
function insert_com(eName, Tag, Frage, Vorgabe) {
  var input = document.getElementById(eName);
  input.focus();
  /* Ermittlung des einzufügenden Textes*/
  var attText = prompt(Frage, Vorgabe);
  if (attText == null) {
    attText = "";
  }
  /* für Internet Explorer */
  if(typeof document.selection != 'undefined') {
    /* Einfügen des Formatierungscodes */
    var range = document.selection.createRange();
    var insText = range.text;
    range.text = "["+Tag+"="+attText+"]"+ insText +"[/"+Tag+"]";
    /* Anpassen der Cursorposition */
    range = document.selection.createRange();
    if (insText.length == 0) {
      range.move('character', -(Tag.length + 2));
    } else {
      range.moveStart('character', Tag.length + 3 + attText.length + insText.length + Tag.length + 3);
    }
    range.select();
  }
  /* für neuere auf Gecko basierende Browser */
  else if(typeof input.selectionStart != 'undefined')
  {
    /* Tags definieren */
    var aTag = "["+Tag+"="+attText+"]";
    var eTag = "[/"+Tag+"]";

    /* Anpassen der Cursorposition nach dem einfügen */
    var selection_start = input.selectionStart;
    var selection_end = input.selectionEnd;
    var insText = input.value.substring(selection_start, selection_end);

    var pos;
    if (insText.length == 0) {
      pos = selection_start + aTag.length;
    } else {
      pos = selection_start + aTag.length + insText.length + eTag.length;
    }

    mozWrap(input, aTag, eTag)
    input.selectionStart = pos;
    input.selectionEnd = pos;
  }
  /* für die übrigen Browser */
  else
  {
    /* Abfrage der Einfügeposition */
    var pos = input.value.length;
    /* Einfügen des Formatierungscodes */
    var insText = prompt("Bitte gib den zu formatierenden Text ein:");
    input.value = input.value.substr(0, pos) +"["+Tag+"="+attText+"]"+ insText +"[/"+Tag+"]"+ input.value.substr(pos);
  }
}
