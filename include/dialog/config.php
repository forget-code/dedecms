<?
//��ҳ�����ڼ���û���¼���������Ҫ�ֹ�����ϵͳ���ã������config_base.php
require_once(dirname(__FILE__)."/../config_base.php");
require_once(dirname(__FILE__)."/../inc_userlogin.php");

//��õ�ǰ�ű����ƣ�������ϵͳ��������$_SERVER�����������и������ѡ��
$dedeNowurl = "";
$s_scriptName="";
$isUrlOpen = @ini_get("allow_url_fopen");
 
$dedeNowurl = GetCurUrl();
$dedeNowurls = explode("?",$dedeNowurl);
$s_scriptName = $dedeNowurls[0];

//�����û���¼״̬
$cuserLogin = new userLogin();
if($cuserLogin->getUserID()==-1)
{
	$gurl = $cfg_cmspath."/include/dialog/"."login.php?gotopage=".urlencode($dedeNowurl);
	echo "<script language='javascript'>location='$gurl';</script>";
	exit();
}

?>