<?php 
require_once(dirname(__FILE__)."/config.php");
require_once(dirname(__FILE__)."/../include/inc_typeunit_menu.php");
$userChannel = $cuserLogin->getUserChannel();
?>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
<title>������</title>
<link href='base.css' rel='stylesheet' type='text/css'>
<script language="javascript" src="js/context_menu.js"></script>
<script language="javascript" src="js/ieemu.js"></script>
<script language="javascript" src="../include/dedeajax2.js"></script>
<script language="javascript">
function LoadSuns(ctid,tid)
{
	if($(ctid).innerHTML.length < 10){
	  var myajax = new DedeAjax($(ctid),true,true,'','x','...');
	  myajax.SendGet('catalog_do.php?dopost=GetSunListsMenu&cid='+tid);
  }
  else{ if(document.all) showHide(ctid); }
}
function showHide(objname)
{
     if($(objname).style.display=="none") $(objname).style.display = "block";
	 else $(objname).style.display="none";
	 return false;
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
    new ContextItem("��������",function(){top.document.frames['main'].location="catalog_do.php?cid="+tid+"&dopost=addArchives";}),
    new ContextItem("��������",function(){top.document.frames['main'].location="catalog_do.php?cid="+tid+"&dopost=listArchives";}),
    new ContextSeperator(),
    new ContextItem("Ԥ������",function(){ window.open("<?php echo $cfg_plus_dir?>/list.php?tid="+tid); }),
    new ContextItem("����HTML",function(){ top.document.frames['main'].location="makehtml_list.php?cid="+tid; }),
    new ContextItem("��ȡJS�ļ�",function(){ top.document.frames['main'].location="catalog_do.php?cid="+tid+"&dopost=GetJs"; }),
    new ContextSeperator(),
    new ContextItem("��������",function(){top.document.frames['main'].location="catalog_add.php?ID="+tid;}),
    new ContextItem("������Ŀ",function(){top.document.frames['main'].location="catalog_edit.php?ID="+tid;}),
    new ContextSeperator(),
    new ContextItem("�ƶ���Ŀ",function(){top.document.frames['main'].location='catalog_move.php?job=movelist&typeid='+tid}),
    new ContextItem("ɾ����Ŀ",function(){top.document.frames['main'].location="catalog_del.php?ID="+tid+"&typeoldname="+tname;})
  ]
  ContextMenu.display(popupoptions)
}
//����ģ��
function CommonMenuPart(obj,tid,tname)
{
  var eobj,popupoptions
  popupoptions = [
    new ContextItem("��������",function(){top.document.frames['main'].location="catalog_do.php?cid="+tid+"&dopost=addArchives";}),
    new ContextItem("��������",function(){top.document.frames['main'].location="catalog_do.php?cid="+tid+"&dopost=listArchives";}),
    new ContextSeperator(),
    new ContextItem("Ԥ������",function(){ window.open("<?php echo $cfg_plus_dir?>/list.php?tid="+tid); }),
    new ContextItem("����HTML",function(){ top.document.frames['main'].location="makehtml_list.php?cid="+tid; }),
    new ContextItem("��ȡJS�ļ�",function(){ top.document.frames['main'].location="catalog_do.php?cid="+tid+"&dopost=GetJs"; }),
    new ContextSeperator(),
    new ContextItem("��������",function(){top.document.frames['main'].location="catalog_add.php?ID="+tid;}),
    new ContextItem("������Ŀ",function(){top.document.frames['main'].location="catalog_edit.php?ID="+tid;}),
    new ContextSeperator(),
    new ContextItem("�ƶ���Ŀ",function(){top.document.frames['main'].location='catalog_move.php?job=movelist&typeid='+tid}),
    new ContextItem("ɾ����Ŀ",function(){top.document.frames['main'].location="catalog_del.php?ID="+tid+"&typeoldname="+tname;})
 ]
  ContextMenu.display(popupoptions)
}
//����ҳ��
function SingleMenu(obj,tid,tname)
{
  var eobj,popupoptions
  popupoptions = [
    new ContextItem("Ԥ��ҳ��",function(){ window.open("catalog_do.php?cid="+tid+"&dopost=viewSgPage"); }),
    new ContextItem("�༭ҳ��",function(){ top.document.frames['main'].location="catalog_do.php?cid="+tid+"&dopost=editSgPage"; }),
    new ContextItem("�༭ģ��",function(){ top.document.frames['main'].location="catalog_do.php?cid="+tid+"&dopost=editSgTemplet"; }),
    new ContextSeperator(),
    new ContextItem("������Ŀ",function(){top.document.frames['main'].location="catalog_edit.php?ID="+tid;}),
    new ContextSeperator(),
    new ContextItem("�ƶ���Ŀ",function(){top.document.frames['main'].location='catalog_move.php?job=movelist&typeid='+tid}),
    new ContextItem("ɾ����Ŀ",function(){top.document.frames['main'].location="catalog_del.php?ID="+tid+"&typeoldname="+tname;})
 ]
  ContextMenu.display(popupoptions)
}
</script>
<style>
div,dd{ margin:0px; padding:0px }
.dlf { margin-right:3px; margin-left:6px; margin-top:2px; float:left }
.dlr { float:left }
.topcc{ margin-top:5px }
.suncc{ margin-bottom:3px }
dl{ clear:left; margin:0px; padding:0px }
.sunct{  }
#items1{ border-bottom: 1px solid #3885AC;
         border-left: 1px solid #2FA1DB;
         border-right: 1px solid #2FA1DB;
}
.sunlist{ width:100%; padding-left:0px; margin:0px; clear:left } 
.tdborder{
border-left: 1px solid #43938B;
border-right: 1px solid #43938B;
border-bottom: 1px solid #43938B;
}
.tdline-left{
border-bottom: 1px solid #656363;
border-left: 1px solid #788C47;
}
.tdline-right{
border-bottom: 1px solid #656363;
border-right: 1px solid #788C47;
}
.tdrl{
border-left: 1px solid #788C47;
border-right: 1px solid #788C47;
}
.top{cursor: hand;}
body {
scrollbar-base-color:#8CC1FE;
scrollbar-arrow-color:#FFFFFF;
scrollbar-shadow-color:#6994C2
}
</style>
</head>
<base target="main">
<body leftmargin="0" bgcolor="#86C1FF" topmargin="3" target="main" onload="ContextMenu.intializeContextMenu()">
<table width='98%' border='0' align='center' cellpadding='0' cellspacing='0'>
  <tr> 
    <td height='32' colspan="2" align='center'>
	 <form name="form1" target="main" action="catalog_add.php">
	 	<input type='hidden' name='listtype' value='all'>
	 </form>
	 <form name="form2" target="main" action="catalog_main.php"></form>
	 <input type="button" name="sb1" value="�½���Ŀ" class="nbt" style="width:60px" onclick="document.form1.submit();">
      <input type="button" name="sb2" value="��Ŀ����" class="nbt" style="width:60px" onclick="document.form2.submit();">
	 </td>
  </tr>
  <tr> 
    <td width="23%" height='24' align='center' background='img/mtbg1.gif'  style='border-left: 1px solid #2FA1DB;'><a href="#" onclick="showHide('items1')" target="_self"><img src="img/mtimg1.gif" width="21" height="24" border="0"></a></td>
    <td width="77%" height='24' background='img/mtbg1.gif'  style='border-right: 1px solid #2FA1DB;'>վ��Ŀ¼��</td>
  </tr>
  <tr bgcolor='#EEFAFE'> 
    <td colspan='2' id='items1' align='center'> 
<?php 
if(empty($opendir)) $opendir=-1;
if($userChannel>0) $opendir=$userChannel;
$tu = new TypeUnit();
$tu->ListAllType($userChannel,$opendir);
$tu->Close();
?>
    </td>
  </tr>
</table>
</body>
</html>