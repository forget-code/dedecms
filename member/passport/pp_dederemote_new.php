<?php 
/*-------------------------------------------
ͨ��վ�������Ͻӿ�Զ�̵����ļ�����Աר�ð�

���ӿڲ���Ҫ���������������û���������Ϣ��ϵͳ���Զ��жϺ�����

���ߣ� IT����ͼ  ����޸����� 2007-3-29
//**********************************************************************
���ļ�����Ϊ���ع�Զ�̵���
��ʹ�û�ο� pp_dederemote_interface_new.php �ṩ�Ľӿں����������ϱ��
-----------------------------------------*/
require_once(dirname(__FILE__)."/../../include/config_base.php");
header("Content-Type: text/html; charset=gb2312");

//ʹ��ͨ��֤���û�ID��������ţ����ԭDEDEϵͳ���û����ݵĲ���Ҫ��ᣬ������Լ� @pp ֮���ʶ��
$ppName = "";

if($cfg_pp_isopen = 0){
	echo "ϵͳû����ͨ��֤���ܣ���ֹԶ�̵��ã�";
	exit();
}

$cfg_ndsql = 0;

if(empty($rmdata)){
	echo "û���յ��κ�Զ�����ݣ�";
	exit();
}

$keys = Array('userid','signstr','action');

foreach($keys as $v) $$v = '';

//����GET�ַ���
$rmdata = base64_decode($rmdata);
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
	Z_OpenSql();
	$userpwd = chr(mt_rand(ord('A'),ord('Z'))).chr(mt_rand(ord('a'),ord('z'))).chr(mt_rand(ord('A'),ord('Z'))).chr(mt_rand(ord('A'),ord('Z'))).chr(mt_rand(ord('a'),ord('z'))).mt_rand(1000,9999).chr(mt_rand(ord('A'),ord('Z')));
	$userpwd = GetEncodePwd($userpwd);
	$loginip = Z_GetIP();
	$ppuserid = $userid.$ppName;
	$inQuery = "
 	 INSERT INTO #@__member(userid,pwd,uname,sex,birthday,membertype,money,
 	 weight,height,job,province,city,myinfo,tel,oicq,email,homepage,
 	 jointime,joinip,logintime,loginip,showaddr,address) 
   VALUES ('$ppuserid','$userpwd','$userid','','0000-00-00','10','0',
   '0','0','','0','0','','','','','','$ntime','$loginip','$ntime','$loginip','0','');";
   $cfg_ndsql->ExecuteNoneQuery($inQuery);
   $row = $cfg_ndsql->GetOne("Select ID From #@__member where userid like '{$userid}$ppName' ");
	 $ID = $row['ID'];
	 Z_CloseSql();
	 echo 'OK!'.$ID;
	 exit();
}
/*--------------------------------
��Ա��¼
function __UserLogin()
---------------------------------*/
else if($action=='login'){
	Z_OpenSql();
	$row = $cfg_ndsql->GetOne("Select ID,pwd From #@__member where userid like '{$userid}$ppName' ");
	$loginip = Z_GetIP();
	if(!is_array($row)){
		 $userpwd = chr(mt_rand(ord('A'),ord('Z'))).chr(mt_rand(ord('a'),ord('z'))).chr(mt_rand(ord('A'),ord('Z'))).chr(mt_rand(ord('A'),ord('Z'))).chr(mt_rand(ord('a'),ord('z'))).mt_rand(1000,9999).chr(mt_rand(ord('A'),ord('Z')));
	   $userpwd = GetEncodePwd($userpwd);
	   $ppuserid = $userid.$ppName;
		 $inQuery = "
 	   INSERT INTO #@__member(userid,pwd,uname,sex,birthday,membertype,money,
 	   weight,height,job,province,city,myinfo,tel,oicq,email,homepage,
 	   jointime,joinip,logintime,loginip,showaddr,address) 
     VALUES ('$ppuserid','$userpwd','$userid','','0000-00-00','10','0',
     '0','0','','0','0','','','','','','$ntime','$loginip','$ntime','$loginip','0','');";
     $cfg_ndsql->ExecuteNoneQuery($inQuery);
     $row = $cfg_ndsql->GetOne("Select ID,pwd From #@__member where userid like '$userid' ");
	}
	$ID = $row['ID'];
	$cfg_ndsql->ExecuteNoneQuery("update #@__member set logintime='$ntime',loginip='$loginip' where ID='$ID' ");
	Z_CloseSql();
	echo 'OK!'.$ID;
	exit();
}
/*--------------------------------
�˳�ϵͳ
function __UserExit()
---------------------------------*/
else if($action=='exit'){
	echo 'OK!0';
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