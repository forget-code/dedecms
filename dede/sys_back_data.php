<?
require_once(dirname(__FILE__)."/config.php");
if(empty($dopost)) $dopost="";
@ob_start();
@set_time_limit(3600);
if(!is_dir($cfg_basedir.$cfg_backup_dir)) mkdir($cfg_basedir.$cfg_backup_dir,0777);
//�����ļ�������С(Ĭ����512K),���������С�ᴴ���µ��ļ�һֱ���������
$maxLen = 500*1024;
//--------------------------------------------
//���ݱ���
/*
function __bakData()
*/
//---------------------------------------------
if($dopost=="bakdata")
{
  $dsql = new DedeSql(false);
  $bakdir = $cfg_basedir.$cfg_backup_dir."/";
  $fileNo = 1;
  $bakStr = "";
  if(!is_dir($bakdir)) mkdir($bakdir,$cfg_dir_purview);
  //�������ݽṹ��Ϣ
  $dsql->SetQuery("Show Tables");
  $dsql->Execute('t');
	while($row = $dsql->GetArray('t'))
	{
		 $bakStr .= "~sql:DROP TABLE IF EXISTS `$baktable`;\r\n\r\n";
	   $dsql->SetQuery("SHOW CREATE TABLE ".$dsql->dbName.".".$baktable);
     $dsql->Execute();
     $row2 = $dsql->GetArray();
     $bakStr .= "~sql:".$row2[1].";\r\n\r\n";
  }
	$dsql->SetQuery("Show Tables");
  $dsql->Execute('t');
  $fp = fopen($bakdir."baktable".$fileNo.".txt","w");
	fwrite($fp,$bakStr);
	fclose($fp);
	echo "�ɹ��������ݽṹ��Ϣ��<br/>\r\n";
	flush();
	$fileNo++;
	$bakStr = "";
	//--------------------
	//�������ݼ�¼
	//----------------------	 
	while($row = $dsql->GetArray('t'))
	{
		 $baktable = $row[0];
		 //��ȡ�ֶ���Ϣ
		 //---------------------------------
		 $j=0;
	   $fs="";
		 $dsql->GetTableFields($baktable);
	   $intable = "~sql:Insert Into $baktable(";
	   while($r = $dsql->GetFieldObject()){
	   	 $fs[$j] = trim($r->name);
	   	 $intable .= $fs[$j].",";
	   	 $j++;
	   }
	   $fsd = $j-1;
	   $intable = ereg_replace(",$","",$intable).") Values(";
	   //��ȡ���������
	   //-----------------------------------------
	   $dsql->SetQuery("Select * From $baktable");
	   $dsql->Execute();
	   while($row2 = $dsql->GetArray())
	   {
		     $line = $intable;
		     for($j=0;$j<=$fsd;$j++){
			     if($j < $fsd) $line .= "'".addslashes($row2[$fs[$j]])."',";
			     else $line .= "'".addslashes($row2[$fs[$j]])."');\r\n";
		     }
		     if(strlen($bakStr) < $maxLen){ $bakStr .= $line;  }
		     else{
		     	 $fp = fopen($bakdir."baktable".$fileNo.".txt","w");
		     	 fwrite($fp,$bakStr);
		     	 fclose($fp);
		     	 echo "���浽�� $fileNo ���ļ���<br/>\r\n";
		     	 flush();
		     	 $bakStr = $line;
		     	 $fileNo++;
		     }
	   }
	}//ѭ�����б�
	
	if($bakStr!=""){
		$fp = fopen($bakdir."baktable".$fileNo.".txt","w");
		fwrite($fp,$bakStr);
		fclose($fp);
		echo "���浽�� $fileNo ���ļ���<br/>\r\n";
		flush();
	}
	
	ShowMsg("�ɹ������������ݱ�","sys_back_data.php?".time(),0,3000);
	$dsql->Close();
	exit();
}
//---------------------------------------------
//���ݻ�ԭ
/*
function __reData()
*/
//---------------------------------------------
if($dopost=="redata")
{
  if(empty($userok)) $userok="";
	if($userok!="yes")
	{
	   require_once(dirname(__FILE__)."/../include/pub_oxwindow.php");
	   $wintitle = "��ԭ����";
	   $wecome_info = "<a href='sys_back_data.php'><u>���ݻ�ԭ/����</u></a>::���ݻ�ԭ";
	   $win = new OxWindow();
	   $win->Init("sys_back_data.php","js/blank.js","POST");
	   $win->AddHidden("dopost",$dopost);
	   $win->AddHidden("userok","yes");
	   $win->AddTitle("ϵͳ���棡");
	   $win->AddMsgItem("��ԭ����ǰ������������ݿ����б�����ݣ���ȷʵҪ��ԭô��","50");
	   $winform = $win->GetWindow("ok");
	   $win->Display();
	   exit();
  }
  //---------------------------
  //��ԭ����
  //---------------------------
  $dsql = new DedeSql(false);
  if(!is_dir($cfg_basedir.$cfg_backup_dir)) mkdir($cfg_basedir.$cfg_backup_dir,0777);
  ////////������e��SQL�Z��
  $errFile = $cfg_basedir.$cfg_backup_dir."/error";
  if(!is_dir($errFile)) mkdir($errFile,0777);
  $errFile = $errFile."/err.txt";
  $fperr = fopen($errFile,"w");
  $dh = dir($cfg_basedir.$cfg_backup_dir);
  while($filename=$dh->Read())
  {
	  $filename = $cfg_basedir.$cfg_backup_dir."/".$filename;
	  if(is_dir($filename) || ereg("\.$",$filename)) continue;
	  $fp = fopen($filename,"r");
	  $j = 0;
	  $query = "";
	  while(!feof($fp))
	  {
		  $line = fgets($fp,1024);
		  if(eregi("^~sql:",$line) && $query!="")
		  {
			  $query = trim(eregi_replace("^~sql:","",$query));
			  $dsql->SetQuery($query);
			  if($dsql->ExecuteNoneQuery()) $j++;
			  else fwrite($fperr,$query."\r\n");
			  $query = $line;
		  }
		  else{ $query .= $line; }
	  }
	  fclose($fp);
	  $query = trim(eregi_replace("^~sql:","",$query));
	  $dsql->SetQuery($query);
	  if($dsql->ExecuteNoneQuery()) $j++;
	  else fwrite($fperr,$query."\r\n");
	  echo $filename." ��: $j ��SQL���ɹ�����!<br>\r\n";
	}
	$dh->Close();
  fclose($fperr);
  ShowMsg("�ɹ���ԭ�������ݣ�","sys_back_data.php?".time(),0,3000);
  exit();
}
?>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
<title>�����뻹ԭ</title>
<link href='base.css' rel='stylesheet' type='text/css'>
</head>
<body background='img/allbg.gif' leftmargin='8' topmargin='8'>
<table width="99%" border="0" cellpadding="3" cellspacing="1" bgcolor="#666666">
<tr>
<td height="19" background="img/tbg.gif" bgcolor="#E7E7E7">
&nbsp;<b>���ݱ���</b>
</td>
</tr>
<tr>
<td height="215" align="center" bgcolor="#FFFFFF"> 
<table width="96%" border="0" cellspacing="1" cellpadding="0">
<form name="form1" action="sys_back_data.php">
<input type="hidden" name="dopost" value="bakdata">
<tr> 
<td width="25%" bgcolor="#F1F2EC"><strong>�����������ݣ�</strong></td>
<td width="75%" bgcolor="#F1F2EC" align="right">
	<input type="submit" name="Submit" value="ȷ������">
