<?php 
require_once(dirname(__FILE__)."/config.php");
CheckRank(0,0);

if(empty($dopost)) $dopost = "";
$dsql = new DedeSql(false);

if($dopost=="addnew"){
	PrintAjaxHead();
	$row = $dsql->GetOne("Select count(*) as dd From #@__member_flink where mid='".$cfg_ml->M_ID."' ");
	if($row['dd']>=20){
	  echo "<font color='red'>��������ʧ�ܣ���Ϊ�Ѿ��ﵽ��ʮ�����ӵ����ޣ�</font>";
	  GetLinkList($dsql);
	  $dsql->Close();
	  exit();
	}
	if($imgurl!="" && !eregi("^http://",$imgurl)){ $imgurl = "http://".$imgurl; }
	if(!eregi("^http://",$url)){ $url = "http://".$url; }
	$imgwidth = trim(ereg_replace("[^0-9]","",$imgwidth));
	$imgheight = trim(ereg_replace("[^0-9]","",$imgheight));
	$linktype = ereg_replace("[^0-9]","",$linktype);
	if(empty($imgwidth) || $imgwidth>150) $imgwidth = 88;
	if(empty($imgheight) || $imgheight>60) $imgwidth = 31;
	$inquery = "
	  INSERT INTO `#@__member_flink`(mid,title,url,linktype,imgurl,imgwidth,imgheight) 
  VALUES(".$cfg_ml->M_ID.",'$title','$url','$linktype','$imgurl','$imgwidth','$imgheight');
	";
	$dsql->ExecuteNoneQuery($inquery);
	echo "<font color='red'>�ɹ�����һ���ӣ�</font>";
	GetLinkList($dsql);
	$dsql->Close();
	exit();
}
else if($dopost=="del"){
	PrintAjaxHead();
	$aid = ereg_replace("[^0-9]","",$aid);
	if($aid==''||$aid==0){ echo ""; exit(); }
	$dsql->ExecuteNoneQuery("Delete From #@__member_flink where aid='$aid' And mid='".$cfg_ml->M_ID."';");
	echo "<font color='red'>�ɹ�ɾ�����ӣ�{$aid}";
	GetLinkList($dsql);
	$dsql->Close();
}
else if($dopost=="update"){
	PrintAjaxHead();
	$aid = ereg_replace("[^0-9]","",$aid);
	if($imgurl!="" && !eregi("^http://",$imgurl)){ $imgurl = "http://".$imgurl; }
	if(!eregi("^http://",$url)){ $url = "http://".$url; }
	$imgwidth = trim(ereg_replace("[^0-9]","",$imgwidth));
	$imgheight = trim(ereg_replace("[^0-9]","",$imgheight));
	$linktype = ereg_replace("[^0-9]","",$linktype);
	if(empty($imgwidth) || $imgwidth>150) $imgwidth = 88;
	if(empty($imgheight) || $imgheight>60) $imgwidth = 31;
	$upquery = "
	  Update #@__member_flink set 
	  title='$title',url='$url',linktype='$linktype',
	  imgurl='$imgurl',imgwidth='$imgwidth',imgheight='$imgheight'
	  where aid='$aid' And mid='".$cfg_ml->M_ID."';
	";
	$rs = $dsql->ExecuteNoneQuery($upquery);
	if($rs){
		echo "<font color='red'>�ɹ��������ӣ�{$title}";
		GetLinkList($dsql);
		$dsql->Close();
		exit();
	}
	else{
		echo "<font color='red'>�������ӣ�{$title} ʧ�ܣ�</font>";
		GetLinkList($dsql);
		$dsql->Close();
		exit();
	}
}
else if($dopost=="reload"){
	PrintAjaxHead();
	GetLinkList($dsql);
  $dsql->Close();
	exit();
}
else{ //Ĭ�Ͻ���
    require_once(dirname(__FILE__)."/templets/flink_main.htm");
}


//����
function GetLinkList($dsql){
	global $cfg_ml;
	$dsql->SetQuery("Select * From #@__member_flink where mid='".$cfg_ml->M_ID."' order by aid desc");
	$dsql->Execute();
	$j=0;
	while($row = $dsql->GetArray())
	{
		 $j++;
		 $check1 = '';$check2='';
		 if($row['linktype']==2) $check2 = ' checked';
		 else $check1 = ' checked';
		 $line = "
<table width='98%' border='0' cellpadding='3' cellspacing='1' bgcolor='#CCCCCC' style='margin-bottom:10px'>
<tr bgcolor='#F5F7F4'> 
<td width='10%' align='center'>����</td>
<td>
<input name='title{$row['aid']}' type='text' id='title{$row['aid']}' value='{$row['title']}' style='width:150px' class='cinput'>
��ַ <input name='url{$row['aid']}' type='text' id='url{$row['aid']}' value='{$row['url']}' style='width:150px' class='cinput'> 
<input name='linktype{$row['aid']}' id='linktype{$row['aid']}1' type='radio' value='1'$check1>
���� 
<input type='radio' id='linktype{$row['aid']}2' name='linktype{$row['aid']}' value='2'$check2>
ͼƬ
</td></tr>
<tr bgcolor='#FFFFFF'> 
<td align='center'>ͼƬ</td>
<td>��ַ�� 
<input name='imgurl{$row['aid']}' value='{$row['imgurl']}' type='text' id='imgurl{$row['aid']}' style='width:120px' class='cinput'>
�� 
<input name='imgwidth{$row['aid']}' value='{$row['imgwidth']}' type='text' id='imgwidth{$row['aid']}' style='width:30px' value='88' class='cinput'>
�ߣ� 
<input name='imgheight{$row['aid']}' value='{$row['imgheight']}' type='text' id='imgheight{$row['aid']}' style='width:30px' value='31' class='cinput'> ��������
				 
[<a href='#' onclick='UpdateType({$row['aid']})'>����</a>]

[<a href='#' onclick='DelType({$row['aid']})'>ɾ��</a>]

</td></tr></table>";
      echo $line;
    }
    if($j==0) echo "�����κ�����";
}

function PrintAjaxHead(){
	header("Pragma:no-cache\r\n");
  header("Cache-Control:no-cache\r\n");
  header("Expires:0\r\n");
	header("Content-Type: text/html; charset=gb2312");
}
?>