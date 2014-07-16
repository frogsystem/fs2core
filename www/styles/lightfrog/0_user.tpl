<!--section-start::APPLET_LOGIN--><b>Anmelden</b>

<form action="" method="post">
  <input type="hidden" name="go" value="login">
  <input type="hidden" name="login" value="1">
  <table style="margin-left:-2px;" border="0" cellpadding="2" cellspacing="0">
    <tr>
      <td>
        <label class="small" for="username_mini">Benutzername:</label>
      </td>
    </tr>
    <tr>
      <td>
        <input class="small input input_highlight" size="20" id="username_mini" name="username" maxlength="25">
      </td>
    </tr>
    <tr>
      <td>
        <label class="small" for="password_mini">Passwort:</label>
      </td>
    </tr>
    <tr>
      <td>
        <input class="small input input_highlight" size="20" id="password_mini" type="password" name="userpassword" maxlength="50"><br>
        <a href="$URL(login[newpassword=])" class="small">Passwort vergessen?</a>
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

<!--section-start::APPLET_ADMINLINE--><a class="small" href="{..admincp_url..}">- Admin CP</a><br><!--section-end::APPLET_ADMINLINE-->

<!--section-start::APPLET_MENU--><b>Willkommen {..user_name..}!</b><br>
{..user_image..}

<p>
  <b>Benutzermen&uuml;:</b><br>
  <a class="small" href="{..user_edit_url..}">- Mein Profil</a><br>
  {..admincp_line..}
  <a class="small" href="{..logout_url..}">- Abmelden</a>
</p><!--section-end::APPLET_MENU-->

<!--section-start::LOGIN--><b>Anmelden</b><br><br>

  <table style="margin-left:-2px;" border="0" cellpadding="2" cellspacing="0">
    <tr>
      <td align="left" colspan="2">
        <label for="username_main"><b>Benutzername:</b></label>
      </td>
      <td align="center" valign="middle" rowspan="11" width="90"><img src="$VAR(style_images)line.gif" alt=""></td>
      <td align="left" valign="top" rowspan="11">
        <div style="margin-bottom:4px;"><b class="textmiddle">Noch kein Benutzerkonto?</b></div>
        Jetzt <a href="?go=register">registrieren</a> und folgende Vorteile genie&szlig;en:
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
        <input class="small input input_highlight" size="33" id="username_main" name="username" maxlength="25">
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
        <label for="password_big"><b>Passwort:</b></label>
      </td>
    </tr>
    <tr>
      <td align="left">
        <input class="small input input_highlight" size="33" type="password" id="password_big" name="userpassword" maxlength="50"><br>
        <a href="$URL(login[newpassword=])" class="small">Passwort vergessen?</a>
      </td>
      <td align="left" valign="top">
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

<!--section-start::NEW_PASSWORD--><h2>Neue Zugangsdaten anfordern</h2>

<p>Wenn du dein Passwort oder Benutzernamen vergessen hast, kannst du hier neue Zugangdaten anfordern. Wir ben&ouml;tigen dazu nur die E-Mail-Adresse, mit der du dich bei uns registriert hast.</p>

<form action="" method="post">
  <input type="hidden" name="go" value="login">
  <input type="hidden" name="newpassword" value="">

  <table border="0" cellpadding="2" cellspacing="0">
    <tr>
      <td align="left" colspan="2">
        <label for="newpassword_mail"><b>E-Mail-Adresse:</b></label>
      </td>
    </tr>
    <tr>
      <td align="left">
        <input class="input input_highlight" size="33" type="text" id="newpassword_mail" name="newpassword_mail" maxlength="50">
      </td>
      <td align="center">
        <button class="pointer" type="submit"><img src="$VAR(style_icons)user/mail.gif" alt="" align="bottom"> Neue Zugangsdaten anfordern</button>
      </td>
    </tr>
  </table>
</form>
<p>Falls du keinen Zugriff mehr auf diese E-Mail-Adresse haben solltest, musst du dir leider einen <a href="$URL(register)">neuen Account</a> anlegen.</p>
<!--section-end::NEW_PASSWORD-->

<!--section-start::REGISTER--><b>Registrierung</b><br><br>

