<?php 
require_once(dirname(__FILE__)."/config.php");
CheckRank(0,0);

$svali = GetCkVdValue();
if(strtolower($vdcode)!=$svali || $svali==""){
  ShowMsg("��֤�����","-1");
  exit();
}

require_once(dirname(__FILE__)."/../include/inc_photograph.php");
require_once(dirname(__FILE__)."/../include/pub_oxwindow.php");
require_once(dirname(__FILE__)."/inc/inc_archives_functions.php");

if(!isset($iscommend)) $iscommend = 0;
if(!isset($isjump)) $isjump = 0;
if(!isset($isbold)) $isbold = 0;
if(!isset($isrm)) $isrm = 0;
if(!isset($ddisfirst)) $ddisfirst = 0;
if(!isset($ddisremote)) $ddisremote = 0;
$channelid = 1;
$typeid = ereg_replace("[^0-9]","",$typeid);

if($typeid==0){
	ShowMsg("��ָ���ĵ���������Ŀ��","-1");
	exit();
}

if(!CheckChannel($typeid,$channelid)){
	ShowMsg("����ѡ�����Ŀ�뵱ǰģ�Ͳ��������֧��Ͷ�壬��ѡ���ɫ��ѡ�","-1");
	exit();
}

$dsql = new DedeSql(false);

$cInfos = $dsql->GetOne("Select sendrank,arcsta From #@__channeltype  where ID='1'; ");	
if($cInfos['sendrank'] > $cfg_ml->M_Type){
	$row = $dsql->GetOne("Select membername From #@__arcrank where rank='".$cInfos['sendrank']."' ");
	$dsql->Close();
	ShowMsg("�Բ�����Ҫ[".$row['membername']."]���������Ƶ�������ĵ���","-1","0",5000);
	exit();
}
//�Ա�������ݽ��д���
//--------------------------------
$typeid2 = 0;
$pubdate = mytime();
$senddate = $pubdate;
$sortrank = $pubdate;

if($cInfos['arcsta']==0){
	$ismake = 0;
	$arcrank = 0;
}
else if($cInfos['arcsta']==1){
	$ismake = -1;
	$arcrank = 0;
}
else{
	$ismake = 0;
	$arcrank = -1;
}

$shorttitle = '';
$color =  '';
$money = 0;
$arcatt = 0;
$pagestyle = 2;

$title = ClearHtml($title);
$writer =  cn_substr(trim(ClearHtml($writer)),30);
$source = cn_substr(trim(ClearHtml($source)),50);
$description = cn_substr(trim(ClearHtml($description)),250);
if($keywords!=""){
	$keywords = ereg_replace("[,;]"," ",trim(ClearHtml($keywords)));
	$keywords = trim(cn_substr($keywords,60))." ";
}

$userip = GetIP();
//�����ϴ�������ͼ
if(!empty($litpic)) $litpic = GetUpImage('litpic',true,true);
else $litpic = "";
$adminID = 0;
$memberID = $cfg_ml->M_ID;

$body = eregi_replace("<(iframe|script)","",$body);

//������������
//----------------------------------
$inQuery = "INSERT INTO #@__archives(
typeid,typeid2,sortrank,iscommend,ismake,channel,
arcrank,click,money,title,shorttitle,color,writer,source,litpic,
pubdate,senddate,arcatt,adminID,memberID,description,keywords,mtype,userip) 
VALUES ('$typeid','$typeid2','$sortrank','$iscommend','$ismake','$channelid',
'$arcrank','0','$money','$title','$shorttitle','$color','$writer','$source','$litpic',
'$pubdate','$senddate','$arcatt','$adminID','$memberID','$description','$keywords','$mtype','$userip');";
$dsql->SetQuery($inQuery);
if(!$dsql->ExecuteNoneQuery()){
	$dsql->Close();
	ShowMsg("�����ݱ��浽���ݿ�archives��ʱ�������飡","-1");
	exit();
}
$arcID = $dsql->GetLastID();

//���븽�ӱ�
//----------------------------------
$dsql->SetQuery("INSERT INTO #@__addonarticle(aid,typeid,body) Values('$arcID','$typeid','$body')");
if(!$dsql->ExecuteNoneQuery()){
	    $dsql->SetQuery("Delete From #@__archives where ID='$arcID'");
	    $dsql->ExecuteNoneQuery();
	    $dsql->Close();
	    ShowMsg("�����ݱ��浽���ݿ⸽ʱ��������ϵ����Ա��","-1");
	    exit();
}

$dsql->ExecuteNoneQuery("Update #@__member set c1=c1+1 where ID='".$cfg_ml->M_ID."';");

$dsql->Close();

$artUrl = MakeArt($arcID);

//---------------------------------
//���سɹ���Ϣ
//----------------------------------

$msg = "
��ѡ����ĺ���������
<a href='article_add.php?cid=$typeid'><u>������������</u></a>
&nbsp;&nbsp;
<a href='article_edit.php?aid=".$arcID."'><u>��������</u></a>
&nbsp;&nbsp;
<a href='$artUrl' target='_blank'><u>Ԥ������</u></a>
&nbsp;&nbsp;
<a href='content_list.php?channelid=1'><u>�ѷ������¹���</u></a>
&nbsp;&nbsp;
<a href='index.php'><u>��Ա��ҳ</u></a>
";

$wintitle = "�ɹ�����һ�����£�";
$wecome_info = "�ĵ�����::��������";
$win = new OxWindow();
$win->AddTitle("�ɹ�����һ�����£�");
$win->AddMsgItem($msg);
$winform = $win->GetWindow("hand","&nbsp;",false);
$win->Display();
?>