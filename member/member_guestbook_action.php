<?
require_once(dirname(__FILE__)."/config_space.php");
require_once(dirname(__FILE__)."/../include/inc_memberlogin.php");
$cfg_ml = new MemberLogin(); 

$svali = GetCkVdValue();
if(strtolower($vdcode)!=$svali || $svali==""){
  ShowMsg("��֤�����","-1");
  exit();
}

$uidnum = trim(ereg_replace("[^0-9]","",$uidnum));
if(empty($uidnum)){
	ShowMsg("��������","-1");
  exit();
}

if(strlen($title)<2||strlen($msg)<10){
	ShowMsg("��ı��ⲻ�Ϸ�����������̫�̣�","-1");
  exit();
}

$title = cn_substr(html2text($title),60);
$msg = cn_substr(stripslashes($msg),2048);
if($cfg_ml->M_UserName!="" && $cfg_ml->M_ID!=$uidnum) $gid = $cfg_ml->M_UserName;
else  $gid = '';

$inquery = "
   INSERT INTO #@__member_guestbook(mid,gid,title,msg,uname,email,qq,tel,ip,dtime)
   VALUES ('$uidnum','$gid','$title','$msg','$uname','$email','$qq','$tel','".GetIP()."',".mytime().");
";
$dsql = new DedeSql(false);
$dsql->ExecuteNoneQuery($inquery);
$dsql->Close();

ShowMsg("�ɹ��ύ������ԣ�","-1");
exit();

?>