<div>
  Du hast noch kein Benutzerkonto?<br>
  Dann registriere dich jetzt bei <b>$VAR(page_title)</b> und genie&szlig;e folgende Vorteile:

  <ul>
    <li>Zugriff auf Downloads</li>
    <li>Kein CAPTCHA bei Kommentaren</li>
    <li>Eigenes Benutzerbild</li>
  </ul>
  <br>

  <form action="" method="post" onSubmit="return checkRegistrationForm()">
    <input type="hidden" name="go" value="register">

    <table border="0" cellpadding="2" cellspacing="0" align="center">
      <tr>
        <td align="left">
          <b>Benutzername:</b>
        </td>
      </tr>
      <tr>
        <td align="left">
          <input class="small input input_highlight" size="33" name="user_name" id="user_name" maxlength="25">
          <img src="$VAR(style_icons)user/user.gif" alt="" align="bottom">
        </td>
      </tr>

      <tr><td></td></tr>

      <tr>
        <td align="left">
          <b>E-Mail:</b>
        </td>
      </tr>
      <tr>
        <td align="left">
          <input class="small input input_highlight" size="33" name="user_mail" id="user_mail" maxlength="100">
          <img src="$VAR(style_icons)user/mail.gif" alt="" align="bottom">
        </td>
      </tr>

      <tr><td></td></tr>

      <tr>
        <td align="left">
          <b>Passwort:</b>
        </td>
      </tr>
      <tr>
        <td align="left">
          <input class="small input input_highlight" size="33" name="new_pwd" id="new_pwd" type="password" maxlength="50" autocomplete="off">
          <img src="$VAR(style_icons)user/key-add.gif" alt="" align="bottom">
        </td>
      </tr>

      <tr><td></td></tr>

      <tr>
        <td align="left">
          <b>Passwort wiederholen:</b>
        </td>
      </tr>
      <tr>
        <td align="left">
          <input class="small input input_highlight" size="33" name="wdh_pwd" id="wdh_pwd" type="password" maxlength="50" autocomplete="off">
          <img src="$VAR(style_icons)user/key-action.gif" alt="" align="bottom">
        </td>
      </tr>

{..captcha_line..}

      <tr><td>&nbsp;</td></tr>

      <tr>
        <td align="center">
          <button class="pointer" type="submit" name="register"><img src="$VAR(style_icons)user/user-new.gif" alt="" align="bottom"> Jetzt registrieren</button>
        </td>
      </tr>
    </table>
  </form>

</div>

<!--section-end::REGISTER-->

<!--section-start::CAPTCHA_LINE-->      <tr><td>&nbsp;</td></tr>
      <tr>
        <td align="left">
          <b>Spam-Schutz:</b>
        </td>
      </tr>
      <tr>
        <td align="right">
          <img class="textmiddle" src="{..captcha_url..}"> <input class="small input input_highlight" size="20" name="captcha" maxlength="5" autocomplete="off">
          <img class="textmiddle" src="$VAR(style_icons)user/lock.gif" alt="" align="bottom">
          <div class="small" align="left">Bitte die Rechenaufgabe l&ouml;sen.</div>
        </td>
      </tr>
<!--section-end::CAPTCHA_LINE-->

<!--section-start::CAPTCHA_TEXT-->    <tr>
      <td></td>
      <td>
        <p class="small" id="captcha_note">
          <b>Hinweis:</b> Die Rechenaufgabe verhindert, dass Spam-Bots auf dieser Seite Werbung als Kommentar einstellen k&ouml;nnen. Um die Abfrage zu umgehen, kannst du dich <a href="?go=register">registrieren</a>.
        </p>
      </td>
    </tr>
<!--section-end::CAPTCHA_TEXT-->

<!--section-start::PROFILE--><b>Profil von {..user_name..}</b><br><br>

