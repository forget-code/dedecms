<?php 
require_once(dirname(__FILE__)."/config.php");
require_once(dirname(__FILE__)."/../include/inc_imgbt.php");
CheckRank(0,0);

if($cfg_mb_sendall=='��'){
	ShowMsg("�Բ���ϵͳ�������Զ���ģ��Ͷ�壬����޷�ʹ�ô˹��ܣ�","-1");
	exit();
}
require_once(dirname(__FILE__)."/inc/inc_catalog_options.php");
require_once(dirname(__FILE__)."/inc/inc_archives_all.php");
require_once(dirname(__FILE__)."/../include/pub_dedetag.php");

if(!isset($channelid)) $channelid=0;
else $channelid = trim(ereg_replace("[^0-9]","",$channelid));

$dsql = new DedeSql(false);
$cInfos = $dsql->GetOne("Select * From #@__channeltype  where ID='$channelid'; ");	

if($cInfos['issystem']!=0 || $cInfos['issend']!=1){
	$dsql->Close();
	ShowMsg("��ָ����Ƶ���������������Ͷ�壡","-1");
	exit();
}

if($cInfos['sendrank'] > $cfg_ml->M_Type){
	$row = $dsql->GetOne("Select membername From #@__arcrank where rank='".$cInfos['sendrank']."' ");
	$dsql->Close();
	ShowMsg("�Բ�����Ҫ[".$row['membername']."]���������Ƶ�������ĵ���","-1","0",5000);
	exit();
}


$channelid = $cInfos['ID'];
$addtable = $cInfos['addtable'];

require_once(dirname(__FILE__)."/templets/archives_add.htm");

?>