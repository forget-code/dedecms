<?php 
//ƴ���Ļ�������
$pinyins = Array();
$g_ftpLink = false;
//�ͻ��������ʱ���У��
function mytime(){
	 global $cfg_cli_time;
	 if(empty($cfg_cli_time)) $cfg_cli_time = 0;
	 $addtime = $cfg_cli_time * 3600;
	 return (time() + $cfg_cli_time);
}
//��õ�ǰ�Ľű���ַ
function GetCurUrl(){
	if(!empty($_SERVER["REQUEST_URI"])){
		$scriptName = $_SERVER["REQUEST_URI"];
		$nowurl = $scriptName;
	}else{
		$scriptName = $_SERVER["PHP_SELF"];
		if(empty($_SERVER["QUERY_STRING"])) $nowurl = $scriptName;
		else $nowurl = $scriptName."?".$_SERVER["QUERY_STRING"];
	}
	return $nowurl;
}
//��ȫ������תΪ�������
function GetAlabNum($fnum){
	$nums = array("��","��","��","��","��","��","��","��","��","��");
	$fnums = "0123456789";
	for($i=0;$i<=9;$i++) $fnum = str_replace($nums[$i],$fnums[$i],$fnum);
	$fnum = ereg_replace("[^0-9\.]|^0{1,}","",$fnum);
	if($fnum=="") $fnum=0;
	return $fnum;
}
//ȥ��HTML��Ƿ���
//function ClearHtml($html){
	//return trim(preg_replace("/[><]/","",$html));
//}
function Text2Html($txt){
	$txt = str_replace("  ","��",$txt);
	$txt = str_replace("<","&lt;",$txt);
	$txt = str_replace(">","&gt;",$txt);
	$txt = preg_replace("/[\r\n]{1,}/isU","<br/>\r\n",$txt);
	return $txt;
}
//���HTML����ı�
function Html2Text($str){
  if(!isset($GLOBALS['__funString'])) require_once(dirname(__FILE__)."/inc/inc_fun_funString.php");
  return SpHtml2Text($str);
}
//���HTML���
function ClearHtml($str){
	$str = str_replace('<','&lt;',$str);
	$str = str_replace('>','&gt;',$str);
	return $str;
}
//���Ľ�ȡ��˫�ֽ��ַ�Ҳ����һ���ַ�
function cnw_left($str,$len){
  return cnw_mid($str,0,$len);
}
function cnw_mid($str,$start,$slen){
  if(!isset($GLOBALS['__funString'])) require_once(dirname(__FILE__)."/inc/inc_fun_funString.php");
  return Spcnw_mid($str,$start,$slen);
}
//���Ľ�ȡ2�����ֽڽ�ȡģʽ
function cn_substr($str,$slen,$startdd=0){
	$restr = "";
	$c = "";
	$str_len = strlen($str);
	if($str_len < $startdd+1) return "";
	if($str_len < $startdd + $slen || $slen==0) $slen = $str_len - $startdd;
	$enddd = $startdd + $slen - 1;
	for($i=0;$i<$str_len;$i++)
	{
		if($startdd==0) $restr .= $c;
		else if($i > $startdd) $restr .= $c;
		
		if(ord($str[$i])>0x80){
			if($str_len>$i+1) $c = $str[$i].$str[$i+1];
			$i++;
		}
		else{	$c = $str[$i]; }

		if($i >= $enddd){
			if(strlen($restr)+strlen($c)>$slen) break;
			else{ $restr .= $c; break; }
		}
	}
	return $restr;
}
function cn_midstr($str,$start,$len){
	return cn_substr($str,$slen,$startdd);
}

