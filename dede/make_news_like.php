<?
require("config.php");
if($artids=="")
{
	ShowMsg("��ûѡ���κ�ѡ�",$ENV_GOBACK_URL);
	exit;
}
$conn = @connectMySql();
$artids=ereg_replace("[^0-9`]","",$artids);
$ids = split("`",$artids);
$wherestr = "(";
$j=count($ids);
for($i=0;$i<$j;$i++)
{
	if($i==0) $wherestr.="ID=".$ids[$i];
	else $wherestr.=" Or ID=".$ids[$i];
}
$wherestr .= ")";
mysql_query("Update art set likeid='$artids' where $wherestr",$conn);
ShowMsg("�ɹ�ִ��ָ��������",$ENV_GOBACK_URL);
exit;
?>