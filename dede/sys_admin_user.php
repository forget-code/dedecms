<?php 
require_once(dirname(__FILE__)."/config.php");
CheckPurview('sys_User');
require_once(dirname(__FILE__)."/../include/pub_datalist.php");
setcookie("ENV_GOBACK_URL",$dedeNowurl,time()+3600,"/");


if(empty($rank)) $rank="";
else $rank = " where #@__admin.usertype='$rank' ";
$dsql = new DedeSql(false);
$dsql->SetQuery("select rank,typename From #@__admintype");
$dsql->Execute();
while($row = $dsql->GetObject()){
	$adminRanks[$row->rank] = $row->typename;
}
function GetUserType($trank)
{
	global $adminRanks;
	if(isset($adminRanks[$trank])) return $adminRanks[$trank];
	else return "��������";
}

function GetChannel($c)
{
	if($c==""||$c==0) return "����Ƶ��";
	else return $c;
}

$query = "Select #@__admin.*,#@__arctype.typename From #@__admin left join #@__arctype on #@__admin.typeid=#@__arctype.ID $rank ";
$dlist = new DataList();
$dlist->SetTemplet(dirname(__FILE__)."/templets/sys_admin_user.htm");
$dlist->SetSource($query);
$dlist->Display();
$dlist->Close();
$dsql->Close();
?>