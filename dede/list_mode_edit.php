<?
require("config.php");
$conn = connectMySql();
$rs = mysql_query("Select * From dede_arttype where ID=$ID",$conn);
$row = mysql_fetch_object($rs);
$modname = urlencode($row->modname);
$modnameurl = $mod_dir."/".$modname."/".$row->channeltype;
$modname = $mod_dir."/".$row->modname."/".$row->channeltype;
$modname2 = $mod_dir."/".$row->modname;
$modnameurl2 = $mod_dir."/".urlencode($row->modname);
$typename = $row->typename;
?>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
<title>��Ŀģ�����</title>
<link href='base.css' rel='stylesheet' type='text/css'>
<script src='menu.js' language='JavaScript'></script>
</head>
<body background='img/allbg.gif' leftmargin='6' topmargin='6'>
<table width="600" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#666666">
  <tr> 
    <td height="19" background="img/tbg.gif" bgcolor="#E7E7E7"><strong>���ģ�����</strong>&nbsp; 
      [<a href="list_type.php"><u>��Ŀ����</u></a>]</td>
  </tr>
  <tr> 
    <td height="95" align="center" bgcolor="#FFFFFF">
    <table width="96%" border="0" cellspacing="0" cellpadding="0">
        <form name="form1" action="" method="post">
          <input type="hidden" name="ID" value="<?=$ID?>">
          <tr> 
            <td height="30" colspan="2">
            ����ѡ���Ŀ¼Ϊ��
            <?
            echo $typename;
            echo " <a href='mod_type.php?ID=$ID&typeoldname=$typename'>[<u>����Ƶ�����</u>]</a>";
            ?>
            </td>
          </tr>
          <tr> 
            <td colspan="2" height="30">Ŀ¼���б�ģ�壺
           <?
            echo "<a href='$modnameurl/".urlencode("�б�").".htm' target='_blank'><u>$modname/�б�.htm</u></a>";
            echo "����<a href='file_edit.php?activepath=".$modname."&filename=�б�.htm&job=edit'>[<u>�༭ģ��</u>]</a>\r\n";
           ?>
           </td>
          </tr>
          <tr> 
            <td colspan="2" height="30">Ŀ¼������ģ�壺
           <?
            echo "<a href='$modnameurl/".urlencode("����").".htm' target='_blank'><u>$modname/����.htm</u></a>";
            echo "����<a href='file_edit.php?activepath=".$modname."&filename=����.htm&job=edit'>[<u>�༭ģ��</u>]</a>";
           ?>
           </td>
          </tr>
          <tr> 
            <td colspan="2" height="30">Ŀ¼��ר��ģ�壺
           <?
            echo "<a href='$modnameurl/".urlencode("ר��").".htm' target='_blank'><u>$modname/ר��.htm</u></a>";
            echo "����<a href='file_edit.php?activepath=".$modname."&filename=ר��.htm&job=edit'>[<u>�༭ģ��</u>]</a>";
           ?>
           </td>
          </tr>
          <tr> 
            <td colspan="2" height="30">Ĭ�ϰ��ģ�壺
           <?
            echo "<a href='$modnameurl2/part.htm' target='_blank'><u>$modname2/part.htm</u></a>";
            echo "����<a href='file_edit.php?activepath=".$modname2."&filename=part.htm&job=edit'>[<u>�༭ģ��</u>]</a>";
           ?>
           </td>
          </tr>
          <tr> 
            <td  colspan="2" height="40">
            �Ƿ�ʹ���Զ���İ��ģ����ΪƵ����ҳ��
            <?
            $rs = mysql_query("Select ID,typeid From dede_partmode where typeid=$ID",$conn);
			if(mysql_num_rows($rs)<=0)
			{
				echo "û�� [<a href='web_type_web.php?ID=$ID'><u>�����Զ����</u></a>]";
			}
			else
			{
				$row = mysql_fetch_object($rs);
				echo "�� [<a href='web_type_webtest.php?ID=".$row->ID."&job=edit'><u>�༭�Զ����</u></a>]";
			}
            ?>
            <hr size="1">
            ��û������Ƶ����ҳΪ���ģ�������£�Ƶ����ҳΪ�б��ļ��ĵ�һҳ���б�ģ��Ĺ̶���ʽ��<br>���������Ƶ����ҳΪ���ģ�壬�����б�󣬱�����<a href='web_type_web.php'><u>��������</u></a>�и��������Ƶ���İ�顣
            </td>
          </tr>
          <tr> 
            <td height="20" colspan="2">&nbsp;</td>
          </tr>
        </form>
      </table></td>
  </tr>
</table>
</body>

</html>
