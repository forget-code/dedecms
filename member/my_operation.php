<?php 
require_once(dirname(__FILE__)."/config.php");
require_once(dirname(__FILE__)."/../include/pub_datalist_dm.php");
CheckRank(0,0);
setcookie("ENV_GOBACK_URL",GetCurUrl(),time()+3600,"/");

function GetSta($sta){
	if($sta==0) return 'δ����';
	else if($sta==1) return '�Ѹ���';
	else return '�����';
}

$sql = "Select * From #@__member_operation where mid='".$cfg_ml->M_ID."' order by aid desc";
$dlist = new DataList();
$dlist->Init();
$dlist->pageSize = 20;
$dlist->SetSource($sql);
require_once(dirname(__FILE__)."/templets/my_operation.htm");
$dlist->Close();
?>
