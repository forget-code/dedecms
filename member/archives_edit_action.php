<?php 
require_once(dirname(__FILE__)."/config.php");
CheckRank(0,0);

if($cfg_mb_sendall=='��'){
	ShowMsg("�Բ���ϵͳ�������Զ���ģ��Ͷ�壬����޷�ʹ�ô˹��ܣ�","-1");
	exit();
}

require_once(dirname(__FILE__)."/../include/pub_dedetag.php");
require_once(dirname(__FILE__)."/inc/inc_archives_all.php");
require_once(dirname(__FILE__)."/../include/inc_photograph.php");
require_once(dirname(__FILE__)."/../include/pub_oxwindow.php");
require_once(dirname(__FILE__)."/inc/inc_archives_functions.php");
$ID = ereg_replace("[^0-9]","",$ID);
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
//����û��Ƿ���Ȩ�޲�����ƪ�ĵ�
//-------------------------------
$row = $dsql->GetOne("Select arcrank From #@__archives where memberID='".$cfg_ml->M_ID."' And ID='$ID'");
if(!is_array($row)){
   $dsql->Close();
   ShowMsg("��ûȨ�޸���������Ϣ��","-1");
   exit();
}

$cInfos = $dsql->GetOne("Select * From #@__channeltype where ID='$channelid'; ");	
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
if(!empty($litpic)){
	$litpic = GetUpImage('litpic',true,true);
	$litpic = " litpic='$litpic', ";
}else{
	$litpic = "";
}

$memberID = $cfg_ml->M_ID;

//�������ݿ��SQL���
//----------------------------------

$inQuery = "
update #@__archives set
ismake='$ismake',arcrank='$arcrank',typeid='$typeid',title='$title',
$litpic
description='$description',keywords='$keywords',userip='$userip'
where ID='$ID' And memberID='$memberID';
";
$dsql->SetQuery($inQuery);
if(!$dsql->ExecuteNoneQuery()){
	$dsql->Close();
	ShowMsg("�����ݱ��浽���ݿ�archives��ʱ�������飡","-1");
	exit();
}

//----------------------------------
//���¸��ӱ�����
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

$artUrl = MakeArt($ID);

//---------------------------------
//���سɹ���Ϣ
//----------------------------------

$msg = "
��ѡ����ĺ���������
<a href='archives_add.php?channelid=$channelid&cid=$typeid'><u>��������Ϣ</u></a>
&nbsp;&nbsp;
<a href='archives_edit.php?aid=".$ID."'><u>����������Ϣ</u></a>
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