<?php 
require_once(dirname(__FILE__)."/config.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>���������滻</title>
<script language='javascript' src='main.js'></script>
<script language='javascript' src='../include/dedeajax2.js'></script>
<link href="base.css" rel="stylesheet" type="text/css">
<script language='javascript'>
	function ShowFields(){
		var exptable = $('exptable').options[$('exptable').selectedIndex].value;
		var queryUrl = "sys_data_replace_action.php?exptable="+exptable+"&action=getfields";
		var myajax = new DedeAjax($('fields'),true,true,'','x','...');
	    myajax.SendGet(queryUrl);
	}
	function CheckSubmit(){
	   if($('qfs1').checked && $('rpfield').value==""){
	      alert("��ѡ��Ĳ���Ϊ�ֹ�ָ���ֶΣ����㲢ûָ����");
		  return false;
	   }
	   if($('rpstring').value==""){
	      alert("��ûָ��Ҫ�滻���ַ�����");
		  return false;
	   }
	   return true;
	}
	function pf(v){
	   $('rpfield').value = v;
	}
	function ShowHideFromItem(){
	   if($('qfs1').checked){
	     $('datasel').style.display = 'block';
	   }else{
	     $('datasel').style.display = 'none';
	   }
	}
</script>
</head>
<body background='img/allbg.gif' leftmargin='8' topmargin='8'>
<table width="98%" border="0" cellpadding="3" cellspacing="1" bgcolor="#98CAEF" align="center">
  <form action="sys_data_replace_action.php" name="form1" method="post" target="stafrm" onSubmit="return CheckSubmit()">
  	<input type='hidden' name='action' value='apply'>
    <tr> 
      <td height="20" background='img/tbg.gif'><table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td width="30%">
            	<strong>&gt;���ݿ������滻��</strong> </td>
            <td>&nbsp;</td>
        </tr>
      </table>
      </td>
    </tr>
    <tr> 
      <td bgcolor="#FFFFFF">
<table width="100%" border="0" cellpadding="2" cellspacing="2">
          <tr bgcolor="#FFFFFF"> 
            <td colspan="2" style="line-height:180%"><img src="img/help.gif" width="16" height="16">�������������滻���ݿ���ĳ�ֶε����ݡ�</td>
          </tr>
          <tr> 
            <td width="15%" bgcolor="#EFFAFE">&nbsp;�ֶ�ѡ�</td>
            <td bgcolor="#EFFAFE"><input type="radio" name="quickfield" id="qfs1" onClick="ShowHideFromItem()" value="none" class="np" checked>
              �ֹ�ָ��Ҫ�滻���ֶ� 
              <input type="radio" name="quickfield" id="qfs2" onClick="ShowHideFromItem()" value="title" class="np">
              �ĵ����� 
              <input type="radio" name="quickfield" id="qfs3" onClick="ShowHideFromItem()" value="body" class="np">
              �������� </td>
          </tr>
          <tr id='datasel'> 
            <td width="15%" height="66">&nbsp;ѡ�����ݱ����ֶΣ�</td>
            <td> <table width="98%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
                  <td id="tables"> 
                    <?php 
	$dsql = new DedeSql(false);
	if(!$dsql->linkID){
		echo "<font color='red'>�������ݿ�ʧ�ܣ�</font><br>";
		echo $qbutton;
		exit();
	}
	$dsql->SetQuery("Show Tables");
  $dsql->Execute('t');
  if($dsql->GetError()!=""){
  	echo "<font color='red'>�Ҳ�������ָ�������ݿ⣡ $dbname</font><br>";
		echo $qbutton;
  }
  echo "<select name='exptable' id='exptable' size='10' style='width:60%' onchange='ShowFields()'>\r\n";
  while($row = $dsql->GetArray('t')){
	  echo "<option value='{$row[0]}'>{$row[0]}</option>\r\n";
  }
  echo "</select>\r\n";
	$dsql->Close();
				  ?>
                  </td>
                </tr>
                <tr> 
                  <td id='fields'></td>
                </tr>
                <tr> 
                  <td height="28"> Ҫ�滻���ֶΣ� 
                    <input name="rpfield" type="text" id="rpfield"></td>
                </tr>
              </table></td>
          </tr>
          <tr bgcolor="#EFFAFE"> 
            <td bgcolor="#EFFAFE">&nbsp;�滻��ʽ��</td>
            <td bgcolor="#EFFAFE"> <input name="rptype" type="radio" class="np" id="ot1" value="replace" checked>
              ��ͨ�滻 
              <input type="radio" name="rptype"  id="ot2" class="np" value="regex">
              ������ʽ �����ֶΣ�
              <input name="keyfield" type="text" id="keyfield" size="12">
              ������ģʽ����ָ����</td>
          </tr>
          <tr> 
            <td>&nbsp;���滻���ݣ�</td>
            <td><textarea name="rpstring" id="rpstring" style="width:60%;height:50px"></textarea></td>
          </tr>
          <tr> 
            <td>&nbsp;�滻Ϊ��</td>
            <td><textarea name="tostring" id="tostring" style="width:60%;height:50px"></textarea></td>
          </tr>
          <tr>
            <td height="29">&nbsp;�滻������</td>
            <td><input name="condition" type="text" id="condition" style="width:45%">
              (����ȫ�滻)</td>
          </tr>
          <tr> 
            <td height="29">&nbsp;��ȫȷ���룺</td>
            <td><table width="300"  border="0" cellspacing="0" cellpadding="0">
                <tr> 
                  <td width="90"><input type="text" name="validate" style="width:80;height:20"></td>
                  <td><img src='../include/vdimgck.php' width='50' height='20'></td>
                </tr>
              </table></td>
          </tr>
        </table>
      </td>
    </tr>
    <tr> 
      <td height="31" bgcolor="#F8FBFB" align="center">
	  <input type="submit" name="Submit" value="��ʼ�滻����" class="nbt"> 
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
	  document.all.mdv.style.pixelHeight = screen.height - 520;
	  </script> </td>
  </tr>
</table>
</body>
</html>
