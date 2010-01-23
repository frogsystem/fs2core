<?php
///////////////////////
//// Update Config ////
///////////////////////
if (
        $_POST['search_num_previews'] && $_POST['search_num_previews'] > 0 && $_POST['search_num_previews'] <= 25
    )
{
    // Security-Functions
    settype ( $_POST['search_num_previews'], "integer" );
    settype ( $_POST['search_index_update'], "integer" );

    // MySQL-Queries
    mysql_query ( "
                    UPDATE `".$global_config_arr['pref']."search_config`
                    SET
                        `search_num_previews` = '".$_POST['search_num_previews']."'
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
        $index = mysql_query ( "
                                SELECT `search_index_update`
                                FROM `".$global_config_arr['pref']."global_config`
                                WHERE `id` = '1'
        ", $db);
        $config_arr['search_index_update'] = mysql_result ( $index, 0, "search_index_update" );
        putintopost ( $config_arr );
    }
    
    // Security-Functions
    settype ( $_POST['search_num_previews'], "integer" );
    settype ( $_POST['search_index_update'], "integer" );
    
    // Display Form
    echo '
                    <form action="" method="post">
                        <input type="hidden" name="go" value="search_config">
                        <input type="hidden" name="sended" value="1">
                        <table class="configtable" cellpadding="4" cellspacing="0">
                            <tr><td class="line" colspan="2">'.$TEXT['admin']->get("search_config_title").'</td></tr>
                            <tr>
                                <td class="config right_space">
                                    '.$TEXT['admin']->get("search_config_num_previews_title").':<br>
                                    <span class="small">'.$TEXT['admin']->get("search_config_num_previews_desc").'</span>
                                </td>
                                <td class="config">
                                    <input class="text center" name="search_num_previews" maxlength="2" size="2" value="'.$_POST['search_num_previews'].'">
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
                                        '.$admin_phrases[common][arrow].' '.$admin_phrases[common][save_long].'
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}
?>