function checkRegistrationForm() {
  var error = false;
  var error_text = "";

  if (
    $("#user_name").val() == ""
    || $("#user_mail").val() == ""
    || $("#new_pwd").val() == ""
    || $("#wdh_pwd").val() == ""
  ) {
    error_text = "\nEs wurden nicht alle Pflichtfelder ausgefüllt";
    error = true;
  }

  if ( $("#new_pwd").val() != $("#wdh_pwd").val() ) {
    error_text = error_text + "\nDas Passwort stimmt nicht mit der Wiederholung überein";
    error = true;
  }

  if ( error == true ) {
    alert ( "Fehler bei der Registrierung:" + error_text );
    return false;
  }
}

function checkUserEditForm() {
  var error = false;;
  var error_text = "";

  if (
    $("#user_mail").val() == ""
    || ($("#old_pwd").val() != ""
        && ($("#new_pwd").val() == ""
            || $("#wdh_pwd").val() == "" ))
  ) {
    error_text = "\nEs wurden nicht alle Pflichtfelder ausgefüllt";
    error = true;
  }

  if (
    $("#old_pwd").val() != ""
    && $("#new_pwd").val() != $("#wdh_pwd").val() ) {
    error_text = error_text + "\nDas Passwort stimmt nicht mit der Wiederholung überein";
    error = true;
  }

  if ( error == true ) {
    alert ( "Fehler bei der Registrierung:" + error_text );
    return false;
  }
}

function checkCommentForm() {
  if ( $("#comment_name").val() == "" ||
        $("#comment_title").val() == "" ||
        $("#text").val() == "" ) {
    alert ( "Es wurden nicht alle Pflichtfelder ausgefüllt" );
    return false;
  }
}

function checkNewsSearchForm() {
  if ( $("#news_search_keyword").val().length <= 2 ) {
    alert ( "Das Schlüsselwort muss min. 3 Zeichen lang sein" );
    return false;
  }
}
