<?php 
$__ONLYDB = true;
require_once(dirname(__FILE__)."/../include/config_base.php");

if(empty($aid)) $aid="0";
$aid = ereg_replace("[^0-9]","",$aid);
if(empty($mid)) $mid="0";
$mid = ereg_replace("[^0-9]","",$mid);

$dsql = new DedeSql(false);
$dsql->ExecuteNoneQuery("Update #@__archives set click=click+1 where ID='$aid'");
if(!empty($mid)){
	$dsql->ExecuteNoneQuery("Update #@__member set pageshow=pageshow+1 where ID='$mid'");
}
if(!empty($view)){
	$row = $dsql->GetOne("Select click From #@__archives  where ID='$aid'");
	echo "document.write('".$row[0]."');\r\n";
}
$dsql->Close();
exit();

//�������ʾ�������,������view����,��������ʣӵ��÷ŵ��ĵ�ģ���ʵ�λ�� 
//<script src="{dede:field name='phpurl'/}/count.php?view=yes&aid={dede:field name='ID'/}&mid={dede:field name='memberID'/}" language="javascript"></script>
//��ͨ������Ϊ
//<script src="{dede:field name='phpurl'/}/count.php?aid={dede:field name='ID'/}&mid={dede:field name='memberID'/}" language="javascript"></script>

?>