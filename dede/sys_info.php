<?
require_once(dirname(__FILE__)."/config.php");
CheckPurview('sys_Edit');
if(empty($dopost)) $dopost = "";
$configfile = dirname(__FILE__)."/../include/config_hand.php";
$configfile_bak = dirname(__FILE__)."/../include/config_hand_bak.php";

if(!is_writeable($configfile)){
	echo "�����ļ�'{$configfile}'��֧��д�룬�Ͻ��޸�ϵͳ���ò�����";
	exit();
}

//�������
if($dopost=="save")
{
	$dsql = new DedeSql(false);
	foreach($_POST as $k=>$v){
		if(ereg("^edit___",$k)) $v = cn_substr(${$k},250);
		else continue;
		$k = ereg_replace("^edit___","",$k);
		$dsql->ExecuteNoneQuery("Update #@__sysconfig set value='$v' where varname='$k'");
	}
	copy($configfile,$configfile_bak);
	$fp = fopen($configfile,'w');
	flock($fp,3);
	fwrite($fp,"<"."?\r\n");
	$dsql->SetQuery("Select varname,value From #@__sysconfig order by aid asc");
  $dsql->Execute();
  while($row = $dsql->GetArray()){
  	fwrite($fp,"\${$row['varname']} = '".str_replace("'","",$row['value'])."';\r\n");
  }
  fwrite($fp,"?".">");
  fclose($fp);
	$dsql->Close();
	ShowMsg("�ɹ�����վ�����ã�","sys_info.php");
	exit();
}
?>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
<title>ϵͳ���ò���</title>
<link href='base.css' rel='stylesheet' type='text/css'>
</head>
<body background='img/allbg.gif' leftmargin='8' topmargin='8'>
<table width="98%" border="0" cellpadding="2" cellspacing="1" bgcolor="#666666" align="center">
<tr>
<td height="23" background="img/tbg.gif">
	&nbsp;<b>DedeCmsϵͳ���ò�����</b>
</td>
</tr>
<tr> 
<td bgcolor="#FFFFFF">
<table width="100%" border="0" cellspacing="1" cellpadding="1">
<form action="sys_info.php" method="post" name="form1">
<input type="hidden" name="dopost" value="save">
<tr align="center" bgcolor="#E6F7CA" height="25"> 
<td width="35%">����˵��</td>
<td width="45%">����ֵ</td>
<td width="20%">������</td>
</tr>
<?
$dsql = new DedeSql(false);
$dsql->SetQuery("Select * From #@__sysconfig order by aid asc");
$dsql->Execute();
$i = 1;
while($row = $dsql->GetArray())
{
	if($i%2==0) $bgcolor = "#FDFDF2";
	else $bgcolor = "#F4FCDC";
	$i++;
?>
<tr align="center" height="25" bgcolor="<?=$bgcolor?>" 
	onMouseMove="javascript:this.bgColor='#D9EF96';" 
	onMouseOut="javascript:this.bgColor='<?=$bgcolor?>';"> 
<td> 
<?=$row['info']?>��
</td>
<td align="left">
<?
if($row['type']=='bool'){
	$c1=""; $c2 = "";
	$row['value']=='��' ? $c1=" checked" : $c2=" checked";
	echo "<input type='radio' class='np' name='edit___{$row['varname']}' value='��'$c1>�� ";
	echo "<input type='radio' class='np' name='edit___{$row['varname']}' value='��'$c2>�� ";
}else if(strlen($row['value'])>30){
  echo "<textarea name='edit___{$row['varname']}' row='4' id='edit___{$row['varname']}' style='width:100%;height:50'>{$row['value']}</textarea>";
}else{
  echo "<input type='text' name='edit___{$row['varname']}' id='edit___{$row['varname']}' value='{$row['value']}' style='width:80%'>";
}
?>
</td>
<td><?=$row['varname']?></td>
</tr>
<?
}
$dsql->Close();
?>
<tr bgcolor="#FFCC00"> 
<td height="26" colspan="3">
	<strong>&nbsp;�޸����ú�ϵͳ����� ../include/config_hand.php �ļ����壬����������⣬���� config_hand_bak.php ��ԭ��<strong>
</td>
</tr>
<tr bgcolor="#F3FFDD"> 
<td height="50" colspan="3">
	<table width="98%" border="0" cellspacing="1" cellpadding="1">
<tr> 
<td width="11%">&nbsp;</td>
<td width="11%"><input name="imageField" type="image" src="img/button_ok.gif" width="60" height="22" border="0" class="np"></td>
<td width="78%"><img src="img/button_reset.gif" width="60" height="22" style="cursor:hand" onclick="document.form1.reset()"></td>
</tr>
</table> </td>
</tr>
</form>
</table>
</td>
</tr>
</table>
<center>
</center>
</body>
</html>