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
	ShowMsg("�ɹ�����һ��Ŀ¼��","select_images.php?imgstick=$imgstick&f=$f&activepath=".urlencode($activepath."/".$dirname));
	exit();
}
if($job=="upload")
{
	if(empty($imgfile)) $imgfile="";
	if(!is_uploaded_file($imgfile)){
		 ShowMsg("��û��ѡ���ϴ����ļ�!","-1");
	   exit();
	}
	if(ereg("^text",$imgfile_type)){
		ShowMsg("�������ı����͸���!","-1");
		exit();
	}
	$sparr = Array("image/pjpeg","image/jpeg","image/gif","image/png");
  $imgfile_type = strtolower(trim($imgfile_type));
  if(!in_array($imgfile_type,$sparr)){
		ShowMsg("�ϴ���ͼƬ��ʽ������ʹ��JPEG��GIF��PNG��ʽ������һ�֣�","-1");
		exit();
	}
	$y = substr(strftime("%Y",time()),2,2);
	$filename = $cuserLogin->getUserID()."_".$y.strftime("%m%d%H%M%S",time());
	$fs = explode(".",$imgfile_name);
	$filename = $filename.".".$fs[count($fs)-1];
  $fullfilename = $cfg_basedir.$activepath."/".$filename;
  if(file_exists($fullfilename)){
  	ShowMsg("��Ŀ¼�Ѿ�����ͬ�����ļ�������ģ�","-1");
		exit();
  }
  @move_uploaded_file($imgfile,$fullfilename);
  
  if(empty($resize)) $resize = 0;
  if($resize==1){
  	require_once(dirname(__FILE__)."/../inc_photograph.php");
  	ImageResize($fullfilename,$iwidth,$iheight);
  }
  
	@unlink($imgfile);
	ShowMsg("�ɹ��ϴ�һ��ͼƬ��","select_images.php?imgstick=$imgstick&comeback=".urlencode($filename)."&f=$f&activepath=".urlencode($activepath)."&d=".time());
	exit();
}
?>