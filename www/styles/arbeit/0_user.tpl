<!--section-start::APPLET_LOGIN--><b>Anmelden</b>

<form action="" method="post">
  <input type="hidden" name="go" value="login">
  <input type="hidden" name="login" value="1">
  <table style="margin-left:-2px;" border="0" cellpadding="2" cellspacing="0">
    <tr>
      <td>
        <span class="small">Benutzername:</span>
      </td>
    </tr>
    <tr>    
      <td>
        <input class="small input input_highlight" size="20" name="username" maxlength="25">
      </td>
    </tr>
    <tr>
      <td>
        <span class="small">Passwort:</span>
      </td>
    </tr>
    <tr>    
      <td>
        <input class="small input input_highlight" size="20" type="password" name="userpassword" maxlength="50">
      </td>
    </tr>
    <tr><td></td></tr>
    
    <tr>
      <td align="left">
        <label for="stayonline_mini" class="small pointer textmiddle">Angemeldet bleiben?</label>
        <input class="pointer textmiddle" type="checkbox" id="stayonline_mini" name="stayonline" value="1" checked>          
      </td>
    </tr>
    <tr>
      <td align="center">
        <button class="pointer small" type="submit">Anmelden</button>
      </td>
    </tr>
    <tr>
      <td align="left">
        <a class="small" href="?go=register">Noch nicht registriert?</a>
      </td>
    </tr>    
  </table>
</form>
<!--section-end::APPLET_LOGIN-->

<!--section-start::APPLET_MENU--><b>Willkommen {..user_name..}</b><br>
{..user_image..}
<a class="small" href="?go=editprofil">- Mein Profil</a><br>
{..admincp_line..}
<a class="small" href="{..logout_url..}">- Abmelden</a><!--section-end::APPLET_MENU-->

<!--section-start::APPLET_ADMINLINK--><a class="small" href="{..admincp_url..}">- Admin CP</a><br>
<!--section-end::APPLET_ADMINLINK-->

<!--section-start::LOGIN-->  <b>Anmelden</b><br><br>

  <table style="margin-left:-2px;" border="0" cellpadding="2" cellspacing="0">
    <tr>
      <td align="left" colspan="2">
        <b>Benutzername:</b>
      </td>
      <td align="center" valign="middle" rowspan="11" width="90"><img src="$VAR(style_images)line.gif" alt=""></td>
      <td align="left" valign="top" rowspan="11">
        <div style="margin-bottom:4px;"><b class="textmiddle">Noch kein Benutzerkonto?</b></div>
        Jetzt <a href="?go=register">registrieren</a> und folgende Vorteile genießen:
        <ul>
          <li>Zugriff auf Downloads</li>
          <li>Kein CAPTCHA bei Kommentaren</li>
          <li>Eigenes Benutzerbild</li>
        </ul>
        <div align="center">
          <form action="" method="get">
            <input type="hidden" name="go" value="register">
            <button class="pointer" type="submit"><img src="$VAR(style_icons)user/user-new.gif" alt="" align="bottom"> zur Registrierung</button>
          </form>
        </div>
      </td>
    </tr>

<form action="" method="post">
  <input type="hidden" name="go" value="login">
  <input type="hidden" name="login" value="1">
  
    <tr>
      <td align="left">
        <input class="small input input_highlight" size="33" name="username" maxlength="25">
      </td>
      <td align="left">
        <img src="$VAR(style_icons)user/user.gif" alt="" align="bottom">
      </td>      
    </tr>
    <tr>
      <td></td>
    </tr>
    <tr>
      <td align="left" colspan="2">
        <b>Passwort:</b>
      </td>
    </tr>
    <tr>
      <td align="left">
        <input class="small input input_highlight" size="33" type="userpassword" name="userpassword" maxlength="50">
      </td>
      <td align="left">
        <img src="$VAR(style_icons)user/key.gif" alt="" align="bottom">
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center" colspan="2">
        <button class="pointer" type="submit"><img src="$VAR(style_icons)user/unlock.gif" alt="" align="bottom"> Anmelden</button>
      </td>
    </tr>
    <tr>
      <td></td>
    </tr>
    <tr>
      <td align="center" colspan="2">
        <label for="stayonline" class="small pointer textmiddle">Dauerhaft angemeldet bleiben?</label>
        <input type="checkbox" class="pointer textmiddle" name="stayonline" id="stayonline" value="1" checked>
      </td>
    </tr>
  </table>
