<?
require_once(dirname(__FILE__)."/config.php");

if(empty($activepath)) $activepath = "";

//����û��ļ����·���Ƿ�Ϸ�
$activepath = str_replace("\\","/",$activepath);
$activepath = str_replace("..","",$activepath);
$activepath = ereg_replace("^/{1,}","/",$activepath);
$rootdir = $cfg_user_dir."/".$cfg_ml->M_ID;

if(!is_dir($cfg_basedir.$rootdir)){
	MkdirAll($cfg_basedir.$rootdir,777);
}

if(strlen($activepath) < strlen($rootdir)){
	$activepath = $rootdir;
}

$inpath = $cfg_basedir.$activepath; 
$activeurl = "..".$activepath;
if(empty($f)) $f="form1.enclosure";

if(empty($comeback)) $comeback = "";

?>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
<title>���������</title>
<link href='base.css' rel='stylesheet' type='text/css'>
<style>
.linerow {border-bottom: 1px solid #CBD8AC;}
</style>
</head>
<body background='img/allbg.gif' leftmargin='0' topmargin='0'>
<SCRIPT language='JavaScript'>
function nullLink()
{
	return;
}
function ReturnValue(reimg)
{
	window.opener.document.<?=$f?>.value=reimg;
	if(document.all) window.opener=true;
  window.close();
}
</SCRIPT>
<table width='100%' border='0' cellpadding='0' cellspacing='1' bgcolor='#CBD8AC' align="center">
<tr bgcolor='#FFFFFF'> 
<td colspan='3'>
<!-- ��ʼ�ļ��б�  -->
<table width='100%' border='0' cellspacing='0' cellpadding='2'>
<tr bgcolor="#CCCCCC"> 
<td width="55%" align="center" background="img/wbg.gif" class='linerow'><strong>�������ѡ���ļ�</strong></td>
<td width="15%" align="center" bgcolor='#EEF4EA' class='linerow'><strong>�ļ���С</strong></td>
<td width="30%" align="center" background="img/wbg.gif" class='linerow'><strong>����޸�ʱ��</strong></td>
</tr>
<?
$dh = dir($inpath);
$ty1="";
$ty2="";
while($file = $dh->read()) {

//-----�����ļ���С�ʹ���ʱ��
if($file!="." && $file!=".." && !is_dir("$inpath/$file")){
   $filesize = filesize("$inpath/$file");
   $filesize=$filesize/1024;
   if($filesize!="")
   if($filesize<0.1){
    @list($ty1,$ty2)=split("\.",$filesize);
    $filesize=$ty1.".".substr($ty2,0,2);
   }
   else{
    @list($ty1,$ty2)=split("\.",$filesize);
    $filesize=$ty1.".".substr($ty2,0,1);
  }
  $filetime = filemtime("$inpath/$file");
  $filetime = strftime("%y-%m-%d %H:%M:%S",$filetime);
}
 
 //------�ж��ļ����Ͳ�������
 if($file == ".") continue;
 else if($file == "..")
 {
    if($activepath == "") continue;
    $tmp = eregi_replace("[/][^/]*$","",$activepath);
    $line = "\n<tr>
    <td class='linerow'> <a href='select_soft.php?f=$f&activepath=".urlencode($tmp)."'><img src=img/dir2.gif border=0 width=16 height=16 align=absmiddle>�ϼ�Ŀ¼</a></td>
    <td colspan='2' class='linerow'> ��ǰĿ¼:$activepath</td>
    </tr>\r\n";
    echo $line;
}
else if(is_dir("$inpath/$file"))
{
   if(eregi("^_(.*)$",$file)) continue; #����FrontPage��չĿ¼��linux����Ŀ¼
   if(eregi("^\.(.*)$",$file)) continue;
     $line = "\n<tr>
   <td bgcolor='#F9FBF0' class='linerow'>
    <a href=select_soft.php?f=$f&activepath=".urlencode("$activepath/$file")."><img src=img/dir.gif border=0 width=16 height=16 align=absmiddle>$file</a>
   </td>
   <td class='linerow'>-</td>
   <td bgcolor='#F9FBF0' class='linerow'>-</td>
   </tr>";
   echo "$line";
}
else if(eregi("\.(zip|rar|tgr.gz)",$file)){
   
   if($file==$comeback) $lstyle = " style='color:red' ";
   else  $lstyle = "";
   
   $reurl = "$activeurl/$file";
  
   $reurl = ereg_replace("^\.\.","",$reurl);
   $reurl = $cfg_mainsite.$reurl;
   
   $line = "\n<tr>
   <td class='linerow' bgcolor='#F9FBF0'>
     <a href=\"javascript:ReturnValue('$reurl');\" $lstyle><img src=img/zip.gif border=0 width=16 height=16 align=absmiddle>$file</a>
   </td>
   <td class='linerow'>$filesize KB</td>
   <td align='center' class='linerow' bgcolor='#F9FBF0'>$filetime</td>
   </tr>";
    echo "$line";
}
else if(eregi("\.(exe)",$file)){
   
   if($file==$comeback) $lstyle = " style='color:red' ";
   else  $lstyle = "";
   
   $reurl = "$activeurl/$file";
  
   $reurl = ereg_replace("^\.\.","",$reurl);
   $reurl = $cfg_mainsite.$reurl;
   
   $line = "\n<tr>
   <td class='linerow' bgcolor='#F9FBF0'>
     <a href=\"javascript:ReturnValue('$reurl');\" $lstyle><img src=img/exe.gif border=0 width=16 height=16 align=absmiddle>$file</a>
   </td>
   <td class='linerow'>$filesize KB</td>
   <td align='center' class='linerow' bgcolor='#F9FBF0'>$filetime</td>
   </tr>";
    echo "$line";
}
}//End Loop
$dh->close();
?>
<!-- �ļ��б��� -->
<tr> 
<td colspan='3' bgcolor='#E8F1DE'>

<table width='100%'>
<form action='select_soft_post.php' method='POST' enctype="multipart/form-data" name='myform'>
<input type='hidden' name='activepath' value='<?=$activepath?>'>
<input type='hidden' name='f' value='<?=$f?>'>
<input type='hidden' name='job' value='upload'>
<tr>
<td background="img/tbg.gif" bgcolor="#99CC00">
  &nbsp;�ϡ����� <input type='file' name='uploadfile' style='width:200'>
                    <input type='submit' name='sb1' value='ȷ��'>
</td>
</tr>
</form>
<form action='select_soft_post.php' method='POST' name='myform2'>
<input type='hidden' name='activepath' value='<?=$activepath?>' style='width:200'>
<input type='hidden' name='f' value='<?=$f?>'>
<input type='hidden' name='job' value='newdir'>
<tr>
  <td background="img/tbg.gif" bgcolor='#66CC00'> &nbsp;��Ŀ¼�� 
  <input type='text' name='dirname' value='' style='width:150'>
  <input type='submit' name='sb2' value='����' style='width:40'>
</td>
</tr>
</form>
</table>

</td>
</tr>
</table>

</td>
</tr>
</table>

</body>
</html>
