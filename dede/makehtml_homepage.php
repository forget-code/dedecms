<?
require_once(dirname(__FILE__)."/config.php");
$dsql = new DedeSql(false);
$row  = $dsql->GetOne("Select * From #@__homepageset");
$dsql->Close();
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>��ҳ������</title>
<link href="base.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" media="all" href="../include/calendar/calendar-win2k-1.css" title="win2k-1" />
<script type="text/javascript" src="../include/calendar/calendar.js"></script>
<script type="text/javascript" src="../include/calendar/calendar-cn.js"></script>
<script language="javascript">
function SelectTemplets(fname)
{
   var posLeft = window.event.clientY-200;
   var posTop = window.event.clientX-300;
   window.open("../include/dialog/select_templets.php?f="+fname, "poptempWin", "scrollbars=yes,resizable=yes,statebar=no,width=600,height=400,left="+posLeft+", top="+posTop);
}
</script>
</head>
<body background='img/allbg.gif' leftmargin='8' topmargin='8'>
<table width="98%" border="0" cellpadding="3" cellspacing="1" bgcolor="#666666" align="center">
  <form name="form1" action="action_makehtml_homepage.php" target="stafrm" method="post">
  <input type="hidden" name="dopost" value="make">
    <tr> 
      <td height="20" colspan="2" background='img/tbg.gif'>
	  <table width="98%" border="0" cellpadding="0" cellspacing="0">
          <tr> 
            <td width="30%" height="18"><strong>��ҳ�����򵼣�</strong></td>
            <td width="70%" align="right">&nbsp;</td>
          </tr>
        </table>
		</td>
    </tr>
    <tr> 
      <td width="177" valign="top" bgcolor="#FFFFFF">ѡ����ҳģ�壺</td>
      <td width="791" valign="top" bgcolor="#FFFFFF">
	    <input name="templet" type="text" id="templet" style="width:300" value="<?=$row['templet']?>"> 
        <input type="button" name="set4" value="���..." style="width:60" onClick="SelectTemplets('form1.templet');"> 
      </td>
    </tr>
    <tr> 
      <td height="20" colspan="2" valign="top" bgcolor="#FFFFFF">Ĭ�ϵ�����£����ɵ���ҳ�ļ�����CMS�İ�װĿ¼��������CMS���ǰ�װ����վ��Ŀ¼�ģ��������ҳ��������վ��Ŀ¼����ô�������·������ʾ����ҳλ�á����������CMS��װ�� 
        http://www.abc.com/dedecms/ Ŀ¼���������ɵ���ҳΪ http://www.abc.com/index.html����ô��ҳλ�þ�Ӧ���ã� 
        ��../index.html����</td>
    </tr>
    <tr> 
      <td height="20" valign="top" bgcolor="#FFFFFF">��ҳλ�ã�</td>
      <td height="20" valign="top" bgcolor="#FFFFFF"><input name="position" type="text" id="position" value="<?=$row['position']?>" size="30"> 
      </td>
    </tr>
    <tr> 
      <td height="20" valign="top" bgcolor="#FFFFFF">���ѡ�</td>
      <td height="20" valign="top" bgcolor="#FFFFFF">
	  <input name="saveset" type="radio" value="0" class="np">
       �����浱ǰѡ�� 
      <input name="saveset" type="radio" class="np" value="1" checked>
      ���浱ǰѡ��
	</td>
    </tr>
    <tr> 
      <td height="31" colspan="2" bgcolor="#FAFAF1" align="center">
	    <input name="view" type="button" id="view" value="Ԥ����ҳ" onclick="window.open('action_makehtml_homepage.php?dopost=view&templet='+form1.templet.value);">
        ��
<input type="submit" name="Submit" value="������ҳHTML"> 
      </td>
    </tr>
  </form>
  <tr bgcolor="#E6F3CD"> 
    <td height="20" colspan="2"><table width="100%">
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
      </table> </td>
  </tr>
  <tr bgcolor="#FFFFFF"> 
    <td colspan="2" id="mtd">
	<div id='mdv' style='width:100%;height:100;'> 
        <iframe name="stafrm" frameborder="0" id="stafrm" width="100%" height="100%">
        <script language="JavaScript">
	  document.all.mdv.style.pixelHeight = screen.height - 360;
	  </script>
        </iframe>
      </div>
	  </td>
  </tr>
</table>
</body>
</html>
