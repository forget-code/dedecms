<?
require_once(dirname(__FILE__)."/config.php");
require_once(dirname(__FILE__)."/../include/pub_dedetag.php");
require_once(dirname(__FILE__)."/../include/inc_typelink.php");
if($nid=="") 
{
	ShowMsg("������Ч!","-1");	
	exit();
}
$dsql = new DedeSql(false);
$dsql->SetSql("Select * from #@__conote where nid='$nid'");
$dsql->Execute();
$rowFirst = $dsql->GetObject();
$gathername = $rowFirst->gathername;
$typeid = $rowFirst->typeid;
$noteinfo = $rowFirst->noteinfo;
$language = $rowFirst->language;
$pos = strpos($noteinfo,"{dede:comments}",strlen("{dede:comments}"));
$headinfo = substr($noteinfo,0,$pos);
$otherinfo = substr($noteinfo,$pos,strlen($noteinfo)-$pos);
$otherinfo = eregi_replace("<textarea","< textarea",$otherinfo);
$otherinfo = eregi_replace("</textarea","< /textarea",$otherinfo);
$otherinfo = eregi_replace("<form","< form",$otherinfo);
$otherinfo = eregi_replace("</form","< /form",$otherinfo);
$dsql->FreeResult();

$dtp = new DedeTagParse();
$dtp->SetNameSpace("dede","{","}");
$dtp->LoadString($headinfo);
$ctag = $dtp->GetTag("item");
$dtp->Clear();

$imgurl = $ctag->GetAtt("imgurl");
$imgdir = $ctag->GetAtt("imgdir");


?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�ɼ��ڵ����</title>
<link href="base.css" rel="stylesheet" type="text/css">
</head>
<body background='img/allbg.gif' leftmargin='8' topmargin='8'>
<table width="98%" border="0" cellpadding="3" cellspacing="1" bgcolor="#666666" align="center">
  <form name="form1" action="action_co_edit.php" method="post">
  	<input type="hidden" name="nid" value="<?=$nid?>">
  <tr> 
    <td height="20" background='img/tbg.gif'> <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr> 
          <td width="37%" height="18"><strong>���Ĳɼ��ڵ㣺</strong></td>
          <td width="63%" align="right">&nbsp;<input type="button" name="b11" value="���زɼ��ڵ����ҳ" class="np2" style="width:160" onClick="location.href='co_main.php';"></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td height="24" bgcolor="#F2F6E5"><table width="400" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="26" align="center"><img src="img/file_tt.gif" width="7" height="8"></td>
          <td width="374">�ڵ������Ϣ</td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td height="94" bgcolor="#FFFFFF">
	<table width="98%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="18%" height="24">�ڵ����ƣ�</td>
            <td width="32%"><input name="notename" value="<?=$gathername?>" type="text" id="notename" style="width:150"></td>
            <td width="18%">ҳ����룺</td>
            <td width="32%">
            	<input type="radio" name="language" class="np" value="gb2312"<? if($language=="gb2312") echo " checked"; ?>>
              GB2312 
              <input type="radio" name="language" class="np" value="utf-8"<? if($language=="utf-8") echo " checked"; ?>>
              UTF8 
              <input type="radio" name="language" class="np" value="big5"<? if($language=="big5") echo " checked"; ?>>
              BIG5 </td>
          </tr>
          <tr> 
            <td height="24">ͼƬ�����ַ��</td>
            <td><input name="imgurl" value="<?=$imgurl?>" type="text" id="imgurl" style="width:150"></td>
            <td>����·����</td>
            <td><input name="imgdir"  value="<?=$imgdir?>" type="text" id="imgdir" style="width:150"></td>
          </tr>
          <tr> 
            <td height="24">��������ID��</td>
            <td colspan="3"> 
              <?
       if(empty($typeid)) $typeid="0";
       $tl = new TypeLink($typeid);
       $typeOptions = $tl->GetOptionArray($typeid,$cuserLogin->getUserChannel(),1);
       echo "<select name='typeid' style='width:200'>\r\n";
       if($typeid=="0") echo "<option value='0' selected>��ѡ�����...</option>\r\n";
       echo $typeOptions;
       echo "</select>";
	   $tl->Close();
		?>
            </td>
          </tr>
        </table></td>
  </tr>
  <tr>
    <td height="24" bgcolor="#F2F6E5">
    	<table width="400" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="26" align="center"><img src="img/file_tt.gif" width="7" height="8"></td>
          <td width="374">��������</td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td height="360" bgcolor="#FFFFFF" align="center">
	<textarea name="otherconfig" id="otherconfig" style="width:96%;height:350"><?=$otherinfo?></textarea>
	</td>
  </tr>
  <tr> 
    <td height="36" bgcolor="#FAFAF1">
    	<table width="400" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="26" align="center">&nbsp;</td>
          <td width="374"><input type="submit" name="b12" value="�������" class="coolbg" style="width:80"></td>
        </tr>
      </table></td>
  </tr>
</form>
</table>
</body>
</html>
<?
$dsql->Close();
?>
