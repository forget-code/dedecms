<?
require(dirname(__FILE__)."/config.php");
require(dirname(__FILE__)."/../include/pub_oxwindow.php");
CheckPurview('plus_�ļ�������');
$activepath = str_replace("..","",$activepath);
$activepath = ereg_replace("^/{1,}","/",$activepath);
if($activepath == "/") $activepath = "";
if($activepath == "") $inpath = $cfg_basedir;
else $inpath = $cfg_basedir.$activepath;

//�ļ��������������߼������ļ�
$fmm = new FileManagement();
$fmm->Init();
/*---------------
function __rename();
----------------*/
if($fmdo=="rename")
{
	$fmm->RenameFile($oldfilename,$newfilename);
}
//�½�Ŀ¼
/*---------------
function __newdir();
----------------*/
else if($fmdo=="newdir")
{
	$fmm->NewDir($newpath);
}
//�ƶ��ļ�
/*---------------
function __move();
----------------*/
else if($fmdo=="move")
{
	$fmm->MoveFile($filename,$newpath);
}
//ɾ���ļ�
/*---------------
function __delfile();
----------------*/
else if($fmdo=="del")
{
	$fmm->DeleteFile($filename);
}
//�ļ��༭
/*---------------
function __saveEdit();
----------------*/
else if($fmdo=="edit")
{
		$filename = str_replace("..","",$filename);
		$file = "$cfg_basedir$activepath/$filename";
    $str = eregi_replace("< textarea","<textarea",$str);
	  $str = eregi_replace("< /textarea","</textarea",$str);
	  $str = eregi_replace("< form","<form",$str);
	  $str = eregi_replace("< /form","</form",$str);
    $str = stripslashes($str);
    $fp = fopen($file,"w");
    fputs($fp,$str);
    fclose($fp);
    if(empty($backurl)) ShowMsg("�ɹ�����һ���ļ���","file_manage_main.php?activepath=$activepath");
    else ShowMsg("�ɹ������ļ���",$backurl);
    exit();
}
//�ļ��༭�����ӻ�ģʽ
/*---------------
function __saveEditView();
----------------*/
else if($fmdo=="editview")
{
		$filename = str_replace("..","",$filename);
		$file = "$cfg_basedir$activepath/$filename";
	  $str = eregi_replace('&quot;','\\"',$str);
    $str = stripslashes($str);
    $fp = fopen($file,"w");
    fputs($fp,$str);
    fclose($fp);
    if(empty($backurl)) $backurl = "file_manage_main.php?activepath=$activepath";
    ShowMsg("�ɹ������ļ���",$backurl);
    exit();
}
//�ļ��ϴ�
/*---------------
function __upload();
----------------*/
else if($fmdo=="upload")
{
	$j=0;
	for($i=1;$i<=50;$i++)
	{
		$upfile = "upfile".$i;
		$upfile_name = "upfile".$i."_name";
		if(!isset(${$upfile}) || !isset(${$upfile_name})) continue;
		$upfile = ${$upfile};
		$upfile_name = ${$upfile_name};
		if(is_uploaded_file($upfile))
		{
			if(!file_exists($cfg_basedir.$activepath."/".$upfile_name)){
					move_uploaded_file($upfile,$cfg_basedir.$activepath."/".$upfile_name);
			}
			@unlink($upfile);
			$j++;
		}
	}
	ShowMsg("�ɹ��ϴ� $j ���ļ���: $activepath","file_manage_main.php?activepath=$activepath");
	exit();
}
//�ռ���
else if($fmdo=="space")
{
	if($activepath=="") $ecpath = "����Ŀ¼";
	else $ecpath = $activepath;	
	$titleinfo = "Ŀ¼ <a href='file_manage_main.php?activepath=$activepath'><b><u>$ecpath</u></b></a> �ռ�ʹ��״����<br/>";
	$wintitle = "�ļ�����";
	$wecome_info = "�ļ�����::�ռ��С��� [<a href='file_manage_main.php?activepath=$activepath'>�ļ������</a>]</a>";
	$activepath=$cfg_basedir.$activepath;
	$space=new SpaceUse;
	$space->checksize($activepath);
	$total=$space->totalsize;
	$totalkb=$space->setkb($total);
	$totalmb=$space->setmb($total);
	$win = new OxWindow();
	$win->Init("","js/blank.js","POST");
	$win->AddTitle($titleinfo);
	$win->AddMsgItem("����$totalmb M<br/>����$totalkb KB<br/>����$total �ֽ�");
	$winform = $win->GetWindow("");
	$win->Display();
}
//---------------------
//�ļ������߼���
//---------------------
class FileManagement
{	
	var $baseDir="";
	var $activeDir="";
	//�Ƿ������ļ�������ɾ��Ŀ¼��
	//Ĭ��Ϊ������ 0 ,���ϣ�����ܹ�������Ŀ¼,���ֵ��Ϊ 1 ��
	var $allowDeleteDir=0;
	//��ʼ��ϵͳ
	function Init()
	{
		global $cfg_basedir;
		global $activepath;
		$this->baseDir = $cfg_basedir;
		$this->activeDir = $activepath;
	}
	//�����ļ���
	function RenameFile($oldname,$newname)
	{
		$oldname = $this->baseDir.$this->activeDir."/".$oldname;
		$newname = $this->baseDir.$this->activeDir."/".$newname;
		if(($newname!=$oldname) && is_writable($oldname)){
			rename($oldname,$newname);
		}
		ShowMsg("�ɹ�����һ���ļ�����","file_manage_main.php?activepath=".$this->activeDir);
		return 0;
	}
	//������Ŀ¼
	function NewDir($dirname)
	{
		$newdir = $dirname;
		$dirname = $this->baseDir.$this->activeDir."/".$dirname;
		if(is_writable($this->baseDir.$this->activeDir)){
			MkdirAll($dirname,777);
			CloseFtp();
			ShowMsg("�ɹ�����һ����Ŀ¼��","file_manage_main.php?activepath=".$this->activeDir."/".$newdir);
		  return 1;
		}
		else{
			ShowMsg("������Ŀ¼ʧ�ܣ���Ϊ���λ�ò�����д�룡","file_manage_main.php?activepath=".$this->activeDir);
			return 0;
		}
	}
	//�ƶ��ļ�
	function MoveFile($mfile,$mpath)
	{
		if($mpath!="" && !ereg("\.\.",$mpath))
		{
			$oldfile = $this->baseDir.$this->activeDir."/$mfile";
			$mpath = str_replace("\\","/",$mpath);
			$mpath = ereg_replace("/{1,}","/",$mpath);
			if(!ereg("^/",$mpath)){ $mpath = $this->activeDir."/".$mpath;  }
			$truepath = $this->baseDir.$mpath;
		  if(is_readable($oldfile) 
		  && is_readable($truepath) && is_writable($truepath))
		  {
				if(is_dir($truepath)) copy($oldfile,$truepath."/$mfile");
			  else{
			  	MkdirAll($truepath,777);
			  	CloseFtp();
			  	copy($oldfile,$truepath."/$mfile");
			  }
				unlink($oldfile);
				ShowMsg("�ɹ��ƶ��ļ���","file_manage_main.php?activepath=$mpath",0,1000);
				return 1;
			}
			else
			{
				ShowMsg("�ƶ��ļ� $oldfile -&gt; $truepath/$mfile ʧ�ܣ�������ĳ��λ��Ȩ�޲��㣡","file_manage_main.php?activepath=$mpath",0,1000);
				return 0;
			}
		}
		else{
		  ShowMsg("�Բ������ƶ���·�����Ϸ���","-1",0,5000);
		  return 0;
	  }
	}
	//ɾ��Ŀ¼
	function RmDirFiles($indir)
	{
    $dh = dir($indir);
    while($filename = $dh->read()) {
      if($filename == "." || $filename == "..")
      	continue;
      else if(is_file("$indir/$filename"))
      	@unlink("$indir/$filename");
      else
        $this->RmDirFiles("$indir/$filename");
    }
    $dh->close();
    @rmdir($indir);
	}
	//ɾ���ļ�
	function DeleteFile($filename)
	{
		$filename = $this->baseDir.$this->activeDir."/$filename";
		if(is_file($filename)){ @unlink($filename); $t="�ļ�"; }
		else{
			$t = "Ŀ¼";
			if($this->allowDeleteDir==1) $this->RmDirFiles($filename);
		}
		ShowMsg("�ɹ�ɾ��һ��".$t."��","file_manage_main.php?activepath=".$this->activeDir);
		return 0;
	}
}
//
//Ŀ¼�ļ���С�����
//
class SpaceUse
{
	var $totalsize=0;	
	function checksize($indir)
	{
		$dh=dir($indir);
		while($filename=$dh->read())
		{
			if(!ereg("^\.",$filename))
			{
				if(is_dir("$indir/$filename")) $this->checksize("$indir/$filename");
				else $this->totalsize=$this->totalsize + filesize("$indir/$filename");
			}
		}
	}
	function setkb($size)
	{
		$size=$size/1024;
		//$size=ceil($size);
		if($size>0)
		{
			list($t1,$t2)=explode(".",$size);
			$size=$t1.".".substr($t2,0,1);
		}
		return $size;
	}
	function setmb($size)
	{
		$size=$size/1024/1024;
		if($size>0)
		{
			list($t1,$t2)=explode(".",$size);
			$size=$t1.".".substr($t2,0,2);
		}
		return $size;
	}	
}
?>