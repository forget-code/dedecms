<?php 
require_once(dirname(__FILE__)."/config.php");
require_once(dirname(__FILE__)."/../include/inc_typelink.php");
$dsql = new DedeSql(false);
?>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
<title>���������б�</title>
<link href='base.css' rel='stylesheet' type='text/css'>
<script src="main.js" language="javascript"></script>
<script language="JavaScript">
function ChangeListStyle(){
   var itxt = document.getElementById("myinnertext");
   var myems = document.getElementsByName("liststyle");
   if(myems[0].checked) itxt.value = document.getElementById("list1").innerHTML;
   else if(myems[1].checked) itxt.value = document.getElementById("list2").innerHTML;
   else if(myems[2].checked) itxt.value = document.getElementById("list3").innerHTML;
   else if(myems[3].checked) itxt.value = document.getElementById("list4").innerHTML;
   itxt.value = itxt.value.replace("<BR>","<BR/>");
   itxt.value = itxt.value.toLowerCase();
}
function ShowHide(objname){
  var obj = document.getElementById(objname);
  if(obj.style.display == "block" || obj.style.display == "")
	   obj.style.display = "none";
  else
	   obj.style.display = "block";
}
function SelectTemplets(fname)
{
   var posLeft = window.event.clientY-200;
   var posTop = window.event.clientX-300;
   window.open("../include/dialog/select_templets.php?&activepath=<?php echo urlencode($cfg_templets_dir)?>&f="+fname, "poptempWin", "scrollbars=yes,resizable=yes,statebar=no,width=600,height=400,left="+posLeft+", top="+posTop);
}
function CheckSubmit(){
   if(document.form1.title.value==""){
       alert("�����б������ⲻ��Ϊ�գ�");
	   document.form1.title.focus();
	   return false;
   }
   return true;
}
</script>
</head>
<body background='img/allbg.gif' leftmargin='8' topmargin='8'>
<center>
<span style="display:none" id="list1">
��[field:textlink/]([field:pubdate function=strftime('%m-%d',@me)/])<br/>
</span>
<span style="display:none" id="list2">
��[field:typelink/] [field:textlink/]<br/>
</span>
<span style="display:none" id="list3">
<table width='98%' border='0' cellspacing='2' cellpadding='0'>
   <tr><td align='center'>[field:imglink/]</td></tr>
   <tr><td align='center'>[field:textlink/]</td></tr>
</table>
</span>
<span style="display:none" id="list4">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbspan" style="margin-top:6px">
<tr> 
<td height="1" colspan="2" background="[field:templeturl/]/img/dot_hor.gif"></td>
</tr>
<tr> 
<td width="5%" height="26" align="center"><img src="[field:templeturl/]/img/item.gif" width="18" height="17"></td>
<td height="26">
	<b>
		[field:typelink function='str_replace("a ","a class=ulink ",@me)'/]
		<a href="[field:arcurl/]" class="ulink">[field:title/]</a>
	</b>
</td>
</tr>
<tr> 
<td height="20" style="padding-left:3px">&nbsp;</td>
<td style="padding-left:3px">
				<font color="#8F8C89">���ڣ�[field:pubdate function="GetDateTimeMK(@me)"/] 
�����[field:click/] ���ۣ�[field:postnum/]</font>
				<a href="[field:phpurl/]/feedback.php?arcID=[field:id/]"><img src="[field:templeturl/]/img/comment.gif" width="12" height="12" border="0" title="�鿴����"></a>
				</td>
</tr>
<tr> 
<td colspan="2" style="padding-left:3px">
  [field:litpic function="CkLitImageView(@me,80)"/]
	[field:description/]
