<?
require("config.php");
$conn = connectMySql();
?>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
<title>֯�����ݹ���ϵͳ(DedeCms)V2.1������</title>
<link href='base.css' rel='stylesheet' type='text/css'>
</head>
<body background='img/allbg.gif' leftmargin='8' topmargin='8'>
<table width="90%" border="0" cellpadding="2" cellspacing="1" bgcolor="#666666" align="center">
  <tr>
    <td height="23" background="img/tbg.gif"> &nbsp;��ӭʹ��֯�����ݹ���ϵͳ(DedeCms)V2.1������</td>
</tr>
<tr>
    <td height="250" align="center" valign="middle" bgcolor="#FFFFFF">
	<br>
      <table width="96%" border="0" cellpadding="1" cellspacing="1" bgcolor="#666666">
        <tr bgcolor="#FFFFFF"> 
          <td width="40%" align="center">��ǰ�û����</td>
          <td width="60%">&nbsp; 
            <?
      if($cuserLogin->getUserType()==10) echo "��������Ա";
      else if($cuserLogin->getUserType()==5) echo "Ƶ���ܱ༭";
      else echo "��Ϣ�ɱ�Ա";
      ?>
          </td>
      </tr>
        <tr bgcolor="#FFFFFF"> 
          <td align="center">��ǰ��¼�û�IP</td>
          <td> &nbsp; 
            <?
	  if(!empty($_SERVER["REMOTE_ADDR"])) echo $_SERVER["REMOTE_ADDR"];
	  ?>
          </td>
      </tr>
        <tr bgcolor="#FFFFFF"> 
          <td width="40%" align="center">PHP�汾</td>
          <td width="60%">&nbsp; 
            <?=@phpversion();?>
          </td>
      </tr>
        <tr bgcolor="#FFFFFF"> 
          <td align="center">�Ƿ�֧��register_globals</td>
          <td>&nbsp; 
            <?=ini_get("register_globals") ? '֧��' : '��֧��'?>
          </td>
      </tr>
        <tr bgcolor="#FFFFFF"> 
          <td align="center">�Ƿ�֧��getenv()</td>
          <td> &nbsp; 
            <?=ereg("getenv",ini_get("disable_functions")) ? '��֧��' : '֧��'?>
          </td>
      </tr>
        <tr bgcolor="#FFFFFF"> 
          <td align="center">�Ƿ�֧��$_SERVER</td>
          <td>&nbsp; 
            <?
      if(isset($_SERVER)) echo "֧��";
      else echo "��֧�֣�ʹ�ñ�ϵͳ���ܻ�������";
      ?>
          </td>
      </tr>
        <tr bgcolor="#FFFFFF"> 
          <td align="center">�Ƿ�֧��magic_quotes_gpc</td>
          <td>&nbsp; 
            <?=ini_get("magic_quotes_gpc") ? '֧��' : '��֧�֣�ʹ�ñ�ϵͳ���ܻ�������'?>
          </td>
      </tr>
        <tr bgcolor="#FFFFFF"> 
          <td align="center">�Ƿ�֧���ϴ�������ļ�</td>
          <td>&nbsp; 
            <?=ini_get("post_max_size")?>
          </td>
      </tr>
        <tr bgcolor="#FFFFFF"> 
          <td align="center">�Ƿ������Զ������</td>
          <td>&nbsp; 
            <?=ini_get("allow_url_fopen") ? '֧��' : '��֧��'?>
          </td>
      </tr>
    </table>
      <br>
    </td>
</tr>
</table>
<center>
<a href="http://www.dedecms.com" target="_blank">Power by PHP+MySQL ֯��֮�� 2004-2006 �ٷ���վ��www.DedeCMS.com</a>
</center>
</body>
</html>