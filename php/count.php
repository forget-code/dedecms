<?
include("config.php");
$conn = connectMySql();
if(empty($artID)) $artID="0";
$ID = ereg_replace("[^0-9]","",$artID);
mysql_query("Update dede_art set click=click+1 where ID=$ID",$conn);
//�������ʾ�������,������view,
//��<script src="count.php?view=yes&artID=����ID" language="javascript"></script>
if(!empty($view))
{
	$rs = mysql_query("select click from dede_art where ID=$ID",$conn);
	$row = mysql_fetch_array($rs);
	echo "document.write('".$row[0]."');\r\n";
}
?>