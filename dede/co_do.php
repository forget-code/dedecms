<?php 
require_once(dirname(__FILE__)."/config.php");
if(!isset($nid)) $nid=0;
if(empty($_COOKIE["ENV_GOBACK_URL"])) $ENV_GOBACK_URL = "co_url.php";
else $ENV_GOBACK_URL = $_COOKIE["ENV_GOBACK_URL"];
//ɾ���ڵ�
/*
function co_delete()
*/
if($dopost=="delete")
{
   CheckPurview('co_Del');
   $dsql = new DedeSql(false);
   $inQuery = "Delete From #@__courl where nid='$nid'";
   $dsql->SetSql($inQuery);
   $dsql->ExecuteNoneQuery();
   $inQuery = "Delete From #@__conote where nid='$nid'";
   $dsql->SetSql($inQuery);
   $dsql->ExecuteNoneQuery();
   $dsql->Close();
   ShowMsg("�ɹ�ɾ��һ���ڵ�!","co_main.php");
   exit();
}
//��ղɼ�����
/*
function url_clear()
*/
else if($dopost=="clear")
{
	CheckPurview('co_Del');
	if(!isset($ids)) $ids="";
  if(empty($ids))
  {
	  $dsql = new DedeSql(false);
	  $inQuery = "Delete From #@__courl where nid='$nid'";
	  $dsql->ExecuteNoneQuery($inQuery);
	  $inQuery = "Delete From #@__co_listenurl where nid='$nid'";
	  $dsql->ExecuteNoneQuery($inQuery);
	  $dsql->Close();
	  ShowMsg("�ɹ����һ���ڵ�ɼ�������!","co_main.php");
	  exit();
  }
  else
  {
	  $dsql = new DedeSql(false);
	  $inQuery = "Delete From #@__courl where ";
	  $idsSql = "";
	  $ids = explode("`",$ids);
	  foreach($ids as $id) $idsSql .= "or aid='$id' ";
	  $idsSql = ereg_replace("^or ","",$idsSql);
	  $dsql->SetSql($inQuery.$idsSql);
	  $dsql->ExecuteNoneQuery();
	  $dsql->Close();
	  ShowMsg("�ɹ�ɾ��ָ������ַ����!",$ENV_GOBACK_URL);
	  exit();
  }
}
//���ƽڵ�
/*
function co_copy()
*/
else if($dopost=="copy")
{
	CheckPurview('co_AddNote');
	if(empty($notename))
	{
		require_once(dirname(__FILE__)."/../include/pub_oxwindow.php");
  	$wintitle = "�ɼ�����-���ƽڵ�";
	  $wecome_info = "<a href='co_main.php'>�ɼ�����</a>::���ƽڵ�";
	  $win = new OxWindow();
	  $win->Init("co_do.php","js/blank.js","POST");
	  $win->AddHidden("dopost",$dopost);
	  $win->AddHidden("nid",$nid);
	  $win->AddTitle("�������½ڵ����ƣ�");
	  $win->AddItem("�½ڵ����ƣ�","<input type='text' name='notename' value='' size='30'>");
	  $winform = $win->GetWindow("ok");
	  $win->Display();
		exit();
	}
	$dsql = new DedeSql(false);
	$row = $dsql->GetOne("Select * From #@__conote where nid='$nid'");
	$inQuery = "
   INSERT INTO #@__conote(typeid,gathername,language,lasttime,savetime,noteinfo) 
   VALUES('".$row['typeid']."', '$notename', '".addslashes($row['language'])."',
    '0','".mytime()."', '".addslashes($row['noteinfo'])."');
  ";
  $dsql->SetQuery($inQuery);
  $dsql->ExecuteNoneQuery();
  $dsql->Close();
  ShowMsg("�ɹ�����һ���ڵ�!",$ENV_GOBACK_URL);
	exit();
}
?>