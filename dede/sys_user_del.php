<?
require("config.php");
if(empty($job)) $job="";
if(empty($ID)) $ID="";
if($ID!=""&&$job=="yes")
{
	$ID = ereg_replace("[^0-9]","",$ID);
	$conn = connectMySql();
	mysql_query("delete from dede_admin where ID=$ID",$conn);
	ShowMsg("�ɹ�ɾ��һ���û���","sys_manager.php");
	exit();
}
?>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
<title>����Ա�ʺ�--�����ʺ�</title>
<link href='base.css' rel='stylesheet' type='text/css'>
</head>
<body background='img/allbg.gif' leftmargin='8' topmargin='8'>
<table width="90%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#666666">
  <tr>
    <td height="19" background="img/tbg.gif"> &nbsp;<strong>����Ա�ʺ�--ɾ���û�</strong>&nbsp;<strong>&nbsp;[<a href="sys_manager.php"><u>�����ʺ�</u></a>]</strong></td>
</tr>
<tr>
    <td align="center" valign="top" bgcolor="#FFFFFF"> 
      <form name="form1">
	<input type="hidden" name="ID" value="<?=$ID?>">
	<input type="hidden" name="job" value="yes">
	    <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr> 
            <td height="6"></td>
          </tr>
          <tr> 
            <td height="30">��ȷʵҪɾ���û���&nbsp;<?=$userid?>&nbsp; ��</td>
          </tr>
          <tr> 
            <td height="41"><input type="submit" name="Submit" value=" ȷ �� "></td>
          </tr>
        </table>
	  </form>
	  </td>
</tr>
</table>
</body>
</html>