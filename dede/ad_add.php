<?php 
require(dirname(__FILE__)."/config.php");
CheckPurview('plus_������');
require_once(dirname(__FILE__)."/../include/inc_typelink.php");
if(empty($dopost)) $dopost = "";
//////////////////////////////////////////
if($dopost=="save")
{
	//timeset tagname typeid normbody expbody
	$tagname = trim($tagname);
	$dsql = new DedeSql(false);
	$row = $dsql->GetOne("Select typeid From #@__myad where typeid='$typeid' And tagname like '$tagname'");
	if(is_array($row)){
		$dsql->Close();
		ShowMsg("����ͬ��Ŀ���Ѿ�����ͬ���ı�ǣ�","-1");
		exit();
	}
	$starttime = GetMkTime($starttime);
	$endtime = GetMkTime($endtime);
	$inQuery = "
	 Insert Into #@__myad(typeid,tagname,adname,timeset,starttime,endtime,normbody,expbody)
	 Values('$typeid','$tagname','$adname','$timeset','$starttime','$endtime','$normbody','$expbody');
	";
	$dsql->SetQuery($inQuery);
	$dsql->ExecuteNoneQuery();
	$dsql->Close();
	ShowMsg("�ɹ�����һ����棡","ad_main.php");
	exit();
}
$startDay = mytime();
$endDay = AddDay($startDay,30);
$startDay = GetDateTimeMk($startDay);
$endDay = GetDateTimeMk($endDay);
?>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
<title>���ӹ��</title>
<link href='base.css' rel='stylesheet' type='text/css'>
<script language="javascript">
function checkSubmit()
{
	if(document.form1.tagname.value=="")
	{
		alert("����ʶ����Ϊ�գ�");
		document.form1.tagname.focus();
		return false;
	}
}
</script>
</head>
<body background='img/allbg.gif' leftmargin='8' topmargin='8'>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#98CAEF">
<tr>
    <td height="19" background="img/tbg.gif"><b><a href="ad_main.php"><u>������</u></a></b>&gt;&gt;���ӹ��λ��</td>
</tr>
<tr>
    <td height="200" bgcolor="#FFFFFF" valign="top">
	<table width="100%" border="0" cellspacing="4" cellpadding="4">
        <form action="ad_add.php" method="post" name="form1" onSubmit="return checkSubmit()">
          <input type='hidden' name='dopost' value='save'>
          <tr> 
            <td height="25" colspan="3">������ĵ��÷�����{dede:myad name='���λ��ʶ'/} </td>
          </tr>
          <tr> 
            <td height="25" align="center">���λ��ʶ��</td>
            <td colspan="2"><input name="tagname" type="text" id="tagname">
              ��ʹ��Ӣ�Ļ����ֱ�ʾ�ļ���ʶ��</td>
          </tr>
          <tr> 
            <td width="15%" height="25" align="center">���Ͷ�ŷ�Χ��</td>
            <td colspan="2"> 
              <?php 
           	$tl = new TypeLink(0);
           	$typeOptions = $tl->GetOptionArray(0,0,0);
            echo "<select name='typeid' style='width:300'>\r\n";
            echo "<option value='0' selected>Ͷ����û��ͬ����ʶ��������Ŀ</option>\r\n";
            echo $typeOptions;
            echo "</select>";
			$tl->Close();
			?>
              <br>
              ���������ѡ��Ŀ�Ҳ���ָ����ʶ�Ĺ�����ݣ�ϵͳ���Զ���������Ŀ��</td>
          </tr>
          <tr> 
            <td height="25" align="center">���λ���ƣ�</td>
            <td colspan="2"><input name="adname" type="text" id="adname" size="30"></td>
          </tr>
          <tr> 
            <td height="25" align="center">ʱ�����ƣ�</td>
            <td colspan="2">
            	<input name="timeset" type="radio" class="np" value="0" checked>
              �������� 
              <input type="radio" name="timeset" class="np" value="1">
              ������ʱ������Ч
            </td>
          </tr>
          <tr> 
            <td height="25" align="center">��ʼʱ�䣺</td>
            <td colspan="2"><input name="starttime" type="text" id="starttime" value="<?php echo $startDay?>"></td>
          </tr>
          <tr> 
            <td height="25" align="center">����ʱ�䣺</td>
            <td colspan="2"><input name="endtime" type="text" id="endtime" value="<?php echo $endDay?>"></td>
          </tr>
          <tr> 
            <td height="80" align="center">������ʾ���ݣ�</td>
            <td width="76%"> 
             <textarea name="normbody" id="normbody" style="width:80%;height:100"></textarea>
            </td>
            <td width="9%">&nbsp;</td>
          </tr>
          <tr> 
            <td height="80" align="center">������ʾ���ݣ�</td>
            <td> 
             <textarea name="expbody" id="expbody" style="width:80%;height:100"></textarea>
            </td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td height="53" align="center">&nbsp;</td>
            <td colspan="2"><input name="imageField" type="image" src="img/button_ok.gif" width="60" height="22" border="0"></td>
          </tr>
        </form>
      </table>
	 </td>
</tr>
</table>
</body>
</html> 
"