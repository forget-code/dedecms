<?php 
require(dirname(__FILE__)."/config.php");
CheckPurview('plus_�ļ�������');

if(!isset($activepath)) $activepath=$cfg_cmspath;
$inpath = "";

$activepath = str_replace("..","",$activepath);
$activepath = ereg_replace("^/{1,}","/",$activepath);
if($activepath == "/") $activepath = "";

if($activepath == "") $inpath = $cfg_basedir;
else $inpath = $cfg_basedir.$activepath;

$activeurl = $activepath;

if(eregi($cfg_templets_dir,$activepath)) $istemplets = true;
else $istemplets = false;

?>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
<title>�ļ�������</title>
<link href='base.css' rel='stylesheet' type='text/css'>
<style>
.linerow{border-bottom: 1px solid #A5D0F1;}
</style>
</head>
<body background='img/allbg.gif' leftmargin='0' topmargin='0'>
<table width="98%" border="0" align="center">
  <tr>
    <td>
    <table width='100%' border='0' cellspacing='0' cellpadding='0'>
        <tr> 
          <td height='4' colspan='4'></td>
        </tr>
        <tr> 
          <td colspan='4' align='right'>
          <table width='100%' border='0' cellpadding='0' cellspacing='1' bgcolor='#A5D0F1'>
              <tr bgcolor='#FFFFFF'> 
                <td colspan='4'>
                <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                    <tr height='24'> 
                      <td width="28%" align="center" background="img/tbg.gif" class='linerow'><strong>�ļ���</strong></td>
                      <td width="16%" align="center" bgcolor='#E5F9FF' class='linerow'><strong>�ļ���С</strong></td>
                      <td width="22%" align="center" background="img/tbg.gif" class='linerow'><strong>����޸�ʱ��</strong></td>
                      <td width="34%" align="center" bgcolor='#E5F9FF' class='linerow'><strong>����</strong></td>
                    </tr>
                    <?php 
$dh = dir($inpath);
$ty1="";
$ty2="";
while($file = $dh->read()) {
     if($file!="." && $file!=".." && !is_dir("$inpath/$file"))
     {
       @$filesize = filesize("$inpath/$file");
       @$filesize=$filesize/1024;
       @$filetime = filemtime("$inpath/$file");
       @$filetime = strftime("%y-%m-%d %H:%M:%S",$filetime);
       if($filesize!="")
       if($filesize<0.1)
       {
         @list($ty1,$ty2)=explode(".",$filesize);
         $filesize=$ty1.".".substr($ty2,0,2);
       }
       else
       {
          @list($ty1,$ty2)=explode(".",$filesize);
          $filesize=$ty1.".".substr($ty2,0,1);
       }
     }
     if($file == ".") continue;
     else if($file == ".."){
            if($activepath == "") continue;
            $tmp = eregi_replace("[/][^/]*$","",$activepath);
            $line = "\n<tr height='22'>
            <td class='linerow'>
            <a href=file_manage_main.php?activepath=".urlencode($tmp)."><img src=img/dir2.gif border=0 width=16 height=16 align=absmiddle>�ϼ�Ŀ¼</a>
            </td>
            <td colspan='3' class='linerow'>
             ��ǰĿ¼:$activepath &nbsp;
             <a href='file_pic_view.php?activepath=".urlencode($activepath)."' style='color:red'>[ͼƬ�����]</a>
             </td>
            </tr>";
            echo $line;
      }
      else if(is_dir("$inpath/$file")){
             if(eregi("^_(.*)$",$file)) continue; #����FrontPage��չĿ¼��linux����Ŀ¼
             if(eregi("^\.(.*)$",$file)) continue;
             $line = "\n<tr height='22' onMouseMove=\"javascript:this.bgColor='#F9FBF0';\" onMouseOut=\"javascript:this.bgColor='#FFFFFF';\">
             <td class='linerow'>
              <a href=file_manage_main.php?activepath=".urlencode("$activepath/$file")."><img src=img/dir.gif border=0 width=16 height=16 align=absmiddle>$file</a></td>
             <td class='linerow'>��</td>
             <td class='linerow'>��</td>
             <td class='linerow'>
             <a href=file_manage_view.php?filename=".urlencode($file)."&activepath=".urlencode($activepath)."&fmdo=rename>[����]</a>
             &nbsp;
             <a href=file_manage_view.php?filename=".urlencode($file)."&activepath=".urlencode($activepath)."&type=dir&fmdo=del>[ɾ��]</a>
             </td>
             </td>
             </tr>";
             echo "$line";
      }
      else if(eregi("\.(gif|png)",$file)){
             $line = "\n<tr height='22' onMouseMove=\"javascript:this.bgColor='#F9FBF0';\" onMouseOut=\"javascript:this.bgColor='#FFFFFF';\">
             <td class='linerow'>
             <a href=$activeurl/$file target=_blank><img src=img/gif.gif border=0 width=16 height=16 align=absmiddle>$file</a></td>
             <td class='linerow'>$filesize KB</td>
             <td align='center' class='linerow'>$filetime</td>
             <td class='linerow'>
             <a href='file_manage_view.php?fmdo=rename&filename=".urlencode($file)."&activepath=".urlencode($activepath)."'>[����]</a>
             &nbsp;
             <a href='file_manage_view.php?fmdo=del&filename=".urlencode($file)."&activepath=".urlencode($activepath)."'>[ɾ��]</a>
             &nbsp;
             <a href='file_manage_view.php?fmdo=move&filename=".urlencode($file)."&activepath=".urlencode($activepath)."'>[�ƶ�]</a>
             </td>
             </tr>";
             echo "$line";
     }
     else if(eregi("\.(jpg)",$file)){
             $line = "\n<tr height='22' onMouseMove=\"javascript:this.bgColor='#F9FBF0';\" onMouseOut=\"javascript:this.bgColor='#FFFFFF';\">
             <td class='linerow'>
             <a href=$activeurl/$file target=_blank><img src=img/jpg.gif border=0 width=16 height=16 align=absmiddle>$file</a></td>
             <td class='linerow'>$filesize KB</td>
             <td align='center' class='linerow'>$filetime</td>
             <td class='linerow'>
             <a href='file_manage_view.php?fmdo=rename&filename=".urlencode($file)."&activepath=".urlencode($activepath)."'>[����]</a>
             &nbsp;
             <a href='file_manage_view.php?fmdo=del&filename=".urlencode($file)."&activepath=".urlencode($activepath)."'>[ɾ��]</a>
             &nbsp;
             <a href='file_manage_view.php?fmdo=move&filename=".urlencode($file)."&activepath=".urlencode($activepath)."'>[�ƶ�]</a>
             </td>
             </tr>";
             echo "$line";
     }
	 else if(eregi("\.(swf|fla|fly)",$file)){
             $line = "\n<tr height='22' onMouseMove=\"javascript:this.bgColor='#F9FBF0';\" onMouseOut=\"javascript:this.bgColor='#FFFFFF';\">
             <td class='linerow'>
             <a href=$activeurl/$file target=_blank><img src=img/flash.gif border=0 width=16 height=16 align=absmiddle>$file</a></td>
             <td class='linerow'>$filesize KB</td>
             <td align='center' class='linerow'>$filetime</td>
             <td class='linerow'>
             <a href='file_manage_view.php?fmdo=rename&filename=".urlencode($file)."&activepath=".urlencode($activepath)."'>[����]</a>
             &nbsp;
             <a href='file_manage_view.php?fmdo=del&filename=".urlencode($file)."&activepath=".urlencode($activepath)."'>[ɾ��]</a>
             &nbsp;
             <a href='file_manage_view.php?fmdo=move&filename=".urlencode($file)."&activepath=".urlencode($activepath)."'>[�ƶ�]</a>
             </td>
             </tr>";
             echo "$line";
     }
	 else if(eregi("\.(zip|rar|tar.gz)",$file)){
             $line = "\n<tr height='22' onMouseMove=\"javascript:this.bgColor='#F9FBF0';\" onMouseOut=\"javascript:this.bgColor='#FFFFFF';\">
             <td class='linerow'>
             <a href=$activeurl/$file target=_blank><img src=img/zip.gif border=0 width=16 height=16 align=absmiddle>$file</a></td>
             <td class='linerow'>$filesize KB</td>
             <td align='center' class='linerow'>$filetime</td>
             <td class='linerow'>
             <a href='file_manage_view.php?fmdo=rename&filename=".urlencode($file)."&activepath=".urlencode($activepath)."'>[����]</a>
             &nbsp;
             <a href='file_manage_view.php?fmdo=del&filename=".urlencode($file)."&activepath=".urlencode($activepath)."'>[ɾ��]</a>
             &nbsp;
             <a href='file_manage_view.php?fmdo=move&filename=".urlencode($file)."&activepath=".urlencode($activepath)."'>[�ƶ�]</a>
             </td>
             </tr>";
             echo "$line";
     }
	 else if(eregi("\.(exe)",$file)){
             $line = "\n<tr height='22' onMouseMove=\"javascript:this.bgColor='#F9FBF0';\" onMouseOut=\"javascript:this.bgColor='#FFFFFF';\">
             <td class='linerow'>
             <a href=$activeurl/$file target=_blank><img src=img/exe.gif border=0 width=16 height=16 align=absmiddle>$file</a></td>
             <td class='linerow'>$filesize KB</td>
             <td align='center' class='linerow'>$filetime</td>
             <td class='linerow'>
             <a href='file_manage_view.php?fmdo=rename&filename=".urlencode($file)."&activepath=".urlencode($activepath)."'>[����]</a>
             &nbsp;
             <a href='file_manage_view.php?fmdo=del&filename=".urlencode($file)."&activepath=".urlencode($activepath)."'>[ɾ��]</a>
             &nbsp;
             <a href='file_manage_view.php?fmdo=move&filename=".urlencode($file)."&activepath=".urlencode($activepath)."'>[�ƶ�]</a>
             </td>
             </tr>";
             echo "$line";
     }
	 else if(eregi("\.(mp3|wma)",$file)){
             $line = "\n<tr height='22' onMouseMove=\"javascript:this.bgColor='#F9FBF0';\" onMouseOut=\"javascript:this.bgColor='#FFFFFF';\">
             <td class='linerow'>
             <a href=$activeurl/$file target=_blank><img src=img/mp3.gif border=0 width=16 height=16 align=absmiddle>$file</a></td>
             <td class='linerow'>$filesize KB</td>
             <td align='center' class='linerow'>$filetime</td>
             <td class='linerow'>
             <a href='file_manage_view.php?fmdo=rename&filename=".urlencode($file)."&activepath=".urlencode($activepath)."'>[����]</a>
             &nbsp;
             <a href='file_manage_view.php?fmdo=del&filename=".urlencode($file)."&activepath=".urlencode($activepath)."'>[ɾ��]</a>
             &nbsp;
             <a href='file_manage_view.php?fmdo=move&filename=".urlencode($file)."&activepath=".urlencode($activepath)."'>[�ƶ�]</a>
             </td>
             </tr>";
             echo "$line";
     }
	 else if(eregi("\.(wmv|api)",$file)){
             $line = "\n<tr height='22' onMouseMove=\"javascript:this.bgColor='#F9FBF0';\" onMouseOut=\"javascript:this.bgColor='#FFFFFF';\">
             <td class='linerow'>
             <a href=$activeurl/$file target=_blank><img src=img/wmv.gif border=0 width=16 height=16 align=absmiddle>$file</a></td>
             <td class='linerow'>$filesize KB</td>
             <td align='center' class='linerow'>$filetime</td>
             <td class='linerow'>
             <a href='file_manage_view.php?fmdo=rename&filename=".urlencode($file)."&activepath=".urlencode($activepath)."'>[����]</a>
             &nbsp;
             <a href='file_manage_view.php?fmdo=del&filename=".urlencode($file)."&activepath=".urlencode($activepath)."'>[ɾ��]</a>
             &nbsp;
             <a href='file_manage_view.php?fmdo=move&filename=".urlencode($file)."&activepath=".urlencode($activepath)."'>[�ƶ�]</a>
             </td>
             </tr>";
             echo "$line";
     }
	 else if(eregi("\.(rm|rmvb)",$file)){
             $line = "\n<tr height='22' onMouseMove=\"javascript:this.bgColor='#F9FBF0';\" onMouseOut=\"javascript:this.bgColor='#FFFFFF';\">
             <td class='linerow'>
             <a href=$activeurl/$file target=_blank><img src=img/rm.gif border=0 width=16 height=16 align=absmiddle>$file</a></td>
             <td class='linerow'>$filesize KB</td>
             <td align='center' class='linerow'>$filetime</td>
             <td class='linerow'>
             <a href='file_manage_view.php?fmdo=rename&filename=".urlencode($file)."&activepath=".urlencode($activepath)."'>[����]</a>
             &nbsp;
             <a href='file_manage_view.php?fmdo=del&filename=".urlencode($file)."&activepath=".urlencode($activepath)."'>[ɾ��]</a>
             &nbsp;
             <a href='file_manage_view.php?fmdo=move&filename=".urlencode($file)."&activepath=".urlencode($activepath)."'>[�ƶ�]</a>
             </td>
             </tr>";
             echo "$line";
     }
     else if(eregi("\.(txt|inc|pl|cgi|asp|xml|xsl|aspx|cfm)",$file))
     {
             /*if($istemplets) $edurl = "file_manage_view.php?fmdo=editview&filename=".urlencode($file)."&activepath=".urlencode($activepath);
             else */
             $edurl = "file_manage_view.php?fmdo=edit&filename=".urlencode($file)."&activepath=".urlencode($activepath);
             $line = "\n<tr height='22' onMouseMove=\"javascript:this.bgColor='#F9FBF0';\" onMouseOut=\"javascript:this.bgColor='#FFFFFF';\">
             <td class='linerow'>
             <a href=$activeurl/$file target=_blank><img src=img/txt.gif border=0 width=16 height=16 align=absmiddle>$file</a></td>
             <td class='linerow'>$filesize KB</td>
             <td align='center' class='linerow'>$filetime</td>
             <td class='linerow'>
             <a href='$edurl'>[�༭]</a>
             &nbsp;
             <a href='file_manage_view.php?fmdo=rename&filename=".urlencode($file)."&activepath=".urlencode($activepath)."'>[����]</a>
             &nbsp;
             <a href='file_manage_view.php?fmdo=del&filename=".urlencode($file)."&activepath=".urlencode($activepath)."'>[ɾ��]</a>
             &nbsp;
             <a href='file_manage_view.php?fmdo=move&filename=".urlencode($file)."&activepath=".urlencode($activepath)."'>[�ƶ�]</a>
             </td>
             </tr>";
             echo "$line";
     }
     else if(eregi("\.(htm|html)",$file))
     {
             /*if($istemplets) $edurl = "file_manage_view.php?fmdo=editview&filename=".urlencode($file)."&activepath=".urlencode($activepath);
             else */
             $edurl = "file_manage_view.php?fmdo=edit&filename=".urlencode($file)."&activepath=".urlencode($activepath);
             $line = "\n<tr height='22' onMouseMove=\"javascript:this.bgColor='#F9FBF0';\" onMouseOut=\"javascript:this.bgColor='#FFFFFF';\">
             <td class='linerow'>
             <a href=$activeurl/$file target=_blank><img src=img/htm.gif border=0 width=16 height=16 align=absmiddle>$file</a></td>
             <td class='linerow'>$filesize KB</td>
             <td align='center' class='linerow'>$filetime</td>
             <td class='linerow'>
             <a href='$edurl'>[�༭]</a>
             &nbsp;
             <a href='file_manage_view.php?fmdo=rename&filename=".urlencode($file)."&activepath=".urlencode($activepath)."'>[����]</a>
             &nbsp;
             <a href='file_manage_view.php?fmdo=del&filename=".urlencode($file)."&activepath=".urlencode($activepath)."'>[ɾ��]</a>
             &nbsp;
             <a href='file_manage_view.php?fmdo=move&filename=".urlencode($file)."&activepath=".urlencode($activepath)."'>[�ƶ�]</a>
             </td>
             </tr>";
             echo "$line";
     }
	 else if(eregi("\.(php)",$file))
     {
             $edurl = "file_manage_view.php?fmdo=edit&filename=".urlencode($file)."&activepath=".urlencode($activepath);
             $line = "\n<tr height='22' onMouseMove=\"javascript:this.bgColor='#F9FBF0';\" onMouseOut=\"javascript:this.bgColor='#FFFFFF';\">
             <td class='linerow'>
             <a href=$activeurl/$file target=_blank><img src=img/php.gif border=0 width=16 height=16 align=absmiddle>$file</a></td>
             <td class='linerow'>$filesize KB</td>
             <td align='center' class='linerow'>$filetime</td>
             <td class='linerow'>
             <a href='$edurl'>[�༭]</a>
             &nbsp;
             <a href='file_manage_view.php?fmdo=rename&filename=".urlencode($file)."&activepath=".urlencode($activepath)."'>[����]</a>
             &nbsp;
             <a href='file_manage_view.php?fmdo=del&filename=".urlencode($file)."&activepath=".urlencode($activepath)."'>[ɾ��]</a>
             &nbsp;
             <a href='file_manage_view.php?fmdo=move&filename=".urlencode($file)."&activepath=".urlencode($activepath)."'>[�ƶ�]</a>
             </td>
             </tr>";
             echo "$line";
     }
	 else if(eregi("\.(js)",$file))
     {
             $edurl = "file_manage_view.php?fmdo=edit&filename=".urlencode($file)."&activepath=".urlencode($activepath);
             $line = "\n<tr onMouseMove=\"javascript:this.bgColor='#F9FBF0';\" onMouseOut=\"javascript:this.bgColor='#FFFFFF';\">
             <td class='linerow'>
             <a href=$activeurl/$file target=_blank><img src=img/js.gif border=0 width=16 height=16 align=absmiddle>$file</a></td>
             <td class='linerow'>$filesize KB</td>
             <td align='center' class='linerow'>$filetime</td>
             <td class='linerow'>
             <a href='$edurl'>[�༭]</a>
             &nbsp;
             <a href='file_manage_view.php?fmdo=rename&filename=".urlencode($file)."&activepath=".urlencode($activepath)."'>[����]</a>
             &nbsp;
             <a href='file_manage_view.php?fmdo=del&filename=".urlencode($file)."&activepath=".urlencode($activepath)."'>[ɾ��]</a>
             &nbsp;
             <a href='file_manage_view.php?fmdo=move&filename=".urlencode($file)."&activepath=".urlencode($activepath)."'>[�ƶ�]</a>
             </td>
             </tr>";
             echo "$line";
     }
	 else if(eregi("\.(css)",$file))
     {
             $edurl = "file_manage_view.php?fmdo=edit&filename=".urlencode($file)."&activepath=".urlencode($activepath);
             $line = "\n<tr height='22' onMouseMove=\"javascript:this.bgColor='#F9FBF0';\" onMouseOut=\"javascript:this.bgColor='#FFFFFF';\">
             <td class='linerow'>
             <a href=$activeurl/$file target=_blank><img src=img/css.gif border=0 width=16 height=16 align=absmiddle>$file</a></td>
             <td class='linerow'>$filesize KB</td>
             <td align='center' class='linerow'>$filetime</td>
             <td class='linerow'>
             <a href='$edurl'>[�༭]</a>
             &nbsp;
             <a href='file_manage_view.php?fmdo=rename&filename=".urlencode($file)."&activepath=".urlencode($activepath)."'>[����]</a>
             &nbsp;
             <a href='file_manage_view.php?fmdo=del&filename=".urlencode($file)."&activepath=".urlencode($activepath)."'>[ɾ��]</a>
             &nbsp;
             <a href='file_manage_view.php?fmdo=move&filename=".urlencode($file)."&activepath=".urlencode($activepath)."'>[�ƶ�]</a>
             </td>
             </tr>";
             echo "$line";
     }
     else
     {
             $line = "\n<tr height='22' onMouseMove=\"javascript:this.bgColor='#F9FBF0';\" onMouseOut=\"javascript:this.bgColor='#FFFFFF';\">
              <td class='linerow'><a href=$activeurl/$file target=_blank>$file</td>
              <td class='linerow'>$filesize KB</td>
              <td align='center' class='linerow'>$filetime</td>
              <td class='linerow'>
              <a href='file_manage_view.php?fmdo=rename&filename=".urlencode($file)."&activepath=".urlencode($activepath)."'>[����]</a>
              &nbsp;
              <a href='file_manage_view.php?fmdo=del&filename=".urlencode($file)."&activepath=".urlencode($activepath)."'>[ɾ��]</a>
              &nbsp;
              <a href='file_manage_view.php?fmdo=move&filename=".urlencode($file)."&activepath=".urlencode($activepath)."'>[�ƶ�]</a>
              </td>
              </tr>";
              echo "$line";
     }
}
$dh->close();
?>
                    <tr> 
                      <td colspan="4" bgcolor='#BEE8FC' height='24'>
                      	<a href='file_manage_main.php'>[��Ŀ¼]</a>
                      	&nbsp;
                      	<a href='file_manage_view.php?fmdo=newfile&activepath=<?php echo urlencode($activepath)?>'>[�½��ļ�]</a>
                      	&nbsp;
                      	<a href='file_manage_view.php?fmdo=newdir&activepath=<?php echo urlencode($activepath)?>'>[�½�Ŀ¼]</a>
                      	&nbsp;
                      	<a href='file_manage_view.php?fmdo=upload&activepath=<?php echo urlencode($activepath)?>'>[�ļ��ϴ�]</a>
                      	&nbsp;
                      	<a href='file_manage_control.php?fmdo=space&activepath=<?php echo urlencode($activepath)?>'>[�ռ���]</a>
                      	&nbsp;&nbsp;</td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>

</html>
