//--------------------------------
// START - Document Ready Functions
//--------------------------------
$().ready(function(){

var lastJQBox;

//////////////////////////////
//// HTML-Editor: Buttons ////
//////////////////////////////

    //add hover class
    $(".html-editor-button").hover(
        function () {
            $(this).addClass("html-editor-button-hover");
        },
        function () {
            $(this).removeClass("html-editor-button-hover");
        }
    );


///////////////////////////////
//// HTML-Editor: Tag-List ////
///////////////////////////////

    // Colorize tag-list
    $(".html-editor-container-list .html-editor-list-popup tr:nth-child(even)").css("background-color","#FFFFFF");
    $(".html-editor-container-list .html-editor-list-popup tr:nth-child(even)").hover( function () {
        $(this).css("background-color","#CCCCCC");
    }, function () {
        $(this).css("background-color","#FFFFFF");
    });
    $(".html-editor-container-list .html-editor-list-popup tr:nth-child(odd)").hover( function () {
        $(this).css("background-color","#CCCCCC");
    }, function () {
        $(this).css("background-color","#EEEEEE");
    });
    $(".html-editor-container-list .html-editor-list-popup tr:first-child").find("td").css("border","none");


    // html-editor-list hover
    $(".html-editor-container-list").hover (
        function () {
            $(this).find(".html-editor-list").css("border","1px solid #555555");
            $(this).find(".html-editor-list-arrow").css("border","1px solid #555555");
            $(this).find(".html-editor-list-arrow").css("border-left","none");
            $(this).find(".html-editor-list-arrow").css("background-color","#CCCCCC");
        },
        function () {
            $(this).find(".html-editor-list").css("border","1px solid #BBBBBB");
            $(this).find(".html-editor-list-arrow").css("border","1px solid #BBBBBB");
            $(this).find(".html-editor-list-arrow").css("border-left","none");
            $(this).find(".html-editor-list-arrow").css("background-color","#EEEEEE");
        }
    );

    // Show tag-list on hover
    $(".html-editor-container-list").hover (
        function () {
            $(this).find(".html-editor-list-popup").show();
        },
        function () {
            $(this).find(".html-editor-list-popup").hide();
        }
    );


/////////////////////
//// Select-List ////
/////////////////////

    // Add Pointer to clickable area
    $(".select_entry").addClass("pointer");

    // create mouseover effect depending on Box State and color
    $(".select_entry").hover(
        function () {
            theTable = $(this).parents(".select_list:first");
            if ( $(this).find("input.select_box:first").is(":checked") ) {
                setBGcolorCompare ( $(this), theTable.find("select.select_type:first option:selected").hasClass("select_red"), "#DE5B5B", "#64DC6A" );
            } else {
                $(this).css("background-color", "#EEEEEE");
            }
        },
        function () {
            theTable = $(this).parents(".select_list:first");
            if ( $(this).find("input.select_box:first").is(":checked") ) {
                setBGcolorCompare ( $(this), theTable.find("select.select_type:first option:selected").hasClass("select_red"), "#C24949", "#49C24f" );
            } else {
                $(this).css("background-color", "transparent");
            }
        }
    );

    // Prevent "double-click" error, don't use default click functionality of boxes
    $(".select_entry input.select_box").click(
        function () {
            if ( $(this).is(":checked") ) {
                $(this).removeProp("checked");
            } else {
                $(this).prop("checked", true);
            }
        }
    );

    // Create Click depending on select type and color
    $(".select_entry").click(
        function () {
            theTable = $(this).parents(".select_list:first");
            if ( theTable.find("select.select_type:first option:selected").hasClass("select_one") ) {
                theTable.find(".select_entry input.select_box").removeProp("checked");
                theTable.find(".select_entry").css("background-color", "transparent");
            }

            var theBox = $(this).find("input.select_box:first");

            if ( theBox.is(":checked") ) {
                theBox.removeProp("checked");
                $(this).css("background-color", "#EEEEEE");
            } else {
                theBox.prop("checked", true);
                setBGcolorCompare ( $(this), theTable.find("select.select_type:first option:selected").hasClass("select_red"), "#DE5B5B", "#64DC6A" );
                lastJQBox = theBox;
            }
        }
    );
            //
    // Create change of select type and color
    $(".select_list select.select_type").change(
        function () {
            theTable = $(this).parents(".select_list:first");
            theLines = theTable.find(".select_entry");

            if ( $(this).find("option:selected").hasClass("select_one") && lastJQBox != undefined) {
                theLines.find("input.select_box").removeProp("checked");
                theLines.css("background-color", "transparent");
                lastJQBox.prop("checked", true);
            }

            setBGcolorCompare ( theLines.find("input.select_box:checked").parents(".select_entry:first"), $(this).find("option:selected").hasClass("select_red"), "#C24949", "#49C24f" );
        }
    );


});
//--------------------------------
// END - Document Ready Functions
//--------------------------------



///////////////////////////////////
//// OLD select-list functions ////
///////////////////////////////////


