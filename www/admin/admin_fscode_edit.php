<?php
function overview() {
    global $sql, $adminpage;
    $list = new SelectList("fscode", $adminpage->langValue("overview_topic"), true, 4);
    $list->setColumns(array(
            array($adminpage->langValue("overview_table_name")),
            array($adminpage->langValue("overview_table_added")),
            array($adminpage->langValue("overview_table_edited")),
            array("")
            ));
    $list->addAction("edit", $adminpage->langValue("overview_table_action_edit"), array("select_one"), true, true);
    $list->addAction("delete", $adminpage->langValue("overview_table_action_remove"), array("select_red"), $_SESSION['fscode_edit_remove']);
    $list->addButton();
    $list->setNoLinesText($adminpage->langValue("not_found"));

    $codes = $sql->getData("fscodes", "*");
    if ($codes != 0)
        foreach($codes as $code) {
        $list->addLine(array(
                array($code[name]),
                array(date("j.n.Y \u\m H:i ", $code[added_date]) . $adminpage->langValue("overview_table_added_by") . " <a href=\"../?go=profil&amp;userid=" . intval($code[added_user]) . "\" target=\"_blank\">" . $sql->getData("user", "user_name", "WHERE `user_id`=" . intval($code[added_user]), 1) . "</a>"),
                array($code[edited_date] != 0 ? date("j.n.Y \u\m H:i", $code[edited_date]) . $adminpage->langValue("overview_table_edited_by") . " <a href=\"../?go=profil&amp;userid=" . intval($code[edited_user]) . " target=\"_blank\">" . $sql->getData("user", "user_name", "WHERE `user_id`=" . intval($code[edited_user]), 1) . "</a>" : $adminpage->langValue("overview_table_edited_never")),
                array(true, $code[name])
                ));
    }

    return $list;
}

