<?php 
/*-------------------------------------------
ͨ��վ�������Ͻӿ�Զ�̵����ļ�
��Ӧ��������ϵͳ����Dedecms--����ʹ������ϵͳ��Ϊ��¼��ע������ڣ�
���ߣ� IT����ͼ  ����޸����� 2007-3-29
���ļ���������ASP���ϵͳ���ִ�û��ʹ��base64���ܣ�
//**********************************************************************
���ļ�����Ϊ���ع�Զ�̵���
��ʹ�û�ο� pp_dederemote_interface.asp �ṩ�Ľӿں����������ϱ��
-----------------------------------------*/
require_once(dirname(__FILE__)."/../../include/config_base.php");
header("Content-Type: text/html; charset=gb2312");

if($cfg_pp_isopen = 0){
	echo "ϵͳû����ͨ��֤���ܣ���ֹԶ�̵��ã�";
	exit();
}

$cfg_ndsql = 0;

if(empty($rmdata)){
	echo "û���յ��κ�Զ�����ݣ�";
	exit();
}

$keys = Array('userid','userpwd','signstr','newuserpwd','action','email','sex','uname','exptime');

foreach($keys as $v) $$v = '';

//����GET�ַ���
$datas = explode('&',$rmdata);
foreach($datas as $ky){
	$nkys = explode('=',$ky);
	if(in_array($nkys[0],$keys) && isset($nkys[1])) ${$nkys[0]} = urldecode($nkys[1]);
}

$ntime = time();

if($action!='exit'){
  //��֤֤��
  if($userid==''||!TestStringSafe($userid)){
	  echo "�û�IDΪ�ջ���ڷǷ��ַ�����".$oldrmdata;
	  exit();
  }
  if(strlen($userid)>24){
	  echo "�û�ID���Ȳ��ܳ���24λ��";
	  exit();
  }
  $testSign = substr(md5($userid.$cfg_cookie_encode),0,24);
  if($testSign!=$signstr){
	  echo "֤����֤ʧ�ܣ�";
	  exit();
  }
}

