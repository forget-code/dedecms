<?
if(empty($step)) $step=0;
$s_isreg = @get_cfg_var("register_globals");
if($s_isreg!=1)
{
	if (!empty($_GET)) foreach($_GET AS $key => $value){$$key = $value;}
	if (!empty($_POST)) foreach($_POST AS $key => $value){$$key = $value;}
}
if(empty($setuptype)) $setuptype=0;
function GetConfigFile()
{
	$fp = fopen("config_base.php","r") or die("<script>alert('�����ļ��޷���ȡ���޷�����,��ѵ�ǰĿ¼Ȩ����Ϊ�ɶ�д��');history.go(-1);</script>");
	$configfile = fread($fp,filesize("config_base.php"));
	fclose($fp);
	return $configfile;
}
function SaveConfigFile($str)
{
	$fp = fopen("config_base.php","w") or die("<script>alert('�����ļ��޷�д�룬��ѵ�ǰĿ¼Ȩ����Ϊ�ɶ�д��');history.go(-1);</script>");;
	fwrite($fp,$str);
	fclose($fp);
}
//�������ݿ��ѡ��
if($step==2)
{
	$conn = @mysql_connect($dbhost,$dbuser,$dbpwd) or die("<script>alert('���ݿ���������¼������Ч��\\n\\n�޷��������ݿ⣬�������趨��');history.go(-1);</script>");
	mysql_select_db($dbname) or die("<script>alert('���ݿⲻ���ڣ��������趨��');history.go(-1);</script>");
	$basedir = ereg_replace("/$","",$basedir);
	$basedir = str_replace("\\","",$basedir);
	$basepath = ereg_replace("/$","",trim($basepath));
	if($basepath=="/") $basepath="";
	if($basepath!=""&&!ereg("^/",$basepath)) $basepath="/".$basepath;
	$rbasepath = "";
	if($basepath=="") $rbasepath="/";
	else $rbasepath = $basepath;
	if(!file_exists($basedir.$basepath."/setup/setup.php"))
	{
		echo "<script>alert('��վ��Ŀ¼�����·��û������ȷ��');history.go(-1);</script>";
		exit();
	}
	$phpdir = ereg_replace("/$","",$basepath)."/php";
	$bakdir = "/".ereg_replace("^/|/$","",$bakdir);
	$baktruedir = $phpdir.$bakdir;
	$baseurl = ereg_replace("/$","",$baseurl);
	$artdir = $basepath.ereg_replace("/$","",$artdir);
	$imgviewdir = $basepath.ereg_replace("/$","",$imgviewdir);
	//���Ŀ¼�Ƿ����
	if(!is_dir($basedir.$artdir))
	{ mkdir($basedir.$artdir,0755) or die("<script>alert('����Ŀ¼ $basedir$artdir ʧ�ܣ�');history.go(-1);</script>"); }
	if(!is_dir($basedir.$imgviewdir))
	{ mkdir($basedir.$imgviewdir,0755) or die("<script>alert('����Ŀ¼ $basedir$imgviewdir ʧ�ܣ�');history.go(-1);</script>"); }
	if(!is_dir($basedir.$baktruedir))
	{ mkdir($basedir.$baktruedir,0755) or die("<script>alert('����Ŀ¼ $basedir$baktruedir ʧ�ܣ�');history.go(-1);</script>"); }
	//���������ļ�
	$configstr = GetConfigFile();
	$configstr = str_replace("~dbhost~",$dbhost,$configstr);
	$configstr = str_replace("~dbname~",$dbname,$configstr);
	$configstr = str_replace("~dbuser~",$dbuser,$configstr);
	$configstr = str_replace("~dbpwd~",$dbpwd,$configstr);
	$configstr = str_replace("~webname~",$webname,$configstr);
	$configstr = str_replace("~adminemail~",$adminemail,$configstr);
	//��ʼ��ϵͳ��
	$sqlfiles[0]="newinstallsql.txt";
	$sqlfiles[1]="v2old-upsql.txt";
	$adminquery = "INSERT INTO dede_admin VALUES (1, 10, '$adminname', '".md5($adminpwd)."', '$adminwriter', 0, '0000-00-00 00:00:00', '127.0.0.1');";
	$sqlfile = $sqlfiles[$setuptype];
	$fp = fopen($sqlfile,"r");
	$query = "";
	while($line = fgets($fp,1024))
	{
		$line = trim($line);
		if(ereg(";$",$line))
		{
			$query.=$line;
			mysql_query($query,$conn);
			$query="";
		}
		else if(!ereg("^//",$line))
		{
			$query.=$line;
		}
	}
	fclose($fp);
	if($setuptype==0) mysql_query($adminquery,$conn);
	//
	mysql_close($conn);
	//����Ӧ��Ŀ¼
	$img_dir = $imgviewdir."/uploadimg";
	$ddimg_dir = $imgviewdir."/artlit";
	$userimg_dir = $imgviewdir."/user";
	$soft_dir = $imgviewdir."/uploadsoft";
	$flink_dir = $imgviewdir."/flink";
	if(!is_dir($basedir.$img_dir)) mkdir($basedir.$img_dir,0755);
	if(!is_dir($basedir.$userimg_dir)) mkdir($basedir.$userimg_dir,0755);
	if(!is_dir($basedir.$soft_dir)) mkdir($basedir.$soft_dir,0755);
	if(!is_dir($basedir.$ddimg_dir)) mkdir($basedir.$ddimg_dir,0755);
	if(!is_dir($basedir.$flink_dir)) mkdir($basedir.$flink_dir,0755);
	//////////////////////////////////////////////////////
	if($artdir=="/") $artdir="";
	$configstr = str_replace("~basedir~",$basedir,$configstr);
	$configstr = str_replace("~baseurl~",$baseurl,$configstr);
	$configstr = str_replace("~artdir~",$artdir,$configstr);
	$configstr = str_replace("~phpdir~",$phpdir,$configstr);
	$configstr = str_replace("~bakdir~",$bakdir,$configstr);
	$configstr = str_replace("~imgviewdir~",$imgviewdir,$configstr);
	$configstr = str_replace("~artnametag~",$artnametag,$configstr);
	$configstr = str_replace("~artshortname~",$artshortname,$configstr);
	$configstr = str_replace("~indexurl~",$rbasepath,$configstr);
	SaveConfigFile($configstr);
	copy("config_base.php","../dede/config_base.php");
	if($admindir!="dede")
	{
		rename("../dede","../".$admindir);
		$uadminfiles= Array(
		"../php/config.php",
		"../php/vote.php",
		"../php/viewart.php",
		"../php/list.php",
		"../php/guestbook/config.php",
		"../member/config.php",
		"../index.php"
		);
		foreach($uadminfiles as $key=>$uadminfile)
		{
			$f2 = fopen($uadminfile,"r");
			$fbody = fread($f2,filesize($uadminfile));
			fclose($f2);
			$fbody = str_replace("dede/",$admindir."/",$fbody);
			$f2 = fopen($uadminfile,"w");
			fwrite($f2,$fbody);
			fclose($f2);
		}
	}
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>֯�����ݹ���ϵͳV2.1������</title>
<link href="../base.css" rel="stylesheet" type="text/css">
</head>

<body>
<?
if($step==0)
{
?>
<table width="720"  border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#666666">
  <tr>
    <td height="24" align="center" bgcolor="#6699FF"><b>֯�����ݹ���ϵͳV2.1������</b></td>
  </tr>
  <tr>
    <td height="89" bgcolor="#FFFFFF"><p>������Ϊ����޳������Ŀ�Դ�����Ŀ����ʹ��ʱ����ע�����¼��㣺<br>
        һ���������»��޸��˱�����Ĳ��ݹ��ܣ������������·������������������������ӵ��Ȩ����֯��֮��(www.dedecms.com)��<br>
        ���������������ʹ�õ�����£�����������ҵ�����ҵ���ʵ���;�������ðѱ�����޸ĺ���Ϊ��ҵ������ۣ�<br>
        �������ǽ��ṩ�����ϵ�֧�֣������û��Ա������ʹ����;���κ����Ρ�</p>
      <p>// ֯��֮�ùٷ���վ�� <a href="http://www.dedecms.com" target="_blank">http://www.dedecms.com</a>��<br>
        // ��ʽ������IT����ͼ QQ:2500875<br>
        // Email��dbzllx@21cn.com ���������ʼ�̫�࣬�������뾡����QQ��ϵ���ڹٷ���վ���ԡ�<br>
        <br>
        ��������汾����DedeCms�ɽṹ�����һ���汾������ڷǸ�Ŀ¼��װ�����ܻ���һЩ�����û������������⣬����Ϊһ����Դ��ƽ̨����������Ȼ���д�����֧���ߣ�DedeCms��δ���汾DedeCmsV3.0��Ҳ�����Ǳ�����ƣ���������һ�����մ���������CMSƽ̨���ŵ㣬���Խṹ������ƹ���һ���������ݹ���ƽ̨�����Ը�����Ȼ����ѵģ��ڽ���������������һ������Զ��PHP����Զ�Ŀ�Դƽ̨��</p>
      <p>//////////////////////////////////////////////////////////////<br>
        DedeCms ֯�����ݹ���ϵͳV2.1������ For PHP4<br>
        //////////////////////////////////////////////////////////////<br>
        ������Ҫ��İ�װƽ̨:</p>
      <p>[1]PHP ����4.1.0 �汾,С��5.0�汾(Ҫ�����GD��),Apache��IIS�ĸ���ģʽ���ɰ�װ<br>
        [2]��̨�������ʹ�� IE 5.5 ���ϰ汾�������<br>
        [3]���뿪�ţ�ini_get()��mysql_pconnect()��dir()��fopen()������������1.6���ϵ�GD��</p>
      <p>V2.1�����汾���ܸĽ�˵��</p>
      <p>[1] ������֪����ҪBug<br>
	[2] ����ʹ�ö�̬�б�Ĺ���,����Ӧ��ͬ�û�������<br>
	[3] ϸ�����б����Ĺ���<br>
	[4] ������Ƶ����ҳĬ�ϵİ��ģ��,�Է�����߲�ε�Ӧ��<br>
	[5] �����˿��԰�����ʱ������½��й鵵�Ĺ���<br>
	[6] �����˵���Discuz��PHPWIND��VBB��PHPBB ��̳�������ӵİ�����<br>
	[7] �����˿�ѡ�Ķ�̬��ҳ<br>
	[8] �����˿��Ի�ֱ��ȡϵͳ���õ�{dede:extern name='var'/}���<br>
	[9] ��������Ŀ���ƶ�����<br>
	[10] ������loop���,�������ɻ�ȡ����������<br>
	[11] ��ǿ�����ݱ��ݵĹ���<br>
	[12] ������ϵͳ�����˵��Ľ���<br>
        <br>
        <font color="#FF0000">Ŀ¼Ȩ��Ҫ��</font><font color="#FF0000"><br>
        ../ </font>dedecms�ĸ�Ŀ¼�ɶ�д<font color="#FF0000"></font><font color="#FF0000"><br>
        ../php </font>PHP����Ŀ¼�ɶ�д<font color="#FF0000"><br>
        ../php/guestbook </font>���Բ�Ŀ¼�ɶ�д<font color="#FF0000"><br>
        ../dede </font>����Ŀ¼�ɶ�д<font color="#FF0000"></font> (��װ���ɸ���Ϊֻ��Ȩ��)<font color="#FF0000"><br>
        ../member </font>��ԱĿ¼�ɶ�д (��װ���ɸ���Ϊֻ��Ȩ��)<font color="#FF0000"><br>
        </font>�����ļ���Ҫ��ɶ�д<font color="#FF0000"> <br>
        ./config_base.php</font><font color="#FF0000"><br>
        ../php/config.php<br>
        ../php/vote.php<br>
        ../php/viewart.php<br>
        ../php/list.php<br>
        ../php/guestbook/config.php<br>
        ../member/config.php<br>
        ../index.php</font></p>
      <p><br>
        <br>
      </p>
      </td>
  </tr>
  <tr>
    <td height="26" align="center" bgcolor="#6699FF"><p>
      <input type="button" name="bt0" value="�����Ķ�������˵����������ʽ��װ" onClick="location='setup.php?step=1';">
    </p>      </td>
  </tr>
</table>
<?
}
else if($step==1)
{
?>
<form action="setup.php" name="form1" method="post">
 <input type="hidden" name="step" value="2">
  <table width="720" border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#666666">
    <tr> 
      <td height="24" colspan="2" align="center" bgcolor="#6699FF"><b>MySql���ݿⰲװ�ͻ����趨</b></td>
    </tr>
    <tr> 
      <td height="24" colspan="2" bgcolor="#FFFFFF">[1]��ע�⣺���򲻻��Զ��������ݿ⣬�������н������ݿ��ٰ�װ��<br>
        [2]�������鰲װ�ڸ�Ŀ¼������㲻���ڸ�Ŀ¼��װ����ȻϵͳҲ������ʹ�ã���ģ������/php��/member��ʾ�����ӽ�ȫ��Ҫ�ֶ����ģ�<font color='red'>������һ��ʹ�ñ�ϵͳ��ǿ�ҽ�����ѱ�����װ����Ŀ¼��������ܻ��в���Ԥ֪�Ĵ���</font>��</td>
    </tr>
    <tr> 
      <td width="152" height="24" align="right" bgcolor="#FFFFFF">���ݷ�������</td>
      <td width="561" bgcolor="#FFFFFF"><input name="dbhost" type="text" id="dbhost" value="localhost" size="30"></td>
    </tr>
    <tr> 
      <td height="24" align="right" bgcolor="#FFFFFF">���ݿ����ƣ�</td>
      <td bgcolor="#FFFFFF"><input name="dbname" type="text" id="dbname" size="30"></td>
    </tr>
    <tr> 
      <td height="24" align="right" bgcolor="#FFFFFF">���ݿ��¼�û���</td>
      <td bgcolor="#FFFFFF"><input name="dbuser" type="text" id="dbuser" size="30"></td>
    </tr>
    <tr> 
      <td height="24" align="right" bgcolor="#FFFFFF">���ݿ��¼���룺</td>
      <td bgcolor="#FFFFFF"><input name="dbpwd" type="text" id="dbpwd" size="30"></td>
    </tr>
    <tr> 
      <td height="24" align="right" bgcolor="#FFFFFF">���ݱ�ǰ׺��</td>
      <td bgcolor="#FFFFFF">dede_</td>
    </tr>
    <tr> 
      <td height="24" align="right" bgcolor="#FFFFFF">��װѡ�</td>
      <td bgcolor="#FFFFFF"><input name="setuptype" type="radio" value="0" checked>
        ȫ�°�װ 
        <input type="radio" name="setuptype" value="1">
        ��2.0������</td>
    </tr>
    <tr> 
      <td height="24" align="right" bgcolor="#FFFFFF">��������Ա���ƣ�</td>
      <td bgcolor="#FFFFFF"><input name="adminname" type="text" id="adminname" value="admin"></td>
    </tr>
    <tr> 
      <td height="24" align="right" bgcolor="#FFFFFF">��������Ա���룺</td>
      <td bgcolor="#FFFFFF"><input name="adminpwd" type="text" id="adminpwd" value="admin"></td>
    </tr>
    <tr> 
      <td height="24" align="right" bgcolor="#FFFFFF">����Ա������</td>
      <td bgcolor="#FFFFFF"><input name="adminwriter" type="text" id="adminwriter" value="admin"></td>
    </tr>
    <tr> 
      <td height="24" align="right" bgcolor="#FFFFFF">��վ���ƣ�</td>
      <td bgcolor="#FFFFFF"><input name="webname" type="text" id="webname" value="֯��֮��"></td>
    </tr>
    <tr> 
      <td height="24" align="right" bgcolor="#FFFFFF">����ԱEmail��</td>
      <td bgcolor="#FFFFFF"><input name="adminemail" type="text" id="adminemail" value="dbzllx@21cn.com"></td>
    </tr>
  </table>
<br>
  <table width="720" border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#666666">
    <tr> 
      <td height="24" colspan="2" align="center" bgcolor="#6699FF"><b>�ļ�Ŀ¼�����������趨</b></td>
    </tr>
    <tr> 
      <td width="145" height="24" align="right" bgcolor="#FFFFFF">��վ��Ŀ¼��</td>
	  <?
	  $acpath="";
	  $bdir="";
	  
	  if(isset($_SERVER["SCRIPT_NAME"])) 
	  	$script_name = $_SERVER["SCRIPT_NAME"];
	  if(!eregi("setup",$script_name) && isset($_SERVER["PHP_SELF"]))
	  	$script_name = $_SERVER["PHP_SELF"];
	  if(!eregi("setup",$script_name) && isset($_SERVER["REQUEST_URI"]))
	  	$script_name = $_SERVER["REQUEST_URI"];
	  $acpath =	str_replace("/setup/setup.php","",$script_name); 
	  
	  $now_dir = @dirname(__FILE__);
	  if($now_dir=="") $now_dir = @getcwd();
	  $bdir = $now_dir;
	  $bdir = str_replace("\\","/",$bdir);
	  $bdir = str_replace("$acpath/setup","",$bdir);
	  ?>
      <td width="568" bgcolor="#FFFFFF"> <input name="basedir" type="text" id="basedir" value="<?=$bdir?>" size="30">
        �������Ǳ���ģ�����㲻��ȷ�������վ��Ŀ¼�������������ϵ��
      </td>
    </tr>
    <tr> 
      <td height="24" align="right" bgcolor="#FFFFFF">��վ����ַ��</td>
      <td bgcolor="#FFFFFF"><input name="baseurl" type="text" id="baseurl" value="http://<?if(isset($_SERVER["HTTP_HOST"])) echo $_SERVER["HTTP_HOST"];?>" size="30">
      </td>
    </tr>
    <tr> 
      <td height="24" align="right" bgcolor="#FFFFFF">DedeCms��Ŀ¼��</td>
      <td bgcolor="#FFFFFF">
	  <input name="basepath" type="text" id="basepath" value="<?=$acpath?>" size="30">
        ���ձ�ʾ��Ŀ¼��<br>
        ���簲װ�ļ���ַΪ��http://test.com/dede2005/setup/setup.php ��ô���·��Ϊ��/dede2005 </td>
    </tr>
    <tr> 
      <td width="145" height="24" align="right" bgcolor="#FFFFFF">���´��Ŀ¼��</td>
      <td width="568" bgcolor="#FFFFFF">DedeCmsĿ¼��<input name="artdir" type="text" id="artdir" value="/html" size="30">
        &nbsp;&nbsp;���ձ�ʾ��Ŀ¼��</td>
    </tr>
    <tr> 
      <td height="24" align="right" bgcolor="#FFFFFF">���±�����ʽ��</td>
      <td bgcolor="#FFFFFF"> <input name="artnametag" type="text" id="artnametag" size="30" value="listdir"> 
        <br>
        //[1] listdir ��ʾ����Ŀ��Ŀ¼���� ID.htm ����ʽ�����ļ�<br>
        //[2] maketime ��ʾ�� ���´��Ŀ¼/year/monthday/ID �������ļ�</td>
    </tr>
    <tr> 
      <td height="24" align="right" bgcolor="#FFFFFF">������չ����</td>
      <td bgcolor="#FFFFFF"><input name="artshortname" type="text" id="artshortname" value=".html" size="20"></td>
    </tr>
    <tr> 
      <td height="24" align="right" bgcolor="#FFFFFF">�ϴ����ļ���Ÿ�Ŀ¼��<br>
        ��ͼƬ������ĸ�Ŀ¼��<br></td>
      <td bgcolor="#FFFFFF">DedeCmsĿ¼��<input name="imgviewdir" type="text" id="imgviewdir" value="/ddimg" size="20"> 
        &nbsp;(&quot;/&quot;��ʾ��Ŀ¼��������Ҫ��&quot;/&quot;)</td>
    </tr>
    <tr> 
      <td height="24" align="right" bgcolor="#FFFFFF">���ݱ���Ŀ¼��</td>
      <td bgcolor="#FFFFFF">DedeCmsĿ¼��/php/ 
        <input name="bakdir" type="text" id="bakdir" value="bak" size="15"> &nbsp;<font color="#FF0000">(����������ƣ�������Ҫ��&quot;/&quot;)</font></td>
    </tr>
    <tr> 
      <td height="24" align="right" bgcolor="#FFFFFF">����Ŀ¼��</td>
      <td bgcolor="#FFFFFF">DedeCmsĿ¼��/ 
        <input name="admindir" type="text" id="admindir" value="dede" size="15"> 
        <font color="#FF0000">(����������ƣ�������Ҫ��&quot;/&quot;)</font></td>
    </tr>
    <tr> 
      <td height="26" colspan="2" align="center" bgcolor="#6699FF"> <input type="submit" name="bt0" value="���棬��������һ����װ"> 
      </td>
    </tr>
  </table>
</form>
<?
}
else if($step==2)
{
?>
<table width="356" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
  <form name="form1" id="form1" action="../<?=$admindir?>/loginok.php" method="post">
  <tr>
      <td width="354" height="25" align="center" bgcolor="#F6F6F6" style="font-size:10pt"><strong>��¼ϵͳ(��ɾ��setup�ļ��У������´��޷���¼)</strong></td>
  </tr>
  <tr>
    <td height="31" bgcolor="#FFFFFF">
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td colspan="3" height="15"></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td width="23%" height="24" style="font-size:10pt">�û���:</td>
          <td width="72%" height="24"><input name="userid" type="text" id="userid" style="width:160"></td>
        </tr>
        <tr>
          <td colspan="3" height="10"></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td height="24" style="font-size:10pt">�ܡ���:</td>
          <td height="24"><input name="pwd" type="password" id="pwd" style="width:160"></td>
        </tr>
        <tr>
          <td colspan="3" height="10"></td>
        </tr>
        <tr align="center">
          <td height="42" colspan="3">&nbsp;
              <input type="submit" name="Submit" value=" �� ¼ ">
&nbsp; </td>
        </tr>
        <tr>
          <td colspan="3" height="10"></td>
        </tr>
    </table></td>
  </tr>
  </form>
</table>
<?
}
?>
</body>
</html>
