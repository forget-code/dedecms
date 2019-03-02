<?php 
require_once(dirname(__FILE__)."/config.php");
CheckPurview('sys_Edit');

$varname = $_POST['varname'];
if(!eregi('cfg_',$varname)){
	ShowMsg("�������Ʊ����� cfg_ ��ͷ","-1");
	exit();
}

if($vartype=='bool' && ($varvalue!='��' && $varvalue!='��')){
	ShowMsg("��������ֵ����Ϊ����'��'��'��'!","-1");
	exit();
}

$dsql = new DedeSql(false);

$row = $dsql->GetOne("Select * From #@__sysconfig where varname like '$varname' ");
if(is_array($row)){
	 ShowMsg("�ñ��������Ѿ�����!","-1");
	 $dsql->Close();
	 exit();
}

$row = $dsql->GetOne("Select * From #@__sysconfig order by aid desc ");
$aid = $row['aid']+1;

$inquery = "INSERT INTO `#@__sysconfig`(`aid`,`varname`,`info`,`value`,`type`,`group`) 
VALUES ('$aid','$varname','$varmsg','$varvalue','$vartype','$vargroup')";

$rs = $dsql->ExecuteNoneQuery($inquery);

if(!$rs){
	 $dsql->Close();
	 ShowMsg("��������ʧ�ܣ������зǷ��ַ���","sys_info.php?gp=$vargroup");
	 exit();
}

$configfile = dirname(__FILE__)."/../include/config_hand.php";
$configfile_bak = dirname(__FILE__)."/../include/config_hand_bak.php";

if(!is_writeable($configfile)){
	$dsql->Close();
	ShowMsg("�ɹ���������������� $configfile �޷�д�룬��˲��ܸ��������ļ���","sys_info.php?gp=$vargroup");
	exit();
}else{
	$dsql->SetQuery("Select varname,value From #@__sysconfig order by aid asc");
	$dsql->Execute();
	if($dsql->GetTotalRow()<=0){
		$dsql->Close();
		ShowMsg("�ɹ���������������ݿ��ȡ��������ʱʧ�ܣ��޷����������ļ���","sys_info.php?gp=$vargroup");
	  exit();
	}
	copy($configfile,$configfile_bak);
	$fp = fopen($configfile,"w");
	fwrite($fp,"<"."?php\r\n");
  while($row = $dsql->GetArray()){
  	fwrite($fp,"\${$row['varname']} = '".str_replace("'","\\'",$row['value'])."';\r\n");
  }
  fwrite($fp,"?".">");
	fclose($fp);
	$dsql->Close();
	ShowMsg("�ɹ�������������������ļ���","sys_info.php?gp=$vargroup");
	exit();
}

?>