<?php 
require_once(dirname(__FILE__)."/config.php");
setcookie("ENV_GOBACK_URL",$dedeNowurl,time()+3600,"/");
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
	$addsql = " where CONCAT(keyword,spwords) like '%$keyword%' ";
}

//�����б�
if($dopost=='getlist'){
	PrintAjaxHead();
	GetKeywordList($dsql,$pageno,$pagesize,$orderby);
	$dsql->Close();
	exit();
}
//�����ֶ�
else if($dopost=='update')
{
	$aid = ereg_replace("[^0-9]","",$aid);
	$count = ereg_replace("[^0-9]","",$count);
	$istag = ereg_replace("[^0-9]","",$istag);
	$keyword = trim($keyword);
	$spwords = trim($spwords);
	$dsql->ExecuteNoneQuery("Update #@__search_keywords set keyword='$keyword',spwords='$spwords',count='$count',istag='$istag' where aid='$aid';");
	PrintAjaxHead();
	GetKeywordList($dsql,$pageno,$pagesize,$orderby);
	$dsql->Close();
	exit();
}
//ɾ���ֶ�
else if($dopost=='del')
{
	$aid = ereg_replace("[^0-9]","",$aid);
	$dsql->ExecuteNoneQuery("Delete From #@__search_keywords where aid='$aid';");
	PrintAjaxHead();
	GetKeywordList($dsql,$pageno,$pagesize,$orderby);
	$dsql->Close();
	exit();
}

//��һ�ν������ҳ��
if($dopost==''){
	$row = $dsql->GetOne("Select count(*) as dd From #@__search_keywords $addsql ");
	$totalRow = $row['dd'];
	include(dirname(__FILE__)."/templets/search_keywords_main.htm");
  $dsql->Close();
}

//����ض��Ĺؼ����б�
//---------------------------------
function GetKeywordList($dsql,$pageno,$pagesize,$orderby='aid'){
	global $cfg_phpurl,$addsql;
	$start = ($pageno-1) * $pagesize;
	$printhead ="<table width='99%' border='0' cellpadding='1' cellspacing='1' bgcolor='#333333' style='margin-bottom:3px'>
    <tr align='center' bgcolor='#E5F9FF' height='24'> 
      <td width='6%' height='23'><a href='#' onclick=\"ReloadPage('aid')\"><u>ID</u></a></td>
      <td width='20%'>�ؼ���</td>
      <td width='25%'>�ִʽ��</td>
      <td width='6%'><a href='#' onclick=\"ReloadPage('count')\"><u>Ƶ��</u></a></td>
      <td width='6%'><a href='#' onclick=\"ReloadPage('result')\"><u>���</u></a></td>
      <td width='10%'><a href='#' onclick=\"ReloadPage('istag')\"><u>�Ƿ�Tag</u></a></td>
      <td width='16%'><a href='#' onclick=\"ReloadPage('lasttime')\"><u>�������ʱ��</u></a></td>
      <td>����</td>
    </tr>\r\n";
    echo $printhead;
    $dsql->SetQuery("Select * From #@__search_keywords $addsql order by $orderby desc limit $start,$pagesize ");
	  $dsql->Execute();
    while($row = $dsql->GetArray()){
    if($row['istag']){ 
       $atag = "<input type='radio' class='np' name='istag{$row['aid']}' id='istag{$row['aid']}1' value='1' checked>�� <input type='radio' class='np' name='istag{$row['aid']}' id='istag{$row['aid']}0' value='2'>��";
    }else{
       $atag = "<input type='radio' class='np' name='istag{$row['aid']}' id='istag{$row['aid']}1' value='1'>�� <input type='radio' class='np' name='istag{$row['aid']}' id='istag{$row['aid']}0' value='2' checked>��";
    }
    $line = "
      <tr align='center' bgcolor='#FFFFFF' onMouseMove=\"javascript:this.bgColor='#FCFEDA';\" onMouseOut=\"javascript:this.bgColor='#FFFFFF';\"> 
      <td height='24'>{$row['aid']}</td>
      <td><input name='keyword' type='text' id='keyword{$row['aid']}' value='{$row['keyword']}' class='ininput'></td>
      <td><input name='spwords' type='text' id='spwords{$row['aid']}' value='{$row['spwords']}' class='ininput'></td>
      <td><input name='count' type='text' id='count{$row['aid']}' value='{$row['count']}' class='ininput'></td>
      <td><a href='{$cfg_phpurl}/search.php?kwtype=0&keyword=".urlencode($row['keyword'])."&searchtype=titlekeyword' target='_blank'><u>{$row['result']}</u></a></td>
      <td> $atag </td>
      <td>".strftime("%y-%m-%d %H:%M:%S",$row['lasttime'])."</td>
      <td>
      <a href='#' onclick='UpdateNote({$row['aid']})'>����</a> | 
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

