<?
header("Content-Type: text/html; charset=gb2312");
header("Pragma:no-cache"); 
header("Cache-Control:no-cache"); 
header("Expires:0"); 
require(dirname(__FILE__)."/config.php");
CheckPurview('sys_Data');
if(empty($dopost)) $dopost = "";
$dsql = new DedeSql(false);
echo "[<a href='#' onclick='javascript:HideObj(\"_mydatainfo\")'><u>�ر�</u></a>]\r\n<xmp>";
if($dopost=="viewinfo") //�鿴��ṹ
{
	if(empty($tablename)) echo "û��ָ��������";
	else{
		$dsql->SetQuery("SHOW CREATE TABLE ".$dsql->dbName.".".$tablename);
    $dsql->Execute();
    $row2 = $dsql->GetArray();
    $ctinfo = $row2[1];
    echo trim($ctinfo);
	}
	$dsql->Close();
	exit();
}
else if($dopost=="opimize") //�Ż���
{
	if(empty($tablename)) echo "û��ָ��������";
	else{
	  $dsql->ExecuteNoneQuery("OPTIMIZE TABLE '$tablename'");
	  $dsql->Close();
	  echo "ִ���Ż��� $tablename  OK��";
  }
	exit();
}
else if($dopost=="repair") //�޸���
{
	if(empty($tablename)) echo "û��ָ��������";
	else{
	  $rs = $dsql->ExecuteNoneQuery("REPAIR TABLE '$tablename'");
	  $dsql->Close();
	  echo "�޸��� $tablename  OK��";
	}
	exit();
}
$dsql->Close();
echo "</xmp>";
?>