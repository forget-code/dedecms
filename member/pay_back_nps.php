<?php 
require_once(dirname(__FILE__)."/../include/config_base.php");
require_once(dirname(__FILE__)."/../include/inc_memberlogin.php");
require_once(dirname(__FILE__)."/config_pay_nps.php");

$cfg_ml = new MemberLogin(); 
$cfg_ml->PutLoginInfo($cfg_ml->M_ID);
if($cfg_ml->M_ID>0) $burl = "control.php";
else $burl = "javascript:;";

if(empty($_POST['m_orderid'])){
	echo "�Ƿ����ʣ�";
	exit();
}

//$m_id;                 //�̼Һ�	
//$m_oamount             //֧�����
//$modate		=	$modate;   //��������

$memberid	= 	$m_ocomment;			//��ע �����Ƿ���վ�ڵĻ�Ա���
$buyid	= 	ereg_replace("[^0-9A-Za-z]","",$m_orderid);   //�̼Ҷ�����
$mState		=	$_POST['m_status'];				         //֧��״̬2�ɹ�,3ʧ��
$OrderInfo	=	$OrderMessage;  //����������Ϣ
$signMsg 	=	$Digest;				   //�ܳ�
//�����µ�md5������֤
$newmd5info	=	$newmd5info;
$digest = strtoupper(md5($OrderInfo.$cfg_merpassword));
	
//���ص�У����Կ
$newtext = $m_id.$m_orderid.$m_oamount.$cfg_merpassword.$mState;
$myDigest = strtoupper(md5($newtext));
$mysign == md5($cfg_merchant.$buyid.$money.$success.$cfg_merpassword);
//--------------------------------------------------------

//ǩ����ȷ
if($digest == $signMsg && $mState==2){
	$OrderInfo = HexToStr($OrderInfo);
	if($newmd5info == $myDigest) //md5�ܳ���֤
	{
     $dsql = new DedeSql(false);
     //��ȡ������Ϣ����鶩������Ч��
     $row = $dsql->GetOne("Select * From #@__member_operation where buyid='$buyid' ");
     if(!is_array($row)||$row['sta']==2){
		   $oldinfo = $row['oldinfo'];
		   $msg = "�������Ѿ���ɣ���ϵͳ������Ϣ( $oldinfo ) <br><br> <a href='control.php'>������ҳ</a> ";
		   ShowMsg($msg,"javascript:;");
		   $dsql->Close();
		   exit();
	   }
	   $mid = $row['mid'];
	   $pid = $row['pid'];
     //���½���״̬Ϊ�Ѹ���
	   $dsql->ExecuteNoneQuery("Update #@__member_operation set sta=1 where buyid='$buyid' ");
	   //-------------------------------------------
	   //��Ա��Ʒ
	   //-------------------------------------------
	   if($row['product']=='member')
	   {
		    $row = $dsql->GetOne(" Select rank,exptime From #@__member_type where aid='{$row['pid']}' ");
		    $rank = $row['rank'];
		    $exptime = $row['exptime'];
		    $equery =  " Update #@__member set 
		                membertype='$rank',exptime='$exptime',uptime='".time()."' where ID='$mid' ";
		    $dsql->ExecuteNoneQuery($equery);
			  //���½���״̬Ϊ�ѹر�
			  $dsql->ExecuteNoneQuery(" Update #@__member_operation set sta=2,oldinfo='��Ա�����ɹ���' where buyid='$buyid' ");
		    $dsql->Close();
        ShowMsg("�ɹ���ɽ��ף�",$burl);
	      exit();
	   }
	   //�㿨��Ʒ
	   else if($row['product']=='card')
	   {
		    $row = $dsql->GetOne("Select cardid From #@__moneycard_record where ctid='$pid' And isexp='0' ");
		    //����Ҳ���ĳ�����͵Ŀ���ֱ��Ϊ�û����ӽ��
		    if(!is_array($row)){
		    	  $nrow = $dsql->GetOne("Select num From  #@__moneycard_type where tid='$pid' ");
		    	  $dnum = $nrow['num'];
		    	  $equery =  " Update #@__member set money=money+".$dnum." where ID='$mid' ";
		        $dsql->ExecuteNoneQuery($equery);
		        //���½���״̬Ϊ�ѹر�
			      $dsql->ExecuteNoneQuery(" Update #@__member_operation set sta=2,oldinfo='ֱ�ӳ�ֵ�� {$dnum} ��ҵ��ʺţ�' where buyid='$buyid' ");
		        ShowMsg("���ڴ˵㿨�Ѿ����꣬ϵͳֱ��Ϊ����ʺ������ˣ�{$dnum} ����ң�",$burl);
		        $dsql->Close();
		        exit();
		    }else{
		    	 $cardid = $row['cardid'];
		    	 $dsql->ExecuteNoneQuery(" Update #@__moneycard_record set uid='$mid',isexp='1',utime='".time()."' where cardid='$cardid' ");
		    	 //���½���״̬Ϊ�ѹر�
			     $dsql->ExecuteNoneQuery(" Update #@__member_operation set sta=2,oldinfo='��ֵ���룺{$cardid}' where buyid='$buyid' ");
		    	 ShowMsg("���׳ɹ���<a href='control.php'><u>[����]</u></a><br> ��ֵ���룺{$cardid}","javascript:;");
		    	 $dsql->Close();
		       exit();
		    }
	   }
  }else{
  	ShowMsg("������Կ�����������Ա��ϵ��",$burl);
	  exit();
  }
}else{
	ShowMsg("������Կ�����������Ա��ϵ��",$burl);
	exit();
}
?>
