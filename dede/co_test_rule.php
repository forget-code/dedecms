<?
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
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>���Խڵ�</title>
<link href="base.css" rel="stylesheet" type="text/css">
</head>
<body background='img/allbg.gif' leftmargin='8' topmargin='8'>
<table width="98%" border="0" cellpadding="3" cellspacing="1" bgcolor="#666666" align="center">
  <tr> 
    <td height="20" background='img/tbg.gif'> <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr> 
          <td width="30%" height="18"><strong>���Խڵ㣺</strong></td>
          <td width="70%" align="right">&nbsp;<input type="button" name="b11" value="���زɼ��ڵ����ҳ" class="np2" style="width:160" onClick="location.href='co_main.php';"></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td height="94" bgcolor="#FFFFFF" align="center">
    	<table width="98%" border="0">
        <tr bgcolor="#F9FCF3"> 
          <td width="13%" height="24" align="center"><b>�ڵ����ƣ�</b></td>
          <td width="87%">&nbsp;<? echo($co->Item["name"]); ?></td>
        </tr>
        <tr> 
          <td height="24" align="center">�б������Ϣ��</td>
          <td>&nbsp;</td>
        </tr>
        <tr> 
          <td height="24" colspan="2">
 <textarea name="r1" id="r1" style="width:100%;height:250"><? $turl = $co->TestList();?></textarea> 
          </td>
        </tr>
        <tr> 
          <td height="24" align="center">��ҳ������ԣ�</td>
          <td>(Dedecms��ʱ�������ֶ�һ�����������ͣ�����㿴��sortrank��pubdate��senddate�����������������������)</td>
        </tr>
        <tr> 
          <td height="24" colspan="2" align="center">
         <textarea name="r2" id="r2" style="width:100%;height:250">������ַ: <? echo "$turl \r\n"; $co->TestArt($turl); ?></textarea>
		  </td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td height="28" bgcolor="#FAFAF1">&nbsp;</td>
  </tr>
</table>
</body>
</html>
<?
$co->Close();
?>