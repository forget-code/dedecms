<?
require("config.php");
require_once("inc_unit.php");
if(empty($userSendArt)) $userSendArt=-1;
if(empty($_COOKIE["cookie_rank"])) $userrank=-1000;
else $userrank=$_COOKIE["cookie_rank"];
if($userSendArt!=-1 && $userrank < $userSendArt)
{
	ShowMsg("Ȩ�޲��㣡","back");
	exit();
}
$conn = connectMySql();
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>����Ͷ��</title>
<link href="../base.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function popUpload()
{
window.open("insertpicture.php", 'popUpWin', 'scrollbars=no,resizable=no,width=300,height=260,left=200, top=100,screenX=0,screenY=0');
}
function checkSubmit()
{
if(document.form1.title.value=="")
{
   document.form1.title.focus();
   alert("���±��ⲻ��Ϊ�գ�");
   return false;
}
if(document.form1.typeid.value=="0")
{
   document.form1.typeid.focus();
   alert("����ѡ����࣡");
   return false;
}
if(document.form1.body.value=="")
{
   document.form1.body.focus();
   alert("�������ݲ���Ϊ�գ�");
   return false;
}
return true;
}
</script>	
</head>
<body leftmargin="0" topmargin="0">
<table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr bgcolor="#FFFFFF"> 
    <td height="50" colspan="4"><img src="img/member.gif" width="320" height="46"></td>
  </tr>
  <tr> 
    <td bgcolor="#808DB5" width="30">&nbsp;</td>
    <td bgcolor="#808DB5" width="220">&nbsp;</td>
    <td bgcolor="#808DB5" width="250">&nbsp;</td>
    <td width="200" align="right">
	<a href="index.php"><u>��������</u></a>
	<a href="/"><u>��վ��ҳ</u></a>
    <a href="exit.php?job=all"><u>�˳���¼</u></a></td>
  </tr>
  <tr> 
    <td width="30" bgcolor="#808DB5">&nbsp;</td>
    <td colspan="3" rowspan="2" valign="top">
	<table width="100%" height="200" border="0" cellpadding="1" cellspacing="1" bgcolor="#000000">
        <tr> 
          <td height="100" align="center" valign="top" bgcolor="#FFFFFF">
		  <form action="artsendok.php" name="form1" method="post" onSubmit="return checkSubmit();">
		  <table width="98%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td height="6" colspan="2"></td>
              </tr>
              <tr> 
                <td height="30" colspan="2"><strong>Ͷ�����ģ� </strong></td>
              </tr>
              <tr> 
                <td colspan="2" align="center"><hr size="1"></td>
              </tr>
              <tr> 
                <td height="22">���±��⣺</td>
                <td height="22"><input name="title" type="text" id="title" size="30"></td>
              </tr>
              <tr>
                <td height="22">���³�����</td>
                <td height="22">
                    <input name="source" type="text" id="source">
                  ���ߣ�
                  <input name="writer" type="text" id="writer" size="16"></td>
              </tr>
              <tr> 
                <td height="22">�������</td>
                <td height="22">
				<select name="typeid" id="typeid">
                    <option value="0" selected>--��ѡ��--</option>
					<?
					GetOptionArray(0,$conn);
					?>
                  </select></td>
              </tr>
              <tr> 
                <td width="14%" height="22">���¼�飺</td>
                <td width="86%" height="22">��250�����ַ����ڣ�</td>
              </tr>
              <tr> 
                <td height="78">&nbsp;</td>
                <td height="78"> <textarea name="msg" cols="50" rows="3" id="msg"></textarea></td>
              </tr>
              <tr> 
                <td height="33">�������ݣ�</td>
                <td height="33"><input type="button" name="Submit3" value="����ͼƬ" onClick="popUpload();"> 
                  &nbsp;(֧�ּ򵥵�HTML������֧�ֽű��͸��ӵ�HTML)</td>
              </tr>
              <tr> 
                <td height="22">&nbsp;</td>
                <td height="22"><textarea name="body" cols="75" rows="14" id="body"></textarea></td>
              </tr>
              <tr> 
                <td height="73">&nbsp;</td>
                <td height="73"><input type="submit" name="Submit" value="ȷ���ύ"> 
                  &nbsp;&nbsp; <input type="reset" name="Submit2" value="���ñ�"></td>
              </tr>
              <tr> 
                <td height="22">&nbsp;</td>
                <td height="22">&nbsp;</td>
              </tr>
            </table>
			</form>
			</td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td bgcolor="#808DB5">&nbsp;</td>
  </tr>
</table>
<p align='center'><a href='http://www.dedecms.com'target='_blank'>Power by DedeCms ֯�����ݹ���ϵͳ</a></p>
</body></html>
