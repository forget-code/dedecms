<?
require(dirname(__FILE__)."/config.php");
CheckPurview('plus_��������ģ��');

$dsql = new DedeSql();
$dsql->Init(false);

if(empty($dopost)) $dopost="";
if($dopost=="add")
{
   $dtime = strftime("%Y-%m-%d %H:%M:%S",mytime());
   if(is_uploaded_file($logoimg))
   {
	   $names = split("\.",$logoimg_name);
	   $shortname = ".".$names[count($names)-1];
	   $filename = strftime("%Y%m%d%H%M%S",mytime()).mt_rand(1000,9999).$shortname;
	   $imgurl = $cfg_medias_dir."/flink";
	   if(!is_dir($cfg_basedir.$imgurl)){
	   	  MkdirAll($cfg_basedir.$imgurl,777);
	   	  CloseFtp();
	   }
	   $imgurl = $imgurl."/".$filename;
	   move_uploaded_file($logoimg,$cfg_basedir.$imgurl) or die("�����ļ���:".$cfg_basedir.$imgurl."ʧ��");
	   @unlink($logoimg);
   }
   else 
	 { $imgurl = $logo; }
   $query = "Insert Into #@__flink(sortrank,url,webname,logo,msg,email,typeid,dtime,ischeck) 
   Values('$sortrank','$url','$webname','$imgurl','$msg','$email',$typeid,'$dtime','$ischeck')";
   $dsql->SetQuery($query);
   $dsql->ExecuteNoneQuery();
   if(!empty($_COOKIE['ENV_GOBACK_URL'])) $burl = $_COOKIE['ENV_GOBACK_URL'];
   else $burl = "friendlink_main.php";
   $dsql->Close();
   ShowMsg("�ɹ�����һ������!",$burl,0,500);
   exit();
}

?>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
<title>�������ӹ���</title>
<script language='javascript'>
function CheckSubmit()
{
	if(document.form1.url.value=="http://"||document.form1.url.value=="")
	{
   		document.form1.url.focus();
   		alert("��ַ����Ϊ�գ�");
   		return false;
	}
	if(document.form1.webname.value=="")
	{
   		document.form1.webname.focus();
   		alert("��վ���Ʋ���Ϊ�գ�");
   		return false;
	}
	return true;
}
</script>
<link href='base.css' rel='stylesheet' type='text/css'>
</head>
<body background='img/allbg.gif' leftmargin='8' topmargin='8'>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#666666">
  <tr>
    <td height="19" background="img/tbg.gif"><b><a href="friendlink_main.php"><u>�������ӹ���</u></a></b>&gt;&gt;��������</td>
</tr>
<tr>
    <td height="200" bgcolor="#FFFFFF" valign="top">
	<form action="friendlink_add.php" method="post" enctype="multipart/form-data" name="form1" onSubmit="return CheckSubmit();";>
	<input type="hidden" name="dopost" value="add">
	<table width="80%"  border="0" cellspacing="1" cellpadding="3">
	  <tr>
        <td width="19%" height="25">��ַ��</td>
        <td width="81%"><input name="url" type="text" id="url" value="http://" size="30"></td>
      </tr>
      <tr>
        <td height="25">��վ���ƣ�</td>
        <td><input name="webname" type="text" id="webname" size="30"></td>
      </tr>
      <tr>
        <td width="19%" height="25">����λ�ã�</td>
        <td width="81%">
        <input name="sortrank" type="text" id="sortrank" value="1" size="10">
        (��С��������)
        </td>
      </tr>
      <tr>
        <td height="25">��վLogo��</td>
        <td><input name="logo" type="text" id="logo" size="30">
          (88*31 gif��jpg)</td>
      </tr>
      <tr>
        <td height="25">�ϴ�Logo��</td>
        <td><input name="logoimg" type="file" id="logoimg" size="30"></td>
      </tr>
      <tr>
        <td height="25">��վ�����</td>
        <td><textarea name="msg" cols="50" rows="4" id="msg"></textarea></td>
      </tr>
      <tr>
        <td height="25">վ��Email��</td>
        <td><input name="email" type="text" id="email" size="30"></td>
      </tr>
      <tr>
        <td height="25">��վ���ͣ�</td>
        <td>
        <select name="typeid" id="typeid">
        <?
        $dsql->SetQuery("select * from #@__flinktype");
        $dsql->Execute();
        while($row=$dsql->GetObject())
        {
        	echo "	<option value='".$row->ID."'>".$row->typename."</option>\r\n";
        }
        ?>
        </select>
        </td>
      </tr>
      <tr>
        <td height="25">����λ�ã�</td>
        <td>
        <select name="ischeck">
        <option value="1">��ҳ</option>
        <option value="2">��ҳ</option>
        </select>
        </td>
      </tr>
      <tr>
        <td height="51">&nbsp;</td>
        <td><input type="submit" name="Submit" value=" �� �� ">�� ��
          <input type="reset" name="Submit" value=" �� �� "></td>
      </tr>
    </table>
	</form>
    </td>
</tr>
</table>
<?
$dsql->Close();
?>
</body>
</html>