<?
require_once(dirname(__FILE__)."/config.php");
require_once(dirname(__FILE__)."/../include/inc_photograph.php");
require_once(dirname(__FILE__)."/../include/pub_oxwindow.php");
require_once(dirname(__FILE__)."/inc/inc_archives_functions.php");

if(!isset($iscommend)) $iscommend = 0;
if(!isset($ispic)) $ispic = 0;
if(!isset($isbold)) $isbold = 0;

if(empty($channelid)||empty($ID)){
	ShowMsg("�ĵ�Ϊ��ָ�������ͣ���������������ʱ�Ƿ�Ϸ���","-1");
	exit();
}

//�Ա�������ݽ��д���
//--------------------------------
$iscommend = $iscommend + $isbold;

$pubdate = GetMkTime($pubdate);
$sortrank = AddDay($senddate,$sortup);

if($ishtml==0) $ismake = -1;
else $ismake = 0;

$title = cn_substr($title,60);
$color =  cn_substr($color,10);
$writer =  cn_substr($writer,30);
$source = cn_substr($source,50);
$description = cn_substr($description,250);
if($keywords!="") $keywords = trim(cn_substr($keywords,50))." ";
if($cuserLogin->getUserRank() < 5){ $arcrank = -1; }

if(!empty($picname)) $litpic = $picname;
else $litpic = "";

$filesize = $filesize;
$playtime = $tms; 
$width  = GetAlabNum($width);
$height = GetAlabNum($height);
//$flashurl = "";

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
keywords=' $keywords '
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