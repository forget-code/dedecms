<?
require_once(dirname(__FILE__)."/config.php");
require_once(dirname(__FILE__)."/../include/inc_typelink.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>����HTML</title>
<link href="base.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" media="all" href="../include/calendar/calendar-win2k-1.css" title="win2k-1" />
<script type="text/javascript" src="../include/calendar/calendar.js"></script>
<script type="text/javascript" src="../include/calendar/calendar-cn.js"></script>
</head>
<body background='img/allbg.gif' leftmargin='8' topmargin='8'>
<table width="98%" border="0" cellpadding="3" cellspacing="1" bgcolor="#666666" align="center">
  <form name="form1" action="action_makehtml_list.php" method="get" target='stafrm'>
    <tr> 
      <td height="20" colspan="2" background='img/tbg.gif'> <table width="98%" border="0" cellpadding="0" cellspacing="0">
          <tr> 
            <td width="30%" height="18"><strong>������ĿHTML��</strong></td>
            <td width="70%" align="right"><a href="catalog_main.php"><u>��Ŀ����</u></a> 
            </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td width="108" valign="top" bgcolor="#FFFFFF">ѡ����Ŀ��</td>
      <td width="377" valign="top" bgcolor="#FFFFFF"> 
        <?
       if(empty($cid)) $cid="0";
       $tl = new TypeLink($cid);
       $typeOptions = $tl->GetOptionArray($cid,$cuserLogin->getUserChannel(),0,1);
       echo "<select name='typeid' style='width:300'>\r\n";
       if($cid=="0") echo "<option value='0' selected>����������Ŀ...</option>\r\n";
       echo $typeOptions;
       echo "</select>";
			 $tl->Close();
		?>
      </td>
    </tr>
    <tr> 
      <td height="20" valign="top" bgcolor="#FFFFFF">����ѡ�</td>
      <td height="20" valign="top" bgcolor="#FFFFFF"> <input name="uptype" type="radio" class="np" value="all" checked>
        �鵵�����ĵ� 
        <input name="uptype" type="radio" class="np" value="1">
        ���鵵ָ������֮����ĵ�</td>
    </tr>
    <tr> 
      <td height="20" valign="top" bgcolor="#FFFFFF">ָ�����ڣ�</td>
      <td height="20" valign="top" bgcolor="#FFFFFF"> 
        <?
		$dayst = GetMkTime("2006-1-2 0:0:0") - GetMkTime("2006-1-1 0:0:0");
		$nowtime = GetDateTimeMk(time() - ($dayst * 365));
		echo "<input name=\"starttime\" value=\"$nowtime\" type=\"text\" id=\"pubdate\" style=\"width:200\">";
		echo "<input name=\"selPubtime\" type=\"button\" id=\"selkeyword\" value=\"ѡ��\" onClick=\"showCalendar('pubdate', '%Y-%m-%d %H:%M:00', '24');\">";
	 ?>
      </td>
    </tr>
    <tr>
      <td height="20" valign="top" bgcolor="#FFFFFF">ÿ����󴴽�ҳ����</td>
      <td height="20" valign="top" bgcolor="#FFFFFF"><input name="maxpagesize" type="text" id="maxpagesize" value="100" size="10">
        ���ļ� </td>
    </tr>
    <tr> 
      <td height="20" valign="top" bgcolor="#FFFFFF">�Ƿ��������Ŀ��</td>
      <td height="20" valign="top" bgcolor="#FFFFFF">
	  <input name="upnext" type="radio" class="np" value="1" checked>
        �����Ӽ���Ŀ 
        <input type="radio" name="upnext" class="np" value="0">
        ��������ѡ��Ŀ </td>
    </tr>
    <tr> 
      <td height="20" colspan="2" bgcolor="#FAFAF1" align="center"> <input name="b112" type="button" class="np2" value="��ʼ����HTML" onClick="document.form1.submit();" style="width:100"> 
      </td>
    </tr>
  </form>
  <tr bgcolor="#E6F3CD"> 
    <td height="20" colspan="2"> <table width="100%">
        <tr> 
          <td width="74%">����״̬�� </td>
          <td width="26%" align="right"> <script language='javascript'>
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
