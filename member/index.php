<?php 
require_once(dirname(__FILE__)."/config_space.php");
if(empty($uid)) $uid = "";
if(empty($action)) $action = "";
//��Ա����������ҳ��
if($action=="" && $uid==""){
  require_once(dirname(__FILE__)."/config.php");
	CheckRank(0,0);
  $myurl = $cfg_basehost.$cfg_member_dir."/index.php?uid=".$cfg_ml->M_LoginID;
  $myurl = "<a href='$myurl'><u>$myurl</u></a>";
  $dsql = new DedeSql(false);
  $minfos = $dsql->GetOne("Select c1,c2,c3,guestbook,spaceshow,pageshow From #@__member where ID='".$cfg_ml->M_ID."'; ");
  $minfos['totaluse'] = GetUserSpace($cfg_ml->M_ID,$dsql);
  $minfos['totaluse'] = number_format($minfos['totaluse']/1024/1024,2);
  if($cfg_mb_max>0) $ddsize = ceil( ($minfos['totaluse']/$cfg_mb_max) * 100 );
  else $ddsize = 0;
  require_once(dirname(__FILE__)."/templets/index.htm");
}
//�鿴�û�����
else if($action=="memberinfo"){
	require_once(dirname(__FILE__)."/config.php");
	CheckRank(0,0);
	$notarchives = "yes";
	if(!TestStringSafe($uid)){
		ShowMsg("�û�ID���Ϸ���","-1");
		exit();
	}
	$dsql = new DedeSql(false);
	$spaceInfos = $dsql->GetOne("Select * From #@__member where userid='$uid'; ");
	if(!is_array($spaceInfos)){
		$dsql->Close();
		ShowMsg("����������û��Ѿ���ɾ����","-1");
		exit();
	}
	foreach( $spaceInfos as $k=>$v){if(ereg("[^0-9]",$k)) $$k = $v; }
	$userNumID = $ID;
	if($spaceimage==''){
		if($sex=='Ů') $spaceimage = 'img/dfgril.gif';
		else $spaceimage = 'img/dfboy.gif';
	}
	require_once(dirname(__FILE__)."/templets/space/member_info.htm");
}
//���û�����
else if($action=="feedback"){
	if(!TestStringSafe($uid)){
		ShowMsg("�û�ID���Ϸ���","-1");
		exit();
	}
	require_once(dirname(__FILE__)."/../include/inc_memberlogin.php");
  $cfg_ml = new MemberLogin(); 
	$notarchives = "yes";
	$dsql = new DedeSql(false);
	$spaceInfos = $dsql->GetOne("Select ID,uname,spacename,spaceimage,sex,c1,c2,spaceshow,logintime,news From #@__member where userid='$uid'; ");
	if(!is_array($spaceInfos)){
		$dsql->Close();
		ShowMsg("����������û��Ѿ���ɾ����","-1");
		exit();
	}
	foreach( $spaceInfos as $k=>$v){if(ereg("[^0-9]",$k)) $$k = $v; }
	$userNumID = $ID;
	if($spaceimage==''){
		if($sex=='Ů') $spaceimage = 'img/dfgril.gif';
		else $spaceimage = 'img/dfboy.gif';
	}
	require_once(dirname(__FILE__)."/templets/space/member_guestbook_form.htm");
}
//��Ա�ռ���ҳ��
else if($action==""){
	require_once(dirname(__FILE__)."/../include/inc_channel_unit_functions.php");
	$notarchives = "yes";
	if(!TestStringSafe($uid)){
		ShowMsg("�û�ID���Ϸ���","-1");
		exit();
	}
	$dsql = new DedeSql(false);
	$spaceInfos = $dsql->GetOne("Select ID,uname,spacename,spaceimage,sex,c1,c2,spaceshow,logintime,news From #@__member where userid='$uid'; ");
	if(!is_array($spaceInfos)){
		$dsql->Close();
		ShowMsg("����������û��Ѿ���ɾ����","-1");
		exit();
	}
	foreach( $spaceInfos as $k=>$v){if(ereg("[^0-9]",$k)) $$k = $v; }
	$userNumID = $ID;
	if($spaceimage==''){
		if($sex=='Ů') $spaceimage = 'img/dfgril.gif';
		else $spaceimage = 'img/dfboy.gif';
	}
	require_once(dirname(__FILE__)."/templets/space/member_index.htm");
}
?>