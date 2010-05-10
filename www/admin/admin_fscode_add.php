<?php
if($_POST){
  if(isset($_POST[name])          && !empty($_POST[name])         &&
     isset($_POST[contenttype])   && !empty($_POST[contenttype])  &&
     isset($_POST[allowedin])     && !empty($_POST[allowedin])    &&
     (isset($_POST[callbacktype]) && !empty($_POST[callbacktype]) || intval($_POST[callbacktype]) == 0) &&
     ((isset($_POST[param_1])     && !empty($_POST[param_1]))     ||
     (isset($_POST[php])          && !empty($_POST[php])          && $_SESSION[fscode_add_php] == 1))){
    $codes = $sql->getData("fscodes", "name");
    if(!in_array($_POST[name], $codes)){
      $name         = savesql($_POST[name]);
      $content      = savesql($_POST[contenttype]);
      $allow        = savesql($_POST[allowedin]);
      $disallow     = savesql($_POST[disallowedin]);
      $callback     = intval($_POST[callbacktype]);
        $callback   = ($callback > 6 || $callback < 0)  ? 0 : $callback;
      $active       = ($_POST[isactive] == "1")         ? 1 : 0;
      $paragraphes  = ($_POST[paragraphes] == "1")      ? 1 : 0;
      $param_1      = savesql($_POST[param_1]);
      $param_2      = savesql($_POST[param_1]);
      $php          = ($_SESSION[fscode_add_php]) ? savesql($_POST[php]) : "";
      if($sql->setData("fscodes",
                      "`name`, ".
                      "`contenttype`, ".
                      "`callbacktype`, ".
                      "`allowin`, ".
                      "`disallowin`, ".
                      "`param_1`, ".
                      "`param_2`, ".
                      "`php`, ".
                      "`active`, ".
                      "`allowparagraphes`",
                      "'".$name."', ".
                      "'".$content."', ".
                      "'".$callback."', ".
                      "'".$allow."', ".
                      "'".$disallow."', ".
                      "'".$param_1."', ".
                      "'".$param_2."', ".
                      "'".$php."', ".
                      "'".$active."', ".
                      "'".$paragraphes."'")){
        unset($_POST, $name, $contant, $allow, $disallow, $callback, $active, $paragraphes, $param_1, $param_2, $php);
        systext("Code erfolgreich gespeichert.", $TEXT["admin"]->get("changes_saved"), FALSE, $TEXT["admin"]->get("icon_save_ok"));
      } else {
        unset($name, $contant, $allow, $disallow, $callback, $active, $paragraphes, $param_1, $param_2, $php);
        systext("Der Code konnte nicht hinzugefügt werden.<br>SQL meldet: ".$sql->error[0]." : ".$sql->error[1], $TEXT["admin"]->get("error"), TRUE, $TEXT["admin"]->get("icon_save_error"));
      }

    } else
      systext("Ein Code mit diesem Namen existiert bereits!", $TEXT["admin"]->get("error"), TRUE, $TEXT["admin"]->get("icon_save_error"));
  } else
    systext("Fülle alle Pflichtfelder aus!", $TEXT["admin"]->get("error"), TRUE, $TEXT["admin"]->get("icon_save_error"));
}
$dropdowns[] = get_dropdowns("editor_param_1");
$dropdowns[] = get_dropdowns("editor_param_2");
?>
          <form action="" method="post" enctype="multipart/form-data">
            <script type="text/javascript">
              <!--
                Array.prototype.contains = function(val){
                  for(var i = 0; i < this.length; i++)
                    if(this[i] == val)
                      return true;

                  return false;
                }

                var definedcodes = new Array(<?
$oldcodes = $sql->getData("fscodes", "`name`");
if($oldcodes != 0){
  $codes = array();
  foreach($oldcodes as $code)
    $codes[] = $code[name];

  echo "\"".implode("\", \"", $codes)."\"";
}
?>);
                function checkcode(){
                  if(definedcodes.contains($('#codename').val()))
                    $('#namehint').css("display", "table-row");
                  else
                    $('#namehint').css("display", "none");
                }
              //-->
            </script>
            <script src="<?=FS2_ROOT_PATH?>resources/codemirror/js/codemirror.js" type="text/javascript"></script>
            <!-- CSS-Definitions for IE-Browsers -->
            <!--[if IE]>
                <style type="text/css">
                    .html-editor-list-popup {
                        margin-top:20px;
                    }
                    .html-editor-container-list {
                        z-index:1;
                    }
                </style>
            <![endif]-->

            <!-- CSS-Definitions for Non-JS-Editor -->
            <noscript>
                <style type="text/css">
                    .html-editor-row {
                        display:none;
                    }
                    .html-editor-row-header {
                        border:none;
                    }
                    .html-editor-path .html-editor-highlighter {
                        display:none;
                    }
                </style>
            </noscript>
            <input type="hidden" value="fscode_add" name="go">
            <table border="0" cellpadding="4" cellspacing="0" width="600">
              <tr>
                <td class="line" colspan="2">
                  FS-Code definieren
                </td>
              </tr>
              <tr>
                <td colspan="2" class="space"></td>
              </tr>
              <tr>
                <td class="config" valign="top">
                  Name des Codes
                </td>
                <td class="config" valign="top">
                  <input type="text" name="name" onkeyup="checkcode();" id="codename" class="text input_width" value="<?=$_POST[name]?>">
                </td>
              </tr>
              <tr id="namehint" style="display: none;">
                <td colspan="2"  class="config" style="text-align: right;">
                  Hinweis: Ein FS-Code mit diesem Namen existiert bereits.
                </td>
              </tr>
              <tr>
                <td class="config" valign="top">
                  Inhaltstyp
                </td>
                <td class="config" valign="top">
                  <input type="text" name="contenttype" id="conenttype" class="text input_width" value="<?=$_POST[contenttype]?>">
                </td>
              </tr>
              <tr>
                <td class="config" valign="top">
                  Erlaubt in
                </td>
                <td class="config" valign="top">
                  <input type="text" name="allowedin" value="<?=$_POST[allowedin]?>" id="allowedin" class="text input_width">
                </td>
              </tr>
              <tr>
                <td class="config" valign="top">
                   Nicht erlaubt in
                </td>
                <td class="config" valign="top">
                  <input type="text" name="disallowedin" value="<?=$_POST[disallowedin]?>" id="disallowedin" class="text input_width">
                </td>
              </tr>
              <tr>
                <td class="config" valign="top">
                   Ersetzungsart
                </td>
                <td class="config" valign="top">
                  <select name="callbacktype" class="input_width">
                    <option value="0" <?=getselected($_POST[callbacktype], "0")?>>simple_replace</option>
                    <option value="1" <?=getselected($_POST[callbacktype], "1")?>>simple_replace_single</option>
                    <option value="2" <?=getselected($_POST[callbacktype], "2")?>>callback_replace</option>
                    <option value="3" <?=getselected($_POST[callbacktype], "3")?>>callback_replace_single</option>
                    <option value="4" <?=getselected($_POST[callbacktype], "4")?>>usecontent</option>
                    <option value="5" <?=getselected($_POST[callbacktype], "5")?>>usecontent?</option>
                    <option value="6" <?=getselected($_POST[callbacktype], "6")?>>callback_replace?</option>
                  </select>
                </td>
              </tr>
              <tr>
                <td class="config" valign="top">
                   Code aktivieren
                </td>
                <td class="config" valign="top">
                  <input type="radio" name="isactive" value="1" <?=count($_POST)>0?getchecked($_POST[isactive], "0"):"checked"?>> Ja<br>
                  <input type="radio" name="isactive" value="0" <?=getchecked($_POST[isactive], "0")?>> Nein<br>
                </td>
              </tr>
              <tr>
                <td class="config" valign="top">
                   Zeilenumbr&uuml;che innerhalb des Codes erlauben
                </td>
                <td class="config" valign="top">
                  <input type="radio" name="paragraphes" value="1" <?=count($_POST)>0?getchecked($_POST[paragraphes], "0"):"checked"?>> Ja<br>
                  <input type="radio" name="paragraphes" value="0" <?=getchecked($_POST[paragraphes], "0")?>> Nein<br>
                </td>
              </tr>
              <tr>
                <td colspan="2" class="space"></td>
              </tr>
              <tr>
                <td class="line" colspan="2">
                  Ersetzungstext
                </td>
              </tr>
              <tr>
                <td class="config" valign="top" colspan="2">
                  <!-- Editor-Bars with Buttons and Dropdowns -->

                  <div class="html-editor-bar" id="param_1_editor-bar">
                    <div class="html-editor-row-header">
                      <span id="param_1_title">Ersetzung wenn ein Parameter angegeben ist</span>
                      <span class="small">(Syntax: [code]Parameter[/code])</span>
                    </div>
                    <div class="html-editor-row">
                      <div class="html-editor-button html-editor-button-active html-editor-button-line-numbers" onClick="toggelLineNumbers(this,'editor_param_1')" title="Zeilen-Nummerierung">
                          <img src="img/null.gif" alt="Zeilen-Nummerierung" border="0">
                      </div>
                      <?=get_taglist(array(array(tag => "x", text => "Der angegebene Parameter")), "param_1" );?>
                      <?=$dropdowns[0]['global_vars']?>
                      <?=$dropdowns[0]['applets']?>
                      <?=$dropdowns[0]['snippets']?>
                    </div>
                  </div>

                  <!-- Editor and original Editor -->

                  <div id="param_1_content" style="background-color:#ffffff; border: 1px solid #999999; width:100%;">
                    <textarea class="no-js-html-editor"  rows="20" cols="66" name="param_1" id="param_1"><?=htmlspecialchars(stripslashes($_POST[param_1]))?></textarea>
                  </div>
                  <script type="text/javascript">
                    editor_param_1 = new_editor ( "param_1", "325", false, 1 );
                  </script>

                  <!-- Footer and the rest -->

                  <div class="html-editor-path" id="param_1_footer">
                    <div style="padding:2px; height:13px;" class="small">
                      <span class="html-editor-highlighter">HTML</span>
                    </div>
                  </div>
                </td>
              </tr>
              <tr><td class="space"></td></tr>
              <tr>
                <td class="config" valign="top" colspan="2">
                  <!-- Editor-Bars with Buttons and Dropdowns -->

                  <div class="html-editor-bar" id="param_2_editor-bar">
                    <div class="html-editor-row-header">
                      <span id="param_2_title">Ersetzung wenn beide Parameter angegeben sind</span>
                      <span class="small">(Syntax: [code='Parameter']Inhalt[/code])</span>
                    </div>
                    <div class="html-editor-row">
                      <div class="html-editor-button html-editor-button-active html-editor-button-line-numbers" onClick="toggelLineNumbers(this,'editor_param_2')" title="Zeilen-Nummerierung">
                          <img src="img/null.gif" alt="Zeilen-Nummerierung" border="0">
                      </div>
                      <?=get_taglist(array(array(tag => "x", text => "Der \"Inhalt\" des Codes.<br>[code='Parameter']<b>Inhalt</b>[/code]"), array(tag => "y", text  => "Der Parameter des Codes.<br>[code='<b>Parameter</b>']Inhalt[/code]")), "param_2" );?>
                      <?=$dropdowns[1]['global_vars']?>
                      <?=$dropdowns[1]['applets']?>
                      <?=$dropdowns[1]['snippets']?>
                    </div>
                  </div>

                  <!-- Editor and original Editor -->

                  <div id="param_2_content" style="background-color:#ffffff; border: 1px solid #999999; width:100%;">
                    <textarea class="no-js-html-editor" rows="20" cols="66" name="param_2" id="param_2"><?=htmlspecialchars(stripslashes($_POST[param_2]))?></textarea>
                  </div>
                  <script type="text/javascript">
                    editor_param_2 = new_editor ( "param_2", "325", false, 1 );
                  </script>

                  <!-- Footer and the rest -->

                  <div class="html-editor-path" id="param_2_footer">
                    <div style="padding:2px; height:13px;" class="small">
                      <span class="html-editor-highlighter">HTML</span>
                    </div>
                  </div>
                </td>
              </tr>
              <?if($_SESSION[fscode_add_php]):?>
              <tr><td class="space"></td></tr>
              <tr>
                <td class="config" valign="top" colspan="2">
                  <!-- Editor-Bars with Buttons and Dropdowns -->

                  <div class="html-editor-bar" id="php_editor-bar">
                    <div class="html-editor-row-header">
                      <span id="php_title">PHP-Code</span>
                    </div>
                    <div class="html-editor-row">
                      <div class="html-editor-button html-editor-button-active html-editor-button-line-numbers" onClick="toggelLineNumbers(this,'editor_php')" title="Zeilen-Nummerierung">
                          <img src="img/null.gif" alt="Zeilen-Nummerierung" border="0">
                      </div>
                      <?=$dropdowns[1]['global_vars']?>
                      <?=$dropdowns[1]['applets']?>
                      <?=$dropdowns[1]['snippets']?>
                    </div>
                  </div>

                  <!-- Editor and original Editor -->

                  <div id="php_content" style="background-color:#ffffff; border: 1px solid #999999; width:100%;">
                    <textarea class="no-js-html-editor" rows="20" cols="66" name="php" id="php"><?=htmlspecialchars(stripslashes($_POST[php]))?></textarea>
                  </div>
                  <script type="text/javascript">
                    editor_php = new_editor ( "php", "325", false, 4 );
                  </script>

                  <!-- Footer and the rest -->

                  <div class="html-editor-path" id="php_footer">
                    <div style="padding:2px; height:13px;" class="small">
                      <span class="html-editor-highlighter">PHP</span>
                    </div>
                  </div>
                </td>
              </tr>
              <?endif;?>
              <tr><td class="space"></td></tr>
              <tr>
                <td colspan="2" class="buttontd">
                  <button class="button_new" type="submit">
                    <?=$admin_phrases[common][arrow]?>
                    <?=$admin_phrases[common][save_long]?>
                  </button>
                </td>
              </tr>
            </table>
          </form>