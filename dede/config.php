<?php 
//��ҳ�����ڼ���û���¼���������Ҫ�ֹ�����ϵͳ���ã������config_base.php
require_once(dirname(__FILE__)."/../include/config_base.php");
require_once(dirname(__FILE__)."/../include/inc_userlogin.php");
header("Cache-Control:private");

//��õ�ǰ�ű����ƣ�������ϵͳ��������$_SERVER�����������и������ѡ��
$dedeNowurl = "";
$s_scriptName="";
$isUrlOpen = @ini_get("allow_url_fopen");
 
$dedeNowurl = GetCurUrl();
$dedeNowurls = explode("?",$dedeNowurl);
$s_scriptName = $dedeNowurls[0];

//�����û���¼״̬
$cuserLogin = new userLogin();
if($cuserLogin->getUserID()==-1)
{
	header("location:login.php?gotopage=".urlencode($dedeNowurl));
	exit();
}

if($cfg_dede_log=='��'){
  $s_nologfile = "_main|_list";
  $s_needlogfile = "sys_|file_";
  isset($_SERVER['REQUEST_METHOD']) ? $s_method=$_SERVER['REQUEST_METHOD'] : $s_method="";
  isset($dedeNowurls[1]) ? $s_query = $dedeNowurls[1] : $s_query = "";
  $s_scriptNames = explode('/',$s_scriptName);
  $s_scriptNames = $s_scriptNames[count($s_scriptNames)-1];
  $s_userip = GetIP();
  if( $s_method=='POST' 
  || (!eregi($s_nologfile,$s_scriptNames) && $s_query!='') 
  || eregi($s_needlogfile,$s_scriptNames) )
  {
     $dsql = new DedeSql(false);
     $inquery = "INSERT INTO #@__log(adminid,filename,method,query,cip,dtime)
             VALUES ('".$cuserLogin->getUserID()."','{$s_scriptNames}','{$s_method}','".addslashes($s_query)."','{$s_userip}','".mytime()."');";
     $dsql->ExecuteNoneQuery($inquery);
     $dsql->Close();
  }
}


function GetTypeidSel($fname,$f1,$f2,$cc,$selv='0',$selname='��ѡ��...',$pos=''){
  global $opall;
  if(empty($opall)) $opall = 0;
  $rstr = "<input type=\"hidden\" name=\"$f1\" value=\"$selv\">\r\n";
	$rstr .= "<input type=\"button\" name=\"$f2\" value=\"$selname\" style=\"height:21px;width:150px;border:0px;background-image:url({$pos}img/ctbg.gif);padding-top:2px; background-color: transparent\" onClick=\"SelectCatalog('$fname','$f1','$f2',$cc,'$pos','$opall');\">\r\n";
	return $rstr;
}

?>