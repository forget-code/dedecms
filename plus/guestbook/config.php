<?
require(dirname(__FILE__)."/../../include/config_base.php");
if(empty($gotopagerank)) $gotopagerank="";
if($gotopagerank=="admin")
{
	require(dirname(__FILE__)."/../../include/inc_userlogin.php");
	$cuserLogin = new userLogin();
}

//����Ϊ 0,��ʾ������Ҫ���
//�������Ϊ 1 ,�����Բ���Ҫ��˾�����ʾ
$needCheck = 0;

function trimMsg($msg,$gtype=0)
{
	$notallowstr="����|������|����|����|����|����|fuck|ȥ��|����|�߹�|͵��|ɫ��|����|sex|��B";
	$msg = htmlspecialchars(trim($msg));
	if($gtype==1){
		$msg = nl2br($msg);
		$msg = str_replace("  ","&nbsp;&nbsp;",$msg);
	}
	$msg = eregi_replace($notallowstr,"***",$msg);
	return $msg;
}
?>