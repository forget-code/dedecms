<?
require("config.php");
$datafile = $base_dir.$art_php_dir."/webnews/news.xml";
if(!empty($mynews))
{
	$mynews=stripslashes($mynews);
	$fp = fopen($datafile,"w");
	fwrite($fp,$mynews);
	fclose($fp);
	ShowMsg("�ɹ����������ļ���","list_mynews.php");
	exit();
}
if(file_exists($datafile))
{
	$fp = fopen($datafile,"r");
	$mynews = fread($fp,5000*20);
	fclose($fp);
}
?>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
<title>վ�����ű༭</title>
<link href='base.css' rel='stylesheet' type='text/css'>
</head>
<body background='img/allbg.gif' leftmargin='8' topmargin='8'>
<table width="96%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#666666">
  <tr>
    <td height="19" background="img/tbg.gif"><strong>&nbsp;�༭վ������&nbsp;</strong>[<a href="add_my_news.php"><u>����վ������</u>]</a> [<a href="list_mynews.php"><u>�鿴վ������</u>]</a></td>
</tr>
<tr>
    <td height="127" align="center" bgcolor="#FFFFFF"><table width="98%"  border="0" cellspacing="4" cellpadding="2">
      <tr>
	  <form action="edit_mynews.php" method="post">
        <td height="163" valign="top">
		<p>
            <textarea name="mynews" cols="80" rows="20" id="mynews"><?=$mynews?></textarea>
        </p>
          <p>              <input type="submit" name="Submit" value="�������">
&nbsp;&nbsp;           
<input type="reset" name="Submit" value="�ָ�ԭ������">
</p>
          </td>
		  </form>
      </tr>
    </table></td>
</tr>
</table>
</body>
</html>