<?
require_once(dirname(__FILE__)."/config.php");
if(empty($job)) $job = "";
if($job=="newdir")
{
	$dirname = trim(ereg_replace("[ \r\n\t\.\*\%\\/\?><\|\":]{1,}","",$dirname));
	if($dirname==""){
		ShowMsg("Ŀ¼���Ƿ���","-1");
		exit();
	}
	@mkdir($cfg_basedir.$activepath."/".$dirname,$cfg_dir_purview);
	ShowMsg("�ɹ�����һ��Ŀ¼��","select_media.php?f=$f&activepath=".urlencode($activepath."/".$dirname));
	exit();
}
if($job=="upload")
{
	if(empty($uploadfile)) $uploadfile = "";
	if(!is_uploaded_file($uploadfile)){
		 ShowMsg("��û��ѡ���ϴ����ļ�!","-1");
	   exit();
	}
	if(ereg("^text",$uploadfile_type)){
		ShowMsg("�������ı����͸���!","-1");
		exit();
	}
	if(!eregi($cfg_mediatype,$uploadfile_name))
	{
		ShowMsg("�����ϴ���ý�����Ͳ��ܱ�ʶ�������config_base.php������ã�","-1");
		exit();
	}
	if($filename!="") $filename = trim(ereg_replace("[ \r\n\t\*\%\\/\?><\|\":]{1,}","",$filename));
	if($filename==""){
		$y = substr(strftime("%Y",time()),2,2);
		$filename = $cuserLogin->getUserID()."_".$y.strftime("%m%d%H%M%S",time());
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
	ShowMsg("�ɹ��ϴ��ļ���","select_media.php?comeback=".urlencode($filename)."&f=$f&activepath=".urlencode($activepath)."&d=".time());
	exit();
}
?>