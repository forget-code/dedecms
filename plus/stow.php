<?
require(dirname(__FILE__)."/../include/config_base.php");
require(dirname(__FILE__)."/../include/inc_memberlogin.php");
require(dirname(__FILE__)."/../include/inc_channel_unit.php");
if(!empty($artID)) $arcID = $artID;
if(!isset($arcID)) $arcID = "";
$arcID = ereg_replace("[^0-9]","",$arcID);
if(empty($arcID)){
	  ShowMsg("�ĵ�ID����Ϊ��!","-1");
	  exit();
}
$ml = new MemberLogin();
if($ml->M_ID==0){
	ShowMsg("ֻ�л�Ա���������������","-1");
	exit();
}
//------------------------------------
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
	  ShowMsg("�޷��ղ�δ֪�ĵ�!","-1");
	  exit();
  }
  $addtime = time();
  $dsql->SetQuery("INSERT INTO #@__memberstow(uid,arcid,title,addtime) VALUES ('".$ml->M_ID."','$arcID','$arctitle','$addtime');");
  $dsql->ExecuteNoneQuery();
  $dsql->Close();
  ShowMsg("�ɹ��ղ�һƪ�ĵ���",$arcurl);
	exit();
}
?>