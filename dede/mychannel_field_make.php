<?
require_once(dirname(__FILE__)."/config.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�ֶ������</title>
<style type="text/css">
<!--
body {
	background-image: url(img/allbg.gif);
}
-->
</style>
<link href="base.css" rel="stylesheet" type="text/css">
<script language="javascript">
var notAllow = " aid ID typeid typeid2 sortrank iscommend ismake channel arcrank click money title color writer source litpic pubdate senddate adminID memberID description keywords ";
function GetFields()
{
	var fieldname = document.form1.fieldname.value;
	var itemname = document.form1.itemname.value;
	var dtype = document.form1.dtype.value;
	if(document.form1.isnull[0].checked) var isnull = document.form1.isnull[0].value;
	else  var isnull = document.form1.isnull[1].value;
	var vdefault = document.form1.vdefault.value;
	var maxlength = document.form1.maxlength.value;
	var vfunction = document.form1.vfunction.value;
	var vinnertext = document.form1.vinnertext.value;
	if(vinnertext!="") vinnertext += "\r\n";
	if(document.form1.spage[0].checked) var spage = document.form1.spage[0].value;
	else var spage = document.form1.spage[1].value;
	if(isnull==0) var sisnull="false";
	else var sisnull="true";
	if(notAllow.indexOf(" "+fieldname+" ") >-1 ) 
	{
		alert("�ֶ����Ʋ��Ϸ������������ǲ�����ģ�\n"+notAllow);
		return false;
	}
	if(dtype=="text" && maxlength=="")
	{
		alert("��ѡ������ı����ͣ�����������󳤶ȣ�");
		return false;
	}
	if(itemname=="")
	{
		alert("����ʾ���Ʋ���Ϊ�գ�");
		return false;
	}
	if(spage=="no") spage = "";
	revalue =  "<field:"+fieldname+" itemname=\""+itemname+"\" type=\""+dtype+"\"";
	revalue += " isnull=\""+sisnull+"\" default=\""+vdefault+"\" function=\""+vfunction+"\"";
	revalue += " maxlength=\""+maxlength+"\" page=\""+spage+"\">\r\n"+vinnertext+"</field:"+fieldname+">\r\n";
	window.opener.document.<?=$f?>.value += revalue;
	window.opener=true;
  window.close();
}
</script>
</head>
<body topmargin="1" leftmargin="1">
<table width="100%"  border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#666666">
  <form name="form1">
  <tr> 
    <td height="20" colspan="2" background="img/tbg.gif"> <b>&nbsp;<a href="mychannel_main.php"></a>�ֶ�����򵼣�</b> 
    </td>
  </tr>
  <tr> 
    <td width="26%" align="center" bgcolor="#FFFFFF">�ֶ����ƣ�</td>
    <td width="74%" bgcolor="#FFFFFF" style="table-layout:fixed;word-break:break-all">
    	<input name="fieldname" type="text" id="fieldname"> *��Ӣ�ģ����ܺ�archives���ֶ��ظ���
    </td>
  </tr>
  <tr> 
    <td align="center" bgcolor="#FFFFFF">����ʾ���ƣ�</td>
    <td bgcolor="#FFFFFF">
    	<input name="itemname" type="text" id="itemname"> *����������ʱ��ʾ�������֣�
    </td>
  </tr>
  <tr> 
    <td align="center" bgcolor="#FFFFFF">�������ͣ�</td>
    <td bgcolor="#FFFFFF">
	<select name="dtype" id="type" style="width:150">
	<option value="text">�����ı�</option>
	<option value="multitext">�����ı�</option>
	<option value="htmltext">HTML�ı�</option>
	<option value="int">��������</option>
	<option value="float">С������</option>
	<option value="datetime">ʱ������</option>
	<option value="img">ͼƬ</option>
	<option value="media">��ý���ļ�</option>
	<option value="addon">��������</option>
    </select>
	</td>
  </tr>
  <tr> 
    <td align="center" bgcolor="#FFFFFF">�Ƿ�����գ�</td>
      <td bgcolor="#FFFFFF">
      	<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="30%">
         <input name="isnull" type="radio" class="np" value="1" checked>��
         &nbsp;
         <input type="radio" name="isnull" class="np" value="0">��
         </td>
            <td width="18%">�Ƿ��ҳ��</td>
            <td width="52%">
            <input name="spage" type="radio" class="np" value="split">��
            &nbsp;
            <input name="spage" type="radio" class="np" value="no" checked>��
          </td>
          </tr>
        </table>
      </td>
  </tr>
  <tr> 
    <td align="center" bgcolor="#FFFFFF">Ĭ��ֵ��</td>
    <td bgcolor="#FFFFFF">
    	<input name="vdefault" type="text" id="vdefault">
    </td>
  </tr>
  <tr> 
    <td align="center" bgcolor="#FFFFFF">��󳤶ȣ�</td>
    <td bgcolor="#FFFFFF">
    	<input name="maxlength" type="text" id="maxlength"> (�ı����ݱ�����д������255Ϊtext����)
    </td>
  </tr>
  <tr> 
    <td align="center" bgcolor="#FFFFFF">��������</td>
    <td bgcolor="#FFFFFF"><input name="vfunction" type="text" id="vfunction">
      (��ѡ����'@me'��ʾ��ǰ��Ŀֵ����)</td>
  </tr>
  <tr> 
    <td align="center" bgcolor="#FFFFFF">��HTML��<br>
      (����㲻���������ɵı�����������������������õı���HTML������������Ϊ���ֶ����ơ�)</td>
    <td bgcolor="#FFFFFF"><textarea name="vinnertext" cols="30" rows="5" id="vinnertext"></textarea>
    </td>
  </tr>
  <tr bgcolor="#F9FDF0"> 
    <td height="28" colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="26%">&nbsp;</td>
          <td width="20%"><img src="img/button_ok.gif" width="60" height="22" border="0" style="cursor:hand" onClick="GetFields()"></td>
          <td width="54%"><img src="img/button_reset.gif" width="60" height="22" border="0" style="cursor:hand" onClick="form1.reset()"></td>
        </tr>
      </table>
    </td>
  </tr>
</form>
</table>
</body>
</html>