function GetMkTime($dtime)
{
	if(!ereg("[^0-9]",$dtime)) return $dtime;
	$dt = Array(1970,1,1,0,0,0);
	$dtime = ereg_replace("[\r\n\t]|��|��"," ",$dtime);
	$dtime = str_replace("��","-",$dtime);
	$dtime = str_replace("��","-",$dtime);
	$dtime = str_replace("ʱ",":",$dtime);
	$dtime = str_replace("��",":",$dtime);
	$dtime = trim(ereg_replace("[ ]{1,}"," ",$dtime));
	$ds = explode(" ",$dtime);
	$ymd = explode("-",$ds[0]);
	if(isset($ymd[0])) $dt[0] = $ymd[0];
	if(isset($ymd[1])) $dt[1] = $ymd[1];
	if(isset($ymd[2])) $dt[2] = $ymd[2];
	if(strlen($dt[0])==2) $dt[0] = '20'.$dt[0];
	if(isset($ds[1])){
		$hms = explode(":",$ds[1]);
		if(isset($hms[0])) $dt[3] = $hms[0];
		if(isset($hms[1])) $dt[4] = $hms[1];
		if(isset($hms[2])) $dt[5] = $hms[2];
	}
  foreach($dt as $k=>$v){
  	$v = ereg_replace("^0{1,}","",trim($v));
  	if($v=="") $dt[$k] = 0;
  }
	$mt = @mktime($dt[3],$dt[4],$dt[5],$dt[1],$dt[2],$dt[0]);
	if($mt>0) return $mt;
	else return mytime();
}

function SubDay($ntime,$ctime){
	$dayst = 3600 * 24;
	$cday = ceil(($ntime-$ctime)/$dayst);
	return $cday;
}

function AddDay($ntime,$aday){
	$dayst = 3600 * 24;
	$oktime = $ntime + ($aday * $dayst);
	return $oktime;
}

function GetDateTimeMk($mktime){
	if($mktime==""||ereg("[^0-9]",$mktime)) return "";
	return strftime("%Y-%m-%d %H:%M:%S",$mktime);
}

function GetDateMk($mktime){
	if($mktime==""||ereg("[^0-9]",$mktime)) return "";
	return strftime("%Y-%m-%d",$mktime);
}

function GetIP(){
	if(!empty($_SERVER["HTTP_CLIENT_IP"])) $cip = $_SERVER["HTTP_CLIENT_IP"];
	else if(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) $cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
	else if(!empty($_SERVER["REMOTE_ADDR"])) $cip = $_SERVER["REMOTE_ADDR"];
	else $cip = "�޷���ȡ��";
	return $cip;
}
//��ȡһ�������ַ���ƴ�� ishead=0 ʱ�����ȫƴ�� ishead=1ʱ�����ƴ������ĸ
function GetPinyin($str,$ishead=0,$isclose=1){
	if(!isset($GLOBALS['__funAdmin'])) require_once(dirname(__FILE__)."/inc/inc_fun_funAdmin.php");
  return SpGetPinyin($str,$ishead,$isclose);
}

function GetNewInfo(){
	if(!isset($GLOBALS['__funAdmin'])) require_once(dirname(__FILE__)."/inc/inc_fun_funAdmin.php");
  return SpGetNewInfo();
}