</td>
</tr>
</table>
</span>
  <table width="98%" border="0" cellpadding="2" cellspacing="1" bgcolor="#98CAEF" align="center">
    <form action="freelist_action.php" method="post"  name="form1" onSubmit="return CheckSubmit();">
      <input type="hidden" name="dopost" value="addnew">
      <tr> 
        <td height="23" background="img/tbg.gif"> <table width="98%" border="0" cellpadding="0" cellspacing="0">
            <tr> 
              <td width="35%" height="18"><strong>���������б���� &gt;&gt; ����һ���б�</strong></td>
              <td width="65%" align="right"> <input type="button" name="b113" value="���������б�" onClick="location='freelist_main.php';" style="width:100" class='nbt'> 
                &nbsp; <input type="button" name="bt2" value="�����б�HTML" class="nbt" style="width:80px" onClick="location='makehtml_freelist.php';"> 
              </td>
            </tr>
          </table></td>
      </tr>
      <tr> 
        <td height="265" valign="top" bgcolor="#FFFFFF"><table width="99%" border="0" align="right" cellpadding="0" cellspacing="0">
            <tr> 
              <td height="56"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr> 
                    <td height="28" colspan="2"><img src="img/help.gif" width="16" height="16">�����б��ǵ�˵���������б���(freelist)�Ĺ��ܻ�����ͬ��arclist��ǣ�������freelist���֧�ַ�ҳ����������Google 
                      Map�����ɰ��Զ����������������б��簴����ƴ����������ȣ������ɵ�ʵ��ͳһ�����������������Ƕ�������ģ���������ģ�����һ����������Ӱ��ϵͳ����HTML������ٶȡ�</td>
                  </tr>
                  <tr> 
                    <td width="16%" height="28">�����б���⣺</td>
                    <td width="84%"><input name="title" type="text" id="title" style="width:35%"></td>
                  </tr>
                  <tr> 
                    <td height="28">�б�HTML���Ŀ¼��</td>
                    <td><input name="listdir" type="text" id="listdir" style="width:35%" value="{cmspath}/freelist/">
                      {listdir}������ֵ</td>
                  </tr>
                  <tr> 
                    <td height="28">Ŀ¼Ĭ��ҳ���ƣ�</td>
                    <td> <input name="defaultpage" type="text" id="defaultpage" style="width:35%" value="index.html"> 
                      <input name="nodefault" type="checkbox" class="np" id="nodefault" value="1">
                      ��ʹ��Ŀ¼Ĭ����ҳ </td>
                  </tr>
                  <tr> 
                    <td height="28">��������</td>
                    <td><input name="namerule" type="text" id="namerule" style="width:35%" value="{listdir}/index_{listid}_{page}.html"></td>
                  </tr>
                  <tr> 
                    <td height="28">�б�ģ�壺</td>
                    <td><input name="templet" type="text" id="templet" style="width:300" value="{style}/list_free.htm"> 
                      <input type="button" name="set4" value="���..." style="width:60" onClick="SelectTemplets('form1.templet');" class='nbt'></td>
                  </tr>
                  <tr> 
                    <td height="28">&nbsp;</td>
                    <td>����ѡ������ģ����� &lt;meta name=&quot;keywords|description&quot; 
                      content=&quot;&quot;&gt; ����</td>
                  </tr>
                  <tr> 
                    <td height="28">�ؼ��֣�</td>
                    <td><input name="keywords" type="text" id="keywords" style="width:60%"></td>
                  </tr>
                  <tr> 
                    <td height="28">�б�������</td>
                    <td><textarea name="description" id="description" style="width:60%;height:50px"></textarea></td>
                  </tr>
                </table></td>
            </tr>
            <tr> 
              <td height="26" background="img/menubg.gif"><img src="img/file_tt.gif" width="7" height="8" style="margin-left:6px;margin-right:6px;">�б���ʽ���������Ƕ��������б�ģ�����{dede:freelist 
                /}��ǵ���ʽ�����ԣ�</td>
            </tr>
            <tr> 
              <td height="72"><table width="99%" border="0" cellspacing="0" cellpadding="0">
                  <tr> 
                    <td width="25%" height="126"><img src="img/g_t2.gif" width="130" height="100"> 
                      <input name="liststyle" class="np" type="radio" onClick="ChangeListStyle()" value="1"> 
                    </td>
                    <td width="25%"><img src="img/g_t1.gif" width="130" height="110"> 
                      <input type="radio" class="np" onClick="ChangeListStyle()" name="liststyle" value="2"></td>
                    <td width="25%"><img src="img/g_t3.gif" width="130" height="110"> 
                      <input type="radio" class="np" onClick="ChangeListStyle()" name="liststyle" value="3"></td>
                    <td><img src="img/g_t4.gif" width="130" height="110"> <input name="liststyle" type="radio" class="np" onClick="ChangeListStyle()" value="4" checked></td>
                  </tr>
                </table></td>
            </tr>
            <tr> 
              <td height="28"> �޶���Ŀ�� 
                <?php echo GetTypeidSel('form1','typeid','selbt1',0)?>
              </td>
            </tr>
            <tr> 
              <td height="28"> �޶�Ƶ���� 
                <?php 
       echo "<select name='channel' style='width:100'>\r\n";
       echo "<option value='0' selected>����...</option>\r\n";
       $dsql->SetQuery("Select ID,typename From #@__channeltype where ID>0");
	   $dsql->Execute();
	   while($row = $dsql->GetObject())
	   {
	      echo "<option value='{$row->ID}'>{$row->typename}</option>\r\n";
	   }
       echo "</select>";
		?>
                ��(����޶���Ƶ������ģ�ͣ�������ʹ�ø��ӱ�ָ�����б��ֶ���Ϊ�ײ����)</td>
            </tr>
            <tr> 
              <td height="28">�������ԣ� 
                <?php 
       echo "<select name='att' style='width:100'>\r\n";
       echo "<option value='0' selected>����...</option>\r\n";
       $dsql->SetQuery("Select * From #@__arcatt");
	   $dsql->Execute();
	   while($row = $dsql->GetObject())
	   {
	      echo "<option value='{$row->att}'>{$row->attname}</option>\r\n";
	   }
       echo "</select>";
		?>
                �ĵ�����ʱ�䣺 
                <input name="subday" type="text" id="subday2" value="0" size="6">
                ������ ��0 ��ʾ���ޣ� </td>
            </tr>
            <tr> 
              <td height="28">ÿҳ��¼���� 
                <input name="pagesize" type="text" id="pagesize" value="30" size="4">
                ����ʾ������ 
                <input name="col" type="text" id="col3" value="1" size="4">
                ���ⳤ�ȣ� 
                <input name="titlelen" type="text" id="titlelen" value="60" size="4">
                ��1 �ֽ� = 0.5�������֣�</td>
            </tr>
            <tr>
              <td height="28">ժҪ���ȣ�</td>
            </tr>
            <tr> 
              <td height="28"> �߼�ɸѡ�� 
                <input name="types[]" type="checkbox" id="type1" value="image" class="np">
                ������ͼ 
                <input name="types[]" type="checkbox" id="type2" value="commend" class="np">
                �Ƽ� 
                <input name="types[]" type="checkbox" id="type3" value="spec" class="np">
                ר�⡡�ؼ��֣� 
                <input name="keyword" type="text" id="keyword">
                ��&quot;,&quot;���ŷֿ���</td>
            </tr>
            <tr> 
              <td height="28">����˳�� 
                <select name="orderby" id="orderby" style="width:120">
                  <option value="sortrank">�ö�Ȩ��ֵ</option>
                  <option value="pubdate" selected>����ʱ��</option>
                  <option value="senddate">¼��ʱ��</option>
                  <option value="click">�����</option>
                  <option value="id">�ĵ��ɣ�</option>
                  <option value="lastpost">�������ʱ��</option>
                  <option value="postnum">��������</option>
                </select>
                �� 
                <input name="order" type="radio"  class="np" value="desc" checked>
                �ɸߵ��� 
                <input type="radio" name="order" class="np" value="asc">
                �ɵ͵���</td>
            </tr>
            <tr> 
              <td height="28">ѭ���ڵĵ��м�¼��ʽ(InnerText)��[<a href='javascript:ShowHide("innervar");'><img src="img/help.gif" width="16" height="16" border="0">�ײ����field�ο�</a>]</td>
            </tr>
            <tr> 
              <td height="99"> <textarea name="innertext" cols="80" rows="6" id="myinnertext" style="width:80%;height:120px"></textarea> 
                <script language="javascript">document.form1.innertext.value=document.getElementById("list4").innerHTML.toLowerCase();</script> 
              </td>
            </tr>
            <tr> 
              <td height="80" id='innervar' style="display:none"><font color="#CC6600"><img src="img/help.gif" width="16" height="16">֧���ֶ�(�ײ����[field:varname/])��id,title,color,typeid,ismake,description,pubdate,senddate,arcrank,click,litpic,typedir,typename,arcurl,typeurl,<br>
                stime(pubdate ��&quot;0000-00-00&quot;��ʽ),textlink,typelink,imglink,image 
                ��ͨ�ֶ�ֱ����[field:�ֶ���/]��ʾ��<br>
                ��Pubdate����ʱ��ĵ��ò��� [field:pubdate function=strftime('%Y-%m-%d %H:%M:%S',@me)/]</font> 
              </td>
            </tr>
            <tr> 
              <td height="50"> &nbsp; <input name="Submit2" type="submit" id="Submit2" value="����һ���б�" class='nbt'> 
              </td>
            </tr>
          </table></td>
      </tr>
    </form>
    <tr> 
      <td valign="top" bgcolor="#EFF7E6">&nbsp;</td>
    </tr>
  </table>
</center>
<?php 
$dsql->Close();
?>
</body>
</html>