<?
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
//����Ķ�Ȩ��
//--------------------
$needMoney = $arc->Fields['money'];
$needRank = $arc->Fields['arcrank'];
//������Ȩ�����Ƶ�����
//arctitle msgtitle moremsg
//------------------------------------
if($needMoney>0 || $needRank>1)
{
	require_once(dirname(__FILE__)."/../include/inc_memberlogin.php");
	$ml = new MemberLogin();
	$arctitle = $arc->Fields['title'];
	$arclink = $arc->TypeLink->GetFileUrl($arc->ArcID,
	                $arc->Fields["typeid"],
	                $arc->Fields["senddate"],
	                $arc->Fields["title"],
	                $arc->Fields["ismake"],
	                $arc->Fields["arcrank"]
	           );
	$description =  $arc->Fields["description"]; 
	$pubdate = GetDateTimeMk($arc->Fields["pubdate"]);
	//��Ա������
	if(($needRank>1 && $ml->M_Type < $needRank && $arc->Fields['memberID']!=$ml->M_ID))
	{
		$dsql = new DedeSql(false);
		$dsql->SetQuery("Select * From #@__arcrank");
		$dsql->Execute();
		while($row = $dsql->GetObject()){
			$memberTypes[$row->rank] = $row->membername;
		}
		$memberTypes[0] = "��ͨ��Ա";
		$dsql->Close();
		$msgtitle = "û��Ȩ�ޣ�";
		$moremsg = "��ƪ�ĵ���Ҫ<font color='red'>".$memberTypes[$needRank]."</font>���ܷ��ʣ���Ŀǰ�ǣ�<font color='red'>".$memberTypes[$ml->M_Type]."</font>";
		include_once($cfg_basedir.$cfg_templets_dir."/plus/view_msg.htm");
		exit();
	}
	//û���㹻�Ľ��
	if(($needMoney > $ml->M_Money  && $arc->Fields['memberID']!=$ml->M_ID) || $ml->M_Money=='')
	{
		$msgtitle = "û��Ȩ�ޣ�";
		$moremsg = "��ƪ�ĵ���Ҫ <font color='red'>".$needMoney." ���</font> ���ܷ��ʣ���Ŀǰӵ�н�ң�<font color='red'>".$ml->M_Money." ��</font>";
		include_once($cfg_basedir.$cfg_templets_dir."/plus/view_msg.htm");
		$arc->Close();
		exit();
	}
	//����Ϊ����������Զ��۵���
	if($needMoney > 0  && $arc->Fields['memberID']!=$ml->M_ID) //���������Ҫ��ң�����û��Ƿ���������ĵ�
	{
		$dsql = new DedeSql(false);
		$row = $dsql->GetOne("Select aid,money From #@__moneyrecord where aid='$aid' And uid='".$ml->M_ID."'");
		if(!is_array($row))
		{
		  $inquery = "
		  INSERT INTO #@__moneyrecord(aid,uid,title,money,dtime) 
      VALUES ('$aid','".$ml->M_ID."','$arctitle','$needMoney','".mytime()."');
		  ";
		  $dsql->SetQuery($inquery);
		  if($dsql->ExecuteNoneQuery()){
		  	$inquery = "Update #@__member set money=money-$needMoney where ID='".$ml->M_ID."'";
		    $dsql->SetQuery($inquery);
		    $dsql->ExecuteNoneQuery();
		  }
		  $ml->PutCookie("DedeUserMoney",$ml->M_Money - $needMoney);
		}
		$dsql->Close();
	}
}

$arc->Display();
?>