<?
require(dirname(__FILE__)."/config.php");
CheckPurview('co_EditNote');
$nid = ereg_replace("[^0-9]","",$nid);
if(empty($nid)){
   ShowMsg("������Ч!","-1");
   exit();
}
$dsql = new DedeSql(false);
$row = $dsql->GetOne("Select * From #@__conote where nid='$nid'");
$dsql->Close();
require_once(dirname(__FILE__)."/../include/pub_oxwindow.php");
$wintitle = "�����ɼ�����";
$wecome_info = "<a href='co_main.php'><u>�ɼ��ڵ����</u></a>::�����ɼ�����";
$win = new OxWindow();
$win->Init();
$win->AddTitle("����Ϊ���� [{$row['gathername']}] ���ı����ã�����Թ����������ѣ�");
$winform = $win->GetWindow("hand","<xmp style='color:#333333;background-color:#ffffff'>".$row['noteinfo']."</xmp>");
$win->Display();
exit();
?>