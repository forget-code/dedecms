<?php 
require_once(dirname(__FILE__)."/config.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�㿨������</title>
<link href="base.css" rel="stylesheet" type="text/css">
</head>
<body background='img/allbg.gif' leftmargin='8' topmargin='8'>
<table width="98%" border="0" cellpadding="3" cellspacing="1" bgcolor="#98CAEF" align="center">
  <form action="member_card_make_action.php" name="form1" target="stafrm">
    <tr> 
      <td height="20" background='img/tbg.gif'><table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="30%"><strong><a href="co_main.php"><u>��Ա����</u></a> &gt; 
            �㿨�����򵼣�</strong> </td>
          <td align="right"><input type="button" name="ss1" value="�㿨��Ʒ����" style="width:90px;margin-right:6px" onClick="location='member_card_type.php';" class='nbt'>
              <input type="button" name="ss2" value="�㿨ʹ�ü�¼" style="width:90px" onClick="location='member_card.php';" class='nbt'>
          </td>
        </tr>
      </table></td>
    </tr>
    <tr> 
      <td bgcolor="#FFFFFF">
<table width="90%" border="0" cellpadding="2" cellspacing="2">
          <tr> 
            <td width="13%">�㿨���ͣ�</td>
            <td width="32%">
<select name='cardtype' style='width:120px'>
<?php 
$dsql = new DedeSql(false);
$dsql->SetQuery("Select * From #@__moneycard_type");
$dsql->Execute();
while($row=$dsql->GetArray()){
  echo "  <option value='{$row['tid']}'>{$row['pname']}</option>\r\n";
}
$dsql->Close();			
?>
</select>
			</td>
            <td width="14%">����������</td>
            <td width="41%">
			<input name="mnum" type="text" id="mnum"  style='width:120px' value="100">
			</td>
          </tr>
          <tr> 
            <td>�㿨ǰ׺��</td>
            <td> 
              <input name="snprefix" type="text" id="snprefix"  style='width:120px' value="SN"> 
            </td>
            <td>���볤�ȣ�</td>
            <td><input name="pwdlen" type="text" id="pwdlen2"  style='width:120px' value="4"> 
            </td>
          </tr>
          <tr> 
            <td>�������ͣ�</td>
            <td><input type="radio" name="ctype" value="1" class="np">
              ������ 
              <input name="ctype" type="radio" class="np" value="2" checked>
              ��д��ĸ</td>
            <td>����������</td>
            <td><input name="pwdgr" type="text" id="pwdlen3"  style='width:120px' value="3"> 
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr> 
      <td height="31" bgcolor="#F8FBFB" align="center">
	  <input type="submit" name="Submit" value="��ʼ���ɵ㿨"> 
      </td>
    </tr>
  </form>
  <tr bgcolor="#E5F9FF"> 
    <td height="20"> <table width="100%">
        <tr> 
          <td width="74%"><strong>�����</strong></td>
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
    <td id="mtd"> <div id='mdv' style='width:100%;height:100;'> 
        <iframe name="stafrm" frameborder="0" id="stafrm" width="100%" height="100%"></iframe>
      </div>
      <script language="JavaScript">
	  document.all.mdv.style.pixelHeight = screen.height - 420;
	  </script> </td>
  </tr>
</table>
</body>
</html>
