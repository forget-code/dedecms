<?
require("config.php");
if(!empty($rank)&&!empty($membername))
{
	if($rank<1)
	{
		ShowMsg("��ֹ���ü������С�ڻ��������û���","");
	}
	else
	{
		$conn = connectMySql();
		mysql_query("Insert Into dede_membertype(rank,membername) values('$rank','$membername')",$conn);
		ShowMsg("�ɹ�����һ������","sys_membertype.php");
		exit();
	}
}
?>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
<title>��Ա������[���ӻ�Ա����]</title>
<link href='base.css' rel='stylesheet' type='text/css'>
</head>
<body background='img/allbg.gif' leftmargin='8' topmargin='8'>
<table width="90%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#666666">
  <tr>
    <td height="19" background="img/tbg.gif" bgcolor="#E7E7E7"> &nbsp;<strong>��Ա������[���ӻ�Ա����]</strong>&nbsp;<strong>&nbsp;[<a href="sys_membertype.php"><u>�����������</u></a>]</strong></td>
</tr>
<tr>
    <td height="150" align="center" valign="top" bgcolor="#FFFFFF">
	<form name="form1">
	<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr> 
          <td height="6"></td>
        </tr>
        <tr> 
          <td height="30">������룺 <input name="rank" type="text" id="rank" size="6">
            (�������0)</td>
        </tr>
        <tr> 
          <td height="30">�������ƣ� <input name="membername" type="text" id="membername" size="16"> 
            &nbsp;��ǰ�����������ʶ�����ͣ��硰������Ա�����ڹ��������У�ֻ��ʾ������������������</td>
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