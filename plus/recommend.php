<?php 
require(dirname(__FILE__)."/../include/config_base.php");
require(dirname(__FILE__)."/../include/inc_channel_unit.php");
if(!isset($action)) $action = "";
if(!empty($artID)) $arcID = $artID;
if(!isset($arcID)) $arcID = "";
$arcID = ereg_replace("[^0-9]","",$arcID);
if(empty($arcID)){
	  ShowMsg("�ĵ�ID����Ϊ��!","-1");
	  exit();
}
//////////////////////////////////////////////
if($action=="")
{
  $dsql = new DedeSql(false);
  //��ȡ�ĵ���Ϣ
  $arctitle = "";
  $arcurl = "";
  $arcRow = $dsql->GetOne("Select #@__archives.title,#@__archives.senddate,#@__archives.arcrank,#@__archives.ismake,#@__archives.money,#@__archives.typeid,#@__arctype.typedir,#@__arctype.namerule From #@__archives  left join #@__arctype on #@__arctype.ID=#@__archives.typeid where #@__archives.ID='$arcID'");
  if(is_array($arcRow)){
	  $arctitle = $arcRow['title'];
	  $arcurl = GetFileUrl($arcID,$arcRow['typeid'],$arcRow['senddate'],$arctitle,$arcRow['ismake'],$arcRow['arcrank'],$arcRow['namerule'],$arcRow['typedir'],$arcRow['money']);
  }
  else{
	  $dsql->Close();
	  ShowMsg("�޷���δ֪�ĵ��Ƽ�������!","-1");
	  exit();
  }
  $dsql->Close();
}
//�����Ƽ���Ϣ
//-----------------------------------
else if($action=="send")
{
	if(!eregi("(.*)@(.*)\.(.*)",$email)){
	  echo "<script>alert('Email����ȷ!');history.go(-1);</script>";
	  exit();
  }
  $mailbody = "";
  $msg = ereg_replace("[><]","",$msg);
  $mailtitle = "��ĺ��Ѹ����Ƽ���һƪ����";
  $mailbody .= "$msg \r\n\r\n";
  $mailbody .= "Power by http://www.dedecms.com ֯�����ݹ���ϵͳ��";
  if(eregi("(.*)@(.*)\.(.*)",$email)){
	  $headers = "From: ".$cfg_adminemail."\r\nReply-To: ".$cfg_adminemail;
    @mail($email, $mailtitle, $mailbody, $headers);
  }
  ShowMsg("�ɹ��Ƽ�һƪ����!",$arcurl);
  exit();
}

//��ʾģ��(��PHP�ļ�)
include_once($cfg_basedir.$cfg_templets_dir."/plus/recommend.htm");

?>
