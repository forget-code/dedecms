<?
$page="reg";
require("config.php");
if(ereg(" ",$userid))
{
	echo "<script>alert('�û��������пո�!');window.close();</script>";
	exit();
}
$conn = @connectMySql();
$rs = mysql_query("Select userid From `dede_member` where userid='$userid' limit 0,1",$conn);
$row = mysql_fetch_object($rs);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>����û���</title>
</head>
<body bgcolor="#FBFBF2">
<center>
<p><br>
<?
if($userid=="")
{
	echo "�û�������Ϊ��!";
}
else if($userid==$row->userid)
{
	echo "�û��� <font color='red'>".$userid."</font> �Ѵ��ڣ���ʹ������һ��!";
}
else
{
	echo "�û��� <font color='red'>".$userid."</font> ��δ����ʹ�ã������ע��!";
}
?>
<p>
</body>
</html>