// set BG color depending on
function setBGcolorCompare (theObject, theCompare, firstColor, secondColor) {
    if (theCompare) {
        theObject.css("background-color", firstColor);
    } else {
        theObject.css("background-color", secondColor);
    }
    return true;
}


// show or hide an element
function show_hidden (showObject, checkObject, compareWith) {
  if (checkObject.checked == compareWith) {
      showObject.className = "default";
    } else {
      showObject.className = "hidden";
    }
  return true;
}

function show_one (oneString, valueString, checkObject) {
  oneArray = oneString.split("|");
  valueArray = valueString.split("|");
  for (var i = 0; i < oneArray.length && i < valueArray.length; ++i) {
    if ( checkObject.value == valueArray[i] ) {
      document.getElementById(oneArray[i]).className = "default";
    } else {
      document.getElementById(oneArray[i]).className = "hidden";
    }
  }
  return true;
}


//Use Confirm-Box on Checkbox
function delalert (elementID, alertText) {
  if (document.getElementById(elementID).checked == true) {
    var Check = confirm(alertText);
    if (Check == true) {
      document.getElementById(elementID).checked = true;
    } else {
      document.getElementById(elementID).checked = false;
    }
  }
  return true;
}


var last;
var lastBox;

//colorize Entry
function colorEntry (theBox, defaultColor, checkedColor, object) {
    if (theBox.checked == true) {
        object.style.backgroundColor = checkedColor;
    } else {
        object.style.backgroundColor = defaultColor;
    }
    return true;
}

//create Change onClick
function createClick (theBox, defaultColor, checkedColor, object) {
    if (theBox.type == 'radio') {
        if (theBox.checked != true) {
             theBox.checked = !(theBox.checked);
        }
    } else {
        theBox.checked = !(theBox.checked);
    }
    colorEntry (theBox, defaultColor, checkedColor, object);
    return true;
}

// save last objects
function saveLast (theBox, object) {
    if (theBox.checked == true) {
        last = object;
        lastBox = theBox;
    }
    return true;
}

// save preselcted object as las
function savePreSelectedLast (theBox, object) {
    last = object;
    lastBox = theBox;
    return true;
}

//reset Not selected
function resetOld (resetColor, last, lastBox, object) {
    if (object != last) {
        if (last) {
            last.style.backgroundColor = resetColor;
        }
        if (lastBox) {
            lastBox.checked = false;
        }
        return true;
    }
}



//////////////////////////
//// Editor Functions ////
//////////////////////////

// Toggle textWrapping
function toggleTextWrapping ( theButton, cm ) {
  cm.setOption("lineWrapping", !cm.getOption("lineWrapping"));
  $(theButton).toggleClass('html-editor-button-active');
}

// Toggle lineNumbers
function toggleLineNumbers ( theButton, cm ) {
  cm.setOption("lineNumbers", !cm.getOption("lineNumbers"));
  $(theButton).toggleClass('html-editor-button-active');
}

// Toggle fullscreen
function toggleFullscreen ( theButton, cm ) {
  cm.setOption("fullScreen", !cm.getOption("fullScreen"));
  //~ $(theButton).toggleClass('html-editor-button-active');
}

//Insert Tag into Editor
function insert_editor_tag( cm, insertText ) {
    cm.replaceSelection(insertText);
}


// Toggle Original
function toggelOriginal ( editorId ) {
    eval ( "var theCheck = $(\"#"+editorId+"_original\").is(\":visible\");" );

    if (theCheck == true) {
        eval ( "$(\"#"+editorId+"_original\").hide()" );
        eval ( "$(\"#"+editorId+"_editor-bar .html-editor-row\").show()" );
        eval ( "$(\"#"+editorId+"_content\").show()" );
        eval ( "$(\"#"+editorId+"_original-row\").hide()" );
    } else {
        eval ( "$(\"#"+editorId+"_content\").hide()" );
        eval ( "$(\"#"+editorId+"_editor-bar .html-editor-row\").hide()" );
        eval ( "$(\"#"+editorId+"_original-row .html-editor-button\").addClass(\"html-editor-button-active\")" );
        eval ( "$(\"#"+editorId+"_original-row\").show()" );
        eval ( "$(\"#"+editorId+"_original\").show()" );
    }
}

//Get Editor Object
function new_editor ( textareaId, editorHeight, readOnlyState, syntaxHighlight )
{
  var textarea = document.getElementById(textareaId);
  
  switch (syntaxHighlight) {
    case 3:
        var mode = "text/javascript";
        break;
    case 2:
        var mode = "text/css";
        break;
    default:
        var mode = "text/html";
        break;
  }
  
  
  var editor = CodeMirror.fromTextArea(textarea, {
    mode:  mode,
    lineNumbers: true,
    readOnly: readOnlyState,
    extraKeys: {
      "F11": function(cm) {
        cm.setOption("fullScreen", !cm.getOption("fullScreen"));
      },
      "Esc": function(cm) {
        if (cm.getOption("fullScreen")) cm.setOption("fullScreen", false);
      }
    }
    
    // DEPRECATED
    //~ tabMode: "shift",
  });
  editor.setSize(null, editorHeight);
  
  return editor;
}

