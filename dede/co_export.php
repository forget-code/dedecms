<?php 
require_once(dirname(__FILE__)."/config.php");
CheckPurview('co_Export');
require_once(dirname(__FILE__)."/../include/pub_collection.php");
require_once(dirname(__FILE__)."/../include/pub_dedetag.php");
require_once(dirname(__FILE__)."/inc/inc_catalog_options.php");
$dsql = new DedeSql(false);
$mrow = $dsql->GetOne("Select count(*) as dd From #@__courl where nid='$nid'");
$totalcc = $mrow['dd'];
$rrow = $dsql->GetOne("Select typeid From #@__conote where nid='$nid'");
$ruleid = $rrow['typeid'];
$rrow = $dsql->GetOne("Select channelid From #@__co_exrule where aid='$ruleid'");
$channelid = $rrow['channelid'];
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link href="base.css" rel="stylesheet" type="text/css">
<script language='javascript' src='main.js'></script>
<title>�ɼ����ݵ���</title>
</head>
<body background='img/allbg.gif' leftmargin='8' topmargin='8'>
<table width="98%" border="0" cellpadding="3" cellspacing="1" bgcolor="#98CAEF" align="center">
  <form name="form1" action="co_export_action.php" method="get" target="stafrm">
    <input type="hidden" name="nid" value="<?php echo $nid?>">
    <input type="hidden" name="totalcc" value="<?php echo $totalcc?>">
    <input type="hidden" name="channelid" value="<?php echo $channelid?>">
    <input type="hidden" name="ruleid" value="<?php echo $ruleid?>">
    <tr> 
      <td height="28" colspan="3" background='img/tbg.gif'><strong><a href="co_main.php"><u>�ɼ�����</u></a> 
        &gt; �ɼ����ݵ�����</strong></td>
    </tr>
    <tr> 
      <td height="24" colspan="3" bgcolor="#F8FCF1">
      	<strong>���ڵ㹲�� <?php echo $totalcc?>�����ݣ�</strong>
      </td>
    </tr>
    <?php 
    if($channelid>0)
    {
    ?>
    <tr> 
      <td width="26%" height="24" align="center" valign="top" bgcolor="#FFFFFF">������Ŀ��</td>
      <td width="74%" colspan="2" bgcolor="#FFFFFF"> 
        <?php echo GetTypeidSel('form1','typeid','selbt2',$channelid)?>
      </td>
    </tr>
    <tr> 
      <td height="24" align="center" valign="top" bgcolor="#FFFFFF">����ѡ�</td>
      <td colspan="2" bgcolor="#FFFFFF">
      	<input name="arcrank" type="radio" class="np" value="0" checked>
        ��ͨ�ĵ� 
        <input name="arcrank" type="radio" class="np" value="-1">
        ����Ϊ�ݸ� 
        </td>
    </tr>
    <?php  } ?>
    <tr> 
      <td height="24" align="center" valign="top" bgcolor="#FFFFFF">ÿ�����룺</td>
      <td colspan="2" bgcolor="#FFFFFF">
      	<input name="pagesize" type="text" id="pagesize" value="30" size="6">
      </td>
    </tr>
    <tr> 
      <td height="24" align="center" valign="top" bgcolor="#FFFFFF">����ѡ�</td>
      <td colspan="2" bgcolor="#FFFFFF">
      	<input name="onlytitle" type="checkbox" id="onlytitle" value="1" class="np">
        �ų��ظ�����
        <input name="makehtml" type="checkbox" id="makehtml" value="1" class="np">
        ��ɺ��Զ����ɵ�������HTML
      </td>
    </tr>
    <tr> 
      <td height="24" colspan="3" bgcolor="#F8FCF1">&nbsp;</td>
    </tr>
    <tr> 
      <td height="34" colspan="3" align="center" bgcolor="#FFFFFF">
      	<input name="imageField" type="image" src="img/button_ok.gif" width="60" height="22" border="0" class="np">
		&nbsp;
        <a href="co_main.php"><img src="img/button_back.gif" width="60" height="22" border="0"></a> 
      </td>
    </tr>
  </form>
  <tr> 
    <td height="34" colspan="3" align="center" bgcolor="#E5F9FF"> <table width="100%">
        <tr> 
          <td width="74%">����״̬�� </td>
          <td width="26%" align="right"> <script language='javascript'>
            	function ResizeDiv(obj,ty)
            	{
            		if(ty=="+") document.all[obj].style.pixelHeight += 50;
            		else if(document.all[obj].style.pixelHeight>80) document.all[obj].style.pixelHeight = document.all[obj].style.pixelHeight - 50;
            	}
            	</script>
            [<a href='#' onClick="ResizeDiv('mdv','+');">����</a>] [<a href='#' onClick="ResizeDiv('mdv','-');">��С</a>] 
          </td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td height="34" colspan="3" bgcolor="#FFFFFF" id="mtd"> <div id='mdv' style='width:100%;height:100;'> 
        <iframe name="stafrm" frameborder="0" id="stafrm" width="100%" height="100%"></iframe>
      </div>
      <script language="JavaScript">
	  document.all.mdv.style.pixelHeight = screen.height/3;
	  </script> </td>
  </tr>
</table>
<?php 
$dsql->Close();
?>
<p>&nbsp;</p></body>
</html>
