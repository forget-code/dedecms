<?php 
require(dirname(__FILE__)."/config.php");
CheckPurview('plus_ͶƱģ��');
if(empty($dopost)) $dopost = "";
//////////////////////////////////////////
if($dopost=="save")
{
	//$ismore,$votename
	$starttime = GetMkTime($starttime);
	$endtime = GetMkTime($endtime);
	$voteitems = "";
	$j=0;
	for($i=1;$i<=15;$i++)
	{
		if(!empty(${"voteitem".$i})){
			$j++;
			$voteitems .= "<v:note id=\\'$j\\' count=\\'0\\'>".${"voteitem".$i}."</v:note>\r\n";
		}
	}
	$dsql = new DedeSql(false);
	$inQuery = "
	insert into #@__vote(votename,starttime,endtime,totalcount,ismore,votenote) 
	Values('$votename','$starttime','$endtime','0','$ismore','$voteitems');
	";
	$dsql->SetQuery($inQuery);
	if(!$dsql->ExecuteNoneQuery())
	{
		$dsql->Close();
		ShowMsg("����ͶƱʧ�ܣ����������Ƿ�Ƿ���","-1");
		exit();
	}
	$dsql->Close();
	ShowMsg("�ɹ�����һ��ͶƱ��","vote_main.php");
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
<title>����ͶƱ</title>
<link href='base.css' rel='stylesheet' type='text/css'>
<script language="javascript">
var i=1;
function AddItem()
{ 
  i++;
  if(i>15){
		alert("���ֻ����15��ѡ�");
		return;
  }
  var obj = document.getElementById("voteitem");
  obj.innerHTML+="<br/>ѡ��"+i+"�� <input name='voteitem"+i+"' type='text' size='30'>";
}
function ResetItem()
{ 
  i = 1;
	var obj = document.getElementById("voteitem");
	obj.innerHTML="ѡ��1�� <input name='voteitem1' type='text' size='30'>";
}
function checkSubmit()
{
	if(document.form1.votename.value=="")
	{
		alert("ͶƱ���Ʋ���Ϊ�գ�");
		document.form1.votename.focus();
		return false;
	}
}
</script>
</head>
<body background='img/allbg.gif' leftmargin='8' topmargin='8'>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#98CAEF">
  <tr>
    <td height="19" background="img/tbg.gif"><b>ͶƱ����</b>&gt;&gt;����ͶƱ&nbsp;&nbsp;[<a href="vote_main.php"><u>��������ͶƱ���ݼ�¼</u></a>]</td>
</tr>
<tr>
    <td height="200" bgcolor="#FFFFFF" valign="top">
	<table width="100%" border="0" cellspacing="4" cellpadding="4">
        <form name="form1" method="post" action="vote_add.php" onSubmit="return checkSubmit()">
		<input type='hidden' name='dopost' value='save'>
		<tr> 
          <td width="15%" align="center">ͶƱ���ƣ�</td>
          <td width="85%"> <input name="votename" type="text" id="votename"> </td>
        </tr>
        <tr> 
          <td align="center">��ʼʱ�䣺</td>
          <td><input name="starttime" type="text" id="starttime" value="<?php echo $startDay?>"></td>
        </tr>
        <tr> 
          <td align="center">����ʱ�䣺</td>
          <td><input name="endtime" type="text" id="endtime" value="<?php echo $endDay?>"></td>
        </tr>
        <tr> 
          <td align="center">�Ƿ��ѡ��</td>
          <td> <input name="ismore" type="radio" class="np" value="0" checked>
            ��ѡ �� 
            <input type="radio" name="ismore" class="np" value="1">
            ��ѡ </td>
        </tr>
        <tr>
          <td align="center">Ͷ Ʊ �</td>
          <td>
          	<input type="button" value="����ͶƱѡ��" name="bbb"  onClick="AddItem();" class='nbt'>
            �� 
            <input type="button" value="����ͶƱѡ��" name="bbb2" onClick="ResetItem();" class='nbt'>
          </td>
        </tr>
        <tr> 
          <td></td>
          <td>
		  <div id="voteitem">
			ѡ��1�� 
                <input name="voteitem1" type="text" id="voteitem1" size="30">
		  </div>
		  </td>
        </tr>
        <tr> 
          <td height="47">&nbsp;</td>
          <td><input type="submit" name="Submit" value="����ͶƱ����"></td>
        </tr>
        <tr> 
          <td colspan="2">&nbsp;</td>
        </tr>
		</form>
      </table>
	 </td>
</tr>
</table>
</body>
</html>