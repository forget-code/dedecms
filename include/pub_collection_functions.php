<?php 
//���ļ�������չ�ɼ����
//���ؾ���http 1.1Э��ķ�����ͼƬ
//------------------------------------
function DownImageKeep($gurl,$rfurl,$filename,$gcookie="",$JumpCount=0,$maxtime=30){
   $urlinfos = GetHostInfo($gurl);
   $ghost = $urlinfos['host'];
   $gquery = $urlinfos['query'];
   if($gcookie=="") $gcookie = RefurlCookie($rfurl);
   $sessionQuery = "GET $gquery HTTP/1.1\r\n";
   $sessionQuery .= "Host: $ghost\r\n";
   $sessionQuery .= "Referer: $rfurl\r\n";
   $sessionQuery .= "Accept: */*\r\n";
   $sessionQuery .= "User-Agent: Mozilla/4.0 (compatible; MSIE 5.00; Windows 98)\r\n";
   if($gcookie!=""&&!ereg("[\r\n]",$gcookie)) $sessionQuery .= $gcookie."\r\n";
   $sessionQuery .= "Connection: Keep-Alive\r\n\r\n";
   $errno = "";
   $errstr = "";
   $m_fp = fsockopen($ghost, 80, $errno, $errstr,10);
   fwrite($m_fp,$sessionQuery);
   $lnum = 0;
   //��ȡ��ϸӦ��ͷ
   $m_httphead = Array();
	 $httpstas = explode(" ",fgets($m_fp,256));
	 $m_httphead["http-edition"] = trim($httpstas[0]);
   $m_httphead["http-state"] = trim($httpstas[1]);
	 while(!feof($m_fp)){
			$line = trim(fgets($m_fp,256));
			if($line == "" || $lnum>100) break;
			$hkey = "";
			$hvalue = "";
			$v = 0;
			for($i=0;$i<strlen($line);$i++){
				if($v==1) $hvalue .= $line[$i];
				if($line[$i]==":") $v = 1;
				if($v==0) $hkey .= $line[$i];
			}
			$hkey = trim($hkey);
			if($hkey!="") $m_httphead[strtolower($hkey)] = trim($hvalue);
	 }
	 //�������ؼ�¼
	 if(ereg("^3",$m_httphead["http-state"])){
	 	  if(isset($m_httphead["location"]) && $JumpCount<3){
	 	  	$JumpCount++;
	 	  	DownImageKeep($gurl,$rfurl,$filename,$gcookie,$JumpCount);
	 	  }
	 	  else{ return false; }
	 }
	 if(!ereg("^2",$m_httphead["http-state"])){
	 	  return false;
	 }
	 if(!isset($m_httphead)) return false;
	 $contentLength = $m_httphead['content-length'];
	 //�����ļ�
	 $fp = fopen($filename,"w") or die("д���ļ���{$filename} ʧ�ܣ�");
	 $i=0;
	 $okdata = "";
	 $starttime = time();
	 while(!feof($m_fp)){
			$okdata .= fgetc($m_fp);
			$i++;
			//��ʱ����
			if(time()-$starttime>$maxtime) break;
			//����ָ����С����
			if($i >= $contentLength) break;
	 }
	 if($okdata!="") fwrite($fp,$okdata);
	 fclose($fp);
	 if($okdata==""){
	 	  @unlink($filename);
	 	  fclose($m_fp);
	    return false;
	 }
	 fclose($m_fp);
	 return true;
}
//���ĳҳ�淵�ص�Cookie��Ϣ
//----------------------------
function RefurlCookie($gurl){
	$urlinfos = GetHostInfo($gurl);
  $ghost = $urlinfos['host'];
  $gquery = $urlinfos['query'];
  $sessionQuery = "GET $gquery HTTP/1.1\r\n";
  $sessionQuery .= "Host: $ghost\r\n";
  $sessionQuery .= "Accept: */*\r\n";
  $sessionQuery .= "User-Agent: Mozilla/4.0 (compatible; MSIE 5.00; Windows 98)\r\n";
  $sessionQuery .= "Connection: Close\r\n\r\n";
  $errno = "";
  $errstr = "";
  $m_fp = fsockopen($ghost, 80, $errno, $errstr,10);
  fwrite($m_fp,$sessionQuery);
  $lnum = 0;
  //��ȡ��ϸӦ��ͷ
  $gcookie = "";
	while(!feof($m_fp)){
			$line = trim(fgets($m_fp,256));
			if($line == "" || $lnum>100) break;
			else{
				if(eregi("^cookie",$line)){
					$gcookie = $line;
					break;
				}
			}
	 }
   fclose($m_fp);
   return $gcookie;
}
//�����ַ��host��query����
//-------------------------------------
function GetHostInfo($gurl){
	$gurl = eregi_replace("^http://","",$gurl);
	$garr['host'] = eregi_replace("/(.*)$","",$gurl);
	$garr['query'] = "/".eregi_replace("^([^/]*)/","",$gurl);
	return $garr;
}
//HTML���ͼƬתDEDE��ʽ
//-----------------------------------
function TurnImageTag($ttx){
   preg_match_all('/src="(.+?)"/is',$ttx,$match);
   for($i=0;$i<count($match[1]);$i++){
     $tx .="{dede:img text='' }".$match[1][$i]." {/dede:img}"."\r\n";
   }
   $ttx="{dede:pagestyle maxwidth='800' ddmaxwidth='150' row='3' col='3' value='3'/}\r\n".$tx;
   return $ttx;
}
?>