<table style="margin-left:-2px;" border="0" cellpadding="2" cellspacing="0">

  <tr>
    <td colspan="2" width="205"><b>Benutzername:</b></td>

    <td align="center" valign="middle" rowspan="28" width="90">
      <img src="$VAR(style_images)line.gif" alt="">
    </td>

    <td colspan="2" width="205"><b>Benutzerbild:</b></td>
  </tr>
  <tr>
    <td>{..user_name..}</td>
    <td align="right"><img src="$VAR(style_icons)user/user.gif" alt="" align="bottom"></td>
    <td></td>
    <td rowspan="8" valign="top" style="padding-top:5px;">{..user_image..}</td>
    <td></td>
  </tr>

  <tr><td></td></tr>

  <tr>
    <td colspan="2"><b>E-Mail:</b></td>
    <td></td>
    <td colspan="2"></td>
  </tr>
  <tr>
    <td>{..user_mail..}</td>
    <td align="right"><img src="$VAR(style_icons)user/mail.gif" alt="" align="bottom"></td>
    <td></td>

    <td></td>
  </tr>

  <tr><td></td></tr>

  <tr>
    <td colspan="2"><b>Registriert seit:</b></td>
    <td></td>
    <td colspan="2"></td>
  </tr>
  <tr>
    <td>{..user_reg_date..}</td>
    <td align="right"><img src="$VAR(style_icons)user/date.gif" alt="" align="bottom"></td>
    <td></td>

    <td></td>
  </tr>

  <tr><td>&nbsp;</td></tr>

  <tr>
    <td colspan="2"><b>Gruppe:</b></td>
    <td></td>
    <td colspan="2"><b>Rang:</b></td>
  </tr>
    <tr valign="top">
    <td>{..user_group..}</td>
    <td align="right"><img src="$VAR(style_icons)user/group.gif" alt="" align="bottom"></td>
    <td></td>
    <td>{..user_rank..}</td>
    <td></td>
  </tr>

  <tr><td>&nbsp;</td></tr>

  <tr>
    <td colspan="2"><b>Homepage:</b></td>
    <td></td>
    <td colspan="2"><b>News:</b></td>
  </tr>
  <tr>
    <td>{..user_homepage_link..}</td>
    <td align="right"><img src="$VAR(style_icons)user/homepage.gif" alt="" align="bottom"></td>
    <td></td>
    <td>{..user_num_news..}</td>
    <td align="right"><img src="$VAR(style_icons)user/news.gif" alt="" align="bottom"></td>
  </tr>

  <tr><td></td></tr>

  <tr>
    <td colspan="2"><b>ICQ-Nummer:</b></td>
    <td></td>
    <td colspan="2"><b>Kommentare:</b></td>
  </tr>
  <tr>
    <td>{..user_icq..}</td>
    <td align="right"><img src="$VAR(style_icons)user/icq.gif" alt="" align="bottom"></td>
    <td></td>
    <td>{..user_num_comments..}</td>
    <td align="right"><img src="$VAR(style_icons)user/comment.gif" alt="" align="bottom"></td>
  </tr>

  <tr><td></td></tr>

  <tr>
    <td colspan="2"><b>AIM E-Mail:</b></td>
    <td></td>
    <td colspan="2"><b>Artikel:</b></td>
  </tr>
  <tr>
    <td>{..user_aim..}</td>
    <td align="right"><img src="$VAR(style_icons)user/aim.gif" alt="" align="bottom"></td>
    <td></td>
    <td>{..user_num_articles..}</td>
    <td align="right"><img src="$VAR(style_icons)user/article.gif" alt="" align="bottom"></td>
  </tr>

  <tr><td></td></tr>

  <tr>
    <td colspan="2"><b>Windows Live ID:</b></td>
    <td></td>
    <td colspan="2"><b>Downloads:</b></td>
  </tr>
  <tr>
    <td>{..user_wlm..}</td>
    <td align="right"><img src="$VAR(style_icons)user/wlm.gif" alt="" align="bottom"></td>
    <td></td>
    <td>{..user_num_downloads..}</td>
    <td align="right"><img src="$VAR(style_icons)user/download.gif" alt="" align="bottom"></td>
  </tr>

  <tr><td></td></tr>

  <tr>
    <td colspan="2"><b>Yahoo!-ID:</b></td>
    <td></td>
    <td colspan="2"><b></b></td>
  </tr>
  <tr>
    <td>{..user_yim..}</td>
    <td align="right"><img src="$VAR(style_icons)user/yim.gif" alt="" align="bottom"></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>

  <tr><td></td></tr>

  <tr>
    <td colspan="2"><b>Skype-Name:</b></td>
    <td></td>
    <td colspan="2"><b></b></td>
  </tr>
  <tr>
    <td>{..user_skype..}</td>
    <td align="right"><img src="$VAR(style_icons)user/skype.gif" alt="" align="bottom"></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>

