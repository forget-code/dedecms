<?
require("config.php");
if(empty($temppath)) $temppath="";
if(empty($activepath)) $activepath="";
class SpaceUse
{
var $totalsize=0;	
function checksize($indir)
{
   $dh=dir($indir);
   while($filename=$dh->read())
   {
       if(!ereg("^\.",$filename))
       {
       	   if(is_dir("$indir/$filename")) $this->checksize("$indir/$filename");
       	   else $this->totalsize=$this->totalsize + filesize("$indir/$filename");
       }
   }
}
function setkb($size)
{
	$size=$size/1024;
	//$size=ceil($size);
	list($t1,$t2)=split("\.",$size);
	$size=$t1.".".substr($t2,0,1);
	return $size;
}
function setmb($size)
{
	$size=$size/1024/1024;
	//$size=ceil($size);
	list($t1,$t2)=split("\.",$size);
	$size=$t1.".".substr($t2,0,2);
	return $size;
}	
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�ռ���</title>
<link href="base.css" rel="stylesheet" type="text/css">
<script src="menu.js" language="JavaScript"></script>
</head>
<body background="img/allbg.gif" leftmargin="0" topmargin="0">
<p>&nbsp;</p>
<table width="400" border="0" align="center" cellspacing="1" bgcolor="#666666">
  <tr>
    <td height="27" bgcolor="#CCCCCC"> 
      <?
	if($activepath=="")
   		$ecpath = "����Ŀ¼";
	else
   		$ecpath = $activepath;	
	echo "Ŀ¼ <a href='file_view.php?activepath=$temppath'><b><u>[".$ecpath."]</u></b></a> �ռ�ʹ��״����<br>";
	?>
    </td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"> <table width="90" border="0" cellspacing="2">
        <tr>
          <td>
            <?
$activepath=$base_dir.$activepath;
$space=new SpaceUse;
$space->checksize($activepath);
$total=$space->totalsize;
$totalkb=$space->setkb($total);
$totalmb=$space->setmb($total);
echo "$totalmb M<br>";
echo "$totalkb KB<br>";
echo "$total �ֽ�";
?>
          </td>
        </tr>
      </table></td>
  </tr>
</table>
</body>

</html>
