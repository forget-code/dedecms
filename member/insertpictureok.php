<?
require_once("config.php");
$conn = connectMySql();
if(!ereg("\.(jpg|gif|png)$",$pic_name))
{
	echo "<script>\n";
	echo "alert('���ͼƬ��ʽ���Ϸ���');\n";
	echo "history.go(-1);\n";
	echo "</script>\n";
	exit();
}
else if($pic>200000)
{
	echo "<script>\n";
	echo "alert('���ͼƬ̫�������С��200K!');\n";
	echo "history.go(-1);\n";
	echo "</script>\n";
	exit();
}
else
{
	$imgUrl = $userimg_dir."/".strftime("%Y%m%d",time());
	$imgPath = $base_dir.$imgUrl;
	if(!is_dir($imgPath)) mkdir($imgPath,0777);
	$milliSecond = strftime("%H%M%S",time()).$_COOKIE["cookie_user"];
	if(eregi("\.gif$",$pic_name)) $shortName = ".gif";
	else if(eregi("\.png$",$pic_name)) $shortName = ".png";
	else $shortName = ".jpg";
	$picname = $imgUrl."/".$milliSecond.$shortName;
	$dataz = GetImageSize($pic,&$info);
	$imgw=$dataz[0];
	$imgh=$dataz[1];
	copy($pic,$base_dir.$picname);
	@unlink($pic);
}
?>
<script language='javascript'>
window.opener.document.form1.body.value+="\r\n<img src='<?=$picname?>' width='<?=$imgw?>' height='<?=$imgh?>' border='0'>\r\n";
window.opener=true;
window.close();
</script>