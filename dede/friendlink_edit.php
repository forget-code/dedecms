<?
require_once(dirname(__FILE__)."/config.php");
if(!empty($_COOKIE['ENV_GOBACK_URL'])) $ENV_GOBACK_URL = $_COOKIE['ENV_GOBACK_URL'];
else $ENV_GOBACK_URL = friendlink_main.php;

$dsql = new DedeSql();

if(empty($dopost)) $dopost = "";

if($dopost=="delete")
{
	$ID = ereg_replace("[^0-9]","",$ID);
	$dsql->SetQuery("Delete From #@__flink where ID='$ID'");
	$dsql->ExecuteNoneQuery();
	$dsql->Close();
	ShowMsg("�ɹ�ɾ��һ�����ӣ�",$ENV_GOBACK_URL);
	exit();
}
else if($dopost=="saveedit")
{
	$ID = ereg_replace("[^0-9]","",$ID);
	$query = "Update #@__flink set 
	sortrank='$sortrank',url='$url',webname='$webname',
	logo='$logo',msg='$msg',
	email='$email',typeid='$typeid',
	ischeck='$ischeck' where ID='$ID'";
	$dsql->SetQuery($query);
	$dsql->ExecuteNoneQuery();
	$dsql->Close();
	ShowMsg("�ɹ�����һ�����ӣ�",$ENV_GOBACK_URL);
	exit();
}
$myLink = $dsql->GetOne("Select #@__flink.*,#@__flinktype.typename From #@__flink left join #@__flinktype on #@__flink.typeid=#@__flinktype.ID where #@__flink.ID=$ID");
?>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
<title>�������Ӹ���</title>
<link href='base.css' rel='stylesheet' type='text/css'>
</head>
<body background='img/allbg.gif' leftmargin='8' topmargin='8'>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#666666">
  <tr>
    <td height="19" background="img/tbg.gif">
    	<b><a href="friendlink_main.php"><u>�������ӹ���</u></a></b>&gt;&gt;���Ӹ���</td>
</tr>
<tr>
    <td height="200" bgcolor="#FFFFFF" valign="top">
	<form action="friendlink_edit.php" method="post" enctype="multipart/form-data" name="form1">
	<input type="hidden" name="ID" value="<?=$myLink['ID']?>">
	<input type="hidden" name="dopost" value="saveedit">
	<table width="80%"  border="0" cellspacing="1" cellpadding="3">
	  <tr>
        <td width="19%" height="25">��ַ��</td>
        <td width="81%">
        <input name="url" type="text" id="url" value="<?=$myLink['url']?>" size="30">
        </td>
      </tr>
      <tr>
        <td width="19%" height="25">����λ�ã�</td>
        <td width="81%">
        <input name="sortrank" type="text" id="sortrank" value="<?=$myLink['sortrank']?>" size="10">
        (��С��������)
        </td>
      </tr>
      <tr>
        <td height="25">��վ���ƣ�</td>
        <td><input name="webname" type="text" id="webname" size="30" value="<?=$myLink['webname']?>"></td>
      </tr>
      <tr>
        <td height="25">��վLogo��</td>
        <td><input name="logo" type="text" id="logo" size="40" value="<?=$myLink['logo']?>">
          (88*31 gif��jpg)</td>
      </tr>
      <tr>
        <td height="25">�ϴ�Logo��</td>
        <td><input name="logoimg" type="file" id="logoimg" size="30"></td>
      </tr>
      <tr>
        <td height="25">��վ�����</td>
        <td><textarea name="msg" cols="50" rows="4" id="msg"><?=$myLink['msg']?></textarea></td>
      </tr>
      <tr>
        <td height="25">վ��Email��</td>
        <td><input name="email" type="text" id="email" size="30" value="<?=$myLink['email']?>"></td>
      </tr>
      <tr>
        <td height="25">״̬��</td>
        <td>
        <select name="ischeck">
        <option value="0"<?if($myLink['ischeck']==0) echo " selected"?>>δ���</option>
        <option value="1"<?if($myLink['ischeck']==1) echo " selected"?>>�����</option>
        </select>
        </td>
      </tr>
      <tr>
        <td height="25">��վ���ͣ�</td>
        <td>
        <select name="typeid" id="typeid">
        <?
        echo "	<option value='".$myLink['typeid']."'>".$myLink['typename']."</option>\r\n";
        $dsql->SetQuery("select * from #@__flinktype where ID<>'".$myLink['typeid']."'");
        $dsql->Execute();
        while($row=$dsql->GetObject()){
        	echo "	<option value='".$row->ID."'>".$row->typename."</option>\r\n";
        }
        ?>
        </select>
        </td>
      </tr>
      <tr>
        <td height="51">&nbsp;</td>
        <td><input type="submit" name="Submit" value=" �� �� ">�� ��
          <input type="reset" name="Submit" value=" �� �� " onclick="location.href='<?=$ENV_GOBACK_URL?>';"></td>
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