/////////////////////////
//// Date Operations ////
/////////////////////////

//Schaltjahr
function schaltJahr(Jhr)
{
    var sJahr;
    S4Jahr = Jhr%4;
    SHJahr = Jhr%100;
    S4HJahr = Jhr%400;
    sJahr = ((S4HJahr == "0") ? (1) : ((SHJahr == "0") ? (0) : ((S4Jahr == "0") ? (1) : (0))));

    return sJahr;
}

//change date
function changeDate (dayID, monthID, yearID, hourID, minID, dayShift, monthShift, yearShift, hourShift, minShift)
{
    var oldDate = new Date(parseInt(document.getElementById(yearID).value, 10),
                           parseInt(document.getElementById(monthID).value, 10) - 1,
                           parseInt(document.getElementById(dayID).value, 10),
                           parseInt(document.getElementById(hourID).value, 10),
                           parseInt(document.getElementById(minID).value, 10),
                           "0");

    var newDate = new Date();
    newDate.setTime(oldDate.getTime());

   var sJahr;
    if (oldDate.getMonth <= 1) {
       sJahr = schaltJahr(oldDate.getFullYear());
    } else {
       sJahr = schaltJahr(oldDate.getFullYear() + 1)
    }
    if (sJahr == 1) {
        yearShift = parseInt(yearShift, 10)*366*24*60*60*1000;
    } else {
        yearShift = parseInt(yearShift, 10)*365*24*60*60*1000;
    }
    newDate.setTime(newDate.getTime() + yearShift);

    if (parseInt(monthShift, 10) > 0) {
        for (var i=0; i < parseInt(monthShift, 10); i++) {
            newDate.setMonth(newDate.getMonth() + 1);
        }
    } else if (parseInt(monthShift, 10) < 0) {
        for (var i=0; i < (parseInt(monthShift, 10) * -1); i++) {
            newDate.setMonth(newDate.getMonth() - 1);
        }
    }

    dayShift = parseInt(dayShift, 10)*24*60*60*1000;
    newDate.setTime(newDate.getTime() + dayShift);

    hourShift = parseInt(hourShift, 10)*60*60*1000;
    newDate.setTime(newDate.getTime() + hourShift);

    minShift = parseInt(minShift, 10)*60*1000;
    newDate.setTime(newDate.getTime() + minShift);

    var newDay = newDate.getDate();
      if (newDay < 10) {newDay = "0" + newDay;}
    var newMonth = newDate.getMonth() + 1;
      if (newMonth < 10) {newMonth = "0" + newMonth;}
    var newYear = newDate.getFullYear();
    var newHour = newDate.getHours();
      if (newHour < 10) {newHour = "0" + newHour;}
    var newMin = newDate.getMinutes();
      if (newMin < 10) {newMin = "0" + newMin;}

    document.getElementById(dayID).value = newDay;
    document.getElementById(monthID).value = newMonth;
    document.getElementById(yearID).value = newYear;
    document.getElementById(hourID).value = newHour;
    document.getElementById(minID).value = newMin;
    return true;
}

//setNow
function setNow(y, m, d, h, i, s) {
    if (document.getElementById(y) != null)
        document.getElementById(y).value=getCurYear();

    if (document.getElementById(m) != null)
        document.getElementById(m).value=getCurMonth();

    if (document.getElementById(d) != null)
        document.getElementById(d).value=getCurDate();

    if (document.getElementById(h) != null)
        document.getElementById(h).value=getCurHours();

    if (document.getElementById(i) != null)
        document.getElementById(i).value=getCurMinutes();

    if (document.getElementById(s) != null)
        document.getElementById(s).value=getCurSeconds();
}


//getCurDate()
function getCurDate () {
  var curDateTime = new Date();
  var curD = curDateTime.getDate();
  if (curD < 10) {
    curD = "0" + curD;
  }
  return curD;
}
//getCurMonth()
function getCurMonth () {
  var curDateTime = new Date();
  var curM = curDateTime.getMonth() + 1;
  if (curM < 10) {
    curM = "0" + curM;
  }
  return curM;
}
//getCurYear()
function getCurYear () {
  var curDateTime = new Date();
  var curY = curDateTime.getFullYear();
  return curY;
}
//getCurHours()
function getCurHours () {
  var curDateTime = new Date();
  var curH = curDateTime.getHours();
  if (curH < 10) {
    curH = "0" + curH;
  }
  return curH;
}
//getCurMinutes()
function getCurMinutes () {
  var curDateTime = new Date();
  var curI = curDateTime.getMinutes();
  if (curI < 10) {
    curI = "0" + curI;
  }
  return curI;
}
//getCurSeconds()
function getCurSeconds () {
  var curDateTime = new Date();
  var curS = curDateTime.getSeconds();
  if (curS < 10) {
    curS = "0" + curS;
  }
  return curS;
}
