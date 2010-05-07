<!--section-start::DOC_MAINPAGE--><b>
  Sie befinden sich hier:
  FS2-API-Dokumentation
</b>
<br><br>


<table style="width: 100%;" cellpadding="3" cellspacing="0">
  <thead>
    <tr>
      <td colspan="3" style="background-color: #F2F2F2; border: 1px solid #E2E2E2; height: 100%;">
        <b>FS2-API Dokumentation</b>
      </td>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td style="width: 0pt; border-left: 1px solid #E2E2E2;"></td>
      <td>
        Dies ist die Frogsystem2.alix5-API-Dokumentation.<br>
        Das Frogsystem2.alix5 stellt einige Klassen und Funktionen zu Vefügung, die das Arbeiten mit dem Frogsystem2 vereinfachen.
      </td>
      <td style="width: 0pt; border-right: 1px solid #E2E2E2;"></td>
    </tr>
    <tr>
      <td colspan="3" style="border-top: 1px solid #E2E2E2;"></td>
    </tr>
  </tbody>
</table>

<table style="width: 100%; display: none;" cellpadding="3" cellspacing="0" id="configtable">
  <thead>
    <tr>
      <td colspan="3" style="background-color: #F2F2F2; border: 1px solid #E2E2E2; height: 100%;">
        <b>Einstellungen</b>
      </td>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td style="width: 0pt; border-left: 1px solid #E2E2E2;"></td>
      <td>
        <input type="checkbox" id="showprivate" onclick="hideprivate();" checked>
        Private Funktionen anzeigen
        <br>
        <input type="checkbox" id="showprotected" onclick="hideproctcted();" checked>
        Geschützte Funktionen anzeigen
        <br>
      </td>
      <td style="width: 0pt; border-right: 1px solid #E2E2E2;"></td>
    </tr>
    <tr>
      <td colspan="3" style="border-top: 1px solid #E2E2E2;"></td>
    </tr>
  </tbody>
</table>

<table style="width: 100%;" cellpadding="3" cellspacing="0">
  <thead>
    <tr>
      <td colspan="3" style="background-color: #F2F2F2; border: 1px solid #E2E2E2; height: 100%;">
        <b>Klassen</b>
      </td>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td style="width: 0pt; border-left: 1px solid #E2E2E2;"></td>
      <td>
        {..classes..}
      </td>
      <td style="width: 0pt; border-right: 1px solid #E2E2E2;"></td>
    </tr>
    <tr>
      <td colspan="3" style="border-top: 1px solid #E2E2E2;"></td>
    </tr>
  </tbody>
</table>

<table style="width: 100%;" cellpadding="3" cellspacing="0">
  <thead>
    <tr>
      <td colspan="3" style="background-color: #F2F2F2; border: 1px solid #E2E2E2; height: 100%;">
        <b>Funktionen</b>
      </td>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td style="width: 0pt; border-left: 1px solid #E2E2E2;"></td>
      <td>
        <b>Hinweis:</b>
        Die Funktionen sollen Schritt für Schritt in den nächsten Versionen entfernt werden.<br>
        Es wird also empfolen, sich nicht blind auf die Erreichbarkeit einer Funktion zu beschränken.<br><br>
        {..functions..}
      </td>
      <td style="width: 0pt; border-right: 1px solid #E2E2E2;"></td>
    </tr>
    <tr>
      <td colspan="3" style="border-top: 1px solid #E2E2E2;"></td>
    </tr>
  </tbody>
</table>

<script type="text/javascript">
  <!--
    document.getElementsByClassName = function(classname){
      var nodes = document.getElementsByTagName("*");
      var ret = new Array();
      var retcount = 0;
      for(var i=0;i<nodes.length;i++){
        if(nodes[i].className==classname){
          ret[retcount++]=nodes[i];
        }
      }
      return ret;
    }

    document.getElementById('configtable').style.display='table';

    function hideprivate(){
      var private = document.getElementsByClassName('private');
      for(var i = 0 ; i < private.length ; i++)
        private[i].style.display = (document.getElementById('showprivate').checked == false) ? 'none' : 'block';
    }

    function hideprotected(){
      var private = document.getElementsByClassName('protected');
      for(var i = 0 ; i < private.length ; i++)
        private[i].style.display = (document.getElementById('showprotected').checked == false) ? 'none' : 'block';
    }

  //-->
</script>
<!--section-end::DOC_MAINPAGE-->

<!--section-start::DOC_MAINPAGE_CLASSES--><fieldset>
  <legend>
    <a href="?go=doc&amp;c={..id..}">
      {..name..}
    </a>
  </legend>
  {..subfunctions..}
</fieldset><!--section-end::DOC_MAINPAGE_CLASSES-->

<!--section-start::DOC_MAINPAGE_NOCLASSES-->Es wurde keine Klasse definiert
<!--section-end::DOC_MAINPAGE_NOCLASSES-->

<!--section-start::DOC_MAINPAGE_CLASSES_FUNCTION--><div class="{..access..}">
  <a href="?go=doc&amp;f={..id..}">{..name..}</a>
</div>

<!--section-end::DOC_MAINPAGE_CLASSES_FUNCTION-->

<!--section-start::DOC_MAINPAGE_CLASSES_NOFUNCTION-->Diese Klasse enthält keine Funktionen
<!--section-end::DOC_MAINPAGE_CLASSES_NOFUNCTION-->

<!--section-start::DOC_MAINPAGE_FUNCS--><a href="?go=doc&amp;f={..id..}">{..name..}</a><br>

<!--section-end::DOC_MAINPAGE_FUNCS-->

<!--section-start::DOC_MAINPAGE_NOFUNCS-->Keine Funktionen definiert.
<!--section-end::DOC_MAINPAGE_NOFUNCS-->
