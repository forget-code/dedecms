<?php 
require_once(dirname(__FILE__)."/config.php");
if(empty($fmdo)) $fmdo = "";
if(empty($dopost)) $dopost = "";
if(empty($_POST) && empty($_GET))
{
	ShowMsg("��ҳ���ֹ����!","control.php");
	exit();
}

switch($fmdo){
 /*********************
 function A_User()
 *******************/
 case "user":
 /*
 ����û����Ƿ����
 function ACheckUser();
 */
 if($dopost=="checkuser")
 {
 	 $msg = "";
 	 $userid = trim($userid);
 	 if($userid==""||!TestStringSafe($userid)){
 	 	 $msg = "����û������зǷ��ַ���";
 	 }else{
 	   $dsql = new DedeSql(false);
 	   $dsql->SetQuery("Select ID From #@__member where userid='$userid'");
 	   $dsql->Execute();
 	   $rowcount = $dsql->GetTotalRow();
 	   $dsql->Close();
 	   if($rowcount>0){ $msg = "������ѡ����û�����[<font color='red'>$userid</font>] ���Ѿ�����ʹ�ã���ʹ�������û�����"; }
 	   else{ $msg = "������ѡ����û�����[<font color='red'>$userid</font>] ����������ʹ�ã���ӭע�ᡣ"; }
 	 }
 	 $htmlhead  = "<html>\r\n<head>\r\n<title>��ʾ��Ϣ</title>\r\n";
	 $htmlhead .= "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\" />\r\n";
	 $htmlhead .= "</head>\r\n<body leftmargin='8' topmargin='8' background='img/dedebg.gif' bgcolor='#D0E8C8' style='font-size:10pt;line-height:150%'>";
	 $htmlfoot  = "</body>\r\n</html>\r\n";
	 echo $htmlhead.$msg.$htmlfoot;
	 exit();
 }
 /*
 ���û�ע��
 function AUserReg()
 */
 else if($dopost=="regnew")
 {
 	 if($cfg_pp_isopen==1 && $cfg_pp_regurl!=''){
	    header("Location:{$cfg_pp_regurl}");
	    exit();
   }
 	 require_once(dirname(__FILE__)."/reg_new.php");
 	 exit();
 }
 else if($dopost=="regok")
 {
 	 if($cfg_pp_isopen==1 && $cfg_pp_regurl!=''){
	    header("Location:{$cfg_pp_regurl}");
	    exit();
   }
 	 $svali = GetCkVdValue();
   if(strtolower($vdcode)!=$svali || $svali==""){
  	 ShowMsg("��֤�����","-1");
  	 exit();
   }
 	 $userid = trim($userid);
 	 $pwd = trim($userpwd);
 	 $pwdc = trim($userpwdok);
 	 if(!TestStringSafe($userid)||!TestStringSafe($pwd))
 	 {
 	 	  ShowMsg("����û��������벻�Ϸ���","-1");
 	 	  exit();
 	 }
 	 if(strlen($userid)<3||strlen($pwd)<3){
 	 	  ShowMsg("����û���������С����λ��������ע�ᣡ","-1");
 	 	  exit();
 	 }
 	 if(strlen($userid)>24||strlen($pwd)>24){
 	 	  ShowMsg("����û��������볤�Ȳ��ܳ���24λ��","-1");
 	 	  exit();
 	 }
 	 if($pwdc!=$pwd){
 	 	 ShowMsg("��������������벻һ�£�","-1");
 	 	 exit();
 	 }
 	 $dsql = new DedeSql(false);
 	 
 	 //��Ա��Ĭ�Ͻ��
 	 $dfrank = $dsql->GetOne("Select money From #@__arcrank where rank='10' ");
 	 if(is_array($dfrank)) $dfmoney = $dfrank['money'];
 	 else $dfmoney = 0;
 	 
 	 $dsql->SetQuery("Select ID From #@__member where userid='$userid'");
 	 $dsql->Execute();
 	 $rowcount = $dsql->GetTotalRow();
 	 if($rowcount>0){
 	 	 $dsql->Close();
 	 	 ShowMsg("��ָ�����û����Ѵ��ڣ���ʹ�ñ���û�����","-1");
 	 	 exit();
   }
   if(!TestStringSafe($uname)){
   	 $dsql->Close();
   	 ShowMsg("�û��ǳ��зǷ��ַ���","-1");
 	 	 exit();
   }
   $pwd = GetEncodePwd($pwd);
 	 $jointime = mytime();
 	 $logintime = mytime();
 	 $joinip = GetIP();
 	 $loginip = GetIP();
 	 
 	 //���ÿ�ѡע����Ŀ��Ĭ��ֵ
 	 $dfregs['birthday_y'] = '0000';
 	 $dfregs['birthday_m'] = '00';
 	 $dfregs['birthday_d'] = '00';
 	 $dfregs['birthday'] = '0000-00-00';
 	 $dfregs['weight'] = '0';
 	 $dfregs['height'] = '0';
 	 $dfregs['job'] = '';
 	 $dfregs['province'] = '0';
 	 $dfregs['city'] = '0';
 	 $dfregs['myinfo'] = '';
 	 $dfregs['tel'] = '';
 	 $dfregs['oicq'] = '';
 	 $dfregs['homepage'] = '';
 	 $dfregs['address'] = '';
 	 $dfregs['showaddr'] = '0';
 	 foreach($dfregs as $k=>$v){
 	 	 if(!isset($$k)) $$k = $v;
 	 }
 	 
 	 $birthday = GetAlabNum($birthday_y)."-".GetAlabNum($birthday_m)."-".GetAlabNum($birthday_d);
 	 if($birthday=='0-0-0'){
 	 	 $birthday = '0000-00-00';
 	 }
 	 $height = GetAlabNum($height);

 	 $inQuery = "
 	 INSERT INTO #@__member(userid,pwd,uname,sex,birthday,membertype,money,
 	 weight,height,job,province,city,myinfo,tel,oicq,email,homepage,
 	 jointime,joinip,logintime,loginip,showaddr,address) 
   VALUES ('$userid','$pwd','$uname','$sex','$birthday','10','$dfmoney',
   '$weight','$height','$job','$province','$city','$myinfo','$tel','$oicq','$email','$homepage',
   '$jointime','$joinip','$logintime','$loginip','$showaddr','$address');
 	 ";
 	 if($dsql->ExecuteNoneQuery($inQuery))
 	 {
 	 	  $dsql->Close();
 	 	  $ml = new MemberLogin();
 	 	  $rs = $ml->CheckUser($userid,$pwd);
 	 	  if($rs==1){
 	 	  	ShowMsg("ע��ɹ���5���Ӻ�ת��ռ��������...","control.php",0,2000);
 	 	    exit();
 	 	  }
 	 	  else{
 	 	  	ShowMsg("ע��ɹ���5���Ӻ�ת���¼ҳ��...","login.php",0,2000);
 	 	    exit();
 	 	  }
 	 }
 	 else
 	 {
 	 	 $dsql->Close();
 	 	 ShowMsg("ע��ʧ�ܣ����������Ƿ�����������Ա��ϵ��","-1");
 	 	 exit();
 	 }
 }
  /*
 �����û�����
 function AEditUser()
 */
 else if($dopost=="editUserSafe")
 {
 	  if($cfg_pp_isopen==1 && $cfg_pp_editsafeurl!=''){
	    header("Location:{$cfg_pp_editsafeurl}");
	    exit();
    }
 	  CheckRank(0,0);
 	  $svali = GetCkVdValue();
    if(strtolower($vdcode)!=$svali || $svali==""){
  	  ShowMsg("��֤�����","-1");
  	  exit();
    }
 	  if($oldpwd==""){
 	  	ShowMsg("��û����д��ľ����룡","-1");
 	  	exit();
 	  }
 	  $pwd = trim($userpwd);
 	  $pwdc = trim($userpwdok);
 	  if($pwd!=""){
 	      if(strlen($pwd)>24){
 	 	       ShowMsg("���볤�Ȳ��ܳ���24λ��","-1");
 	 	       exit();
 	      }
 	      if(!TestStringSafe($pwd)){
 	 	      ShowMsg("��������뺬�зǷ��ַ���","-1");
 	 	      exit();
 	      }
 	      if($pwdc!=$pwd){
 	 	      ShowMsg("��������������벻һ�£�","-1");
 	 	      exit();
 	      }
 	  }else{
 	  	ShowMsg("��û������Ҫ���ĵ����룡","-1");
 	 	  exit();
 	  }
 	  $dsql = new DedeSql(false);
 	  $row = $dsql->GetOne("Select pwd From #@__member where ID='".$cfg_ml->M_ID."'");
 	  $oldpwd = GetEncodePwd($oldpwd);
 	  if(!is_array($row)||$row['pwd']!=$oldpwd){
 	     $dsql->Close();
 	     ShowMsg("������ľ��������","-1");
 	 	   exit();
 	  }
 	  $pwd = GetEncodePwd($pwd);
 	  $query = "update #@__member set pwd = '$pwd' where ID='".$cfg_ml->M_ID."'";
 	  $dsql->ExecuteNoneQuery($query);
 	  ShowMsg("�ɹ�����������룡","-1");
 	 	exit();
 }
 else if($dopost=="editUser")
 {
 	  CheckRank(0,0);
 	  $svali = GetCkVdValue();
    if(strtolower($vdcode)!=$svali || $svali==""){
  	  ShowMsg("��֤�����","-1");
  	  exit();
    }
 	  /*
 	  if($oldpwd==""){
 	  	ShowMsg("��û����д������룡","-1");
 	  	exit();
 	  }
 	  
 	  $dsql = new DedeSql(false);
 	  $row = $dsql->GetOne("Select pwd From #@__member where ID='".$cfg_ml->M_ID."'");
 	  $oldpwd = GetEncodePwd($oldpwd);
 	  if(!is_array($row)||$row['pwd']!=$oldpwd){
 	     $dsql->Close();
 	     ShowMsg("��������������","-1");
 	 	   exit();
 	  }*/
 	  $query = "
 	  update #@__member set 
 	  email = '$email',
    uname = '$uname',
    sex = '$sex',
    birthday = '$birthday',
    weight = '$weight',
    height = '$height',
    job = '$job',
    province = '$province',
    city = '$city',
    myinfo = '$myinfo',
    fullinfo = '$fullinfo',
    showaddr = '$showaddr',
    address = '$address',
    oicq = '$oicq',
    tel = '$tel',
    homepage = '$homepage'
 	  where ID='".$cfg_ml->M_ID."'
 	  ";
 	  $dsql->SetQuery($query);
 	  if(!$dsql->ExecuteNoneQuery())
 	  {
 	  	 $dsql->Close();
 	     ShowMsg("�������ϳ������������Ƿ�Ϸ���","-1");
 	 	   exit();
 	  }
 	  else{
 	    $dsql->Close();
 	    ShowMsg("�ɹ�������ĸ������ϣ�","edit_info.php");
 	 	  exit();
 	  }
 }
  /*
 ���ĸ��˿ռ�����
 function EditSpace()
 */
 else if($dopost=="editSpace")
 {
 	  CheckRank(0,0);
 	  $svali = GetCkVdValue();
    if(strtolower($vdcode)!=$svali || $svali==""){
  	  ShowMsg("��֤�����","-1");
  	  exit();
    }
    require_once("./inc/inc_archives_functions.php");
    $title = "�ռ�����";
    $spaceimage = GetUpImage('spaceimage',true,true,150,112,'myface');
    if($spaceimage=="" && $oldimg!="" && $oldimg!="img/pview.gif"){
    	 if(file_exists($cfg_basedir.$oldimg)){
    	 	  $spaceimage = $oldimg;
    	 }
    }
 	  $dsql = new DedeSql(false);
 	  $news = addslashes(cn_substr(stripslashes($news),1024));
 	  $news = eregi_replace("<(iframe|script|javascript)","",$news);
 	  $spacename = ereg_replace("[><]","",$spacename);
 	  $mybb = addslashes(html2text(stripslashes($mybb)));
 	  $upquery = "Update #@__member set 
 	      spacename='$spacename',spaceimage='$spaceimage',news='$news',mybb='$mybb' 
 	      where ID='".$cfg_ml->M_ID."';
 	  ";
 	  $ok = $dsql->ExecuteNoneQuery($upquery);
 	  if($ok){
 	  	$dsql->Close();
 	  	ShowMsg("�ɹ�������ĸ��˿ռ���ܣ�","space_info.php?".time().mt_rand(100,900));
 	  	exit();
 	  }else{
 	  	$dsql->Close();
 	    ShowMsg("��������ʧ�ܣ�","space_info.php?".time().mt_rand(100,900));
 	 	  exit();
 	  }
 }
 //
 break;
 /*********************
 function B_Login()
 *******************/
 case "login":
 //
 /*
 �û���¼
 function BUserLogin()
 */
 if($dopost=="login")
 {
 	 if($cfg_pp_isopen==1 && $cfg_pp_loginurl!=''){
	    header("Location:{$cfg_pp_loginurl}");
	    exit();
   }
 	 $svali = GetCkVdValue();
   if(strtolower($vdcode)!=$svali || $svali==""){
  	 ShowMsg("��֤�����","-1");
  	 exit();
   }
   if(!TestStringSafe($userid)||!TestStringSafe($pwd))
   {
   	 ShowMsg("�û��������벻�Ϸ���","-1",0,2000);
  	 exit();
   }
   if($userid==""||$pwd==""){
   	 ShowMsg("�û��������벻��Ϊ�գ�","-1",0,2000);
  	 exit();
   }
   //����ʺ�
   $rs = $cfg_ml->CheckUser($userid,GetEncodePwd($pwd));
   if($rs==0) {
   	 ShowMsg("�û��������ڣ�","-1",0,2000);
  	 exit();
   }
   else if($rs==-1){
   	 ShowMsg("�������","-1",0,2000);
  	 exit();
   }
   else{
   	 $dsql = new DedeSql(false);
   	 $dsql->SetQuery("update #@__member set logintime='".mytime()."',loginip='".GetIP()."' where ID='".$cfg_ml->M_ID."'");
   	 $dsql->ExecuteNoneQuery();
   	 $dsql->Close();
   	 if(empty($gourl)||eregi("action|_do",$gourl)){
   	 	  ShowMsg("�ɹ���¼��5���Ӻ�ת��ϵͳ��������...","control.php",0,2000);
   	 }else{
   	 	  ShowMsg("�ɹ���¼��ת������ҳ��...",$gourl,0,2000);
   	 }
  	 exit();
   }
 }
 /*
 �˳���¼
 function BUserExit()
 */
 else if($dopost=="exit")
 {
 	 $cfg_ml->ExitCookie();
 	 if($cfg_pp_isopen==1 && $cfg_pp_exiturl!=''){
	    echo "<script> location='{$cfg_pp_exiturl}'; </script>";
	    exit();
   }
 	 $cfg_ml->ExitCookie();
 	 ShowMsg("�ɹ��˳���¼��","login.php",0,2000);
   exit();
 }
