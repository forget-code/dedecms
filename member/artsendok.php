<?
require("config.php");
$conn = connectMySql();
//--������յ�����--------------------
$title = trim(cn_substr($title,100));
$source = trim(cn_substr($source,50));
$writer = trim(cn_substr($writer,50));
$msg = cn_substr($msg,500);
$rank = -1;
$dtime = strftime("%Y-%m-%d %H:%M:%S",time());
$stime = strftime("%Y-%m-%d",time());

//����body������//////////
if(ereg("\r",$body)&&ereg("\n",$body))
{
    $body=str_replace("\r","",$body);
    $bodys=split("\n",$body);
}
else if(ereg("\r",$body))
{
     $bodys=split("\r",$body);
} 
else
{
     $bodys=split("\n",$body);
}    
$body="";
foreach($bodys as $line)
{
     $line = ereg_replace("  ","&nbsp;&nbsp;",$line);
     if(!ereg("<",$line)) $body.=$line."<br>\n";
     else $body.=$line."\n";
}
//////////////////////////////////////////////
$conn = connectMySql();
$inQuery = "
INSERT INTO dede_art(typeid,title,source,writer,rank,
stime,isdd,click,msg,redtitle,ismake,body,userid,spec,memberID)
 VALUES ('$typeid','$title','$source','$writer','$rank',
'$stime',0,0,'$msg',0,0,'$body',0,0,".$_COOKIE["cookie_user"].")";
mysql_query($inQuery,$conn);
$artID = mysql_insert_id();
if($artID==0)
{
	echo "<script>\n";
	echo "alert('��������ʧ��,�������Ա��ϵ!');\n";
	echo "history.go(-1);\n";
	echo "</script>\n";
	exit();
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�ɹ���ʾ</title>
<link href="base.css" rel="stylesheet" type="text/css">
<script src="menu.js" language="JavaScript"></script>
<style>
.bt{border-left: 1px solid #FFFFFF; border-right: 1px solid #666666; border-top: 1px solid #FFFFFF; border-bottom: 1px solid #666666; background-color: #C0C0C0}
</style>
<link href="../base.css" rel="stylesheet" type="text/css">
</head>
<body background="img/allbg.gif" leftmargin="0" topmargin="0">
<p>&nbsp;</p>
<table width="300" border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#666666">
  <tr align="center" bgcolor="#CCCCCC">
    <td height="26" colspan="2"><strong>���·����ɹ�!</strong></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="85" colspan="2" align="center"> ����:
        <?=$title?>
        <p> <a href='artsend.php'>[����������]</a>&nbsp;  <a href="artlist.php">[�ҵ�Ͷ��]</a></td>
  </tr>
</table>
</body>

</html>