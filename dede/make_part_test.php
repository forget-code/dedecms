<?
require("config.php");
require("inc_makepartcode.php");
?>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
<title>�������</title>
<link href='base.css' rel='stylesheet' type='text/css'>
</head>
<body background='img/allbg.gif' leftmargin='8' topmargin='8'>
<table width="98%" border="0" cellpadding="3" cellspacing="1" bgcolor="#666666" align="center">
  <tr>
    <td height="19" background='img/tbg.gif'> &nbsp;�������</td>
</tr>
<tr>
    <td height="242" bgcolor="#FFFFFF" valign="top">
<?
$testcode = stripslashes($testcode);
$maprt= new MakePartCode();
echo $maprt->ParTempTest($testcode);
?>
    </td>
</tr>
</table>
</body>
</html>