<?
require_once(dirname(__FILE__)."/config.php");
CheckPurview('a_Edit,a_AccEdit,a_MyEdit');
require_once(dirname(__FILE__)."/../include/inc_photograph.php");
require_once(dirname(__FILE__)."/../include/pub_oxwindow.php");
require_once(dirname(__FILE__)."/inc/inc_archives_functions.php");

if(!isset($iscommend)) $iscommend = 0;
if(!isset($isjump)) $isjump = 0;
if(!isset($isbold)) $isbold = 0;
if(!isset($autokey)) $autokey = 0;
if(!isset($remote)) $remote = 0;
if(!isset($dellink)) $dellink = 0;
if(!isset($autolitpic)) $autolitpic = 0;

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
if($keywords!="") $keywords = trim(cn_substr($keywords,60))." ";
if(!TestPurview('a_Check,a_AccCheck,a_MyCheck')){ $arcrank = -1; }

//�����ϴ�������ͼ
if(empty($ddisremote)) $ddisremote = 0;
$litpic = GetDDImage('none',$picname,$ddisremote);

$body = stripslashes($body);

//��������Զ�̵�ͼƬ��Դ���ػ�
//------------------------------------
if($isUrlOpen && $remote==1){
	$body = GetCurContent($body);
}

//�Զ�ժҪ
if($description=='' && $cfg_auot_description>0){
	$description = stripslashes(cn_substr(html2text($body),$cfg_auot_description));
	$description = trim(preg_replace("/#p#|#e#/","",$description));
	$description = addslashes($description);
}

//�Զ���ȡ����ͼ
if($autolitpic==1 && $litpic==''){
  $cfg_medias_dir = str_replace('/','\/',$cfg_medias_dir);
  $picname = preg_replace("/.+?".$cfg_medias_dir."(.*)( |\"|').*$/isU",$cfg_medias_dir."$1",$body);
  if(eregi("\.(jpg|gif|png)$",$picname)) $litpic = GetDDImage('ddfirst',$picname,0);
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