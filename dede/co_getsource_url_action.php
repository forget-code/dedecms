<?
require_once(dirname(__FILE__)."/config.php");
CheckPurview('co_PlayNote');
require_once(dirname(__FILE__)."/../include/pub_collection.php");
if(empty($islisten)) $islisten = 0;
if($nid=="") 
{
	ShowMsg("������Ч!","-1");	
	exit();
}

if(empty($glstart)) $glstart = 0;
if(empty($totalnum)) $totalnum = 0;

$gurl = "co_gather_start_action.php?islisten=$islisten&nid=$nid&startdd=$startdd&pagesize=$pagesize&threadnum=$threadnum&sptime=$sptime";

$gurlList = "co_getsource_url_action.php?islisten=$islisten&nid=$nid&startdd=$startdd&pagesize=$pagesize&threadnum=$threadnum&sptime=$sptime";

if($totalnum>0)
{
	ShowMsg("��ǰ�ڵ���������ҳ��ַ������ֱ��ת����ҳ�ɼ�...",$gurl."&totalnum=$totalnum");
	exit();
}

$co = new DedeCollection();
$co->Init();
$co->LoadFromDB($nid);

$limitList = $co->GetSourceUrl($islisten,$glstart,$pagesize);

if($limitList==0)
{
	$co->dsql->SetSql("Select count(aid) as dd From #@__courl where nid='$nid'");
  $co->dsql->Execute();
  $row = $co->dsql->GetObject();
  $totalnum = $row->dd;
	$co->Close();
	ShowMsg("�ѻ�����д�������ַ��ת����ҳ�ɼ�...",$gurl."&totalnum=$totalnum");
	exit();
}else if($limitList>0)
{
	$co->Close();
	ShowMsg("�ɼ��б�ʣ�ࣺ{$limitList} ��ҳ�棬�����ɼ�...",$gurlList."&glstart=".($glstart+$pagesize),0,100);
	exit();
}else{
	echo "��ȡ�б���ַʧ�ܣ��޷���ɲɼ���";
}

?>