<?
require("config.php");
$conn = connectMySql();
if(isset($job)&&isset($ID))
{
	if($job=="del") mysql_query("Delete From dede_weburl where ID=$ID",$conn);
	ShowMsg("�ɹ�ɾ��һ����ַ��","add_news_url.php");
	exit();
}
if(isset($wname)&&isset($url))
{
	if($url!=""&&$wname!="")
	{
		$url = strtolower($url);
		if(!ereg("http",$url)) $url = "http://".$url;
		mysql_query("Insert Into dede_weburl(title,url,msg) values('$wname','$url','$msg')",$conn);
		ShowMsg("�ɹ�����һ����ַ��","add_news_url.php");
	}
	else
	{
		ShowMsg("û��д��վ��ַ�����ƣ�","add_news_url.php");
	}
	exit();
}
?>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
<title>�����ռ�--������ַ</title>
<link href='base.css' rel='stylesheet' type='text/css'>
</head>
<body background='img/allbg.gif' leftmargin='8' topmargin='8'>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#666666">
  <tr>
    <td height="19" background="img/tbg.gif"><a href="add_news_url.php"><u>������Ϣ�ɱ�</u></a> -&gt; ����Դ��ַ</td>
</tr>
<tr>
    <td height="124" align="center" bgcolor="#FFFFFF">
<table width="90%" border="0" cellspacing="1" cellpadding="0">
    <form name="form1">
        <tr> 
          <td width="18%" height="25">��ַ��</td>
          <td width="82%"><input name="url" type="text" id="url" size="30"></td>
        </tr>
        <tr> 
          <td height="22">���ƣ�</td>
          <td><input name="wname" type="text" id="wname" size="20"></td>
        </tr>
        <tr> 
          <td height="22">��飺</td>
          <td>&nbsp;</td>
        </tr>
        <tr align="center"> 
          <td height="42" colspan="2"> <textarea name="msg" cols="50" rows="4" id="msg"></textarea> 
          </td>
        </tr>
        <tr> 
          <td height="35" colspan="2">
<input type="submit" name="Submit" value=" �� �� ">
          </td>
        </tr>
        <tr> 
          <td colspan="2">&nbsp;</td>
        </tr>
		</form>
      </table> </td>
</tr>
</table>
</body>
</html>