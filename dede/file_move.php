<?
require("config.php");
if(empty($newpath)) $newpath="";
if(empty($activepath)) $activepath="";
if(empty($filename)) $filename="";
if($newpath!="")
{
      copy("$base_dir$activepath/$filename","$base_dir$newpath/$filename");
      unlink("$base_dir$activepath/$filename");
      header("Location:file_view.php?activepath=$newpath");
      exit();
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�ƶ��ļ�</title>
<link href="base.css" rel="stylesheet" type="text/css">
<script src="menu.js" language="JavaScript"></script>
<style>
.bt{border-left: 1px solid #FFFFFF; border-right: 1px solid #666666; border-top: 1px solid #FFFFFF; border-bottom: 1px solid #666666; background-color: #C0C0C0}
</style>
</head>
<body background="img/allbg.gif" leftmargin="0" topmargin="0">
<p>&nbsp;</p><table width="400" border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#666666">
  <form name="form1" action="file_move.php" method="post">
    <input type="hidden" name="activepath" value="<? echo $activepath ?>">
    <input type="hidden" name="filename" value="<? echo $filename ?>">
    <tr align="center" bgcolor="#CCCCCC"> 
      <td height="26" colspan="2">
      <strong>�ƶ��ļ�[<? echo $filename ?>]</strong>
      <br>
      ����·���У����� / ��ʾ��Ŀ¼ 
      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="24">&nbsp;��·����</td>
      <td height="24">&nbsp;&nbsp;[<a href='file_view.php?activepath=<? echo $activepath ?>'> 
        <? if($activepath=="") echo "��Ŀ¼";else echo $activepath?>
        </a>]</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="97" height="24"> &nbsp;��·����</td>
      <td width="196" height="24"> &nbsp; <input name="newpath" type="input" id="newpath"></td>
    </tr>
    <tr align="center" bgcolor="#CCCCCC"> 
      <td height="28" colspan="2"> <input type="button" name="Submit" value=" ȷ �� " onclick="document.form1.submit();" class="bt"> 
        &nbsp;&nbsp; <input type="button" name="Submit2" value=" ȡ �� " class="bt" onclick="location.href='file_view.php?activepath=<? echo $activepath ?>';"> 
      </td>
    </tr>
  </form>
</table>
</body>

</html>
