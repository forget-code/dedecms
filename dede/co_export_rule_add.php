<?
require(dirname(__FILE__)."/config.php");
CheckPurview('co_NewRule');
if(empty($action)) $action = "";
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
	Insert Into #@__co_exrule(channelid,rulename,etype,dtime,ruleset)
	Values('$channelid','$rulename','$etype','".mytime()."','$notes')
	";
	$dsql = new DedeSql(false);
	$dsql->ExecuteNoneQuery($query);
	$dsql->Close();
	ShowMsg("�ɹ�����һ������!","co_export_rule.php");
	exit();
}
else if($action=="hand")
{
	 if(empty($job)) $job="";
	 if($job=="")
	 {
     require_once(dirname(__FILE__)."/../include/pub_oxwindow.php");
     $wintitle = "���ݵ������";
	   $wecome_info = "<a href='co_export_rule.php'><u>���ݵ������</u></a>::�����ı�����";
	   $win = new OxWindow();
	   $win->Init("co_export_rule_add.php","js/blank.js","POST");
	   $win->AddHidden("job","yes");
	   $win->AddHidden("action",$action);
	   $win->AddTitle("��������������Ҫ������ı����ã�");
	   $win->AddMsgItem("<textarea name='notes' style='width:100%;height:300'></textarea>");
	   $winform = $win->GetWindow("ok");
	   $win->Display();
     exit();
   }
   else
   {
   	  require_once(dirname(__FILE__)."/../include/pub_dedetag.php");
   	  $dtp = new DedeTagParse();
   	  $dbnotes = $notes;
   	  $notes = stripslashes($notes);
      $dtp->LoadString($notes);
   	  if(!is_array($dtp->CTags))
      {
	      ShowMsg("�ù��򲻺Ϸ����޷�����!","-1");
	      $dsql->Close();
	      exit();
      }
      $noteinfos = $dtp->GetTagByName("note");
	    $query = "
	        Insert Into #@__co_exrule(channelid,rulename,etype,dtime,ruleset)
	        Values('".$noteinfos->GetAtt('channelid')."','".$noteinfos->GetAtt('rulename')."','".$noteinfos->GetAtt('etype')."','".mytime()."','$dbnotes')
	    ";
	    $dsql = new DedeSql(false);
	    $dsql->ExecuteNoneQuery($query);
	    $dsql->Close();
	    ShowMsg("�ɹ�����һ������!","co_export_rule.php");
	    exit();
   }
}
?>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
<title>�½����ݵ������</title>
<script language='javascript'>
var fieldstart = 6;
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
    <td height="19" background="img/tbg.gif"><b><a href="co_export_rule.php"><u>���ݵ���������</u></a></b>&gt;&gt;�½����ݵ������</td>
