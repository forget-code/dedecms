<?
require("config.php");
require("inc_typelink.php");
$conn = connectMySql();
?>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
<title>���������</title>
<link href='base.css' rel='stylesheet' type='text/css'>
<script>
function checkSubmit()
{
	if(document.form1.typeid.value=="0")
{
   document.form1.typeid.focus();
   alert("������ѡ��");
   return false;
}
if(document.form1.title.value=="")
{
   document.form1.title.focus();
   alert("������Ʊ����趨��");
   return false;
}
if(document.form1.msg.value=="")
{
   document.form1.msg.focus();
   alert("������������趨��");
   return false;
}
}
</script>
</head>
<body background='img/allbg.gif' leftmargin='8' topmargin='8'>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#666666">
 <form action="add_news_softok.php" method="post" enctype="multipart/form-data" name="form1" onSubmit="return checkSubmit();">
  <tr>
    <td height="19" background="img/tbg.gif"><strong>&nbsp;���������&nbsp; </strong><? if($cuserLogin->getUserRank()>4) echo("[<a href=\"list_news.php\"><u>��������</u></a>]");?>&nbsp;[<a href="list_news_member.php"><u>������</u>]</a></td>
</tr>
<tr>
    <td height="127" align="center" bgcolor="#FFFFFF"> 
      <table width="98%" border="0" cellspacing="2" cellpadding="0">
          <tr> 
            <td height="30" colspan="2">���������������Ϊ�˼�������ݵķ������̣�ģ����� ��ģ��Ŀ¼/ģ������/3�� 
              ���ļ����У�ֻ�ж���Ƶ������Ϊ��������ء������ڴ����з������£������bodyģ���ڡ�ģ��Ŀ¼/ģ��������/3/��.htm���С� 
            </td>
          </tr>
          <tr> 
            <td width="19%" height="30">���*</td>
            <td width="81%"><select name="typeid">
                <?
						if(!empty($typeid)) echo "<option value='$typeid' selected>$typename</option>\r\n";
						else echo "<option value='0' selected>--��ѡ��--</option>\r\n";
                    	$ut = new TypeLink();
						if($cuserLogin->getUserChannel()<=0)
							$ut->GetOptionArray(0,0,3);
						else
							$ut->GetOptionArray(0,$cuserLogin->getUserChannel(),3);
					?>
              </select> &nbsp;</td>
          </tr>
          <tr> 
            <td height="20">������ƣ�*</td>
            <td> <input name="title" type="text" id="title" size="20">
              ��������� 
              <input name="source" type="text" id="source2" value="-" size="25"></td>
          </tr>
          <tr> 
            <td height="20">���ʱ�䣺*</td>
            <td><input name="stime" type="text" id="softsize5" value="<?=strftime("%Y-%m-%d")?>" size="15"> &nbsp;����ȼ��� 
              <select name="softrank" id="softrank">
                <option value="��">һ�Ǽ�</option>
                <option value="���">���Ǽ�</option>
                <option value="����" selected>���Ǽ�</option>
                <option value="�����">���Ǽ�</option>
                <option value="������">���Ǽ�</option>
              </select> </td>
          </tr>
          <tr> 
            <td height="20">������ԣ�</td>
            <td><input name="language" type="text" id="language3" value="��������" size="15"> 
              &nbsp;�����С�� 
              <input name="softsize" type="text" id="softsize4" value="1000 K" size="15"></td>
          </tr>
          <tr> 
            <td height="20">���ƽ̨��</td>
            <td><select name="opensystem" id="opensystem">
                <option value="windows98/NT/2000/XP/2003" selected>windows98/NT/2000/XP/2003</option>
                <option value="Linux">Linux</option>
                <option value="FreeBSD/Unix">FreeBSD/Unix</option>
                <option value="����ƽ̨">����ƽ̨</option>
              </select> &nbsp;��Ȩ��ʽ�� 
              <select name="softtype" id="softtype">
                <option value="����/�������">����/�������</option>
                <option value="���/��Դ���" selected>���/��Դ���</option>
                <option value="�ƽ�/�������">�ƽ�/�������</option>
              </select></td>
          </tr>
          <tr> 
            <td height="50">���������*<br>
              (200������) </td>
            <td><textarea name="msg" cols="52" rows="3" id="msg"></textarea></td>
          </tr>
          <tr> 
            <td height="50">������ܣ�*<br>
              (20K���ڣ���֧��HTML)</td>
            <td><textarea name="body" cols="52" rows="5" id="body"></textarea></td>
          </tr>
          <tr> 
            <td height="22">����ͼƬ(200*200)��</td>
            <td><input name="litpic" type="file" id="litpic" size="40"></td>
          </tr>
          <tr> 
            <td height="22">�ϴ������</td>
            <td><input name="uploadsoft" type="file" id="uploadsoft" size="40"></td>
          </tr>
          <tr> 
            <td height="22">���ص�ַһ��</td>
            <td><input name="addr1" type="text" id="addr1" value="http://" size="40"></td>
          </tr>
          <tr> 
            <td height="22">���ص�ַ����</td>
            <td><input name="addr2" type="text" id="addr2" value="http://" size="40"></td>
          </tr>
          <tr> 
            <td height="22">���ص�ַ����</td>
            <td><input name="addr3" type="text" id="addr3" value="http://" size="40"></td>
          </tr>
          <tr> 
            <td height="22">���ص�ַ�ģ�</td>
            <td><input name="addr4" type="text" id="addr4" value="http://" size="40"></td>
          </tr>
          <tr> 
            <td height="22">���ص�ַ�壺</td>
            <td><input name="addr5" type="text" id="addr5" value="http://" size="40"></td>
          </tr>
          <tr> 
            <td height="38">&nbsp;</td>
            <td><input type="submit" name="Submit" value="�ύ���"> </td>
          </tr>
          <tr> 
            <td colspan="2" bgcolor="#F1FAF2">&nbsp;</td>
          </tr>
        </table> </td>
</tr>
</form>
</table>
</body>
</html>