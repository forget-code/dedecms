<?
require_once(dirname(__FILE__)."/config.php");
require_once(dirname(__FILE__)."/../include/inc_typeunit_admin.php");
$ID = trim(ereg_replace("[^0-9]","",$ID));

//���Ȩ�����
CheckPurview('t_Del,t_AccDel');
//�����Ŀ�������
CheckCatalog($ID,"����Ȩɾ������Ŀ��");

if(empty($dopost)) $dopost="";
if($dopost=="ok"){
	 $ut = new TypeUnit();
	 $ut->DelType($ID,$delfile);
	 $ut->Close();
	 ShowMsg("�ɹ�ɾ��һ����Ŀ��","catalog_main.php");
	 exit();
}
?>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
<title>ɾ����Ŀ</title>
<link href='base.css' rel='stylesheet' type='text/css'>
<script src='menu.js' language='JavaScript'></script>
</head>
<body background='img/allbg.gif' leftmargin='8' topmargin='8'>
<table width="98%" border="0" cellpadding="3" cellspacing="1" bgcolor="#666666">
  <tr> 
    <td height="19" background='img/tbg.gif'><a href="catalog_main.php"><u>��Ŀ����</u></a>&gt;&gt;ɾ����Ŀ</td>
  </tr>
  <tr> 
    <td height="60" align="center" bgcolor="#FFFFFF"> 
      <table width="96%" border="0" cellspacing="0" cellpadding="0">
        <form name="form1" action="catalog_del.php" method="post">
          <input type="hidden" name="ID" value="<?=$ID?>">
          <input type="hidden" name="dopost" value="ok">
          <tr> 
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr> 
            <td colspan="2">��Ҫɾ����Ŀ�� 
              <?=$typeoldname?>
            </td>
          </tr>
          <tr> 
            <td colspan="2">��Ŀ���ļ�����Ŀ¼�� 
              <?
              $dsql = new DedeSql();
              $dsql->SetQuery("Select typedir From #@__arctype where ID=".$ID);
              $row = $dsql->GetOne();
              $dsql->Close();
              echo $row["typedir"];
              ?>
            </td>
          </tr>
          <tr> 
            <td width="42%" height="36">�Ƿ�ɾ���ļ��� 
              <input type="radio" name="delfile" class="np" value="no" checked>
              �� &nbsp;&nbsp; <input type="radio" name="delfile" class="np" value="yes">
              �� </td>
            <td width="58%" height="36"><input type="button" name="Submit" value=" ȷ�� " onClick="javascript:document.form1.submit();"> 
              &nbsp; <input type="button" name="Submit2" value=" ���� " onClick="javascript:location.href='catalog_main.php';"> 
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
