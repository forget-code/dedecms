<?
require_once(dirname(__FILE__)."/../include/config_base.php");
require_once(dirname(__FILE__)."/../include/inc_memberlogin.php");

$cfg_ml = new MemberLogin(); 

$cfg_member_menu = "
<a href=\"index.php\"><u>��Ա��ҳ</u></a>&nbsp;
<a href=\"mystow.php\"><u>�ҵ��ղؼ�</u></a>&nbsp;
<a href=\"mypay.php\"><u>���Ѽ�¼</u></a>&nbsp;
<a href=\"artsend.php\"><u>Ͷ��</u></a>&nbsp;
<a href=\"artlist.php\"><u>������</u></a>&nbsp;
<a href=\"edit_info.php\"><u>���ĸ�������</u></a>&nbsp;
<a href=\"index_do.php?fmdo=login&dopost=exit\"><u>�˳���¼</u></a>
";

//------------------------------
//����û��Ƿ���Ȩ�޽���ĳ������
//------------------------------
function CheckRank($rank=0,$money=0)
{
	global $cfg_ml,$cfg_member_dir;
	if(!$cfg_ml->IsLogin()){
		ShowMsg("����δ��¼���Ѿ���ʱ��",$cfg_member_dir."/login.php?gourl=".urlencode(GetCurUrl()));
		exit();
	}
	else{
		if($cfg_ml->M_Type < $rank)
		{
		  $dsql = new DedeSql(false);
		  $needname = "";
		  if($cfg_ml->M_Type==0){
		  	$row = $dsql->GetOne("Select membername From #@__arcrank where rank='$rank'");
		  	$myname = "��ͨ��Ա";
		  	$needname = $row['membername'];
		  }else
		  {
		  	$dsql->SetQuery("Select membername From #@__arcrank where rank='$rank' Or rank='".$cfg_ml->M_Type."' order by rank desc");
		  	$dsql->Execute();
		  	$row = $dsql->GetObject();
		  	$needname = $row->membername;
		  	if($row = $dsql->GetObject()){ $myname = $row->membername; }
		  	else{ $myname = "��ͨ��Ա"; }
		  }
		  $dsql->Close();
		  ShowMsg("�Բ�����Ҫ��<span style='font-size:11pt;color:red'>$needname</span> ���ܷ��ʱ�ҳ�档<br>��Ŀǰ�ĵȼ��ǣ�<span style='font-size:11pt;color:red'>$myname</span> ��","-1",0,5000);
		  exit();
		}
		else if($cfg_ml->M_Money < $money)
		{
			ShowMsg("�Բ�����Ҫ���ѽ�ң�<span style='font-size:11pt;color:red'>$money</span> ���ܷ��ʱ�ҳ�档<br>��Ŀǰӵ�еĽ���ǣ�<span style='font-size:11pt;color:red'>".$cfg_ml->M_Money."</span>  ��","-1",0,5000);
		  exit();
		}
	}
}
?>