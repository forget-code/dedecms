<?
require("config.php");
require("inc_makeart.php");
if(empty($startid)||empty($endid))
{
	if(!empty($_COOKIE["ENV_GOBACK_URL"]))
		ShowMsg("��ûָ����ʼ�ͽ���ID��",$_COOKIE["ENV_GOBACK_URL"]);
	else
		ShowMsg("��ûָ����ʼ�ͽ���ID��",-1);
	exit;
}
if(!isset($q)) $q=1;
if(!isset($i)) $i=0;
if(empty($pagenum)) $pagenum=50;
if($startid<=$endid-$pagenum)
{
	$conn = connectMySql();
	$rs = mysql_query("Select ID From dede_art where ID>=$startid and ID<=$startid+$pagenum",$conn);
	$mr = new makeArt();
	echo "<html><link href='base.css' rel='stylesheet' type='text/css'><body><ul style='margin:0px;'>";
	$bai=(round(($pagenum*$q)/($endid-$startid+$pagenum*$q),2))*100;
	echo "<p style='color:red;margin:0px;'>�������½���:".$startid."/".$endid."</p>";
	echo "<span style='background-color:#3a6ea5;width:100%;'>";
	echo "<span style='background-color:#000;width:".$bai."%;color:#fff;text-align:center;'>".$bai."%</span></span>";
	while($row=mysql_fetch_object($rs))
	{
		$mr->makeArtDone($row->ID);
		$i++;
		echo "<li>������:".$mr->artFileName." Ok!</li>\r\n";
	}
	$q++;
	echo "<meta http-equiv='refresh' content=\"1;url='make_news_html_id.php?startid=".($startid+$pagenum+1)."&endid=".$endid."&i=".$i."&q=".$q."&pagenum=".$pagenum."'\">";
}
else
{
	echo "<html><link href='base.css' rel='stylesheet' type='text/css'><body><ul>";
	echo "<li>���ɽ���,������".$i."ƪ����</li>";
	exit;
}
echo"</ul></body></html>";
?>