</form>
<!--section-end::LOGIN-->

<!--section-start::REGISTER--><b>Registrierung</b><br>
<img src="images/design/line.jpg"><br><br>

<div style="padding-left:10px;">
  Du hast noch kein Benutzerkonto? Dann registriere dich jetzt auf <b>$VAR(page_title)</b> und genieße folgende Vorteile:

  <ul><li>Zugriff auf die Downloads</li>
  <li>Keine Spam-Schutz Abfrage bei Kommentaren</li>
  <li>auch ganz ordentlicher Vorteil drei</li></ul>
  <br>

    <form action="" method="post" onSubmit="return chkFormularRegister()">
        <input type="hidden" name="go" value="register">

        <table border="0" cellpadding="2" cellspacing="0" align="center">
            <tr>
                <td align="left">
                    <b>Benutzername:</b>
                </td>
            </tr>
            <tr>
                <td align="left">
                    <input class="text" size="33" name="username" id="user_name" maxlength="25">
                    <img src="{virtualhost}images/icons/user/user.gif" alt="" align="bottom">
                </td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td align="left">
                    <b>E-Mail:</b>
                </td>
            </tr>
            <tr>
                <td align="left">
                    <input class="text" size="33" name="usermail" id="user_mail" maxlength="100">
                    <img src="{virtualhost}images/icons/user/mail.gif" alt="" align="bottom">
                </td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td align="left">
                    <b>Passwort:</b>
                </td>
            </tr>
            <tr>
                <td align="left">
                    <input class="text" size="33" name="newpwd" id="user_pass1" type="password" maxlength="50" autocomplete="off">
                    <img src="{virtualhost}images/icons/user/key-add.gif" alt="" align="bottom">
                </td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td align="left">
                    <b>Passwort wiederholen:</b>
                </td>
            </tr>
            <tr>
                <td align="left">
                    <input class="text" size="33" name="wdhpwd" id="user_pass2" type="password" maxlength="50" autocomplete="off">
                    <img src="{virtualhost}images/icons/user/key-action.gif" alt="" align="bottom">
                </td>
            </tr>
{antispam}
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td align="center">
                    <button class="pointer" type="submit"><img src="{virtualhost}images/icons/user/user-new.gif" alt="" align="bottom"> Jetzt registrieren</button>
                </td>
            </tr>
        </table>
    </form>

</div>

<!--section-end::REGISTER-->

<!--section-start::CAPTCHA_LINE-->            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td align="left">
                    <b>Spam-Schutz:</b>
                </td>
            </tr>
            <tr>
                <td align="right">
                    <img class="textmiddle" src="{captcha_url}"> <input class="text textmiddle" size="20" name="spam" id="spam" type="password" maxlength="5" autocomplete="off">
                    <img class="textmiddle" src="{virtualhost}images/icons/user/lock.gif" alt="">
                    <div class="small" align="left">Bitte lösen Sie diese Rechenaufgabe.</div>
                </td>
            </tr>
<!--section-end::CAPTCHA_LINE-->

<!--section-start::CAPTCHA_TEXT--><br /><br />
 <table border="0" cellspacing="0" cellpadding="0" width="60%">
  <tr>
   <td valign="top" align="left">
<div id="antispam"><font size="1">* Auf dieser Seite kann jeder einen Kommentar zu einer News abgeben. Leider ist sie dadurch ein beliebtes Ziel von sog. Spam-Bots - speziellen Programmen, die automatisiert und zum Teil massenhaft Links zu anderen Internetseiten platzieren. Um das zu verhindern müssen nicht registrierte User eine einfache Rechenaufgabe lösen, die für die meisten Spam-Bots aber nicht lösbar ist. Wenn du nicht jedesmal eine solche Aufgabe lösen möchtest, kannst du dich einfach bei uns <a href="?go=register">registrieren</a>.</font></div>
   </td>
  </tr>
 </table><!--section-end::CAPTCHA_TEXT-->

<!--section-start::PROFILE--><b>Profil von {username}</b><br>
<img src="images/design/line.jpg"><br><br>

