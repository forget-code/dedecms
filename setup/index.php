<?
$registerGlobals = @ini_get("register_globals");
$isUrlOpen = @ini_get("allow_url_fopen");
$isMagic = @ini_get("magic_quotes_gpc");
if(!$registerGlobals){
	if(!$isMagic) require_once(dirname(__FILE__)."/config_rglobals_magic.php");
	else require_once(dirname(__FILE__)."/config_rglobals.php");
}
else{
	if(!$isMagic) require_once(dirname(__FILE__)."/config_rglobals_magic.php");
}
function GetDateTimeMk($mktime)
{
	if($mktime==""||ereg("[^0-9]",$mktime)) return "";
	return strftime("%Y-%m-%d %H:%M:%S",$mktime);
}
if(empty($step)) $step = 1;

//��װ����
//---------------------------------------------------
if($step==2)
{
  if(!isset($isnew)) $isnew = 0;
  $conn = mysql_connect($cfg_dbhost,$cfg_dbuser,$cfg_dbpwd) or die("<script>alert('���ݿ���������¼������Ч��\\n\\n�޷��������ݿ⣬�������趨��');history.go(-1);</script>");
  if($isnew==1){
  	mysql_query("CREATE DATABASE ".$cfg_dbname,$conn) or die("<script>alert('�������ݿ�ʧ�ܣ�����Ȩ�޲��㣡');history.go(-1);</script>");;
  }
  mysql_select_db($cfg_dbname) or die("<script>alert('���ݿⲻ���ڣ��������趨��');history.go(-1);</script>");
  mysql_query("SET NAMES 'gbk';",$conn);
  $rs = mysql_query("SELECT VERSION();",$conn);
  $row = mysql_fetch_array($rs);
  $mysql_version = $row[0];
  $mysql_versions = explode(".",trim($mysql_version));
  $mysql_version = $mysql_versions[0].".".$mysql_versions[1];
  
  $fp = fopen(dirname(__FILE__)."/config_base.php","r") or die("<script>alert('��ȡ���ã�����setup/config_base.php �Ƿ�ɶ�ȡ��');history.go(-1);</script>");;
  $configstr = fread($fp,filesize(dirname(__FILE__)."/config_base.php"));
  fclose($fp);
  
  $configstr = str_replace("~dbhost~",$cfg_dbhost,$configstr);
	$configstr = str_replace("~dbname~",$cfg_dbname,$configstr);
	$configstr = str_replace("~dbuser~",$cfg_dbuser,$configstr);
	$configstr = str_replace("~dbpwd~",$cfg_dbpwd,$configstr);
	$configstr = str_replace("~dbprefix~",$cfg_dbprefix,$configstr);
	$configstr = str_replace("~cfg_webname~",$cfg_webname,$configstr);
	$configstr = str_replace("~email~",$email,$configstr);
	$bkdir = "backup_".substr(md5(mt_rand(1000,5000).time().mt_rand(1000,5000)),0,10);
	$configstr = str_replace("~bakdir~",$bkdir,$configstr);
	$configstr = str_replace("~baseurl~",$base_url,$configstr);
	
	$cfg_cmspath = trim(ereg_replace("/{1,}","/",$cfg_cmspath));
	if($cfg_cmspath!="" && !ereg("^/",$cfg_cmspath)) $cfg_cmspath = "/".$cfg_cmspath;
	
	if($cfg_cmspath=="") $indexUrl = "/";
	else $indexUrl = $cfg_cmspath;
	
	$configstr = str_replace("~basepath~",$cfg_cmspath,$configstr);
	$configstr = str_replace("~indexurl~",$indexUrl,$configstr);
	
	$fp = fopen(dirname(__FILE__)."/../include/config_base.php","w") or die("<script>alert('д������ʧ�ܣ�����../includeĿ¼�Ƿ��д�룡');history.go(-1);</script>");;
  $configstr = fwrite($fp,$configstr);
  fclose($fp);
  
  if($setuptype=="update")
  {
  	if($mysql_version < 4.1) $fp = fopen(dirname(__FILE__)."/upsql.txt","r");
  	else $fp = fopen(dirname(__FILE__)."/upsql-4.1.txt","r");
  }
  else
  {
  	if($mysql_version < 4.1) $fp = fopen(dirname(__FILE__)."/sql.txt","r");
  	else $fp = fopen(dirname(__FILE__)."/sql-4.1.txt","r");
  }
  $query = "";
  while(!feof($fp))
	{
		$line = trim(fgets($fp,1024));
		if(ereg(";$",$line)){
			$query .= $line;
			mysql_query(str_replace("#@__",$cfg_dbprefix,$query),$conn);
			$query="";
		}
		else if(!ereg("^//",$line)){
			$query .= $line."\n";
		}
	}
	fclose($fp);
	
	if($setuptype == "new")
	{
	  $adminquery = "INSERT INTO ".$cfg_dbprefix."admin VALUES (1, 10, '$adminuser', '".md5($adminpwd)."', 'admin', 0, '".GetDateTimeMk(time())."', '127.0.0.1');";
	  mysql_query($adminquery,$conn);
  }
	
  @mysql_close($conn);
  
  ShowMsg("������ã���ת���¼��ҳ...","../dede/");
  exit();
}
//-----------------
//��ʾ��Ϣ
//-----------------
function ShowMsg($msg,$gourl,$onlymsg=0,$limittime=0)
{
		$htmlhead  = "<html>\r\n<head>\r\n<title>��ʾ��Ϣ</title>\r\n";
		$htmlhead .= "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\" />\r\n";
		$htmlhead .= "</head>\r\n<body leftmargin='0' topmargin='0'><center>\r\n<script>\r\n";
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
				$rmsg .= "<br/><br/><a href='".$gourl."'>�����������û��Ӧ����������...</a><br/><br/></div>\");\r\n";
				$rmsg .= "setTimeout('JumpUrl()',$litime);";
			}
			else{
				$rmsg .= "<br/><br/></div>\");\r\n";
			}
			$msg  = $htmlhead.$rmsg.$htmlfoot;
		}		
		echo $msg;
}
//--------------------------------------------------

