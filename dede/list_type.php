<?
require("config.php");
require("inc_typeunit.php");
$conn = connectMySql();
$userChannel = $cuserLogin->getUserChannel();
?>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
<title>������</title>
<link href='base.css' rel='stylesheet' type='text/css'>
<script>
//���ѡ���ļ����ļ���
function getCheckboxItem()
{
	var allSel="";
	if(document.form1.typeinfo.value) return document.form1.typeinfo.value;
	for(i=0;i<document.form1.typeinfo.length;i++)
	{
		if(document.form1.typeinfo[i].checked)
		{
			allSel=document.form1.typeinfo[i].value;
		}
	}
	return allSel;	
}
function getCheckboxItems()
{
	var allSel="";
	if(document.form1.typeinfo.value) return document.form1.typeinfo.value;
	for(i=0;i<document.form1.typeinfo.length;i++)
	{
		if(document.form1.typeinfo[i].checked)
		{
			allSel+=document.form1.typeinfo[i].value+",";
		}
	}
	return allSel;	
}
function typeDel()
{
	var qstr=getCheckboxItem();
	if(qstr=="") alert("��ûѡ���κ����");
	else
	{
		qstrs = qstr.split("`");
		location.href="del_type.php?ID="+qstrs[0]+"&typeoldname="+qstrs[1];
	}
}
function moveList()
{
	var qstr=getCheckboxItem();
	if(qstr=="") alert("��ûѡ���κ����");
	else
	{
		location.href="move_list.php?job=movelist&typeid="+qstr
	}
}
function uniteList()
{
	var qstr=getCheckboxItem();
	if(qstr=="") alert("��ûѡ���κ����");
	else
	{
		location.href="move_list.php?job=unitelist&typeid="+qstr
	}
}
function typeMod()
{
	var qstrs,qstr=getCheckboxItem();
	if(qstr=="") alert("��ûѡ���κ����");
	else
	{
		qstrs = qstr.split("`");
		location.href="mod_type.php?ID="+qstrs[0]+"&typeoldname="+qstrs[1];
	}
}
function typeAddArt()
{
	var qstr=getCheckboxItem();
	if(qstr=="") alert("��ûѡ���κ����");
	else
	{
		qstrs = qstr.split("`");
		location.href="add_news_view.php?typeid="+qstrs[0]+"&typename="+qstrs[1];
	}
}
function typeAddSun()
{
	var qstr=getCheckboxItem();
	if(qstr=="") location.href="add_type.php?listtype=all";
	else
	{
		qstrs = qstr.split("`");
		location.href="add_type.php?ID="+qstrs[0];
	}
}
function typeEditMode()
{
	var qstr=getCheckboxItem();
	if(qstr=="") alert("��ûѡ���κ����");
	else
	{
		qstrs = qstr.split("`");
		location.href="list_mode_edit.php?ID="+qstrs[0];
	}
}
function viewList()
{
	var qstr=getCheckboxItem();
	if(qstr=="") alert("��ûѡ���κ����");
	else
	{
		qstrs = qstr.split("`");
		window.open("<?=$art_php_dir?>/list.php?id="+qstrs[0]);
	}
}
function viewArt()
{
	var qstr=getCheckboxItem();
	if(qstr=="") alert("��ûѡ���κ����");
	else
	{
		qstrs = qstr.split("`");
		location.href="list_news.php?arttoptype="+qstrs[0];
	}
}
function makeList()
{
	var qstr=getCheckboxItems();
	if(qstr=="") alert("��ûѡ���κ����");
	else
	{
		//qstrs = qstr.split("`");
		location.href="make_list_set.php?typeids="+qstr;
	}
}
function showHide(obj)
{
    var oStyle = obj.parentElement.parentElement.parentElement.rows[1].style;
    oStyle.display == "none" ? oStyle.display = "block" : oStyle.display = "none";
}
</script>
<style>
.coolbg2 {
border: 1px solid #000000;
background-color: #F2F5E9;
height:18px
}
</style>
</head>
<body background='img/allbg.gif' leftmargin='8' topmargin='8'>
<table width="98%" border="0" cellpadding="3" cellspacing="1" bgcolor="#666666" align="center">
<tr>
<td height="19" background='img/tbg.gif' align="right">
<?
if($userChannel<=0)
{
?>
<a href='add_type.php?listtype=all' class='coolbg2'>[���Ӷ���Ŀ¼]</a> 
<a href="make_list.php?job=all" class='coolbg2'>[����/����������Ŀ]</a> 
<a href='file_view.php?activepath=<?=$mod_dir?>' class='coolbg2'>[����ͨ��ģ��]</a>
<?
}
?>
</td>
</tr>
<tr>
<td height="19" bgcolor="#ffffff">
<b>���������Ŀ����ѡ�����</b>
(������̬���б�֧�ֶ�ѡ���������ֻ�����һ����Ч)
</td>
</tr>
<tr>
<td height="27" bgcolor="#FFFFFF" valign='top'>
<span class='coolbg' style='width:100%'>
<a href='#' class='coolbg2'>|</a>
<a href='javascript:typeAddSun();' class='coolbg2'>[������Ƶ��]</a> 
<a href='javascript:typeMod();' class='coolbg2'>[����Ƶ��]</a> 
<a href='javascript:typeEditMode();' class='coolbg2'>[ģ��]</a>
<a href='#' class='coolbg2'>|</a>
<a href='javascript:viewArt();' class='coolbg2'>[����]</a> 
<a href='javascript:viewList();' class='coolbg2'>[Ԥ��]</a>
<a href='javascript:makeList();' class='coolbg2'>[��̬���б�]</a>
<a href='#' class='coolbg2'>|</a>
<a href='javascript:moveList();' class='coolbg2'>[�ƶ�]</a>
<?
if($cuserLogin->getUserType()==10)
{
echo "<a href='javascript:typeDel();' class='coolbg2'>[��ɾ��]</a>\r\n";
}
?>
</span>
</td>
</tr>
<form name='form1'>
<tr>
<td height="94" bgcolor="#FFFFFF">
<?
if(empty($opendir)) $opendir=-1;
if($userChannel>0) $opendir=$userChannel;
$tu = new TypeUnit();
$tu->ListAllType($userChannel,$opendir);
?>
ע����ϵͳ�ǰ������޼��������ʽ��Ƶģ������������㽨������������ȵ�Ŀ¼����Ϊ���������������������������ٷ���Ѹ����Ŀ¼���ӷ�����ҳ�����Ŀ¼�С�
</td>
</tr>
</form>
<tr>
<td height="36" bgcolor="#FFFFFF" align="right">
</td>
</tr>
</table>
</body>
</html>