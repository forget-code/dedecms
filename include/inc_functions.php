<?
require_once(dirname(__FILE__)."/config_base.php");
//ƴ���Ļ�������
$pinyins = Array();
//
//��õ�ǰ�Ľű���ַ
//
function GetCurUrl()
{
	if(!empty($_SERVER["REQUEST_URI"])){
		$scriptName = $_SERVER["REQUEST_URI"];
		$nowurl = $scriptName;
	}
	else
	{
		$scriptName = $_SERVER["PHP_SELF"];
		if($_SERVER["QUERY_STRING"]=="")
			$nowurl = $scriptName;
		else
			$nowurl = $scriptName."?".$_SERVER["QUERY_STRING"];
	}
	return $nowurl;
}
//
//��ȫ������תΪ�������
//
function GetAlabNum($fnum)
{
	$nums = array("��","��","��","��","��","��","��","��","��","��");
	$fnums = "0123456789";
	for($i=0;$i<=9;$i++)
		$fnum = str_replace($nums[$i],$fnums[$i],$fnum);
	$fnum = ereg_replace("[^0-9\.]|^0{1,}","",$fnum);
	if($fnum=="") $fnum=0;
	return $fnum;
}
//
//ȥ��HTML��Ƿ���
//
function ClearHtml($html)
{
	return trim(preg_replace("/[><]/","",$html));
}
function Text2Html($txt)
{
	$txt = str_replace("  ","��",$txt);
	$txt = str_replace("<","&lt;",$txt);
	$txt = str_replace(">","&gt;",$txt);
	$txt = preg_replace("/[\r\n]{1,}/isU","<br/>\r\n",$txt);
	return $txt;
}
//-----------------------------
//���HTML����ı�
//-----------------------------
function Html2Text($str)
{
  $str = preg_replace("/<sty(.*)\\/style>|<scr(.*)\\/script>|<!--(.*)-->/isU","",$str);
  $alltext = "";
  $start = 1;
  for($i=0;$i<strlen($str);$i++){
    if($start==0 && $str[$i]==">") $start = 1;
    else if($start==1){
     if($str[$i]=="<"){ $start = 0; $alltext .= " "; }
     else if(ord($str[$i])>32) $alltext .= $str[$i];
    }
  }
  $alltext = str_replace("��","",$alltext);
  $alltext = preg_replace("/&([^;&]*)(;|&)/","",$alltext);
  $alltext = preg_replace("/[ ]+/s"," ",$alltext);
  return $alltext;
}
//------------------------------------------
//���Ľ�ȡ
//�����ǰ�˫�ֽ��ַ�Ҳ����һ���ַ�
//���ǣ� "�����й�abcde���ˣ�" 
//����ᱻ������ 12 ���ַ���������PHP����Ϊ�ĵ��ֽڵ�Len
//-------------------------------------------
function cnw_left($str,$len)
{
  return cnw_mid($str,0,$len);
}
function cnw_mid($str,$start,$slen)
{
  $str_len = strlen($str);
  $strs = Array();
  for($i=0;$i<$str_len;$i++){
  	if(ord($str[$i])>0x80)
  	{ $strs[] = $str[$i].$str[$i+1]; $i++;}
  	else
  	{ $strs[] = $str[$i]; }
  }
  $wlen = count($strs);
  if($wlen < $start) return "";
  $restr = "";
  $startdd = $start;
  $enddd = $startdd + $slen;
  for($i=$startdd;$i<$enddd;$i++){
  	if(!isset($strs[$i])) break;
  	$restr .= $strs[$i];
  }
  return $restr;
}
//
//���Ľ�ȡ2�����ֽڽ�ȡģʽ
//
function cn_substr($str,$slen,$startdd=0)
{
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

		if(ord($str[$i])>0x80){ $c = $str[$i].$str[$i+1]; $i++;}
		else{	$c = $str[$i]; }

		if($i >= $enddd){
			if(strlen($restr)+strlen($c)>$slen) break;
			else{ $restr .= $c; break; }
		}
	}
	return $restr;
}

function cn_midstr($str,$start,$len)
{
	return cn_substr($str,$slen,$startdd);
}
//----------------------
//��ʱ��ת��Ϊʱ�������
//---------------------
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
	else return time();
}
//�������ʱ����������
//----------------------
function SubDay($ntime,$ctime)
{
	$dayst = GetMkTime("2006-1-2 0:0:0") - GetMkTime("2006-1-1 0:0:0");
	$cday = ceil(($ntime-$ctime)/$dayst);
	return $cday;
}
//���ָ��ʱ���������ʱ��
//------------------
function AddDay($ntime,$aday)
{
	$dayst = GetMkTime("2006-1-2 0:0:0") - GetMkTime("2006-1-1 0:0:0");
	$oktime = $ntime + ($aday * $dayst);
	return $oktime;
}

