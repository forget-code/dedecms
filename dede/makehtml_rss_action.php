<?
require_once(dirname(__FILE__)."/config.php");
CheckPurview('sys_MakeHtml');
require_once(dirname(__FILE__)."/../include/inc_rss_view.php");
if(empty($tid)) $tid = 0;
if(empty($maxrecord)) $maxrecord = 50;
$dsql = new DedeSql(false);
$row = $dsql->GetOne("Select ID From #@__arctype where ID>'$tid' And ispart<>2 order by ID asc limit 0,1;");
$dsql->Close();
if(!is_array($row)){
	echo "��������ļ����£�";
	exit();
}
else{
	$rv = new RssView($row['ID'],$maxrecord);
	$rssurl = $rv->MakeRss();
	$rv->Close();
	$tid = $row['ID'];
	ShowMsg("�ɹ�����".$rssurl."���������в�����","makehtml_rss_action.php?tid=$tid&maxrecord=$maxrecord",0,100);
  exit();
}
?>