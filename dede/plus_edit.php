<?
require_once(dirname(__FILE__)."/config.php");
SetPageRank(10);
$aid = ereg_replace("[^0-9]","",$aid);
if($dopost=="show")
{
	$dsql = new DedeSql(false);
	$dsql->SetQuery("update #@__plus set isshow=1 where aid='$aid';");
	$dsql->ExecuteNoneQuery();
	$dsql->Close();
	ShowMsg("�ɹ�����һ�����,��ˢ�µ����˵�!","plus_main.php");
	exit();
}
else if($dopost=="hide")
{
	$dsql = new DedeSql(false);
	$dsql->SetQuery("update #@__plus set isshow=0 where aid='$aid';");
	$dsql->ExecuteNoneQuery();
	$dsql->Close();
	ShowMsg("�ɹ�����һ�����,��ˢ�µ����˵�!","plus_main.php");
	exit();
}
else if($dopost=="delete")
{
	if(empty($job)) $job="";
  if($job=="") //ȷ����ʾ
  {
  	require_once(dirname(__FILE__)."/../include/pub_oxwindow.php");
  	$wintitle = "ɾ�����";
	  $wecome_info = "<a href='plus_main.php'>�������</a>::ɾ�����";
	  $win = new OxWindow();
	  $win->Init("plus_edit.php","js/blank.js","POST");
	  $win->AddHidden("job","yes");
	  $win->AddHidden("dopost",$dopost);
	  $win->AddHidden("aid",$aid);
	  $win->AddTitle("��ȷʵҪɾ��'".$title."'��������");
	  $winform = $win->GetWindow("ok");
	  $win->Display();
	  exit();
  }
  else if($job=="yes") //����
  {
  	$dsql = new DedeSql(false);
	  $dsql->SetQuery("Delete From #@__plus where aid='$aid';");
	  $dsql->ExecuteNoneQuery();
	  $dsql->Close();
	  ShowMsg("�ɹ�ɾ��һ�����,��ˢ�µ����˵�!","plus_main.php");
	  exit();
  }
}
?>