<?php 
require_once(dirname(__FILE__)."/../include/config_base.php");
require_once(dirname(__FILE__)."/../include/inc_memberlogin.php");
require_once(dirname(__FILE__)."/../include/pub_httpdown.php");
require_once(dirname(__FILE__)."/config_pay_allbuy.php");

$cfg_ml = new MemberLogin(); 
$cfg_ml->PutLoginInfo($cfg_ml->M_ID);
if($cfg_ml->M_ID>0) $burl = "control.php";
else $burl = "javascript:;";

if(empty($billno)){
	echo "�Ƿ����ʣ�";
	exit();
}

$mySign = md5($cfg_merchant.$billno.$amount.$success.$cfg_merpassword);
$buyid = $billno;


//ǩ����ȷ
if($sign == $mySign && $success=="Y"){
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
		    
		    //��֧���ӿڷ�����Ϣ
		    $dhd = new DedeHttpDown();
   	    @$dhd->OpenUrl("http://www.allbuy.cn/merchant/checkfeedback.asp?".$_SERVER["QUERY_STRING"]);
   	    @$staCode = $dhd->GetHtml();
   	    $dhd->Close();
   	    
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
		        
		        //��֧���ӿڷ�����Ϣ
		        $dhd = new DedeHttpDown();
   	        @$dhd->OpenUrl("http://www.allbuy.cn/merchant/checkfeedback.asp?".$_SERVER["QUERY_STRING"]);
   	        @$staCode = $dhd->GetHtml();
   	        $dhd->Close();
		        
		        ShowMsg("���ڴ˵㿨�Ѿ����꣬ϵͳֱ��Ϊ����ʺ������ˣ�{$dnum} ����ң�",$burl);
		        $dsql->Close();
		        exit();
		    }else{
		    	 $cardid = $row['cardid'];
		    	 $dsql->ExecuteNoneQuery(" Update #@__moneycard_record set uid='$mid',isexp='1',utime='".time()."' where cardid='$cardid' ");
		    	 //���½���״̬Ϊ�ѹر�
			     $dsql->ExecuteNoneQuery(" Update #@__member_operation set sta=2,oldinfo='��ֵ���룺{$cardid}' where buyid='$buyid' ");
		    	 
		    	 //��֧���ӿڷ�����Ϣ
		        $dhd = new DedeHttpDown();
   	        @$dhd->OpenUrl("http://www.allbuy.cn/merchant/checkfeedback.asp?".$_SERVER["QUERY_STRING"]);
   	        @$staCode = $dhd->GetHtml();
   	        $dhd->Close();
		    	 
		    	 ShowMsg("���׳ɹ���<a href='control.php'><u>[����]</u></a><br> ��ֵ����Ϊ��{$cardid}","javascript:;");
		    	 $dsql->Close();
		       exit();
		    }
	  }
}else{
	ShowMsg("���״����������Ա��ϵ��",$burl);
	exit();
}
?>