/*
 ��ȡ����
 function BUserGetPwd()
*/
 else if($dopost=="getpwd")
 {
 	 if($cfg_pwdtype=='md5'){
 	 	 ShowMsg("ϵͳ�����뱻����Ϊ������ܣ��޷�ȡ�أ��������Ա��ϵ��","javascript:;");
 	 	 exit();
 	 }
 	 $svali = GetCkVdValue();
   if(strtolower($vdcode)!=$svali || $svali==""){
  	 ShowMsg("��֤�����","-1");
  	 exit();
   }
   if(!ereg("(.*)@(.*)\.(.*)",$email)||!TestStringSafe($email)){
   	 ShowMsg("�����ַ��ʽ����ȷ��","-1");
  	 exit();
   }
   $dsql = new DedeSql(false);
   $row = $dsql->GetOne("Select userid,pwd,uname,email From #@__member where email='$email'");
   if(!is_array($row)){
     $dsql->Close();
     ShowMsg("ϵͳ�Ҳ����������ַ��","-1");
  	 exit();
   }
   $dsql->Close();
	 $mailtitle = "����".$cfg_webname."���û���������";
	 $mailbody = "\r\n�û�����'".$row['userid']."'  ���룺'".$row['pwd']."'\r\n\r\n��
	 $cfg_powerby";
	 $headers = "From: ".$cfg_adminemail."\r\nReply-To: $cfg_adminemail";
   @mail($email, $mailtitle, $mailbody, $headers);
   $gurl = explode("@",$email);
   ShowMsg("�ɹ���������û��������룬��ע����գ�","login.php");
   exit();
 }
 //
 break;
}

?>