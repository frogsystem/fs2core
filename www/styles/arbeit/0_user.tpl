<!--section-start::PROFILE-->
<b>Profil von {..user_name..} (ID: {..user_id..})</b><br><br>

{..user_image..}<br>
{..user_rank..}<br><br>

<table border="0" cellpadding="3" cellspacing="0">
    <tr>
        <td width="50%" valign="top">
            <b>E-Mail:</b>
        </td>
        <td width="50%">
            {..user_mail..}
        </td>
    </tr>
    <tr>
        <td width="50%" valign="top">
            <b>Homepage:</b>
        </td>
        <td width="50%">
            {..user_homepage_link..}
        </td>
    </tr>
    <tr>
        <td>
            <b>Registriert seit:</b>
        </td>
        <td>
            {..user_reg_date..}
        </td>
    </tr>
    <tr><td></td><td></td></tr>
    <tr>
        <td>
            <b>Teammitglied:</b>
        </td>
        <td>
            {..user_is_staff..}
        </td>
    </tr>
    <tr>
        <td>
            <b>Administrator:</b>
        </td>
        <td>
            {..user_is_admin..}
        </td>
    </tr>
    <tr>
        <td>
            <b>Benutzergruppe:</b>
        </td>
        <td>
            {..user_group..}
        </td>
    </tr>
    <tr><td></td><td></td></tr>
    <tr>
        <td>
            <b>ICQ-Nummer:</b>
        </td>
        <td>
            {..user_icq..}
        </td>
    </tr>
    <tr>
        <td>
            <b>AOL-Webname:</b>
        </td>
        <td>
            {..user_aim..}
        </td>
    </tr>
    <tr>
        <td>
            <b>WLM-Adresse:</b>
        </td>
        <td>
            {..user_wlm..}
        </td>
    </tr>
    <tr>
        <td>
            <b>Yahoo!-ID:</b>
        </td>
        <td>
            {..user_yim..}
        </td>
    </tr>
    <tr>
        <td>
            <b>Skype:</b>
        </td>
        <td>
            {..user_skype..}
        </td>
    </tr>
    <tr><td></td><td></td></tr>
    <tr>
        <td>
            <b>Geschriebene News:</b>
        </td>
        <td>
            {..user_num_news..}
        </td>
    </tr>
    <tr>
        <td>
            <b>Geschriebene Kommentare:</b>
        </td>
        <td>
            {..user_num_comments..}
        </td>
    </tr>
    <tr>
        <td>
            <b>Geschriebene Artikel:</b>
        </td>
        <td>
            {..user_num_articles..}
        </td>
    </tr>
    <tr>
        <td>
            <b>Hochgeladene Downloads:</b>
        </td>
        <td>
            {..user_num_downloads..}
        </td>
    </tr>
</table>
<!--section-end::PROFILE-->

<!--section-start::USERRANK-->
{..group_image..}
<div>{..group_title..}</div>
<!--section-end::USERRANK-->

<!--section-start::EDITPROFILE-->
<b>Profil bearbeiten von {..user_name..} (ID: {..user_id..})</b><br><br>

