<?php 
require_once(dirname(__FILE__)."/config.php");
require_once(dirname(__FILE__)."/../include/inc_imgbt.php");
CheckRank(0,0);

if($cfg_mb_album=='��'){
	ShowMsg("�Բ���ϵͳ������ͼ���Ĺ��ܣ�����޷�ʹ�ã�","-1");
	exit();
}

require_once(dirname(__FILE__)."/inc/inc_catalog_options.php");
require_once(dirname(__FILE__)."/../include/pub_dedetag.php");

$aid = ereg_replace("[^0-9]","",$aid);
$channelid="1";
$dsql = new DedeSql(false);
//��ȡ�鵵��Ϣ
//------------------------------
$arcQuery = "Select 
#@__archives.*,#@__addonimages.*
From #@__archives
left join #@__addonimages on #@__addonimages.aid=#@__archives.ID
where #@__archives.ID='$aid' And #@__archives.memberID='".$cfg_ml->M_ID."'";
$dsql->SetQuery($arcQuery);
$row = $dsql->GetOne($arcQuery);

if(!is_array($row)){
	$dsql->Close();
	ShowMsg("��ȡͼ����Ϣ����!","-1");
	exit();
}

$arow = $dsql->GetOne(" Select typename From #@__arctype where ID='".$row['typeid']."'; ");

require_once(dirname(__FILE__)."/templets/album_edit.htm");

?>