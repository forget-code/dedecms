<?php 
require_once(dirname(__FILE__)."/config.php");
CheckPurview('sys_plus');
require_once(dirname(__FILE__)."/../include/pub_datalist.php");
require_once(dirname(__FILE__)."/../include/inc_functions.php");
setcookie("ENV_GOBACK_URL",$dedeNowurl,time()+3600,"/");

function GetSta($sta,$ID,$title)
{
	if($sta==1)
	{
		return " &nbsp; <a href='plus_edit.php?dopost=edit&aid=$ID'><u>�޸�</u></a> &nbsp; ����  &gt; <a href='plus_edit.php?dopost=hide&aid=$ID'><u>����</u></a> &nbsp; <a href='plus_edit.php?dopost=delete&aid=$ID&title=".urlencode($title)."'><u>ɾ��</u></a>";
	}
	else return " &nbsp; <a href='plus_edit.php?aid=$ID'><u>�޸�</u></a> &nbsp; ���� &gt; <a href='plus_edit.php?dopost=show&aid=$ID'><u>����</u></a> &nbsp; <a href='plus_edit.php?dopost=delete&aid=$ID&title=".urlencode($title)."'><u>���</u></a>";
}

$sql = "Select aid,plusname,writer,isshow From #@__plus order by aid asc";

$dlist = new DataList();
$dlist->Init();
$dlist->SetSource($sql);
$dlist->SetTemplet(dirname(__FILE__)."/templets/plus_main.htm");
$dlist->display();
$dlist->Close();
?>