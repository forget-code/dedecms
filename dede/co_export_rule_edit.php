<?
require(dirname(__FILE__)."/config.php");
CheckPurview('co_NewRule');
if(empty($action)) $action = "";
$aid = ereg_replace("[^0-9]","",$aid);
if(empty($aid)){
   ShowMsg("������Ч!","-1");
   exit();
}
//----------------------------
//�¼���������
//----------------------------
if($action=="save")
{
	$notes = "
{dede:note 
  rulename=\\'$rulename\\'
  etype=\\'$etype\\'
  tablename=\\'$tablename\\'
  autofield=\\'$autofield\\'
  synfield=\\'$synfield\\'
  channelid=\\'$channelid\\'
/}
	";
	for($i=1;$i<=50;$i++)
	{
		if( !isset(${"fieldname".$i}) ) break;
		$fieldname = ${"fieldname".$i};
		$comment = ${"comment".$i};
		$intable = ${"intable".$i};
		$source = ${"source".$i};
		$makevalue = ${"makevalue".$i};
		$notes .= "{dede:field name=\\'$fieldname\\' comment=\\'$comment\\' intable=\\'$intable\\' source=\\'$source\\'}$makevalue{/dede:field}\r\n";
	}
	$query = "
	update #@__co_exrule set 
	channelid = '$channelid',
	rulename='$rulename',
	etype='$etype',
	dtime='".mytime()."',
	ruleset='$notes'
	where aid='$aid'
	";
	$dsql = new DedeSql(false);
	$dsql->ExecuteNoneQuery($query);
	$dsql->Close();
	ShowMsg("�ɹ�����һ������!","co_export_rule.php");
	exit();
}
else if($action=="delete")
{
   if(empty($job)) $job="";
   if($job=="") //ȷ����ʾ
   {
  	 require_once(dirname(__FILE__)."/../include/pub_oxwindow.php");
  	 $wintitle = "ɾ�����ݹ���ģ��";
	   $wecome_info = "<a href='co_export_rule.php'><u>���ݹ���ģ��</u></a>::ɾ������";
	   $win = new OxWindow();
	   $win->Init("co_export_rule_edit.php","js/blank.js","POST");
	   $win->AddHidden("job","yes");
	   $win->AddHidden("action",$action);
	   $win->AddHidden("aid",$aid);
	   $win->AddTitle("��ȷʵҪɾ��[{$aid}]�������");
	   $winform = $win->GetWindow("ok");
	   $win->Display();
   }
   else if($job=="yes") //����
   {
   	 $dsql = new DedeSql(false);
	   $dsql->ExecuteNoneQuery("Delete From #@__co_exrule where aid='$aid'");
	   $dsql->Close();
	   ShowMsg("�ɹ�ɾ��һ������!","co_export_rule.php");
	   exit();
   }
   exit();
}
else if($action=="export")
{
   $dsql = new DedeSql(false);
   $row = $dsql->GetOne("Select * From #@__co_exrule where aid='$aid'");
   $dsql->Close();
   require_once(dirname(__FILE__)."/../include/pub_oxwindow.php");
   $wintitle = "ɾ�����ݹ���ģ��";
	 $wecome_info = "<a href='co_export_rule.php'><u>���ݹ���ģ��</u></a>::������������";
	 $win = new OxWindow();
	 $win->Init();
	 $win->AddTitle("����Ϊ����[{$aid}]���ı����ã�����Թ����������ѣ�");
	 $winform = $win->GetWindow("hand","<textarea name='cg' style='width:100%;height:300'>".$row['ruleset']."</textarea><br/><br/>");
	 $win->Display();
   exit();
}
////////////////////////////////
require_once(dirname(__FILE__)."/../include/pub_dedetag.php");
$dsql = new DedeSql(false);
$row = $dsql->GetOne("Select * From #@__co_exrule where aid='$aid'");
$dsql->Close();
$ruleset = $row['ruleset'];
$channelid = $row['channelid'];
$dtp = new DedeTagParse();
$dtp->LoadString($ruleset);
$noteid = 0;
if(is_array($dtp->CTags))
{
	foreach($dtp->CTags as $ctag){
		if($ctag->GetName()=='field') $noteid++;
	}
}
else
{
	ShowMsg("�ù��򲻺Ϸ����޷����и���!","-1");
	$dsql->Close();
	exit();
}
$noteinfos = $dtp->GetTagByName("note");
?>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
<title>���ݹ���ģ��</title>
<script language='javascript'>
var fieldstart = <?=($noteid+1)?>;
function CheckSubmit()
{
   if(document.form1.rulename.value==""){
	   alert("�������Ʋ���Ϊ�գ�");
	   document.form1.rulename.focus();
	   return false;
   }
   if(document.form1.tablename.value==""){
	   alert("��������ݱ��ֵ����Ϊ�գ�");
	   document.form1.tablename.focus();
	   return false;
   }
   return true;
}
function addMoreField()
{
   var objFieldNum = document.getElementById("fieldnum");
   var objField = document.getElementById("morefield");
   var addvalue = Number(objFieldNum.value);
   var endnum = fieldstart + addvalue;
   if(endnum>50){ alert("���������޶�����Ŀ!"); return; }
   for(;fieldstart<endnum;fieldstart++)
   {
      if(fieldstart>9) objField.innerHTML += "�ֶ�"+fieldstart+"�� <input class='nnpp' name=\"fieldname"+fieldstart+"\" type=\"text\" size=\"15\"> ע�⣺ <input class='nnpp' name=\"comment"+fieldstart+"\" type=\"text\" size=\"15\"> ������ <input class='nnpp' name=\"intable"+fieldstart+"\" type=\"text\" size=\"18\"><br>\r\n";
      else objField.innerHTML += "�ֶ�0"+fieldstart+"�� <input class='nnpp' name=\"fieldname"+fieldstart+"\" type=\"text\" size=\"15\"> ע�⣺ <input class='nnpp' name=\"comment"+fieldstart+"\" type=\"text\" size=\"15\"> ������ <input class='nnpp' name=\"intable"+fieldstart+"\" type=\"text\" size=\"18\"><br>\r\n";
      objField.innerHTML += "ֵ���ͣ� <input type='radio' class='np' name='source"+fieldstart+"' value='function'>���� <input type='radio' class='np' name='source"+fieldstart+"' value='value'>ָ��ֵ <input type='radio' class='np' name='source"+fieldstart+"' value='export' checked>����/�ɼ� ָ��ֵ������ <input name='makevalue"+fieldstart+"' type='text' size='26' class='nnpp'><hr size=1 width=80%>\r\n";
   }
   
}
</script>
<link href='base.css' rel='stylesheet' type='text/css'>
<style>
	.nnpp{
	border-bottom:1px solid #666666;
	border-top:1px solid #FFFFFF;
	border-left:1px solid #FFFFFF;
	border-right:1px solid #FFFFFF;
	color:red;
	filter:alpha(opacity=70);
 }
