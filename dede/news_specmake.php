<?
require_once("config.php");
require_once("inc_makespec.php");
if(!isset($ID))
{
	ShowMsg("��ûѡ���κ�ѡ�","-1");
	exit;
}
$IDS = split("`",$ID);
$conn = connectMySql();
foreach($IDS as $ID)
{
	if($ID!="")
	{
		$mk = new MakeSpec($ID);
		$makeok = $mk->makeMode();
	}
}
?>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
<title>����ר��</title>
<link href='base.css' rel='stylesheet' type='text/css'>
<script src='menu.js' language='JavaScript'></script>
</head>
<body background='img/allbg.gif' leftmargin='6' topmargin='16'>
<table width="80%" border="0" cellpadding="3" cellspacing="1" bgcolor="#666666" align="center">
  <tr> 
    <td height="19" background='img/tbg.gif'>�ɹ�����ָ��ר��&nbsp;&nbsp;</td>
  </tr>
  <tr> 
    <td height="95" align="center" bgcolor="#FFFFFF"> <table width="80%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr> 
            <td colspan="2" height="50">
            ����ҳ�棺[<a href="list_news_spec.php">ר�����</a>] [<a href="add_news_spec.php">ר�ⷢ����</a>]
            </td>
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