</tr>
<tr>
    <td height="200" bgcolor="#FFFFFF" valign="top">
	<form action="co_export_rule_add.php" method="post" name="form1" onSubmit="return CheckSubmit();";>
        <input type='hidden' name='action' value='save'>
        <table width="800" border="0" cellspacing="1" cellpadding="1">
          <tr> 
            <td height="20" colspan="2" background="img/exbg.gif"><strong>&nbsp;�����������</strong></td>
          </tr>
          <tr> 
            <td width="120" height="24" align="center">�������ƣ�</td>
            <td height="24"> <input name="rulename" type="text" id="rulename" size="36"> 
            </td>
          </tr>
          <tr>
            <td height="24" align="center">������ͣ�</td>
            <td height="24"> <input name="etype" type="radio" class="np" value="��ǰϵͳ" checked>
              ��ǰϵͳ 
              <input type="radio" name="etype" class="np" value="����ϵͳ">
              ����ϵͳ </td>
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
				   echo "<option value='{$row->ID}'>{$row->typename}</option>\r\n";
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
            <td><input name="tablename" type="text" id="tablename" size="30">
              ��������á�,���ֿ������֧��������</td>
          </tr>
          <tr> 
            <td height="24" align="center">�Զ�����ֶΣ�</td>
            <td>
            	<input name="autofield" type="text" id="autofield" size="15">
            	(��ʾ���������ʱ����һ������Զ�����ֶ�)
            </td>
          </tr>
          <tr> 
            <td height="24" align="center">ͬ���ֶΣ�</td>
            <td>
            	<input name="synfield" type="text" id="synfield" size="15"> 
              ����ʾ�ڶ��������һ������Զ�����ֶι����ֶΣ�
            </td>
          </tr>
        </table>
        <table width="800" border="0" cellspacing="1" cellpadding="1">
          <tr>
            <td height="20" colspan="2" background="img/exbg.gif"><strong>&nbsp;���ֶ��趨��</strong></td>
          </tr>
          <tr> 
            <td height="20" colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
                  <td width="90%">&nbsp;&nbsp;&nbsp;&nbsp;���ѡ�̶�ֵ��������{cid}��ʾƵ��ID��{typeid}��ĿID��{rank}�Ƿ����״̬��1��0������Щ��������ֵ�����ڵ�������ʱѡ��</td>
                </tr>
              </table></td>
          </tr>
          <tr> 
            <td height="62" colspan="2"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
                  <td width="10%" height="45" align="center">�����ֶΣ�</td>
                  <td width="90%"> <input name="fieldnum" type="text" id="fieldnum" value="5" size="8"> 
                    <input type="button" name="Submit" value="����" onClick="addMoreField();"> 
                  </td>
                </tr>
                <tr> 
                  <td height="60">&nbsp;</td>
                  <td width="90%" align="left">�ֶ�01�� 
                    <input name="fieldname1" class='nnpp' type="text" id="fieldname1" size="15">
                    ע�⣺ 
                    <input name="comment1" class='nnpp' type="text" id="comment1" size="15">
                    ������ 
                    <input name="intable1" class='nnpp' type="text" id="intable1" size="18"> 
                    <br>
                    ֵ���ͣ� 
                    <input type='radio' class='np' name='source1' value='function'>
                    ���� 
                    <input type='radio' class='np' name='source1' value='value'>
                    ָ��ֵ 
                    <input type='radio' class='np' name='source1' value='export' checked>
                    ����/�ɼ� ָ��ֵ������ 
                    <input name="makevalue1" type="text" size="26" class='nnpp'> 
                    <hr size=1 width=80%>
                    �ֶ�02�� 
                    <input name="fieldname2" class='nnpp' type="text" id="fieldname2" size="15">
                    ע�⣺ 
                    <input name="comment2" class='nnpp' type="text" id="comment2" size="15">
                    ������ 
                    <input name="intable2" class='nnpp' type="text" id="intable2" size="18"> 
                    <br>
                    ֵ���ͣ� 
                    <input type='radio' class='np' name='source2' value='function'>
                    ���� 
                    <input type='radio' class='np' name='source2' value='value'>
                    ָ��ֵ 
                    <input type='radio' class='np' name='source2' value='export' checked>
                    ����/�ɼ� ָ��ֵ������ 
                    <input name="makevalue2" type="text" size="26" class='nnpp'> 
                    <hr size=1 width=80%>
                    �ֶ�03�� 
                    <input name="fieldname3" class='nnpp' type="text" id="fieldname3" size="15">
                    ע�⣺ 
                    <input name="comment3" class='nnpp' type="text" id="comment3" size="15">
                    ������ 
                    <input name="intable3" class='nnpp' type="text" id="intable3" size="18"> 
                    <br>
                    ֵ���ͣ� 
                    <input type='radio' class='np' name='source3' value='function'>
                    ���� 
                    <input type='radio' class='np' name='source3' value='value'>
                    ָ��ֵ 
                    <input type='radio' class='np' name='source3' value='export' checked>
                    ����/�ɼ� ָ��ֵ������ 
                    <input name="makevalue3" type="text" size="26" class='nnpp'> 
                    <hr size=1 width=80%>
                    �ֶ�04�� 
                    <input name="fieldname4" class='nnpp' type="text" id="fieldname4" size="15">
                    ע�⣺ 
                    <input name="comment4" class='nnpp' type="text" id="comment4" size="15">
                    ������ 
                    <input name="intable4" class='nnpp' type="text" id="intable4" size="18"> 
                    <br>
                    ֵ���ͣ� 
                    <input type='radio' class='np' name='source4' value='function'>
                    ���� 
                    <input type='radio' class='np' name='source4' value='value'>
                    ָ��ֵ 
                    <input type='radio' class='np' name='source4' value='export' checked>
                    ����/�ɼ� ָ��ֵ������ 
                    <input name="makevalue4" type="text" size="26" class='nnpp'> 
                    <hr size=1 width=80%>
                    �ֶ�05�� 
                    <input name="fieldname5" class='nnpp' type="text" id="fieldname5" size="15">
                    ע�⣺ 
                    <input name="comment5" class='nnpp' type="text" id="comment5" size="15">
                    ������ 
                    <input name="intable5" class='nnpp' type="text" id="intable5" size="18"> 
                    <br>
                    ֵ���ͣ� 
                    <input type='radio' class='np' name='source5' value='function'>
                    ���� 
                    <input type='radio' class='np' name='source5' value='value'>
                    ָ��ֵ 
                    <input type='radio' class='np' name='source5' value='export' checked>
                    ����/�ɼ� ָ��ֵ������ 
                    <input name="makevalue5" type="text" size="26" class='nnpp'> 
                    <hr size=1 width=80%> <span id='morefield'></span> </td>
                </tr>
              </table></td>
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