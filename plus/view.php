<?php 
require_once(dirname(__FILE__)."/../include/config_base.php");
require_once(dirname(__FILE__)."/../include/inc_archives_view.php");
function ParamError(){
	ShowMsg("�Բ���������Ĳ�������","javascript:;");
	exit();
}
$aid = ereg_replace("[^0-9]","",$aid);
if(empty($okview)) $okview="";
if($aid==0||$aid=="") ParamError();

$arc = new Archives($aid);


if($arc->IsError) {
	$arc->Close();
	ParamError();
}

//�۵�
function PayMoney($ml,$arc,$money){
	 global $aid;
   $row = $arc->dsql->GetOne("Select aid,money From #@__moneyrecord where aid='$aid' And uid='".$ml->M_ID."'");
   if(!is_array($row)){
		   //������Ѽ�¼
		   $inquery = "INSERT INTO #@__moneyrecord(aid,uid,title,money,dtime) 
               VALUES ('$aid','".$ml->M_ID."','{$arc->Fields['title']}','$money','".mytime()."');";
		   if($arc->dsql->ExecuteNoneQuery($inquery)){
		  	  $inquery = "Update #@__member set money=money-$money where ID='".$ml->M_ID."'";
		      $arc->dsql->ExecuteNoneQuery($inquery);
		   }
		}
}
//����Ķ�Ȩ��
//--------------------
$needMoney = $arc->Fields['money'];
$needRank = $arc->Fields['arcrank'];
$arcTitle = $arc->Fields['title'];
//������Ȩ�����Ƶ�����
//��ԱȨ��˵��:
//1�������趨�˰�ʱ���и߼���Ա������κ�Ȩ���ڵ��ĵ�������Ҫʹ�ý��
//2������Ȩ�޲��㣬���н�ҵ��û������Ի�1��������Ȩ������ĵ������趨�Ľ�����ĳ�ĵ�
//arctitle msgtitle moremsg
//------------------------------------
if($needMoney > 0 || $needRank > 0)
{
	if($needMoney<1 && $needRank > $ml->M_Type) $needMoney = 1;
	require_once(dirname(__FILE__)."/../include/inc_memberlogin.php");
	$ml = new MemberLogin();
	$arctitle = $arc->Fields['title'];
	$arclink = $arc->TypeLink->GetFileUrl($arc->ArcID,
	                $arc->Fields["typeid"],
	                $arc->Fields["senddate"],
	                $arc->Fields["title"],
	                $arc->Fields["ismake"],
	                $arc->Fields["arcrank"]);
	
	$arc->dsql->SetQuery("Select * From #@__arcrank");
	$arc->dsql->Execute();
	while($nrow = $arc->dsql->GetObject()){
			$memberTypes[$nrow->rank] = $nrow->membername;
	}
	$memberTypes[0] = 'δ��˻�Ա';
	$memberTypes[-1] = "<a href='{$cfg_memberurl}'>����δ��½</a>";
	
	$description =  $arc->Fields["description"]; 
	$pubdate = GetDateTimeMk($arc->Fields["pubdate"]);
	
	//�����趨�˰�ʱ���и߼���Ա������κ�Ȩ���ڵ��ĵ�������Ҫʹ�ý��
	//----------------------------------------------------------------
	if( ($ml->M_Type > 10) && ($ml->M_Type >= $needRank ) ){
		 //��Ա�Ѿ�����
		 if($ml->M_HasDay<1){
			  //���㹻���
			  if( $ml->M_Money < $needMoney )
			  {
			     $msgtitle = "�Ķ���{$arcTitle} Ȩ�޲��㣡";
		       $moremsg = "��ƪ�ĵ���Ҫ [<font color='red'>".$memberTypes[$needRank]."</font>] ";
		       $moremsg .= "�򻨷� {$needMoney} ����Ҳ��ܷ��ʣ���Ŀǰ�Ļ�Ա����Ѿ����ڣ�ӵ�н�� {$ml->M_Money} ����";
		       include_once($cfg_basedir.$cfg_templets_dir."/plus/view_msg.htm");
		       exit();
		    //���㹻���
		    }else{
		    	 PayMoney($ml,$arc,$needMoney);
		    }
		 }
	//�ǰ�ʱ��Ա�򼶱���Ļ�Ա��ʹ�ý���Ķ�
	//-------------------------------------------------------------------
	}else{
		//���㹻���
		if( $ml->M_Money < $needMoney )
		{
			   $msgtitle = "�Ķ���{$arcTitle} Ȩ�޲��㣡";
		     $moremsg = "��ƪ�ĵ���Ҫ [<font color='red'>".$memberTypes[$needRank]."</font>] ";
		     $moremsg .= "�򻨷� {$needMoney} ����Ҳ��ܷ��ʣ���Ŀǰ�Ļ�Ա���Ϊ".$memberTypes[$ml->M_Type]."��ӵ�н�� {$ml->M_Money} ����";
		     include_once($cfg_basedir.$cfg_templets_dir."/plus/view_msg.htm");
		     exit();
		 //���㹻���
		 }else{
		    PayMoney($ml,$arc,$needMoney);
		 }
	}
}

$arc->Display();
?>