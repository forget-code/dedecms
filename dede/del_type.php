<?
require("config.php");
require("inc_typeunit.php");
if(!isset($job)) $job="";
if($job=="ok")
{
     $conn = connectMySql();
	 $ut = new TypeUnit();
	 $ut->DelType($ID,$delfile);
	 echo "<script>alert('�ɹ�ɾ��һ����Ŀ��');location.href='list_type.php';</script>";
	 exit();
	 
}
?>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
<title>ɾ����Ŀ</title>
<link href='base.css' rel='stylesheet' type='text/css'>
<script src='menu.js' language='JavaScript'></script>
</head>
<body background='img/allbg.gif' leftmargin='6' topmargin='6'>
<table width="80%" border="0" cellpadding="3" cellspacing="1" bgcolor="#666666">
  <tr> 
    <td height="19" background='img/tbg.gif'><a href="list_type.php"><u>��Ŀ����</u></a>&gt;&gt;ɾ����Ŀ</td>
  </tr>
  <tr> 
    <td height="95" align="center" bgcolor="#FFFFFF"> <table width="80%" border="0" cellspacing="0" cellpadding="0">
        <form name="form1" action="del_type.php" method="post">
          <input type="hidden" name="ID" value="<?=$ID?>">
          <input type="hidden" name="job" value="ok">
          <tr> 
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr> 
            <td colspan="2">��Ҫɾ��Ŀ¼��
              <?=$typeoldname?>
            </td>
          </tr>
          <tr> 
            <td colspan="2" height="50">�Ƿ�ɾ���ļ�����Ϊ��̬[�������ݿ�����]����̬[������HTML]�ļ������ѱ�����������¼,һ�㲻����ɾ��������ɾ��ĳ��Ŀ��Ӧ�����´��������Ŀ�����µ�������ȣ���������ǵ���ԭ�򣬶�������ɾ���ļ�����</td>
          </tr>
          <tr> 
            <td width="51%" height="30"> <input type="radio" name="delfile" value="no" checked>
              �� &nbsp;&nbsp; <input type="radio" name="delfile" value="yes">
              ��</td>
            <td width="49%"> <input type="button" name="Submit" value=" ȷ�� " onClick="javascript:document.form1.submit();"> 
              &nbsp; <input type="button" name="Submit2" value=" ���� " onClick="javascript:location.href='list_type.php';"></td>
          </tr>
          <tr> 
            <td height="20" colspan="2">&nbsp;</td>
          </tr>
        </form>
      </table></td>
  </tr>
</table>
</body>

</html>
