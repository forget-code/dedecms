<?
require("config.php");
require("inc_makeart.php");

$conn = connectMySql();
//--������յ�����--------------------
$ID = ereg_replace("[^0-9]","",$artID);
$title = cn_substr($title,100);
$source = cn_substr($source,50);
$writer = cn_substr($writer,50);
$msg = cn_substr($shortmsg,500);
$body = str_replace($base_url,"",$artbody);

$stimesql = "";
//���������������û������ֹ�����stime
if(!empty($stime)) 
{
	$stime = trim($stime);
	$stimesql = "stime='$stime',";
}

if(empty($redtitle[0])) $redtitle=0;
else $redtitle = $redtitle[0];

if(empty($isdd[0])) $isdd = 0;
else $isdd=$isdd[0];

if(empty($rank)) $rank=0;

if($rank>0) $ismake="ismake=0,";
else $ismake="";

//��ȡ����body�е�Զ��ͼƬ
if(!empty($saveremoteimg))
{
		$body = stripslashes($body);
		$img_array = array();
		preg_match_all("/(src|SRC)=[\"|'| ]{0,}(http:\/\/(.*)\.(gif|jpg|jpeg|bmp|png))/isU",$body,$img_array);
		$img_array = array_unique($img_array[2]);
		set_time_limit(0);
		$imgUrl = $img_dir."/".strftime("%Y%m%d",time());
		$imgPath = $base_dir.$imgUrl;
		$milliSecond = strftime("%H%M%S",time());
		if(!is_dir($imgPath)) @mkdir($imgPath,0777);
		foreach($img_array as $key =>$value)
		{
			$value = trim($value);
			$get_file = @file_get_contents($value);
			$rndFileName = $imgPath."/".$milliSecond.$key.".".substr($value,-3,3);
			$fileurl = $imgUrl."/".$milliSecond.$key.".".substr($value,-3,3);
			if($get_file)
			{
				$fp = @fopen($rndFileName,"w");
				@fwrite($fp,$get_file);
				@fclose($fp);
			}
			$body = ereg_replace($value,$fileurl,$body);
		}
		$body = addslashes($body);
}

//----------------------------
$upQuery = "Update dede_art set 
$ismake
title='$title',
source='$source',
writer='$writer',
typeid='$typeid',
msg='$msg',
redtitle='$redtitle',
rank='$rank',
$stimesql
body='$body' where ID=$ID";

mysql_query($upQuery,$conn);

if($rank==0)
{
	$mr = new makeArt();
	$mr->makeArtDone($artID);
}

ShowMsg("�ɹ�����һƪ���£�",$ENV_GOBACK_URL);
exit;
?>