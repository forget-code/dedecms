<?
if(is_dir("setup"))
{
  echo "����㻹û��װ������,������<a href='setup/setup.php'>setup/setup.php</a>,������ɾ������ļ���!";
  exit();
}
require("dede/inc_makepartcode.php");
$maprt= new MakePartCode();
$modfilename = $base_dir."/".$mod_dir."/��ҳ��/��������.htm";
$fp = fopen($modfilename,"r");
$testcode = fread($fp,filesize($modfilename));
fclose($fp);
echo $maprt->ParTemp($testcode);
?>