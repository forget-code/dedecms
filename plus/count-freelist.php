<?php 
//�����������������б�����������
$__ONLYDB = true;
require_once(dirname(__FILE__)."/../include/config_base.php");

if(empty($aid)) $aid="0";

//����һҳ�ż����������ÿҳ����������ģ�����JS���ݵ� pageno ȥ������
if(empty($pageno)) $pageno = 1;
if($pageno!=1) exit();

$aid = ereg_replace("[^0-9]","",$aid);

$dsql = new DedeSql(false);
$dsql->ExecuteNoneQuery("Update #@__freelist set click=click+1 where aid='$aid'");
if(!empty($view)){
	$row = $dsql->GetOne("Select click From #@__freelist where aid='$aid'");
	echo "document.write('".$row[0]."');\r\n";
}
$dsql->Close();
exit();

/*-----------------------------------
�������ʾ�������,������view����,��������ʣӵ��÷ŵ��ĵ�ģ���ʵ�λ�� 
<script src="{dede:field name='phpurl'/}/count-freelist.php?view=yes&aid={dede:field name='aid'/}&pageno={dede:pageno/}" language="javascript"></script>
��ͨ������Ϊ
<script src="{dede:field name='phpurl'/}/count-freelist.php?aid={dede:field name='aid'/}&pageno={dede:pageno/}" language="javascript"></script>
----------------------------------*/
?>