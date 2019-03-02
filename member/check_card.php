<?php 
require_once(dirname(__FILE__)."/config.php");
CheckRank(0,0);
$svali = GetCkVdValue();

if(strtolower($vdcode)!=$svali || $svali==""){
  ShowMsg("��֤�����","-1");
  exit();
}

$cardid = ereg_replace("[^0-9A-Za-z-]","",$cardid);
if(empty($cardid)){
	ShowMsg("����Ϊ�գ�","-1");
  exit();
}

$dsql = new DedeSql(false);

$row = $dsql->GetOne("Select * From #@__moneycard_record where cardid='$cardid' ");

if(!is_array($row)){
	ShowMsg("���Ŵ��󣺲����ڴ˿��ţ�","-1");
	$dsql->Close();
  exit();
}

if($row['isexp']==-1){
	ShowMsg("�˿����Ѿ�ʧЧ�������ٴ�ʹ�ã�","-1");
	$dsql->Close();
  exit();
}

$hasMoney = $row['num'];

$dsql->ExecuteNoneQuery("update #@__moneycard_record set uid='".$cfg_ml->M_ID."',isexp='-1',utime='".time()."' where cardid='$cardid' ");

$dsql->ExecuteNoneQuery("update #@__member set money=money+$hasMoney where ID='".$cfg_ml->M_ID."'");

ShowMsg("��ֵ�ɹ����㱾�����ӵĽ��Ϊ��{$hasMoney} ����","control.php");
$dsql->Close();
exit();

?>