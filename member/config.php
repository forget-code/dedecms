<?php 
$needFilter = true;
require_once(dirname(__FILE__)."/../include/config_base.php");
require_once(dirname(__FILE__)."/../include/inc_memberlogin.php");

//��õ�ǰ�ű����ƣ�������ϵͳ��������$_SERVER�����������и������ѡ��
$dedeNowurl = "";
$s_scriptName="";
$dedeNowurl = GetCurUrl();
$dedeNowurls = explode("?",$dedeNowurl);
$s_scriptName = $dedeNowurls[0];

//����Ƿ񿪷Ż�Ա����
//-------------------------------

if($cfg_mb_open=='��'){
	ShowMsg("ϵͳ�ر��˻�Ա���ܣ�������޷����ʴ�ҳ�棡","javascript:;");
	exit();
}

$cfg_egstr = "[\\\|\"\s\*\?\(\)\$;,'`%]";

$cfg_ml = new MemberLogin(); 
//$cfg_ml->PutLoginInfo($cfg_ml->M_ID);

//����û��Ƿ���Ȩ�޽���ĳ������
//------------------------------
function CheckRank($rank=0,$money=0)
{
	global $cfg_ml,$cfg_member_dir,$cfg_pp_isopen,$cfg_pp_loginurl,$cfg_pp_exiturl;
	if(!$cfg_ml->IsLogin()){
		if($cfg_pp_isopen==0 || $cfg_pp_loginurl==''){
			 ShowMsg("����δ��¼���Ѿ���ʱ��",$cfg_member_dir."/login.php?gourl=".urlencode(GetCurUrl()));
		   exit();
		}else{
			 $cfg_ml->ExitCookie();
			 //ShowMsg("����δ��¼���Ѿ���ʱ��",$cfg_pp_loginurl);
			 ShowMsg("����δ��¼���Ѿ���ʱ��",$cfg_pp_exiturl);
		   exit();
		}
		
	}
	else{
		if($cfg_ml->M_Type < $rank)
		{
		  $dsql = new DedeSql(false);
		  $needname = "";
		  if($cfg_ml->M_Type==0){
		  	$row = $dsql->GetOne("Select membername From #@__arcrank where rank='$rank'");
		  	$myname = "δ��˻�Ա";
		  	$needname = $row['membername'];
		  }else
		  {
		  	$dsql->SetQuery("Select membername From #@__arcrank where rank='$rank' Or rank='".$cfg_ml->M_Type."' order by rank desc");
		  	$dsql->Execute();
		  	$row = $dsql->GetObject();
		  	$needname = $row->membername;
		  	if($row = $dsql->GetObject()){ $myname = $row->membername; }
		  	else{ $myname = "δ��˻�Ա"; }
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