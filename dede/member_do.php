<?php 
require_once(dirname(__FILE__)."/config.php");
require_once(dirname(__FILE__)."/../include/pub_oxwindow.php");

if(empty($dopost)) $dopost = "";
if(empty($fmdo)) $fmdo = "";

if(!isset($ENV_GOBACK_URL)) $ENV_GOBACK_URL = '';

/*----------------
function __DelMember()
ɾ����Ա
----------------*/
if($dopost=="delmember")
{
	CheckPurview('member_Del');
	
	if($fmdo=="yes")
	{
		$ID = ereg_replace("[^0-9]","",$ID);
		$dsql = new DedeSql(false);
		$dsql->ExecuteNoneQuery("Delete From #@__member where ID='$ID'");
		$dsql->ExecuteNoneQuery("Delete From #@__memberstow where uid='$ID'");
		$dsql->ExecuteNoneQuery("Delete From #@__member_guestbook where mid='$ID'");
		$dsql->ExecuteNoneQuery("Delete From #@__member_arctype where memberid='$ID'");
		$dsql->ExecuteNoneQuery("Delete From #@__member_flink where mid='$ID'");
		$dsql->ExecuteNoneQuery("update #@__archives set memberID='0' where memberID='$ID'");
		$dsql->Close();
		ShowMsg("�ɹ�ɾ��һ����Ա��",$ENV_GOBACK_URL);
		exit();
	}
	
	$wintitle = "��Ա����-ɾ����Ա";
	$wecome_info = "<a href='".$ENV_GOBACK_URL."'>��Ա����</a>::ɾ����Ա";
	$win = new OxWindow();
	$win->Init("member_do.php","js/blank.js","POST");
	$win->AddHidden("fmdo","yes");
	$win->AddHidden("dopost",$dopost);
	$win->AddHidden("ID",$ID);
	$win->AddTitle("��ȷʵҪɾ��(ID:".$ID.")�����Ա?");
	$winform = $win->GetWindow("ok");
	$win->Display();
}
/*-----------------------------
function __UpOperations()
ҵ��״̬����Ϊ�Ѹ���״̬
------------------------------*/
else if($dopost=="upoperations")
{
	CheckPurview('member_Operations');
	if($nid==''){
		ShowMsg("ûѡ��Ҫ���ĵ�ҵ���¼��","-1");
		exit();
	}
	$nids = explode('`',$nid);
  $wh = '';
	foreach($nids as $n){
		if($wh=='') $wh = " where aid='$n' ";
		else $wh .= " Or aid='$n' ";
	}
	$dsql = new DedeSql(false);
	$dsql->SetQuery("update #@__member_operation set sta=1 $wh ");
	$dsql->ExecuteNoneQuery();
	$dsql->Close();
	ShowMsg("�ɹ�����ָ����ҵ���¼��",$ENV_GOBACK_URL);
	exit();
}	
/*----------------------------
function __OkOperations()
ҵ��״̬���ĸ����״̬
-----------------------------*/
else if($dopost=="okoperations")
{
	CheckPurview('member_Operations');
	if($nid==''){
		ShowMsg("ûѡ��Ҫ���ĵ�ҵ���¼��","-1");
		exit();
	}
	$nids = explode('`',$nid);
  $wh = '';
	foreach($nids as $n){
		if($wh=='') $wh = " where aid='$n' ";
		else $wh .= " Or aid='$n' ";
	}
	$dsql = new DedeSql(false);
	$dsql->SetQuery("update #@__member_operation set sta=2 $wh ");
	$dsql->ExecuteNoneQuery();
	$dsql->Close();
	ShowMsg("�ɹ�����ָ����ҵ���¼��",$ENV_GOBACK_URL);
	exit();
}	
/*----------------
function __UpRank()
��Ա����
----------------*/
else if($dopost=="uprank")
{
	CheckPurview('member_Edit');
	
	if($fmdo=="yes")
	{
		$ID = ereg_replace("[^0-9]","",$ID);
		$membertype = ereg_replace("[^0-9]","",$membertype);
		$dsql = new DedeSql(false);
		$dsql->SetQuery("update #@__member set membertype='$membertype',uptype='0' where ID='$ID'");
		$dsql->ExecuteNoneQuery();
		$dsql->Close();
		ShowMsg("�ɹ�����һ����Ա��",$ENV_GOBACK_URL);
		exit();
	}
	
	$dsql = new DedeSql(false);
  $MemberTypes = "";
  $dsql->SetQuery("Select rank,membername From #@__arcrank where rank>0");
  $dsql->Execute();
  $MemberTypes[0] = "��ͨ��Ա";
  while($row = $dsql->GetObject()){
	  $MemberTypes[$row->rank] = $row->membername;
  }
  $dsql->Close();
  
  $options = "<select name='membertype' style='width:100'>\r\n";
  foreach($MemberTypes as $k=>$v)
  {
  	if($k!=$uptype) $options .= "<option value='$k'>$v</option>\r\n";
  	else $options .= "<option value='$k' selected>$v</option>\r\n";
  }
  $options .= "</select>\r\n";
  
	$wintitle = "��Ա����-��Ա����";
	$wecome_info = "<a href='".$ENV_GOBACK_URL."'>��Ա����</a>::��Ա����";
	$win = new OxWindow();
	$win->Init("member_do.php","js/blank.js","POST");
	$win->AddHidden("fmdo","yes");
	$win->AddHidden("dopost",$dopost);
	$win->AddHidden("ID",$ID);
	$win->AddTitle("��Ա������");
	$win->AddItem("��ԱĿǰ�ĵȼ���",$MemberTypes[$mtype]);
	$win->AddItem("��Ա����ĵȼ���",$MemberTypes[$uptype]);
	$win->AddItem("��ͨ�ȼ���",$options);
	$winform = $win->GetWindow("ok");
	$win->Display();
}
/*----------------
function __Recommend()
�Ƽ���Ա
----------------*/
else if($dopost=="recommend")
{
	CheckPurview('member_Edit');
	$ID = ereg_replace("[^0-9]","",$ID);
	$dsql = new DedeSql(false);
	if($matt==0){
		$dsql->ExecuteNoneQuery("update #@__member set matt=1 where ID='$ID'");
		$dsql->Close();
		ShowMsg("�ɹ�����һ����Ա�Ƽ���",$ENV_GOBACK_URL);
	  exit();
	}else{
		$dsql->ExecuteNoneQuery("update #@__member set matt=0 where ID='$ID'");
	  $dsql->Close();
	  ShowMsg("�ɹ�ȡ��һ����Ա�Ƽ���",$ENV_GOBACK_URL);
	  exit();
  }
}
/*----------------
function __AddMoney()
��Ա��ֵ
----------------*/
else if($dopost=="addmoney")
{
	CheckPurview('member_Edit');
	
	if($fmdo=="yes")
	{
		$ID = ereg_replace("[^0-9]","",$ID);
		$money = ereg_replace("[^0-9]","",$money);
		$dsql = new DedeSql(false);
		$dsql->SetQuery("update #@__member set money=money+$money where ID='$ID'");
		$dsql->ExecuteNoneQuery();
		$dsql->Close();
		ShowMsg("�ɹ���һ����Ա��ֵ��",$ENV_GOBACK_URL);
		exit();
	}
	if(empty($upmoney)) $upmoney = 500;
	$wintitle = "��Ա����-��Ա��ֵ";
	$wecome_info = "<a href='".$ENV_GOBACK_URL."'>��Ա����</a>::��Ա��ֵ";
	$win = new OxWindow();
	$win->Init("member_do.php","js/blank.js","POST");
	$win->AddHidden("fmdo","yes");
	$win->AddHidden("dopost",$dopost);
	$win->AddHidden("ID",$ID);
	$win->AddTitle("��Ա��ֵ��");
	$win->AddMsgItem("�������ֵ������<input type='text' name='money' size='10' value='$upmoney'>",60);
	$winform = $win->GetWindow("ok");
	$win->Display();
}
/*----------------
function __EditUser()
���Ļ�Ա
----------------*/
else if($dopost=="edituser")
{
	CheckPurview('member_Edit');
	$dsql = new DedeSql(false);
	$uptime =  GetMkTime($uptime);
	$query = "update #@__member set 
 	  membertype = '$membertype',
 	  uptime = '$uptime',
 	  exptime = '$exptime',
 	  money = '$money',
 	  email = '$email',
    uname = '$uname',
    sex = '$sex',
    birthday = '$birthday',
    weight = '$weight',
    height = '$height',
    job = '$job',
    province = '$province',
    city = '$city',
    myinfo = '$myinfo',
    mybb = '$mybb',
    oicq = '$oicq',
    tel = '$tel',
    homepage = '$homepage',
    spacename = '$spacename',
    news = '$news',
    fullinfo = '$fullinfo',
    address = '$address'
 	  where ID='$ID'";
	$dsql->SetQuery($query);
	$rs = $dsql->ExecuteNoneQuery();
  $dsql->Close();
  ShowMsg("�ɹ����Ļ�Ա���ϣ�",$ENV_GOBACK_URL);
  exit();
}
?>