<?
require_once(dirname(__FILE__)."/../include/inc_arcspec_view.php");
$specfile = dirname(__FILE__)."spec_1".$art_shortname;
//����Ѿ����뾲̬�б���ֱ�������һ���ļ�
if(file_exists($specfile))
{
	include($specfile);
	exit();
}
else
{
  $sp = new SpecView();
  $sp->Display();
  $sp->Close();
}
?>