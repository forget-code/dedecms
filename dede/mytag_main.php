<?
require_once(dirname(__FILE__)."/config.php");
require_once(dirname(__FILE__)."/../include/pub_datalist.php");
require_once(dirname(__FILE__)."/../include/inc_functions.php");
setcookie("ENV_GOBACK_URL",$dedeNowurl,time()+3600,"/");

function TestType($tname)
{
	if($tname=="") return "������Ŀ";
	else return $tname;
}

function TimeSetValue($ts)
{
	if($ts==0) return "����ʱ��";
	else return "��ʱ���";
}

$sql = "Select 
#@__mytag.aid,#@__mytag.tagname,#@__arctype.typename,#@__mytag.timeset,#@__mytag.endtime
From #@__mytag
left join #@__arctype on #@__arctype.ID=#@__mytag.typeid
order by #@__mytag.aid desc
";

$dlist = new DataList();
$dlist->Init();
$dlist->SetSource($sql);
$dlist->SetTemplet(dirname(__FILE__)."/templets/mytag_main.htm");
$dlist->display();
$dlist->Close();
?>