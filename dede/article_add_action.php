<?php 
require_once(dirname(__FILE__)."/config.php");
CheckPurview('a_New,a_AccNew');
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
if(!TestPurview('a_New')) {
	CheckCatalog($typeid,"�Բ�����û�в�����Ŀ {$typeid} ��Ȩ�ޣ�");
	if($typeid2!=0) CheckCatalog($typeid2,"�Բ�����û�в�����Ŀ {$typeid2} ��Ȩ�ޣ�");
}

$arcrank = GetCoRank($arcrank,$typeid);

//�Ա�������ݽ��д���
//--------------------------------
$iscommend = $iscommend + $isbold;

$pubdate = GetMkTime($pubdate);
$senddate = mytime();
$sortrank = AddDay($senddate,$sortup);

if($ishtml==0) $ismake = -1;
else $ismake = 0;

$shorttitle = cn_substr($shorttitle,36);
$color =  cn_substr($color,10);
$writer =  cn_substr($writer,30);
$source = cn_substr($source,50);
$description = cn_substr($description,250);
$keywords = cn_substr($keywords,60);
if(!TestPurview('a_Check,a_AccCheck,a_MyCheck')){ $arcrank = -1; }

//�����ϴ�������ͼ
if(empty($ddisremote)) $ddisremote = 0;
$litpic = GetDDImage('litpic',$picname,$ddisremote);

$body = stripslashes($body);

//�Զ�ժҪ
if($description=="" && $cfg_auot_description>0){
	$description = stripslashes(cn_substr(html2text($body),$cfg_auot_description));
	$description = trim(preg_replace("/#p#|#e#/","",$description));
	$description = addslashes($description);
}
//��������Զ�̵�ͼƬ��Դ���ػ�
//------------------------------------
if($isUrlOpen && $remote==1){
	$body = GetCurContent($body);
}
//ȥ�������е�վ������
//------------------------------------
if($dellink==1){
	$body = str_replace($cfg_basehost,'#basehost#',$body);
	$body = preg_replace("/(<a[ \t\r\n]{1,}href=[\"']{0,}http:\/\/[^\/]([^>]*)>)|(<\/a>)/isU","",$body);
  $body = str_replace('#basehost#',$cfg_basehost,$body);
}
//�Զ���ȡ�����еĹؼ���
//----------------------------------
if($autokey==1||$keywords==""){
	require_once(dirname(__FILE__)."/../include/pub_splitword_www.php");
	$keywords = "";
	$sp = new SplitWord();
	$titleindexs = explode(" ",trim($sp->GetIndexText($sp->SplitRMM($title))));
	$allindexs = explode(" ",trim($sp->GetIndexText($sp->SplitRMM(Html2Text($body)),200)));
	if(is_array($allindexs) && is_array($titleindexs)){
		foreach($titleindexs as $k){	
			if(strlen($keywords)>=50) break;
			else $keywords .= $k." ";
		}
		foreach($allindexs as $k){
			if(strlen($keywords)>=50) break;
			else if(!in_array($k,$titleindexs)) $keywords .= $k." ";
	  }
	}
	$sp->Clear();
	unset($sp);
	$keywords = preg_replace("/#p#|#e#/","",$keywords);
	$keywords = addslashes($keywords);
}
//�Զ���ҳ
if($sptype=="auto"){
	$body = SpLongBody($body,$spsize*1024,"#p#��ҳ����#e#");
}

//�Զ���ȡ����ͼ
if($autolitpic==1 && $litpic==''){
  $cfg_medias_dir = str_replace('/','\/',$cfg_medias_dir);
  $picname = preg_replace("/.+?".$cfg_medias_dir."(.*)( |\"|').*$/isU",$cfg_medias_dir."$1",$body);
  if(eregi("\.(jpg|gif|png)$",$picname)){
  	 if(ereg("_lit\.",$picname)) $litpic = $picname;
  	 else $litpic = GetDDImage('ddfirst',$picname,0);
  }
}

$body = addslashes($body);
if($keywords!="") $keywords = trim(cn_substr($keywords,60))." ";
$adminID = $cuserLogin->getUserID();

//�������ݿ��SQL���
//----------------------------------
$inQuery = "INSERT INTO #@__archives(
typeid,typeid2,sortrank,iscommend,ismake,channel,
arcrank,click,money,title,shorttitle,color,writer,source,litpic,
pubdate,senddate,arcatt,adminID,memberID,description,keywords,templet,redirecturl) 
VALUES ('$typeid','$typeid2','$sortrank','$iscommend','$ismake','$channelid',
'$arcrank','0','$money','$title','$shorttitle','$color','$writer','$source','$litpic',
'$pubdate','$senddate','$arcatt','$adminID','0','$description','$keywords','$templet','$redirecturl');";

$dsql = new DedeSql();
$dsql->SetQuery($inQuery);
if(!$dsql->ExecuteNoneQuery()){
	$dsql->Close();
	ShowMsg("�����ݱ��浽���ݿ�archives��ʱ�������飡","-1");
	exit();
}
$arcID = $dsql->GetLastID();
$dsql->SetQuery("INSERT INTO #@__addonarticle(aid,typeid,body) Values('$arcID','$typeid','$body')");
if(!$dsql->ExecuteNoneQuery()){
	$dsql->SetQuery("Delete From #@__archives where ID='$arcID'");
	$dsql->ExecuteNoneQuery();
	$dsql->Close();
	ShowMsg("�����ݱ��浽���ݿ⸽�ӱ�addonarticleʱ��������ԭ��","-1");
	exit();
}
$dsql->Close();

//����HTML
//---------------------------------

$artUrl = MakeArt($arcID,true);
if($artUrl=="") $artUrl = $cfg_plus_dir."/view.php?aid=$arcID";

//---------------------------------
//���سɹ���Ϣ
//----------------------------------

$msg = "
������ѡ����ĺ���������
<a href='article_add.php?cid=$typeid'><u>������������</u></a>
&nbsp;&nbsp;
<a href='$artUrl' target='_blank'><u>�鿴����</u></a>
&nbsp;&nbsp;
<a href='archives_do.php?aid=".$arcID."&dopost=editArchives'><u>��������</u></a>
&nbsp;&nbsp;
<a href='catalog_do.php?cid=$typeid&dopost=listArchives'><u>�ѷ������¹���</u></a>
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