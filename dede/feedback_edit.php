<?php 
require_once(dirname(__FILE__)."/config.php");
CheckPurview('sys_Feedback');
$ID = ereg_replace("[^0-9]","",$ID);

if(empty($dopost)) $dopost = "";
if(empty($_COOKIE['ENV_GOBACK_URL'])) $ENV_GOBACK_URL="feedback_main.php";
else $ENV_GOBACK_URL = $_COOKIE['ENV_GOBACK_URL'];

$dsql = new DedeSql(false);

if($dopost=="edit")
{
   $msg = cn_substr($msg,1500);
   $adminmsg = trim($adminmsg);
   if($adminmsg!="")
   {
	  $adminmsg = cn_substr($adminmsg,1500);
	  $adminmsg = str_replace("<","&lt;",$adminmsg);
	  $adminmsg = str_replace(">","&gt;",$adminmsg);
	  $adminmsg = str_replace("  ","&nbsp;&nbsp;",$adminmsg);
	  $adminmsg = str_replace("\r\n","<br/>\n",$adminmsg);
	  $msg = $msg."<br/>\n"."<font color=red>����Ա�ظ��� $adminmsg</font>\n";
   }
   $query = "update #@__feedback set username='$username',msg='$msg',ischeck=1 where ID=$ID";
   $dsql->SetQuery($query);
   $dsql->ExecuteNoneQuery();
   $dsql->Close();
   ShowMsg("�ɹ��ظ�һ�����ԣ�",$ENV_GOBACK_URL);
   exit();
}

$query = "select * from #@__feedback where ID=$ID";
$dsql->SetQuery($query);
$dsql->Execute();
$row = $dsql->GetObject();
$dsql->Close();
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�༭����</title>
<style type="text/css">
<!--
body {
	background-image: url(img/allbg.gif);
}
-->
</style>
<link href="base.css" rel="stylesheet" type="text/css">
</head>

<body>
&nbsp;
<table width="98%"  border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#98CAEF">
  <tr>
    <td width="100%" height="24" colspan="2" background="img/tbg.gif"><strong><a href="<?php echo $ENV_GOBACK_URL?>"><u>���۹���</u></a>&gt;&gt;�༭���ۣ�</strong></td>
  </tr>
  <tr>
    <td height="187" colspan="2" align="center" bgcolor="#FFFFFF">
	<form name="form1" method="post" action="feedback_edit.php">
	<input type="hidden" name="dopost" value="edit">
	<input type="hidden" name="ID" value="<?php echo $row->ID?>">
        <table width="98%" border="0" cellpadding="3" cellspacing="1" bgcolor="#ADA896">
          <tr bgcolor="#FFFFFF"> 
            <td width="21%" height="24">�����������£�</td>
            <td width="79%"> 
              <?php echo $row->arctitle?>
            </td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="24">�����ˣ�</td>
            <td> 
              <input name="username" type="text" id="username" size="20" value="<?php echo $row->username?>"> 
            </td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="24">���۷���ʱ�䣺</td>
            <td> 
              <?php echo GetDateTimeMK($row->dtime)?>
            </td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="24">IP��ַ��</td>
            <td> 
              <?php echo $row->ip?>
            </td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="24">�������ݣ�</td>
            <td>���ĵ���������HTML���벻�ᱻ���Σ�����HTML�﷨�༭��</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="62" align="center">&nbsp; </td>
            <td height="62"> 
              <textarea name="msg" cols="60" rows="5" id="textarea"><?php echo $row->msg?></textarea></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="24">����Ա�ظ���</td>
            <td>�ظ����ݵ�HTML����ᱻ���Ρ�</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="24" align="center">&nbsp; </td>
            <td height="24"> 
              <textarea name="adminmsg" cols="60" rows="5" id="textarea2"></textarea></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="40" colspan="2" align="center"> 
              <input type="submit" name="Submit" value="�������">
              �� 
              <input type="button" name="Submit2" value="������" onClick="location='<?php echo $ENV_GOBACK_URL?>';" class='nbt'></td>
          </tr>
        </table>
	  </form>
	  </td>
  </tr>
</table>
</body>
</html>