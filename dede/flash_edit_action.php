<?php 
require_once(dirname(__FILE__)."/config.php");
CheckPurview('a_Edit,a_AccEdit,a_MyEdit');
require_once(dirname(__FILE__)."/../include/inc_photograph.php");
require_once(dirname(__FILE__)."/../include/pub_oxwindow.php");
require_once(dirname(__FILE__)."/inc/inc_archives_functions.php");

if(!isset($iscommend)) $iscommend = 0;
if(!isset($isjump)) $isjump = 0;
if(!isset($isbold)) $isbold = 0;

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

$title = cn_substr($title,80);
$shorttitle = cn_substr($shorttitle,36);
$color =  cn_substr($color,10);
$writer =  cn_substr($writer,30);
$source = cn_substr($source,50);
$description = cn_substr($description,250);
if($keywords!="") $keywords = trim(cn_substr($keywords,50))." ";
if(!TestPurview('a_Check,a_AccCheck,a_MyCheck')){ $arcrank = -1; }

//�����ϴ�������ͼ
if(empty($ddisremote)) $ddisremote = 0;
$litpic = GetDDImage('none',$picname,$ddisremote);

$filesize = $filesize;
$playtime = $tms; 
$width  = GetAlabNum($width);
$height = GetAlabNum($height);

//����Զ�̵�Flash
//------------------
if(empty($downremote)) $downremote = 0;
$rmflash = "";
if(eregi("^http://",$flashurl) 
  && !eregi($cfg_basehost,$flashurl) && $downremote==1)
{
	if($isUrlOpen) $rmflash = GetRemoteFlash($flashurl,$adminID);
}
if($width==0)  $width  = "500";
if($height==0) $height = "350";
if($rmflash!="") $flashurl = $rmflash;

if($flashurl==""){
	ShowMsg("Flash��ַ����ȷ����Զ�̲ɼ�����","-1");
	exit();
}

//������������
//----------------------------------
$inQuery = "
update #@__archives set
typeid='$typeid',
typeid2='$typeid2',
sortrank='$sortrank',
redirecturl='$redirecturl',
iscommend='$iscommend',
ismake='$ismake',
arcrank='$arcrank',
money='$money',
title='$title',
color='$color',
source='$source',
writer='$writer',
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

//���¸��ӱ�
//----------------------------------

$row = $dsql->GetOne("Select aid,typeid From #@__addonflash where aid='$ID'");
if(!is_array($row))
{
  $query = "
  INSERT INTO #@__addonflash(aid,typeid,filesize,playtime,flashtype,flashrank,width,height,flashurl) 
  VALUES ('$ID','$typeid','$filesize','$playtime','$flashtype','$flashrank','$width','$height','$flashurl');
  ";
  $dsql->SetQuery($query);
  if(!$dsql->ExecuteNoneQuery()){
	  $dsql->Close();
	  ShowMsg("�����ݱ��浽���ݿ⸽�ӱ� addonflash ʱ��������ԭ��","-1");
	  exit();
  }
}
else
{
	$query = "
  update #@__addonflash
  set typeid ='$typeid',
  filesize ='$filesize',
  playtime ='$playtime',
  flashtype ='$flashtype',
  flashrank ='$flashrank',
  width ='$width',
  height ='$height',
  flashurl ='$flashurl'
  where aid='$ID';
  ";
  $dsql->SetQuery($query);
  if(!$dsql->ExecuteNoneQuery()){
	  $dsql->Close();
	  ShowMsg("�������ݿ⸽�ӱ� addonflash ʱ��������ԭ��","-1");
	  exit();
  }
}

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
<a href='flash_add.php?cid=$typeid'><u>������Flash��Ʒ</u></a>
&nbsp;&nbsp;
<a href='archives_do.php?aid=".$ID."&dopost=editArchives'><u>�鿴����</u></a>
&nbsp;&nbsp;
<a href='$artUrl' target='_blank'><u>�鿴�ĵ�</u></a>
&nbsp;&nbsp;
<a href='catalog_do.php?cid=$typeid&dopost=listArchives'><u>�ѷ���Flash����</u></a>
&nbsp;&nbsp;
<a href='catalog_main.php'><u>��վ��Ŀ����</u></a>
";

$wintitle = "�ɹ�����һ��Flash��Ʒ��";
$wecome_info = "���¹���::����Flash";
$win = new OxWindow();
$win->AddTitle("�ɹ�����һ��Flash��");
$win->AddMsgItem($msg);
$winform = $win->GetWindow("hand","&nbsp;",false);
$win->Display();
?>