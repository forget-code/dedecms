<?
require("config.php");
$conn = connectMySql();
?>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
<title>�����뻹ԭ</title>
<link href='base.css' rel='stylesheet' type='text/css'>
<script language="javascript">
function selAll()
{
	for(i=0;i<document.formbak2.files.length;i++)
	{
		document.formbak2.files[i].checked=true;
	}
}
function selNone()
{
	for(i=0;i<document.formbak2.files.length;i++)
	{
		document.formbak2.files[i].checked=false;
	}
}
function GetSubmit()
{
	for(i=0;i<document.formbak2.files.length;i++)
	{
		if(document.formbak2.files[i].checked)
		{
			document.formbak2.refiles.value+="*"+document.formbak2.files[i].value;
		}
	}
	return true;
}
</script>
</head>
<body background='img/allbg.gif' leftmargin='8' topmargin='8'>
<table width="99%" border="0" cellpadding="3" cellspacing="1" bgcolor="#666666">
  <tr>
    <td height="19" background="img/tbg.gif" bgcolor="#E7E7E7"> &nbsp;<b>���ݱ���</b></td>
</tr>
<tr>
    <td height="215" align="center" bgcolor="#FFFFFF"> 
      <table width="96%" border="0" cellspacing="1" cellpadding="0">
      <form name="form1" action="sys_bakdat_ok.php">
        <tr> 
          <td width="25%" bgcolor="#F1F2EC"><strong>�����������ݣ�</strong></td>
          <td width="75%" bgcolor="#F1F2EC" align="right"> <input type="submit" name="Submit0" value=" " style="width:0"><input type="submit" name="Submit" value="ȷ������"></td>
        </tr>    
          <tr> 
            <td height="45" align="right">��ѡ��Ҫ���ݵı�</td>
            <td><select name="baktable" id="baktable">
                <option value="0" selected>--�������б�--</option>
                <?
		  $rs = mysql_list_tables($dbname,$conn);
           while($row = mysql_fetch_array($rs))
           {
	          	$rs2 = mysql_query("Select count(*) From ".$row[0],$conn);
	          	$row2 = mysql_fetch_array($rs2);
	          	$dd = $row2[0];
              	echo "			<option value='".$row[0]."'>".$row[0]."(".$dd.")</option>\r\n";
			  }
			  ?>
              </select> </td>
          </tr>
          <tr> 
            <td height="45" align="right">���·����</td>
            <td><?=$bak_dir?></td>
          </tr>
        </form>
        <tr align="center"> 
          <td colspan="2" bgcolor="#F1F2EC">���ݱ���˵��</td>
        </tr>
        <tr> 
          <td height="32" colspan="2">�������ݰ�ÿ���������ɶ�Ӧ��txt�ļ���������SQL��Insert��䣬ǰ�����~��������ʶ�������ڡ�ִ��MySQL����Ĳ�����������ЩSQL��䣬���Ƚ�~Insert 
            �滻Ϊ�� Insert�������Ҫ����վ����ƽ̨ת�ƣ���Ҫ���������ǣ�[1]�������ݣ�[2]���ļ��ϴ�������վ�ռ䣬��������setup.php����ԭ���������ٰ�װһ�飬Ȼ��ԭ���ݼ��ɡ�</td>
        </tr>
        <form name="formbak2" action="sys_redat_ok.php" onSubmit="return GetSubmit();">
        <input type="hidden" name="refiles" value="">
         <tr> 
          <td bgcolor="#F1F2EC"><b>��ԭ����</b></td><td bgcolor="#F1F2EC" align="right"><input type="submit" name="Submit2" value="ȷ����ԭ"></td>
        </tr>
        <tr>
          <td height="30" align="right">�������ݴ��·����</td>
          <td><?=$bak_dir?></td>
        </tr>
        <tr> 
          <td bgcolor="#F1F2EC" colspan="2">&nbsp;</td>
        </tr>
        <tr> 
          <td align="right" valign="top">��ѡ��Ҫִ�л�ԭ���ļ���</td>
          <td valign="top" align="right">
          <input type="button" name="btx" value="ȫ��ѡ��" onClick="selAll()">
          &nbsp;&nbsp;
          <input type="button" name="btx" value="ȡ��ѡ��" onClick="selNone()">
          </td>
        </tr>
        <tr> 
          <td bgcolor="#F1F2EC" colspan="2">&nbsp;</td>
        </tr>
        <tr> 
          <td valign="top" colspan="2"align="center">
          <table width="80%" border="0" cellspacing="1" cellpadding="0">
          <tr><td width="6%"></td><td></td></tr>
		  <?
		  $dh = dir($base_dir.$bak_dir);
		  while($filename = $dh->read())
		  {
		   	if(!is_dir($base_dir.$bak_dir."/".$filename))
		   	{
		   		echo "<tr><td><input name='files' value='$filename' type='checkbox' class='np'></td><td>$filename</td></tr>\r\n";
		   	}
		  }
		  ?>
		  </table>
		  </td>
        </tr>
        </form>
        <tr> 
          <td bgcolor="#F1F2EC" colspan="2">&nbsp;</td>
        </tr>
      </table></td>
</tr>
</table>
</body>
</html>