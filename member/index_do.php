<?
require_once(dirname(__FILE__)."/config.php");
if(empty($fmdo)) $fmdo = "";
if(empty($dopost)) $dopost = "";
if(empty($_POST) && empty($_GET))
{
	ShowMsg("��ҳ���ֹ����!","index.php");
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
 	 if($userid==""||ereg("[ '\"\*\?\%]","",$userid)){
 	 	 $msg = "����û���Ϊ�գ����ߺ��� ['],[\"],[*],[?],[%],[�ո�] ����Ƿ��ַ���";
 	 }
 	 else
 	 {
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
 	 require_once(dirname(__FILE__)."/reg_new.php");
 	 exit();
 }
 else if($dopost=="regok")
 {
 	 session_start();
 	 if( empty($_SESSION["s_validate"]) ) $svali = "";
   else $svali = $_SESSION["s_validate"];
   if(strtolower($vdcode)!=$svali && $svali!=""){
  	 ShowMsg("��֤�����","-1");
  	 exit();
   }
 	 $userid = trim($userid);
 	 $pwd = trim($userpwd);
 	 $pwdc = trim($userpwdok);
 	 if(ereg("[ '\"\*\?\%]","",$userid)||ereg("[ '\"\*\?\%]","",$pwd)){
 	 	  ShowMsg("����û���Ϊ�գ����ߺ��� ['],[\"],[*],[?],[%],[�ո�] ����Ƿ��ַ���","-1");
 	 	  exit();
 	 }
 	 if($pwdc!=$pwd){
 	 	 ShowMsg("��������������벻һ�£�","-1");
 	 	 exit();
 	 }
 	 $dsql = new DedeSql(false);
 	 $dsql->SetQuery("Select ID From #@__member where userid='$userid'");
 	 $dsql->Execute();
 	 $rowcount = $dsql->GetTotalRow();
 	 if($rowcount>0){
 	 	 $dsql->Close();
 	 	 ShowMsg("��ָ�����û����Ѵ��ڣ���ʹ�ñ���û�����","-1");
 	 	 exit();
   }
   $uname = ereg_replace("[ '\"\*\?\%]","",$uname);
   if($uname==""){
   	 ShowMsg("�û��ǳ��зǷ��ַ���","-1");
 	 	 exit();
   }
 	 $jointime = time();
 	 $logintime = time();
 	 $joinip = GetIP();
 	 $loginip = GetIP();
 	 $birthday = GetAlabNum($birthday_y)."-".GetAlabNum($birthday_m)."-".GetAlabNum($birthday_d);
 	 $height = GetAlabNum($height);
 	 $inQuery = "
 	 INSERT INTO #@__member(userid,pwd,uname,sex,birthday,membertype,uptype,money,weight,height,job,province,city,myinfo,mybb,tel,oicq,email,homepage,jointime,joinip,logintime,loginip) 
   VALUES ('$userid','$pwd','$uname','$sex','$birthday','0','0','0','$weight','$height','$job','$province','$city','$myinfo','$mybb','$tel','$oicq','$email','$homepage','$jointime','$joinip','$logintime','$loginip');
 	 ";
 	 $dsql->SetQuery($inQuery);
 	 if($dsql->ExecuteNoneQuery())
 	 {
 	 	  $dsql->Close();
 	 	  $ml = new MemberLogin();
 	 	  $rs = $ml->CheckUser($userid,$pwd);
 	 	  if($rs==1){
 	 	  	ShowMsg("ע��ɹ���5���Ӻ�ת��ϵͳ��ҳ...","index.php",0,2000);
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
 ��������
 function AUserUpRank();
 */
 else if($dopost=="uprank")
 {
 	 CheckRank(0,0);
 	 if(empty($uptype))
 	 {
 	 	 ShowMsg("������Ч��","-1");
 	 	 exit();
 	 }
 	 $uptype = GetAlabNum($uptype);
 	 if($uptype < $cfg_ml->M_Type)
 	 {
 	 	 ShowMsg("���Ͳ��ԣ���ļ������Ŀǰ����ļ���Ҫ�ߣ�","-1");
 	 	 exit();
 	 }
 	 $dsql = new DedeSql();
 	 $dsql->SetQuery("update #@__member set uptype='$uptype' where ID='".$cfg_ml->M_ID."' ");
 	 $dsql->Execute();
 	 $dsql->Close();
 	 ShowMsg("�ɹ�������������ȴ�����Ա��ͨ��","index.php?".time());
 	 exit();
 }
 /*
 ���ӽ��
 function AddMoney();
 */
 else if($dopost=="addmoney")
 {
 	 CheckRank(0,0);
 	 session_start();
 	 if( empty($_SESSION["s_validate"]) ) $svali = "";
   else $svali = $_SESSION["s_validate"];
   if(strtolower($vdcode)!=$svali && $svali!=""){
  	 ShowMsg("��֤�����","-1");
  	 exit();
   }
 	 if(empty($money))
 	 {
 	 	 ShowMsg("��ûָ��Ҫ������ٽ�ң�","-1");
 	 	 exit();
 	 }
 	 $dsql = new DedeSql();
 	 $dsql->SetQuery("update #@__member set upmoney='$money' where ID='".$cfg_ml->M_ID."'");
 	 $dsql->Execute();
 	 $dsql->Close();
 	 ShowMsg("�ɹ��ύ������룡","index.php?".time());
 	 exit();
 }
  /*
 �����û�����
 function AEditUser()
 */
 else if($dopost=="editUser")
 {
 	  session_start();
 	  CheckRank(0,0);
 	  if( empty($_SESSION["s_validate"]) ) $svali = "";
    else $svali = $_SESSION["s_validate"];
    if(strtolower($vdcode)!=$svali && $svali!=""){
  	  ShowMsg("��֤�����","-1");
  	  exit();
    }
 	  if($province==0) $province = $oldprovince;
 	  if($city==0) $city = $oldcity;
 	  $oldpwd = ereg_replace("[ '\"\*\?\%]","",$oldpwd);
 	  if($oldpwd==""){
 	  	ShowMsg("��û����д��ľ����룡","-1");
 	  	exit();
 	  }
 	  $pwd = trim($userpwd);
 	  $pwdc = trim($userpwdok);
 	  if($pwd!="")
 	  {
 	    if(ereg("[ '\"\*\?\%]","",$pwd)){
 	 	    ShowMsg("������뺬�� ['],[\"],[*],[?],[%],[�ո�] ����Ƿ��ַ���","-1");
 	 	    exit();
 	    }
 	    if($pwdc!=$pwd){
 	 	    ShowMsg("��������������벻һ�£�","-1");
 	 	    exit();
 	    }
 	  }
 	  else{
 	  	$pwd = $oldpwd;
 	  }
 	  $dsql = new DedeSql(false);
 	  $row = $dsql->GetOne("Select pwd From #@__member where ID='".$cfg_ml->M_ID."'");
 	  if(!is_array($row)||$row['pwd']!=$oldpwd)
 	  {
 	     $dsql->Close();
 	     ShowMsg("������ľ��������","-1");
 	 	   exit();
 	  }
 	  $query = "
 	  update #@__member set 
 	  pwd='$pwd',
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
    mybb = '$mybb',
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
 	    ShowMsg("�ɹ�������ĸ������ϣ�","index.php");
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
 	 session_start();
 	 if( empty($_SESSION["s_validate"]) ) $svali = "";
   else $svali = $_SESSION["s_validate"];
   if(strtolower($vdcode)!=$svali && $svali!=""){
  	 ShowMsg("��֤�����","-1");
  	 exit();
   }
   if(ereg("[ '\"\*\?\%]","",$userid)||ereg("[ '\"\*\?\%]","",$pwd))
   {
   	 ShowMsg("�û��������벻�Ϸ���","-1",0,2000);
  	 exit();
   }
   if($userid==""||$pwd==""){
   	 ShowMsg("�û��������벻��Ϊ�գ�","-1",0,2000);
  	 exit();
   }
   //����ʺ�
   $rs = $cfg_ml->CheckUser($userid,$pwd);
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
   	 $dsql->SetQuery("update #@__member set logintime='".time()."',loginip='".GetIP()."' where ID='".$cfg_ml->M_ID."'");
   	 $dsql->ExecuteNoneQuery();
   	 $dsql->Close();
   	 if(empty($gourl)) ShowMsg("�ɹ���¼��5���Ӻ�ת��ϵͳ��ҳ...","index.php",0,2000);
   	 else ShowMsg("�ɹ���¼��ת������ҳ��...",$gourl,0,2000);
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
 	 ShowMsg("�ɹ��˳���¼��","login.php",0,2000);
   exit();
 }
 /*
 ��ȡ����
 function BUserGetPwd()
 */
 else if($dopost=="getpwd")
 {
 	 session_start();
 	 if( empty($_SESSION["s_validate"]) ) $svali = "";
   else $svali = $_SESSION["s_validate"];
   if(strtolower($vdcode)!=$svali && $svali!=""){
  	 ShowMsg("��֤�����","-1");
  	 exit();
   }
   if(!ereg("(.*)@(.*)\.(.*)",$email)){
   	 ShowMsg("�����ַ��ʽ����ȷ��","-1");
  	 exit();
   }
   $dsql = new DedeSql(false);
   $row = $dsql->GetOne("Select userid,pwd,uname,email From #@__member where email='$email'");
   if(!is_array($row))
   {
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