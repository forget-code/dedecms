<?
require("config.php");
$conn = connectMySql();
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>��Ա��ҳ</title>
<link href="../base.css" rel="stylesheet" type="text/css">	
</head>
<body leftmargin="0" topmargin="0">
<table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr bgcolor="#FFFFFF"> 
    <td height="50" colspan="4"><img src="img/member.gif" width="320" height="46"></td>
  </tr>
  <tr> 
    <td bordercolor="#FFFFFF" bgcolor="#808DB5" width="30">&nbsp;</td>
    <td bordercolor="#FFFFFF" bgcolor="#808DB5" width="220">&nbsp;</td>
    <td bordercolor="#FFFFFF" bgcolor="#808DB5" width="250">&nbsp;</td>
    <td width="200" align="right"><a href="/"><u>��վ��ҳ</u></a>&nbsp; <a href="exit.php?job=all"><u>�˳���¼</u></a></td>
  </tr>
  <tr> 
    <td width="30" bgcolor="#808DB5">&nbsp;</td>
    <td colspan="3" rowspan="2" valign="top">
	<table width="100%" height="200" border="0" cellpadding="1" cellspacing="1" bgcolor="#000000">
        <tr> 
          <td height="100" align="center" valign="top" bgcolor="#FFFFFF">
		  <table width="98%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td height="6" colspan="2"></td>
              </tr>
              <tr> 
                <td height="40" colspan="2"><font color="red"> 
                  <?=$_COOKIE["cookie_username"]?>
                  </font> ��ã���ӭ��¼����Ա��������</td>
              </tr>
              <tr> 
                <td height="18" colspan="2"> 
                  <?getRank($conn,$_COOKIE["cookie_rank"])?>
                </td>
              </tr>
              <tr> 
                <td colspan="2" align="center"><hr size="1"></td>
              </tr>
              <tr> 
                <td width="15%" height="40" align="center">������</td>
                <td width="85%">
				<a href="/"><u>�������</u></a>&nbsp; 
				<?
				if($userSendArt==-1||$_COOKIE["cookie_rank"]>=$userSendArt)
				{
				?>
				<a href="artsend.php"><u>Ͷ��</u></a>&nbsp; 
				<a href="artlist.php"><u>������</u></a>&nbsp; 
				<?}?>
				<a href="modinfo.php"><u>���ĸ�������</u></a>&nbsp; 
				<a href="/rap"><u></u></a><a href="exit.php?job=all"><u>�˳���¼</u></a>
				</td>
              </tr>
              <tr bgcolor="#F8F8F5"> 
                <td height="22" colspan="2" align="center">&nbsp;</td>
              </tr>
              <tr> 
                <td height="40" colspan="2" align="center">&nbsp;</td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td bgcolor="#808DB5">&nbsp;</td>
  </tr>
</table>
<p align='center'><a href='http://www.dedecms.com'target='_blank'>Power by DedeCms ֯�����ݹ���ϵͳ</a></p>
</body></html>
