<?
require(dirname(__FILE__)."/config.php");
require(dirname(__FILE__)."/../include/pub_dedetag.php");
if(empty($dopost)) $dopost="";
if(empty($aid)) $aid="";
$aid = trim(ereg_replace("[^0-9]","",$aid));
if($aid==""){
	ShowMsg('��û��ָ��ͶƱID��','-1');
	exit();
}
if(!empty($_COOKIE['ENV_GOBACK_URL'])) $ENV_GOBACK_URL = $_COOKIE['ENV_GOBACK_URL'];
else $ENV_GOBACK_URL = "vote_main.php";
///////////////////////////////////////
$dsql = new DedeSql(false);
if($dopost=="delete")
{
	$dsql->SetQuery("Delete From #@__vote where aid='$aid'");
	$dsql->ExecuteNoneQuery();
	$dsql->Close();
	ShowMsg('�ɹ�ɾ��һ��ͶƱ!',$ENV_GOBACK_URL);
	exit();
}
else if($dopost=="saveedit")
{
	$starttime = GetMkTime($starttime);
	$endtime = GetMkTime($endtime);
	$query = "Update #@__vote set votename='$votename',
	starttime='$starttime',
	endtime='$endtime',
	totalcount='$totalcount',
	ismore='$ismore',
	votenote='$votenote' where aid='$aid'";
	$dsql->SetQuery($query);
	$dsql->ExecuteNoneQuery();
	$dsql->Close();
	ShowMsg('�ɹ�����һ��ͶƱ!',$ENV_GOBACK_URL);
	exit();
}
$row = $dsql->GetOne("Select * From #@__vote where aid='$aid'");
?>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
<title>ͶƱ����</title>
<link href='base.css' rel='stylesheet' type='text/css'>
</head>
<body background='img/allbg.gif' leftmargin='8' topmargin='8'>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#666666">
  <tr>
    <td height="19" background="img/tbg.gif"><b>ͶƱ����</b>&gt;&gt;����ͶƱ&nbsp;&nbsp;[<a href="vote_main.php"><u>��������ͶƱ���ݼ�¼</u></a>]</td>
</tr>
<tr>
    <td height="200" bgcolor="#FFFFFF" valign="top">
	<form name="form1" method="post" action="vote_edit.php">
	<input type="hidden" name="dopost" value="saveedit">
	<input type="hidden" name="aid" value="<?=$aid?>">
	    <table width="100%" border="0" cellspacing="4" cellpadding="4">
          <tr> 
            <td width="15%" align="center">ͶƱ���ƣ�</td>
            <td width="85%"> <input name="votename" type="text" id="votename" value="<?=$row['votename']?>"> 
            </td>
          </tr>
          <tr>
            <td align="center">ͶƱ��������</td>
            <td><input name="totalcount" type="text" id="totalcount" value="<?=$row['totalcount']?>"></td>
          </tr>
          <tr> 
            <td align="center">��ʼʱ�䣺</td>
            <td><input name="starttime" type="text" id="starttime" value="<?=GetDateMk($row['starttime'])?>"></td>
          </tr>
          <tr> 
            <td align="center">����ʱ�䣺</td>
            <td><input name="endtime" type="text" id="endtime" value="<?=GetDateMk($row['endtime'])?>"></td>
          </tr>
          <tr> 
            <td align="center">�Ƿ��ѡ��</td>
            <td> <input name="ismore" type="radio" class="np" value="0"<?if($row['ismore']==0) echo " checked";?>>
              ��ѡ �� 
              <input type="radio" name="ismore" class="np" value="1"<?if($row['ismore']==1) echo " checked";?>>
              ��ѡ </td>
          </tr>
          <tr> 
            <td align="center">Ͷ Ʊ �<br/>
              (�밴��ͬ����ʽ�����ӻ��޸Ľڵ㣬�������ԣ�id�����ظ�) </td>
            <td><textarea name="votenote" rows="8" id="votenote" style="width:80%"><?=$row['votenote']?></textarea> 
            </td>
          </tr>
          <tr> 
            <td height="47">&nbsp;</td>
            <td><input type="submit" name="Submit" value="����ͶƱ����"></td>
          </tr>
          <tr> 
            <td colspan="2">&nbsp;</td>
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