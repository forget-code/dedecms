<?php 
require_once(dirname(__FILE__)."/config.php");
$cfg_txttype = "htm|html|tpl|txt|dtp";
if(empty($job)) $job = "";
if($job=="newdir")
{
	$dirname = trim(ereg_replace("[ \r\n\t\.\*\%\\/\?><\|\":]{1,}","",$dirname));
	if($dirname==""){
		ShowMsg("Ŀ¼���Ƿ���","-1");
		exit();
	}
	MkdirAll($cfg_basedir.$activepath."/".$dirname,777);
	CloseFtp();
	ShowMsg("�ɹ�����һ��Ŀ¼��","select_templets.php?f=$f&activepath=".urlencode($activepath."/".$dirname));
	exit();
}
if($job=="upload")
{
	if(empty($uploadfile)) $uploadfile = "";
	if(!is_uploaded_file($uploadfile)){
		 ShowMsg("��û��ѡ���ϴ����ļ�!","-1");
	   exit();
	}
	if(!ereg("^text",$uploadfile_type)){
		ShowMsg("���ϴ��Ĳ����ı����͸���!","-1");
		exit();
	}
	if(!eregi($cfg_txttype,$uploadfile_name))
	{
		ShowMsg("�����ϴ���ģ���ļ����Ͳ��ܱ�ʶ����ʹ��htm��html��tpl��txt��dtp��չ����","-1");
		exit();
	}
	if($filename!="") $filename = trim(ereg_replace("[ \r\n\t\*\%\\/\?><\|\":]{1,}","",$filename));
	if($filename==""){
		$y = substr(strftime("%Y",mytime()),2,2);
		$filename = $cuserLogin->getUserID()."_".$y.strftime("%m%d%H%M%S",mytime());
		$fs = explode(".",$uploadfile_name);
		$filename = $filename.".".$fs[count($fs)-1];
	}
  $fullfilename = $cfg_basedir.$activepath."/".$filename;
  if(file_exists($fullfilename))
  {
  	ShowMsg("��Ŀ¼�Ѿ�����ͬ�����ļ�������ģ�","-1");
		exit();
  }
  @move_uploaded_file($uploadfile,$fullfilename);
	@unlink($uploadfile);
	ShowMsg("�ɹ��ϴ��ļ���","select_templets.php?comeback=".urlencode($filename)."&f=$f&activepath=".urlencode($activepath)."&d=".mytime());
	exit();
}
?>