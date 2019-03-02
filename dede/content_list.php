<?php 
require_once(dirname(__FILE__)."/config.php");
if(!isset($cid)) $cid = 0;
if(!isset($keyword)) $keyword = "";
if(!isset($channelid)) $channelid = 0;
if(!isset($arcrank)) $arcrank = "";
if(!isset($adminid)) $adminid = 0;
if(!isset($ismember)) $ismember = 0;

//���Ȩ����ɣ���Ȩ��
CheckPurview('a_List,a_AccList,a_MyList');
//��Ŀ������
if(TestPurview('a_List')){ ; }
else if(TestPurview('a_AccList')){
	 if($cid==0) $cid = $cuserLogin->getUserChannel();
	 else CheckCatalog($cid,"����Ȩ�����ָ����Ŀ�����ݣ�");
}else{
	 $adminid = $cuserLogin->getUserID();
}

////////////////////////////////////////////////////////////////////
require_once(dirname(__FILE__)."/../include/inc_typelink.php");
require_once(dirname(__FILE__)."/../include/pub_datalist_dm.php");
require_once(dirname(__FILE__)."/inc/inc_list_functions.php");
setcookie("ENV_GOBACK_URL",$dedeNowurl,time()+3600,"/");

$tl = new TypeLink($cid);

if($cid==0){
	if($channelid==0) $positionname = "������Ŀ&gt;";
	else{
		$row = $tl->dsql->GetOne("Select typename From #@__channeltype where ID='$channelid'");
		$positionname = $row[0]."&gt;";
	}
}else{
	$positionname = str_replace($cfg_list_symbol,"&gt;",$tl->GetPositionName())."&gt;";
}

$seltypeids = 0;
if(!empty($cid)){
	$seltypeids = $tl->dsql->GetOne("Select ID,typename,channeltype From #@__arctype where ID='$cid' ");
}
$opall=1;
if(is_array($seltypeids)){
	$optionarr = GetTypeidSel('form3','cid','selbt1',0,$seltypeids['ID'],$seltypeids['typename']);
}else{
	$optionarr = GetTypeidSel('form3','cid','selbt1',0,0,'��ѡ��...');
}


if($channelid==0) $whereSql = " where #@__archives.channel > 0 ";
else $whereSql = " where #@__archives.channel = '$channelid' ";

if($ismember==1) $whereSql .= " And #@__archives.memberID > 0 ";

if(!empty($memberid)) $whereSql .= " And #@__archives.memberID = '$memberid' ";
else $memberid = 0;

if($keyword!=""){
	$whereSql .= " And ( CONCAT(#@__archives.title,#@__archives.writer,#@__archives.source) like '%$keyword%') ";
}

if($cid!=0){
	$tlinkSql = $tl->GetSunID($cid,"#@__archives",0);
	$whereSql .= " And $tlinkSql ";
}

if($adminid>0){ $whereSql .= " And #@__archives.adminID = '$adminid' "; }

if($arcrank!=""){
	$whereSql .= " And #@__archives.arcrank = '$arcrank' ";
	$CheckUserSend = "<input type='button' onClick=\"location='catalog_do.php?cid=".$cid."&dopost=listArchives&gurl=content_list.php';\" value='�����ĵ�' class='nbt'>";
}
else{
	$whereSql .= " And #@__archives.arcrank >-1 ";
	$CheckUserSend = "<input type='button' onClick=\"location='catalog_do.php?cid=".$cid."&dopost=listArchives&arcrank=-1&gurl=content_list.php';\" value='������' class='nbt'>";
}

$tl->Close();

if(empty($orderby)) $orderby = "ID";

$query = "
select #@__archives.ID,#@__archives.adminID,#@__archives.typeid,#@__archives.senddate,
#@__archives.iscommend,#@__archives.ismake,#@__archives.channel,#@__archives.arcrank,
#@__archives.click,#@__archives.title,#@__archives.color,#@__archives.litpic,
#@__archives.pubdate,#@__archives.adminID,#@__archives.memberID,
#@__arctype.typename,#@__channeltype.typename as channelname,#@__admin.uname as adminname 
from #@__archives 
left join #@__arctype on #@__arctype.ID=#@__archives.typeid
left join #@__channeltype on #@__channeltype.ID=#@__archives.channel
left join #@__admin on #@__admin.ID=#@__archives.adminID
$whereSql
order by #@__archives.{$orderby} desc
";

$dlist = new DataList();
$dlist->pageSize = 20;
$dlist->SetParameter("dopost","listArchives");
$dlist->SetParameter("keyword",$keyword);
$dlist->SetParameter("adminid",$adminid);
$dlist->SetParameter("memberid",$memberid);
$dlist->SetParameter("cid",$cid);
$dlist->SetParameter("arcrank",$arcrank);
$dlist->SetParameter("channelid",$channelid);
$dlist->SetParameter("ismember",$ismember);
$dlist->SetParameter("orderby",$orderby);
$dlist->SetSource($query);
include(dirname(__FILE__)."/templets/content_list.htm");
$dlist->Close();

?>