<div style="padding-left:10px;">
  <table border="0" cellpadding="0" cellspacing="2">

    <tr>
      <td colspan="2" width="225"><b>Benutzername:</b></td>
      <td width="50"></td>
      <td colspan="2" width="125"><b>News:</b></td>
    </tr>
    <tr>
      <td>{username}</td>
      <td align="right"><img src="{virtualhost}images/icons/user/user.gif" alt="" align="bottom"></td>
      <td></td>
      <td>{news}</td>
      <td align="right"><img src="{virtualhost}images/icons/user/news.gif" alt="" align="bottom"></td>
    </tr>

    <tr><td></td></tr>

    <tr>
      <td colspan="2"><b>E-Mail:</b></td>
      <td></td>
      <td colspan="2"><b>Kommentare:</b></td>
    </tr>
    <tr>
      <td>{email}</td>
      <td align="right"><img src="{virtualhost}images/icons/user/mail.gif" alt="" align="bottom"></td>
      <td></td>
      <td>{kommentare}</td>
      <td align="right"><img src="{virtualhost}images/icons/user/note.gif" alt="" align="bottom"></td>
    </tr>

    <tr><td></td></tr>

    <tr>
      <td colspan="2"><b>Registriert seit:</b></td>
      <td></td>
      <td colspan="2"><b>Artikel:</b></td>
    </tr>
    <tr>
      <td>{reg_datum}</td>
      <td align="right"><img src="{virtualhost}images/icons/user/date.gif" alt="" align="bottom"></td>
      <td></td>
      <td>{artikel}</td>
      <td align="right"><img src="{virtualhost}images/icons/user/article.gif" alt="" align="bottom"></td>
    </tr>

  </table>
</div>
<!--section-end::PROFILE-->

<!--section-start::PROFILE_EDIT--><b>Profil bearbeiten ({..user_name..})</b><br><br>


