<?
require("config.php");
$conn = connectMySql();
if(empty($ID)) $ID="";
if(empty($job)) $job="";
if(empty($pwd)) $pwd="";
if(empty($usertype)) $usertype="";
if(empty($typeid)) $typeid="";
if(empty($uname)) $uname="";
if($job=="mod")
{
	if($pwd!="")
		$squery = "Update dede_admin set uname='$uname',pwd='".md5(trim($pwd))."',usertype='$usertype',typeid='$typeid' where ID=$ID";
	else
		$squery = "Update dede_admin set uname='$uname',usertype='$usertype',typeid='$typeid' where ID=$ID";
	mysql_query($squery,$conn);
	echo "<script>alert('�ɹ�����һ�ʺţ�');</script>";
}
$rs = mysql_query("Select dede_admin.*,dede_arttype.typename From dede_admin left join dede_arttype on dede_admin.typeid=dede_arttype.ID where dede_admin.ID=".$ID,$conn);
$row = mysql_fetch_object($rs);
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
    <td height="19" background="img/tbg.gif"> &nbsp;<strong>����Ա�ʺ�--�����ʺ�</strong>&nbsp;<strong>&nbsp;[<a href="sys_manager.php"><u>�����ʺ�</u></a>]</strong></td>
</tr>
<tr>
    <td height="215" align="center" valign="top" bgcolor="#FFFFFF">
	<form name="form1" action="sys_user_modpwd.php" method="post">
	<input type="hidden" name="ID" value="<?=$ID?>">
	<input type="hidden" name="job" value="mod">
	<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr> 
          <td height="6"></td>
        </tr>
        <tr> 
          <td height="30">�û���¼ID�� <?=$row->userid?> </td>
        </tr>
        <tr>
          <td height="30">�û�������
            <input name="uname" type="text" id="uname" size="15" value="<?=$row->uname?>">
            &nbsp;���������º���ʾ���α༭�����֣�</td>
        </tr>
        <tr> 
          <td height="30">�û����룺 <input name="pwd" type="text" id="pwd" size="16"> 
            &nbsp;��MD5������ܣ�ֻ������ģ��޷���ѯ��</td>
        </tr>
        <tr> 
          <td height="30">�û����ͣ�
          <?
          $u10="";
          $u5="";
          $u1="";
          if($row->usertype==10) $u10=" checked";
          if($row->usertype==5) $u5=" checked";
          if($row->usertype==1) $u1=" checked";
          ?> 
          <input name="usertype" type="radio" value="1"<?=$u1?>>
            ��Ϣ�ɱ�
              <input type="radio" name="usertype" value="5"<?=$u5?>>
              Ƶ���༭
              <input type="radio" name="usertype" value="10"<?=$u10?>>
            �����û�</td>
        </tr>
        <tr>
          <td height="41">�������齨�������������Ա������㲻����admin�������û��������½�һ�������û���Ȼ��ִ��delete from dede where userid='admin'��mysql����ɾ��ԭ���ĳ�������Ա��</td>
        </tr>
        <tr>
          <td height="41">����Ƶ����
            <select name="typeid" id="typeid">
            <?
            if($row->typeid=="") $typeid_aaa = "0";
            else $typeid_aaa = $row->typeid;
            ////////////////////////////////////////
            if($row->typename=="") $typename_aaa = "����Ƶ��";
            else $typename_aaa = $row->typename;
            ?>
              <option value="<?=$typeid_aaa?>" selected>--<?=$typename_aaa?>--</option>
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