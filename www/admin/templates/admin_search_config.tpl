<!--section-start::main-->
<form action="" method="post">
<input type="hidden" name="go" value="search_config">
<input type="hidden" name="sended" value="1">

    <table class="content config" cellpadding="0" cellspacing="0">
        <tr><td colspan="2"><h3><!--LANG::search_config_title--></h3><hr></td></tr>

        <tr>
            <td>
                <!--LANG::num_previews_title-->:<br>
                <span class="small"><!--LANG::num_previews_desc--></span>
            </td>
            <td>
                <input class="center" name="search_num_previews" maxlength="2" size="3" value="<!--TEXT::search_num_previews-->">
                <!--COMMON::results--><br>
                <span class="small">[<!--COMMON::max--> 25]</span>
            </td>
        </tr>

        <tr>
            <td>
                <!--LANG::allow_phonetic_title-->:<br>
                <span class="small"><!--LANG::allow_phonetic_desc--></span>
            </td>
            <td>
                <!--COMMON::checkbox-->
                <input class="hidden" type="checkbox" name="search_allow_phonetic" value="1" <!--IF::search_allow_phonetic-->checked<!--ENDIF-->>
            </td>
        </tr>

        <tr>
            <td>
                <!--LANG::and_title-->:<br>
                <span class="small"><!--LANG::and_desc--></span>
            </td>
            <td>
                <input class="half" name="search_and" maxlength="255" size="20" value="<!--TEXT::search_and-->">
                <span class="small">[<!--COMMON::csv-->]</span>
            </td>
        </tr>
        <tr>
            <td>
                <!--LANG::or_title-->:<br>
                <span class="small"><!--LANG::or_desc--></span>
            </td>
            <td>
                <input class="half" name="search_or" maxlength="255" size="20" value="<!--TEXT::search_or-->">
                <span class="small">[<!--COMMON::csv-->]</span>
            </td>
        </tr>
        <tr>
            <td>
                <!--LANG::xor_title-->:<br>
                <span class="small"><!--LANG::xor_desc--></span>
            </td>
            <td>
                <input class="half" name="search_xor" maxlength="255" size="20" value="<!--TEXT::search_xor-->">
                <span class="small">[<!--COMMON::csv-->]</span>
            </td>
        </tr>
        <tr>
            <td>
                <!--LANG::not_title-->:<br>
                <span class="small"><!--LANG::not_desc--></span>
            </td>
            <td>
                <input class="half" name="search_not" maxlength="255" size="20" value="<!--TEXT::search_not-->">
                <span class="small">[<!--COMMON::csv-->]</span>
            </td>
        </tr>
        <tr>
            <td>
                <!--LANG::wildcard_title-->:<br>
                <span class="small"><!--LANG::wildcard_desc--></span>
            </td>
            <td>
                <input class="half" name="search_wildcard" maxlength="255" size="20" value="<!--TEXT::search_wildcard-->">
                <span class="small">[<!--COMMON::csv-->]</span>
            </td>
        </tr>


        <tr><td colspan="2"><h3><!--LANG::search_index_title--></h3><hr></td></tr>

        <tr>
            <td>
                <!--LANG::index_update_title-->:<br>
                <span class="small"><!--LANG::index_update_desc--></span>
            </td>
            <td>
                <select name="search_index_update" size="1">
                    <option value="1" <!--IF::search_index_update_1-->selected<!--ENDIF-->><!--LANG::index_update_instantly--></option>
                    <option value="2" <!--IF::search_index_update_2-->selected<!--ENDIF-->><!--LANG::index_update_daily--></option>
                    <option value="3" <!--IF::search_index_update_3-->selected<!--ENDIF-->><!--LANG::index_update_never--></option>
                </select>
            </td>
        </tr>

        <tr>
            <td>
                <!--LANG::use_stopwords_title-->:<br>
                <span class="small"><!--LANG::use_stopwords_desc--></span>
            </td>
            <td>
                <!--COMMON::checkbox-->
                <input class="hidden" type="checkbox" name="search_use_stopwords" value="1" <!--IF::search_use_stopwords-->checked<!--ENDIF-->>
            </td>
        </tr>

        <tr>
            <td>
                <!--LANG::min_word_length_title-->:<br>
                <span class="small"><!--LANG::min_word_length_desc--></span>
            </td>
            <td>
                <input class="center" name="search_min_word_length" maxlength="3" size="4" value="<!--TEXT::search_min_word_length-->">
                <!--COMMON::chars--><br>
            </td>
        </tr>



        <tr>
            <td colspan="2">
                <button class="button" type="submit">
                    <!--COMMON::button_arrow--> <!--COMMON::save_changes_button-->
                </button>
            </td>
        </tr>
    </table>
</form>
<!--section-end::main-->
