<?php 
require_once(dirname(__FILE__)."/config.php");
CheckRank(0,0);
$buyid = '';
$ptype = '';
$pname = '';
$price = '';
$buyid = '';
$mtime = time();
$mid = $cfg_ml->M_ID;
$buyid = 'M'.$mid.'T'.$mtime.'RN'.mt_rand(100,999);
$dsql = new DedeSql(false);

//ɾ���û��ɵ�δ�����ͬ���¼
$mid = intval($mid);
$dsql->ExecuteNoneQuery("Delete From #@__member_operation where mid='$mid' And sta=0 And product='$product'");

$pid = intval($pid);
if($product=='member'){
	$ptype = "��Ա����";
	$row = $dsql->GetOne("Select * From #@__member_type where aid='{$pid}'");
	if(!is_array($row)){
		echo "�޷�ʶ����Ķ�����";
		$dsql->Close();
	  exit();
	}
	$pname = $row['pname'];
	$price = $row['money'];
}
else if($product=='card'){
	$ptype = "�㿨����";
	$row = $dsql->GetOne("Select * From #@__moneycard_type where tid='{$pid}'");
	if(!is_array($row)){
		echo "�޷�ʶ����Ķ�����";
		$dsql->Close();
	  exit();
	}
	$pname = $row['pname'];
	$price = $row['money'];
}

if($product=='card'){ $okptype = $ptype.' : δ��ÿ���'; }
else{ $okptype = $ptype; }
//���涨����Ϣ

$inquery = "
   INSERT INTO #@__member_operation(`buyid` , `pname` , `product` , `money` , `mtime` , `pid` , `mid` , `sta` ,`oldinfo`) 
   VALUES ('$buyid', '$pname', '$product' , '$price' , '$mtime' , '$pid' , '$mid' , '0' , '$ptype');
";

$isok = $dsql->ExecuteNoneQuery($inquery);

if(!$isok){
  echo "���ݿ���������³��ԣ�".$dsql->GetError();
	$dsql->Close();
	exit();
}

if($price==''){
	echo "�޷�ʶ����Ķ�����";
	$dsql->Close();
	exit();
}

$pagePos = 'post_to_pay';
if(empty($cfg_online_type)) $cfg_online_type = 'none';
require_once(dirname(__FILE__).'/config_pay_'.$cfg_online_type.'.php');
require_once(dirname(__FILE__).'/templets/buy_action_'.$cfg_online_type.'.htm');

?>
