<?
$page="login";
include("config.php");
$conn=connectMySql();
$email = str_replace(" ","",$email);
if($email!="")
{
	$rs = mysql_query("Select userid,pwd From dede_member where email='$email' limit 0,1",$conn);
	$row = mysql_fetch_object($rs,$conn);
	$userid=$row->userid;
	$pwd=$row->pwd;
	if($userid=="") $msg = "���Email���������ݿ��У���<a href='getpassword.php'>��������</a>��<a href='reg.php'>��ע��</a><br><br>";
	else 
	{
		$msg = "����û����������ѷ��͵���������У�����գ�";
		$mailtitle = "����[".$webname."]���û���������";
		$mailbody = "\r\n�û�����'$userid'  ���룺'$pwd'\r\n\r\n��Power by www.dedecms.com ֯�����ݹ���ϵͳ��";
	        if(eregi("(.*)@(.*)\.(.*)",$email))
	        {
	        	 $headers = "From: ".$admin_email."\r\nReply-To: $admin_email";
                         @mail($email, $mailtitle, $mailbody, $headers);
	        }
	}
	
}
?>