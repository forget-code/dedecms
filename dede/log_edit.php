<?php 
require_once(dirname(__FILE__)."/config.php");
CheckPurview('sys_Log');

if(empty($dopost)){
	ShowMsg("��ûָ���κβ�����","javascript:;");
	exit();
}

//���������־
if($dopost=="clear"){
	$dsql = new DedeSql(false);
	$dsql->ExecuteNoneQuery("Delete From #@__log");
	$dsql->Close();
	ShowMsg("�ɹ����������־��","log_list.php");
	exit();
}
else if($dopost=="del")
{
	isset($_COOKIE['ENV_GOBACK_URL']) ? $bkurl =$_COOKIE['ENV_GOBACK_URL'] : $baurl="log_list.php";
	$ids = explode('`',$ids);
	$dquery = "";
	foreach($ids as $id){
		if($dquery=="") $dquery .= " lid='$id' ";
		else $dquery .= " Or lid='$id' ";
	}
	if($dquery!="") $dquery = " where ".$dquery;
	$dsql = new DedeSql(false);
	$dsql->ExecuteNoneQuery("Delete From #@__log $dquery");
	$dsql->Close();
	ShowMsg("�ɹ�ɾ��ָ������־��",$bkurl);
	exit();
}
else{
	ShowMsg("�޷�ʶ���������","javascript:;");
	exit();
}

?>
