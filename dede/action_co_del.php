<?
require_once(dirname(__FILE__)."/config.php");
if(!isset($nid)) $nid=0;
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
?>