<?
require("config.php");
require("inc_makespec.php");
$spectitle = trim($spectitle);
$specartid = ereg_replace("(^,)|(,$)|[^0-9,]","",ereg_replace(",{2,}",",",$specartid));
$speclikeid = ereg_replace("(^,)|(,$)|[^0-9,]","",ereg_replace(",{2,}",",",$speclikeid));
$dtime = strftime("%Y-%m-%d %H:%M:%S",time());
$stime = strftime("%Y-%m-%d",time());
$adminid=$cuserLogin->getUserID();
$inquery="Insert Into dede_spec(typeid,spectitle,specimg,imgtitle,imglink,specmsg,specartid,speclikeid,stime,dtime,userid) Values('$typeid','$spectitle','$specimg','$imgtitle','$imglink','$specmsg','$specartid','$speclikeid','$stime','$dtime',$adminid)";
$conn = connectMySql();
mysql_query($inquery,$conn);
$ID = mysql_insert_id($conn);
if($ID!="")
{
	$mk = new MakeSpec($ID);
	$makeok = $mk->MakeMode();
}
?>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
<title>ר�ⴴ����</title>
<link href='base.css' rel='stylesheet' type='text/css'>
</head>
<body background='img/allbg.gif' leftmargin='8' topmargin='8'>
<table width="96%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#666666">
 <tr>
    <td height="19" background="img/tbg.gif"><strong>&nbsp;ר�ⴴ����&nbsp; </strong></td>
</tr>
<tr>
      <td height="120" align="center" bgcolor="#FFFFFF"><table width="90%" border="0" cellspacing="2" cellpadding="0">
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td height="37">
		  <?
		  if($ID!="")
		  {
		  		echo "�ɹ���ר����Ϣ���浽���ݿ��У�����δ��ר����Ϣ����������HTML����������ѡȡ��һ��������";
		  		echo "<br><br>";
				echo "<a href='add_news_specview.php?ID=$ID' target='_blank'><u>[Ԥ��Ч��]</u></a>&nbsp;&nbsp;<a href='news_spec_edit.php?ID=$ID'><u>[�޸�]</u></a>&nbsp;&nbsp;<a href='list_news_spec.php'><u>[ר�����]</u></a>";
		  }
		  else
		  {
		      echo "��ר����Ϣ���浽���ݿ�ʱʧ�ܣ�����ԭ��<br>";
		      echo mysql_error();		
		  }
		  ?>
		  </td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table></td>
</tr>
</table>
</body>
</html>