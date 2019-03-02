<?php 
require_once(dirname(__FILE__)."/config.php");
CheckPurview('sys_MakeHtml');
require_once(dirname(__FILE__)."/../include/inc_freelist_view.php");

if(empty($startid)) $startid = 0;
$ci = " aid >= $startid ";
if(!empty($endid) && $endid>=$startid){
	$ci .= " And aid <= $endid ";
}

$dsql = new DedeSql(false);
$dsql->SetQuery("Select aid From #@__freelist where $ci");
$dsql->Execute();
while($row=$dsql->GetArray()) $idArray[] = $row['aid'];
$dsql->Close();

if(!isset($pageno)) $pageno=0;
$totalpage=count($idArray);
if(isset($idArray[$pageno])) $lid = $idArray[$pageno];
else{
	echo "��������ļ�������";
	exit();
}

$lv = new FreeList($lid);

$ntotalpage = $lv->TotalPage;

if(empty($mkpage)) $mkpage = 1;
if(empty($maxpagesize)) $maxpagesize = 50;

//�����Ŀ���ĵ�̫�࣬�ֶ����θ���
if($ntotalpage<=$maxpagesize){
	$lv->MakeHtml();
	$finishType = true;
}
else{
	$lv->MakeHtml($mkpage,$maxpagesize);
	$finishType = false;
	$mkpage = $mkpage + $maxpagesize;
	if( $mkpage >= ($ntotalpage+1) ) $finishType = true;
}


$lv->Close();

$nextpage = $pageno+1;
if($nextpage==$totalpage){
	echo "��������ļ�������";
}
else{
	if($finishType){
	  $gourl = "makehtml_freelist_action.php?maxpagesize=$maxpagesize&startid=$startid&endid=$endid&pageno=$nextpage";
	  ShowMsg("�ɹ������б�".$tid."���������в�����",$gourl,0,100);
  }
  else
  {
  	$gourl = "makehtml_freelist_action.php?mkpage=$mkpage&maxpagesize=$maxpagesize&startid=$startid&endid=$endid&pageno=$pageno";
	  ShowMsg("�б�".$tid."���������в���...",$gourl,0,100);
  }
}
?>