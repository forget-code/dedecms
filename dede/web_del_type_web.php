<?
require("config.php");
if(isset($ID))
{
	$conn = connectMySql();
	mysql_query("Delete From dede_partmode where ID=$ID",$conn);
	ShowMsg("�ɹ�ɾ��һ�����ģ�壡","web_type_web.php");
	exit();
}
?>