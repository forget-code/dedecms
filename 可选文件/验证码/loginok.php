<?
require_once("inc_userLogin.php");
require_once("config_base.php");
$validate = strtolower($validate);
if($validate!=$_SESSION["s_validate"])
{
	ShowMsg("��֤�벻��ȷ!","-1");
	exit();
}
$cuserLogin = new userLogin();
if(!empty($userid)&&!empty($pwd))
{
	$res = $cuserLogin->checkUser($userid,$pwd);
	if($res==1)
	{
		$cuserLogin->keepUser();
		if(!empty($gotopage)) header("location:$gotopage");
		else header("location:index.php");
	}
	else if($res==-1)
	{
		ShowMsg("����û���������!","-1");
		exit();
	}
	else
	{
		ShowMsg("����������!","-1");
		exit();
	}
}
else
{
	ShowMsg("�û�������û��д����!","-1");
	exit();
}
?> 