function ShowMsg($msg,$gourl,$onlymsg=0,$limittime=0){
		$htmlhead  = "<html>\r\n<head>\r\n<title>��ʾ��Ϣ</title>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\" />\r\n";
		$htmlhead .= "<base target='_self'/>\r\n</head>\r\n<body leftmargin='0' topmargin='0'>\r\n<center>\r\n<script>\r\n";
		$htmlfoot  = "</script>\r\n</center>\r\n</body>\r\n</html>\r\n";
		
		if($limittime==0) $litime = 1000;
		else $litime = $limittime;
		
		if($gourl=="-1"){
			if($limittime==0) $litime = 5000;
			$gourl = "javascript:history.go(-1);";
		}
		
		if($gourl==""||$onlymsg==1){
			$msg = "<script>alert(\"".str_replace("\"","��",$msg)."\");</script>";
		}else{
			$func = "      var pgo=0;
      function JumpUrl(){
        if(pgo==0){ location='$gourl'; pgo=1; }
      }\r\n";
			$rmsg = $func;
			$rmsg .= "document.write(\"<br/><div style='width:400px;padding-top:4px;height:24;font-size:10pt;border-left:1px solid #7ECDFB;border-top:1px solid #7ECDFB;border-right:1px solid #7ECDFB;background-color:#ACE4FF;'>DEDECMS ��ʾ��Ϣ��</div>\");\r\n";
			$rmsg .= "document.write(\"<div style='width:400px;height:100;font-size:10pt;border:1px solid #7ECDFB;background-color:#EEFAFE'><br/><br/>\");\r\n";
			$rmsg .= "document.write(\"".str_replace("\"","��",$msg)."\");\r\n";
			$rmsg .= "document.write(\"";
			if($onlymsg==0){
				if($gourl!="javascript:;" && $gourl!=""){ $rmsg .= "<br/><br/><a href='".$gourl."'>�����������û��Ӧ����������...</a>"; }
				$rmsg .= "<br/><br/></div>\");\r\n";
				if($gourl!="javascript:;" && $gourl!=""){ $rmsg .= "setTimeout('JumpUrl()',$litime);"; }
			}else{ $rmsg .= "<br/><br/></div>\");\r\n"; }
			$msg  = $htmlhead.$rmsg.$htmlfoot;
		}		
		echo $msg;
}

function ExecTime(){ 
	$time = explode(" ", microtime());
	$usec = (double)$time[0]; 
	$sec = (double)$time[1]; 
	return $sec + $usec; 
}

