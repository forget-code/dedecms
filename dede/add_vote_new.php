<?
require("config.php");
?>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
<title>ͶƱ����</title>
<link href='base.css' rel='stylesheet' type='text/css'>
<script language="javascript">
     var i=1;
     function AddItem()
     { 
        i++;
		if(i>9)
		{
			alert("���ֻ����9��ѡ�");
			return;
		}
        document.all.voteitem.innerHTML+="<br>ѡ��"+i+"�� <input name='voteitem"+i+"' type='text' size='30'>";
     }
	function ResetItem()
    { 
        i = 1;
		document.all.voteitem.innerHTML="ѡ��1�� <input name='voteitem1' type='text' size='30'>";
    }
</script>

</head>
<body background='img/allbg.gif' leftmargin='8' topmargin='8'>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#666666">
  <tr>
    <td height="19" background="img/tbg.gif"><b>ͶƱ����</b>&gt;&gt;����ͶƱ&nbsp;&nbsp;[<a href="add_vote.php"><u>��������ͶƱ���ݼ�¼</u></a>]</td>
</tr>
<tr>
    <td height="200" bgcolor="#FFFFFF" valign="top">
	<form name="form1" method="post" action="add_voteok.php">
	    <table width="100%" border="0" cellspacing="4" cellpadding="4">
          <tr> 
            <td width="12%">ͶƱ���ƣ�</td>
            <td width="88%"> <input name="votename" type="text" id="votename">
              ����Ҫ����\ / : ? * &quot; &lt;&gt; | ���ţ� </td>
          </tr>
          <tr> 
            <td>ͶƱѡ�</td>
            <td><input type="button" value="����ͶƱѡ��" name="bbb" class="bt1" onClick="AddItem();">
              ��
              <input type="button" value="����ͶƱѡ��" name="bbb2" class="bt1" onClick="ResetItem();"></td>
          </tr>
          <tr> 
            <td colspan="2">
			<div id="voteitem">
			ѡ��1�� 
                <input name="voteitem1" type="text" id="voteitem1" size="30">
			 </div>
			 </td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td><input type="submit" name="Submit" value="����ͶƱ����"></td>
          </tr>
          <tr> 
            <td colspan="2">&nbsp;</td>
          </tr>
        </table>
	  </form>
	  </td>
</tr>
</table>
</body>
</html>