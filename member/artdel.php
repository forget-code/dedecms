<?
require("config.php");
$conn = connectMySql();
mysql_query("Delete From dede_art where ID=$ID And memberID=".$_COOKIE["cookie_user"],$conn);
echo "<script>\n";
echo "alert('�ɹ�ɾ��һƪ����!');\n";
echo "location.href='artlist.php';\n";
echo "</script>\n";
exit();
?>