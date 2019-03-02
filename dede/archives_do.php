<?php 
require_once(dirname(__FILE__)."/config.php");
require_once(dirname(__FILE__)."/../include/inc_typelink.php");
require_once(dirname(__FILE__)."/inc/inc_batchup.php");
require_once(dirname(__FILE__)."/inc/inc_archives_functions.php");
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
	if($gurl==""){ $gurl=="article_edit.php"; }
	require_once(dirname(__FILE__)."/$gurl");
}
/*--------------------------
//����ĵ�
function viewArchives();
---------------------------*/
else if($dopost=="viewArchives")
{
	$aid = ereg_replace("[^0-9]","",$aid);
	$dsql = new DedeSql(false);
	$arcQuery = "
    Select #@__archives.ID,#@__archives.title,#@__archives.typeid,
    #@__archives.ismake,#@__archives.senddate,#@__archives.arcrank,#@__channeltype.addtable,
 		#@__archives.money,#@__arctype.typedir,#@__arctype.typename,
 		#@__arctype.namerule,#@__arctype.namerule2,#@__arctype.ispart,
 		#@__arctype.moresite,#@__arctype.siteurl,#@__arctype.siterefer,#@__arctype.sitepath 
		from #@__archives
		left join #@__arctype on #@__archives.typeid=#@__arctype.ID
		left join #@__channeltype on #@__channeltype.ID=#@__archives.channel
		where #@__archives.ID='$aid'
    ";
  $arcRow = $dsql->GetOne($arcQuery);
  $dsql->Close();
	if($arcRow['ismake']==-1||$arcRow['arcrank']!=0
    ||$arcRow['typeid']==0||$arcRow['money']>0){
    	echo "<script language='javascript'>location.href='{$cfg_plus_dir}/view.php?aid={$aid}';</script>";
    	exit();
  }
  $arcurl = GetFileUrl($arcRow['ID'],$arcRow['typeid'],$arcRow['senddate'],$arcRow['title'],$arcRow['ismake'],
           $arcRow['arcrank'],$arcRow['namerule'],$arcRow['typedir'],$arcRow['money'],true,$arcRow['siteurl']);
  $arcfile = GetFileUrl($arcRow['ID'],$arcRow['typeid'],$arcRow['senddate'],$arcRow['title'],$arcRow['ismake'],
           $arcRow['arcrank'],$arcRow['namerule'],$arcRow['typedir'],$arcRow['money'],false,'');
	$truefile = GetTruePath($arcRow['siterefer'],$arcRow['sitepath']).$arcfile;
  if(!file_exists($truefile)) {
  	MakeArt($aid,true);
  }
  echo "<script language='javascript'>location.href='$arcurl"."?".mytime()."';</script>";
	exit();
}
/*--------------------------
//�Ƽ��ĵ�
function commendArchives();
---------------------------*/
else if($dopost=="commendArchives")
{
	CheckPurview('a_Commend,sys_ArcBatch');
	if( $aid!="" && !ereg("(".$aid."`|`".$aid.")",$qstr) ) $qstr .= "`".$aid;
	if($qstr==""){
	  ShowMsg("������Ч��",$ENV_GOBACK_URL);
	  exit();
	}
	$qstrs = explode("`",$qstr);
	$dsql = new DedeSql(false);
	foreach($qstrs as $aid){
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
	CheckPurview('sys_MakeHtml,sys_ArcBatch');
	$aid = ereg_replace("[^0-9]","",$aid);
	require_once(dirname(__FILE__)."/inc/inc_archives_functions.php");
	if(empty($qstr)){
	  $pageurl = MakeArt($aid,true);
	  ShowMsg("�ɹ�����{$pageurl}...",$ENV_GOBACK_URL);
	  exit();
  }
  else{
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
	CheckPurview('a_Check,a_AccCheck,sys_ArcBatch');
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
	CheckPurview('a_Del,a_AccDel,a_MyDel,sys_ArcBatch');
	require_once(dirname(__FILE__)."/../include/pub_oxwindow.php");
	if(empty($fmdo)) $fmdo = "";
	if($fmdo=="yes")
	{
	  if( $aid!="" && !ereg("(".$aid."`|`".$aid.")",$qstr) ) $qstr .= "`".$aid;
	  if($qstr==""){
	  	ShowMsg("������Ч��",$ENV_GOBACK_URL);
	  	exit();
	  }
	  $qstrs = explode("`",$qstr);
	  $okaids = Array();
	  $dsql = new DedeSql(false);
	  foreach($qstrs as $aid){
	    if(!isset($okaids[$aid])) DelArc($aid);
	    else $okaids[$aid] = 1;
    }
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
/*-----------------------------
function moveArchives()
------------------------------*/
else if($dopost=='moveArchives'){
	CheckPurview('sys_ArcBatch');
	require_once(dirname(__FILE__)."/../include/pub_oxwindow.php");
	require_once(dirname(__FILE__)."/../include/inc_typelink.php");
	if(empty($targetTypeid)){
		$tl = new TypeLink($cid);
		$typeOptions = $tl->GetOptionArray(0,$cuserLogin->getUserChannel(),0);
		$tl->Close();
		$typeOptions = "
		<select name='targetTypeid' style='width:350'>
		<option value='0'>��ѡ���ƶ�����λ��...</option>\r\n
     $typeOptions
    </select>
    ";
		$wintitle = "�ĵ�����-�ƶ��ĵ�";
	  $wecome_info = "<a href='".$ENV_GOBACK_URL."'>�ĵ�����</a>::�ƶ��ĵ�";
	  $win = new OxWindow();
	  $win->Init("archives_do.php","js/blank.js","POST");
	  $win->AddHidden("fmdo","yes");
	  $win->AddHidden("dopost",$dopost);
	  $win->AddHidden("qstr",$qstr);
	  $win->AddHidden("aid",$aid);
	  $win->AddTitle("��Ŀǰ�Ĳ������ƶ��ĵ�����ѡ��Ŀ����Ŀ��");
	  $win->AddMsgItem($typeOptions,"30","1");
	  $win->AddMsgItem("��ѡ�е��ĵ�ID�ǣ� $qstr <br>�ƶ�����Ŀ�����ѡ�����ĵ�Ƶ������һ�£����������Զ����Բ����ϵ��ĵ���","30","1");
	  $winform = $win->GetWindow("ok");
	  $win->Display();
	}else{
		$targetTypeid = ereg_replace('[^0-9]','',$targetTypeid);
		$dsql = new DedeSql(false);
		$typeInfos = $dsql->GetOne("Select * From #@__arctype where ID='$targetTypeid' ");
		if(!is_array($typeInfos)){
			ShowMsg("��������","-1");
			$dsql->Close();
			exit();
		}
		if($typeInfos['ispart']!=0){
			ShowMsg("�ĵ��������Ŀ����Ϊ�����б���Ŀ��","-1");
			$dsql->Close();
			exit();
		}
		$arcids = explode('`',$qstr);
		$arc = "";
		$j = 0;
		$okids = Array();
		foreach($arcids as $arcid){
			$arcid = ereg_replace('[^0-9]','',$arcid);
			$arcrow = $dsql->GetOne("Select channel,typeid From #@__archives where ID='$arcid' ");
			if($arcrow['channel']==$typeInfos['channeltype'] && $arcrow['typeid']!=$targetTypeid){
				$dsql->ExecuteNoneQuery("Update #@__archives Set typeid='$targetTypeid' where ID='$arcid' ");
        $okids[] = $arcid;
        $j++;
		  }
		}
		//����HTML
		foreach($okids as $aid){
			$arc = new Archives($aid);
      $arc->MakeHtml();
		}
		$dsql->Close();
		if(is_object($arc)) $arc->Close();
		ShowMsg("�ɹ��ƶ� $j ���ĵ���",$ENV_GOBACK_URL);
		//"content_list.php?cid=$targetTypeid"
		exit();
	}
}
?>