<?
require("config.php");
$conn = connectMySql();
$ID = ereg_replace("[^0-9]","",$ID);
mysql_query("Delete From dede_membertype where ID=$ID",$conn);
echo "<script>alert('�ɹ�ɾ��һ������');location.href='sys_membertype.php';</script>";
exit();
?>