<form action="" method="post" enctype="multipart/form-data">
    <input type="hidden" name="go" value="editprofil">

    <table style="margin-left:-2px;" border="0" cellpadding="2" cellspacing="0">

        <tr>
            <td align="left" colspan="2">
                <b>Benutzername:</b>
            </td>

            <td align="center" valign="middle" rowspan="24" width="90"><img src="$VAR(style_images)line.gif" alt=""></td>

            <td align="left" colspan="2">
                <b>Benutzerbild:</b>
            </td>
        </tr>

        <tr>
            <td align="left">{..user_name..}</td>
            <td align="center"><img src="$VAR(style_icons)user/user.gif" alt="" align="bottom"></td>
            <td align="left"><label for="user_delete_image" class="small pointer textmiddle" style="vertical-align:middle;">Aktuelles Benutzerbild löschen?</label></td>
            <td align="center"><input type="checkbox" class="pointer" name="user_delete_image" id="user_delete_image" value="1"></td>
        </tr>
        <tr><td></td></tr>

        <tr><td align="left" colspan="2"><b>E-Mail:</b></td></tr>
        <tr>
            <td align="left"><input class="small input input_highlight" size="33" value="{..user_mail..}" name="user_mail" maxlength="100"></td>
            <td align="center"><img src="$VAR(style_icons)user/mail.gif" alt="" align="bottom"></td>
            <td align="center" valign="middle" rowspan="9" colspan="2">{..user_image..}</td>
        </tr>
        <tr valign="middle">
            <td align="left"><label for="user_show_mail" class="small pointer textmiddle" style="vertical-align:middle;">E-Mail im öffentlichen Profl anzeigen?</label></td>
            <td align="center"><input type="checkbox" class="pointer" name="user_show_mail" id="user_show_mail" value="1" {..show_mail_checked..}></td>
        </tr>
        <tr><td></td></tr>
        <tr><td align="left" colspan="2"><b>Homepage:</b></td></tr>
        <tr>
            <td align="left"><input class="small input input_highlight" size="33" value="{..user_homepage_url..}" name="user_homepage" maxlength="100"></td>
            <td align="center"><img src="$VAR(style_icons)user/homepage.gif" alt="" align="bottom"></td>

        </tr>
        <tr><td>&nbsp;</td></tr>
      
      
        <tr><td align="left" colspan="2"><b>ICQ-Nummer:</b></td></tr>
        <tr>
           <td align="left"><input class="small input input_highlight" size="33" value="{..user_icq..}" name="user_icq" maxlength="100"></td>
           <td align="center"><img src="$VAR(style_icons)user/icq.gif" alt="ICQ" align="bottom"></td>
        
        </tr>
        <tr><td></td></tr>
        <tr><td align="left" colspan="2"><b>AIM E-Mail:</b></td></tr>
        <tr>
          <td align="left"><input class="small input input_highlight" size="33" value="{..user_aim..}" name="user_aim" maxlength="100"></td>
          <td align="center"><img src="$VAR(style_icons)user/aim.gif" alt="AIM" align="bottom"></td>
        
        </tr>
        <tr><td></td></tr>
        <tr>
          <td align="left" colspan="2"><b>Windows Live ID:</b></td>          
          <td align="left" colspan="2"><b>Benutzerbild hochladen:</b></td>
        </tr>
        <tr>
          <td align="left"><input class="small input input_highlight" size="33" value="{..user_wlm..}" name="user_wlm" maxlength="100"></td>
          <td align="center"><img src="$VAR(style_icons)user/wlm.gif" alt="WLM" align="bottom"></td>
          <td align="left" valign="top" rowspan="5" colspan="2">
            <input class="small input input_highlight" type="file" name="user_image" style="width:100%;"><br>
            <span class="small">{..image_limits_text..}<br></span>
          </td>        
        </tr>
        <tr><td></td></tr>
        <tr><td align="left" colspan="2"><b>Yahoo!-ID:</b></td></tr>
        <tr>
           <td align="left"><input class="small input input_highlight" size="33" value="{..user_yim..}" name="user_yim" maxlength="100"></td>
           <td align="center"><img src="$VAR(style_icons)user/yim.gif" alt="YIM" align="bottom"></td>
        
        </tr>
        <tr><td></td></tr>
        <tr><td align="left" colspan="2"><b>Skype-Name:</b></td></tr>
        <tr>
           <td align="left"><input class="small input input_highlight" size="33" value="{..user_skype..}" name="user_skype" maxlength="100"></td>
           <td align="center"><img src="$VAR(style_icons)user/skype.gif" alt="Skype" align="bottom"></td>
        
        </tr>
        <tr>
          <td colspan="2">&nbsp;</td>
          <td rowspan="9"></td>
        </tr>
      
      
        <tr><td align="left" colspan="2"><b>Nur bei einer Passwortänderung:</b></td></tr>
        <tr><td></td></tr>
        <tr>
          <td align="left" colspan="2"><b>Aktuelles Passwort:</b></td>
          <td align="left" colspan="2"><b>Neues Passwort:</b></td>
        </tr>
        <tr>
            <td align="left"><input class="small input input_highlight" size="33" name="oldpwd" type="password" maxlength="50" autocomplete="off"></td>
            <td align="center"><img src="$VAR(style_icons)user/key.gif" alt="" align="bottom"></td>
            <td align="left"><input class="small input input_highlight" size="33" name="newpwd" type="password" maxlength="50" autocomplete="off"></td>
            <td align="center"><img src="$VAR(style_icons)user/key-add.gif" alt="" align="bottom"></td>          
        </tr>
        <tr><td></td></tr>

        <tr>
          <td colspan="2"></td>
          <td align="left" colspan="2"><b>Neues Passwort wiederholen:</b></td></tr>
        <tr>
          <td colspan="2"></td>
          <td align="left"><input class="small input input_highlight" size="33" name="wdhpwd" type="password" maxlength="50" autocomplete="off"></td>
          <td align="center"><img src="$VAR(style_icons)user/key-action.gif" alt="" align="bottom"></td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td align="center" colspan="5">
                <button class="pointer" type="submit"><img src="$VAR(style_icons)user/unlock.gif" alt="" align="bottom"> Profil speichern</button>
       </td></tr>

    </table>
</form>
<!--section-end::PROFILE_EDIT-->

<!--section-start::MEMBERSLIST-->
<!--section-end::MEMBERSLIST-->

<!--section-start::MEMBERSLIST_USERLINE-->
<!--section-end::MEMBERSLIST_USERLINE-->

<!--section-start::MEMBERSLIST_ADMINLINE-->
<!--section-end::MEMBERSLIST_ADMINLINE-->