//ע�����function������UltraEdit������������������
/*--------------------------------
��Աע��
function __UserReg()
---------------------------------*/
if($action=='reg'){
	if($userpwd==''||!TestStringSafe($userpwd)){
	  echo "�û�����Ϊ�ջ���ڷǷ��ַ�����";
	  exit();
  }
  if(strlen($userpwd)>24){
	  echo "�û����볤�Ȳ��ܳ���24λ��";
	  exit();
  }
	Z_OpenSql();
	$row = $cfg_ndsql->GetOne("Select ID,pwd From #@__member where userid like '$userid' ");
	//����Ѿ������û�������������Ƿ���ȷ�����������ȷ���򷵻ص�¼��Ϣ����������ע��
	if(is_array($row)){
		 $userpwd = GetEncodePwd($userpwd);
	   $ID = $row['ID'];
	   $pwd = $row['pwd'];
	   Z_CloseSql();
	   if($userpwd != $pwd){
		    echo "�û�ID��{$userid} �Ѵ��ڣ���ʹ�������û�����";
		    exit();
	   }else{
	      $backString = $ID;
	      echo 'OK!'.$backString;
	      exit();
	   }
	}
	$userpwd = GetEncodePwd($userpwd);
	$loginip = Z_GetIP();
	$inQuery = "
 	 INSERT INTO #@__member(userid,pwd,uname,sex,birthday,membertype,money,
 	 weight,height,job,province,city,myinfo,tel,oicq,email,homepage,
 	 jointime,joinip,logintime,loginip,showaddr,address) 
   VALUES ('$userid','$userpwd','$uname','$sex','0000-00-00','10','0',
   '0','0','','0','0','','','','','','$ntime','$loginip','$ntime','$loginip','0','');";
   $cfg_ndsql->ExecuteNoneQuery($inQuery);
   $row = $cfg_ndsql->GetOne("Select ID From #@__member where userid like '$userid' ");
	 if(!is_array($row)){
		 Z_CloseSql();
		 echo "ϵͳ�����޷����ע�ᣬ����ϵ����Ա��";
		 exit();
	 }
	 $ID = $row['ID'];
	 Z_CloseSql();
	 $backString = $ID;
	 echo 'OK!'.$backString;
	 exit();
}
/*--------------------------------
����Ƿ�����û���
function __UserTest()
---------------------------------*/
else if($action=='test'){
	Z_OpenSql();
	$row = $cfg_ndsql->GetOne("Select count(ID) as dd From #@__member where userid like '$userid' ");
	if(!is_array($row)){
		 Z_CloseSql();
		 echo "ϵͳ�����޷����ע�ᣬ����ϵ����Ա��";
		 exit();
	}
	if($row['dd']>0){
		 Z_CloseSql();
		 echo "�û�ID�Ѵ��ڣ�";
		 exit();
	}
	 Z_CloseSql();
	 echo 'OK!';
	 exit();
}
/*--------------------------------
��Ա��¼
function __UserLogin()
---------------------------------*/
else if($action=='login'){
	Z_OpenSql();
	$row = $cfg_ndsql->GetOne("Select ID,pwd From #@__member where userid like '$userid' ");
	if(!is_array($row)){
		 Z_CloseSql();
		 echo "�û��������ڣ��޷���¼��ϵͳ��";
		 exit();
	}
	if(strlen($userpwd)>24){
	  echo "�û����볤�Ȳ��ܳ���24λ��";
	  exit();
  }
	$userpwd = GetEncodePwd($userpwd);
	$ID = $row['ID'];
	$pwd = $row['pwd'];
	if($userpwd != $pwd){
		 Z_CloseSql();
		 echo "�������";
		 exit();
	}
	$loginip = Z_GetIP();
	$cfg_ndsql->ExecuteNoneQuery("update #@__member set logintime='$ntime',loginip='$loginip' where ID='$ID' ");
	Z_CloseSql();
	$backString = $ID;
	echo 'OK!'.$backString;
	exit();
}
/*--------------------------------
��������
function __UserEdit()
---------------------------------*/
else if($action=='edit'){
	if($newuserpwd==''||!TestStringSafe($newuserpwd)){
	   echo "�û�����Ϊ�ջ���ڷǷ��ַ�����";
	   exit();
  }
  if(strlen($newuserpwd)>24){
	  echo "�û����볤�Ȳ��ܳ���24λ��";
	  exit();
  }
  $newuserpwd = GetEncodePwd($newuserpwd);
	Z_OpenSql();
	$cfg_ndsql->ExecuteNoneQuery("Update #@__member set pwd='$newuserpwd' where userid like '$userid' ");
	Z_CloseSql();
	echo 'OK!';
}
/*--------------------------------
�˳�ϵͳ
function __UserExit()
---------------------------------*/
else if($action=='exit'){
	$backString = "0";
	echo 'OK!'.$backString;
	exit();
}
/*--------------------------------
�޷�ʶ��Զ�̶���
function __ActionError()
---------------------------------*/
else{
	echo "�޷�ʶ����Ķ�����";
	exit();
}

//���������纯��
function Z_OpenSql(){
	global $cfg_ndsql;
	if(!$cfg_ndsql) $cfg_ndsql = new DedeSql(false);
}
function Z_CloseSql(){
	global $cfg_ndsql;
	if($cfg_ndsql) $cfg_ndsql->Close();
}
function Z_GetIP(){
	if(!empty($_SERVER["HTTP_CLIENT_IP"])) $cip = $_SERVER["HTTP_CLIENT_IP"];
	else if(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) $cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
	else if(!empty($_SERVER["REMOTE_ADDR"])) $cip = $_SERVER["REMOTE_ADDR"];
	else $cip = "�޷���ȡ��";
	return $cip;
}
?>