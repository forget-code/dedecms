<?
require(dirname(__FILE__)."/../include/config_base.php");
require(dirname(__FILE__)."/../include/inc_memberlogin.php");
require(dirname(__FILE__)."/../include/inc_channel_unit.php");
if(!isset($action)) $action = "";
//Ĭ�ϵ��������������˲���ʾ��
//�������ֱ����ʾ�������ֵ��Ϊ 1 
$ischeck = 0;

if(!empty($artID)) $arcID = $artID;
if(!isset($arcID)) $arcID = "";
$arcID = ereg_replace("[^0-9]","",$arcID);
if(empty($arcID)){
	  ShowMsg("�ĵ�ID����Ϊ��!","-1");
	  exit();
}
$ml = new MemberLogin();
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
	 ShowMsg("�޷���δ֪�ĵ���������!","-1");
	 exit();
}
//�鿴����
//-----------------------------------
if($action==""||$action=="show")
{
	require_once(dirname(__FILE__)."/../include/pub_datalist.php");
  $querystring = "select * from #@__feedback where aid='$arcID' and ischeck='1' order by dtime desc";
  $dlist = new DataList();
  $dlist->Init();
  $dlist->SetParameter("arcID",$arcID);
  $dlist->SetParameter("action","show");
  $dlist->SetSource($querystring);
  $dlist->SetTemplet($cfg_basedir.$cfg_templets_dir."/plus/feedback_templet.htm");
  $dlist->display();
  $dlist->Close();
  $dsql->Close();
}
//��������
//------------------------------------
/*
function __send()
*/
else if($action=="send")
{
  if(empty($notuser)) $notuser=0;
  if($notuser==1) //������������
  {
	  if(empty($username)) $username = "guest";
  }
  else if($ml->M_ID > 0) //�ѵ�¼���û�
  {
	  $username = $ml->M_UserName;
  }
  else //�û������֤
  {
	  $username = ereg_replace("[ '\"\*\?\%]","",$username);
	  $pwd = ereg_replace("[ '\"\*\?\%]","",$pwd);
 	  $rs = $ml->CheckUser($username,$pwd);
    if($rs==1) {
   	  $dsql->SetQuery("update #@__member set logintime='".time()."',loginip='".GetIP()."' where ID='".$cfg_ml->M_ID."'");
   	  $dsql->ExecuteNoneQuery();
   	  $username = $ml->M_UserName;
    }
    else{
  	  ShowMsg("��֤�û�ʧ�ܣ���������������û��������룡","-1");
  	  exit();
    }
  }
  $arcID = ereg_replace("[^0-9]","",$arcID);
  $msg = cn_substr(trim($msg),1000);
  $msg = str_replace("<","&lt;",$msg);
  $msg = str_replace(">","&gt;",$msg);
  $msg = str_replace("  ","&nbsp;&nbsp;",$msg);
  $msg = str_replace("\r\n","<br>\n",$msg);
  $msg = trim($msg);
  $ip = GetIP();
  $dtime = time();
  //������������
  if($msg!="")
  {
	  $inquery = "
	  Insert Into #@__feedback(aid,username,arctitle,ip,msg,ischeck,dtime) 
	  values('$arcID','$username','$arctitle','$ip','$msg','$ischeck','$dtime')
	  ";
	  $dsql->SetQuery($inquery);
	  $dsql->ExecuteNoneQuery();
  }
  $dsql->Close();
  if($ischeck==0) ShowMsg("�ɹ��������ۣ�������˺�Ż���ʾ�������!","feedback.php?arcID=$arcID");
  if($ischeck==1) ShowMsg("�ɹ��������ۣ�����ת������ҳ��!","feedback.php?arcID=$arcID");
  exit();
}
?>