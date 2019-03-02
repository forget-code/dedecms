<?
require_once(dirname(__FILE__)."/config.php");
if(empty($dopost)){
	ShowMsg("�Բ�����ָ����Ŀ������","catalog_main.php");
	exit();
}
if(empty($cid)) $cid = 0;
$cid = ereg_replace("[^0-9]","",$cid);
/*--------------------------
//�����ĵ�
function addArchives();
---------------------------*/
if($dopost=="addArchives")
{
	if(empty($cid) && empty($channelid)){
		require_once(dirname(__FILE__)."/article_add.php");
		exit();
	}
	$dsql = new DedeSql(false);
	if(!empty($channelid)) $row = $dsql->GetOne("Select addcon from #@__channeltype where ID='$channelid'");
	else $row = $dsql->GetOne("Select #@__channeltype.addcon from #@__arctype left join #@__channeltype on #@__channeltype.ID=#@__arctype.channeltype where #@__arctype.ID='$cid'");
	$gurl = $row["addcon"];
	$dsql->Close();
	if($gurl==""){
		ShowMsg("�Բ�����ָ����Ŀ��������","catalog_main.php");
	  exit();
	}
	require_once(dirname(__FILE__)."/$gurl");
	exit();
}
/*--------------------------
//�����ĵ�
function listArchives();
---------------------------*/
else if($dopost=="listArchives")
{
	if(!isset($channelid)) $channelid = 0;
	if(!empty($gurl)){
		$gurl = str_replace("..","",$gurl);
		require_once(dirname(__FILE__)."/$gurl");
	  exit();
	}
	if($cid>0)
	{
	  $dsql = new DedeSql(false);
	  $row = $dsql->GetOne("Select #@__arctype.typename,#@__channeltype.typename as channelname,#@__channeltype.ID,#@__channeltype.mancon from #@__arctype left join #@__channeltype on #@__channeltype.ID=#@__arctype.channeltype where #@__arctype.ID='$cid'");
	  $gurl = $row["mancon"];
	  $channelid = $row["ID"];
	  $typename = $row["typename"];
	  $channelname = $row["channelname"];
	  $dsql->Close();
	  if($gurl==""){
		  ShowMsg("�Բ�����ָ����Ŀ��������","catalog_main.php");
	    exit();
	  }
  }
  else if($channelid>0)
  {
  	$dsql = new DedeSql(false);
	  $row = $dsql->GetOne("Select typename,ID,mancon from #@__channeltype where ID='$channelid'");
	  $gurl = $row["mancon"];
	  $channelid = $row["ID"];
	  $typename = "";
	  $channelname = $row["typename"];
	  $dsql->Close();
  }
	require_once(dirname(__FILE__)."/$gurl");
	exit();
}
/*--------------------------
//���ͨ��ģ��Ŀ¼
function viewTempletDir();
---------------------------*/
else if($dopost=="viewTemplet")
{
	header("location:file_manage_main.php?activepath=".$cfg_templets_dir);
	exit();
}
/*--------------------------
//���Բ�����
function GoGuestBook();
---------------------------*/
else if($dopost=="guestbook")
{
	echo "<script language='javascript'>location='".$cfg_plus_dir."/guestbook/index.php?gotopagerank=admin';</script>";
	exit();
}
/*------------------------
�������ҳ�����Ŀ
function ViewSgPage()
------------------------*/
else if($dopost=="viewSgPage")
{
	require_once(dirname(__FILE__)."/../include/inc_arclist_view.php");
	$lv = new ListView($cid);
  $pageurl = $lv->MakeHtml();
  $lv->Close();
  ShowMsg("���»��壬���Ժ�...",$pageurl);
	exit();
}
/*------------------------
������Ŀ����˳��
function upRank()
------------------------*/
else if($dopost=="upRank")
{
	//���Ȩ�����
  CheckPurview('t_Edit,t_AccEdit');
  //�����Ŀ�������
  CheckCatalog($cid,"����Ȩ���ı���Ŀ��");
	$dsql = new DedeSql(false);
	$row = $dsql->GetOne("Select reID,sortrank From #@__arctype where ID='$cid'");
	$reID = $row['reID'];
	$sortrank = $row['sortrank'];
	$row = $dsql->GetOne("Select sortrank From #@__arctype where sortrank<=$sortrank And reID=$reID order by sortrank desc ");
	if(is_array($row)){
		$sortrank = $row['sortrank']-1;
		$dsql->SetQuery("update #@__arctype set sortrank='$sortrank' where ID='$cid'");
		$dsql->ExecuteNoneQuery();
	}
	$dsql->Close();
	ShowMsg("�����ɹ�������Ŀ¼...","catalog_main.php");
	exit();
}
else if($dopost=="upRankAll")
{
	//���Ȩ�����
  CheckPurview('t_Edit');
	$dsql = new DedeSql(false);
	$row = $dsql->GetOne("Select ID From #@__arctype order by ID desc");
	if(is_array($row))
	{
		$maxID = $row['ID'];
		for($i=1;$i<=$maxID;$i++){
			if(isset(${'sortrank'.$i})){
				$dsql->ExecuteNoneQuery("Update #@__arctype set sortrank='".(${'sortrank'.$i})."' where ID='{$i}';");
			}
		}
	}
	$dsql->Close();
	ShowMsg("�����ɹ������ڷ���...","catalog_main.php");
	exit();
}
/*---------------------
��ȡJS�ļ�
function GetJs
----------------------*/
else if($dopost=="GetJs")
{
	require_once(dirname(__FILE__)."/makehtml_js.php");
	exit();
}
/*-----------
�༭����ҳ��
function editSgPage();
-----------*/
else if($dopost=="editSgPage")
{
	//���Ȩ�����
  CheckPurview('plus_�ļ�������');
	$dsql = new DedeSql(false);
	$row = $dsql->GetOne("Select defaultname,typedir From #@__arctype where ID='$cid'");
	$dsql->Close();
	require_once(dirname(__FILE__)."/../include/inc_arclist_view.php");
	$lv = new ListView($cid);
	$lv->MakeHtml();
	$lv->Close();
 	$row['typedir'] = eregi_replace("\{cmspath\}",$cfg_cmspath,$row['typedir']);
 	$editurl = "file_manage_view.php?backurl=catalog_main.php&fmdo=editview&ishead=yes&filename=".$row['defaultname']."&activepath=".urlencode($row['typedir'])."&job=edit";
 	header("location:$editurl");
 	exit();
}
/*-----------
�༭ģ��ҳ��
function editSgTemplet();
-----------*/
else if($dopost=="editSgTemplet")
{
  //���Ȩ�����
  CheckPurview('plus_�ļ�������');
	$dsql = new DedeSql(false);
	$row = $dsql->GetOne("Select tempone From #@__arctype where ID='$cid'");
	$dsql->Close();
	$tempone = $row['tempone'];
	$tempone = eregi_replace("\{style\}",$cfg_df_style,$tempone);
	if(!is_file($cfg_basedir.$cfg_templets_dir."/".$tempone)){
		ShowMsg("�������ҳ��û��ʹ��ģ�壬����ת��ֱ�ӱ༭���ҳ�档","catalog_do.php?cid=$cid&dopost=editSgPage");
		exit();
	}
	$tempones = explode('/',$tempone);
	$filename = $tempones[count($tempones)-1];
	$tmpdir = $cfg_templets_dir;
	if(count($tempones)>1){
	  foreach($tempones as $v){
		  if($v!="") $tmpdir .= "/".$v;
	  }
  }
	$editurl = "file_manage_view.php?backurl=catalog_main.php&fmdo=editview&ishead=yes&filename=".$filename."&activepath=".urlencode($tmpdir)."&job=edit";
 	header("location:$editurl");
 	exit();
}
/*-----------
������������
function GetSunLists();
-----------*/
else if($dopost=="GetSunLists")
{
	require_once(dirname(__FILE__)."/../include/inc_typeunit_admin.php");
	header("Content-Type: text/html; charset=gb2312");
	PutCookie('lastCid',$cid,3600*24,"/");
	$tu = new TypeUnit();
	$tu->dsql = new DedeSql(false);
  echo "    <table width='100%' border='0' cellspacing='0' cellpadding='0'>\r\n";	
	$tu->LogicListAllSunType($cid,"��");
	echo "    </table>\r\n";
  $tu->Close();
}
?>
