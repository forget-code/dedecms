<?
require_once(dirname(__FILE__)."/config.php");
require_once(dirname(__FILE__)."/../include/inc_typelink.php");
empty($_COOKIE['ENV_GOBACK_URL']) ? $ENV_GOBACK_URL = "content_list.php" : $ENV_GOBACK_URL=$_COOKIE['ENV_GOBACK_URL'];
if(empty($dopost)||empty($aid)){
	ShowMsg("�Բ�����ûָ�����в�����","-1");
	exit();
}
$aid = ereg_replace("[^0-9]","",$aid);
/*--------------------------
//�༭�ĵ� 
function editArchives();
---------------------------*/
if($dopost=="editArchives")
{
	$dsql = new DedeSql(false);
	$row = $dsql->GetOne("Select #@__channeltype.editcon from #@__archives left join #@__channeltype on #@__channeltype.ID=#@__archives.channel where #@__archives.ID='$aid'");
	$gurl = $row["editcon"];
	$dsql->Close();
	if($gurl==""){
		$gurl=="article_edit.php";
	}
	require_once(dirname(__FILE__)."/$gurl");
}
/*--------------------------
//����ĵ�
function viewArchives();
---------------------------*/
else if($dopost=="viewArchives")
{
	$aid = ereg_replace("[^0-9]","",$aid);
	/*
	require_once(dirname(__FILE__)."/inc/inc_archives_functions.php");
	$pageurl = MakeArt($aid,true);
	ShowMsg("���»��壬���Ժ�...",$pageurl);
	*/
	header("Location:{$cfg_plus_dir}/view.php?aid={$aid}");
	exit();
}
/*--------------------------
//�Ƽ��ĵ�
function commendArchives();
---------------------------*/
else if($dopost=="commendArchives")
{
	SetPageRank(5);
	if( $aid!="" && !ereg("(".$aid."`|`".$aid.")",$qstr) ) $qstr .= "`".$aid;
	if($qstr==""){
	  ShowMsg("������Ч��",$ENV_GOBACK_URL);
	  exit();
	}
	$qstrs = explode("`",$qstr);
	$dsql = new DedeSql(false);
	foreach($qstrs as $aid)
	{
	  $aid = ereg_replace("[^0-9]","",$aid);
	  if($aid=="") continue;
	  $dsql->SetQuery("Update #@__archives set iscommend='11' where ID='$aid'");
	  $dsql->ExecuteNoneQuery();
	}
	$dsql->Close();
	ShowMsg("�ɹ�����ѡ���ĵ���Ϊ�Ƽ���",$ENV_GOBACK_URL);
	exit();
}
/*--------------------------
//����HTML
function makeArchives();
---------------------------*/
else if($dopost=="makeArchives")
{
	SetPageRank(5);
	$aid = ereg_replace("[^0-9]","",$aid);
	require_once(dirname(__FILE__)."/inc/inc_archives_functions.php");
	if(empty($qstr))
	{
	  $pageurl = MakeArt($aid,true);
	  ShowMsg("�ɹ�����{$pageurl}...",$ENV_GOBACK_URL);
	  exit();
  }
  else
  {
  	$qstrs = explode("`",$qstr);
  	$i = 0;
  	foreach($qstrs as $aid){
  		$i++;
  		$pageurl = MakeArt($aid,true);
  	}
  	ShowMsg("�ɹ�����ָ�� $i ���ļ�...",$ENV_GOBACK_URL);
  	exit();
  }
}
/*--------------------------
//����ĵ�
function checkArchives();
---------------------------*/
else if($dopost=="checkArchives")
{
	SetPageRank(5);
	require_once(dirname(__FILE__)."/inc/inc_archives_functions.php");
	if( $aid!="" && !ereg("(".$aid."`|`".$aid.")",$qstr) ) $qstr .= "`".$aid;
	if($qstr==""){
	  ShowMsg("������Ч��",$ENV_GOBACK_URL);
	  exit();
	}
	$qstrs = explode("`",$qstr);
	foreach($qstrs as $aid)
	{
	  $aid = ereg_replace("[^0-9]","",$aid);
	  if($aid=="") continue;
	  $dsql = new DedeSql(false);
	  $dsql->SetQuery("Update #@__archives set arcrank='0',adminID='".$cuserLogin->getUserID()."' where ID='$aid' And arcrank<'0'");
	  $dsql->ExecuteNoneQuery();
	  $pageurl = MakeArt($aid,true);
	  $dsql->Close();
	}
	ShowMsg("�ɹ����ָ�����ĵ���",$ENV_GOBACK_URL);
	exit();
}
/*--------------------------
//ɾ���ĵ�
function delArchives();
---------------------------*/
else if($dopost=="delArchives")
{
	require_once(dirname(__FILE__)."/../include/pub_oxwindow.php");
	SetPageRank(5);
	if(empty($fmdo)) $fmdo = "";
	if($fmdo=="yes")
	{
	  if( $aid!="" && !ereg("(".$aid."`|`".$aid.")",$qstr) ) $qstr .= "`".$aid;
	  if($qstr==""){
	  	ShowMsg("������Ч��",$ENV_GOBACK_URL);
	  	exit();
	  }
	  $qstrs = explode("`",$qstr);
	 foreach($qstrs as $aid)
	 {
	  $aid = ereg_replace("[^0-9]","",$aid);
	  if($aid=="") continue;
	  $dsql = new DedeSql(false);
    //��ȡ�ĵ���Ϣ
    $arctitle = "";
    $arcurl = "";
    $arcQuery = "
    Select #@__archives.title,#@__channeltype.addtable  From #@__archives 
    left join #@__channeltype on #@__channeltype.ID=#@__archives.channel where #@__archives.ID='$aid'
    ";
    $arcRow = $dsql->GetOne($arcQuery);
    if(!is_array($arcRow)){ continue; }
    $dsql->SetQuery("Delete From #@__archives where ID='$aid'");
    $dsql->ExecuteNoneQuery();
    if($arcRow['addtable']!=""){
      $dsql->SetQuery("Delete From ".$arcRow['addtable']." where aid='$aid'");
      $dsql->ExecuteNoneQuery();
    }
    $dsql->SetQuery("Delete From #@__feedback where aid='$aid'");
    $dsql->ExecuteNoneQuery();
    if(!ereg("\?",$arcurl)){
    	 $htmlfile = $cfg_basedir.$arcurl;
    	 if(file_exists($htmlfile) && !is_dir($htmlfile)) unlink($htmlfile);
    	 $arcurls = explode(".",$arcurl);
    	 $sname = $arcurls[count($arcurls)-1];
    	 $fname = ereg_replace("\.$sname$","",$arcurl);
    	 for($i=2;$i<=30;$i++){
    		 $htmlfile = $cfg_basedir.$fname."_$i".".".$sname;
    		 if(file_exists($htmlfile) && !is_dir($htmlfile)) unlink($htmlfile);
    	 }
    }
  }//foreach
    $dsql->Close();
    ShowMsg("�ɹ�ɾ��ָ�����ĵ���",$ENV_GOBACK_URL);
	  exit();
  }//ȷ���h���������
  
  //ɾ��ȷ����Ϣ
  //-----------------------
	$wintitle = "�ĵ�����-ɾ���ĵ�";
	$wecome_info = "<a href='".$ENV_GOBACK_URL."'>�ĵ�����</a>::ɾ���ĵ�";
	$win = new OxWindow();
	$win->Init("archives_do.php","js/blank.js","POST");
	$win->AddHidden("fmdo","yes");
	$win->AddHidden("dopost",$dopost);
	$win->AddHidden("qstr",$qstr);
	$win->AddHidden("aid",$aid);
	$win->AddTitle("��ȷʵҪɾ���� $qstr �� $aid ����Щ�ĵ���");
	$winform = $win->GetWindow("ok");
	$win->Display();
}
?>