<?php 
require_once(dirname(__FILE__)."/config.php");
CheckRank(0,0);

if($dopost=="addnew"){
	header("Pragma:no-cache\r\n");
  header("Cache-Control:no-cache\r\n");
  header("Expires:0\r\n");
	header("Content-Type: text/html; charset=gb2312");
	$dsql = new DedeSql(false);
	$row = $dsql->GetOne("Select count(*) as dd From #@__member_arctype where memberid='".$cfg_ml->M_ID."';");
	if($row['dd']>=16){
		PrintTypeList("<font color='red'>�㲻�ܶ��峬��ʮ�������࣡</font>");
		exit();
	}else{
		$typename = cn_substr(trim(ereg_replace($cfg_egstr,"",stripslashes($typename))),50);
    $typename = trim(addslashes($typename));
		if($typename==""){
			PrintTypeList("<font color='red'>�������ƷǷ���Ϊ�գ�</font>");
			exit();
		}
		$rank = ereg_replace("[^0-9]","",trim($rank));
		if($channelid!=1 && $channelid!=2) $channelid = 1;
		$row = $dsql->GetOne("Select typename From #@__member_arctype where memberid='".$cfg_ml->M_ID."' And typename='$typename' And channelid='$channelid';");
		if(is_array($row)){
			PrintTypeList("<font color='red'>���Ѿ�����ͬ���ķ��࣡</font>");
			exit();
		}
		if($rank=="") $rank = 0;
		$dsql->ExecuteNoneQuery("Insert Into #@__member_arctype(typename,memberid,channelid,rank) Values('$typename','".$cfg_ml->M_ID."','$channelid','$rank'); ");
		$dsql->Close();
		PrintTypeList();
	}
}
else if($dopost=="reload"){
	header("Pragma:no-cache\r\n");
  header("Cache-Control:no-cache\r\n");
  header("Expires:0\r\n");
	header("Content-Type: text/html; charset=gb2312");
	PrintTypeList("",$orderby);
}
else if($dopost=="del"){
	header("Pragma:no-cache\r\n");
  header("Cache-Control:no-cache\r\n");
  header("Expires:0\r\n");
	header("Content-Type: text/html; charset=gb2312");
	$aid = ereg_replace("[^0-9]","",$aid);
	if($aid==''||$aid==0){ echo ""; exit(); }
	$dsql = new DedeSql(false);
	$dsql->ExecuteNoneQuery("Delete From #@__member_arctype where aid='$aid' And memberid='".$cfg_ml->M_ID."';");
	$dsql->Close();
	PrintTypeList("<font color='red'>�ɹ�ɾ��һ���࣡</font>");
}
else if($dopost=="update"){
	header("Pragma:no-cache\r\n");
  header("Cache-Control:no-cache\r\n");
  header("Expires:0\r\n");
	header("Content-Type: text/html; charset=gb2312");
	$dsql = new DedeSql(false);
	$typename = cn_substr(trim(ereg_replace($cfg_egstr,"",stripslashes($typename))),50);
  $typename = trim(addslashes($typename));
	if($typename==""){
		PrintTypeList("<font color='red'>�������Ʋ���Ϊ�գ�</font>");
		exit();
	}
	$rank = ereg_replace("[^0-9]","",trim($rank));
	$aid = ereg_replace("[^0-9]","",$aid);
	$row = $dsql->GetOne("Select typename From #@__member_arctype where aid!='$aid' And memberid='".$cfg_ml->M_ID."' And typename='$typename';");
	if(is_array($row)){
		PrintTypeList("<font color='red'>����ͬ�����࣬���·��� {$aid} Ϊ��{$typename} ʧ�ܣ�</font>");
		exit();
	}
	$upquery = "
	  Update #@__member_arctype set 
	  typename='$typename',rank='$rank' 
	  where aid='$aid' And memberid='".$cfg_ml->M_ID."';
	";
	$rs = $dsql->ExecuteNoneQuery($upquery);
	$dsql->Close();
	if($rs) PrintTypeList("<font color='red'>�ɹ����·��ࣺ{$typename}");
	else PrintTypeList("<font color='red'>���·��ࣺ{$typename} ʧ�ܣ�</font>");
}
//-----------
//������Ŀ�б�
//-----------
function PrintTypeList($addstr="",$orderby=0){
	global $cfg_ml;
	$dsql = new DedeSql(false);
	echo $addstr;
	echo "<table width='98%' border='0' cellpadding='3' cellspacing='1' bgcolor='#CCCCCC' style='margin-bottom:10px'>\r\n";
	echo "<tr align='center' bgcolor='#FBFCD1'>\r\n";
	echo "<td width='11%'>ID</td>\r\n";
  echo "<td width='32%'>��������</td>\r\n";
  echo "<td width='15%'><a href='javascript:ReLoadList(1)'><u>��������</u></a></td>\r\n";
  echo "<td width='18%'><a href='javascript:ReLoadList(0)'><u>���򼶱�</u></a></td>\r\n";
  echo "<td>����</td>\r\n</tr>\r\n";
  if($orderby==1) $orderby = " order by channelid desc ";
  else $orderby = " order by rank desc ";
  $dsql->SetQuery("Select * From #@__member_arctype where memberid='".$cfg_ml->M_ID."' $orderby");
  $dsql->Execute();
  while($row = $dsql->GetObject()){
  	if($row->channelid==1){ $cktype = " ���� "; }
  	else{ $cktype = " <font color='#3C9636'>ͼ��<font> "; }
  	echo "<tr align='center' bgcolor='#FFFFFF' onMouseMove=\"javascript:this.bgColor='#EFEFEF';\" onMouseOut=\"javascript:this.bgColor='#FFFFFF';\">\r\n";
  	echo "<td>{$row->aid}</td>\r\n";
    echo "<td><input name='typename{$row->aid}' type='text' id='typename{$row->aid}' style='width:150px' value='{$row->typename}'></td>\r\n";
    echo "<td>{$cktype}</td>\r\n";
    echo "<td><input name='rank{$row->aid}' type='text' id='rank{$row->aid}' style='width:60px' value='{$row->rank}'></td>\r\n";
    echo "<td>��<a href='#' onclick='UpdateType({$row->aid})'>����</a>�ݣ�<a href='#' OnClick='DelType({$row->aid})'>ɾ��</a>��</td>\r\n</tr>\r\n";
  }
	echo "</table>\r\n";
	$dsql->Close();
}
?>