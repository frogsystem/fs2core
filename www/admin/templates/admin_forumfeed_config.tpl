<!--section-start::main-->
<form action="" method="post">
  <input type="hidden" name="go" value="forumfeed_config">
  <input type="hidden" name="sended" value="1">

  <table class="content config" cellpadding="0" cellspacing="0">
    <tr><td colspan="2"><h3><!--LANG::pageinfo_title--></h3><hr></td></tr>

    <tr>
      <td>
        <!--LANG::feed_url-->:<br>
        <span class="small"><!--LANG::feed_url_desc--></span>
      </td>
      <td>
        <input class="half" name="feed_url" maxlength="100" value="<!--TEXT::feed_url-->"><br>
        <span class="small">(<!--LANG::feed_notes-->)</span>
      </td>
    </tr>

    <tr>
      <td>
        <!--LANG::thread_limit-->:<br>
        <span class="small"><!--LANG::thread_limit_desc--></span>
      </td>
      <td>
        <input class="center" size="2" name="thread_limit" maxlength="2" value="<!--TEXT::thread_limit-->"><br>
        <span class="small">(<!--COMMON::zero_not_allowed-->)</span>
      </td>
    </tr>

    <tr>
      <td>
        <!--LANG::title_max-->:<br>
        <span class="small"><!--LANG::title_max_desc--></span>
      </td>
      <td>
        <input class="center" size="2" name="title_max" maxlength="2" value="<!--TEXT::title_max-->"> <!--COMMON::chars--><br>
        <span class="small">(<!--COMMON::zero_not_allowed-->)</span>
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
