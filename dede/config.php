<?
//��ҳ�����ڼ���û���¼���������Ҫ�ֹ�����ϵͳ���ã������config_base.php
require_once(dirname(__FILE__)."/../include/inc_userlogin.php");
require_once(dirname(__FILE__)."/../include/config_base.php");

//�ǳ�������Ա��ֹ���ʵĽű�
$s_exptag = "del_|_del|file_|admin_|sys_";

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
	header("location:login.php?gotopage=$s_scriptName");
	exit();
}

//�����û��Ƿ���ʱ���ֹ�Ľű�
if(eregi($s_exptag,$s_scriptName) && $cuserLogin->getUserType()<5)
{
	ShowMsg(" �Բ�����û��Ȩ�޷��ʱ�ҳ��","-1");
	exit();
}

//�����û�����ĳҳ��
function SetPageRank($pagerank)
{
	global $cuserLogin;
	if($cuserLogin->getUserRank()<$pagerank)
	{
		ShowMsg("�Բ�����û��Ȩ�޷��ʱ�ҳ��","-1");
		exit();
	}
}
?>