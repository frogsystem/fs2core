<!--section-start::DOC_CLASS--><b>
  Sie befinden sich hier:
  <a href="?go=doc">FS2-API-Dokumentation</a> &raquo;
  {..name..}
</b>
<br><br>


<table style="width: 100%;" cellpadding="3" cellspacing="0">
  <thead>
    <tr>
      <td colspan="3" style="background-color: #F2F2F2; border: 1px solid #E2E2E2; height: 100%;">
        <b>{..name..}</b>
      </td>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td style="width: 0pt; border-left: 1px solid #E2E2E2;"></td>
      <td>
        {..desc..}
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
        Private Funktionen &amp; Variablen anzeigen
        <br>
        <input type="checkbox" id="showprotected" onclick="hideproctcted();" checked>
        Geschützte Funktionen &amp; Variablen anzeigen
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
        <b>Funktionen in &bdquo;{..name..}&rdquo;</b>
      </td>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td style="width: 0pt; border-left: 1px solid #E2E2E2;"></td>
      <td>
        {..functions..}
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
        <b>Variablen in &bdquo;{..name..}&rdquo;</b>
      </td>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td style="width: 0pt; border-left: 1px solid #E2E2E2;"></td>
      <td>
        <fieldset>
          <legend>Konstanten</legend>
          {..constants..}
        </fieldset>
        <fieldset>
        <legend>Variablen</legend>
          {..variables..}
        </fieldset>
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
</script><!--section-end::DOC_CLASS-->

<!--section-start::DOC_NOCLASS--><b>
  Sie befinden sich hier:
  <a href="?go=doc">FS2-API-Dokumentation</a> &raquo;
  Systemnachricht
</b>
<br><br>


<table style="width: 100%;" cellpadding="3" cellspacing="0">
  <thead>
    <tr>
      <td colspan="3" style="background-color: #F2F2F2; border: 1px solid #E2E2E2; height: 100%;">
        <b>Fehler</b>
      </td>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td style="width: 0pt; border-left: 1px solid #E2E2E2;"></td>
      <td>
        Diese Klasse existiert nicht!
      </td>
      <td style="width: 0pt; border-right: 1px solid #E2E2E2;"></td>
    </tr>
    <tr>
      <td colspan="3" style="border-top: 1px solid #E2E2E2;"></td>
    </tr>
  </tbody>
</table><!--section-end::DOC_NOCLASS-->

<!--section-start::DOC_FUNCS--><div class="{..type..}">
  <span title="Access: {..type..}" style="cursor:pointer;">{..type_symbol..}</span>
  <a href="?go=doc&amp;f={..id..}">{..name..}</a>
</div><!--section-end::DOC_FUNCS-->

<!--section-start::DOC_NOFUNCS--><i>Diese Klasse enthält keine Funktionen.</i>
<!--section-end::DOC_NOFUNCS-->

<!--section-start::DOC_VARS--><div class="{..type..}">
  <span title="Access: {..type..}" style="cursor:pointer;">{..type_symbol..}</span>
  <a href="?go=doc&amp;v={..id..}">{..name..}</a>
</div><!--section-end::DOC_VARS-->

<!--section-start::DOC_NOVARS--><i>Diese Klasse enthält keine Variable.</i><!--section-end::DOC_NOVARS-->

<!--section-start::DOC_CONSTS--><div class="{..type..}">
  <a href="?go=doc&amp;v={..id..}">{..name..}</a>
</div><!--section-end::DOC_CONSTS-->

<!--section-start::DOC_NOCONSTS--><i>Diese Klasse enthält keine Konstante.</i><!--section-end::DOC_NOCONSTS-->

