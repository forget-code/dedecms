<?
require("config.php");
$conn = connectMySql();
if(!empty($_SERVER["REMOTE_ADDR"])) $ip = $_SERVER["REMOTE_ADDR"];
else $ip = "�޷���ȡ";
$dtime = strftime("%Y-%m-%d %H:%M:%S",time());
$uname = trimMsg($uname);
$email = trimMsg($email);
$homepage = trimMsg($homepage);
$homepage = eregi_replace("http://","",$homepage);
$qq = trimMsg($qq);
$msg = trimMsg($msg,1);
$msg = cn_substr($msg,2000);
if($msg==""||$uname=="")
{
	showMsg("����������������ݲ���Ϊ��!",-1);
	exit();
}
$query = "INSERT INTO 
dede_guestbook(uname,email,homepage,qq,face,msg,ip,dtime,ischeck) 
VALUES ('$uname','$email','$homepage','$qq','$img','$msg','$ip','$dtime','1')";
mysql_query($query);
showMsg("�ɹ�����һ������!","index.php");
?>
