<?php 
$needFilter = true;
require(dirname(__FILE__)."/../../include/config_base.php");

if(empty($gotopagerank)) $gotopagerank="";
if($gotopagerank=="admin")
{
	require(dirname(__FILE__)."/../../include/inc_userlogin.php");
	$cuserLogin = new userLogin();
	CheckPurview('plus_���Բ�ģ��');
}

//����Ϊ 0,��ʾ������Ҫ���
//�������Ϊ 1 ,�����Բ���Ҫ��˾�����ʾ
if($cfg_feedbackcheck=='��') $needCheck = 0;
else $needCheck = 1;

function trimMsg($msg,$gtype=0)
{
	$msg = htmlspecialchars(trim($msg));
	if($gtype==1){
		$msg = nl2br($msg);
		$msg = str_replace("  ","&nbsp;&nbsp;",$msg);
	}
	return $msg;
}
?>