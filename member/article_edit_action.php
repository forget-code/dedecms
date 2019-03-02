<?php 
require_once(dirname(__FILE__)."/config.php");
CheckRank(0,0);

require_once(dirname(__FILE__)."/../include/inc_photograph.php");
require_once(dirname(__FILE__)."/../include/pub_oxwindow.php");
require_once(dirname(__FILE__)."/inc/inc_archives_functions.php");

$typeid = ereg_replace("[^0-9]","",$typeid);
$channelid = 1;
$ID = ereg_replace("[^0-9]","",$ID);

if($typeid==0){
	ShowMsg("��ָ���ĵ���������Ŀ��","-1");
	exit();
}

if(!CheckChannel($typeid,$channelid)){
	ShowMsg("����ѡ�����Ŀ�뵱ǰģ�Ͳ��������֧��Ͷ�壬��ѡ���ɫ��ѡ�","-1");
	exit();
}

$dsql = new DedeSql(false);

//����û��Ƿ���Ȩ�޲�����ƪ����
//--------------------------------
$cInfos = $dsql->GetOne("Select arcsta From #@__channeltype  where ID='1'; ");

$row = $dsql->GetOne("Select arcrank From #@__archives where memberID='".$cfg_ml->M_ID."' And ID='$ID'");

if(!is_array($row)){
   $dsql->Close();
   ShowMsg("��ûȨ�޸�����ƪ���£�","-1");
   exit();
}else if($row['arcrank']>=0 && $cInfos['arcsta']==-1){
   $dsql->Close();
   ShowMsg("��ƪ�����ѱ���ˣ���ûȨ�޸��ģ�","-1");
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
ismake='$ismake',arcrank='$arcrank',typeid='$typeid',title='$title',source='$source',
$litpic
description='$description',keywords='$keywords',mtype='$mtype',userip='$userip'
where ID='$ID' And memberID='$memberID';
";

$dsql->SetQuery($inQuery);
if(!$dsql->ExecuteNoneQuery()){
	$dsql->Close();
	ShowMsg("�����ݱ��浽���ݿ�archives��ʱ�������飡","-1");
	exit();
}

$body = eregi_replace("<(iframe|script)","",$body);
//���¸��ӱ�
//----------------------------------

$dsql->SetQuery("Update #@__addonarticle set typeid='$typeid',body='$body' where aid='$ID'; ");
if(!$dsql->ExecuteNoneQuery()){
   $dsql->Close();
   ShowMsg("�����ݱ��浽���ݿ⸽ʱ��������ϵ����Ա��","-1");
   exit();
}
$dsql->Close();

$artUrl = MakeArt($ID);

//���سɹ���Ϣ
//----------------------------------

$msg = "
��ѡ����ĺ���������
<a href='article_add.php?cid=$typeid'><u>����������</u></a>
&nbsp;&nbsp;
<a href='article_edit.php?aid=".$ID."'><u>��������</u></a>
&nbsp;&nbsp;
<a href='$artUrl' target='_blank'><u>Ԥ������</u></a>
&nbsp;&nbsp;
<a href='content_list.php?channelid=1'><u>�ѷ������¹���</u></a>
&nbsp;&nbsp;
<a href='index.php'><u>��Ա��ҳ</u></a>
";

$wintitle = "�ɹ��޸�һ�����£�";
$wecome_info = "�ĵ�����::�޸�����";
$win = new OxWindow();
$win->AddTitle("�ɹ��޸�һ�����£�");
$win->AddMsgItem($msg);
$winform = $win->GetWindow("hand","&nbsp;",false);
$win->Display();

?>