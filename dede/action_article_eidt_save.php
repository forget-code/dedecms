<?
require_once(dirname(__FILE__)."/config.php");
require_once(dirname(__FILE__)."/../include/inc_photograph.php");
require_once(dirname(__FILE__)."/../include/pub_oxwindow.php");
require_once(dirname(__FILE__)."/inc/inc_archives_functions.php");

if(!isset($iscommend)) $iscommend = 0;
if(!isset($ispic)) $ispic = 0;
if(!isset($isbold)) $isbold = 0;
if(!isset($autokey)) $autokey = 0;
if(!isset($remote)) $remote = 0;
if(!isset($dellink)) $dellink = 0;
//if(!isset($seltypeid)) $seltypeid = 0;

if(empty($channelid)||empty($ID)){
	ShowMsg("�ĵ�Ϊ��ָ�������ͣ���������������ʱ�Ƿ�Ϸ���","-1");
	exit();
}

//�Ա�������ݽ��д���
//--------------------------------
$iscommend = $iscommend + $isbold;

$pubdate = GetMkTime($pubdate);
$sortrank = AddDay($senddate,$sortup);//$pubdate + ($sortup * 24 * 3600);

if($ishtml==0) $ismake = -1;
else $ismake = 0;

//if($typeid==0 && $seltypeid>0) $typeid = $seltypeid;

$title = cn_substr($title,60);
$color =  cn_substr($color,10);
$writer =  cn_substr($writer,30);
$source = cn_substr($source,50);
$description = cn_substr($description,250);
if($keywords!="") $keywords = trim(cn_substr($keywords,60))." ";
if($cuserLogin->getUserRank() < 5){ $arcrank = -1; }

if(!empty($picname)) $litpic = $picname;
else $litpic = "";

$body = stripslashes($body);

//��������Զ�̵�ͼƬ��Դ���ػ�
//------------------------------------
if($isUrlOpen && $remote==1){
	$body = GetCurContent($body);
}

$body = addslashes($body);

$adminID = $cuserLogin->getUserID();

//�������ݿ��SQL���
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
writer='$writer',
source='$source',
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

$row = $dsql->GetOne("Select aid,typeid From #@__addonarticle where aid='$ID'");
if(!is_array($row))
{
  $dsql->SetQuery("INSERT INTO #@__addonarticle(aid,typeid,body) Values('$ID','$typeid','$body')");
  if(!$dsql->ExecuteNoneQuery()){
	   $dsql->Close();
	   ShowMsg("�����ݱ��浽���ݿ⸽�ӱ�addonarticleʱ��������ԭ��","-1");
	   exit();
  }
}
else
{
	$dsql->SetQuery("update #@__addonarticle set typeid='$typeid',body='$body' where aid='$ID'");
  if(!$dsql->ExecuteNoneQuery()){
	   $dsql->Close();
	   ShowMsg("���¸��ӱ�addonarticleʱ��������ԭ��","-1");
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
<a href='article_add.php?cid=$typeid'><u>����������</u></a>
&nbsp;&nbsp;
<a href='archives_do.php?aid=".$ID."&dopost=editArchives'><u>�鿴����</u></a>
&nbsp;&nbsp;
<a href='$artUrl' target='_blank'><u>�鿴����</u></a>
&nbsp;&nbsp;
<a href='catalog_do.php?cid=$typeid&dopost=listArchives'><u>��������</u></a>
&nbsp;&nbsp;
<a href='catalog_main.php'><u>��վ��Ŀ����</u></a>
";

$wintitle = "�ɹ��������£�";
$wecome_info = "���¹���::��������";
$win = new OxWindow();
$win->AddTitle("�ɹ��������£�");
$win->AddMsgItem($msg);
$winform = $win->GetWindow("hand","&nbsp;",false);
$win->Display();
?>