<?
//��� Global �� Magic ����
$needFilter = false;
$registerGlobals = @ini_get("register_globals");
$isMagic = @ini_get("magic_quotes_gpc");
if(!$isMagic) require_once(dirname(__FILE__)."/../include/config_rglobals_magic.php");
else if(!$registerGlobals) require_once(dirname(__FILE__)."/../include/config_rglobals.php");
require_once(dirname(__FILE__)."/../include/inc_functions.php");
//-----------------------------------------
if(empty($step)) $step = 1;
if($step==1){ //��ȡ��ʼ����
  if(!empty($_SERVER["REQUEST_URI"])){$scriptName = $_SERVER["REQUEST_URI"]; }
  else{ $scriptName = $_SERVER["PHP_SELF"]; }
  $basepath = eregi_replace("/setup(.*)$","",$scriptName);
  if(empty($_SERVER['HTTP_HOST'])) $baseurl = "http://".$_SERVER['HTTP_HOST'];
  else $baseurl = "http://".$_SERVER['SERVER_NAME'];
  
  $rnd_cookieEncode = chr(mt_rand(ord('A'),ord('Z'))).chr(mt_rand(ord('a'),ord('z'))).chr(mt_rand(ord('A'),ord('Z'))).chr(mt_rand(ord('A'),ord('Z'))).chr(mt_rand(ord('a'),ord('z'))).mt_rand(1000,9999).chr(mt_rand(ord('A'),ord('Z')));
  
}
else if($step==2){ //��װ����
  if(!isset($isnew)) $isnew = 0;
  $conn = mysql_connect($cfg_dbhost,$cfg_dbuser,$cfg_dbpwd) or die("<script>alert('���ݿ���������¼������Ч��\\n\\n�޷��������ݿ⣬�������趨��');history.go(-1);</script>");
  if($isnew==1){
  	mysql_query("CREATE DATABASE ".$cfg_dbname,$conn) or die("<script>alert('�������ݿ�ʧ�ܣ�����Ȩ�޲��㣬��ָ��һ���Ѵ����õ����ݿ⣡');history.go(-1);</script>");
  }
  mysql_select_db($cfg_dbname) or die("<script>alert('���ݿⲻ���ڣ��������趨��');history.go(-1);</script>");
  mysql_query("SET NAMES '$dblang';",$conn);
  $rs = mysql_query("SELECT VERSION();",$conn);
  $row = mysql_fetch_array($rs);
  $mysql_version = $row[0];
  $mysql_versions = explode(".",trim($mysql_version));
  $mysql_version = $mysql_versions[0].".".$mysql_versions[1];
  
  $fp = fopen(dirname(__FILE__)."/config_base.php","r") or die("<script>alert('��ȡ���ã�����setup/config_base.php �Ƿ�ɶ�ȡ��');history.go(-1);</script>");;
  $configstr1 = fread($fp,filesize(dirname(__FILE__)."/config_base.php"));
  fclose($fp);
  
  $fp = fopen(dirname(__FILE__)."/config_hand.php","r") or die("<script>alert('��ȡ���ã�����setup/config_base.php �Ƿ�ɶ�ȡ��');history.go(-1);</script>");;
  $configstr2 = fread($fp,filesize(dirname(__FILE__)."/config_hand.php"));
  fclose($fp);
  
  //config_base.php
  $configstr1 = str_replace("~dbhost~",$cfg_dbhost,$configstr1);
	$configstr1 = str_replace("~dbname~",$cfg_dbname,$configstr1);
	$configstr1 = str_replace("~dbuser~",$cfg_dbuser,$configstr1);
	$configstr1 = str_replace("~dbpwd~",$cfg_dbpwd,$configstr1);
	$configstr1 = str_replace("~dbprefix~",$cfg_dbprefix,$configstr1);
  $configstr1 = str_replace("~dblang~",$dblang,$configstr1);
  
  $fp = fopen(dirname(__FILE__)."/../include/config_base.php","w") or die("<script>alert('д������ʧ�ܣ�����../includeĿ¼�Ƿ��д�룡');history.go(-1);</script>");
  fwrite($fp,$configstr1);
  fclose($fp);

	//config_hand.php
	$cfg_cmspath = trim(ereg_replace("/{1,}","/",$cfg_cmspath));
	if($cfg_cmspath!="" && !ereg("^/",$cfg_cmspath)) $cfg_cmspath = "/".$cfg_cmspath;
	
	if($cfg_cmspath=="") $indexUrl = "/";
	else $indexUrl = $cfg_cmspath;
	
	$configstr2 = str_replace("~baseurl~",$base_url,$configstr2);
	$configstr2 = str_replace("~basepath~",$cfg_cmspath,$configstr2);
	$configstr2 = str_replace("~indexurl~",$indexUrl,$configstr2);
	$configstr2 = str_replace("~cookieEncode~",$cookieEncode,$configstr2);
	
	$fp = fopen(dirname(__FILE__)."/../include/config_hand.php","w") or die("<script>alert('д������ʧ�ܣ�����../includeĿ¼�Ƿ��д�룡');history.go(-1);</script>");
  fwrite($fp,$configstr2);
  fclose($fp);
  
  $fp = fopen(dirname(__FILE__)."/../include/config_hand_bak.php","w");
  fwrite($fp,$configstr2);
  fclose($fp);
  
  if($mysql_version < 4.1) $fp = fopen(dirname(__FILE__)."/sql_4_0.txt","r");
  else $fp = fopen(dirname(__FILE__)."/sql_4_1.txt","r");
  
  //�������ݱ��д������
  $query = "";
  while(!feof($fp))
	{
		$line = trim(fgets($fp,1024));
		if(ereg(";$",$line)){
			$query .= $line;
			if($mysql_version < 4.1) mysql_query(str_replace("#@__",$cfg_dbprefix,$query),$conn);
			else mysql_query(str_replace("#~lang~#",$dblang,str_replace("#@__",$cfg_dbprefix,$query)),$conn);
			$query="";
		}else if(!ereg("^//",$line)){
			$query .= $line."\n";
		}
	}
	fclose($fp);
	
	$adminquery = "INSERT INTO `{$cfg_dbprefix}admin` VALUES (1, 10, '$adminuser', '".substr(md5($adminpwd),0,24)."', 'admin', '', '', 0, '".GetDateTimeMk(time())."', '127.0.0.1');";
	mysql_query($adminquery,$conn);
	$adminquery = "Update `{$cfg_dbprefix}sysconfig` set value='{$base_url}' where varname='cfg_basehost';";
	mysql_query($adminquery,$conn);
	$adminquery = "Update `{$cfg_dbprefix}sysconfig` set value='{$cfg_cmspath}' where varname='cfg_cmspath';";
	mysql_query($adminquery,$conn);
	$adminquery = "Update `{$cfg_dbprefix}sysconfig` set value='{$indexUrl}' where varname='cfg_indexurl';";
	mysql_query($adminquery,$conn);
	$adminquery = "Update `{$cfg_dbprefix}sysconfig` set value='{$cookieEncode}' where varname='cfg_cookie_encode';";
	mysql_query($adminquery,$conn);
	
  @mysql_close($conn);
  
  ShowMsg("������ã���ת���¼��ҳ...","../dede/login.php");
  exit();
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>֯�����ݹ���ϵͳ DedeCms V3.1 ��װ����</title>
<link href="base.css" rel="stylesheet" type="text/css">
</head>
<body bgColor='#ffffff' leftMargin='0' topMargin='0'>
<table width="80%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#111111" style="BORDER-COLLAPSE: collapse">
  <tr> 
    <td width="100%" height="64" background="img/indextitlebg.gif">
    <a href="http://www.dedecms.com"><img src="img/df_dedetitle.gif" width="178" height="53" border="0"></a>
    </td>
  </tr>
  <tr> 
    <td width="100%" height="20" valign="middle" bgcolor="#F9FDF2"> <table width="540" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td>
          	<IMG height=14 src="img/book1.gif" width=20>&nbsp; ��װ DedeCms V3.1 ��
          </td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td width="100%" height="1" background="img/sp_bg.gif"></td>
  </tr>
  <tr> 
    <td width="100%" height="2"></td>
  </tr>
  <form name="form1" method="post" action="index.php">
    <input type="hidden" name="step" value="2">
    <tr> 
      <td width="100%" valign="top"> <table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#EEF9D9">
          <tr bgcolor="#FFFFFF"> 
            <td width="19%" height="87">&nbsp;Ŀ¼Ȩ�ޣ�</td>
            <td width="81%">
            	�����linux��Unixƽ̨������Ŀ¼���ֹ���FTP����Ϊ���û��ɶ�д������ȫȨ�� 0777 <br>
              ../include<br>
              ../dede/templets<br>
              �ڰ�װ�걾��������ں�̨����һ��DedeCmsĿ¼Ȩ�޼��
              </td>
          </tr>
          <tr bgcolor="#F9FDF2"> 
            <td colspan="2">&nbsp;���ݿ��趨��</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="24">&nbsp;���ݿ�������</td>
            <td><input name="cfg_dbhost" type="text" id="cfg_dbhost" value="localhost"></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="24">&nbsp;���ݿ����ƣ�</td>
            <td><input name="cfg_dbname" type="text" id="cfg_dbname" value="dedev3_1"> 
              <input name="isnew" type="checkbox" id="isnew" value="1">
              ���������ݿ�</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="24">&nbsp;���ݿ��û���</td>
            <td><input name="cfg_dbuser" type="text" id="cfg_dbuser" value="root"></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="24">&nbsp;���ݿ����룺</td>
            <td><input name="cfg_dbpwd" type="text" id="cfg_dbpwd"></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="24">&nbsp;���ݿ�ǰ׺��</td>
            <td><input name="cfg_dbprefix" type="text" id="cfg_dbprefix" value="dede_"></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="24">&nbsp;���ݿ���룺</td>
            <td><input name="dblang" type="radio" value="gbk" checked>
              GBK 
              <input type="radio" name="dblang" value="latin1">
              LATIN1 ������4.1+���ϰ汾��MySqlѡ��</td>
          </tr>
          <tr bgcolor="#F9FDF2"> 
            <td colspan="2">&nbsp;����Ա��ʼ���룺</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="24">&nbsp;�û�����</td>
            <td><input name="adminuser" type="text" id="adminuser" value="admin"></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="24">&nbsp;�ܡ��룺</td>
            <td><input name="adminpwd" type="text" id="adminpwd" value="admin"></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="24">&nbsp;Cookie�����룺</td>
            <td><input name="cookieEncode" type="text" id="cookieEncode" value="<?=$rnd_cookieEncode?>"></td>
          </tr>
          <tr bgcolor="#F9FDF2"> 
            <td colspan="2">&nbsp;�����趨��</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="24">&nbsp;��վ��ַ��</td>
            <td><input name="base_url" type="text" id="base_url" value="<?=$baseurl?>" size="35"></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="24">&nbsp;CMS��װĿ¼��</td>
            <td><input name="cfg_cmspath" type="text" id="cfg_cmspath" value="<?=$basepath?>">
              ���ڸ�Ŀ¼��װʱ������ᣩ </td>
          </tr>
          <tr bgcolor="#F9FDF2"> 
            <td height="30" colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
                  <td width="14%" height="35">&nbsp;</td>
                  <td width="86%"><input name="imageField" type="image" src="img/button_ok.gif" width="60" height="22" border="0"></td>
                </tr>
                <tr align="right" bgcolor="#FFFFFF"> 
                  <td height="80" colspan="2"><img src="py/p5.gif" width="43" height="41"><img src="py/p4.gif" width="43" height="41"><img src="py/p3.gif" width="43" height="41"><img src="py/p2.gif" width="43" height="41"><img src="py/p1.gif" width="43" height="41"></td>
                </tr>
              </table></td>
          </tr>
        </table> </td>
    </tr>
  </form>
  <tr> 
    <td width="100%" height="2" valign="top"></td>
  </tr>
</table>
<p align="center">
<a href='http://www.dedecms.com' target='_blank'>Power by DedeCms ֯�����ݹ���ϵͳ</a><br><br>
</p>
</body>
</html>
