<?
require_once(dirname(__FILE__)."/config.php");
CheckPurview('sys_ArcBatch');
require_once(dirname(__FILE__)."/../include/inc_typelink.php");
require_once(dirname(__FILE__)."/inc/inc_batchup.php");
@set_time_limit(0);
//typeid,startid,endid,seltime,starttime,endtime,action,newtypeid
//��������
//check del move makehtml
//��ȡID����
//------------------------
if(empty($startid)) $startid = 0;
if(empty($endid)) $endid = 0;
if(empty($seltime)) $seltime = 0;
//����HTML����������ҳ�洦��
if($action=="makehtml")
{
	$jumpurl  = "makehtml_archives_action.php?endid=$endid&startid=$startid";
  $jumpurl .= "&typeid=$typeid&pagesize=20&seltime=$seltime";
  $jumpurl .= "&stime=".urlencode($starttime)."&etime=".urlencode($endtime);
	header("Location: $jumpurl");
	exit();
}

$gwhere = " where arcrank=0 ";
if($startid >0 ) $gwhere .= " And ID>= $startid ";
if($endid > $startid) $gwhere .= " And ID<= $endid ";
$dsql = new DedeSql(false);
$idsql = "";
if($typeid!=0){
	$idArrary = TypeGetSunTypes($typeid,$dsql,0);
	if(is_array($idArrary)){
	  foreach($idArrary as $tid){
		  if($idsql=="") $idsql .= " typeid=$tid ";
		  else $idsql .= " or typeid=$tid ";
	  }
	  $gwhere .= " And ( ".$idsql." ) ";
  }
}
if($seltime==1){
	$t1 = GetMkTime($starttime);
	$t2 = GetMkTime($endtime);
	$gwhere .= " And (senddate >= $t1 And senddate <= $t2) ";
}

//�������
if(!empty($heightdone)) $action=$heightdone;

//ָ�����
if($action=='check')
{
	 if(empty($startid)||empty($endid)){
	 	 ShowMsg('�ò�������ָ����ʼID��','javascript:;');	
	 	 exit();
	 }
	 $jumpurl  = "makehtml_archives_action.php?endid=$endid&startid=$startid";
   $jumpurl .= "&typeid=$typeid&pagesize=20&seltime=$seltime";
   $jumpurl .= "&stime=".urlencode($starttime)."&etime=".urlencode($endtime);
	 $dsql->SetQuery("Select ID,arcrank From #@__archives $gwhere");
   $dsql->Execute('c');
	 while($row = $dsql->GetObject('c')){
	 	 if($row->arcrank==-1) $dsql->ExecuteNoneQuery("Update #@__archives set arcrank=0 where ID='{$row->ID}'");
	 }
	 $dsql->Close();
	 ShowMsg("������ݿ����˴���׼������HTML...",$jumpurl);
	 exit();
}
//����ɾ��
else if($action=='del')
{
  if(empty($startid)||empty($endid)){
	 	 ShowMsg('�ò�������ָ����ʼID��','javascript:;');	
	 	 exit();
	}
  $dsql->SetQuery("Select ID From #@__archives $gwhere");
  $dsql->Execute('x');
  $tdd = 0;
  while($row = $dsql->GetObject('x')){ if(DelArc($row->ID)) $tdd++; }
  $dsql->Close();
	ShowMsg("�ɹ�ɾ�� $tdd ����¼��","javascript:;");
	exit();
}
//ɾ���ձ����ĵ�
else if($action=='delnulltitle')
{
  $dsql->SetQuery("Select ID From #@__archives where trim(title)='' ");
  $dsql->Execute('x');
  $tdd = 0;
  while($row = $dsql->GetObject('x')){ if(DelArc($row->ID)) $tdd++; }
  $dsql->Close();
	ShowMsg("�ɹ�ɾ�� $tdd ����¼��","javascript:;");
	exit();
}
//ɾ������������
else if($action=='delnullbody')
{
  $dsql->SetQuery("Select aid From #@__addonarticle where LENGTH(body) < 10 ");
  $dsql->Execute('x');
  $tdd = 0;
  while($row = $dsql->GetObject('x')){ if(DelArc($row->aid)) $tdd++; }
  $dsql->Close();
	ShowMsg("�ɹ�ɾ�� $tdd ����¼��","javascript:;");
	exit();
}
//��������ͼ����
else if($action=='modddpic')
{
  $dsql->ExecuteNoneQuery("Update #@__archives set litpic='' where trim(litpic)='litpic' ");
  $dsql->Close();
	ShowMsg("�ɹ���������ͼ����","javascript:;");
	exit();
}
//�����ƶ�
else if($action=='move')
{
  if(empty($typeid)){
	 	 ShowMsg('�ò�������ָ����Ŀ��','javascript:;');	
	 	 exit();
	}
  $typeold = $dsql->GetOne("Select * From #@__arctype where ID='$typeid'; ");
  $typenew = $dsql->GetOne("Select * From #@__arctype where ID='$newtypeid'; ");
  if(!is_array($typenew)){
  	$dsql->Close();
    ShowMsg("�޷�����ƶ���������Ŀ����Ϣ��������ɲ�����","javascript:;");
	  exit();
  }
  if($typenew['ispart']!=0){
  	$dsql->Close();
    ShowMsg("�㲻�ܰ������ƶ����������б����Ŀ��","javascript:;");
	  exit();
  }
  if($typenew['channeltype']!=$typeold['channeltype']){
  	$dsql->Close();
    ShowMsg("���ܰ������ƶ����������Ͳ�ͬ����Ŀ��","javascript:;");
	  exit();
  }
  $gwhere .= " And channel='".$typenew['channeltype']."' And title like '%$keyword%'";
  $dsql->SetQuery("Select ID From #@__archives $gwhere");
  $dsql->Execute('m');
  $tdd = 0;
  while($row = $dsql->GetObject('m')){
	 	 $rs = $dsql->ExecuteNoneQuery("Update #@__archives set typeid='$newtypeid' where ID='{$row->ID}'");
	   if($rs) $tdd++;
	   DelArc($row->ID,true);
	}
  $dsql->Close();
  if($tdd>0)
  {
  	$jumpurl  = "makehtml_archives_action.php?endid=$endid&startid=$startid";
    $jumpurl .= "&typeid=$newtypeid&pagesize=20&seltime=$seltime";
    $jumpurl .= "&stime=".urlencode($starttime)."&etime=".urlencode($endtime);
  	ShowMsg("�ɹ��ƶ� $tdd ����¼��׼����������HTML...",$jumpurl);
  }
  else ShowMsg("��ɲ�����û�ƶ��κ�����...","javascript:;");
	exit();
}
?>