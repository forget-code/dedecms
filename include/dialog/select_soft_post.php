<?php 
require_once(dirname(__FILE__)."/config.php");
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
	ShowMsg("�ɹ�����һ��Ŀ¼��","select_soft.php?f=$f&activepath=".urlencode($activepath."/".$dirname));
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
	if(!eregi("\.".$cfg_softtype,$uploadfile_name))
	{
		ShowMsg("�����ϴ����ļ����Ͳ��ܱ�ʶ�������ϵͳ����չ���޶������ã�","-1");
		exit();
	}
	$nowtme = mytime();
	if($filename!="") $filename = trim(ereg_replace("[ \r\n\t\*\%\\/\?><\|\":]{1,}","",$filename));
	if($filename==""){
		$y = substr(strftime("%Y",$nowtme),2,2);
		$filename = $cuserLogin->getUserID()."_".$y.strftime("%m%d%H%M%S",$nowtme);
		$fs = explode(".",$uploadfile_name);
		$filename = $filename.".".$fs[count($fs)-1];
	}
  $fullfilename = $cfg_basedir.$activepath."/".$filename;
  if(file_exists($fullfilename)){
  	ShowMsg("��Ŀ¼�Ѿ�����ͬ�����ļ�������ģ�","-1");
		exit();
  }
  @move_uploaded_file($uploadfile,$fullfilename);
	if($uploadfile_type == 'application/x-shockwave-flash') $mediatype=2;
	else if(eregi('audio|media|video',$uploadfile_type)) $mediatype=3;
	else $mediatype=4;
	$inquery = "
   INSERT INTO #@__uploads(title,url,mediatype,width,height,playtime,filesize,uptime,adminid,memberid) 
   VALUES ('$filename','".$activepath."/".$filename."','$mediatype','0','0','0','{$uploadfile_size}','{$nowtme}','".$cuserLogin->getUserID()."','0');
  ";
  $dsql = new DedeSql(false);
  $dsql->ExecuteNoneQuery($inquery);
  $dsql->Close();
	ShowMsg("�ɹ��ϴ��ļ���","select_soft.php?comeback=".urlencode($filename)."&f=$f&activepath=".urlencode($activepath)."&d=".mytime());
	exit();
}
?>