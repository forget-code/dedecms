<?
if(is_dir(dirname(__FILE__)."/setup"))
{
  echo "����㻹û��װ������������<a href='setup/index.php'> setup/index.php </a>,����������������ļ���!";
  echo "<br>Power by www.dedecms.com";
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