<?php 
require_once(dirname(__FILE__)."/config.php");
CheckPurview('sys_plus');
if(empty($dopost)) $dopost = "";
if($dopost=="save"){
	$plusname = str_replace("\\'","",$plusname);
	$link = str_replace("\\'","",$link);
	$target = str_replace("\\'","",$target);
	$menustring = "<m:item name=\\'$plusname\\' link=\\'$link\\' rank=\\'plus_$plusname\\' target=\\'$target\\' />";
  $dsql = new DedeSql(false);
  $dsql->SetQuery("Insert Into #@__plus(plusname,menustring,writer,isshow,filelist) Values('$plusname','$menustring','$writer','1','$filelist');");
  $dsql->Execute();
  $dsql->Close();
  ShowMsg("�ɹ���װһ�����,��ˢ�µ����˵�!","plus_main.php");
	exit();
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>��װ�²��</title>
<style type="text/css">
<!--
body {
	background-image: url(img/allbg.gif);
}
-->
</style>
<link href="base.css" rel="stylesheet" type="text/css">
</head>
<body topmargin="8">
<table width="98%"  border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#98CAEF">
  <form name="form1" action="plus_add.php" method="post">
   <input type='hidden' name='dopost' value='save'>
    <tr> 
      <td height="20" colspan="2" background="img/tbg.gif"> <b>&nbsp;<a href="plus_main.php"><u>�������</u></a> 
        &gt; ��װ�²����</b> </td>
    </tr>
    <tr> 
      <td width="19%" align="center" bgcolor="#FFFFFF">�������</td>
      <td width="81%" bgcolor="#FFFFFF"><input name="plusname" type="text" id="plusname"> 
      </td>
    </tr>
    <tr> 
      <td align="center" bgcolor="#FFFFFF">����</td>
      <td bgcolor="#FFFFFF"> <input name="writer" type="text" id="writer"> </td>
    </tr>
    <tr> 
      <td align="center" bgcolor="#FFFFFF">�������ļ�</td>
      <td bgcolor="#FFFFFF"><input name="link" type="text" id="link" size="30"> </td>
    </tr>
    <tr> 
      <td align="center" bgcolor="#FFFFFF">Ŀ����</td>
      <td bgcolor="#FFFFFF"><input name="target" type="text" id="target" value="main"></td>
    </tr>
    <tr> 
      <td align="center" bgcolor="#FFFFFF">�ļ��б�</td>
      <td bgcolor="#FFFFFF">�ļ���&quot;,&quot;�ֿ���·������ڹ���Ŀ¼����ǰĿ¼��<br>
        <textarea name="filelist" rows="8" id="filelist" style="width:60%"></textarea></td>
    </tr>
    <tr bgcolor="#F9FDF0"> 
      <td height="28" colspan="2"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="26%">&nbsp;</td>
            <td width="15%"><input name="imageField" class="np" type="image" src="img/button_ok.gif" width="60" height="22" border="0"></td>
            <td width="59%"><img src="img/button_back.gif" width="60" height="22" onClick="location='plus_main.php';" style="cursor:hand"></td>
          </tr>
        </table></td>
    </tr>
  </form>
</table>
</body>
</html>