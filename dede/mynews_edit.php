<?
require_once(dirname(__FILE__)."/config.php");
CheckPurview('plus_վ�����ŷ���');
if(empty($dopost)) $dopost = "";
$aid = ereg_replace("[^0-9]","",$aid);
$dsql = new DedeSql(false);
if($dopost=="del")
{
	 $dsql->SetQuery("Delete From #@__mynews where aid='$aid';");
	 $dsql->ExecuteNoneQuery();
	 $dsql->Close();
	 ShowMsg("�ɹ�ɾ��һ��վ�����ţ�","mynews_main.php");
	 exit();
}
else if($dopost=="editsave")
{
	$dsql->SetQuery("Update #@__mynews set title='$title',typeid='$typeid',writer='$writer',senddate='".GetMKTime($sdate)."',body='$body' where aid='$aid';");
	$dsql->ExecuteNoneQuery();
	$dsql->Close();
	ShowMsg("�ɹ�����һ��վ�����ţ�","mynews_main.php");
	exit();
}
$myNews = $dsql->GetOne("Select #@__mynews.*,#@__arctype.typename From #@__mynews left join #@__arctype on #@__arctype.ID=#@__mynews.typeid where #@__mynews.aid='$aid';");
?>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
<title>վ�����ŷ���</title>
<link href='base.css' rel='stylesheet' type='text/css'>
<script>
function checkSubmit()
{
  if(document.form1.title.value=="")
  {
     document.form1.title.focus();
     alert("��������趨��");
     return false;
  }
}
</script>
</head>
<body background='img/allbg.gif' leftmargin='8' topmargin='8'>
<table width="98%" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#666666">
  <form action="mynews_edit.php" method="post" name="form1" onSubmit="return checkSubmit();">
  <input type="hidden" name="dopost" value="editsave">
  <input type="hidden" name="aid" value="<?=$myNews['aid']?>">
  <tr>
      <td height="24" background="img/tbg.gif"> 
        <table width="90%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td><strong>&nbsp;վ�����Ź���-&gt;������Ϣ</strong></td>
            <td align="right"> <a href="mynews_main.php"><img src="img/file_edit.gif" width="15" height="16" border="0"><u>���ع���ҳ</u></a> 
            </td>
          </tr>
        </table></td>
</tr>
<tr>
    <td height="127" align="center" bgcolor="#FFFFFF"> 
      <table width="98%" border="0" cellspacing="2" cellpadding="0">
          <tr> 
            <td height="20" colspan="2">����˵����վ��������Ϊ�˷���վ������վ�㹫������õ�һ��С���ܣ�����Ҫ��ȡ����text�ֶε���Ϣ��Ӧ����ɾ��̫�ɵ���Ϣ��������ܻ���ģ������ٶȱ��������û��ѡ����ʾƵ�����������Ƶ����ʹ��������ʱ�ᱻ������λ��...���ı�����ݴ��档</td>
          </tr>
          <tr> 
            <td height="20" colspan="2">����վ�����ŵ��ô��룺 {dede:mynews row='����' titlelen='���ⳤ��'}Innertext{/dede:mynews}��Innertext֧�ֵ��ֶ�Ϊ��[field:title 
              /],[field:writer /],[field:senddate /](ʱ��),[field:body /]�� </td>
          </tr>
          <tr> 
            <td width="13%" height="30">�ꡡ�⣺</td>
            <td width="87%"> <input name="title" type="text" id="title" value="<?=$myNews['title']?>" size="30" style="width:300"> 
            </td>
          </tr>
          <tr>
            <td height="30">��ʾƵ����</td>
            <td>
			  <select name="typeid" style="width:150">     
        <?
			  $dsql->SetQuery("Select ID,typename From #@__arctype where reID=0 order by ABS(".$myNews['typeid']." - ID) asc");
			  $dsql->Execute();
			  while($row = $dsql->GetObject())
			  {
			     echo "<option value='".$row->ID."'>".$row->typename."</option>\r\n";
			  }
			  if($myNews['typeid']=="0") echo "<option value=\"0\" selected>����λ��...</option>\r\n";
			  else echo "<option value=\"0\">����λ��...</option>\r\n";
			  ?>
        </select>
			   </td>
          </tr>
          <tr> 
            <td height="30">�����ˣ�</td>
            <td><input name="writer" type="text" id="writer" value="<?=$myNews['writer']?>" size="16">
              �� ���ڣ� 
              <input name="sdate" type="text" id="sdate" size="25" value="<?=GetDateTimeMk($myNews['senddate'])?>"></td>
          </tr>
          <tr> 
            <td height="172" valign="top">��Ϣ���ݣ�</td>
            <td height="172"> 
              <?
	GetEditor("body",$myNews['body'],250,"Small");
	?>
            </td>
          </tr>
          <tr> 
            <td height="38">&nbsp;</td>
            <td><input type="submit" name="Submit" value="�ύ����"> &nbsp;</td>
          </tr>
          <tr bgcolor="#F1FAF2"> 
            <td colspan="2">&nbsp;</td>
          </tr>
        </table>
      </td>
</tr>
</form>
</table>
<?
$dsql->Close();
?>
</body>
</html>