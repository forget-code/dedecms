<?php 
require_once(dirname(__FILE__)."/config.php");
require_once(dirname(__FILE__)."/../include/inc_channel_unit_functions.php");
setcookie("ENV_GOBACK_URL",$dedeNowurl,time()+3600,"/");
CheckPurview('c_FreeList');

$dsql = new DedeSql(false);

if(empty($pagesize)) $pagesize = 18;
if(empty($pageno)) $pageno = 1;
if(empty($dopost)) $dopost = '';
if(empty($orderby)) $orderby = 'aid';
if(empty($keyword)){
	$keyword = '';
	$addget = '';
	$addsql = '';
}else{
	$addget = '&keyword='.urlencode($keyword);
	$addsql = " where title like '%$keyword%' ";
}

//�����б�
if($dopost=='getlist'){
	PrintAjaxHead();
	GetTagList($dsql,$pageno,$pagesize,$orderby);
	$dsql->Close();
	exit();
}
//ɾ���ֶ�
else if($dopost=='del')
{
	$aid = ereg_replace("[^0-9]","",$aid);
	$dsql->ExecuteNoneQuery("Delete From #@__freelist where aid='$aid'; ");
	PrintAjaxHead();
	GetTagList($dsql,$pageno,$pagesize,$orderby);
	$dsql->Close();
	exit();
}

//��һ�ν������ҳ��
if($dopost==''){
	$row = $dsql->GetOne("Select count(*) as dd From #@__freelist $addsql ");
	$totalRow = $row['dd'];
	include(dirname(__FILE__)."/templets/freelist_main.htm");
  $dsql->Close();
}

//����ض���Tag�б�
//---------------------------------
function GetTagList($dsql,$pageno,$pagesize,$orderby='aid'){
	global $cfg_phpurl,$addsql;
	$start = ($pageno-1) * $pagesize;
	$printhead ="<table width='99%' border='0' cellpadding='1' cellspacing='1' bgcolor='#333333' style='margin-bottom:3px'>
    <tr align='center' bgcolor='#E5F9FF' height='24'> 
      <td width='8%'><a href='#' onclick=\"ReloadPage('aid')\"><u>ID</u></a></td>
      <td width='24%'>�б�����</td>
      <td width='30%'>ģ���ļ�</td>
      <td width='8%'><a href='#' onclick=\"ReloadPage('click')\"><u>���</u></a></td>
      <td width='10%'>����ʱ��</td>
      <td>����</td>
    </tr>\r\n";
    echo $printhead;
    $dsql->SetQuery("Select aid,title,templet,click,edtime,namerule,listdir,defaultpage,nodefault From #@__freelist $addsql order by $orderby desc limit $start,$pagesize ");
	  $dsql->Execute();
    while($row = $dsql->GetArray()){
    $listurl = GetFreeListUrl($row['aid'],$row['namerule'],$row['listdir'],$row['defaultpage'],$row['nodefault']);
    $line = "
      <tr align='center' bgcolor='#FFFFFF' onMouseMove=\"javascript:this.bgColor='#FCFEDA';\" onMouseOut=\"javascript:this.bgColor='#FFFFFF';\"> 
      <td height='24'>{$row['aid']}</td>
      <td> <a href='$listurl' target='_blank'>{$row['title']}</a> </td>
      <td> {$row['templet']} </td>
      <td> {$row['click']} </td>
      <td>".strftime("%y-%m-%d",$row['edtime'])."</td>
      <td>
      <a href='#' onclick='EditNote({$row['aid']})'>����</a> | 
      <a href='#' onclick='CreateNote({$row['aid']})'>����</a> | 
      <a href='#' onclick='DelNote({$row['aid']})'>ɾ��</a>
      </td>
    </tr>";
    echo $line;
   }
	 echo "</table>\r\n";
}

function PrintAjaxHead(){
	header("Pragma:no-cache\r\n");
  header("Cache-Control:no-cache\r\n");
  header("Expires:0\r\n");
	header("Content-Type: text/html; charset=gb2312");
}
?>

