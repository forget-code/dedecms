<?
require("config.php");
$conn = connectMySQl();
$pname = trim($pname);
//$fname = ereg_replace("\.(htm|html)$","",trim($fname)).".html";
$body = trim($body);
if($pname==""||$fname==""||$body=="")
{
	ShowMsg("������Ŀ������Ϊ�գ�","web_type_web.php#up");
	exit();
}
mysql_query("Insert Into dede_partmode(typeid,pname,fname,body) Values($typeid,'$pname','$fname','$body')",$conn);
ShowMsg("�ɹ��ϴ�һ��ģ�壡","web_type_web.php#up");
exit();
?>