<?
require_once(dirname(__FILE__)."/config.php");
require_once(dirname(__FILE__)."/../include/inc_typeunit2.php");
$userChannel = $cuserLogin->getUserChannel();
?>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
<title>������</title>
<link href='base.css' rel='stylesheet' type='text/css'>
<script language="javascript" src="js/context_menu.js"></script>
<script language="javascript" src="js/ieemu.js"></script>
<script language="javascript">
function showHide(objname)
{
   var obj = document.getElementById(objname);
   if(obj.style.display=="none") obj.style.display = "block";
	 else obj.style.display="none";
}
if(moz) {
	extendEventObject();
	extendElementModel();
	emulateAttachEvent();
}
//��ͨ��Ŀ
function CommonMenu(obj,tid,tname)
{
  var eobj,popupoptions
  popupoptions = [
    new ContextItem("��������",function(){location="catalog_do.php?cid="+tid+"&dopost=addArchives";}),
    new ContextItem("��������",function(){location="catalog_do.php?cid="+tid+"&dopost=listArchives";}),
    new ContextSeperator(),
    new ContextItem("Ԥ������",function(){ window.open("<?=$cfg_plus_dir?>/list.php?tid="+tid); }),
    new ContextItem("����HTML",function(){ location="makehtml_list.php?cid="+tid; }),
    new ContextItem("��ȡJS�ļ�",function(){ location="catalog_do.php?cid="+tid+"&dopost=GetJs"; }),
    new ContextSeperator(),
    new ContextItem("��������",function(){location="catalog_add.php?ID="+tid;}),
    new ContextItem("������Ŀ",function(){location="catalog_edit.php?ID="+tid;}),
    new ContextSeperator(),
    new ContextItem("�ƶ���Ŀ",function(){location='catalog_move.php?job=movelist&typeid='+tid}),
    new ContextItem("ɾ����Ŀ",function(){location="catalog_del.php?ID="+tid+"&typeoldname="+tname;}),
    new ContextSeperator(),
    new ContextItem("������ǰһ��",function(){ location="catalog_do.php?cid="+tid+"&dopost=upRank"; })
  ]
  ContextMenu.display(popupoptions)
}
//����ҳ��
function SingleMenu(obj,tid,tname)
{
  var eobj,popupoptions
  popupoptions = [
    new ContextItem("Ԥ��ҳ��",function(){ window.open("catalog_do.php?cid="+tid+"&dopost=viewSgPage"); }),
    new ContextItem("�༭ҳ��",function(){ location="catalog_do.php?cid="+tid+"&dopost=editSgPage"; }),
    new ContextItem("�༭ģ��",function(){ location="catalog_do.php?cid="+tid+"&dopost=editSgTemplet"; }),
    new ContextSeperator(),
    new ContextItem("������Ŀ",function(){location="catalog_edit.php?ID="+tid;}),
    new ContextSeperator(),
    new ContextItem("�ƶ���Ŀ",function(){location='catalog_move.php?job=movelist&typeid='+tid}),
    new ContextItem("ɾ����Ŀ",function(){location="catalog_del.php?ID="+tid+"&typeoldname="+tname;}),
    new ContextSeperator(),
    new ContextItem("������ǰһ��",function(){ window.location="catalog_do.php?cid="+tid+"&dopost=upRank"; })
  ]
  ContextMenu.display(popupoptions)
}
</script>
<style>
.coolbg2 {
border: 1px solid #000000;
background-color: #F2F5E9;
height:18px
}
.bline {border-bottom: 1px solid #BCBCBC;background-color:#F0F4F1;}
</style>
</head>
<body background='img/allbg.gif' leftmargin='8' topmargin='8' onload="ContextMenu.intializeContextMenu()">
<table width="98%" border="0" cellpadding="3" cellspacing="1" bgcolor="#666666" align="center">
<tr>
<td height="19" background='img/tbg.gif' align="right">
<?
if($userChannel<=0)
{
?>
<a href='catalog_add.php?listtype=all' class='coolbg2'>[���Ӷ�����Ŀ]</a> 
<a href="makehtml_list.php" class='coolbg2'>[����������ĿHTML]</a> 
<a href='catalog_do.php?dopost=viewTemplet' class='coolbg2'>[����ͨ��ģ��]</a>
<?
}
?>
</td>
</tr>
<tr>
<td height="19" bgcolor="#ffffff">
<b>��ʹ���Ҽ��˵����в�����</b>
(�����û���κη��࣬���ȡ����Ӷ���Ŀ¼��)
</td>
</tr>
<form name='form1'>
<tr>
<td height="120" bgcolor="#FFFFFF" valign="top">
<?
if(empty($opendir)) $opendir=-1;
if($userChannel>0) $opendir=$userChannel;
$tu = new TypeUnit();
$tu->ListAllType($userChannel,$opendir);
$tu->Close();
?>
<br/>
</td>
</tr>
</form>
<tr>
<td height="36" bgcolor="#FFFFFF" align="center">
<?=$cfg_powerby?>
</td>
</tr>
</table>
</body>
</html>