<?
require_once(dirname(__FILE__)."/config.php");
CheckRank(0,0);

if($cfg_mb_album=='��'){
	ShowMsg("�Բ���ϵͳ������ͼ���Ĺ��ܣ�����޷�ʹ�ã�","-1");
	exit();
}

$dsql = new DedeSql(false);
$cInfos = $dsql->GetOne("Select sendrank From #@__channeltype  where ID='2'; ");	
if($cInfos['sendrank'] > $cfg_ml->M_Type){
	$row = $dsql->GetOne("Select membername From #@__arcrank where rank='".$cInfos['sendrank']."' ");
	$dsql->Close();
	ShowMsg("�Բ�����Ҫ[".$row['membername']."]���������Ƶ�������ĵ���","-1","0",5000);
	exit();
}

require_once(dirname(__FILE__)."/inc/inc_catalog_options.php");
require_once(dirname(__FILE__)."/templets/album_add.htm");
$dsql->Close();
?>