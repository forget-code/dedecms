<?
require("config.php");
require("inc_page_list.php");
$conn = connectMySql();
$sql = "";
//��ȡ�б����ز���
$pagesize=20;
$orderby=" order by dtime desc ";
$sql = "Select * From dede_flink";
$sqlcount = "Select count(ID) as dd From dede_flink";
$pageurl = "add_friendlink.php?tag=1";    
if(!isset($total_record))
{
      $rs=mysql_query($sqlcount,$conn);
      $row=mysql_fetch_object($rs);
      $total_record = $row->dd;
}
?>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
<title>�������ӹ���</title>
<link href='base.css' rel='stylesheet' type='text/css'>
<script language="javascript">
function DelVote(gurl)
{
	if(window.confirm('��ȷ��Ҫɾ�������վ��?')) location.href=gurl;
}
</script>
</head>
<body background='img/allbg.gif' leftmargin='8' topmargin='8'>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#666666">
  <tr>
    <td height="19" background="img/tbg.gif"><b>�������ӹ���</b>&nbsp;[<a href="add_friendlink_form.php"><u>��������</u></a>]  [<a href='<?=$art_php_dir."/flink.php"?>' target='_blank'><u>�ⲿ�����</u></a>]</td>
</tr>
<tr>
    <td height="200" bgcolor="#FFFFFF" valign="top">
    <table width="98%" border="0" cellpadding="1" cellspacing="1" bgcolor="#CCCCCC">
        <tr align="center" bgcolor="#E9E9E4"> 
          <td width="26%">��վ����</td>
          <td width="16%">��վLogo</td>
          <td width="15%">վ��Email</td>
          <td width="20%">����ʱ��</td>
          <td width="8%">״̬</td>
          <td width="15%">����</td>
        </tr>
		<?
		 $sql.=$orderby.get_limit($pagesize);
        if($total_record!=0)
        {
        	$rs = mysql_query($sql,$conn);
        	while($row=mysql_fetch_object($rs))
        	{
        		if($row->ischeck==0) $sta="δ���";
        		else $sta="�����";
		?>
        <tr align="center" bgcolor="#FFFFFF"> 
          <td><a href="<?=$row->url?>" target='_blank'><?=$row->webname?></a></td>
          <td><a href="<?=$row->url?>" target='_blank'><?if($row->logo!="") echo "<img src='".$row->logo."' width='88' height='31' border='0'>";?></a></td>
          <td><?=$row->email?></td>
          <td><?=$row->dtime?></td>
          <td><?=$sta?></td>
          <td><a href='add_friendlink_mod.php?ID=<?=$row->ID?>'>[����]</a> <a href="javascript:DelVote('add_friendlink_mod.php?ID=<?=$row->ID?>&job=del');">[ɾ��]</a></td>
        </tr>
		<?
		}
		}
		?>
        <tr align="right" bgcolor="#F7F9F7"> 
          <td colspan="6">
		  <?
          get_page_list($pageurl,$total_record,$pagesize);
          ?>
		  &nbsp;</td>
        </tr>
      </table> </td>
</tr>
</table>
</body>
</html>