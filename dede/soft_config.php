<?
require_once(dirname(__FILE__)."/config.php");
CheckPurview('sys_SoftConfig');
if(empty($dopost)) $dopost = "";
//����
$dsql = new DedeSql(false);
if($dopost=="save")
{
   $query = "UPDATE `#@__softconfig` SET downtype = '$downtype' , 
   gotojump='$gotojump' , ismoresite = '$ismoresite',sites = '$sites'";
   $dsql->SetQuery($query);
   $dsql->ExecuteNoneQuery();
}
//��ȡ����
$row = $dsql->GetOne("select * From #@__softconfig");
if(!is_array($row)){
	$dsql->ExecuteNoneQuery("INSERT INTO `#@__softconfig` ( `downtype` , `ismoresite` , `gotojump` , `sites` ) VALUES ('0', '0', '0', '');");
	$row['downtype']=1;
	$row['ismoresite']=0;
	$row['sites']="";
	$row['gotojump']=0;
}
$dsql->Close();
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>������Դ����</title>
<link href="base.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function AddServer()
{
   if(document.form1.serverurl.value==""||document.form1.serverurl.value=="http://"){ alert('��������ַ����Ϊ�գ�'); return ;}
   if(document.form1.servername.value==""){ alert('���������Ʋ���Ϊ�գ�'); return ;}
   document.form1.sites.value += document.form1.serverurl.value+" | "+document.form1.servername.value+"\r\n";
}
</script>
</head>
<body background='img/allbg.gif' leftmargin='8' topmargin='8'>
<table width="98%" border="0" cellpadding="3" cellspacing="1" bgcolor="#666666" align="center">
  <form name="form1" action="soft_config.php" method="post">
    <input type="hidden" name="dopost" value="save">
    <tr> 
      <td height="20" colspan="2" background='img/tbg.gif'> <table width="98%" border="0" cellpadding="0" cellspacing="0">
          <tr> 
            <td width="30%" height="18"><strong>���Ƶ�����ã�</strong></td>
            <td width="70%" align="right">&nbsp;</td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td width="125" valign="top" bgcolor="#FFFFFF">������ʾ��ʽ��</td>
      <td width="827" valign="top" bgcolor="#FFFFFF">
      	<input type="radio" name="downtype" class="np" value="0"<?if($row['downtype']==0) echo " checked";?>>
        ֱ����ʾ��ַ�б� 
        <input name="downtype" type="radio" value="1" class="np"<?if($row['downtype']==1) echo " checked";?>>
        Ҫ��������ص�ַ�б�ҳ
       </td>
    </tr>
    <tr> 
      <td valign="top" bgcolor="#FFFFFF">�������ط�ʽ��</td>
      <td valign="top" bgcolor="#FFFFFF">
      	<input type="radio" name="gotojump" class="np" value="0"<?if($row['gotojump']==0) echo " checked";?>>
        ���ӵ���ʵ�����ַ 
        <input name="gotojump" type="radio" class="np" value="1"<?if($row['gotojump']==1) echo " checked";?>>
        ���ӵ���תҳ��
       </td>
    </tr>
    <tr> 
      <td valign="top" bgcolor="#FFFFFF">�Ƿ����þ���վ�㣺</td>
      <td valign="top" bgcolor="#FFFFFF">
      	<input type="radio" name="ismoresite" class="np" value="1"<?if($row['ismoresite']==1) echo " checked";?>>
        ���� 
        <input name="ismoresite" type="radio" class="np" value="0"<?if($row['ismoresite']==0) echo " checked";?>>
        ������
       </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td colspan="2" valign="top">
      	��������˷����������ܣ��������ص�ַʱ��ֻ��Ҫ��д�������ӵĵ�ַ��ϵͳ���Զ����ɾ���������ĵ�ַ��
      </td>
    </tr>
    <tr bgcolor="#F1FCEF"> 
      <td colspan="2" valign="top">
      	����������б�
      </td>
    </tr>
    <tr> 
      <td colspan="2" valign="top" bgcolor="#FFFFFF">��������ַ�� 
        <input name="serverurl" type="text" id="serverurl" value="http://">
        ���������ƣ� 
        <input name="servername" type="text" id="servername">
		<input type="button" name="Submit" value="����һ��" onClick="AddServer()">
	  </td>
    </tr>
    <tr> 
      <td height="62" colspan="2" bgcolor="#FFFFFF"> <textarea name="sites" id="sites" style="width:100%;height:300"><?=$row['sites']?></textarea> 
      </td>
    </tr>
    <tr> 
      <td height="31" colspan="2" bgcolor="#FAFAF1" align="center"> <input type="submit" name="Submit" value="��������"> 
      </td>
    </tr>
  </form>
</table>
</body>
</html>
