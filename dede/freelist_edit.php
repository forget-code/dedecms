<?php 
require_once(dirname(__FILE__)."/config.php");
require_once(dirname(__FILE__)."/../include/inc_typelink.php");
require_once(dirname(__FILE__)."/../include/pub_dedetag.php");
$dsql = new DedeSql(false);
$aid = ereg_replace("[^0-9]","",$aid);
$row = $dsql->GetOne("Select * From #@__freelist where aid='$aid' ");
$dtp = new DedeTagParse();
$dtp->SetNameSpace("dede","{","}");
$dtp->LoadSource("--".$row['listtag']."--");
$ctag = $dtp->GetTag('list');
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
  <table width="98%" border="0" cellpadding="2" cellspacing="1" bgcolor="#98CAEF" align="center">
    <form action="freelist_action.php" method="post"  name="form1" onSubmit="return CheckSubmit();">
      <input type="hidden" name="dopost" value="edit">
      <input type="hidden" name="aid" value="<?php echo $row['aid']?>">
      <tr> 
        <td height="23" background="img/tbg.gif"> <table width="98%" border="0" cellpadding="0" cellspacing="0">
            <tr> 
              <td width="35%" height="18"><a href="mytag_main.php"><strong>���������б����</strong></a> 
                <strong>&gt;&gt; ���������б�</strong></td>
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
                    <td width="84%"><input name="title" type="text" id="title" style="width:35%" value="<?php echo $row['title']?>"></td>
                  </tr>
                  <tr> 
                    <td height="28">�б�HTML���Ŀ¼��</td>
                    <td><input name="listdir" type="text" id="listdir" style="width:35%" value="<?php echo $row['listdir']?>">
                      {listdir}������ֵ</td>
                  </tr>
                  <tr> 
                    <td height="28">Ŀ¼Ĭ��ҳ���ƣ�</td>
                    <td><input name="defaultpage" type="text" id="defaultpage" style="width:35%" value="<?php echo $row['defaultpage']?>"> 
                      <input name="nodefault" type="checkbox" class="np" id="nodefault" value="1"<?php  if($row['nodefault']==1) echo " checked"; ?>>
                      ��ʹ��Ŀ¼Ĭ����ҳ
                    </td>
                  </tr>
                  <tr> 
                    <td height="28">��������</td>
                    <td><input name="namerule" type="text" id="namerule" style="width:35%" value="<?php echo $row['namerule']?>"></td>
                  </tr>
                  <tr> 
                    <td height="28">�б�ģ�壺</td>
                    <td><input name="templet" type="text" id="templet" style="width:300" value="<?php echo $row['templet']?>"> 
                      <input type="button" name="set4" value="���..." style="width:60" onClick="SelectTemplets('form1.templet');" class='nbt'></td>
                  </tr>
                  <tr> 
                    <td height="28">&nbsp;</td>
                    <td>����ѡ������ģ����� &lt;meta name=&quot;keywords|description&quot; 
                      content=&quot;&quot;&gt; ����</td>
                  </tr>
                  <tr> 
                    <td height="28">�ؼ��֣�</td>
                    <td><input name="keywords" type="text" id="keywords" style="width:60%" value="<?php echo $row['keyword']?>"></td>
                  </tr>
                  <tr> 
                    <td height="28">�б�������</td>
                    <td><textarea name="description" id="description" style="width:60%;height:50px"><?php echo $row['description']?></textarea></td>
                  </tr>
                </table></td>
            </tr>
            <tr> 
              <td height="26" background="img/menubg.gif"><img src="img/file_tt.gif" width="7" height="8" style="margin-left:6px;margin-right:6px;">
              	�б���ʽ���������Ƕ��������б�ģ�����{dede:freelist/}��ǵ���ʽ�����ԣ�
              </td>
            </tr>
            <tr> 
              <td height="28">
              	�޶���Ŀ�� 
               <?php 
                $typeid = $ctag->GetAtt('typeid');
                if(!empty($typeid)){
                    $typeinfos = $dsql->GetOne("Select ID,typename From #@__arctype where ID='$typeid' ");
                    echo GetTypeidSel('form1','typeid','selbt1',0,$typeinfos['ID'],$typeinfos['typename']);
                }else{
                	echo GetTypeidSel('form1','typeid','selbt1',0);
                }
               ?>
              </td>
            </tr>
            <tr> 
              <td height="28"> �޶�Ƶ���� 
                <?php 
       $channel  = $ctag->GetAtt('channel');
       echo "<select name='channel' style='width:100'>\r\n";
       echo "<option value='0'>����...</option>\r\n";
       $dsql->SetQuery("Select ID,typename From #@__channeltype where ID>0");
	   $dsql->Execute();
	   while($nrow = $dsql->GetObject())
	   {
	      if($nrow->ID==$channel) echo "<option value='{$nrow->ID}' selected>{$nrow->typename}</option>\r\n";
	      else echo "<option value='{$nrow->ID}'>{$nrow->typename}</option>\r\n";
	   }
       echo "</select>";
		?>
                ��(����޶���Ƶ������ģ�ͣ�������ʹ�ø��ӱ�ָ�����б��ֶ���Ϊ�ײ����)</td>
            </tr>
            <tr> 
              <td height="28">�������ԣ� 
                <?php 
       $att  = $ctag->GetAtt('att');    
       echo "<select name='att' style='width:100'>\r\n";
       echo "<option value='0'>����...</option>\r\n";
       $dsql->SetQuery("Select * From #@__arcatt");
	   $dsql->Execute();
	   while($nrow = $dsql->GetObject())
	   {
	      if($att==$nrow->att) echo "<option value='{$nrow->att}' selected>{$nrow->attname}</option>\r\n";
	      else echo "<option value='{$nrow->att}'>{$nrow->attname}</option>\r\n";
	   }
       echo "</select>";
		?>
                �ĵ�����ʱ�䣺 
                <input name="subday" type="text" id="subday" size="6" value="<?php echo $ctag->GetAtt('subday')?>">
                ������ ��0 ��ʾ���ޣ� </td>
            </tr>
            <tr> 
              <td height="28">ÿҳ��¼���� 
                <input name="pagesize" type="text" id="pagesize"  value="<?php echo $ctag->GetAtt('pagesize')?>" size="4">
                ����ʾ������ 
                <input name="col" type="text" id="col" value="<?php  $col = $ctag->GetAtt('col'); $v = ( empty($col) ? '1' :  $col ); echo $v; ?>" size="4">
                ���ⳤ�ȣ� 
                <input name="titlelen" type="text" id="titlelen" value="<?php echo $ctag->GetAtt('titlelen')?>" size="4">
                ��1 �ֽ� = 0.5�������֣�</td>
            </tr>
            <tr> 
              <td height="28">
              	<?php 
              	$setype = $ctag->GetAtt('type');
              	if($setype=='') $setype = 'X';
              	?>
              	�߼�ɸѡ�� 
                <input name="types[]" type="checkbox" id="type1" value="image" class="np"<?php if(eregi('image',$setype)) echo ' checked';?>>
                ������ͼ 
                <input name="types[]" type="checkbox" id="type2" value="commend" class="np"<?php if(eregi('commend',$setype)) echo ' checked';?>>
                �Ƽ� 
                <input name="types[]" type="checkbox" id="type3" value="spec" class="np"<?php if(eregi('spec',$setype)) echo ' checked';?>>
                ר�⡡�ؼ��֣� 
                <input name="keyword" type="text" id="keyword" value="<?php echo $ctag->GetAtt('keyword')?>">
                ��&quot;,&quot;���ŷֿ���
                </td>
            </tr>
            <tr> 
              <td height="28">����˳�� 
                <?php 
                $orderby = $ctag->GetAtt('orderby');
                $sorta = "sortrank,�ö�Ȩ��ֵ;pubdate,����ʱ��;senddate,¼��ʱ��;click,�����;id,�ĵ��ɣ�,lastpost,�������ʱ��;postnum,��������;rand,�����ȡ";
                $sortas = explode(';',$sorta);
                foreach($sortas as $v){
                	$vs = explode(',',$v);
                	$vs[0] = trim($vs[0]);
                	$sortarrs[$vs[0]] = $vs[1];
                }
                ?>  
                <select name="orderby" id="orderby" style="width:120">
                	<?php 
                	echo "<option value=\"$orderby\" selected>{$sortarrs[$orderby]}</option>\r\n";
                	?>
                  <option value="sortrank">�ö�Ȩ��ֵ</option>
                  <option value="pubdate">����ʱ��</option>
                  <option value="senddate">¼��ʱ��</option>
                  <option value="click">�����</option>
                  <option value="id">�ĵ��ɣ�</option>
                  <option value="lastpost">�������ʱ��</option>
                  <option value="postnum">��������</option>
                </select>
                �� 
                <input name="order" type="radio"  class="np" value="desc"<?php if($ctag->GetAtt('orderway')=='desc') echo " checked";?>>
                �ɸߵ��� 
                <input type="radio" name="order" class="np" value="asc"<?php if($ctag->GetAtt('orderway')=='asc') echo " checked";?>>
                �ɵ͵���</td>
            </tr>
            <tr> 
              <td height="28">ѭ���ڵĵ��м�¼��ʽ(InnerText)��[<img src="img/help.gif" width="16" height="16"><a href='javascript:ShowHide("innervar");'>�ײ����field�ο�</a>]</td>
            </tr>
            <tr> 
              <td height="80">
			  <textarea name="innertext" cols="80" rows="6" id="myinnertext" style="width:80%;height:120px"><?php echo $ctag->GetInnerText()?></textarea> 
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
              <td height="50"> &nbsp; 
                <input name="Submit2" type="submit" id="Submit2" value="����һ���б�" class='nbt'>
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