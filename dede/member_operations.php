<?php 
require_once(dirname(__FILE__)."/config.php");
CheckPurview('member_Operations');
require_once(dirname(__FILE__)."/../include/pub_datalist_dm.php");
setcookie("ENV_GOBACK_URL",$dedeNowurl,time()+3600,"/");

function GetMemberID($dsql,$mid){
	if($mid==0) return '0';
	$row = $dsql->GetOne("Select userid From #@__member where ID='$mid' ");
	if(is_array($row)) return "<a href='member_view.php?ID={$mid}'>".$row['userid']."</a>";
	else return '0';
}

function GetPType($tname){
	if($tname=='card') return '������';
	else return '��Ա����';
}

function GetSta($sta){
	if($sta==0) return 'δ����';
	else if($sta==1) return '�Ѹ���';
	else return '�����';
}

if(empty($buyid)) $buyid = '';

$addsql = " where buyid like '%$buyid%' ";

if(isset($sta)){
	$addsql .= " And sta='$sta' ";
}




$sql = "Select * From #@__member_operation $addsql order by aid desc";
$dlist = new DataList();
$dlist->Init();

$dlist->SetParameter("buyid",$buyid);
if(isset($sta)){
	$dlist->SetParameter("sta",$sta);
}

$dlist->dsql->SetQuery("Select * From #@__moneycard_type ");
$dlist->dsql->Execute('ts');
while($rw = $dlist->dsql->GetArray('ts')){
	$TypeNames[$rw['tid']] = $rw['pname'];
}

$dlist->SetSource($sql);
include(dirname(__FILE__)."/templets/member_operations.htm");
$dlist->Close();


?>


