<?
require_once("config_base.php");
//����ļ���ҪҪ���ڻ�ȡģ��Ĳ���
class modPage
{
	var $BaseDir="";
	var $ModDir="";
	var $ArtDir="";
	function modPage()
	{
		global $base_dir;
		global $mod_dir;
		global $art_dir;
		$this->BaseDir = $base_dir;
		$this->ModDir = $mod_dir;
		$this->ArtDir = $art_dir;
	}
	//
	//���ָ��ģ��ľ���·��
	//
	function GetFullName($hname="Ĭ��ģ��",$typename="����",$channeltype="1")
	{
		return $this->BaseDir.$this->ModDir."/$hname/".$channeltype."/".$typename.".htm";
	}
	//
	//��ȡģ���ļ������ģ���б�
	//
	function GetModArray($hname="")
	{
		$i=0;
		if($hname!="")
		{
			$ds[0] = $hname;
			if($hname!="Ĭ��ģ��")
			{
				$i++;
				$ds[$i] = "Ĭ��ģ��";
			}
		}
		else
			$ds[0] = "Ĭ��ģ��";
		$i++;
		$mpath = $this->BaseDir.$this->ModDir;
        $dh = dir($mpath);
        while($filename=$dh->read())
        {
            if(!ereg("^\.|�Ͳ�ģ��|Ĭ��ģ��|images|img|dedeimg|��ҳ��",$filename)&&$filename!=$hname&&is_dir($mpath."/".$filename))
            {
            	$ds[$i] = $filename;
            	$i++;
            }
        }
        return $ds;
	}
	//
	//��ȡģ���ļ������ģ���б�
	//
	function GetHomePageArrays($hname="")
	{
		$i=0;
		if($hname!="")
		{
			$ds[0] = $hname;
			$i++;
		}
		$mpath = $this->BaseDir.$this->ModDir."/��ҳ��";
        $dh = dir($mpath);
        while($filename=$dh->read())
        {
            if(ereg("\.htm$|\.html$",$filename)&&$filename!=$hname)
            {
            	$ds[$i] = $filename;
            	$i++;
            }
        }
        return $ds;
	}
}
?>