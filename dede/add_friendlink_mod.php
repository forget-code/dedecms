<?
require("config.php");
$conn = connectMySql();
if(isset($job))
{
	if($job=="del")
	{
		mysql_query("Delete From dede_flink where ID=$ID",$conn);
		echo "<script language='javascript'>\r\n";
		echo "alert('�ɹ�ɾ��һ�����ӣ�');";
		echo "location.href='add_friendlink.php';";
		echo "</script>";
		exit();
	}
}
$rs = mysql_query("Select dede_flink.*,dede_flinktype.typename From dede_flink left join dede_flinktype on dede_flink.typeid=dede_flinktype.ID where dede_flink.ID=$ID",$conn);
$row = mysql_fetch_object($rs);
?>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
<title>�������Ӹ���</title>
<link href='base.css' rel='stylesheet' type='text/css'>
</head>
<body background='img/allbg.gif' leftmargin='8' topmargin='8'>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#666666">
  <tr>
    <td height="19" background="img/tbg.gif"><b><a href="add_friendlink.php"><u>�������ӹ���</u></a></b>&gt;&gt;���Ӹ���</td>
</tr>
<tr>
    <td height="200" bgcolor="#FFFFFF" valign="top">
	<form action="add_friendlink_modok.php" method="post" enctype="multipart/form-data" name="form1">
	<input type="hidden" name="ID" value="<?=$ID?>">
	<table width="80%"  border="0" cellspacing="1" cellpadding="3">
	  <tr>
        <td width="19%" height="25">��ַ��</td>
        <td width="81%">
        <input name="url" type="text" id="url" value="<?=$row->url?>" size="30">
        </td>
      </tr>
      <tr>
        <td height="25">��վ���ƣ�</td>
        <td><input name="fwebname" type="text" id="fwebname" size="30" value="<?=$row->webname?>"></td>
      </tr>
      <tr>
        <td height="25">��վLogo��</td>
        <td><input name="logo" type="text" id="logo" size="40" value="<?=$row->logo?>">
          (88*31 gif��jpg)</td>
      </tr>
      <tr>
        <td height="25">�ϴ�Logo��</td>
        <td><input name="logoimg" type="file" id="logoimg" size="30"></td>
      </tr>
      <tr>
        <td height="25">��վ�����</td>
        <td><textarea name="msg" cols="50" rows="4" id="msg"><?=$row->msg?></textarea></td>
      </tr>
      <tr>
        <td height="25">վ��Email��</td>
        <td><input name="email" type="text" id="email" size="30" value="<?=$row->email?>"></td>
      </tr>
      <tr>
        <td height="25">״̬��</td>
        <td>
        <select name="ischeck">
        <option value="0"<?if($row->ischeck==0) echo " selected"?>>δ���</option>
        <option value="1"<?if($row->ischeck==1) echo " selected"?>>�����</option>
        </select>
        </td>
      </tr>
      <tr>
        <td height="25">��վ���ͣ�</td>
        <td>
        <select name="typeid" id="typeid">
        <?
        echo "	<option value='".$row->typeid."'>".$row->typename."</option>\r\n";
        $rs = mysql_query("select * from dede_flinktype",$conn);
        while($row=mysql_fetch_object($rs))
        {
        	echo "	<option value='".$row->ID."'>".$row->typename."</option>\r\n";
        }
        ?>
        </select>
        </td>
      </tr>
      <tr>
        <td height="51">&nbsp;</td>
        <td><input type="submit" name="Submit" value=" �� �� ">�� ��
          <input type="reset" name="Submit" value=" �� �� " onclick="location.href='add_friendlink.php';"></td>
      </tr>
    </table>
	</form>
    </td>
</tr>
</table>
</body>
</html>