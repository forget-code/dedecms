<?php 
require_once(dirname(__FILE__)."/config.php");
if($cfg_ml->IsLogin()){
	ShowMsg("���Ѿ���½ϵͳ������ע�����û���","index.php");
	exit();
}
if($cfg_pp_isopen==1 && $cfg_pp_regurl!=''){
	 header("Location:{$cfg_pp_regurl}");
	 exit();
}
require_once(dirname(__FILE__)."/templets/reg_new.htm");
?>