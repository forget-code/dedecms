<?
require("config.php");
?>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
<title>����Ա�ʺ�</title>
<link href='base.css' rel='stylesheet' type='text/css'>
</head>
<body background='img/allbg.gif' leftmargin='8' topmargin='8'>
<table width="80%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#666666">
  <tr>
    <td height="19" background="img/tbg.gif" bgcolor="#E7E7E7"> &nbsp;<strong>����Ա�ʺ�&nbsp;&nbsp;[<a href="sys_manager_add.php"><u>���ӹ���Ա</u></a>]</strong></td>
</tr>
<tr>
    <td height="215" valign="top" bgcolor="#FFFFFF"><table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td>&nbsp;&nbsp;&nbsp;&nbsp;�ʺŷּ�����Ա����ͨ�û����֣���ͨ�û�û��ִ��MySQL��������û���ɾ���������ļ����Ȩ�ޡ�</td>
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
		  $rs = mysql_query("Select dede_admin.*,dede_arttype.typename From dede_admin left join dede_arttype on dede_admin.typeid=dede_arttype.ID",$conn);
		  while($row = mysql_fetch_object($rs))
		  {
		  	if($row->usertype==10)
				$line = "<li>".$row->userid." ������". $row->uname ." ���� ��������Ա)&nbsp;&nbsp;<a href='sys_user_modpwd.php?ID=".$row->ID."'>[<u>����</u>]</a><br><font color='#888888'>(����¼ʱ�䣺".$row->logintime." IP��".$row->loginip.")</font></li>\r\n";		
			else
			{
				if($row->usertype==5) $utype="Ƶ���༭";
				if($row->usertype==1) $utype="��Ϣ�ɱ�";
				if($row->typename=="") $utypename="����";
				else $utypename=$row->typename;
				$line = "<li>".$row->userid." <b>������</b>". $row->uname ." <b>����</b> $utype  <b>Ƶ����</b>$utypename  &nbsp;&nbsp;<a href='sys_user_modpwd.php?ID=".$row->ID."'>[<u>����</u>]</a> <a href='sys_user_del.php?ID=".$row->ID."&userid=".$row->userid."'>[<u>ɾ��</u>]</a><br><font color='#888888'>(����¼ʱ�䣺".$row->logintime." IP��".$row->loginip.")</font></li>\r\n";
			}
			echo $line;
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