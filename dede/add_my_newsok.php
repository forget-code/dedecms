<?
require("config.php");
require("inc_dedetag.php");
$datafile = $base_dir.$art_php_dir."/webnews/news.xml";
if(!file_exists($datafile))
{
	$fp = @fopen($datafile,"w") or die("�޷������ļ���$datafile");
	fclose($fp);
}
$CDTag = new DedeTag();
$ctp = new DedeTagParse();
$ctp->SetNameSpace("mynews");
$ctp->LoadTemplate($datafile);
$title = trim($title);
$writer = trim($writer);
$sdate = trim($sdate);
$msg = nl2br(trim($msg));
$msg = str_replace("/>","",$msg);
/////////////////////////
$fp = fopen($datafile,"w");
fwrite($fp,"//���ﲢ�Ǳ�׼��XML�ļ���������XML���ֿռ���ʽ��֯����\n");
if($ctp->GetCount()!=0)
{
	if($ctp->GetCount()==21) $startdd = 1;
	else $startdd = 0;
	for($i=$startdd;$i<$ctp->GetCount();$i++)
	{
		$CDTag = $ctp->CTags[$i];
		fwrite($fp,"<".$ctp->NameSpace.":".$CDTag->TagName);
		foreach($CDTag->CAttribute->Items as $key=>$value)
		{
			if($key!="tagname") fwrite($fp," $key=\"$value\"");
		}
		fwrite($fp,">\r\n".trim($CDTag->InnerText)."\r\n</".$ctp->NameSpace.">\r\n");
	}
}
fwrite($fp,"<".$ctp->NameSpace.":item title=\"$title\" writer=\"$writer\" senddate=\"$sdate\">\r\n");
fwrite($fp,"$msg\r\n</".$ctp->NameSpace.">\r\n");
fclose($fp);
ShowMsg("�ɹ�����һ��վ�����ţ�","-1");
?>