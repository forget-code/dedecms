<?php 
if(is_file(dirname(__FILE__)."/setup/notinsall.txt")){
  echo "������㻹û��װ������������<a href='setup/index.php'> setup/index.php </a> ���밲װ&gt;&gt;<br/><br/>";
  echo "��������Ѿ���װ�ó�����ɾ�� setup/notinsall.txt ����ļ�!  <br/><br/>";
  echo "&nbsp;&nbsp;<a href='http://www.dedecms.com' style='font-size:12px' target='_blank'>Power by DedeCms OX V4.0 &nbsp;֯�����ݹ���ϵͳ</a>";
  exit();
}
require_once(dirname(__FILE__)."/include/config_base.php");
require_once(dirname(__FILE__)."/include/inc_arcpart_view.php");
$dsql = new DedeSql(false);
$row  = $dsql->GetOne("Select * From #@__homepageset");
$dsql->Close();
$row['templet'] = str_replace("{style}",$cfg_df_style,$row['templet']);
$pv = new PartView();
$pv->SetTemplet($cfg_basedir."/".$cfg_templets_dir."/".$row['templet']);
$pv->Display();
$pv->Close();
?>