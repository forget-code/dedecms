<?php 
require_once(dirname(__FILE__)."/../include/config_base.php");
require_once(dirname(__FILE__)."/../include/inc_channel_unit.php");
if(!isset($open)) $open = 0;
if(!isset($aid)) $aid = "";
$aid = ereg_replace("[^0-9]","",$aid);
//��ȡ�����б�
//------------------
if($open==0)
{
	$dsql = new DedeSql(false);
  //��ȡ�ĵ�������Ϣ
  $arctitle = "";
  $arcurl = "";
  $gquery = "Select
  #@__archives.title,#@__archives.senddate,#@__archives.arcrank,
  #@__archives.ismake,#@__archives.typeid,#@__archives.channel,#@__archives.money,
  #@__arctype.typedir,#@__arctype.namerule 
  From #@__archives 
  left join #@__arctype on #@__arctype.ID=#@__archives.typeid 
  where #@__archives.ID='$aid'
  ";
  $arcRow = $dsql->GetOne($gquery);
  if(is_array($arcRow)){
	  $arctitle = $arcRow['title'];
	  $arcurl = GetFileUrl($aid,$arcRow['typeid'],$arcRow['senddate'],$arctitle,$arcRow['ismake'],$arcRow['arcrank'],$arcRow['namerule'],$arcRow['typedir'],$arcRow['money']);
  }else{
	  $dsql->Close();
	  ShowMsg("�޷���ȡδ֪�ĵ�����Ϣ!","-1");
	  exit();
  }
	$cu = new ChannelUnit($arcRow['channel'],$aid);
	if(!is_array($cu->ChannelFields)) {
		$cu->Close();
		$dsql->Close();
	  ShowMsg("��ȡ�ĵ�������Ϣʧ�ܣ�","-1");
	  exit();
	}
	$vname = "";
	foreach($cu->ChannelFields as $k=>$v){
		if($v['type']=="softlinks"){ $vname=$k; break; }
	}
	if(!is_array($cu->ChannelFields)) {
		$cu->Close();
		$dsql->Close();
	  ShowMsg("��ȡ�ĵ�������Ϣʧ�ܣ�","-1");
	  exit();
	}
	$row = $dsql->GetOne("Select $vname From ".$cu->ChannelInfos['addtable']." where aid='$aid'");
	$downlinks = $cu->GetAddLinks($row[$vname]);
	$dsql->Close();
	$cu->Close();
	require_once($cfg_basedir.$cfg_templets_dir."/plus/download_links_templet.htm");
	exit();
}
//�ṩ������û�����
//------------------------
else if($open==1){
	$link = base64_decode($link);
	echo "<script language='javascript'>location=\"$link\";</script>";
	exit();
}
?>