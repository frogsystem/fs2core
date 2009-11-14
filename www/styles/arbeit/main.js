function chkFormularComment()
    {
        if((document.getElementById("name").value == "") ||
           (document.getElementById("title").value == "") ||
           (document.getElementById("text").value == ""))
        {
            alert ("Du hast nicht alle Felder ausgefüllt");
            return false;
        }
    }
    
function chkFormularNewsSearch()
    {
        if (document.getElementById("keyword").value.length < "4")
        {
            alert("Es müssen mehr als 3 Zeichen sein");
            return false;
        }
    }

function chkFormularRegister() 
{
    if((document.getElementById("username").value == "") ||
       (document.getElementById("usermail").value == "") ||
       (document.getElementById("newpwd").value == "") ||
       (document.getElementById("wdhpwd").value == ""))
    {
        alert("Du hast nicht alle Felder ausgefüllt"); 
        return false;
    }
    if(document.getElementById("newpwd").value != document.getElementById("wdhpwd").value)
    {
        alert("Passwöter sind verschieden"); 
        return false;
    }
}