</table>
<!--section-end::PROFILE-->

<!--section-start::USERRANK--><div>{..group_image..}<br>
{..group_title..}</div>
<!--section-end::USERRANK-->

<!--section-start::PROFILE_EDIT--><b>Profil bearbeiten ({..user_name..})</b>
<a href="?go=user&id={..user_id..}" class="small" style="float:right;">(Profil betrachten, wie es andere sehen)</a>
<br><br>


<form action="" method="post" enctype="multipart/form-data" onSubmit="return checkUserEditForm()">
    <input type="hidden" name="go" value="user_edit">

    <table style="margin-left:-2px;" border="0" cellpadding="2" cellspacing="0">

        <tr>
            <td align="left" colspan="2">
                <b>Benutzername:</b>
            </td>

            <td align="center" valign="middle" rowspan="24" width="90">
              <img src="$VAR(style_images)line.gif" alt="">
            </td>

            <td align="left" colspan="2">
                <b>Benutzerbild:</b>
            </td>
        </tr>

        <tr>
            <td align="left">{..user_name..}</td>
            <td align="center"><img src="$VAR(style_icons)user/user.gif" alt="" align="bottom"></td>
            <td align="left"><label for="user_delete_image" class="small pointer textmiddle" style="vertical-align:middle;">Aktuelles Benutzerbild l&ouml;schen?</label></td>
            <td align="center"><input type="checkbox" class="pointer" name="user_delete_image" id="user_delete_image" value="1"></td>
        </tr>
        <tr><td></td></tr>

        <tr><td align="left" colspan="2"><b>E-Mail:</b> <span class="small">(Pflicht)</span></td></tr>
        <tr>
            <td align="left"><input class="small input input_highlight" size="33" value="{..user_mail..}" id="user_mail"  name="user_mail" maxlength="100"></td>
            <td align="center"><img src="$VAR(style_icons)user/mail.gif" alt="" align="bottom"></td>
            <td align="center" valign="middle" rowspan="9" colspan="2">{..user_image..}</td>
        </tr>
        <tr valign="middle">
            <td align="left"><label for="user_show_mail" class="small pointer textmiddle" style="vertical-align:middle;">E-Mail im &ouml;ffentlichen Profil anzeigen?</label></td>
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


        <tr><td align="left" colspan="2"><b>Nur bei einer Passwort&auml;nderung:</b></td></tr>
        <tr><td></td></tr>
        <tr>
          <td align="left" colspan="2"><b>Aktuelles Passwort:</b></td>
          <td align="left" colspan="2"><b>Neues Passwort:</b></td>
        </tr>
        <tr>
            <td align="left"><input class="small input input_highlight" size="33" id="old_pwd" name="old_pwd" type="password" maxlength="50" autocomplete="off"></td>
            <td align="center"><img src="$VAR(style_icons)user/key.gif" alt="" align="bottom"></td>
            <td align="left"><input class="small input input_highlight" size="33" id="new_pwd" name="new_pwd" type="password" maxlength="50" autocomplete="off"></td>
            <td align="center"><img src="$VAR(style_icons)user/key-add.gif" alt="" align="bottom"></td>
        </tr>
        <tr><td></td></tr>

        <tr>
          <td colspan="2"></td>
          <td align="left" colspan="2"><b>Neues Passwort wiederholen:</b></td></tr>
        <tr>
          <td colspan="2"></td>
          <td align="left"><input class="small input input_highlight" size="33" id="wdh_pwd" name="wdh_pwd" type="password" maxlength="50" autocomplete="off"></td>
          <td align="center"><img src="$VAR(style_icons)user/key-action.gif" alt="" align="bottom"></td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td align="center" colspan="5">
                <button class="pointer" type="submit" name="user_edit"><img src="$VAR(style_icons)user/unlock.gif" alt="" align="bottom"> Profil speichern</button>
       </td></tr>

    </table>
