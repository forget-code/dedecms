<?
header("Content-Type: text/html; charset=gb2312");
require_once(dirname(__FILE__)."/config.php");
CheckPurview('sys_Edit');
if(empty($action)) $action = "";
$needDir = "$cfg_templets_dir|
$cfg_templets_dir/dedecmsv31|
$cfg_templets_dir/system|
$cfg_templets_dir/plus|
$cfg_templets_dir/default|
$cfg_plus_dir|
$cfg_plus_dir/js|
$cfg_plus_dir/rss|
$cfg_plus_dir/cache|
$cfg_medias_dir|
$cfg_image_dir|
$ddcfg_image_dir|
$cfg_user_dir|
$cfg_soft_dir|
$cfg_other_medias|
$cfg_cmspath/include|
$cfg_cmspath/include/textdata|
$cfg_cmspath/include/sessions|
$cfg_special|
$cfg_member_dir/templets|
$cfg_cmspath$cfg_arcdir";
if(($isSafeMode || $cfg_ftp_mkdir=='��') && $cfg_ftp_host==""){
	echo "�������վ���PHP���ô������ƣ�����ֻ��ͨ��FTP��ʽ����Ŀ¼���������������ں�ָ̨��FTP��صı�����<br>";
	echo "<a href='sys_info.php'>&lt;&lt;�޸�ϵͳ����&gt;&gt;</a>";
	exit();
}
if($action==""){
	echo "�����򽫼������Ŀ¼�Ƿ���ڣ������Ƿ����д���Ȩ�ޣ������Դ�������ģ�<br>";
	echo "������������ʹ�õ���windowsϵͳ����������д˲�����<br>";
	echo "'/include' Ŀ¼�� '��ǰĿ¼/templets' �ļ���������FTP���ֹ�����Ȩ��Ϊ��д��(0777)<br>";
	echo "<pre>".str_replace('|','',$needDir)."</pre>";
	echo "<a href='testenv.php?action=ok'>&lt;&lt;��ʼ���&gt;&gt;</a> &nbsp; <a href='index_body.php'>&lt;&lt;������ҳ&gt;&gt;</a>";
}else{
	$needDirs = explode('|',$needDir);
	$needDir = "";
	foreach($needDirs as $needDir){
		$needDir = trim($needDir);
		$needDir = str_replace("\\","/",$needDir);
		$needDir = ereg_replace("/{1,}","/",$needDir);
		if(CreateDir($needDir)) echo "�ɹ����Ļ򴴽���{$needDir} <br>";
		else echo "���Ļ򴴽�Ŀ¼��{$needDir} <font color='red'>ʧ�ܣ�</font> <br>";
	}
	echo "<br>������ָ��Ļ򴴽��������Ŀ����<a href='testenv.php?action=ok&play=".mytime()."'><u>����</u></a>���ֶ���½��FTP�������Ŀ¼��Ȩ��Ϊ777��666<br>";
	echo "<br><a href='index_body.php'>&lt;&lt;������ҳ&gt;&gt;</a>";
	CloseFtp();
}

?>