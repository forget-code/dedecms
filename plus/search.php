<?
require_once(dirname(__FILE__)."/../include/inc_arcsearch_view.php");

if(empty($typeid)) $typeid = 0;
else $typeid = ereg_replace("[^0-9]","",$typeid);

if(empty($orderby)) $orderby="";
else $orderby = eregi_replace("[^a-z]","",$orderby);

if(empty($channeltype)) $channeltype="-1";
else $channeltype = eregi_replace("[^0-9]","",$channeltype);

if(empty($searchtype)) $searchtype = "titlekeyword";
else $searchtype = eregi_replace("[^a-z]","",$searchtype);

//ÿҳ��ʾ�Ľ���������û�ûָ�����������10
if(empty($pagesize)) $pagesize = 10;
else $pagesize = eregi_replace("[^0-9]","",$pagesize);

if(!isset($kwtype)) $kwtype = 1;

if(empty($keyword)) $keyword = "";

$keyword = stripslashes($keyword);
$keyword = ereg_replace("[\|\"\r\n\t%\*\?\(\)\$;,'%-]"," ",trim($keyword));

if(eregi($cfg_notallowstr,$keyword) || eregi($cfg_replacestr,$keyword)){
	echo "�����Ϣ�д��ڷǷ����ݣ���ϵͳ��ֹ��<a href='javascript:history.go(-1)'>[����]</a>"; exit();
}

if($keyword==""||strlen($keyword)<2){
	ShowMsg("�ؼ��ֲ���С��2���ֽڣ�","-1");
	exit();
}

if(empty($starttime)) $starttime = -1;
else //��ʼʱ��
{
	$starttime = ereg_replace("[^0-9]","",$starttime);
	if($starttime>0){
	  $starttime = ereg_replace("[^0-9]","",$starttime);
	  $dayst = GetMkTime("2006-1-2 0:0:0") - GetMkTime("2006-1-1 0:0:0");
	  $starttime = mytime() - ($starttime * $dayst);
  }
}

$sp = new SearchView($typeid,$keyword,$orderby,$channeltype,$searchtype,$starttime,$pagesize,$kwtype);
$sp->Display();
$sp->Close();

?>