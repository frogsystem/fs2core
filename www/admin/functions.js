//delete alert
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

//Open Edit-PopUp
function openedit(what)
{
    document.getElementsByName("editwhat")[0].value = what;
    newWidth = screen.availWidth;
    newHeight = screen.availHeight;
    window.open("admin_frogpad.php","editor","width=newWidth,height=newHeight,left=0,top=0,scrollbars=YES,resizable=YES");
}

closedMenu=new Array();

//Initialize Menu
function iniMenu()
{
    if (getCookieInfo("tAdminMenu") != false) {
    closedMenu = getCookieInfo("tAdminMenu");
    }

    //document.write("menu ->"+closedMenu);
    for (i=0; i<document.getElementsByTagName("div").length; i++) {
        if (document.getElementsByTagName("div")[i].className == "toggle") {
            MenuID = document.getElementsByTagName("div")[i].id;
            if (closedMenu.inArray(MenuID)) {
                setToggle(MenuID,"hide");
            } else {
                setToggle(MenuID,"show");
            }
        }
    }

}

//Toggle Menu
function toggleMenu(MenuID)
{
    var MenuState = document.getElementById(MenuID).style.display;

    if (MenuState == "none") {
        setToggle(MenuID,"show");
    } else {
        setToggle(MenuID,"hide");
    }
}

//Set Toggle State
function setToggle(MenuID,state)
{
    if (state == "show") {
        document.getElementById(MenuID).style.display = "block";
        document.getElementById("timg_"+MenuID).src = "img/pointer_down.gif";
        if (closedMenu.inArray(MenuID)) {
            closedMenu.deleteArray(MenuID);
        }
    } else {
        document.getElementById(MenuID).style.display = "none";
        document.getElementById("timg_"+MenuID).src = "img/pointer.gif";
        if (!closedMenu.inArray(MenuID)) {
            closedMenu.push(MenuID);
        }
    }
    setCookie(closedMenu.join("|"), 1000*60*60*24*365); //Cookie expires in 365 Days = 1 Year
}

//Imitate deleteArray
Array.prototype.deleteArray = function (value)
// Returns true if the passed value is found in the
// array.  Returns false if it is not.
{
    var i;
    for (i=0; i < this.length; i++) {
        // Matches identical (===), not just similar (==).
        if (this[i] === value) {
            this.splice(i,1);
            return true;
        }
    }
    return false;
}

//Imitate inArray
Array.prototype.inArray = function (value)
// Returns true if the passed value is found in the
// array.  Returns false if it is not.
{
    var i;
    for (i=0; i < this.length; i++) {
        // Matches identical (===), not just similar (==).
        if (this[i] === value) {
            return true;
        }
    }
    return false;
}

//Set tAdminMenu Cookie
function setCookie(tMenuIDs, expiresIn)
{
    var expires = new Date();
    var expireDate = expires.getTime() + expiresIn;
    expires.setTime(expireDate);
    document.cookie="tAdminMenu="+tMenuIDs+"; expires="+expires.toGMTString()+";";
}

//Get Information from Cookie
function getCookieInfo(cookieName)
{
    var menuData = new Array();
    if (document.cookie) {
        begin = document.cookie.indexOf(cookieName+"=");
        if (begin != -1) {
            begin += cookieName.length+1;
            end = document.cookie.indexOf(";", begin);
            if (end == -1) {
                end = document.cookie.length;
            }
            cookievalue = unescape(document.cookie.substring(begin, end));
        } else {
            return false;
        }
    } else {
        return false;
    }
    menuData = cookievalue.split('|');
    return menuData;
}