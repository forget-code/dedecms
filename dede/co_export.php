<?
require_once(dirname(__FILE__)."/config.php");
require_once(dirname(__FILE__)."/../include/pub_collection.php");
require_once(dirname(__FILE__)."/../include/pub_dedetag.php");
require_once(dirname(__FILE__)."/../include/inc_typelink.php");
$dsql = new DedeSql(false);
$mrow = $dsql->GetOne("Select count(*) as dd From #@__courl where nid='$nid'");
$totalcc = $mrow['dd'];
$co = new DedeCollection();
$co->Init();
$co->LoadFromDB($nid);
function GetOptionArraySel($oname)
{
	global $co;
	echo "<select name='".$oname."_sel' style='width:150'>";
	echo "<option value='0'>-ʹ�ÿ�ֵ���ֵ-</option>";
	foreach($co->ArtNote as $k=>$v){
	   if($k=="sppage") continue;
	   if($oname==$k) echo "<option value='$k' selected>$k</option>\r\n";
	   else echo "<option value='$k'>$k</option>\r\n";
    }
	echo "</select>";
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�ɼ����ݵ���</title>
<link href="base.css" rel="stylesheet" type="text/css">
</head>
<body background='img/allbg.gif' leftmargin='8' topmargin='8'>
<table width="98%" border="0" cellpadding="3" cellspacing="1" bgcolor="#666666" align="center">
  <form name="form1" action="action_co_export.php" method="post" target="stafrm">
    <input type="hidden" name="nid" value="<?=$nid?>">
    <tr> 
      <td height="28" colspan="3" background='img/tbg.gif'><strong><a href="co_main.php"><u>�ɼ�����</u></a> 
        &gt; �ɼ����ݵ�����</strong></td>
    </tr>
    <tr> 
      <td height="24" colspan="3" bgcolor="#F8FCF1"><strong>�������ԣ�</strong></td>
    </tr>
    <tr> 
      <td width="37%" height="24" align="center" valign="top" bgcolor="#FFFFFF">�ĵ�����Ŀ��</td>
      <td colspan="2" bgcolor="#FFFFFF"> 
        <?
         $tl = new TypeLink(0);
         $typeOptions = $tl->GetOptionArray(0,0,1);
         echo "<select name='typeid' style='width:300'>\r\n";
         echo "<option value='0' selected>��ѡ��������...</option>\r\n";
         echo $typeOptions;
         echo "</select>";
	?>
      </td>
    </tr>
    <tr> 
      <td height="24" align="center" valign="top" bgcolor="#FFFFFF">�ĵ�����Ŀ��</td>
      <td colspan="2" bgcolor="#FFFFFF"> 
        <?
	echo "<select name='typeid2' style='width:300'>\r\n";
    echo "<option value='0' selected>��ѡ�񸱷���...</option>\r\n";
    echo $typeOptions;
    echo "</select>";
	?>
      </td>
    </tr>
    <tr> 
      <td height="24" align="center" valign="top" bgcolor="#FFFFFF">����ѡ�</td>
      <td colspan="2" bgcolor="#FFFFFF"> <input name="sendtype" type="radio" class="np" value="0" checked>
        ��ͨ�ĵ� 
        <input type="radio" name="sendtype" class="np" value="-1">
        ����Ϊ�ݸ� </td>
    </tr>
    <tr> 
      <td height="24" align="center" valign="top" bgcolor="#FFFFFF">����������</td>
      <td colspan="2" bgcolor="#FFFFFF"> <input name="nextdo" type="radio" class="np" value="-1" checked>
        �������ݺ�����ɼ����� 
        <input name="nextdo" type="radio" class="np" value="0">
        ������ </td>
    </tr>
    <tr> 
      <td height="24" align="center" valign="top" bgcolor="#FFFFFF">�޶���������<strong>��</strong>������ 
        <?=$totalcc?>
        �����ݣ�</td>
      <td colspan="2" bgcolor="#FFFFFF"><input name="maxexport" type="text" id="maxexport" value="0" size="6">
        ��ʹ�ñ�ѡ����ǿ������ѵ���Ĳɼ����ݣ������ֹ����ж�ε��룩</td>
    </tr>
    <tr> 
      <td height="24" align="center" valign="top" bgcolor="#F8FCF1"><strong>���ݿ��ڵ��ֶ�����</strong></td>
      <td width="29%" bgcolor="#F8FCF1"><strong>ʹ�òɼ���������</strong></td>
      <td width="34%" bgcolor="#F8FCF1"><strong>��ֵ����ֵ</strong></td>
    </tr>
    <tr> 
      <td height="24" align="center" valign="top" bgcolor="#FFFFFF">����(title)</td>
      <td bgcolor="#FFFFFF"> 
        <? GetOptionArraySel('title'); ?>
      </td>
      <td bgcolor="#FFFFFF"><input name="title_null" type="text" id="title_null" size="20"></td>
    </tr>
    <tr> 
      <td height="24" align="center" valign="top" bgcolor="#FFFFFF">����(writer)</td>
      <td bgcolor="#FFFFFF"> 
        <? GetOptionArraySel('writer'); ?>
      </td>
      <td bgcolor="#FFFFFF"><input name="writer_null" type="text" id="writer_null" size="20"></td>
    </tr>
    <tr> 
      <td height="24" align="center" valign="top" bgcolor="#FFFFFF">��Դ(source)</td>
      <td bgcolor="#FFFFFF"> 
        <? GetOptionArraySel('source'); ?>
      </td>
      <td bgcolor="#FFFFFF"><input name="source_null" type="text" id="source_null" size="20"></td>
    </tr>
    <tr> 
      <td height="24" align="center" valign="top" bgcolor="#FFFFFF">����ʱ��(pubdate)</td>
      <td bgcolor="#FFFFFF"> 
        <? GetOptionArraySel('pubdate'); ?>
      </td>
      <td bgcolor="#FFFFFF"><input name="pubdate_null" type="text" id="pubdate_null" size="20" value="<?=GetDateTimeMk(time())?>"></td>
    </tr>
    <tr> 
      <td height="24" align="center" valign="top" bgcolor="#FFFFFF">��������(body)</td>
      <td bgcolor="#FFFFFF"> 
        <? GetOptionArraySel('body'); ?>
      </td>
      <td bgcolor="#FFFFFF"> <textarea name="body_null" cols="20" id="body_null"></textarea></td>
    </tr>
    <tr> 
      <td height="24" colspan="3" bgcolor="#F8FCF1">&nbsp;</td>
    </tr>
    <tr> 
      <td height="34" colspan="3" align="center" bgcolor="#FFFFFF">
	  <input name="imageField" type="image" src="img/button_ok.gif" width="60" height="22" border="0" class="np">
        ������<a href="co_main.php"><img src="img/button_back.gif" width="60" height="22" border="0"></a> 
      </td>
    </tr>
  </form>
  <tr> 
    <td height="34" colspan="3" align="center" bgcolor="#E6F3CD"> <table width="100%">
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
<?
$tl->Close();
$co->Close();
$dsql->Close();
?>
<p>&nbsp;</p></body>
</html>
