<?php 
require_once(dirname(__FILE__)."/config.php");
CheckPurview('c_List');
require_once(dirname(__FILE__)."/../include/pub_datalist.php");
require_once(dirname(__FILE__)."/../include/inc_functions.php");
setcookie("ENV_GOBACK_URL",$dedeNowurl,time()+3600,"/");

function GetSta($sta,$ID)
{
	if($sta==1)
	{
		if($ID>0) return "����  &gt; <a href='mychannel_edit.php?dopost=hide&ID=$ID'><u>����</u></a>";
		else return "�̶���Ŀ";
	}
	else return "���� &gt; <a href='mychannel_edit.php?dopost=show&ID=$ID'><u>����</u></a>";
}

function IsSystem($s)
{
	if($s==1) return "ϵͳģ��";
	else return "�Զ�ģ��";
}

$sql = "Select ID,nid,typename,addtable,isshow,issystem From #@__channeltype order by ID desc";

$dlist = new DataList();
$dlist->Init();
$dlist->SetSource($sql);
$dlist->SetTemplet(dirname(__FILE__)."/templets/mychannel_main.htm");
$dlist->display();
$dlist->Close();
?>