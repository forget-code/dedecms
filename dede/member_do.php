<?
require_once(dirname(__FILE__)."/config.php");
require_once(dirname(__FILE__)."/../include/pub_oxwindow.php");

if(empty($dopost)) $dopost = "";
if(empty($fmdo)) $fmdo = "";
if(!isset($_COOKIE['ENV_GOBACK_URL'])) $ENV_GOBACK_URL = "";
else $ENV_GOBACK_URL="member_main.php";

/*----------------
function __DelMember()
ɾ����Ա
----------------*/
if($dopost=="delmember")
{
	SetPageRank(5);
	
	if($fmdo=="yes")
	{
		$ID = ereg_replace("[^0-9]","",$ID);
		$dsql = new DedeSql(false);
		$dsql->SetQuery("Delete From #@__member where ID='$ID'");
		$dsql->ExecuteNoneQuery();
		$dsql->SetQuery("Delete From #@__memberstow where uid='$ID'");
		$dsql->ExecuteNoneQuery();
		$dsql->SetQuery("update #@__archives set memberID='0' where memberID='$ID'");
		$dsql->ExecuteNoneQuery();
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
/*----------------
function __UpRank()
��Ա����
----------------*/
else if($dopost=="uprank")
{
	SetPageRank(5);
	
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
function __AddMoney()
��Ա��ֵ
----------------*/
else if($dopost=="addmoney")
{
	SetPageRank(5);
	
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
	SetPageRank(5);
	$dsql = new DedeSql(false);
	if($province==0) $province = $oldprovince;
 	if($city==0) $city = $oldcity;
	$query = "update #@__member set 
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
    homepage = '$homepage'
 	  where ID='$ID'";
	$dsql->SetQuery($query);
	$dsql->ExecuteNoneQuery();
  $dsql->Close();
  ShowMsg("�ɹ����Ļ�Ա���ϣ�",$ENV_GOBACK_URL);
  exit();
}
?>