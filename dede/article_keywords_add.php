<?
require_once(dirname(__FILE__)."/config.php");
empty($_COOKIE['ENV_GOBACK_URL']) ? $ENV_GOBACK_URL = "-1" : $ENV_GOBACK_URL=$_COOKIE['ENV_GOBACK_URL'];
CheckPurview('sys_Keyword');
$keyword = trim($keyword);
$rank = ereg_replace("[^0-9]","",$rank);
if(ereg(" ",$keyword)||$keyword=="")
{
	ShowMsg("�ؼ��ֲ��ܴ��пո��Ϊ�գ�",-1);
	exit();
}
$dsql = new DedeSql(false);
$row = $dsql->GetOne("Select * From #@__keywords where keyword like '$keyword'");
if(is_array($row))
{
	$dsql->Close();
	ShowMsg("�ؼ����Ѵ��ڿ��У�","-1");
	exit();
}
$inquery = "
INSERT INTO #@__keywords(keyword,rank,sta,rpurl) VALUES ('$keyword','$rank','1','$rpurl');
";
$dsql->SetQuery($inquery);
$dsql->ExecuteNoneQuery();
$dsql->Close();
ShowMsg("�ɹ�����һ���ؼ��֣�",$ENV_GOBACK_URL);
?>