<?
require("config.php");
$conn = connectMySql();
if(!empty($userid)&&!empty($pwd)&&!empty($usertype))
{
	$rs = mysql_query("Select * from dede_admin where userid='$userid' Or uname='$uname'",$conn);
	$ns = mysql_num_rows($rs);
	if($ns>0)
	{
		echo "<br><br>��";
		ShowMsg("�û����Ѵ��ڻ�����Ѵ��ڣ�","back");
		exit();
	}
	mysql_query("Insert Into dede_admin(usertype,userid,pwd,uname,typeid) values('$usertype','$userid','".md5($pwd)."','$uname',$typeid)",$conn);
	ShowMsg("�ɹ�����һ���û���","sys_manager.php");
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
    <td height="19" background="img/tbg.gif" bgcolor="#E7E7E7"> &nbsp;<strong>����Ա�ʺ�--�����ʺ�</strong>&nbsp;<strong>&nbsp;[<a href="sys_manager.php"><u>�����ʺ�</u></a>]</strong></td>
</tr>
<tr>
    <td height="215" align="center" valign="top" bgcolor="#FFFFFF">
	<form name="form1">
	<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr> 
          <td height="6"></td>
        </tr>
        <tr> 
          <td height="30">�û���¼ID�� <input name="userid" type="text" id="userid" size="16">
            ��ֻ����Ӣ����ĸ��@��&quot;.&quot;,&quot;!&quot;,���»��ߺ����ֵ���ϣ� </td>
        </tr>
        <tr>
          <td height="30">�û�������
            <input name="uname" type="text" id="uname" size="15">
            &nbsp;���������º���ʾ���α༭�����֣�</td>
        </tr>
        <tr> 
          <td height="30">�û����룺 <input name="pwd" type="text" id="pwd" size="16"> 
            &nbsp;��MD5������ܣ����ɺ�ֻ�ɸ��ģ��޷���ѯ��</td>
        </tr>
        <tr> 
          <td height="30">�û����ͣ� <input name="usertype" type="radio" value="1" checked>
            ��Ϣ�ɱ�
              <input type="radio" name="usertype" value="5">
              Ƶ���༭
              <input type="radio" name="usertype" value="10">
            �����û�</td>
        </tr>
        <tr>
          <td height="41">�������齨�������������Ա������㲻����admin�������û��������½�һ�������û���Ȼ��ִ��delete from dede where userid='admin'��mysql����ɾ��ԭ���ĳ�������Ա��</td>
        </tr>
        <tr>
          <td height="41">����Ƶ����
            <select name="typeid" id="typeid">
              <option value="0" selected>--����Ƶ��--</option>
			  <?
			  $rs = mysql_query("Select * from dede_arttype where reID=0",$conn);
			  while($row=mysql_fetch_object($rs))
			  {
			  		echo "<option value=".$row->ID.">".$row->typename."</option>\r\n";
			  }
			  ?>
            </select>
			</td>
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