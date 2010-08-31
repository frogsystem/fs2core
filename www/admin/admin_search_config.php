<?php
///////////////////////
//// Update Config ////
///////////////////////
if (
        isset ( $_POST['search_num_previews'] )
        && $_POST['search_num_previews'] > 0
        && $_POST['search_num_previews'] <= 25
        && isset ( $_POST['search_min_length'] )
        && $_POST['search_min_length'] > 0
    )
{
    // Security-Functions
    settype ( $_POST['search_num_previews'], "integer" );
    settype ( $_POST['search_use_stopwords'], "integer" );
    settype ( $_POST['search_min_length'], "integer" );
    settype ( $_POST['search_index_update'], "integer" );
    settype ( $_POST['search_use_partsearch'], "integer" );
    settype ( $_POST['search_use_phonetic'], "integer" );

    // MySQL-Queries
    mysql_query ( "
                    UPDATE `".$global_config_arr['pref']."search_config`
                    SET
                        `search_num_previews` = '".$_POST['search_num_previews']."',
                        `search_use_stopwords` = '".$_POST['search_use_stopwords']."',
                        `search_min_length` = '".$_POST['search_min_length']."' ,
                        `search_use_partsearch` = '".$_POST['search_use_partsearch']."',
                        `search_use_phonetic` = '".$_POST['search_use_phonetic']."'
                    WHERE `id` = '1'
    ", $db );
    mysql_query ( "
                    UPDATE `".$global_config_arr['pref']."global_config`
                    SET
                        `search_index_update` = '".$_POST['search_index_update']."'
                    WHERE `id` = '1'
    ", $db );
    
    // Display Message
    systext ( $TEXT["admin"]->get("changes_saved"),
        $TEXT["admin"]->get("info"), FALSE, $TEXT["admin"]->get("icon_save_ok") );

    // Unset Vars
    unset ( $_POST );
}

/////////////////////
//// Config Form ////
/////////////////////

if ( TRUE )
{
    // Display Error Messages
    if ( isset ( $_POST['sended'] ) ) {
        $error_message = array();
        if (
               FALSE
            )
        {
            $error_messages[] = $TEXT["admin"]->get("form_not_filled");
        }

        if (
                $_POST['search_num_previews'] < 0 || $_POST['search_num_previews'] > 25
            )
        {
            $error_messages[] = $TEXT["admin"]->get("form_only_allowed_values");
        }

        systext ( $TEXT["admin"]->get("changes_not_saved")."<br>".implode ( "<br>", $error_messages ),
            $TEXT["admin"]->get("error"), TRUE, $TEXT["admin"]->get("icon_save_error") );
            
    // Load Data from DB into Post
    } else {
        $index = mysql_query ( "
                                SELECT *
                                FROM `".$global_config_arr['pref']."search_config`
                                WHERE `id` = '1'
        ", $db);
        $config_arr = mysql_fetch_assoc($index);
        $config_arr['search_index_update'] = $global_config_arr['search_index_update'];
        putintopost ( $config_arr );
    }
    
    // Security-Functions
    settype ( $_POST['search_num_previews'], "integer" );
    settype ( $_POST['search_use_stopwords'], "integer" );
    settype ( $_POST['search_min_length'], "integer" );
    settype ( $_POST['search_index_update'], "integer" );
    settype ( $_POST['search_use_partsearch'], "integer" );
    settype ( $_POST['search_use_phonetic'], "integer" );
    
    // Display Form
    echo '
                    <form action="" method="post">
                        <input type="hidden" name="go" value="search_config">
                        <input type="hidden" name="sended" value="1">
                        <table class="configtable" cellpadding="4" cellspacing="0">
                            <tr><td class="line" colspan="2">'.$TEXT['admin']->get("search_config_title").'</td></tr>
                            <tr>
                                <td class="config right_space">
                                    '.$TEXT['admin']->get("search_config_space_is_title").':<br>
                                    <span class="small">'.$TEXT['admin']->get("search_config_space_is_desc").'</span>
                                </td>
                                <td class="config">
                                    <input class="pointer middle" type="radio" name="search_space_is" id="space_is_and" value="AND"'.getchecked ( "AND", $_POST['search_space_is'] ).'>
                                    <label class="pointer middle" for="space_is_and">AND</label>&nbsp;&nbsp;&nbsp;
                                    <input class="pointer middle" type="radio" name="search_space_is" id="space_is_or" value="OR"'.getchecked ( "OR", $_POST['search_space_is'] ).'>
                                    <label class="pointer middle" for="space_is_or">OR</label>&nbsp;&nbsp;&nbsp;
                                    <input class="pointer middle" type="radio" name="search_space_is" id="space_is_xor" value="XOR"'.getchecked ( "XOR", $_POST['search_space_is'] ).'>
                                    <label class="pointer middle" for="space_is_xor">XOR</label>
                                </td>
                            </tr>
                            <tr>
                                <td class="config right_space">
                                    '.$TEXT['admin']->get("search_config_use_stopwords_title").':<br>
                                    <span class="small">'.$TEXT['admin']->get("search_config_use_stopwords_desc").'</span>
                                </td>
                                <td class="config">
                                    <input class="pointer" type="checkbox" name="search_use_stopwords" value="1"'.getchecked ( 1, $_POST['search_use_stopwords'] ).'>
                                </td>
                            </tr>
                            <tr>
                                <td class="config right_space">
                                    '.$TEXT['admin']->get("search_config_use_partsearch_title").':<br>
                                    <span class="small">'.$TEXT['admin']->get("search_config_use_partsearch_desc").'</span>
                                </td>
                                <td class="config">
                                    <input class="pointer" type="checkbox" name="search_use_partsearch" value="1"'.getchecked ( 1, $_POST['search_use_partsearch'] ).'>
                                </td>
                            </tr>
                            <tr>
                                <td class="config right_space">
                                    '.$TEXT['admin']->get("search_config_use_phonetic_title").':<br>
                                    <span class="small">'.$TEXT['admin']->get("search_config_use_phonetic_desc").'</span>
                                </td>
                                <td class="config">
                                    <input class="pointer middle" type="checkbox" name="search_use_phonetic" value="1"'.getchecked ( 1, $_POST['search_use_phonetic'] ).'>
                                    <span class="small middle"><b>'.$TEXT['admin']->get("search_config_use_phonetic_note").'</b></span>
                                </td>
                            </tr>
                            <tr>
                                <td class="config right_space">
                                    '.$TEXT['admin']->get("search_config_min_length_title").':<br>
                                    <span class="small">'.$TEXT['admin']->get("search_config_min_length_desc").'</span>
                                </td>
                                <td class="config">
                                    <input class="text center" name="search_min_length" maxlength="2" size="2" value="'.$_POST['search_min_length'].'">
                                    '.$TEXT['admin']->get("search_config_min_length_chars").'<br>
                                    <span class="small">('.$TEXT['admin']->get("zero_not_allowed").')</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="config right_space">
                                    '.$TEXT['admin']->get("search_config_num_previews_title").':<br>
                                    <span class="small">'.$TEXT['admin']->get("search_config_num_previews_desc").'</span>
                                </td>
                                <td class="config">
                                    <input class="text center" type="text" name="search_num_previews" maxlength="2" size="2" value="'.$_POST['search_num_previews'].'">
                                    '.$TEXT['admin']->get("search_config_num_previews_results").'<br>
                                    <span class="small">('.$TEXT['admin']->get("max").' 25)</span>
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr><td class="line" colspan="2">'.$TEXT['admin']->get("search_index_config_title").'</td></tr>
                            <tr>
                                <td class="config right_space">
                                    '.$TEXT['admin']->get("search_index_config_update_title").':<br>
                                    <span class="small">'.$TEXT['admin']->get("search_index_config_update_desc").'</span>
                                </td>
                                <td class="config">
                                    <select name="search_index_update" size="1">
                                        <option value="1" '.getselected ( 1, $_POST['search_index_update'] ).'>'.$TEXT['admin']->get("search_index_config_update_instantly").'</option>
                                        <option value="2" '.getselected ( 2, $_POST['search_index_update'] ).'>'.$TEXT['admin']->get("search_index_config_update_daily").'</option>
                                        <option value="3" '.getselected ( 3, $_POST['search_index_update'] ).'>'.$TEXT['admin']->get("search_index_config_update_never").'</option>
                                    </select>
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="buttontd" colspan="2">
                                    <button class="button_new" type="submit">
                                        '.$TEXT["admin"]->get("button_arrow").' '.$TEXT["admin"]->get("save_changes_button").'
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}
?>