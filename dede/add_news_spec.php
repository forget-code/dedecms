<?
require("config.php");
require("inc_typelink.php");
$conn = connectMySql();
?>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
<title>ר�ⴴ����</title>
<link href='base.css' rel='stylesheet' type='text/css'>
<script>
var popUpWin=0;
function popUpWindow(URLStr, left, top, width, height)
{
	window.open(URLStr, 'popUpWin', 'scrollbars=yes,resizable=yes,statebar=yes,width='+width+',height='+(screen.height-100)+',left='+left+', top='+top+',screenX='+left+',screenY='+top+'');
}
function checkSubmit()
{
	if(document.form1.typeid.value=="0")
{
   document.form1.typeid.focus();
   alert("������ѡ��");
   return false;
}
if(document.form1.spectitle.value=="")
{
   document.form1.spectitle.focus();
   alert("ר����������д��");
   return false;
}
if(document.form1.specimg.value=="")
{
   document.form1.specimg.focus();
   alert("ר��ͼƬ�����趨��");
   return false;
}
if(document.form1.imgtitle.value=="")
{
   document.form1.imgtitle.focus();
   alert("ר��ͼƬ��������趨��");
   return false;
}
if(document.form1.imglink.value=="")
{
   document.form1.imglink.focus();
   alert("ר��ͼƬ���ӱ����趨��");
   return false;
}
if(document.form1.specmsg.value=="")
{
   document.form1.specmsg.focus();
   alert("ר��������趨��");
   return false;
}
if(document.form1.specartid.value=="")
{
   document.form1.specartid.focus();
   alert("ר�������б����ѡ��");
   return false;
}
}
</script>
</head>
<body background='img/allbg.gif' leftmargin='8' topmargin='8'>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#666666">
 <form name="form1" action="add_news_specok.php" method="post" onSubmit="return checkSubmit();">
  <tr>
    <td height="19" background="img/tbg.gif"><strong>&nbsp;ר�ⴴ����&nbsp; </strong>[<a href="list_news_spec.php"><u>�������е�ר��</u></a>]</td>
</tr>
<tr>
    <td height="127" align="center" bgcolor="#FFFFFF"> 
      <table width="98%" border="0" cellspacing="2" cellpadding="0">
        <tr>
          <td height="30"><strong>���</strong></td>
          <td><select name="typeid">
                     <?
						if(!empty($typeid)) echo "<option value='$typeid' selected>$typename</option>\r\n";
						else echo "<option value='0' selected>--��ѡ��--</option>\r\n";
                    	$ut = new TypeLink();
						if($cuserLogin->getUserChannel()<=0)
							$ut->GetOptionArray(0,0,1);
						else
							$ut->GetOptionArray(0,$cuserLogin->getUserChannel(),1);
					?>
					</select> (����ѡ��һ�����������)</td>
        </tr>
        <tr> 
          <td height="30"><strong>���⣺</strong></td>
          <td> <input name="spectitle" type="text" id="spectitle" size="40"> </td>
        </tr>
        <tr> 
          <td height="30" colspan="2" bgcolor="#F7F9F8"><strong>����ͼƬ�� 
            <input name="b1" type="button" id="b1" onClick="popUpWindow('list_news_picforspec.php', 50, 0,600,300)" value="�����е�ͼƬ������ѡȡ" style="height:20;width:160">
            </strong></td>
        </tr>
        <tr> 
          <td>ר��ͼƬ��</td>
          <td><input name="specimg" type="text" id="specimg" size="40"> &nbsp;(��Ѵ�СΪW150 
            * H120����)</td>
        </tr>
        <tr> 
          <td>ͼƬ���⣺</td>
          <td><input name="imgtitle" type="text" id="imgtitle" size="40"></td>
        </tr>
        <tr> 
          <td>ͼƬ���ӣ�</td>
          <td><input name="imglink" type="text" id="specimg32" size="40"></td>
        </tr>
        <tr> 
          <td colspan="2" bgcolor="#F7F9F8"><strong>��飺</strong>(����ר����ܣ�250����������)</td>
        </tr>
        <tr align="center"> 
          <td height="80" colspan="2"> <textarea name="specmsg" cols="60" rows="3" id="specmsg"></textarea> 
          </td>
        </tr>
        <tr> 
          <td height="30" colspan="2" bgcolor="#F7F9F8"><strong>ר�������б�</strong>�����á�ID1��ID2..����ʽ������˴��б��� 
            <input name="b2" type="button" id="b2" value="ѡȡ������" style="height:20;width:80" onClick="popUpWindow('list_news_forspec.php?qtype=specartid', 50, 0,600,300)"> 
            &nbsp;(�����Ǳ����)</td>
        </tr>
        <tr align="center"> 
          <td colspan="2"> <textarea name="specartid" cols="60" rows="3" id="specartid"><?if(isset($artids)) echo str_replace("`",",",$artids);?></textarea> 
          </td>
        </tr>
        <tr> 
          <td height="30" colspan="2" bgcolor="#F7F9F8"><strong>������£�</strong>�����á�ID1��ID2..����ʽ������˴��б��� 
            <input name="b3" type="button" id="b3" value="ѡȡ������" style="height:20;width:80" onClick="popUpWindow('list_news_forspec.php?qtype=speclikeid', 50, 0,600,300)"></td>
        </tr>
        <tr align="center"> 
          <td colspan="2"> <textarea name="speclikeid" cols="60" rows="3" id="speclikeid"></textarea> 
          </td>
        </tr>
        <tr> 
          <td height="38">&nbsp;</td>
          <td><input type="submit" name="Submit" value="�ύר��"> &nbsp;</td>
        </tr>
        <tr> 
          <td width="19%">&nbsp;</td>
          <td width="81%">&nbsp;</td>
        </tr>
      </table> </td>
</tr>
</form>
</table>
</body>
</html>