<?
require("config.php");
require("inc_makeart.php");
require("inc_pic_resize.php");
if(empty($autosize)) $autosize=0;
$picname="";
//�ļ�����λ��
$rndFileName = strftime("%H%M%S",time()).mt_rand(100,999);
//����ͼ
if(!empty($litpic_name))
{
	if(!ereg("\.(jpg|gif|png)$",$litpic_name))
	{
		ShowMsg("���ͼƬ��ʽ���Ϸ���","-1");
		exit;
	}
	//���Ŀ¼
	$imgUrl = $ddimg_dir."/".strftime("%Y%m%d",time());
	if(!is_dir($base_dir.$imgUrl)) @mkdir($base_dir.$imgUrl,0755);
	
	if(eregi("\.gif$",$litpic_name)) $shortName = ".gif";
	else if(eregi("\.png$",$litpic_name)) $shortName = ".png";
	else $shortName = ".jpg";
	
	$picname = $imgUrl."/".$rndFileName.$shortName;
	if($autosize==0) copy($litpic,$base_dir.$picname);
	else pic_resize($litpic,$base_dir.$picname,$imgw,$imgh);
	@unlink($litpic);
}
//����Flash
if(!empty($flash_name))
{
	if(!eregi("\.swf$",$flash_name))
	{
		ShowMsg("���ϴ���Flash��ʽ���Ϸ���","-1");
		exit;
	}
	//���Ŀ¼
	$imgUrl = $img_dir."/".strftime("%Y%m%d",time());
	if(!is_dir($base_dir.$imgUrl)) @mkdir($base_dir.$imgUrl,0755);
	$flash_urlname = $imgUrl."/".$rndFileName.".swf";
	copy($flash,$base_dir.$flash_urlname);
	$flashsize = ceil(filesize($flash)/1024);
	@unlink($flash);
}
else
{
	$flash_urlname = $flashurl;
	$flashsize = $fflashsize;
}
$writer="$flashsize K";
$body =
"<table width=".($flashw+4)." height=".($flashh+4)." border=0 align=center cellpadding=1 cellspacing=1 bgcolor=#BBC7AD>
<tr>
<td align=center bgcolor=#FFFFFF>
<object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' width='$flashw' height='$flashh'>
    <param name='movie' value='$flash_urlname'>
    <param name='quality' value='high'>
    <embed src='$flash_urlname' quality='high' pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash' width='$flashw' height='$flashh'></embed>
  </object>
</td>
</tr>
<tr>
<td align=center bgcolor=#FFFFFF><a href='$flash_urlname' target='_blank'>[ȫ���ۿ�] ������Ҽ�->���Ϊ�� �ɱ������FlashӰƬ</a></td>
</tr>
</table>
";
$body = addslashes($body);
//����Flash
$conn = connectMySql();
//--������յ�����--------------------
$adminid=$cuserLogin->getUserID();
$title = cn_substr(trim($title),100);
$source = cn_substr(trim($source),50);
$msg = cn_substr(trim($msg),500);
//---���·���ʱ��--------
$stime = strftime("%Y-%m-%d",time());
//---���뵽���ݿ��SQL���-------------
//$body = addslashes($body);
$inQuery = "
INSERT INTO dede_art(typeid,title,source,writer,rank,
stime,picname,isdd,click,msg,redtitle,ismake,body,userid,spec)
 VALUES ('$typeid','$title','$source','$writer','0',
'$stime','$picname','1','0','$msg','0','0','$body','$adminid','0')";
mysql_query($inQuery,$conn);
$artID = mysql_insert_id($conn);
$typename = "";
if($artID!=0)
{
	$mr = new makeArt();
	$mr->makeArtDone($artID);
	$artfilename = $mr->artFileName;
	$rs = mysql_query("select modname,typename from dede_arttype where ID=$typeid",$conn);
	$row = mysql_fetch_array($rs);
	$typename = $row["typename"];
}
else
{
	echo "<script>alert('����Flashʧ�ܣ�ԭ���ǣ�".str_replace("'","\\'",mysql_error())."');history.go(-1);</script>";
	exit();
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�ɹ���ʾ</title>
<link href="base.css" rel="stylesheet" type="text/css">
<style>
.bt{border-left: 1px solid #FFFFFF; border-right: 1px solid #666666; border-top: 1px solid #FFFFFF; border-bottom: 1px solid #666666; background-color: #C0C0C0}
</style>
</head>
<body background="img/allbg.gif" leftmargin="6" topmargin="6">
<table width="409" border="0" cellpadding="1" cellspacing="1" bgcolor="#666666" align="center">
          <tr align="center"> 
            <td width="405" height="26" colspan="2" background='img/tbg.gif'><strong>Flash�ϴ��ɹ�!</strong></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            
          <td height="85" colspan="2" align="center"> Flash����: 
            <?=$title?>
            
      <p> <a href='add_news_flash.php?typeid=<?=$typeid?>&typename=<?=$typename?>'>[<u>������Flash</u>]</a> 
        &nbsp;&nbsp; <a href='list_news.php?arttoptype=<?=$typeid?>'>[<u>�����б�</u>]</a>&nbsp; <a href='<?=$artfilename;?>' target='_blank'>[<u>�鿴����</u>]</a>&nbsp; 
    </td>
          </tr>
      </table>
</body>
</html>