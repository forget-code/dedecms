<?
require("config.php");
$msg = cn_substr($msg,1500);
$adminmsg = trim($adminmsg);
if($adminmsg!="")
{
	$adminmsg = cn_substr($adminmsg,1500);
	$adminmsg = str_replace("<","&lt;",$adminmsg);
	$adminmsg = str_replace(">","&gt;",$adminmsg);
	$adminmsg = str_replace("  ","&nbsp;&nbsp;",$adminmsg);
	$adminmsg = str_replace("\r\n","<br>\n",$adminmsg);
	$msg = $msg."<br>\n"."<font color=red>����Ա�ظ��� $adminmsg</font>\n";
}
$query = "update dede_feedback set msg='$msg',ischeck=1 where ID=$ID";
$conn = connectMySql();
mysql_query($query,$conn);
ShowMsg("�ɹ��ظ�һ�����ԣ�",$_COOKIE["ENV_GOBACK_URL"]);
?>