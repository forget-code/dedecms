<?
require("config.php");
if(empty($job)) $job="";
if($job=="ok")
{
      $mypic = $base_dir."/member/upimg/$ID.jpg";
      if(file_exists($mypic)) unlink($mypic);
      $conn=connectMySql();
      @mysql_query("Delete From dede_member where ID=".$ID,$conn);
      echo "<script>alert('�ɹ�ɾ��һ���û���');location.href='".$ENV_GOBACK_URL."';</script>";
      exit();
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>ɾ���ļ�</title>
<link href="base.css" rel="stylesheet" type="text/css">
<script src="menu.js" language="JavaScript"></script>
<style>
.bt{border-left: 1px solid #FFFFFF; border-right: 1px solid #666666; border-top: 1px solid #FFFFFF; border-bottom: 1px solid #666666; background-color: #C0C0C0}
</style>
</head>
<body background="img/allbg.gif" leftmargin="8" topmargin="8">
<table width="300" border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#666666">
  <form name="form1" action="user_del.php" method="post">
    <input type="hidden" name="ID" value="<? echo $ID ?>">
    <input type="hidden" name="job" value="ok">
    <tr align="center"> 
      <td height="26" colspan="2" background='img/tbg.gif'><strong>ɾ��ȷ��</strong></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="50" colspan="2" align="center"> ��ȷ��Ҫɾ������û�[ 
        <?=$user?>
        ]��</td>
    </tr>
    <tr align="center" bgcolor="#EFEFEF"> 
      <td height="28" colspan="2"> <input type="button" name="Submit" value=" ȷ �� " onclick="document.form1.submit();" class="bt"> 
        &nbsp;&nbsp; <input type="button" name="Submit2" value=" ȡ �� " onclick="history.go(-1);" class="bt"></td>
    </tr>
  </form>
</table>
</body>

</html>
