<?php 
require_once(dirname(__FILE__)."/config.php");
CheckRank(0,0);

$svali = GetCkVdValue();
if(strtolower($vdcode)!=$svali || $svali==""){
  ShowMsg("��֤�����","-1");
  exit();
}
if($cfg_mb_sendall=='��'){
	ShowMsg("�Բ���ϵͳ�������Զ���ģ��Ͷ�壬����޷�ʹ�ô˹��ܣ�","-1");
	exit();
}

require_once(dirname(__FILE__)."/inc/inc_archives_all.php");
require_once(dirname(__FILE__)."/inc/inc_archives_functions.php");
require_once(dirname(__FILE__)."/../include/pub_dedetag.php");
require_once(dirname(__FILE__)."/../include/inc_photograph.php");
require_once(dirname(__FILE__)."/../include/pub_oxwindow.php");

if(!isset($iscommend)) $iscommend = 0;
if(!isset($isjump)) $isjump = 0;
if(!isset($isbold)) $isbold = 0;
if(!isset($isrm)) $isrm = 0;
if(!isset($ddisfirst)) $ddisfirst = 0;
if(!isset($ddisremote)) $ddisremote = 0;
$typeid = ereg_replace("[^0-9]","",$typeid);
$channelid = ereg_replace("[^0-9]","",$channelid);

if($typeid==0){
	ShowMsg("��ָ���ĵ���������Ŀ��","-1");
	exit();
}

if(!CheckChannel($typeid,$channelid)){
	ShowMsg("����ѡ�����Ŀ�뵱ǰģ�Ͳ��������֧��Ͷ�壬��ѡ���ɫ��ѡ�","-1");
	exit();
}

$dsql = new DedeSql(false);

$cInfos = $dsql->GetOne("Select * From #@__channeltype  where ID='$channelid'; ");	
if($cInfos['issystem']!=0 || $cInfos['issend']!=1){
	$dsql->Close();
	ShowMsg("��ָ����Ƶ�������Ĵ���","-1");
	exit();
}

if($cInfos['sendrank'] > $cfg_ml->M_Type){
	$row = $dsql->GetOne("Select membername From #@__arcrank where rank='".$cInfos['sendrank']."' ");
	$dsql->Close();
	ShowMsg("�Բ�����Ҫ[".$row['membername']."]���������Ƶ�������ĵ���","-1","0",5000);
	exit();
}

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

//�Ա�������ݽ��д���
//--------------------------------
$typeid2 = 0;
$pubdate = mytime();
$senddate = $pubdate;
$sortrank = $pubdate;
$shorttitle = '';
$color =  '';
$money = 0;
$arcatt = 0;
$pagestyle = 2;

$title = ClearHtml($title);
$writer =  cn_substr(trim(ClearHtml($writer)),30);
$source = '';
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

//������������
//----------------------------------
$inQuery = "INSERT INTO #@__archives(
typeid,typeid2,sortrank,iscommend,ismake,channel,
arcrank,click,money,title,shorttitle,color,writer,source,litpic,
pubdate,senddate,arcatt,adminID,memberID,description,keywords,mtype,userip) 
VALUES ('$typeid','$typeid2','$sortrank','$iscommend','$ismake','$channelid',
'$arcrank','0','$money','$title','$shorttitle','$color','$writer','$source','$litpic',
'$pubdate','$senddate','$arcatt','$adminID','$memberID','$description','$keywords','0','$userip');";
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
$dtp = new DedeTagParse();
$dtp->SetNameSpace("field","<",">");
$dtp->LoadSource($cInfos['fieldset']);
$dede_addonfields = "";
if(is_array($dtp->CTags)){
    foreach($dtp->CTags as $tid=>$ctag){
        if($dede_addonfields=="") $dede_addonfields = $ctag->GetName().",".$ctag->GetAtt('type');
        else $dede_addonfields .= ";".$ctag->GetName().",".$ctag->GetAtt('type');
    }
}
$dede_addtablename = $cInfos['addtable'];
//------------------------------------------------
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
    ${$vs[0]} = eregi_replace("<(iframe|script)","",${$vs[0]});
    //�Զ�ժҪ
    if($description==""){
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

$dsql->ExecuteNoneQuery("Update #@__member set c3=c3+1 where ID='".$cfg_ml->M_ID."';");
$dsql->Close();

$artUrl = MakeArt($arcID);

//---------------------------------
//���سɹ���Ϣ
//----------------------------------

$msg = "
��ѡ����ĺ���������
<a href='archives_add.php?channelid=$channelid&cid=$typeid'><u>����������Ϣ</u></a>
&nbsp;&nbsp;
<a href='archives_edit.php?aid=".$arcID."'><u>������Ϣ</u></a>
&nbsp;&nbsp;
<a href='$artUrl' target='_blank'><u>Ԥ����Ϣ</u></a>
&nbsp;&nbsp;
<a href='content_list.php?channelid=$channelid'><u>�ѷ�����Ϣ����</u></a>
&nbsp;&nbsp;
<a href='index.php'><u>��Ա��ҳ</u></a>
";

$wintitle = "�ɹ�����һ����Ϣ��";
$wecome_info = "�ĵ�����::�����ĵ�";
$win = new OxWindow();
$win->AddTitle("�ɹ�����һ����Ϣ��");
$win->AddMsgItem($msg);
$winform = $win->GetWindow("hand","&nbsp;",false);
$win->Display();
?>