//��ȡ��ʼ����
//----------------------
if(!empty($_SERVER["REQUEST_URI"])){
  $scriptName = $_SERVER["REQUEST_URI"];
}
else{
  $scriptName = $_SERVER["PHP_SELF"];
}
$basepath = eregi_replace("/setup(.*)$","",$scriptName);

if(empty($_SERVER['HTTP_HOST'])) $baseurl = "http://".$_SERVER['HTTP_HOST'];
else $baseurl = "http://".$_SERVER['SERVER_NAME'];

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>֯�����ݹ���ϵͳ DedeCms V3.0 ��װ����</title>
<link href="base.css" rel="stylesheet" type="text/css">
</head>
<body bgColor='#ffffff' leftMargin='0' topMargin='0'>
<table width="80%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#111111" style="BORDER-COLLAPSE: collapse">
  <tr> 
    <td width="100%" height="64" background="img/indextitlebg.gif"><img src="img/indextitle.gif" width="250" height="64"> 
    </td>
  </tr>
  <tr> 
    <td width="100%" height="20" valign="middle" bgcolor="#F9FDF2"> <table width="540" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td><IMG height=14 src="img/book1.gif" width=20>&nbsp; ��װDedeCms</td>
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
            <td width="19%" height="44">&nbsp;Ŀ¼Ȩ�ޣ�</td>
            <td width="81%">�����linux��Unixƽ̨������Ŀ¼����Ϊ���û��ɶ�д������ȫȨ�� 0777 <br>
              ../html<br>
              ../upimg/*<br>
              ../templets/*<br>
              ../special/*<br>
              ../plus/*<br>
              ../include/sessions<br>
              ../include (����װʱ��Ҫ����Ϊ0777)</td>
          </tr>
          <tr bgcolor="#F9FDF2"> 
            <td colspan="2">&nbsp;���ݿ��趨��</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td>&nbsp;���ݿ�������</td>
            <td><input name="cfg_dbhost" type="text" id="cfg_dbhost" value="localhost"></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td>&nbsp;���ݿ����ƣ�</td>
            <td><input name="cfg_dbname" type="text" id="cfg_dbname" value="dedev3"> 
              <input name="isnew" type="checkbox" id="isnew" value="1">
              ���������ݿ�</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td>&nbsp;���ݿ��û���</td>
            <td><input name="cfg_dbuser" type="text" id="cfg_dbuser" value="root"></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td>&nbsp;���ݿ����룺</td>
            <td><input name="cfg_dbpwd" type="text" id="cfg_dbpwd"></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td>&nbsp;���ݿ�ǰ׺��</td>
            <td><input name="cfg_dbprefix" type="text" id="cfg_dbprefix" value="dede_"></td>
          </tr>
          <tr bgcolor="#F9FDF2"> 
            <td colspan="2">&nbsp;����Ա��ʼ���룺���û���������ֻ����ʹ�� [a-z][A-Z][0-9][-][_][@][.]���ڵ��ַ�����</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td>&nbsp;�û�����</td>
            <td><input name="adminuser" type="text" id="adminuser" value="admin"></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td>&nbsp;�ܡ��룺</td>
            <td><input name="adminpwd" type="text" id="adminpwd" value="admin"></td>
          </tr>
          <tr bgcolor="#F9FDF2"> 
            <td colspan="2">&nbsp;�����趨��</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td>��װѡ�</td>
            <td><input name="setuptype" type="radio" value="new" checked>
              ȫ�°�װ 
              <input type="radio" name="setuptype" value="update">
              ��V3��ʽ������</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td colspan="2">������Ǵ�V3��ʽ�������ģ����Բ�������Ա�û��������룬�����������£�<br>
              1���ȱ��� templets/default �ļ�������ļ���<br>
              2���������°���ļ��и��Ǿ��ļ���<br>
              3��������������<br>
              4���ѱ��ݵ�ģ���ļ��������ļ���</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td>&nbsp;��վ���ƣ�</td>
            <td><input name="cfg_webname" type="text" id="cfg_webname"></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td>&nbsp;վ��Email��</td>
            <td><input name="email" type="text" id="email"></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td>&nbsp;��վ��ַ��</td>
            <td><input name="base_url" type="text" id="base_url" value="<?=$baseurl?>" size="35"></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td>&nbsp;CMS��װĿ¼��</td>
            <td><input name="cfg_cmspath" type="text" id="cfg_cmspath" value="<?=$basepath?>"></td>
          </tr>
          <tr bgcolor="#F9FDF2"> 
            <td height="30" colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
                  <td width="14%">&nbsp;</td>
                  <td width="86%"><input name="imageField" type="image" src="img/button_ok.gif" width="60" height="22" border="0"></td>
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
