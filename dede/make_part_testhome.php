<?
require("config.php");
require("inc_makepartcode.php");
$testcode = stripslashes(trim($testcode));
if($job=="save")
{
	$testcode = str_replace("\r","",$testcode);
	$testcode = ereg_replace("\n{1,}","\n",$testcode);
	$modefilename = $base_dir.$mod_dir."/��ҳ��/".$selmode;
	$fp = fopen($modefilename,"w") or die("<script>alert('�ļ�·�� $modefilename ��Ч��Ȩ�޲��㣡');history.go(-1);</script>");
	fwrite($fp,$testcode);
	fclose($fp);
	ShowMsg("�ɹ�����ģ�壡","add_home_page.php?modname=$selmode");
}
$maprt= new MakePartCode();
if($job=="make")
{
	$mfilename = $base_dir."/".$filename;
	$fp = fopen($mfilename,"w") or die("<script>alert('�ļ�·�� $mfilename ��Ч��Ȩ�޲��㣡');history.go(-1);</script>");
	fwrite($fp,$maprt->ParTemp($testcode));
	fclose($fp);
	ShowMsg("�ɹ������ļ���","/$filename");
}
else
{
	echo $maprt->ParTemp($testcode);
}
?>