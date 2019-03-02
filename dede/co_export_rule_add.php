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
	ShowMsg("成功增加一个规则!","co_export_rule.php");
	exit();
}
else if($action=="hand")
{
	 if(empty($job)) $job="";
	 if($job=="")
	 {
     require_once(dirname(__FILE__)."/../include/pub_oxwindow.php");
     $wintitle = "数据导入规则";
	   $wecome_info = "<a href='co_export_rule.php'><u>数据导入规则</u></a>::导入文本配置";
	   $win = new OxWindow();
	   $win->Init("co_export_rule_add.php","js/blank.js","POST");
	   $win->AddHidden("job","yes");
	   $win->AddHidden("action",$action);
	   $win->AddTitle("请在下面输入你要导入的文本配置：");
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
	      ShowMsg("该规则不合法，无法保存!","-1");
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
	    ShowMsg("成功导入一个规则!","co_export_rule.php");
	    exit();
   }
}
?>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
<title>新建数据导入规则</title>
<script language='javascript'>
var fieldstart = 6;
function CheckSubmit()
{
   if(document.form1.rulename.value==""){
	   alert("规则名称不能为空！");
	   document.form1.rulename.focus();
	   return false;
   }
   if(document.form1.tablename.value==""){
	   alert("导入的数据表的值不能为空！");
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
   if(endnum>50){ alert("不允许超过限定的项目!"); return; }
   for(;fieldstart<endnum;fieldstart++)
   {
      if(fieldstart>9) objField.innerHTML += "字段"+fieldstart+"： <input class='nnpp' name=\"fieldname"+fieldstart+"\" type=\"text\" size=\"15\"> 注解： <input class='nnpp' name=\"comment"+fieldstart+"\" type=\"text\" size=\"15\"> 递属表： <input class='nnpp' name=\"intable"+fieldstart+"\" type=\"text\" size=\"18\"><br>\r\n";
      else objField.innerHTML += "字段0"+fieldstart+"： <input class='nnpp' name=\"fieldname"+fieldstart+"\" type=\"text\" size=\"15\"> 注解： <input class='nnpp' name=\"comment"+fieldstart+"\" type=\"text\" size=\"15\"> 递属表： <input class='nnpp' name=\"intable"+fieldstart+"\" type=\"text\" size=\"18\"><br>\r\n";
      objField.innerHTML += "值类型： <input type='radio' class='np' name='source"+fieldstart+"' value='function'>函数 <input type='radio' class='np' name='source"+fieldstart+"' value='value'>指定值 <input type='radio' class='np' name='source"+fieldstart+"' value='export' checked>导入/采集 指定值或函数： <input name='makevalue"+fieldstart+"' type='text' size='26' class='nnpp'><hr size=1 width=80%>\r\n";
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
    <td height="19" background="img/tbg.gif"><b><a href="co_export_rule.php"><u>数据导入规则管理</u></a></b>&gt;&gt;新建数据导入规则</td>
</tr>
<tr>
    <td height="200" bgcolor="#FFFFFF" valign="top">
	<form action="co_export_rule_add.php" method="post" name="form1" onSubmit="return CheckSubmit();";>
        <input type='hidden' name='action' value='save'>
        <table width="800" border="0" cellspacing="1" cellpadding="1">
          <tr> 
            <td height="20" colspan="2" background="img/exbg.gif"><strong>&nbsp;§基本参数：</strong></td>
          </tr>
          <tr> 
            <td width="120" height="24" align="center">规则名称：</td>
            <td height="24"> <input name="rulename" type="text" id="rulename" size="36"> 
            </td>
          </tr>
          <tr>
            <td height="24" align="center">入库类型：</td>
            <td height="24"> <input name="etype" type="radio" class="np" value="当前系统" checked>
              当前系统 
              <input type="radio" name="etype" class="np" value="其它系统">
              其它系统 </td>
          </tr>
          <tr> 
            <td height="24" align="center">针对频道：</td>
            <td height="24">
			<select name="channelid" id="channelid" style="width:150">
                <option value="0">--非系统频道模型--</option>
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
            <td height="20" colspan="2" background="img/exbg.gif"><strong>&nbsp;§数据库基本参数：</strong></td>
          </tr>
          <tr> 
            <td width="120" height="24" align="center">导入的数据表：</td>
            <td><input name="tablename" type="text" id="tablename" size="30">
              （多个表用“,”分开，最多支持两个表）</td>
          </tr>
          <tr> 
            <td height="24" align="center">自动编号字段：</td>
            <td>
            	<input name="autofield" type="text" id="autofield" size="15">
            	(表示两个表关连时，第一个表的自动编号字段)
            </td>
          </tr>
          <tr> 
            <td height="24" align="center">同步字段：</td>
            <td>
            	<input name="synfield" type="text" id="synfield" size="15"> 
              （表示第二个表与第一个表的自动编号字段关连字段）
            </td>
          </tr>
        </table>
        <table width="800" border="0" cellspacing="1" cellpadding="1">
          <tr>
            <td height="20" colspan="2" background="img/exbg.gif"><strong>&nbsp;§字段设定：</strong></td>
          </tr>
          <tr> 
            <td height="20" colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
                  <td width="90%">&nbsp;&nbsp;&nbsp;&nbsp;如果选固定值，允许用{cid}表示频道ID、{typeid}栏目ID、{rank}是否审核状态（1或0），这些变量具体值可以在导出数据时选择。</td>
                </tr>
              </table></td>
          </tr>
          <tr> 
            <td height="62" colspan="2"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
                  <td width="10%" height="45" align="center">增加字段：</td>
                  <td width="90%"> <input name="fieldnum" type="text" id="fieldnum" value="5" size="8"> 
                    <input type="button" name="Submit" value="增加" onClick="addMoreField();"> 
                  </td>
                </tr>
                <tr> 
                  <td height="60">&nbsp;</td>
                  <td width="90%" align="left">字段01： 
                    <input name="fieldname1" class='nnpp' type="text" id="fieldname1" size="15">
                    注解： 
                    <input name="comment1" class='nnpp' type="text" id="comment1" size="15">
                    递属表： 
                    <input name="intable1" class='nnpp' type="text" id="intable1" size="18"> 
                    <br>
                    值类型： 
                    <input type='radio' class='np' name='source1' value='function'>
                    函数 
                    <input type='radio' class='np' name='source1' value='value'>
                    指定值 
                    <input type='radio' class='np' name='source1' value='export' checked>
                    导入/采集 指定值或函数： 
                    <input name="makevalue1" type="text" size="26" class='nnpp'> 
                    <hr size=1 width=80%>
                    字段02： 
                    <input name="fieldname2" class='nnpp' type="text" id="fieldname2" size="15">
                    注解： 
                    <input name="comment2" class='nnpp' type="text" id="comment2" size="15">
                    递属表： 
                    <input name="intable2" class='nnpp' type="text" id="intable2" size="18"> 
                    <br>
                    值类型： 
                    <input type='radio' class='np' name='source2' value='function'>
                    函数 
                    <input type='radio' class='np' name='source2' value='value'>
                    指定值 
                    <input type='radio' class='np' name='source2' value='export' checked>
                    导入/采集 指定值或函数： 
                    <input name="makevalue2" type="text" size="26" class='nnpp'> 
                    <hr size=1 width=80%>
                    字段03： 
                    <input name="fieldname3" class='nnpp' type="text" id="fieldname3" size="15">
                    注解： 
                    <input name="comment3" class='nnpp' type="text" id="comment3" size="15">
                    递属表： 
                    <input name="intable3" class='nnpp' type="text" id="intable3" size="18"> 
                    <br>
                    值类型： 
                    <input type='radio' class='np' name='source3' value='function'>
                    函数 
                    <input type='radio' class='np' name='source3' value='value'>
                    指定值 
                    <input type='radio' class='np' name='source3' value='export' checked>
                    导入/采集 指定值或函数： 
                    <input name="makevalue3" type="text" size="26" class='nnpp'> 
                    <hr size=1 width=80%>
                    字段04： 
                    <input name="fieldname4" class='nnpp' type="text" id="fieldname4" size="15">
                    注解： 
                    <input name="comment4" class='nnpp' type="text" id="comment4" size="15">
                    递属表： 
                    <input name="intable4" class='nnpp' type="text" id="intable4" size="18"> 
                    <br>
                    值类型： 
                    <input type='radio' class='np' name='source4' value='function'>
                    函数 
                    <input type='radio' class='np' name='source4' value='value'>
                    指定值 
                    <input type='radio' class='np' name='source4' value='export' checked>
                    导入/采集 指定值或函数： 
                    <input name="makevalue4" type="text" size="26" class='nnpp'> 
                    <hr size=1 width=80%>
                    字段05： 
                    <input name="fieldname5" class='nnpp' type="text" id="fieldname5" size="15">
                    注解： 
                    <input name="comment5" class='nnpp' type="text" id="comment5" size="15">
                    递属表： 
                    <input name="intable5" class='nnpp' type="text" id="intable5" size="18"> 
                    <br>
                    值类型： 
                    <input type='radio' class='np' name='source5' value='function'>
                    函数 
                    <input type='radio' class='np' name='source5' value='value'>
                    指定值 
                    <input type='radio' class='np' name='source5' value='export' checked>
                    导入/采集 指定值或函数： 
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