<?php 
require_once(dirname(__FILE__)."/../config.php");
require_once(dirname(__FILE__)."/../../include/inc_typelink.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>������������ͼ</title>
<link href="../base.css" rel="stylesheet" type="text/css">
<script src="../main.js" language="javascript"></script>
</head>
<body background='../img/allbg.gif' leftmargin='8' topmargin='8'>
<table width="98%" border="0" cellpadding="3" cellspacing="1" bgcolor="#666666" align="center">
  <form name='form2' action='../content_list.php' method="get" target='stafrm'>
   <input type='hidden' name='nullfield' value='ok'>
  </form>
  <form name="form1" action="makeminiature_action.php" method="get" target='stafrm'>
  <tr> 
    <td height="20" colspan="2" background='../img/tbg.gif'>
    	<table width="98%" border="0" cellpadding="0" cellspacing="0">
        <tr> 
          <td height="18"><strong>��������ͼ��</strong>������������ѡ�<a href='mailto:smpluckly@gmail.com'><u>������Ы[beluckly]</u></a>����д��</td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td width="108" valign="top" bgcolor="#FFFFFF">ѡ����Ŀ��</td>
    <td width="377" valign="top" bgcolor="#FFFFFF">
   <?php
   $opall = 1;
   echo GetTypeidSel('form1','typeid','selbt1',0,0,'��ѡ��...','../');
   ?>
   </td>
  </tr>
  <tr>
    <td height="20" valign="top" bgcolor="#FFFFFF">��ʼID��</td>
    <td height="20" valign="top" bgcolor="#FFFFFF"><input name="startid" type="text" id="startid" size="10">
      ���ջ�0��ʾ��ͷ��ʼ��</td>
  </tr>
  <tr> 
    <td height="20" valign="top" bgcolor="#FFFFFF">����ID��</td>
    <td height="20" valign="top" bgcolor="#FFFFFF"><input name="endid" type="text" id="endid" size="10">
      ���ջ�0��ʾֱ������ID�� </td>
  </tr>
  <tr> 
    <td height="20" valign="top" bgcolor="#FFFFFF">�������ͣ�</td>
    <td height="20" valign="top" bgcolor="#FFFFFF"><input type=radio class=np name=isall id=isall value=1>ȫ����ȡ��һ��ͼƬ����
      <input type=radio class=np name=isall id=isall value=2 checked=1>�����ϴ���ͼ������</td>
  </tr>
  <tr>
    <td height="20" valign="top" bgcolor="#FFFFFF">������ͼ���ͣ�</td>
    <td height="20" valign="top" bgcolor="#FFFFFF"><input type=radio class=np name=maketype id=maketype value=1>Ť��������&nbsp;&nbsp;<input type=radio class=np name=maketype id=maketype value=2>����������&nbsp;&nbsp;<input type=radio class=np name=maketype id=maketype value=3>���ֲü���&nbsp;&nbsp;<input type=radio class=np name=maketype id=maketype value=4 checked="1">���������&nbsp;&nbsp;����ɫ��<input type="text" name="backcolor1" id="backcolor1" size=5 value="255">&nbsp;&nbsp;<input type="text" name="backcolor2" id="backcolor2" size=5 value="255">&nbsp;&nbsp;<input type="text" name="backcolor3" id="backcolor3" size=5 value="255"></td>
  </tr>
  <tr> 
    <td height="20" valign="top" bgcolor="#FFFFFF">����ͼ��͸ߣ�</td>
    <td height="20" valign="top" bgcolor="#FFFFFF">��<input name="imgwidth" type="text" id="imgwidth" size="10" value="240">
      �ߣ�<input name="imgheight" type="text" id="imgheight" size="10" value="180"> </td>
  </tr>
    <tr> 
      <td height="20" bgcolor="#FFFFFF">ÿҳ���ɣ�</td>
      <td height="20" bgcolor="#FFFFFF"> <input name="pagesize" type="text" id="pagesize" value="10" size="8">
        ���ļ�</td>
    </tr>
    <tr> 
      <td height="20" colspan="2" bgcolor="#FAFAF1" align="center">
      	<input name="b112" type="button" class="nbt" value="��ʼ��������ͼ" onClick="document.form1.submit();" style="width:100">
        &nbsp;
        <input type="button" name="b113" value="�鿴�����ĵ�" class="nbt" onClick="document.form2.submit();" style="width:100"> 
      </td>
    </tr>
  </form>
  <tr bgcolor="#E5F9FF"> 
    <td height="20" colspan="2"> <table width="100%">
        <tr> 
          <td width="74%">����״̬�� </td>
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
    <td colspan="2" id="mtd"> <div id='mdv' style='width:100%;height:100;'> 
        <iframe name="stafrm" frameborder="0" id="stafrm" width="100%" height="100%"></iframe>
      </div>
      <script language="JavaScript">
	  document.all.mdv.style.pixelHeight = screen.height - 360;
	  </script> </td>
  </tr>
</table>
</body>
</html>