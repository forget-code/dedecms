<?
//��ҳ�����ڼ���û���¼���������Ҫ�ֹ�����ϵͳ���ã������config_base.php
require_once("inc_userLogin.php");
require_once("config_base.php");

//�ǳ�������Ա��ֹ���ʵĽű�
$s_exptag = "del_|_del|file_|admin_|sys_";

//��õ�ǰ�ű����ƣ�������ϵͳ��������$_SERVER�����������и������ѡ��
$dedeNowurl = "";
$s_scriptName="";
$qstr="";
$isUrlOpen = @ini_get("allow_url_fopen");
if(!empty($_SERVER["REQUEST_URI"]))
{
	$s_scriptName = $_SERVER["REQUEST_URI"];
	$dedeNowurl = $s_scriptName;
}

//�����û���¼״̬
$cuserLogin = new userLogin();
if($cuserLogin->getUserID()==-1)
{
	header("location:login.php?gotopage=$s_scriptName");
	exit();
}

//�����û��Ƿ���ʱ���ֹ�Ľű�
if(ereg($s_exptag,$s_scriptName)&&$cuserLogin->getUserType()!=10)
{
	ShowMsg(" �㲻�ǳ�������Ա���ļ���ϵͳ�����Լ��󲿷�ɾ���Ĳ����������ƣ�\\n\\n �����ȷʵҪ�����ЩȨ�ޣ����볬������Ա����ɾ����","-1");
	exit();
}
?>