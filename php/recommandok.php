<?
require("config.php");
if(!eregi("(.*)@(.*)\.(.*)",$email))
{
	echo "<script>alert('Email����ȷ!');history.go(-1);</script>";
	exit();
}
$msg = ereg_replace("[><]","",$msg);
$mailtitle = "��ĺ��Ѹ����Ƽ���һƪ����";
$mailbody = "$msg\r\nPower by http://www.dedecms.com ֯�����ݹ���ϵͳ��";
if(eregi("(.*)@(.*)\.(.*)",$email))
{
	  $headers = "From: ".$admin_email."\r\nReply-To: ".$admin_email;
      @mail($email, $mailtitle, $mailbody, $headers);
}
echo "<script>alert('�ɹ��Ƽ�һƪ����!');location='$arturl';</script>";
exit();
?>