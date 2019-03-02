<?
require_once(dirname(__FILE__)."/config.php");
CheckPurview('a_New,a_AccNew');
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
if(!TestPurview('a_New')) {
	CheckCatalog($typeid,"�Բ�����û�в�����Ŀ {$typeid} ��Ȩ�ޣ�");
	if($typeid2!=0) CheckCatalog($typeid2,"�Բ�����û�в�����Ŀ {$typeid2} ��Ȩ�ޣ�");
}
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

if($keywords!="") $keywords = trim(cn_substr($keywords,56))." ";
$adminID = $cuserLogin->getUserID();

//�������ݿ��SQL���
//----------------------------------
$inQuery = "INSERT INTO #@__archives(
typeid,typeid2,sortrank,iscommend,ismake,channel,
arcrank,click,money,title,shorttitle,color,writer,source,litpic,
pubdate,senddate,arcatt,adminID,memberID,description,keywords) 
VALUES ('$typeid','$typeid2','$sortrank','$iscommend','$ismake','$channelid',
'$arcrank','0','$money','$title','$shorttitle','$color','$writer','$source','$litpic',
'$pubdate','$senddate','$arcatt','$adminID','0','$description','$keywords');";

$dsql = new DedeSql();
$dsql->SetQuery($inQuery);
if(!$dsql->ExecuteNoneQuery()){
	$dsql->Close();
	ShowMsg("�����ݱ��浽���ݿ�archives��ʱ�������飡","-1");
	exit();
}
$arcID = $dsql->GetLastID();

//----------------------------------
//���������ӱ�����
//----------------------------------
if(empty($dede_addtablename)) $dede_addtablename = "";
if(empty($dede_addonfields)) $dede_addonfields = "";
$addonfields = explode(";",$dede_addonfields);
$inadd_f = "";
$inadd_v = "";
$autoDescription = false;
foreach($addonfields as $v)
{
	if($v=="") continue;
	$vs = explode(",",$v);
	//HTML�ı����⴦��
	if($vs[1]=="htmltext"||$vs[1]=="textdata")
	{
		${$vs[0]} = stripslashes(${$vs[0]});
    //�������body����ⲿ��Դ
    if($isUrlOpen && $remote==1){
	    ${$vs[0]} = GetCurContent(${$vs[0]});
    }
    //ȥ�������е�վ������
    if($dellink==1){
	    ${$vs[0]} = str_replace($cfg_basehost,'#basehost#',${$vs[0]});
	    ${$vs[0]} = preg_replace("/(<a[ \t\r\n]{1,}href=[\"']{0,}http:\/\/[^\/]([^>]*)>)|(<\/a>)/isU","",${$vs[0]});
      ${$vs[0]} = str_replace('#basehost#',$cfg_basehost,${$vs[0]});
    }
    //�Զ�ժҪ
    if($description=="" && $cfg_auot_description>0){
    	$description = cn_substr(html2text(${$vs[0]}),$cfg_auot_description);
	    $description = trim(preg_replace("/#p#|#e#/","",$description));
	    $description = addslashes($description);
	    $autoDescription = true;
    }
    ${$vs[0]} = addslashes(${$vs[0]});
    ${$vs[0]} = GetFieldValue(${$vs[0]},$vs[1],$arcID);
	}else{
		${$vs[0]} = GetFieldValue(${$vs[0]},$vs[1],$arcID);
	}
	$inadd_f .= ",".$vs[0];
	$inadd_v .= ",'".${$vs[0]}."'";
}

if($autoDescription){
	$dsql->ExecuteNoneQuery("update #@__archives set description='$description' where ID='$arcID';");
}

if($dede_addtablename!="" && $addonfields!="")
{
  $dsql->SetQuery("INSERT INTO ".$dede_addtablename."(aid,typeid".$inadd_f.") Values('$arcID','$typeid'".$inadd_v.")");
  if(!$dsql->ExecuteNoneQuery()){
	  $dsql->SetQuery("Delete From #@__archives where ID='$arcID'");
	  $dsql->ExecuteNoneQuery();
	  $dsql->Close();
	  ShowMsg("�����ݱ��浽���ݿ⸽�ӱ� ".$dede_addtablename." ʱ��������ԭ��","-1");
	  exit();
  }
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
<a href='archives_add.php?cid=$typeid'><u>���������ĵ�</u></a>
&nbsp;&nbsp;
<a href='archives_do.php?aid={$arcID}&dopost=editArchives'><u>�����ĵ�</u></a>
&nbsp;&nbsp;
<a href='$artUrl' target='_blank'><u>Ԥ���ĵ�</u></a>
&nbsp;&nbsp;
<a href='catalog_do.php?cid=$typeid&dopost=listArchives'><u>�ѷ����ĵ�����</u></a>
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