<?
require(dirname(__FILE__)."/config.php");
SetPageRank(10);
if(empty($dopost)) $dopost = "";
$dsql = new DedeSql(false);
if($dopost=="viewinfo")
{
	if(empty($tablename)) echo "û��ָ��������";
	else
	{
		$dsql->SetQuery("SHOW CREATE TABLE ".$dsql->dbName.".".$tablename);
    $dsql->Execute();
    $row2 = $dsql->GetArray();
    $ctinfo = $row2[1];
    echo "<xmp>".trim($ctinfo)."</xmp>";
	}
	$dsql->Close();
	exit();
}
else if($dopost=="query")
{
	$sqlquery = trim(stripslashes($sqlquery));
	if(eregi("drop(.*)table",$sqlquery) || eregi("drop(.*)database",$sqlquery))
	{
		echo "<span style='font-size:10pt'>ɾ��'���ݱ�'��'���ݿ�'����䲻����������ִ�С�</span>";
		$dsql->Close();
	  exit();
	}
	
	//���в�ѯ���
	if(eregi("^select ",$sqlquery))
	{
		$dsql->SetQuery($sqlquery);
	  $dsql->Execute();
	  if($dsql->GetTotalRow()<=0) echo "����SQL��{$sqlquery}���޷��ؼ�¼��";
	  else echo "����SQL��{$sqlquery}������".$dsql->GetTotalRow()."����¼����󷵻�100����";
	  $j = 0;
	  while($row = $dsql->GetArray())
	  {
	  	$j++;
	  	if($j>100) break;
	  	echo "<hr size=1 width='100%'/>";
	  	echo "��¼��$j";
	  	echo "<hr size=1 width='100%'/>";
	  	foreach($row as $k=>$v){
	  		if(ereg("[^0-9]",$k)){
	  			echo "<font color='red'>{$k}��</font>{$v}<br/>\r\n";
	  		}
	  	}
	  }
	  exit();
	}
	
	$sqls = explode(";",$sqlquery);
	$errCode = "";
	$i=0;
	foreach($sqls as $q)
	{
	  $q = trim($q);
	  if($q=="") continue;
	  $dsql->SetQuery($q);
	  $dsql->ExecuteNoneQuery();
	  $nerrCode = trim($dsql->GetError());
	  if($nerrCode=="") $i++;
	  else $errCode .= "ִ�У� <font color='blue'>$q</font> ����������ʾ��<font color='red'>".$nerrCode."</font><br>";
  }
	echo "�ɹ�ִ��{$i}��SQL��䣡<br><br>";
	echo $errCode;
	$dsql->Close();
	exit();
}
?>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
<title>�����Զ���ҳ��</title>
<link href='base.css' rel='stylesheet' type='text/css'>
</head>
<body background='img/allbg.gif' leftmargin='8' topmargin='8'>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#666666">
<tr>
    <td height="19" background="img/tbg.gif"> <strong>SQL������������</strong></td>
</tr>
<tr>
    <td height="200" bgcolor="#FFFFFF" valign="top">
	<table width="100%" border="0" cellspacing="4" cellpadding="2">
        <form action="sql_main.php" method="post" name="infoform" target="stafrm">
          <input type='hidden' name='dopost' value='viewinfo'>
          <tr bgcolor="#F3FBEC"> 
            <td width="15%" height="24" align="center">ϵͳ�ı���Ϣ��</td>
            <td>
			<select name="tablename" id="tablename" style="width:250" size="6">
<?
$dsql->SetQuery("Show Tables");
$dsql->Execute('t');
while($row = $dsql->GetArray('t'))
{
	$dsql->SetQuery("Select count(*) From ".$row[0]);
	$dsql->Execute('n');
	$row2 = $dsql->GetArray('n');
	$dd = $row2[0];
	echo "			<option value='".$row[0]."'>".$row[0]."(".$dd.")</option>\r\n";
}
?>
</select>
              &nbsp; <input type="Submit" name="Submit1" value="�鿴����Ϣ" class="np">
			 </td>
          </tr>
          <tr> 
            <td height="200" align="center">������Ϣ��</td>
            <td>
			<iframe name="stafrm" frameborder="0" id="stafrm" width="100%" height="100%"></iframe>
			</td>
          </tr>
		  </form>
		  <form action="sql_main.php" method="post" name="form1" target="stafrm">
          <input type='hidden' name='dopost' value='query'>
          <tr> 
            <td height="24" colspan="2" bgcolor="#F3FBEC"><strong>����SQL�����У�</strong></td>
          </tr>
		      <tr> 
            <td height="118" colspan="2">
			<textarea name="sqlquery" cols="60" rows="10" id="sqlquery" style="width:80%"></textarea> 
            </td>
          </tr>
          <tr> 
            <td height="53" align="center">&nbsp;</td>
            <td><input name="imageField" type="image" src="img/button_ok.gif" width="60" height="22" border="0"></td>
          </tr>
        </form>
      </table>
	 </td>
</tr>
</table>
<?
$dsql->Close();
?>
</body>
</html>