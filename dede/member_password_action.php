<?php 
require_once(dirname(__FILE__)."/config.php");
CheckPurview('member_Data');
if(empty($notcdata)) $notcdata = 0;
$dsql = new DedeSql(false);
$row = $dsql->GetOne("Select count(*) as dd From #@__member ");
$dd = $row['dd'];
//��������
$configfile = dirname(__FILE__)."/../include/config_hand.php";
$configfile_bak = dirname(__FILE__)."/../include/config_hand_bak.php";
$dsql->ExecuteNoneQuery("Update #@__sysconfig set value='$newtype' where varname='cfg_pwdtype' ");
$dsql->ExecuteNoneQuery("Update #@__sysconfig set value='$newmd5len' where varname='cfg_md5len' ");
$dsql->ExecuteNoneQuery("Update #@__sysconfig set value='$newsign' where varname='cfg_ddsign' ");
$dsql->SetQuery("Select varname,value From #@__sysconfig order by aid asc");
$dsql->Execute();
copy($configfile,$configfile_bak) or die("��������{$configfile}ʱʧ�ܣ�����Ȩ��");
$fp = fopen($configfile,'w') or die("��������{$configfile}ʱʧ�ܣ�����Ȩ��");
flock($fp,3);
fwrite($fp,"<"."?php\r\n");
while($row = $dsql->GetArray()){
  fwrite($fp,"\${$row['varname']} = '".str_replace("'","\\'",$row['value'])."';\r\n");
}
fwrite($fp,"?".">");
fclose($fp);
if($dd==0){
	$dsql->Close();
	ShowMsg("�ɹ��������ã����ڻ�Աϵͳ�����ݣ���˲���ת����","javascript:;");
	exit();
}
if($notcdata==1){
	$dsql->Close();
	ShowMsg("�ɹ��������ã�","javascript:;");
	exit();
}
//-------------------------------
//������Ϊ��������
if($cfg_pwdtype=='none'){
	if($newtype=='none'){
		$dsql->Close();
	  ShowMsg("��ָ�������ͺ�ϵͳĿǰ������һ�£�����Ҫת����","javascript:;");
	  exit();
	}
  $cfg_pwdtype = $newtype;
  $cfg_md5len = $newmd5len;
  $cfg_ddsign = $newsign;
	$dsql->SetQuery("Select ID,pwd From #@__member ");
	$dsql->Execute();
	while($row = $dsql->GetArray()){
		$pwd = addslashes(GetEncodePwd($row['pwd']));
		$ID = $row['ID'];
		$dsql->ExecuteNoneQuery("Update #@__member set pwd='$pwd' where ID='$ID' ");
	}
	$dsql->Close();
	ShowMsg("�ɹ���� {$dd} �����ݵ�ת����","javascript:;");
	exit();
}
//������Ϊdede�����㷨����
else if($cfg_pwdtype=='dd'){
	if($newtype=='dd' && $newsign==$cfg_ddsign){
		$dsql->Close();
	  ShowMsg("��ָ�������ͺ�ϵͳĿǰ������һ�£�����Ҫת����","javascript:;");
	  exit();
	}
  $oosign = $cfg_ddsign;
  $cfg_pwdtype = $newtype;
  $cfg_md5len = $newmd5len;
  $cfg_ddsign = $newsign;
	$dsql->SetQuery("Select ID,pwd From #@__member ");
	$dsql->Execute();
	while($row = $dsql->GetArray()){
		$ID = $row['ID'];
		$pwd = DdPwdDecode($row['pwd'],$oosign);
		$pwd = addslashes(GetEncodePwd($pwd));
		$dsql->ExecuteNoneQuery("Update #@__member set pwd='$pwd' where ID='$ID' ");
	}
	$dsql->Close();
	ShowMsg("�ɹ���� {$dd} �����ݵ�ת����","javascript:;");
	exit();
}
//������Ϊmd5����
else if($cfg_pwdtype=='md5'){
	if($newtype!='md5'){
		$dsql->Close();
		ShowMsg("��ԭ������������ΪMD5���ͣ�ϵͳ�޷�ת���������Ϊ��MD5���ͣ�","javascript:;");
		exit();
	}
	if($newmd5len > $cfg_md5len){
		$dsql->Close();
		ShowMsg("��ԭ����MD5�������Ŀǰָ���Ķ̣�ϵͳ�޷�ת��Ϊ���������룡","javascript:;");
		exit();
	}
	if($newmd5len == $cfg_md5len){
		$dsql->Close();
		ShowMsg("��ԭ�������������ѡ��һ��������ת����","javascript:;");
		exit();
	}
	$dsql->SetQuery("Select ID,pwd From #@__member ");
	$dsql->Execute();
	while($row = $dsql->GetArray()){
		$ID = $row['ID'];
		$pwd = $row['pwd'];
		$pwd = substr($pwd,0,$newmd5len);
		$dsql->ExecuteNoneQuery("Update #@__member set pwd='$pwd' where ID='$ID' ");
	}
	$dsql->Close();
	ShowMsg("�ɹ���� {$dd} �����ݵ�ת����","javascript:;");
	exit();
}
//������Ϊmd5�м�16λ
else if($cfg_pwdtype=='md5m16'){
	$dsql->Close();
	ShowMsg("��ԭ������������ΪMD5�м�ȡ16λ�����ͣ��޷�ת��Ϊ�������ݣ�","javascript:;");
	exit();
}

?>