<?
//��һ��Ҫ�������ֹ���������,����һ������ļ�������õ�ʹ�ñ�ϵͳ���а�����

$registerGlobals = @ini_get("register_globals");
$isUrlOpen = @ini_get("allow_url_fopen");

if(!$registerGlobals) require_once("register_extern.php");

//��վ��Ŀ¼�ľ���·����վ����ַ

$base_dir="~basedir~";
$base_url = "~baseurl~";

//���ݿ�������Ϣ
$dbname = "~dbname~";
$dbhost = "~dbhost~";
$dbusername = "~dbuser~";
$dbuserpwd = "~dbpwd~";

//��ҳ��ҳ���Ӻ�����
$index_url="~indexurl~";
$index_name="��ҳ";

//��վ���ƣ�RSS�б���,�������������Ϊ��վ������
$webname = "~webname~"; 

//ͳ����Ա��Email,��վ�뷢���йصĳ���������Email
$admin_email = "~adminemail~";

//���µ�·�������鰴Ĭ�ϣ����Ҫ���ģ�����Ϊ�����Ŀ¼ͬ����ȵ�Ŀ¼
$art_dir = "~artdir~";

//ͼƬ�������Ĭ��·��
$imgview_dir = "~imgviewdir~";

//��̬�ļ���Ŀ¼�����Ŀ¼�����ڴ�ż�������ͶƱ�����۵ȳ���ı�Ҫ��̬����
$art_php_dir = "~phpdir~";

//���ݱ���Ŀ¼
$bak_dir = $art_php_dir."~bakdir~";

//�����ļ�����չ���������� .htm �� .html ,������Ҫ,��Ҳ������ .php �� .shtml
$art_shortname = "~artshortname~";

//HTML�ı���·����ѡ��Ϊ:
//[1] listdir ��ʾ����Ŀ��Ŀ¼���� ID.htm ����ʽ�����ļ�
//[2] maketime ��ʾ�� $artdir/year/monthday/ID �������ļ�
//������ǵ�һ��ʹ�ã��Ƽ��������ļ���ʽ�������V0.8�����汾������listdir��ʽ
$art_nametag = "~artnametag~";

//�½�Ŀ¼��Ȩ��
//�����ʹ�ñ�����ԣ����̲���֤������˳����Linux��Unixϵͳ����
$dir_purview = 0755;

//�Ƿ������û�Ͷ��, -1 ��ʾ���л�Ա����Ͷ��
//�������-1����ʾ����Ͷ��Ļ�Ա������룬����㲻���û�����Ͷ�壬���Ϊ 10000 ֮�������
$userSendArt = -1;

//--------------------------------
//����ѡ�����ޱ�Ҫ�����������//

//��Ƿ��
$tag_start_char = "{";
$tag_end_char = "}";

//Ĭ�ϵ����ֿռ䣬���������
$tag_namespace = "dede";

//�ϴ���ͼƬ��·��,���鰴Ĭ��
$img_dir = $imgview_dir."/uploadimg";

//����ͼ
$ddimg_dir = $imgview_dir."/artlit";

//�û�Ͷ��ͼƬ���Ŀ¼
$userimg_dir = $imgview_dir."/user";

//�ϴ������Ŀ¼
$soft_dir = $imgview_dir."/uploadsoft";

//��������ͼ���Ŀ¼
$flink_dir = $imgview_dir."/flink";

//ģ��Ĵ��Ŀ¼
$mod_dir = $art_php_dir."/modpage";

if(!is_dir($art_dir)) require("start_newdir.php");

/////////////////////////////////////////////////////////////
//��ص�����ѡ�����
//����Ϊ���ú���
/////////////////////////////////////////////////////////////
//-----����MySql���ݿ�----------------
function connectMySql()
{
	global $dbname,$dbhost,$dbusername,$dbuserpwd;
	$openconn = mysql_pconnect($dbhost,$dbusername,$dbuserpwd) or die("�޷�����MySQL���ݿ�!");
	mysql_select_db($dbname,$openconn);
	return $openconn;
}
//-----�����ַ���ȡ--------
function cn_substr($str,$len)
{
  return cn_midstr($str,0,$len);
}
function cn_midstr($str,$start,$len){
  $i=0;
  $dd=0;
  while($i<$start)
  {
  		$ch=substr($str,$i,1);
  		if(ord($ch)>127) $dd++;
  		else $dd=$dd+2;
  		$i++;
  }
  if($dd%2!=0) $start++;
  $i=$start;
  $endnum = $start+$len;
  while($i<$endnum)
  {
    $ch=substr($str,$i,1);
    if(ord($ch)>127) $i++;
      $i++;
  }
  $restr=substr($str,$start,$i-$start);
  return $restr;
}
//-------����ʾ��Ϣ----------
function ShowMsg($msg,$gotoPage)
{
	$msg = str_replace("'","`",trim($msg));
	$gotoPage = str_replace("'","`",trim($gotoPage));
	echo "<script language='javascript'>\n";
	echo "alert('$msg');";
	if($gotoPage=="back")
	{
		echo "history.go(-1);\r\n";
	}
	else if(ereg("^-",$gotoPage))
	{
		echo "history.go($gotoPage);\r\n";
	}
	else if($gotoPage!="")
	{
		echo "location.href='$gotoPage';\r\n";
	}
	echo "</script>";
}
?>