if ((!isset($_POST[fscode_id]) || !is_array($_POST[fscode_id]) || count($_POST[fscode_id]) == 0) && !isset($_GET[code])) { // kein fscode gewählt
    echo overview();
} else {
    $check = true;
    $code = isset($_GET[code]) ? array($_GET[code]) : $_POST[fscode_id];
    foreach($code as $item) {
        $codes[] = $sql->getData("fscodes", "*", "WHERE `name`='" . savesql($item) . "'", 1);
        if ($codes[count($codes) - 1] == 0)
            $check = false;
    }
    if ($check == false) { // fscode ist nicht definiert
        systext($adminpage->langValue("detail_not_found"), $TEXT["admin"]->get("error"), true, $TEXT["admin"]->get("icon_error"));
    } elseif ($_POST[fscode_action] == 'delete') { // fscode löschen
        if ($_SESSION[fscode_edit_remove] == 1) { // benutzer hat rechte
            $good = array();
            $evil = array();
            foreach($codes as $code) {
                if ($sql->query("DELETE FROM `{..pref..}fscodes` WHERE `name`='" . $code[name] . "'") !== false && $sql->query("DELETE FROM `{..pref..}fscodes_flag` WHERE `code`='" . $code[name] . "'")) { // löschen
                    $good[] = $code[name];
                    $filepath = FS2_ROOT_PATH . "styles/" . $global_config_arr[style_tag] . "/icons/fscode/" . $code[name];
                    if (file_exists($filepath . ".gif"))
                        unlink($filepath . ".gif");
                    elseif (file_exists($filepath . ".jpg"))
                        unlink($filepath . ".jpg");
                    elseif (file_exists($filepath . ".png"))
                        unlink($filepath . ".png");
                } else {
                    $evil[] = $code[name];
                }
            }

            if (count($good) > 0)
                systext(str_replace("{..names..}", implode(", ", $good), $adminpage->langValue("delete_deleted")), false, false, $TEXT["admin"]->get("icon_trash_ok"));
            if (count($evil) > 0)
                systext(str_replace("{..names..}", implode(", ", $evil), $adminpage->langValue("delete_notdeleted")), $TEXT["admin"]->get("error"), true, $TEXT["admin"]->get("icon_trash_error"));
        } else {
            systext($adminpage->langValue("delete_norights"), $TEXT["admin"]->get("error"), true, $TEXT["admin"]->get("icon_error"));
        }
    } else { // fscode bearbeiten
        if (!isset($_POST[editcode])) { // formular noch nicht abgeschickt
            $code = isset($_GET[code]) ? $_GET[code] : $_POST[fscode_id][0];
            $code = !isset($_POST[addflag]) ?
            array_map("stripslashes", $sql->getData("fscodes", "*", "WHERE `name`='" . savesql($code) . "'", 1)) :
            $_POST;

            $groups = $sql->getData("fscodes_groups", "*");
            if ($groups == 0) {
                $adminpage->addCond("groups", "0");
            } else {
                $othergroups = "";
                foreach($groups as $group) {
                    if (isset($code[group]) && $code[group] == $group[id])
                        $adminpage->addCond("selected", 1);

                    $adminpage->addText("id", $group[id]);
                    $adminpage->addText("name", $group[name]);
                    $othergroups .= $adminpage->get("groups");
                }
                if (!isset($code[group]) || (isset($code[group]) && intval($code[group]) == 0))
                    $adminpage->addCond("group", 0);
                $adminpage->addText("othergroups", $othergroups);
            }

            $oldcodes = $sql->getData("fscodes", "`name`", "WHERE `name`!='" . savesql($code[name]) . "'");
            $dropdowns[] = get_dropdowns("editor_param_1");
            $dropdowns[] = get_dropdowns("editor_param_2");
            if ($oldcodes != 0) {
                $codes = array();
                foreach($oldcodes as $oldcode)
                $codes[] = $oldcode[name];

                $oldcodes = "\"" . implode("\", \"", $codes) . "\"";
            } else {
                $oldcodes = "";
            }
            $flags = "";
            if (isset($_POST[flag])) {
                $i = 0;
                while ($i < count($_POST[flag][0])) {
                    if ($_POST[flag][0][$i] != "0") {
                        $adminpage->addCond("flag", $_POST[flag][0][$i]);
                        $adminpage->addCond("flagval", $_POST[flag][1][$i]);
                        $flags .= $adminpage->get("flagselect");
                    }
                    $i++;
                }
            } else {
                $_flags = $sql->getData("fscodes_flag", "*", "WHERE `code`='" . $code[name] . "'");
                if ($_flags != 0) {
                    foreach($_flags as $_flag) {
                        $adminpage->addCond("flag", $_flag[name]);
                        $adminpage->addCond("flagval", $_flag[value]);
                        $flags .= $adminpage->get("flagselect");
                    }
                }
                unset($_flags, $_flagnames, $_flag);
            }

            $allowin = explode("&#44;", $code[allowin]);

            if (count($allowin) == 4) {
                $allowin = array_map("trim", $allowin);
                if (in_array("inline", $allowin) && in_array("block", $allowin) && in_array("listitem", $allowin) && in_array("link", $allowin))
                    $allowin = true;
                else
                    $allowin = false;
            } else {
                $allwoin = false;
            }

            if ($code[contenttype] == "inline" &&   // contenttype: inline
                $allowin &&                         // allowed in: inline, block, listitem, link
                $code[disallowin] == "" &&          // no explict disallowence defined
                $code[callbacktype] == 0 &&         // callback-type: calllback_replace
                $code[php] == "" &&                 // no php-code
                $sql->getData("fscodes_flag", "*", "WHERE `code`=" . $code[id], 2) == 0) // no flags defined
                $adminpage->addCond("simple", 1);
            else
                $adminpage->addCond("advanced", 1);

            if (isset($_GET[mode]) || $_GET[mode] == "advanced")
                $adminpage->addCond("advanced", 1);
            // conditions
            $adminpage->addCond("name",             $code[name]);
            $adminpage->addCond("callbacktype",     $code[callbacktype]);
            $adminpage->addCond("active",           $code[active]);
            $adminpage->addCond("php",              $_SESSION[fscode_add_php]);
            // phrases
            $adminpage->addText("id",               $code[id]);
            $adminpage->addText("codenames",        $oldcodes);
            $adminpage->addText("FSROOT",           FS2_ROOT_PATH);
            $adminpage->addText("name",             $code[name]);
            $adminpage->addText("oldname",          isset($_POST[oldname]) ? $_POST[oldname] : $code[name]);
            $adminpage->addText("contenttype",      $code[contenttype]);
            $adminpage->addText("allowin",          $code[allowin]);
            $adminpage->addText("disallowin",       $code[disallowin]);
            $adminpage->addText("flags",            $flags);
            $adminpage->addText("global_vars_1",    $dropdowns[0]['global_vars']);
            $adminpage->addText("applets_1",        $dropdowns[0]['applets']);
            $adminpage->addText("snippets_1",       $dropdowns[0]['snippets']);
            $adminpage->addText("global_vars_2",    $dropdowns[1]['global_vars']);
            $adminpage->addText("applets_2",        $dropdowns[1]['applets']);
            $adminpage->addText("snippets_2",       $dropdowns[1]['snippets']);
            $adminpage->addText("taglist_1",        get_taglist(array(array(tag => "x", text => "Der angegebene Parameter")), "param_1"));
            $adminpage->addText("taglist_2",        get_taglist(array(array(tag => "x", text => "Der \"Inhalt\" des Codes.<br>[code='Parameter']<b>Inhalt</b>[/code]"), array(tag => "y", text => "Der Parameter des Codes.<br>[code='<b>Parameter</b>']Inhalt[/code]")), "param_2"));
            $adminpage->addText("value_1",          $code[param_1]);
            $adminpage->addText("value_2",          $code[param_2]);
            $adminpage->addText("value_php",        $code[php]);
            $adminpage->addText("submitarrow",      $admin_phrases[common][arrow]);
            $adminpage->addText("submittext",       $admin_phrases[common][save_long]);

            echo $adminpage->get("detail");
        } else { // formular abgeschickt
            if (isset($_POST[name]) && (isset($_POST[param_1]) || (isset($_POST[php]) && $_SESSION[fscode_add_php] == 1))) {
                $codes = $sql->getData("fscodes", "name", "WHERE `name`!='" . savesql($_POST[oldname]) . "'");
                if (!in_array($_POST[name], $codes)) {
                    if (preg_match("#[^a-zA-Z-_]+#", $_POST[name]) == 0 || $_POST[oldname] == $_POST[name]) {
                        $post = savesql($_POST);
                        $post[param_1] = str_replace(",", "&#44;", $post[param_1]);
                        $post[param_2] = (!isset($post[param_2]) || empty($post[param_2]))?$post[param_1]:str_replace(",", "&#44;", $post[param_2]);
                        $post[php] = $_SESSION[fscode_edit_php] == 1 ? str_replace(",", "&#44;", $post[php]) : "";
                        $post[contenttype]  = str_replace(",", "&#44;", $post[contenttype]);
                        $post[allowin]      = str_replace(",", "&#44;", $post[allowin]);
                        $post[disallowin]   = str_replace(",", "&#44;", $post[disallowin]);
                        $sql->updateData("fscodes",
                            "name, contenttype, callbacktype, allowin, disallowin, param_1, param_2, php, active, edited_date, edited_user",
                            $post[name] . ", " . $post[contenttype] . ", " . $post[callbacktype] . ", " . $post[allowin] . ", " . $post[disallowin] . ", " . $post[param_1] . ", " . $post[param_2] . ", " . $post[php] . ", " . $post[active] . ", " . time() . ", " . $_SESSION[user_id], "WHERE `name`='" . $post[oldname] . "'");
                        $sql->deleteData("fscodes_flag", "`code`='" . $post[name] . "'");

                        $flags = array(2, 5, 3, 3, 3, 3, 3, 2);
                        for($i = 0; $i < count($_POST[flag][0]); $i++) {
                            $flag = array(intval($_POST[flag][0][$i]), intval($_POST[flag][1][$i]));
                            if ($flag[0] != 0 && $flag[0] <= count($flags) && $flag[1] < $flags[$flag[0] - 1]) {
                                $sql->setData("fscodes_flag", "code, name, value", $post[name] . ", " . $flag[0] . ", " . $flag[1]);
                            }
                        }
                        if ($_FILES[icon][error] != 4) { // es wurde ein icon hochgeladen
                            $tmp = $sql->getData("fscodes_config", "*");
                            foreach($tmp as $conf)
                            $fileconfig[$conf[type]] = $conf[value];
                            unset($conf, $tmp);
                            if ($notice = upload_img($_FILES[icon], "media/fscode-images/", $name, $fileconfig[file_size], $fileconfig[file_width], $fileconfig[file_height]) != 0)
                                systext(upload_img_notice($notice), $TEXT["admin"]->get("error"), true, $TEXT["admin"]->get("icon_save_error"));
                        }
                        systext($adminpage->langValue("error_1"), $TEXT["admin"]->get("changes_saved"), false, $TEXT["admin"]->get("icon_save_ok"));
                    } else
                        systext($adminpage->langValue("error_2"), $TEXT["admin"]->get("error"), true, $TEXT["admin"]->get("icon_save_error"));
                } else
                    systext($adminpage->langValue("error_3"), $TEXT["admin"]->get("error"), true, $TEXT["admin"]->get("icon_save_error"));
            } else
                systext($adminpage->langValue("error_4"), $TEXT["admin"]->get("error"), true, $TEXT["admin"]->get("icon_save_error"));
        }
    }
}

?>