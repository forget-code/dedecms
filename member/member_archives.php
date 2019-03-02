<?php 
require_once(dirname(__FILE__)."/config_space.php");
require_once(dirname(__FILE__)."/../include/pub_datalist_dm.php");
require_once(dirname(__FILE__)."/../include/inc_channel_unit_functions.php");

if(empty($keyword)) $keyword = "";
else{
	$keyword = cn_substr(trim(ereg_replace($cfg_egstr,"",stripslashes($keyword))),30);
	$keyword = addslashes($keyword);
}
if(empty($channelid)) $channelid = 0;
if(empty($mtype)) $mtype = 0;

if(!TestStringSafe($uid)){
		ShowMsg("用户ID不合法！","-1");
		exit();
}

if(empty($channelid)){
	$listName = '　§所有文档';
}
else if($channelid==1){
	$listName = "　§<a href='member_archives.php?uid=$uid' style='color:#666600'>所有文档</a>&gt;&gt;我的文章";
}
else if($channelid==2){
	$listName = "　§<a href='member_archives.php?uid=$uid' style='color:#666600'>所有文档</a>&gt;&gt;我的图集";
}

//用户信息
$dsql = new DedeSql(false);
$spaceInfos = $dsql->GetOne("Select ID,uname,spacename,spaceimage,sex,c1,c2,spaceshow,logintime,scores From #@__member where userid='$uid'; ");
if(!is_array($spaceInfos)){
	ShowMsg("参数错误或者用户已经被删除！","-1");
	exit();
}
//积分头衔
$scores = $spaceInfos['scores'];
$honors = @explode("#|",Gethonor($scores));
$honor = $honors[0];
$space_star = $honors[1];
foreach( $spaceInfos as $k=>$v){if(ereg("[^0-9]",$k)) $$k = $v; }
$userNumID = $ID;
if($spaceimage==''){
	if($sex=='女') $spaceimage = 'images/space_nophoto.gif';
	else $spaceimage = 'images/space_nophoto.gif';
}

if(!empty($mtype)){
	$mtype = ereg_replace("[^0-9]","",$mtype);
	$rows = $dsql->GetOne("Select typename From #@__member_arctype where aid='$mtype'; ");
	$listName .= "&gt;&gt;".$rows['typename'];
}

//获取文档列表
$whereSql = " arc.mid='$userNumID' ";
if(!empty($channelid)) $whereSql .= " And arc.channelid='$channelid' ";
if(!empty($mtype)) $whereSql .= " And (arc.mtype='$mtype') ";
if($keyword!=""){
	$whereSql .= " And (arc.title like '%$keyword%') ";
}

$query = "Select arc.*,tp.typename From `#@__full_search` arc left join #@__arctype tp on tp.ID = arc.typeid
 where $whereSql order by arc.aid desc";

$dlist = new DataList();
$dlist->pageSize = 10;
$dlist->SetParameter("uid",$uid);
$dlist->SetParameter("keyword",$keyword);
$dlist->SetParameter("mtype",$mtype);
$dlist->SetParameter("channelid",$channelid);
$dlist->SetSource($query);

include(dirname(__FILE__)."/templets/space/member_archives.htm");

?>