function GetEditor($fname,$fvalue,$nheight="350",$etype="Basic",$gtype="print",$isfullpage="false"){
	if(!isset($GLOBALS['__funAdmin'])) require_once(dirname(__FILE__)."/inc/inc_fun_funAdmin.php");
  return SpGetEditor($fname,$fvalue,$nheight,$etype,$gtype,$isfullpage);
}
//���ָ��λ��ģ���ַ���
function GetTemplets($filename){
	if(file_exists($filename)){
     $fp = fopen($filename,"r");
     $rstr = fread($fp,filesize($filename));
     fclose($fp);
     return $rstr;
	}else{ return ""; }
}
function GetSysTemplets($filename){
	return GetTemplets($GLOBALS['cfg_basedir'].$GLOBALS['cfg_templets_dir'].'/system/'.$filename);
}
//��������Ĭ��ֵ
function AttDef($oldvar,$nv){
 	if(empty($oldvar)) return $nv;
 	else return $oldvar;
}
//�ѷ��Ϲ��������תΪ�ַ�
function dd2char($dd){
  $slen = strlen($dd);
  $okdd = "";
  for($i=0;$i<$slen;$i++){
  	if(isset($dd[$i+1])){
  		$n = $dd[$i].$dd[$i+1];
  		if(($n>96 && $n<123)||($n>64 && $n<91)){ $okdd .= chr($n); $i++; }
  		else $okdd .= $dd[$i];
    }else $okdd .= $dd[$i];
  }
  return $okdd;
}
//��Ĭ�ϲ�������һ��Cookie
function PutCookie($key,$value,$kptime,$pa="/"){
	 global $cfg_cookie_encode,$cfg_pp_isopen,$cfg_basehost;
	 if($cfg_pp_isopen=='0'||!ereg("\.",$cfg_basehost)||!ereg("[a-zA-Z]",$cfg_basehost)){
	   setcookie($key,$value,time()+$kptime,$pa);
	   setcookie($key.'ckMd5',substr(md5($cfg_cookie_encode.$value),0,16),time()+$kptime,$pa);
	 }else{
	 	 $dm = eregi_replace("http://([^\.]*)\.","",$cfg_basehost);
	 	 $dm = ereg_replace("/(.*)","",$dm);
	 	 setcookie($key,$value,time()+$kptime,$pa,$dm);
	   setcookie($key.'ckMd5',substr(md5($cfg_cookie_encode.$value),0,16),time()+$kptime,$pa,$dm);
	 }
}
//ʹCookieʧЧ
function DropCookie($key){
  global $cfg_cookie_encode,$cfg_pp_isopen,$cfg_basehost;
	if($cfg_pp_isopen=='0'||!ereg("\.",$cfg_basehost)||!ereg("[a-zA-Z]",$cfg_basehost)){
    setcookie($key,"",time()-3600000,"/");
	  setcookie($key.'ckMd5',"",time()-3600000,"/");
	}else{
		 $dm = eregi_replace("http://([^\.]*)\.","",$cfg_basehost);
		 $dm = ereg_replace("/(.*)","",$dm);
	 	 setcookie($key,"",time(),"/",$dm);
	   setcookie($key.'ckMd5',"",time(),"/",$dm);
	}
}
//���һ��cookieֵ
function GetCookie($key){
	 global $cfg_cookie_encode;
	 if( !isset($_COOKIE[$key]) || !isset($_COOKIE[$key.'ckMd5']) ) return '';
	 else{
	   if($_COOKIE[$key.'ckMd5']!=substr(md5($cfg_cookie_encode.$_COOKIE[$key]),0,16)) return '';
	   else return $_COOKIE[$key];
	 }
}
//�����֤���ֵ
function GetCkVdValue(){
	@session_start();
	if(isset($_SESSION["dd_ckstr"])) $ckvalue = $_SESSION["dd_ckstr"];
	else $ckvalue = '';
	//DropCookie("dd_ckstr");
	return $ckvalue;
}
//��FTP����һ��Ŀ¼
function FtpMkdir($truepath,$mmode,$isMkdir=true){
	global $cfg_basedir,$cfg_ftp_root,$g_ftpLink;
	OpenFtp();
	$ftproot = ereg_replace($cfg_ftp_root.'$','',$cfg_basedir);
	$mdir = ereg_replace('^'.$ftproot,'',$truepath);
	if($isMkdir) ftp_mkdir($g_ftpLink,$mdir);
	return ftp_site($g_ftpLink,"chmod $mmode $mdir");
}
//��FTP�ı�һ��Ŀ¼��Ȩ��
function FtpChmod($truepath,$mmode){
	return FtpMkdir($truepath,$mmode,false);
}
//��FTP����
function OpenFtp(){
	global $cfg_basedir,$cfg_ftp_host,$cfg_ftp_port;
	global $cfg_ftp_user,$cfg_ftp_pwd,$cfg_ftp_root,$g_ftpLink;
	if(!$g_ftpLink){
		if($cfg_ftp_host==""){
		  echo "�������վ���PHP���ô������ƣ���������FTP����Ŀ¼������������ں�ָ̨��FTP��صı�����";
		  exit();
	  }
		$g_ftpLink = ftp_connect($cfg_ftp_host,$cfg_ftp_port);
	  if(!$g_ftpLink){ echo "����FTPʧ�ܣ�"; exit(); }
	  if(!ftp_login($g_ftpLink,$cfg_ftp_user,$cfg_ftp_pwd)){ echo "��½FTPʧ�ܣ�"; exit(); }
	}
}
//�ر�FTP����
function CloseFtp(){
	global $g_ftpLink;
	if($g_ftpLink) @ftp_quit($g_ftpLink);
}
//ͨ�õĴ���Ŀ¼�ĺ���
function MkdirAll($truepath,$mmode){
	global $cfg_ftp_mkdir,$isSafeMode; 
	if($isSafeMode||$cfg_ftp_mkdir=='��'){ return FtpMkdir($truepath,$mmode); }
	else{
		  if(!file_exists($truepath)){
		  	 mkdir($truepath,0777);
		  	 chmod($truepath,0777);
		  	 return true;
		  }else{
		  	return true;
		  }
  }
}
//ͨ�õĸ���Ŀ¼���ļ�Ȩ�޵ĺ���
function ChmodAll($truepath,$mmode){
	global $cfg_ftp_mkdir,$isSafeMode; 
	if($isSafeMode||$cfg_ftp_mkdir=='��'){ return FtpChmod($truepath,$mmode); }
	else{ return chmod($truepath,'0'.$mmode); }
}

