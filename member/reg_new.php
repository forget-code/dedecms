<?
require_once(dirname(__FILE__)."/config.php");
if($cfg_ml->IsLogin()){
	ShowMsg("���Ѿ���½ϵͳ������ע�����û���","index.php");
	exit();
}
require_once(dirname(__FILE__)."/templets/reg_new.htm");
?>