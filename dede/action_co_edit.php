<?
require_once(dirname(__FILE__)."/config.php");
if(!isset($isenum)) $isenum=0;
if($isenum==1) $typeid="0";
$itemconfig = "
{dede:comments}
{!-- �ڵ������Ϣ --}
{/dede:comments}

{dede:item name=\\'$notename\\' typeid=\\'$typeid\\'
  imgurl=\\'$imgurl\\' imgdir=\\'$imgdir\\' language=\\'$language\\'}
{/dede:item}

$otherconfig
";
$inQuery = "
Update #@__conote set typeid='$typeid',gathername='$notename',language='$language',noteinfo='$itemconfig' 
Where nid='$nid';
";
$dsql = new DedeSql(false);
$dsql->SetSql($inQuery);
if($dsql->ExecuteNoneQuery())
{
	$dsql->Close();
	ShowMsg("�ɹ�����һ���ڵ�!","co_main.php");
	exit();
}
else
{
	$dsql->Close();
	ShowMsg("���Ľڵ�ʧ��,����ԭ��!","-1");
	exit();
}
?>