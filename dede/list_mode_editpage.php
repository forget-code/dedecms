<?
require("config.php");
if(!eregi("^$mod_dir",$fname)||!eregi("htm$",$fname))
{
	ShowMsg("�Բ����ļ������Ϸ����޷����к��������","back");
	exit();
}
else
{
	$ftruename = $base_dir.$fname;
}
if($job == "save"){
    $str = stripslashes($body);
    $file = $base_dir.$fname;
    $str = str_replace("< textarea","<textarea",$str);
    $str = str_replace("< /textarea","</textarea",$str);
    $str = str_replace("< form","<form",$str);
    $str = str_replace("< /form","</form",$str);
    $fp = fopen($file,"w");
    fputs($fp,$str);
    fclose($fp);
    Header("Location:list_mode_edit.php?ID=$ID");
    exit();
}
if($job == "edit"||$job == "make"){
   $openname = $ftruename;
   if($job=="make")
   {
   	  if(eregi("htm$",$fname))
   	  {
   	  	 $openname = $base_dir.$df;
   	  	 $domsg = "������ģ��(����������ΪĬ��ģ�壬�밴��Ҫ�޸ģ�)";
   	  }
   }
   else
   {
   	   $domsg = "�༭ģ��";
   }
   if(file_exists($openname))
   {
   		$fp = fopen($openname,"r");
   		$str = fread($fp,filesize($openname));
   		fclose($fp);
   		$str = eregi_replace("<textarea","< textarea",$str);
   		$str = eregi_replace("</textarea","< /textarea",$str);
   		$str = eregi_replace("<form","< form",$str);
   		$str = eregi_replace("</form","< /form",$str);
   }
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�ļ��༭</title>
<style>
<!--
#fps0    {width:60}
#fps1    {color: #800000; background-color: #ffffcc}
td{ line-height: 18px; font-size: 10pt ;}
a:visited{ color: #000000; text-decoration: none }
a:link{ color: #000000; text-decoration: none; font-family: ���� }
a:hover{ color:red;background-color:yellow;}
-->
</style>
<script language="javascript">
function insertTag(str)
{
	document.form1.body.value=document.form1.body.value+str+"\n";
}
function view(){
	var htmlWnd=window.open("","html","width=700,height=400,top=20,left=100,scrollbars=yes,resizable=yes,status=1,");
	htmlWnd.document.open();
	htmlWnd.document.writeln(this.document.form1.body.value.replace(".js",""));
	htmlWnd.document.close();
}
</script>
</head>
<body background="img/allbg.gif" leftmargin="0" topmargin="4">
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td align="center"> 
      <table border=0 cellpadding=0 cellspacing=0 style="border-collapse: collapse" bordercolor=#111111 width=100%>
        <form method="POST" action="list_mode_editpage.php" name=form1 onSubmit="return Post()">
          <input type="hidden" name="job" value="save">
          <input type="hidden" name="fname" value="<?=$fname?>">
          <input type="hidden" name="ID" value="<?=$ID?>">
          <tr> 
            <td width=78% style="border-top-style: none; border-top-width: medium">
            <table border=0 cellpadding=0 cellspacing=0 style="border-collapse: collapse" width=100%>    <tr> 
                  <td height="75"> 
                    <table width=96% border=0 cellpadding=0 cellspacing=1 bgcolor="#FFFFFF" style="border-collapse: collapse">
                      <tr> 
                        <td height="20" bgcolor="#999999"><strong>&nbsp;��ǰ������</strong><?=$domsg?></td>
                      </tr>
                      <tr> 
                        <td height="20" bgcolor="#CCCCCC"> &nbsp;��ǰ���༭��ģ�壺 
                          <?=$fname?>
                        </td>
                      </tr>
                      <tr> 
                        <td height="20" bgcolor="#999999"><strong>&nbsp;���ô��룺</strong>[XML���ֿռ��﷨��������Ƕ��]</td>
                      </tr>
                      <tr> 
                        <td> 
                          <?
                        if(file_exists("taglib/$mtype.txt"))
                        {
                        	$ds = @file("taglib/$mtype.txt");
                        	foreach($ds as $d)
                        	{
                        		$d = trim($d);
                        		if($d!="")
                        		{
                        			list($insertto,$msg)=split("\|",$d);
                        			echo "<li>$msg</li>\n";
                        		}
                        	}
                        }
                        ?>
                        </td>
                      </tr>
                    </table>
 <table width="80%" border="0" cellspacing="0" cellpadding="0" height="4"><tr><td></td></tr></table></td>
                </tr>
              </table></td>
          </tr>
          <tr> 
            <td width=78%> <textarea rows=18 name="body" cols=86 wrap="off"><? echo "$str"; ?></textarea> 
            </td>
          </tr>
          <tr> 
            <td width=78%> <p align=center><br>
                <input type=submit value="  �� ��  " name=B1>
                &nbsp; 
                <input type=reset value="����" name=B2>
                &nbsp; 
                <input type=button value=HTMLԤ�� name=B3 onclick="view()">
                &nbsp; 
                <input type=button value="������" name=B4 onclick="javascript:history.go(-1);">
                <br>
                ��</td>
          </tr>
        </form>
      </table></td>
  </tr>
</table>
</body>

</html>
