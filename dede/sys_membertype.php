<?
require("config.php");
?>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
<title>��Ա������</title>
<link href='base.css' rel='stylesheet' type='text/css'>
</head>
<body background='img/allbg.gif' leftmargin='8' topmargin='8'>
<table width="80%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#666666">
  <tr>
    <td height="19" background="img/tbg.gif" bgcolor="#E7E7E7"> &nbsp;<strong>��Ա������&nbsp;&nbsp;[<a href="sys_membertype_add.php"><u>���ӻ�Ա����</u></a>]</strong></td>
</tr>
<tr>
    <td height="215" valign="top" bgcolor="#FFFFFF"><table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td>&nbsp;&nbsp;&nbsp;&nbsp;�ȼ�����С�ڻ���� 1 ���û�ΪϵͳĬ���ʻ���������ɾ������ġ�</td>
        </tr>
        <tr> 
          <td><hr size="1"></td>
        </tr>
        <tr> 
          <td>ϵͳ�����ʺţ�</td>
        </tr>
        <tr> 
          <td height="55">
		  <?
		  $conn = connectMySql();
		  $rs = mysql_query("Select * From dede_membertype order by rank",$conn);
		  while($row = mysql_fetch_object($rs))
		  {
		  	if($row->rank>1)
		  		echo "<li><a href='del_rank.php?ID=".$row->ID."'>[<u>ɾ��</u>]</a> &nbsp;".$row->membername." �ȼ����룺".$row->rank."</li>\r\n";
		  	else
		  		echo "<li>".$row->membername." �ȼ����룺".$row->rank."</li>\r\n";
		  }
		  ?></td>
        </tr>
        <tr> 
          <td>&nbsp;</td>
        </tr>
      </table> </td>
</tr>
</table>
</body>
</html>