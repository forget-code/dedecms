<?
require("config.php");
if(empty($job)) $job="";
if($job=="up")
{
	$j=0;
	for($i=1;$i<=50;$i++)
	{
		$img="img".$i;
		$img_name="img".$i."_name";
		if(!empty(${$img}))
		{
			$img=${$img};
			$img_name=${$img_name};
			if(ereg("(.*)\.(.*)",$img_name))
			{
				copy($img,"$base_dir$activepath/$img_name");
				@unlink($img);
				$j++;
			}	
		}
	}
	echo "<script>\r\n";
	echo "alert('�ɹ��ϴ� $j ���ļ���: $activepath');\r\n";
	echo "location.href='file_view.php?activepath=$activepath';\r\n";
	echo "</script>\r\n";
	exit();
}	
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�ļ��ϴ�</title>
<link href="base.css" rel="stylesheet" type="text/css">
<script src="menu.js" language="JavaScript"></script>
</head>
<body background="img/allbg.gif" leftmargin="0" topmargin="0">
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
<tr> 
<td height="425" align="center" valign="top">
<script language="javascript">
        var i=1;
        function make_upload()
        { 
             i++;
             document.all.upfield.innerHTML+="<br>�ļ�"+i+":<input type='file' name='img"+i+"' size='30'>";
        }
		 function reset_upload()
        { 
             document.all.upfield.innerHTML="�ļ�1:<input type='file' name='img1' size='30'>";
        }
</script>
          <form method="POST" enctype="multipart/form-data" action="file_upload.php" name="form1">
            <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="600">
              <tr>
            <td width="100%" height="10" colspan="2" align="center"></td>
              </tr>
              <tr>
                <td width="10%" height="40" valign="top"></td>
                <td width="90%">
                <input type="button" value="�����ϴ���" name="bbb" class="bt1" onClick="make_upload();">
                <input type='hidden' name='activepath' value="<? echo "$activepath"; ?>">
                <input type='hidden' name='job' value="up">
              &nbsp;<a href="file_view.php?activepath=<? echo $activepath;?>">[����Ŀ¼<? echo $activepath ?>]</a> </td>
              </tr>
            <tr>
                <td width="10%">��</td>
                <td width="90%">
                <div id="upfield">
                �ļ�1:<input type='file' name='img1' size='30'>
                </div>
                </td>
              </tr>
          <tr>
            <td width="100%" height="40" colspan="2">
            &nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value=" �ϴ��ļ� " name="B1">
              &nbsp; <input type="button" value=" ����� " name="B12" onClick="reset_upload();"></td>
          </tr>
        </table>
</form>
</td>
</tr>
</table>
</body>

</html>
