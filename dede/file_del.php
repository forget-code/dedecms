<?
require("config.php");
if(empty($job)) $job="";
if(empty($type)) $type="";
function rmdirallfile($indir)
{
   $dh = dir($indir);
   while($file = $dh->read()) {
      if($file == "." || $file == "..") continue;
      else if(is_file("$indir/$file")) unlink("$indir/$file");
      else
      {
         rmdirallfile("$indir/$file");
      }
      if(is_dir("$indir/$file"))
      {
         @rmdir("$indir/$file");
      }
   }
   $dh->close();
   return(1);
}
if($job=="ok")
{
      if($type == "dir"){
          rmdirallfile("$base_dir$activepath/$filename");
          rmdir("$base_dir$activepath/$filename");
          Header("Location:file_view.php?activepath=$activepath");
          exit();
      }
      else
      {
          unlink("$base_dir$activepath/$filename");
          Header("Location:file_view.php?activepath=$activepath");
          exit();
      }
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>ɾ���ļ�</title>
<link href="base.css" rel="stylesheet" type="text/css">
<script src="menu.js" language="JavaScript"></script>
<style>
.bt{border-left: 1px solid #FFFFFF; border-right: 1px solid #666666; border-top: 1px solid #FFFFFF; border-bottom: 1px solid #666666; background-color: #C0C0C0}
</style>
</head>
<body background="img/allbg.gif" leftmargin="0" topmargin="0">
<p>&nbsp;</p>
<table width="400" border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#666666">
  <form name="form1" action="file_del.php" method="post">
    <input type="hidden" name="activepath" value="<? echo $activepath ?>">
    <input type="hidden" name="filename" value="<? echo $filename ?>">
    <input type="hidden" name="type" value="<? echo $type ?>">
    <input type="hidden" name="job" value="ok">
    <tr align="center" bgcolor="#CCCCCC"> 
      <td height="26" colspan="2"><strong>ɾ��ȷ��</strong></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="50" colspan="2" align="center"> 
        <?
			if($type=="dir")
			{
			    //echo "��ȷ��Ҫɾ��Ŀ¼ [$filename] ��<br>������Ŀ¼�����е��ļ����ᱻɾ����";
			    echo "������ϵͳ·�������д���ɾ������Ŀ¼�ᵼ�¼����غ���������ѽ�ֹ����ܣ������ȷ�����ϵͳһ�������������޸ı������77�е�if����Ϊif(true)��";
			}
			else
			{
			   echo "��ȷ��Ҫɾ���ļ� [$filename] ��";
			}
			?>
      </td>
    </tr>
    <tr align="center" bgcolor="#CCCCCC"> 
      <td height="28" colspan="2"> 
      <?if($type!="dir")
			echo "<input type=\"button\" name=\"Submit\" value=\" ȷ �� \" onclick=\"document.form1.submit();\" class=\"bt\">";?>
        &nbsp;&nbsp; <input type="button" name="Submit2" value=" ȡ �� " onclick="location.href='file_view.php?activepath=<? echo $activepath ?>';" class="bt"></td>
    </tr>
  </form>
</table>
</body>

</html>
