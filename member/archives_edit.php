<?
require_once(dirname(__FILE__)."/config.php");
CheckRank(0,0);

if($cfg_mb_sendall=='��'){
	ShowMsg("�Բ���ϵͳ�������Զ���ģ��Ͷ�壬����޷�ʹ�ô˹��ܣ�","-1");
	exit();
}
require_once(dirname(__FILE__)."/inc/inc_catalog_options.php");
require_once(dirname(__FILE__)."/../include/pub_dedetag.php");
require_once(dirname(__FILE__)."/inc/inc_archives_all.php");
$aid = ereg_replace("[^0-9]","",$aid);
if($aid=="")
{
	ShowMsg("��ûָ���ĵ�ID����������ʱ�ҳ�棡","-1");
	exit();
}
$dsql = new DedeSql(false);
//��ȡ�鵵��Ϣ
//------------------------------
$arcQuery = "Select 
#@__channeltype.typename as channelname,
#@__arcrank.membername as rankname,
#@__archives.* 
From #@__archives
left join #@__channeltype on #@__channeltype.ID=#@__archives.channel 
left join #@__arcrank on #@__arcrank.rank=#@__archives.arcrank
where #@__archives.ID='$aid'";

$dsql->SetQuery($arcQuery);
$arcRow = $dsql->GetOne($arcQuery);
if(!is_array($arcRow)){
	$dsql->Close();
	ShowMsg("��ȡ����������Ϣ����!","-1");
	exit();
}
if($arcRow['arcrank']>=0){
	$dsql->Close();
	ShowMsg("�Բ���������Ϣ�Ѿ�������Ա�������㲻���ٸ���!","-1");
	exit();
}


$query = "Select * From #@__channeltype where ID='".$arcRow['channel']."'";
$cInfos = $dsql->GetOne($query);
if(!is_array($cInfos)){
	$dsql->Close();
	ShowMsg("��ȡƵ��������Ϣ����!","-1");
	exit();
}
if($cInfos['issystem']!=0 || $cInfos['issend']!=1){
	$dsql->Close();
	ShowMsg("��ָ����Ƶ�������Ĵ���","-1");
	exit();
}

$channelid = $arcRow['channel'];
//-----------------------
$addQuery = "Select * From ".$cInfos['addtable']." where aid='$aid'";
$addRow = $dsql->GetOne($addQuery);
$arow = $dsql->GetOne(" Select typename From #@__arctype where ID='".$arcRow['typeid']."'; ");
require_once(dirname(__FILE__)."/templets/archives_edit.htm");

?>