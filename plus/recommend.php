<?
require(dirname(__FILE__)."/../include/config_base.php");
require(dirname(__FILE__)."/../include/inc_channel_unit.php");
if(!isset($action)) $action = "";
if(!empty($artID)) $arcID = $artID;
if(!isset($arcID)) $arcID = "";
$arcID = ereg_replace("[^0-9]","",$arcID);
if(empty($arcID)){
	  ShowMsg("�ĵ�ID����Ϊ��!","-1");
	  exit();
}
//////////////////////////////////////////////
if($action=="")
{
  $dsql = new DedeSql(false);
  //��ȡ�ĵ���Ϣ
  $arctitle = "";
  $arcurl = "";
  $arcRow = $dsql->GetOne("Select #@__archives.title,#@__archives.senddate,#@__archives.arcrank,#@__archives.ismake,#@__archives.money,#@__archives.typeid,#@__arctype.typedir,#@__arctype.namerule From #@__archives  left join #@__arctype on #@__arctype.ID=#@__archives.typeid where #@__archives.ID='$arcID'");
  if(is_array($arcRow)){
	  $arctitle = $arcRow['title'];
	  $arcurl = GetFileUrl($arcID,$arcRow['typeid'],$arcRow['senddate'],$arctitle,$arcRow['ismake'],$arcRow['arcrank'],$arcRow['namerule'],$arcRow['typedir'],$arcRow['money']);
  }
  else{
	  $dsql->Close();
	  ShowMsg("�޷���δ֪�ĵ��Ƽ�������!","-1");
	  exit();
  }
  $dsql->Close();
}
//�����Ƽ���Ϣ
//-----------------------------------
else if($action=="send")
{
	if(!eregi("(.*)@(.*)\.(.*)",$email)){
	  echo "<script>alert('Email����ȷ!');history.go(-1);</script>";
	  exit();
  }
  $mailbody = "";
  $msg = ereg_replace("[><]","",$msg);
  $mailtitle = "��ĺ��Ѹ����Ƽ���һƪ����";
  $mailbody .= "$msg \r\n\r\n";
  $mailbody .= "Power by http://www.dedecms.com ֯�����ݹ���ϵͳ��";
  if(eregi("(.*)@(.*)\.(.*)",$email)){
	  $headers = "From: ".$cfg_adminemail."\r\nReply-To: ".$cfg_adminemail;
    @mail($email, $mailtitle, $mailbody, $headers);
  }
  ShowMsg("�ɹ��Ƽ�һƪ����!",$arcurl);
  exit();
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�Ƽ�����</title>
<link href="../base.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style2 {
	color: #CC0000;
	font-size: 11pt;
}
-->
</style>
</head>
<body>
<table width="650" border="0" align="center" cellspacing="2">
<tr> 
<td><img src="img/recommend.gif" width="320" height="46"></td>
</tr>
<tr> 
<td bgcolor="#CCCC99" height="6"></td>
</tr>
<tr> 
<td height="28">
<span class="style2">&nbsp;�������ƣ�<a href="<? echo $arcurl ?>"><? echo $arctitle ?></a></span>
</td>
</tr>
<tr> 
<td bgcolor="#DFEAE4">&nbsp;��Ҫ�������͸��ҵĺ��ѣ�</td>
</tr>
<tr> 
<td> <table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr> 
<td height="3"></td>
</tr>
<tr> 
<td height="100" align="center" valign="top">
<form name="form1" method="post" action="recommend.php">
<input type="hidden" name="arcurl" value="<? echo $arcurl ?>">
<input type="hidden" name="action" value="send">
<input type="hidden" name="arcID" value="<?=$arcID?>">
<table width="98%" border="0" cellspacing="0" cellpadding="0">
<tr> 
<td width="19%" height="30">����ѵ�Email��</td>
<td width="81%">
	<input name="email" type="text" id="email"> 
</td>
</tr>
<tr> 
<td height="30">������ԣ�</td>
<td>&nbsp;</td>
</tr>
<tr align="center"> 
<td height="61" colspan="2">
<textarea name="msg" cols="72" rows="6" id="msg" style="width:98%">
��ã����� [<?=$cfg_webname?>] ������һ���ܺõĶ�����
�㲻��ȥ�����ɣ�
�ĵ��������ǣ�<?=$arctitle?>
��ַ�ǣ�<?=$cfg_basehost.$arcurl?>
</textarea>
</td>
</tr>
<tr> 
<td height="50">&nbsp;</td>
<td><input type="submit" name="Submit" value=" �� �� "></td>
</tr>
</table>
</form>
</td>
</tr>
<tr> 
<td height="3"></td>
</tr>
</table></td>
</tr>
<tr> 
<td bgcolor="#CCCC99" height="6"></td>
</tr>
<tr> 
<td align="center">
<?=$cfg_powerby?>
</td>
</tr>
</table>
</td>
</tr>
</table>
</body>
</html>
