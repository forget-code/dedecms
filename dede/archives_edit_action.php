<?php 
require_once(dirname(__FILE__)."/config.php");
CheckPurview('a_Edit,a_AccEdit,a_MyEdit');
require_once(dirname(__FILE__)."/../include/inc_photograph.php");
require_once(dirname(__FILE__)."/../include/pub_oxwindow.php");
require_once(dirname(__FILE__)."/inc/inc_archives_functions.php");
require_once(dirname(__FILE__)."/inc/inc_archives_all.php");

if(!isset($iscommend)) $iscommend = 0;
if(!isset($isjump)) $isjump = 0;
if(!isset($isbold)) $isbold = 0;
if(!isset($autokey)) $autokey = 0;
if(!isset($remote)) $remote = 0;
if(!isset($dellink)) $dellink = 0;

if($typeid==0){
	ShowMsg("��ָ���ĵ�����Ŀ��","-1");
	exit();
}
if(empty($channelid)){
	ShowMsg("�ĵ�Ϊ��ָ�������ͣ������㷢�����ݵı��Ƿ�Ϸ���","-1");
	exit();
}
if(!CheckChannel($typeid,$channelid) || !CheckChannel($typeid2,$channelid)){
	ShowMsg("����ѡ�����Ŀ�뵱ǰģ�Ͳ��������ѡ���ɫ��ѡ�","-1");
	exit();
}
if(!TestPurview('a_Edit')) {
	if(TestPurview('a_AccEdit')) CheckCatalog($typeid,"�Բ�����û�в�����Ŀ {$typeid} ���ĵ�Ȩ�ޣ�");
	else CheckArcAdmin($ID,$cuserLogin->getUserID());
}

$arcrank = GetCoRank($arcrank,$typeid);

//�Ա�������ݽ��д���
//--------------------------------
$iscommend = $iscommend + $isbold;

$pubdate = GetMkTime($pubdate);
$sortrank = AddDay($senddate,$sortup);

if($ishtml==0) $ismake = -1;
else $ismake = 0;

$shorttitle = cn_substr($shorttitle,36);
$color =  cn_substr($color,10);
$writer =  cn_substr($writer,30);
$source = cn_substr($source,50);
$description = cn_substr($description,250);
if($keywords!="") $keywords = trim(cn_substr($keywords,60))." ";
if(!TestPurview('a_Check,a_AccCheck,a_MyCheck')){ $arcrank = -1; }

//�����ϴ�������ͼ
if(empty($ddisremote)) $ddisremote = 0;
$litpic = GetDDImage('none',$picname,$ddisremote);

$adminID = $cuserLogin->getUserID();

//�������ݿ��SQL���
//----------------------------------
$inQuery = "
update #@__archives set
typeid='$typeid',
typeid2='$typeid2',
sortrank='$sortrank',
iscommend='$iscommend',
redirecturl='$redirecturl',
ismake='$ismake',
arcrank='$arcrank',
money='$money',
title='$title',
color='$color',
writer='$writer',
source='$source',
litpic='$litpic',
pubdate='$pubdate',
description='$description',
keywords='$keywords',
shorttitle='$shorttitle',
arcatt='$arcatt'
where ID='$ID'; ";

$dsql = new DedeSql();
$dsql->SetQuery($inQuery);
if(!$dsql->ExecuteNoneQuery()){
	$dsql->Close();
	ShowMsg("�������ݿ�archives��ʱ�������飡","-1");
	exit();
}

//----------------------------------
//���������ӱ�����
//----------------------------------
if(empty($dede_addtablename)) $dede_addtablename = "";
if(empty($dede_addonfields)) $dede_addonfields = "";
$addonfields = explode(";",$dede_addonfields);
$upfield = "";
foreach($addonfields as $v)
{
	if($v=="") continue;
	$vs = explode(",",$v);
	if($vs[1]=="textdata"){
		${$vs[0]} = GetFieldValue(${$vs[0]},$vs[1],$ID,'edit',${$vs[0].'_file'});
	}else{
		${$vs[0]} = GetFieldValue(${$vs[0]},$vs[1]);
	}
	if($upfield=="") $upfield .= $vs[0]." = '".${$vs[0]}."'";
	else $upfield .= ", ".$vs[0]." = '".${$vs[0]}."'";
}
$addQuery = "Update ".$dede_addtablename." set $upfield where aid='$ID'";
$dsql->SetQuery($addQuery);
$dsql->ExecuteNoneQuery();
$dsql->Close();
//����HTML
//---------------------------------

$artUrl = MakeArt($ID,true);
if($artUrl=="") $artUrl = $cfg_plus_dir."/view.php?aid=$ID";

//---------------------------------
//���سɹ���Ϣ
//----------------------------------

$msg = "
������ѡ����ĺ���������
<a href='archives_add.php?cid=$typeid'><u>�������ĵ�</u></a>
&nbsp;&nbsp;
<a href='archives_do.php?aid={$ID}&dopost=editArchives'><u>�鿴����</u></a>
&nbsp;&nbsp;
<a href='$artUrl' target='_blank'><u>Ԥ���ĵ�</u></a>
&nbsp;&nbsp;
<a href='catalog_do.php?cid=$typeid&dopost=listArchives'><u>�����ĵ�</u></a>
&nbsp;&nbsp;
<a href='catalog_main.php'><u>��վ��Ŀ����</u></a>
";

$wintitle = "�ɹ������ĵ���";
$wecome_info = "���¹���::�����ĵ�";
$win = new OxWindow();
$win->AddTitle("�ɹ������ĵ���");
$win->AddMsgItem($msg);
$winform = $win->GetWindow("hand","&nbsp;",false);
$win->Display();
?>