</td>
</tr>
<tr> 
<td height="45" align="right">���ݿ���Ϣ��</td>
<td>
<select name="baktable" id="baktable" style="width:250">
<?
$dsql = new DedeSql(false);
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
$dsql->Close();
?>
</select>
</td>
</tr>
<tr> 
<td height="45" align="right">���·����</td>
<td><?=$cfg_backup_dir?></td>
</tr>
</form>
<tr align="center"> 
<td colspan="2" bgcolor="#F1F2EC"><b>���ݱ���˵��</b></td>
</tr>
<tr> 
<td height="32" colspan="2">����������õ���һ�����ݺ�һ����ԭ��ģʽ���������װ��ϵͳ�����ȱ������ݣ���װ��ϵͳ�󣬰ѱ��������ϴ�����ϵͳ�ı����ļ��У�Ȼ��ִ��һ����ԭ���ɣ�������������̫���޷�һ���Ի�ԭ�����Ȱ� baktable1.txt �ŵ������ļ��н��л�ԭ��Ȼ���ٰ��������ݷֶ�λ�ԭ��</td>
</tr>
<form name="formbak2" action="sys_back_data.php">
<input type="hidden" name="dopost" value="redata">
 <tr> 
<td bgcolor="#F1F2EC"><b>��ԭ����</b></td>
<td bgcolor="#F1F2EC" align="right">
	<input type="submit" name="Submit2" value="ȷ����ԭ">
</td>
</tr>
<tr>
<td height="30" align="right">�������ݴ��·����</td>
<td><?=$cfg_backup_dir?></td>
</tr>
<tr> 
<td bgcolor="#F1F2EC" colspan="2">&nbsp;</td>
</tr>
<tr> 
            <td align="right" valign="top">�ڱ���Ŀ¼�����ݣ�</td>
            <td valign="top" align="right">&nbsp; </td>
</tr>
<tr> 
<td bgcolor="#F1F2EC" colspan="2">&nbsp;</td>
</tr>
<tr> 
<td valign="top" colspan="2"align="center">
<table width="80%" border="0" cellspacing="1" cellpadding="0">
<tr><td width="6%"></td><td></td></tr>
		<?
		$dh = dir($cfg_basedir.$cfg_backup_dir);
		while($filename = $dh->read())
		{
		 	if(!is_dir($cfg_basedir.$cfg_backup_dir."/".$filename)){
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