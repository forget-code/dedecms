<?php 
require_once(dirname(__FILE__)."/config.php");
require_once(dirname(__FILE__)."/../include/pub_collection.php");
if($nid=="") 
{
	ShowMsg("������Ч!","-1");	
	exit();
}
$co = new DedeCollection();
$co->Init();
$co->LoadFromDB($nid);
$dsql = new DedeSql(false);
$dsql->SetSql("Select count(aid) as dd From #@__courl where nid='$nid'");
$dsql->Execute();
$row = $dsql->GetObject();
$dd = $row->dd;
$dsql->Close();
if($dd==0)
{
	$unum = "û�м�¼�����û�вɼ�������ڵ㣡";
}
else
{
	$unum = "���� $dd ����ʷ������ַ��<a href='javascript:SubmitNew();'>[<u>����������ַ�����ɼ�</u>]</a>";
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�ɼ��ڵ�</title>
<script language='javascript'>
	function SubmitNew()
	{
		document.form1.totalnum.value = "0";
		document.form1.submit();
	}
</script>
<link href="base.css" rel="stylesheet" type="text/css">
</head>
<body background='img/allbg.gif' leftmargin='8' topmargin='8'>
<table width="98%" border="0" cellpadding="3" cellspacing="1" bgcolor="#98CAEF" align="center">
  <tr> 
      <td height="20" colspan="2" background='img/tbg.gif'>
      	<table width="98%" border="0" cellpadding="0" cellspacing="0">
         <form name='form2' action='co_url.php' target='stafrm'>
         	<input type='hidden' name='small' value='1'>
         	<input type='hidden' name='nid' value='<?php echo $nid?>'>
         	</form>
          <tr> 
            <td width="30%" height="18"><strong>�ɼ�ָ���ڵ㣺</strong></td>
            <td width="70%" align="right">
            	<input type="button" name="b11" value="�鿴������"  class='nbt' onClick="document.form2.submit();" style="width:90"> 
              <input type="button" name="b12" value="�ɼ��ڵ����"  class='nbt' style="width:90" onClick="location.href='co_main.php';">
              <input type="button" name="b13" value="��������"  class='nbt' style="width:90" onClick="location.href='co_export.php?nid=<?php echo $nid?>';">
              </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td width="108" valign="top" bgcolor="#FFFFFF">�ڵ����ƣ�</td>
      <td width="377" valign="top" bgcolor="#FFFFFF"> 
        <?php echo $co->Item["name"]?>
      </td>
    </tr>
    <tr> 
      <td height="20" valign="top" bgcolor="#FFFFFF">������ַ����</td>
      <td height="20" valign="top" bgcolor="#FFFFFF"> 
        <?php echo $unum?>
      </td>
    </tr>
    <form name="form1" action="co_getsource_url_action.php" method="get" target='stafrm'>
    <input type='hidden' name='nid' value='<?php echo $nid?>'>
    <input type='hidden' name='totalnum' value='<?php echo $dd?>'>
    <input type='hidden' name='startdd' value='0'>
    <tr> 
      <td height="20" bgcolor="#FFFFFF">ÿҳ�ɼ���</td>
      <td height="20" bgcolor="#FFFFFF">
      	<input name="pagesize" type="text" id="pagesize" value="5" size="3">
        �����߳����� 
        <input name="threadnum" type="text" id="threadnum" value="1" size="3">
        ���ʱ�䣺 
        <input name="sptime" type="text" id="sptime" value="0" size="3">
        �루��ˢ�µ�վ�������ã�</td>
    </tr>
    <tr> 
      <td height="20" bgcolor="#FFFFFF">����ѡ�</td>
      <td height="20" bgcolor="#FFFFFF">
      	<input name="islisten" type="radio" class="np" value="0" checked>
        �����������ص���ַ
        <input name="islisten" type="radio" class="np" value="-1">
        ������δ��������
      	<input name="islisten" type="radio" class="np" value="1">
      	����������������
      	</td>
    </tr>
    <tr> 
      <td height="20" colspan="2" bgcolor="#F8FBFB" align="center">
      	<input name="b112" type="button"  class='nbt' value="��ʼ�ɼ���ҳ" onClick="document.form1.submit();" style="width:100">��
      	<input type="button" name="b113" value="�鿴������ַ"  class='nbt' onClick="document.form2.submit();" style="width:100">
      </td>
    </tr>
  </form>
    <tr bgcolor="#E5F9FF"> 
      <td height="20" colspan="2">
<table width="100%">
          <tr> 
            <td width="74%">�ڵ��������ַ�� </td>
            <td width="26%" align="right">
            	<script language='javascript'>
            	function ResizeDiv(obj,ty)
            	{
            		if(ty=="+") document.all[obj].style.pixelHeight += 50;
            		else if(document.all[obj].style.pixelHeight>80) document.all[obj].style.pixelHeight = document.all[obj].style.pixelHeight - 50;
            	}
            	</script>
            	[<a href='#' onClick="ResizeDiv('mdv','+');">����</a>] [<a href='#' onClick="ResizeDiv('mdv','-');">��С</a>]
            	</td>
          </tr>
        </table></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td colspan="2" id="mtd">
	  <div id='mdv' style='width:100%;height:100;'>
	  <iframe name="stafrm" frameborder="0" id="stafrm" width="100%" height="100%"<?php if($dd>0) echo " src=co_url.php?nid=$nid&small=1";?>></iframe>
	  </div>
	  <script language="JavaScript">
	  document.all.mdv.style.pixelHeight = screen.height - 360;
	  </script>
	  </td>
    </tr>
</table>
</body>
</html>
<?php 
$co->Close();
?>