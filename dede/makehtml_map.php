<?
require_once(dirname(__FILE__)."/config.php");
require_once(dirname(__FILE__)."/../include/inc_sitemap.php");
require_once(dirname(__FILE__)."/../include/pub_dedetag.php");
if(empty($dopost))
{
	ShowMsg("��������!","-1");
	exit();
}
$sm = new SiteMap();
$maplist = $sm->GetSiteMap($dopost);
$sm->Close();
if($dopost=="site")
{
	$murl = $cfg_plus_dir."/sitemap.html";
	$tmpfile = $cfg_basedir.$cfg_templets_dir."/plus/sitemap.htm";
}
else
{
	$murl = $cfg_plus_dir."/rssmap.html";
	$tmpfile = $cfg_basedir.$cfg_templets_dir."/plus/rssmap.htm";
}
$dtp = new DedeTagParse();
$dtp->LoadTemplet($tmpfile);
$dtp->SaveTo($cfg_basedir.$murl);
$dtp->Clear();
echo "<a href='$murl' target='_blank'>�ɹ������ļ�: $murl ���...</a>";
exit();
?>