//
//��MKTime��ñ�׼��Datatime��ʽ
//
function GetDateTimeMk($mktime)
{
	if($mktime==""||ereg("[^0-9]",$mktime)) return "";
	return strftime("%Y-%m-%d %H:%M:%S",$mktime);
}
//
//��MKTime��ñ�׼��Data
//
function GetDateMk($mktime)
{
	if($mktime==""||ereg("[^0-9]",$mktime)) return "";
	return strftime("%Y-%m-%d",$mktime);
}
//
//��ȡ�ͻ���IP
//
function GetIP()
{
	if(!empty($_SERVER["HTTP_CLIENT_IP"]))
		$cip = $_SERVER["HTTP_CLIENT_IP"];
	else if(!empty($_SERVER["HTTP_X_FORWARDED_FOR"]))
		$cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
	else if(!empty($_SERVER["REMOTE_ADDR"]))
		$cip = $_SERVER["REMOTE_ADDR"];
	else
		$cip = "�޷���ȡ��";
	return $cip;
}
//-------------------------------
//��ȡһ�������ַ���ƴ��
//ishead=0 ʱ�����ȫƴ��
//ishead=1ʱ�����ƴ������ĸ
//��ƴ�����ݿ��Ǳ�׼��GB2312���ݿ�,��֧��gb2312�ַ���
//----------------------------------
function GetPinyin($str,$ishead=0,$isclose=0)
{
	global $pinyins;
	$restr = "";
	$str = trim($str);
	$slen = strlen($str);
	if($slen<2) return $str;
	if(count($pinyins)==0){
		$fp = fopen(dirname(__FILE__)."/data/pinyin.db","r");
		while(!feof($fp)){
			$line = trim(fgets($fp));
			$pinyins[$line[0].$line[1]] = substr($line,3,strlen($line)-3);
		}
		fclose($fp);
	}
	for($i=0;$i<$slen;$i++){
		if(ord($str[$i])>0x80){
			$c = $str[$i].$str[$i+1];
			$i++;
			if(isset($pinyins[$c])){
				if($ishead==0) $restr .= $pinyins[$c];
				else $restr .= $pinyins[$c][0];
			}
			else $restr .= "_";
		}
		else if( eregi("[a-z0-9]",$str[$i]) )
		{	$restr .= $str[$i]; }
		else
		{ $restr .= "_";  }
	}
	if($isclose==0) unset($pinyins);
	return $restr;
}

