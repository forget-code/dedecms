<?
require_once(dirname(__FILE__)."/config.php");
CheckPurview('a_New,a_AccNew');
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
if($keywords!="") $keywords = trim(cn_substr($keywords,60))." ";
if(!TestPurview('a_Check,a_AccCheck,a_MyCheck')){ $arcrank = -1; }

//�����ϴ�������ͼ
if(empty($ddisremote)) $ddisremote = 0;
$litpic = GetDDImage('litpic',$picname,$ddisremote);

$adminID = $cuserLogin->getUserID();

//�Զ�ժҪ
if($description=="" && $cfg_auot_description>0){
	$description = stripslashes(cn_substr(html2text($body),$cfg_auot_description));
	$description = addslashes($description);
}

//������������

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

//��������б�
$softurl1 = stripslashes($softurl1);
$urls = "";
if($softurl1!="") $urls .= "{dede:link text='��������'} $softurl1 {/dede:link}\r\n";
for($i=2;$i<=9;$i++)
{
	if(!empty(${'softurl'.$i}))
	{ 
		$servermsg = str_replace("'","",stripslashes(${'servermsg'.$i}));
	  $softurl = stripslashes(${'softurl'.$i});
		if($servermsg=="") $servermsg = "���ص�ַ".$i;
		if($softurl!="" && $softurl!="http://")
		{ $urls .= "{dede:link text='$servermsg'} $softurl {/dede:link}\r\n"; }
  }
}

$urls = addslashes($urls);

$softsize = $softsize.$unit;

//���븽�ӱ�
//----------------------------------
$arcID = $dsql->GetLastID();

$inQuery = "
INSERT INTO #@__addonsoft(aid,typeid,filetype,language,softtype,accredit,
os,softrank,officialUrl,officialDemo,softsize,softlinks,introduce) 
VALUES ('$arcID','$typeid','$filetype','$language','$softtype','$accredit',
'$os','$softrank','$officialUrl','$officialDemo','$softsize','$urls','$body');
";

$dsql->SetQuery($inQuery);
if(!$dsql->ExecuteNoneQuery()){
	$dsql->SetQuery("Delete From #@__archives where ID='$arcID'");
	$dsql->ExecuteNoneQuery();
	$dsql->Close();
	ShowMsg("�����ݱ��浽���ݿ⸽�ӱ� addonsoft ʱ��������ԭ��","-1");
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
<a href='soft_add.php?cid=$typeid'><u>�����������</u></a>
&nbsp;&nbsp;
<a href='$artUrl' target='_blank'><u>�鿴���</u></a>
&nbsp;&nbsp;
<a href='catalog_do.php?cid=$typeid&dopost=listArchives'><u>�ѷ����������</u></a>
&nbsp;&nbsp;
<a href='catalog_main.php'><u>��վ��Ŀ����</u></a>
";

$wintitle = "�ɹ�����һ�������";
$wecome_info = "���¹���::�������";
$win = new OxWindow();
$win->AddTitle("�ɹ����������");
$win->AddMsgItem($msg);
$winform = $win->GetWindow("hand","&nbsp;",false);
$win->Display();
?>