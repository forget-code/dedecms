<?
require_once(dirname(__FILE__)."/config.php");
require_once(dirname(__FILE__)."/../include/inc_typelink.php");
SetPageRank(10);
if(empty($dopost)) $dopost = "";
$ID = ereg_replace("[^0-9]","",$ID);
/////////////////////////////////////////////
if($dopost=="saveedit")
{
	$pwd = trim($pwd);
	if($pwd!="" && ereg("[^0-9a-zA-Z_@\!\.-]",$pwd)){
		ShowMsg("���벻�Ϸ���","-1",0,300);
		exit();
	}
	$dsql = new DedeSql();
	if($pwd!="") $pwd = ",pwd='".md5($pwd)."'";
	$dsql->SetQuery("Update #@__admin set uname='$uname',usertype='$usertype',typeid='$typeid' $pwd where ID='$ID'");
	$dsql->Execute();
	$dsql->Close();
	ShowMsg("�ɹ�����һ���ʻ���","sys_admin_user.php");
	exit();
}
else if($dopost=="delete")
{
	if(empty($userok)) $userok="";
	if($userok!="yes")
	{
	   require_once(dirname(__FILE__)."/../include/pub_oxwindow.php");
	   $wintitle = "ɾ���û�";
	   $wecome_info = "<a href='sys_admin_user.php'>ϵͳ�ʺŹ���</a>::ɾ���û�";
	   $win = new OxWindow();
	   $win->Init("sys_admin_user_edit.php","js/blank.js","POST");
	   $win->AddHidden("dopost",$dopost);
	   $win->AddHidden("userok","yes");
	   $win->AddHidden("ID",$ID);
	   $win->AddTitle("ϵͳ���棡");
	   $win->AddMsgItem("��ȷ��Ҫɾ���û���$userid ��","50");
	   $winform = $win->GetWindow("ok");
	   $win->Display();
	   exit();
  }
	$dsql = new DedeSql();
	$dsql->SetQuery("Delete From #@__admin where ID='$ID'");
	$dsql->Execute();
	$dsql->Close();
	ShowMsg("�ɹ�ɾ��һ���ʻ���","sys_admin_user.php");
	exit();
}
//////////////////////////////////////////
$dsql = new DedeSql();
$row = $dsql->GetOne("Select * From #@__admin where ID='$ID'");
$tl = new TypeLink($row['typeid']);
$typeOptions = $tl->GetOptionArray($row['typeid'],0,0);
?>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
<title>����Ա�ʺ�--�����ʺ�</title>
<link href='base.css' rel='stylesheet' type='text/css'>
</head>
<body background='img/allbg.gif' leftmargin='8' topmargin='8'>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#666666">
  <tr>
    <td height="19" background="img/tbg.gif" bgcolor="#E7E7E7"> 
      <table width="96%" border="0" cellspacing="1" cellpadding="1">
        <tr> 
          <td width="24%"><b><strong>�����ʺ�</strong></b> </td>
          <td width="76%" align="right"><strong><a href="sys_admin_user.php"><u>�����ʺ�</u></a></strong></td>
        </tr>
      </table></td>
</tr>
<tr>
    <td height="215" align="center" valign="top" bgcolor="#FFFFFF">
	<form name="form1" action="sys_admin_user_edit.php" method="post">
	<input type="hidden" name="dopost" value="saveedit">
	<input type="hidden" name="ID" value="<?=$row['ID']?>">
        <table width="98%" border="0" cellspacing="1" cellpadding="1">
          <tr> 
            <td width="16%" height="30">�û���¼ID��</td>
            <td width="84%"><?=$row['userid']?></td>
          </tr>
          <tr> 
            <td height="30">�û�������</td>
            <td><input name="uname" type="text" id="uname" size="16" value="<?=$row['uname']?>" style="width:150"> &nbsp;���������º���ʾ���α༭�����֣�</td>
          </tr>
          <tr> 
            <td height="30">�û����룺</td>
            <td><input name="pwd" type="text" id="pwd" size="16" style="width:150"> &nbsp;���ղ��䣬ֻ����'0-9'��'a-z'��'A-Z'��'.'��'@'��'_'��'-'��'!'���ڷ�Χ���ַ���</td>
          </tr>
          <tr> 
            <td height="30">�û����ͣ�</td>
            <td>
			  <select name='usertype' style='width:150'>
			  	<?
			  	$dsql->SetQuery("Select * from #@__admintype order by rank asc");
			  	$dsql->Execute("ut");
			  	while($myrow = $dsql->GetObject("ut"))
			  	{
			  		if($row['usertype']==$myrow->rank) echo "<option value='".$myrow->rank."' selected>".$myrow->typename."</option>\r\n";
			  		else echo "<option value='".$myrow->rank."'>".$myrow->typename."</option>\r\n";
			  	}
			  	?>
			  </select>
         </td>
          </tr>
          <tr> 
            <td height="30">����Ƶ����</td>
            <td>
			<select name="typeid" style="width:300" id="typeid">
        <option value="0" selected>--����Ƶ��--</option>
				<?=$typeOptions?>
       </select>
			 </td>
          </tr>
          <tr> 
            <td height="30">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td height="30">&nbsp;</td>
            <td><input type="submit" name="Submit" value=" �����û� "></td>
          </tr>
        </table>
      </form>
	  </td>
</tr>
</table>
<?
$tl->Close();
$dsql->Close();
?>
</body>
</html>