<?php 
require(dirname(__FILE__)."/../include/config_base.php");
if(empty($dopost)) $dopost="";
$dsql = new DedeSql(false);
if($dopost=="save")
{
  if(empty($dopost)) $dopost="";
  if(empty($validate)) $validate=="";
  else $validate = strtolower($validate);
  $svali = GetCkVdValue();
  if($validate=="" || $validate!=$svali){
	  ShowMsg("��֤�벻��ȷ!","");
	  exit();
  }
  $dtime = strftime("%Y-%m-%d %H:%M:%S",mytime());
  $query = "Insert Into #@__flink(sortrank,url,webname,logo,msg,email,typeid,dtime,ischeck) 
  Values('50','$url','$webname','$logo','$msg','$email','$typeid','$dtime','0')";
  $dsql->SetQuery($query);
  $dsql->ExecuteNoneQuery();
  ShowMsg("�ɹ�����һ�����ӣ�����Ҫ��˺������ʾ!","",1);
}

//��ʾģ��(��PHP�ļ�)
include_once($cfg_basedir.$cfg_templets_dir."/plus/flink-list.htm"); 

?>