//-----------------------
//����ָ����Ŀ¼
//-----------------------
function CreateDir($spath){
	$truepath = $GLOBALS["cfg_basedir"];
	$spaths = explode("/",$spath);
	$spath = "";
	foreach($spaths as $spath){
		if($spath=="") continue;
		$spath = trim($spath);
		$truepath .= "/".$spath;
		if(!is_dir($truepath)){
			if(!mkdir($truepath,0777)) return false;
		}
	}
	return true;
}
//--------------------
//���DedeCms������Ϣ
//--------------------
function GetNewInfo()
{
	global $cfg_version;
	$nurl = $_SERVER["HTTP_HOST"];
	if( eregi("[a-z\-]{1,}\.[a-z]{2,}",$nurl) ){ $nurl = urlencode($nurl); }
	else{ $nurl = "test"; }
	$gs = "<iframe name='stafrm' src='http://www.dedecms.com/newinfo.php?version=".urlencode($cfg_version)."&formurl=$nurl' frameborder='0' id='stafrm' width='100%' height='50'></iframe>\r\n";
	return $gs;
}
//-----------------
//��ʾ��Ϣ
//-----------------
function ShowMsg($msg,$gourl,$onlymsg=0,$limittime=0)
{
		$htmlhead  = "<html>\r\n<head>\r\n<title>��ʾ��Ϣ</title>\r\n";
		$htmlhead .= "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\" />\r\n";
		$htmlhead .= "<base target='_self'></head>\r\n<body leftmargin='0' topmargin='0'><center>\r\n<script>\r\n";
		$htmlfoot  = "</script>\r\n</center></body>\r\n</html>\r\n";
		
		if($limittime==0) $litime = 1000;
		else $litime = $limittime;
		
		if($gourl=="-1"){
			if($limittime==0) $litime = 5000;
			$gourl = "javascript:history.go(-1);";
		}
		
		if($gourl==""||$onlymsg==1){
			$msg = "<script>alert(\"".str_replace("\"","��",$msg)."\");</script>";
		}
		else
		{
			$func = "      var pgo=0;
      function JumpUrl(){
        if(pgo==0){
          location='$gourl';
          pgo=1;
        }
      }\r\n";
			$rmsg = $func;
			$rmsg .= "document.write(\"<br/><div style='width:400px;padding-top:4px;height:24;font-size:10pt;border-left:1px solid #cccccc;border-top:1px solid #cccccc;border-right:1px solid #cccccc;background-color:#DBEEBD;'>DEDECMS ��ʾ��Ϣ��</div>\");\r\n";
			$rmsg .= "document.write(\"<div style='width:400px;height:100;font-size:10pt;border:1px solid #cccccc;background-color:#F4FAEB'><br/><br/>\");\r\n";
			$rmsg .= "document.write(\"".str_replace("\"","��",$msg)."\");\r\n";
			$rmsg .= "document.write(\"";
			if($onlymsg==0){
				if($gourl!="javascript:;" && $gourl!=""){ $rmsg .= "<br/><br/><a href='".$gourl."'>�����������û��Ӧ����������...</a>"; }
				$rmsg .= "<br/><br/></div>\");\r\n";
				if($gourl!="javascript:;" && $gourl!=""){ $rmsg .= "setTimeout('JumpUrl()',$litime);"; }
			}
			else{
				$rmsg .= "<br/><br/></div>\");\r\n";
			}
			$msg  = $htmlhead.$rmsg.$htmlfoot;
		}		
		echo $msg;
}
/********************************
//��õ�ǰ��ʱ��,��ȷ������
//(���ڼ���ű�����ʱ��)
*********************************/
function ExecTime(){ 
	$time = explode(" ", microtime());
	$usec = (double)$time[0]; 
	$sec = (double)$time[1]; 
	return $sec + $usec; 
}
//
//��ÿ��ӱ༭������Ĵ���
//
function GetEditor($fname,$fvalue,$nheight="350",$etype="Basic",$gtype="print",$isfullpage="false")
{
	if(!isset($GLOBALS['cfg_html_editor'])) $GLOBALS['cfg_html_editor']='fck';
	if($gtype=="") $gtype = "print";
	if($GLOBALS['cfg_html_editor']=='fck')
	{
	  require_once(dirname(__FILE__)."/FCKeditor/fckeditor.php");
	  $fck = new FCKeditor($fname);
	  $fck->BasePath		= $GLOBALS['cfg_cmspath'].'/include/FCKeditor/' ;
	  $fck->Width		= '100%' ;
	  $fck->Height		= $nheight ;
	  $fck->ToolbarSet	= $etype ;
	  $fck->Config['FullPage'] = $isfullpage;
	  $fck->Value = $fvalue ;
	  if($gtype=="print") $fck->Create();
	  else return $fck->CreateHtml();
  }
	else
	{
		require_once(dirname(__FILE__)."/htmledit/dede_editor.php");
	  $ded = new DedeEditor($fname);
	  $ded->BasePath		= $GLOBALS['cfg_cmspath'].'/include/htmledit/' ;
	  $ded->Width		= '100%' ;
	  $ded->Height		= $nheight ;
	  if($etype=="Member") $ded->ToolbarSet = "member";
	  else if($etype=="Small") $ded->ToolbarSet = "small";
	  else $ded->ToolbarSet = "full";
	  $ded->Value = $fvalue ;
	  if($gtype=="print") $ded->Create();
	  else return $ded->CreateHtml();
	}
}
/*****************************
//���ָ���ĵײ�ģ���ַ���
******************************/
function GetSysTemplets($filename)
{
	$moddir = $GLOBALS["cfg_basedir"].$GLOBALS["cfg_templets_dir"]."/system";
	if(file_exists($moddir."/".$filename)){
     $fp = fopen($moddir."/".$filename,"r");
     $rstr = fread($fp,filesize($moddir."/".$filename));
     fclose($fp);
     return $rstr;
	}
	else
	{ return ""; }
}
/*****************************
//���ָ��λ��ģ���ַ���
******************************/
function GetTemplets($filename)
{
	if(file_exists($filename)){
     $fp = fopen($filename,"r");
     $rstr = fread($fp,filesize($filename));
     fclose($fp);
     return $rstr;
	}
	else
	{ return ""; }
}
?>