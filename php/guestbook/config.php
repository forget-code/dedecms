<?
require("../../dede/config_base.php");
if(empty($gotopagerank)) $gotopagerank="";
if($gotopagerank=="admin") require("../../dede/inc_userLogin.php");
function trimMsg($msg,$gtype=0)
{
	$notallowstr="����|������|����|����|����|����|fuck|ȥ��|����|�߹�|͵��|ɫ��|����|sex|��B";
	$msg = htmlspecialchars(trim($msg));
	if($gtype==1)
	{
		$msg = nl2br($msg);
		$msg = str_replace("  ","&nbsp;&nbsp;",$msg);
	}
	$msg = eregi_replace($notallowstr,"***",$msg);
	return $msg;
}
?>