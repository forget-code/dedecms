<?php 
require_once(dirname(__FILE__)."/../include/config_base.php");
require_once(dirname(__FILE__)."/../include/inc_channel_unit.php");
if(!isset($aid)){ exit(); }
$aid = ereg_replace("[^0-9]","",$aid);
if(empty($aid)){ exit(); } 
$dsql = new DedeSql(false);
//��ȡ�ĵ���Ϣ
$arctitle = "";
$arcurl = "";
$topID = 0;
$arcRow = $dsql->GetOne("Select #@__archives.title,#@__archives.senddate,#@__archives.arcrank,#@__archives.ismake,#@__archives.money,#@__archives.typeid,#@__arctype.topID,#@__arctype.typedir,#@__arctype.namerule From #@__archives  left join #@__arctype on #@__arctype.ID=#@__archives.typeid where #@__archives.ID='$aid'");
if(is_array($arcRow)){
	$arctitle = $arcRow['title'];
	$topID = $arcRow['topID'];
	$arcurl = GetFileUrl($aid,$arcRow['typeid'],$arcRow['senddate'],$arctitle,$arcRow['ismake'],$arcRow['arcrank'],$arcRow['namerule'],$arcRow['typedir'],$arcRow['money']);
}
else{
	$dsql->Close();
	ShowMsg("�޷����δ֪�ĵ�!","-1");
	exit();
}
if(empty($mx)){ $mx=$cfg_album_width; }
$pageGuide = "";
//��ȡ���·�ͼƬ����
$row = $dsql->GetOne("Select imgurls From #@__addonimages where aid='{$aid}'");
$i = 0;
$nextSrc = "";
$preSrc = "";
$dtp = new DedeTagParse();
$dtp->LoadSource($row['imgurls']);
foreach($dtp->CTags as $ctag){
  if($ctag->GetName()=="img"){
    if($i==($npos-1)){ $preSrc = trim($ctag->GetInnerText()); }
    if($i==($npos+1)){ $nextSrc = trim($ctag->GetInnerText()); }
    $i++;
  }
}
unset($dtp);
if($cfg_multi_site=="��"){
	if(!preg_match("/^http:/i",$preSrc) && !empty( $preSrc)) $preSrc = $cfg_basehost.$preSrc;
	if(!preg_match("/^http:/i",$nextSrc) && !empty($nextSrc)) $nextSrc = $cfg_basehost.$nextSrc;
}
if($preSrc!=""){
	$pageGuide .= "<a href='showphoto.php?aid={$aid}&src=".urlencode($preSrc)."&npos=".($npos-1)."'>&lt;&lt;��һ��ͼƬ</a> ";
}
if($nextSrc!=""){
  if($pageGuide!="") $pageGuide .= " | ";
  $pageGuide .= "<a href='showphoto.php?aid={$aid}&src=".urlencode($nextSrc)."&npos=".($npos+1)."'>��һ��ͼƬ&gt;&gt;</a>";
}
$dsql->Close();
require_once($cfg_basedir.$cfg_templets_dir."/plus/showphoto.htm");
exit();
?>