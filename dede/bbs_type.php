<?
require("config.php");
$conn = connectMySql();
if(isset($qtype))
{
	if($qtype=="mod")
	{
		if(isset($newname)&&$bbstype!="0")
		{
			$newname = trim($newname);
			$bbstype = trim($bbstype);
			mysql_query("Update bbstype set bbstype='$newname' where ID='$bbstype'",$conn);
		}
	}
	if($qtype=="new")
	{
		$newname = trim($newname);
		mysql_query("Insert Into bbstype(bbstype) values('$newname')",$conn);
	}
	if($qtype=="del")
	{
		if($bbstype!="0")
		{
			$bbstype = trim($bbstype);
			mysql_query("Delete From bbstype where ID=$bbstype",$conn);
		}
	}
}
?>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
<title>��̳������</title>
<link href='base.css' rel='stylesheet' type='text/css'>
</head>
<body background='img/allbg.gif' leftmargin='8' topmargin='8'>
<table width="99%" border="0" cellpadding="3" cellspacing="1" bgcolor="#666666">
  <tr>
    <td height="19" bgcolor="#E7E7E7"> &nbsp;<b>��̳��Ŀ����</b>����<a href='list_bbs.php'><u>��̳����</u></a></td>
</tr>
<tr>
    <td height="120" bgcolor="#FFFFFF">
    <table width="90%" border="0" cellpadding="3" cellspacing="1" align="center">
  	<form action="bbs_type.php" name="form1">
  	<tr>
    <td height="50">
    ѡ��һ����Ŀ��
    <select name="bbstype">
    <option value="0">--��ѡ��--</option>
    <?
    $rs = mysql_query("Select * From bbstype",$conn);
    while($row = mysql_fetch_object($rs))
    {
    	echo "    <option value='".$row->ID."'>".$row->bbstype."</option>\r\n";
    }
    ?>
    </select> 
    &nbsp;
    �޸� <input type="radio" name="qtype" value="mod" checked>&nbsp;
    �½� <input type="radio" name="qtype" value="new">&nbsp;
    ɾ�� <input type="radio" name="qtype" value="del">
    </td>
	</tr>
	<tr>
    <td height="40">
    ����Ŀ���ƣ�<input type="text" name="newname" size="20">
    </td>
	</tr>
	<tr>
    <td height="50">
    <input type="submit" name="sb1" value="ִ�в���"> &nbsp; 
    </td>
	</tr>
	</form>
	</table>
    </td>
</tr>
</table>
</body>
</html>