<?
require_once(dirname(__FILE__)."/../include/config_base.php");
if(empty($aid)) $aid="0";
$aid = ereg_replace("[^0-9]","",$aid);
$dsql = new DedeSql(false);
$dsql->SetQuery("Update #@__archives set click=click+1 where ID='$aid'");
$dsql->ExecuteNoneQuery();
if(!empty($view))
{
	$row = $dsql->GetOne("Select click From #@__archives  where ID='$aid'");
	echo "document.write('".$row[0]."');\r\n";
}
$dsql->Close();
exit();
//�������ʾ�������,������view����,
//���� 
//<script src="{dede:field name='phpurl'/}/count.php?view=yes&aid={dede:field name='ID'/}" language="javascript"></script>
//�ŵ��ʵ��ĵ�ģ��λ��
?>