//�������ε�Ŀ¼
function CreateDir($spath,$siterefer="",$sitepath=""){
	if(!isset($GLOBALS['__funAdmin'])) require_once(dirname(__FILE__)."/inc/inc_fun_funAdmin.php");
  return SpCreateDir($spath,$siterefer,$sitepath);
}

//�����û��������ڲ�ѯ���ַ���
function StringFilterSearch($str,$isint=0){
	return $str;
}

//��ԱУ������
//���û������뾭���˺����������ݿ������Ա�
function GetEncodePwd($pwd){
	global $cfg_pwdtype,$cfg_md5len,$cfg_ddsign;
	$cfg_pwdtype = strtolower($cfg_pwdtype);
	if($cfg_pwdtype=='md5'){
		if(empty($cfg_md5len)) $cfg_md5len = 32;
		if($cfg_md5len>=32) return md5($pwd);
		else return substr(md5($pwd),0,$cfg_md5len);
	}else if($cfg_pwdtype=='dd'){
		return DdPwdEncode($pwd,$cfg_ddsign);
	}else{
		return $pwd;
	}
}

//�û�ID������������ַ�����ȫ�Բ���
function TestStringSafe($uid){
	//if(ereg("[><]",$uid)) return false;
	if($uid!=addslashes($uid)) return false;
	return true;
}

//Dede��������㷨
//���ܳ���
function DdPwdEncode($pwd,$sign=''){
	global $cfg_ddsign;
	if($sign=='') $sign = $cfg_ddsign;
	$rtstr = '';
	$plen = strlen($pwd);
	if($plen<10) $plenstr = '0'.$plen;
	else $plenstr = "$plen";
	$sign = substr(md5($sign),0,$plen);
	$poshandle = mt_rand(65,90);
	$rtstr .= chr($poshandle);
	$pwd = base64_encode($pwd);
	if($poshandle%2==0){
		$rtstr .= chr(ord($plenstr[0])+18);
		$rtstr .= chr(ord($plenstr[1])+36);
	}
	for($i=0;$i<strlen($pwd);$i++){
		 if($i < $plen){
		   if($poshandle%2==0) $rtstr .= $pwd[$i].$sign[$i];
		   else $rtstr .= $sign[$i].$pwd[$i];
		 }else{ $rtstr .= $pwd[$i]; }
	}
	if($poshandle%2!=0){
		$rtstr .= chr(ord($plenstr[0])+20);
		$rtstr .= chr(ord($plenstr[1])+25);
	}
	return $rtstr;
}

//���ܳ���
function DdPwdDecode($epwd,$sign=''){
	global $cfg_ddsign;
	$n1=0;
	$n2=0;
	$pwstr='';
	$restr='';
	if($sign=='') $sign = $cfg_ddsign;
	$rtstr = '';
	$poshandle = ord($epwd[0]);
	if($poshandle%2==0){
		$n1 = chr(ord($epwd[1])-18);
		$n2 = chr(ord($epwd[2])-36);
		$pwstr = substr($epwd,3,strlen($epwd)-3);
  }else{
  	$n1 = chr(ord($epwd[strlen($epwd)-2])-20);
		$n2 = chr(ord($epwd[strlen($epwd)-1])-25);
		$pwstr = substr($epwd,1,strlen($epwd)-3);
  }
  $pwdlen = ($n1.$n2)*2;
  $pwstrlen = strlen($pwstr);
  for($i=0;$i<$pwstrlen;$i++){
  	if($i<$pwdlen){
  	  if($poshandle%2==0){ $restr .= $pwstr[$i]; $i++; }
  	  else{ $i++; $restr .= $pwstr[$i]; }
  	}else{ $restr .= $pwstr[$i]; }
  }
  $restr = base64_decode($restr);
	return $restr;
}

?>