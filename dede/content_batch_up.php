<?php 
require_once(dirname(__FILE__)."/config.php");
require_once(dirname(__FILE__)."/../include/inc_typelink.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�ĵ���������</title>
<link href="base.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" media="all" href="../include/calendar/calendar-win2k-1.css" title="win2k-1" />
<script type="text/javascript" src="../include/calendar/calendar.js"></script>
<script type="text/javascript" src="../include/calendar/calendar-cn.js"></script>
<script src="main.js" language="javascript"></script>
<script language='javascript'>
	function ShowHideTime()
	{
		var selBox = document.getElementById('seltime');
		var obj = document.getElementById('seltimeField');
		if(selBox.checked) obj.style.display = "block";
		else  obj.style.display = "none";
	}
	function ShowHideMove()
	{
		var selBox = document.getElementById('moveradio');
		var obj = document.getElementById('moveField');
		if(selBox.checked) obj.style.display = "block";
		else  obj.style.display = "none";
	}
</script>
</head>
<body background='img/allbg.gif' leftmargin='8' topmargin='8'>
<table width="98%" border="0" cellpadding="3" cellspacing="1" bgcolor="#98CAEF" align="center">
  <form name="form1" action="content_batchup_action.php" target="stafrm">
    <input type="hidden" name="dopost" value="go">
    <tr> 
      <td height="20" colspan="2" background='img/tbg.gif'> <table width="98%" border="0" cellpadding="0" cellspacing="0">
          <tr> 
            <td width="30%" height="18"><strong>�ĵ���������</strong></td>
            <td width="70%" align="right">&nbsp;</td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td width="177" align="center" bgcolor="#FFFFFF">ѡ����Ŀ��</td>
      <td width="791" bgcolor="#FFFFFF"> 
        <?php 
        $opall = 1;
        echo GetTypeidSel('form1','typeid','selbt1',0);
        ?>
	  </td>
    </tr>
    <tr> 
      <td height="20" align="center" bgcolor="#FFFFFF">��ʼID��</td>
      <td height="20" bgcolor="#FFFFFF">��ʼ�� 
        <input name="startid" type="text" id="startid" size="10">
        ������ 
        <input name="endid" type="text" id="endid" size="10"></td>
    </tr>
    <tr> 
      <td height="20" align="center" bgcolor="#FFFFFF">��������ʱ�䣺</td>
      <td height="20" bgcolor="#FFFFFF"><table width="500" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td colspan="2"> <label> 
              <input name="seltime" type="checkbox" class="np" id="seltime" value="1" onClick="ShowHideTime()">
              ����ʱ��ɸѡ�����ƶ���ɾ���ĵ����ø�ѡ�</label></td>
          </tr>
          <tr id='seltimeField' style='display:none' height='20'> 
            <td width="250">��ʼ�� 
              <?php 
			$nowtime = GetDateTimeMk(mytime()-(24*3600*30));
			echo "<input name=\"starttime\" value=\"$nowtime\" type=\"text\" id=\"starttime\" style=\"width:150\">";
			echo "<input name=\"selstarttime\" type=\"button\" id=\"selkeyword\" value=\"ѡ��\" onClick=\"showCalendar('starttime', '%Y-%m-%d %H:%M:00', '24');\">";
			?>
            </td>
            <td width="250">������ 
              <?php 
			$nowtime = GetDateTimeMk(mytime());
			echo "<input name=\"endtime\" value=\"$nowtime\" type=\"text\" id=\"endtime\" style=\"width:150\">";
			echo "<input name=\"selendtime\" type=\"button\" id=\"selkeyword\" value=\"ѡ��\" onClick=\"showCalendar('endtime', '%Y-%m-%d %H:%M:00', '24');\">";
			?>
            </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="20" align="center" bgcolor="#FFFFFF">������</td>
      <td height="20" bgcolor="#FFFFFF"> <input name="action" type="radio" class="np" id="checkradio" onClick="ShowHideMove()" value="check" checked>
        ����ĵ� 
        <input name="action" type="radio" class="np" value="makehtml" id="makehtmlradio" onClick="ShowHideMove()">
        ����HTML 
        <input name="action" type="radio" class="np" value="move" id="moveradio" onClick="ShowHideMove()">
        �ƶ��ĵ� 
        <input name="action" type="radio" class="np" id="delradio" value="del" onClick="ShowHideMove()">
        ɾ���ĵ�</td>
    </tr>
    <tr height="20" bgcolor="#FFFFFF"> 
      <td height="20" align="center" bgcolor="#FFFFFF">�ƶ�ѡ�</td>
      <td height="20" bgcolor="#FFFFFF"> 
        <?php 
        $opall = 1;
        echo "<span id='moveField' style='display:none'>��λ�ã�";
		echo GetTypeidSel('form1','newtypeid','selbt3',0);
		echo "<br/>";
        echo "����ؼ��֣�<input id='movekeyword' type='text' name='keyword' value='' style='width:220;'></span>";
        ?>
      </td>
    </tr>
    <tr> 
      <td height="31" colspan="2" bgcolor="#F8FBFB" align="center"><input name="b112" type="button"  class='nbt' value="��ʼ����" onClick="document.form1.submit();" style="width:100"></td>
    </tr>
  </form>
  <tr bgcolor="#E5F9FF"> 
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
    <td colspan="2" id="mtd">
	<div id='mdv' style='width:100%;height:250;'> 
        <iframe name="stafrm" frameborder="0" id="stafrm" width="100%" height="100%"></iframe>
      </div>
	 </td>
  </tr>
  <form name="form2" action="content_batchup_action2.php" target="stafrm" method="post">
    <input type="hidden" name="dopost" value="go">
    <tr> 
      <td height="20" colspan="2" background='img/tbg.gif'> <table width="98%" border="0" cellpadding="0" cellspacing="0">
          <tr> 
            <td width="30%" height="18"><strong>�����ĵ�������</strong></td>
            <td width="70%" align="right">&nbsp;</td>
          </tr>
        </table></td>
    </tr>
    <tr height="20" bgcolor="#FFFFFF"> 
      <td height="20" colspan="2" align="center" bgcolor="#FFFFFF"> <input type='radio' value='delnulltitle' name='action' class='np'>
        ɾ���ձ�������� 
        <input type='radio' value='delnullbody' name='action' class='np'>
        ɾ������Ϊ�յ����� 
        <input type='radio' value='modddpic' name='action' class='np'>
        ������ͼ���� </td>
    </tr>
    <tr> 
      <td height="31" colspan="2" bgcolor="#F8FBFB" align="center"><input name="b112" type="button"  class='nbt' value="��ʼ����" onClick="document.form2.submit();" style="width:100"></td>
    </tr>
  </form>
</table>
</body>
</html>