</form>
<!--section-end::PROFILE_EDIT-->

<!--section-start::USERLIST--><b>Mitgliederliste</b><br><br>

<table style="margin-left:-2px;" border="0" cellpadding="2" cellspacing="0" width="100%">

  <tr align="center">
    <td class="left bottom" width="25%">
      <a href="{..order_name..}">
        <img src="$VAR(style_icons)user/user.gif" alt="Benutzername" title="Benutzername" align="bottom">
        <br>{..arrow_name..}
      </a>
    </td>
    <td class="left bottom" width="35%">
      <a href="{..order_mail..}">
        <img src="$VAR(style_icons)user/mail.gif" alt="E-Mail" title="E-Mail" align="bottom">
        <br>{..arrow_mail..}
      </a>
    </td>
    <td class="left bottom" width="110">
      <a href="{..order_reg_date..}">
        <img src="$VAR(style_icons)user/date.gif" alt="Registriert seit" title="Registriert seit" align="bottom">
        <br>{..arrow_reg_date..}
      </a>
    </td>
    <td class="bottom center" width="20">
      <a href="{..order_num_news..}">
        <img src="$VAR(style_icons)user/news.gif" alt="News" title="News" align="bottom">
        <br>{..arrow_num_news..}
      </a>
    </td>
    <td class="bottom center" width="20">
      <a href="{..order_num_comments..}">
        <img src="$VAR(style_icons)user/comment.gif" alt="Kommentare" title="Kommentare" align="bottom">
        <br>{..arrow_num_comments..}
      </a>
    </td>
    <td class="bottom center" width="20">
      <a href="{..order_num_articles..}">
        <img src="$VAR(style_icons)user/article.gif" alt="Artikel" title="Artikel" align="bottom">
        <br>{..arrow_num_articles..}
      </a>
    </td>
    <td class="bottom center" width="20">
      <a href="{..order_num_downloads..}">
        <img src="$VAR(style_icons)user/download.gif" alt="Downloads" title="Downloads" align="bottom">
        <br>{..arrow_num_downloads..}
      </a>
    </td>
  </tr>
  {..user_lines..}
</table>

<br><br>

<div align="center">
  {..page_nav..}
</div><!--section-end::USERLIST-->

<!--section-start::USERLIST_USERLINE-->  <tr class="small" align="center">
    <td class="left">
      <a href="{..user_url..}" class="small">{..user_name..}</a>
    </td>
    <td class="left">
      {..user_mail..}
    </td>
    <td class="left">
      {..user_reg_date..}
    </td>
    <td>
      {..user_num_news..}
    </td>
    <td>
      {..user_num_comments..}
    </td>
    <td>
      {..user_num_articles..}
    </td>
     <td>
       {..user_num_downloads..}
     </td>
  </tr><!--section-end::USERLIST_USERLINE-->

<!--section-start::USERLIST_STAFFLINE-->  <tr class="small"  align="center">
    <td class="left">
      <a href="{..user_url..}" class="small"><b>{..user_name..}</b></a>
    </td>
    <td class="left">
      {..user_mail..}
    </td>
    <td class="left">
      {..user_reg_date..}
    </td>
    <td>
      {..user_num_news..}
    </td>
    <td>
      {..user_num_comments..}
    </td>
    <td>
      {..user_num_articles..}
    </td>
     <td>
       {..user_num_downloads..}
     </td>
  </tr><!--section-end::USERLIST_STAFFLINE-->

<!--section-start::USERLIST_ADMINLINE-->  <tr class="small"  align="center">
    <td class="left">
      <a href="{..user_url..}" class="small"><b>{..user_name..}</b></a>
    </td>
    <td class="left">
      {..user_mail..}
    </td>
    <td class="left">
      {..user_reg_date..}
    </td>
    <td>
      {..user_num_news..}
    </td>
    <td>
      {..user_num_comments..}
    </td>
    <td>
      {..user_num_articles..}
    </td>
     <td>
       {..user_num_downloads..}
     </td>
  </tr><!--section-end::USERLIST_ADMINLINE-->