</style>
</head>
<body background='img/allbg.gif' leftmargin='8' topmargin='8'>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#666666">
  <tr>
    <td height="19" background="img/tbg.gif"><b><a href="co_export_rule.php"><u>���ݹ���ģ�͹���</u></a></b>&gt;&gt;�޸ĵ������</td>
</tr>
<tr>
    <td height="200" bgcolor="#FFFFFF" valign="top">
	<form action="co_export_rule_edit.php" method="post" name="form1" onSubmit="return CheckSubmit();";>
        <input type='hidden' name='action' value='save'>
        <input type='hidden' name='aid' value='<?=$aid?>'>
        <table width="800" border="0" cellspacing="1" cellpadding="1">
          <tr> 
            <td height="20" colspan="2" background="img/exbg.gif"><strong>&nbsp;�����������</strong></td>
          </tr>
          <tr> 
            <td width="120" height="24" align="center">�������ƣ�</td>
            <td height="24"> 
              <input name="rulename" type="text" id="rulename" size="36" value="<?=$noteinfos->GetAtt('rulename')?>">
            </td>
          </tr>
          <tr> 
            <td height="24" align="center">������ͣ�</td>
            <td height="24">
			<input name="etype" type="radio" class="np" value="��ǰϵͳ"<? if($noteinfos->GetAtt('etype')=='��ǰϵͳ') echo " checked";?>>
             ��ǰϵͳ 
            <input type="radio" name="etype" class="np" value="����ϵͳ"<? if($noteinfos->GetAtt('etype')=='����ϵͳ') echo " checked";?>>
             ����ϵͳ
			</td>
          </tr>
          <tr> 
            <td height="24" align="center">���Ƶ����</td>
            <td height="24">
			<select name="channelid" id="channelid" style="width:150">
                <option value="0">--��ϵͳƵ��ģ��--</option>
				<?
				$dsql = new DedeSql(false);
				$dsql->SetQuery("Select ID,typename From #@__channeltype where ID>0 order by ID asc");
				$dsql->Execute();
				while($row = $dsql->GetObject()){
				   if($channelid==$row->ID) echo "<option value='{$row->ID}' selected>{$row->typename}</option>\r\n";
				   else  echo "<option value='{$row->ID}'>{$row->typename}</option>\r\n";
				}
				$dsql->Close();
				?>
              </select>
			</td>
          </tr>
        </table>
        <table width="800" border="0" cellspacing="1" cellpadding="1">
          <tr> 
            <td height="20" colspan="2" background="img/exbg.gif"><strong>&nbsp;�����ݿ����������</strong></td>
          </tr>
          <tr> 
            <td width="120" height="24" align="center">��������ݱ�</td>
            <td><input name="tablename" type="text" id="tablename" size="30" value="<?=$noteinfos->GetAtt('tablename')?>">
              ��������á�,���ֿ������֧��������</td>
          </tr>
          <tr> 
            <td height="24" align="center">�Զ�����ֶΣ�</td>
            <td>
            	<input name="autofield" type="text" id="autofield" size="15" value="<?=$noteinfos->GetAtt('autofield')?>">
              (��ʾ���������ʱ����һ������Զ�����ֶ�)
            </td>
          </tr>
          <tr> 
            <td height="24" align="center">���ͬ���ֶΣ�</td>
            <td>
            	<input name="synfield" type="text" id="synfield" size="15" value="<?=$noteinfos->GetAtt('synfield')?>">
              ����ʾ�ڶ��������һ������Զ�����ֶι����ֶΣ�
             </td>
          </tr>
        </table>
        <table width="800" border="0" cellspacing="1" cellpadding="1">
          <tr> 
            <td width="120" height="20" colspan="2" background="img/exbg.gif"><strong>&nbsp;���ֶ��趨��</strong></td>
          </tr>
          <tr> 
            <td height="62" colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
                  <td width="10%" height="45" align="center">�����ֶΣ�</td>
                  <td width="90%"> <input name="fieldnum" type="text" id="fieldnum" value="5" size="8"> 
                    <input type="button" name="Submit" value="����" onClick="addMoreField();"> 
                  </td>
                </tr>
                <tr> 
                  <td height="60">&nbsp;</td>
                  <td width="90%" align="left">
                  	<?
                  	if(is_array($dtp->CTags))
                    {
	                     $s = 0;
	                     foreach($dtp->CTags as $ctag){
		                      if($ctag->GetName()=='field')
		                      {
		                          $s++;
		                          if($s<10) $ss="0".$s;
		                          else $ss=$s;
		                          $c1="";
		                          $c2="";
		                          $c3="";
		                          if($ctag->GetAtt('source')=='function') $c1=" checked";
		                          else if($ctag->GetAtt('source')=='value') $c2=" checked";
		                          else  $c3=" checked";
		                          $line="
		                          �ֶ�{$ss}�� 
                    <input class='nnpp' name='fieldname{$s}' type='text' value='".$ctag->GetAtt('name')."' size='15'>
                    ע�⣺ 
                    <input class='nnpp' name='comment{$s}' type='text' value='".$ctag->GetAtt('comment')."' size='15'>
                    ������ 
                    <input class='nnpp' name='intable{$s}' type='text' value='".$ctag->GetAtt('intable')."' size='18'> 
                    <br>
                    ֵ���ͣ�
                  <input type='radio' class='np' name='source{$s}' value='function'{$c1}>����
                  <input type='radio' class='np' name='source{$s}' value='value'{$c2}>ָ��ֵ
                  <input type='radio' class='np' name='source{$s}' value='export'{$c3}>����/�ɼ�
                  ָ��ֵ������
                  <textarea class='nnpp' rows='1' cols='26' name='makevalue{$s}'>".$ctag->GetInnerText()."</textarea>
                  <hr size=1 width=80%>\r\n";
		                          echo $line;
		                      }
		                   }
                    }
                    
                    ?>
                    <span id='morefield'></span>
                    </td>
                </tr>
              </table> </td>
          </tr>
        </table>
        <table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td bgcolor="#CCCCCC" height="1"></td>
          </tr>
          <tr> 
            <td height="80"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="10%">&nbsp;</td>
                  <td width="90%">
				  <input name="imageField" class="np" type="image" src="img/button_save.gif" width="60" height="22" border="0">
                    �� 
                   <img class="np" src="img/button_reset.gif" width="60" height="22" border="0" style="cursor:hand" onClick="form1.reset();">
				  </td>
                </tr>
              </table></td>
          </tr>
        </table>
      </form>
    </td>
</tr>
</table>
</body>
</html>