<form action="" method="post" enctype="multipart/form-data">
    <input type="hidden" name="go" value="editprofil">
    <table border="0" cellpadding="3" cellspacing="0">
        <tr>
            <td width="50%" valign="top">
                <b>Benutzerbild:</b>
            </td>
            <td width="50%">
                {..user_image..}
            </td>
        </tr>
        <tr>
            <td>
                <b>Benutzerbild hochladen:</b><br>
                <span class="small">Ersetzt ein vorhandes Benutzerbild</span>
            </td>
            <td>
                <input class="text" size="33" type="file" name="user_image"><br>
                <span class="small">[{..image_limits_text..}]</span>
            </td>
        </tr>
        <tr>
            <td>
                <b>Benutzerbild löschen:</b><br>
                <span class="small">Löscht ein vorhandes Benutzerbild</span>
            </td>
            <td>
                <input class="pointer" value="1" name="user_delete_image" type="checkbox">
            </td>
        </tr>
        <tr>
            <td>
                <b>E-Mail:</b> <span class="small">(Pflichtangabe)</span><br>
                <span class="small">Deine E-Mail Adresse</span>
            </td>
            <td>
                <input class="text" size="33" value="{..user_mail..}" name="user_mail" maxlength="50">
            </td>
        </tr>
        <tr>
            <td>
                <b>E-Mail zeigen:</b><br>
                <span class="small">Zeigt deine E-Mail Adresse im öffentlichen Profil</span>
            </td>
            <td>
                <input class="pointer" value="1" name="user_show_mail" type="checkbox"{..show_mail_checked..}>
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <br><b>Folgende Daten werden in deinem öffentlichen Profil angezeigt:</b><br>
            </td>
        </tr>
        <tr>
            <td>
                <b>Homepage:</b><br>
                <span class="small">URL zu deiner Homepage</span>
            </td>
            <td>
                <input class="text" size="33" value="{..user_homepage_url..}" name="user_homepage" maxlength="100"><br>
                <span class="small">Bitte mit vorangestelltem http:// angeben!</span>
            </td>
        </tr>
        <tr>
            <td>
                <b>ICQ-Nummer:</b><br>
                <span class="small">Deine ICQ-Nummer</span>
            </td>
            <td>
                <input class="text" size="20" value="{..user_icq..}" name="user_icq" maxlength="50">
            </td>
        </tr>
        <tr>
            <td>
                <b>AOL-Webname:</b><br>
                <span class="small">Dein AOL-Webname</span>
            </td>
            <td>
                <input class="text" size="20" value="{..user_aim..}" name="user_aim" maxlength="50">
            </td>
        </tr>
        <tr>
            <td>
                <b>WLM-Adresse:</b><br>
                <span class="small">Deine Windows Live Messanger-Adresse</span>
            </td>
            <td>
                <input class="text" size="20" value="{..user_wlm..}" name="user_wlm" maxlength="50">
            </td>
        </tr>
        <tr>
            <td>
                <b>Yahoo!-ID:</b><br>
                <span class="small">Deine Yahoo!-ID</span>
            </td>
            <td>
                <input class="text" size="20" value="{..user_yim..}" name="user_yim" maxlength="50">
            </td>
        </tr>
        <tr>
            <td>
                <b>Skype:</b><br>
                <span class="small">Dein Skype-Benutzername</span>
            </td>
            <td>
                <input class="text" size="20" value="{..user_skype..}" name="user_skype" maxlength="50">
            </td>
        </tr>
        
        <tr>
            <td colspan="2">
                <br><b>Folgende Daten musst du nur angeben, wenn du dein Passwort ändern möchtest:</b><br>
            </td>
        </tr>
        <tr>
            <td>
                <b>Altes Passwort:</b><br>
                <span class="small">Zur Sicherheit musst du zuerst dein altes Passwort eingeben</span>
            </td>
            <td>
                <input class="text" size="33" type="password" name="oldpwd" maxlength="50" autocomplete="off">
            </td>
        </tr>
        <tr>
            <td>
                <b>Neues Passwort:</b><br>
                <span class="small">Gib jetzt dein gewünschtes neues Passwort ein</span>
            </td>
            <td>
                <input class="text" size="33" type="password" name="newpwd" maxlength="50" autocomplete="off">
            </td>
        </tr>
        <tr>
            <td>
                <b>Neues Passwort wiederholen:</b><br>
                <span class="small">Wiederhole dieses Passwort jetzt nocheinmal zur Sicherheit</span>
            </td>
            <td>
                <input class="text" size="33" type="password" name="wdhpwd" maxlength="50" autocomplete="off">
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <input class="button pointer" type="submit" value="Absenden">
            </td>
        </tr>
    </table>
</form>
<!--section-end::EDITPROFILE-->