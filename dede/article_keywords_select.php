<?
require_once(dirname(__FILE__)."/config.php");
require_once(dirname(__FILE__)."/../include/pub_datalist.php");
setcookie("ENV_GOBACK_URL",$dedeNowurl,time()+3600,"/");

function GetSta($sta)
{
	if($sta==1) return "����";
	else return "<font color='red'>����</font>";
}

function GetMan($sta)
{
	if($sta==1) return "<u>����</u>";
	else return "<u>����</u>";
}


$sql = "Select * from #@__keywords order by rank desc";
$dlist = new DataList();
$dlist->Init();
$dlist->SetSource($sql);
$dlist->SetTemplet(dirname(__FILE__)."/templets/article_keywords_select.htm");
$dlist->display();
$dlist->Close();
?>