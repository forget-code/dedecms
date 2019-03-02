<?
$needFilter = true;
require(dirname(__FILE__)."/../include/config_base.php");
require(dirname(__FILE__)."/../include/inc_memberlogin.php");
require(dirname(__FILE__)."/../include/inc_channel_unit.php");
if(!isset($action)) $action = "";
if(!empty($artID)) $arcID = $artID;
if(!isset($arcID)) $arcID = "";

if($cfg_feedbackcheck=='��') $ischeck = 0;
else $ischeck = 1;

function trimMsg($msg)
{
	global $cfg_notallowstr;
	$notallowstr = $cfg_notallowstr;
	$msg = htmlspecialchars(trim($msg));
	$msg = nl2br($msg);
	$msg = str_replace("  ","&nbsp;&nbsp;",$msg);
	$msg = eregi_replace($notallowstr,"***",$msg);
	return $msg;
}

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
$topID = 0;
$arcRow = $dsql->GetOne("Select #@__archives.title,#@__archives.senddate,#@__archives.arcrank,#@__archives.ismake,#@__archives.money,#@__archives.typeid,#@__arctype.topID,#@__arctype.typedir,#@__arctype.namerule From #@__archives  left join #@__arctype on #@__arctype.ID=#@__archives.typeid where #@__archives.ID='$arcID'");
if(is_array($arcRow)){
	$arctitle = $arcRow['title'];
	$topID = $arcRow['topID'];
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
	require_once(dirname(__FILE__)."/../include/pub_datalist_dm.php");
  $dlist = new DataList();
  $dlist->Init();
  $dlist->pageSize = 20;
  
  //�����������
  $feedback_hot = "";
	$nearTime = 60;  //������۵����µķ�������(��ʾ������ǰ)
	$minTime = mytime() - (3600 * 24 * $nearTime);
	
	if($topID==0) $hotquery = "Select ID,title From #@__archives where ID<>'$arcID' And senddate>$minTime order by postnum desc limit 0,10";
	else $hotquery = "Select ID,title From #@__archives where ID<>'$arcID' And senddate>$minTime And typeid=$topID order by postnum desc limit 0,10";
  
  $dlist->dsql->Execute("hotq",$hotquery);
  while($myrow = $dlist->dsql->GetArray("hotq")){
  	$feedback_hot .= "<div class='nndiv'>��<a href='feedback.php?arcID={$myrow['ID']}'>{$myrow['title']}</a></div>\r\n"; 
  }
  $dlist->dsql->FreeResult("hotq");
  
  //���������б�
  $querystring = "select * from #@__feedback where aid='$arcID' and ischeck='1' order by dtime desc";
  $dlist->SetParameter("arcID",$arcID);
  $dlist->SetParameter("action","show");
  $dlist->SetSource($querystring);
  require_once($cfg_basedir.$cfg_templets_dir."/plus/feedback_templet.htm");
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
  //�Ƿ����֤����ȷ��
  if(empty($isconfirm)) $isconfirm = "";
  if($isconfirm!="yes" && $cfg_feedback_ck=="��"){
  	require_once($cfg_basedir.$cfg_templets_dir."/plus/feedback_confirm.htm");
  	exit();
  }
  //�����֤��
  if($cfg_feedback_ck=="��"){
  	if(empty($validate)) $validate=="";
    else $validate = strtolower($validate);
    $svali = GetCkVdValue();
    if(strtolower($validate)!=$svali || $svali==""){
       ShowMsg("��֤�����","-1");
       exit();
    }
  }
  //�������
  if(empty($notuser)) $notuser=0;
  if($notuser==1){ //������������
	  if(empty($username)) $username = "guest";
  }
  else if($ml->M_ID > 0){ //�ѵ�¼���û�
	  $username = $ml->M_UserName;
  }
  else{ //�û������֤
	  $username = ereg_replace("[ ;'\"\*\?\%]","",$username);
	  $pwd = ereg_replace("[ ;'\"\*\?\%]","",$pwd);
 	  $rs = $ml->CheckUser($username,$pwd);
    if($rs==1) {
   	  $dsql->SetQuery("update #@__member set logintime='".mytime()."',loginip='".GetIP()."' where ID='".$cfg_ml->M_ID."'");
   	  $dsql->ExecuteNoneQuery();
   	  $username = $ml->M_UserName;
    }
    else{
  	  ShowMsg("��֤�û�ʧ�ܣ���������������û��������룡","-1");
  	  exit();
    }
  }
  $msg = cn_substr(trimMsg($msg),1000);
  $ip = GetIP();
  $dtime = mytime();
  //������������
  if($msg!="")
  {
	  $inquery = "
	  Insert Into #@__feedback(aid,username,arctitle,ip,msg,ischeck,dtime) 
	  values('$arcID','$username','$arctitle','$ip','$msg','$ischeck','$dtime')
	  ";
	  $dsql->ExecuteNoneQuery($inquery);
	  $dsql->ExecuteNoneQuery("Update #@__archives set postnum=postnum+1,lastpost='".mytime()."' where ID='$arcID'");
  }
  $dsql->Close();
  if($ischeck==0) ShowMsg("�ɹ��������ۣ�������˺�Ż���ʾ�������!","feedback.php?arcID=$arcID");
  if($ischeck==1) ShowMsg("�ɹ��������ۣ�����ת������ҳ��!","feedback.php?arcID=$arcID");
  exit();
}
?>