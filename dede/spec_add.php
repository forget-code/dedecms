<?php 
require_once(dirname(__FILE__)."/config.php");
CheckPurview('spec_New');
require_once(dirname(__FILE__)."/../include/inc_typelink.php");
$channelid = -1;
if(empty($cid)) $cid = 0;
$dsql = new DedeSql(false);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>ר�ⷢ����</title>
<style type="text/css">
<!--
body { background-image: url(img/allbg.gif); }
-->
</style>
<link href="base.css" rel="stylesheet" type="text/css">
<script language='javascript' src='main.js'></script>
<script language="javascript">
<!--

function checkSubmit(){
   if(document.form1.title.value==""){
	    alert("ר�����Ʋ���Ϊ�գ�");
	    return false;
   }
}

function SelectTemplets(fname){
   var posLeft = window.event.clientY-200;
   var posTop = window.event.clientX-300;
   window.open("../include/dialog/select_templets.php?f="+fname, "poptempWin", "scrollbars=yes,resizable=yes,statebar=no,width=600,height=400,left="+posLeft+", top="+posTop);
}

function SelectArcList(fname){
   var posLeft = 10;
   var posTop = 10;
   window.open("content_select_list.php?f="+fname, "selArcList", "scrollbars=yes,resizable=yes,statebar=no,width=700,height=500,left="+posLeft+", top="+posTop);
}

function SelectImage(fname,vlist){
   var posLeft = window.event.clientY-100;
   var posTop = window.event.clientX-400;
   window.open("../include/dialog/select_images.php?f="+fname+"&imgstick="+vlist, "popUpImagesWin", "scrollbars=yes,resizable=yes,statebar=no,width=600,height=400,left="+posLeft+", top="+posTop);
}

-->
</script>
</head>
<body topmargin="8">
<form name="form1" action="spec_add_action.php" enctype="multipart/form-data" method="post" onSubmit="return checkSubmit();">
<input type="hidden" name="channelid" value="<?php echo $channelid?>">
<input type="hidden" name="arcrank" value="0">
<input type="hidden" name="source" value="��վ">
<input type="hidden" name="typeid2" value="0">
  <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr> 
      <td width="4%" height="30"><IMG height=14 src="img/book1.gif" width=20> 
        &nbsp;</td>
      <td width="85%"><a href="content_s_list.php"><u>ר���б�</u></a><a href="catalog_do.php?cid=<?php echo $cid?>&channelid=<?php echo $channelid?>&dopost=listArchives"></a>&gt;&gt;����ר��</td>
      <td width="10%">&nbsp; <a href="makehtml_spec.php">[<u>����HTML</u>]</a></td>
      <td width="1%">&nbsp;</td>
    </tr>
  </table>
  <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" id="head1" class="htable">
    <tr> 
      <td colspan="2"> <table width="168" border="0" cellpadding="0" cellspacing="0">
          <tr> 
            <td width="84" height="24" align="center" background="img/itemnote1.gif">&nbsp;�������&nbsp;</td>
            <td width="84" align="center" background="img/itemnote2.gif"><a href="#" onClick="ShowItem2()"><u>ר���ĵ�</u></a>&nbsp;</td>
          </tr>
        </table></td>
    </tr>
  </table>
  <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" id="head2" style="border-bottom:1px solid #CCCCCC;display:none">
    <tr> 
      <td colspan="2"> <table width="168" height="24" border="0" cellpadding="0" cellspacing="0">
          <tr> 
            <td width="84" align="center" background="img/itemnote2.gif"><a href="#" onClick="ShowItem1()"><u>�������</u></a>&nbsp;</td>
            <td width="84" align="center" background="img/itemnote1.gif">ר���ĵ�</td>
          </tr>
        </table></td>
    </tr>
  </table>
  <table width="98%"  border="0" align="center" cellpadding="2" cellspacing="2" id="needset">
    <tr> 
      <td width="400%" height="24" colspan="4" class="bline"> <table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90">ר�����ƣ�</td>
            <td width="250">
<input name="title" type="text" id="title" style="width:200">
            </td>
            <td width="90">���Ӳ�����</td>
            <td> 
              <input name="iscommend" type="checkbox" id="iscommend" value="11" class="np">
              �Ƽ� 
              <input name="isbold" type="checkbox" id="isbold" value="5" class="np">
              �Ӵ� </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline"> <table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90">С���⣺</td>
            <td width="250">
<input name="shorttitle" type="text" id="shorttitle" style="width:150">
            </td>
            <td width="90">�Զ����ԣ�</td>
            <td> 
              <select name='arcatt' style='width:150'>
                <option value='0'>��ͨ�ĵ�</option>
                <?php 
            	$dsql->SetQuery("Select * From #@__arcatt order by att asc");
            	$dsql->Execute();
            	while($trow = $dsql->GetObject())
            	{
            		echo "<option value='{$trow->att}'>{$trow->attname}(att={$trow->att})</option>";
            	}
            	?>
              </select>
            </td>
          </tr>
        </table></td>
    </tr>
    <tr id="pictable"> 
      <td height="24" colspan="4" class="bline"> <table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90" height="81">
            	&nbsp;�� �� ͼ��<br/>
            	&nbsp;<input type='checkbox' class='np' name='ddisremote' value='1'>Զ��
            </td>
            <td width="441"> 
              <table width="100%" border="0" cellspacing="1" cellpadding="1">
                <tr> 
                  <td height="30"> �����ϴ��������������ť 
                    <input name="litpic" type="file" id="litpic" class="np" style="width:200" onChange="SeePic(document.picview,document.form1.litpic);"> 
                  </td>
                </tr>
                <tr> 
                  <td height="30">
				    <input name="picname" type="text" id="picname" style="width:250" value="" onChange="SeePic(document.picview,this.value);"> 
                    <input type="button" name="Submitss" value="����վ��ѡ��" style="width:120" onClick="SelectImage('form1.picname','');" class='nbt'> 
                  </td>
                </tr>
              </table>
            </td>
            <td width="269" align="center"><img src="img/pview.gif" width="150" id="picview" name="picview"></td>
          </tr>
        </table></td>
    </tr>
    <tr>
      <td height="24" colspan="4" class="bline">
	  <table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90">ר��ģ�壺</td>
            <td>
			<input name="templet" type="text" id="templet" size="30" value="{style}/article_spec.htm">
            <input type="button" name="set3" value="���..." style="width:60" onClick="SelectTemplets('form1.templet');" class='nbt'> 
            </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline"><table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90">���α༭��</td>
            <td width="240"> 
              <input name="writer" type="text" id="writer">
            </td>
            <td width="90">����ѡ�</td>
            <td> <input name="ishtml" type="radio" class="np" value="1" checked>
              ����HTML 
              <input type="radio" name="ishtml" class="np" value="0">
              ����̬��� </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline"><table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90" height="22">��������</td>
            <td width="240"> <select name="sortup" id="sortup" style="width:150">
                <option value="0" selected>Ĭ������</option>
                <option value="7">�ö�һ��</option>
                <option value="30">�ö�һ����</option>
                <option value="90">�ö�������</option>
                <option value="180">�ö�����</option>
                <option value="360">�ö�һ��</option>
              </select> </td>
            <td width="90">������ɫ��</td>
            <td width="159"> <input name="color" type="text" id="color" style="width:120"> 
            </td>
            <td> <input name="modcolor" type="button" id="modcolor" value="ѡȡ" onClick="ShowColor()" class='nbt'> 
            </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline"><table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90" height="78">ר��˵����</td>
            <td> <textarea name="description" rows="4" id="textarea" style="width:350"></textarea> 
            </td>
          </tr>
          <tr> 
            <td width="90" height="51">�ؼ��֣�</td>
            <td> <textarea name="keywords" rows="3" id="textarea2" style="width:180"></textarea> 
            </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline"><table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90">����ʱ�䣺</td>
            <td> 
              <?php 
			$nowtime = GetDateTimeMk(mytime());
			echo "<input name=\"pubdate\" value=\"$nowtime\" type=\"text\" id=\"pubdate\" style=\"width:200\">";
			echo "<input name=\"selPubtime\" type=\"button\" id=\"selkeyword\" value=\"ѡ��\" onClick=\"showCalendar('pubdate', '%Y-%m-%d %H:%M:00', '24');\">";
			?>
            </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline"><table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90">�����ࣺ</td>
            <td><?php echo GetTypeidSel('form1','typeid','selbt',0)?></td>
          </tr>
        </table></td>
    </tr>
  </table>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr><td height="6"></td></tr>
</table>
  <table width="98%"  border="0" align="center" cellpadding="2" style="display:none" cellspacing="2" id="adset">
    <tr> 
      <td height="24" bgcolor="#F1F5F2" class="bline2"> <strong>ר��ڵ��б�</strong> 
        <br>
        1�������б���ID1,ID2,ID3������ʽ�ֿ���ϵͳ���Զ��ų���ͬ�ڵ����ͬ���£�<br/>
        2�����ڵ�����¼ģ�����[field:fieldname /]��ǵ�ʹ�ã���ο�����ϵͳ�������� arclist ��ǵ�˵����<br>
        3���ڵ�ID�ǽڵ��Ψһ��ʶ��������ר��ģ������{dede:specnote id='��ʶ'/}��������ʾ�����ڵ㡣<br>
        4������������£�ÿ���ڵ���ʾ���ǡ��ڵ������б�����ĵ��������ָ��Ϊ���Զ���ȡģʽ������ô����ָ���ؼ��ֺ���ĿID��
        </td>
    </tr>
    <tr> 
      <td height="24" valign="top" class="bline">
        <table width="800" border="0" cellspacing="2" cellpadding="2">
          <?php 
		  $speclisttmp = GetSysTemplets("spec_arclist.htm");
		  for($i=1;$i<=$cfg_specnote;$i++)
		  {
		  ?>
          <tr bgcolor="#EEF8E0"> 
            <td width="113">�ڵ� 
              <?php echo $i?>
              ���ƣ�</td>
            <td colspan="2"> <table width="600" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="310"><input name="notename<?php echo $i?>" type="text" id="notename<?php echo $i?>" style="width:300"> 
                  </td>
                  <td width="90" align="center">�ڵ��ʶ��</td>
                  <td width="200"><input name="noteid<?php echo $i?>" type="text" id="noteid<?php echo $i?>" style="width:100"></td>
                </tr>
              </table></td>
          </tr>
          <tr> 
            <td>�ڵ������б�</td>
            <td width="479"><textarea name="arcid<?php echo $i?>" rows="3" id="arcid<?php echo $i?>" style="width:90%"></textarea></td>
            <td width="188"> 
              <input name="selarc<?php echo $i?>" type="button" id="selarc<?php echo $i?>2" value="ѡ��ڵ�����" style="width:100" onClick="SelectArcList('form1.arcid<?php echo $i?>');" class='nbt'></td>
          </tr>
          <tr> 
            <td>�ĵ���Դ��</td>
            <td colspan="2">
            	<input name="isauto<?php echo $i?>" type="radio" id="isauto<?php echo $i?>" value="0" class="np" checked>
            	�������б�
            	<input name="isauto<?php echo $i?>" type="radio" id="isauto<?php echo $i?>" value="1" class="np">
            	�Զ���ȡ�ĵ�
            	&nbsp;
            	�ؼ��֣�
            	<input name="keywords<?php echo $i?>" type="text" id="keywords<?php echo $i?>" value="" size="16">(���ŷֿ�)
            	��ĿID��
            	<input name="typeid<?php echo $i?>" type="text" id="typeid<?php echo $i?>" value="0" size="4">
            </td>
          </tr>
          <tr> 
            <td height="51" rowspan="2" valign="top">�ڵ㲼�֣� </td>
            <td colspan="2">
            	������ 
              <input name="col<?php echo $i?>" type="text" id="col<?php echo $i?>" value="1" size="3">
              ͼƬ�ߣ� 
              <input name="imgheight<?php echo $i?>" type="text" id="imgheight<?php echo $i?>" value="90" size="3">
              ͼƬ�� 
              <input name="imgwidth<?php echo $i?>" type="text" id="imgwidth<?php echo $i?>" value="120" size="3">
              ���ⳤ�� 
              <input name="titlelen<?php echo $i?>" type="text" id="titlelen<?php echo $i?>" value="60" size="3">
              ��鳤�� 
              <input name="infolen<?php echo $i?>" type="text" id="infolen<?php echo $i?>" value="160" size="3"> 
              �ĵ����� 
              <input name="rownum<?php echo $i?>" type="text" id="rownum<?php echo $i?>" value="40" size="3">
            </td>
          </tr>
          <tr> 
            <td colspan="2">������¼��ģ�壺<br/> <textarea name="listtmp<?php echo $i?>" rows="3" id="listtmp<?php echo $i?>" style="width:60%"><?php echo $speclisttmp?></textarea></td>
          </tr>
          <tr> 
            <td>�ڵ�����ģ�壺</td>
            <td colspan="2"><input name="notetemplet<?php echo $i?>" type="text" id="notetemplet<?php echo $i?>" value="system/channel/channel_spec_note.htm" style="width:300"> 
              <input type="button" name="selno<?php echo $i?>" value="���..." style="width:70" onClick="SelectTemplets('form1.notetemplet<?php echo $i?>');" class='nbt'></td>
          </tr>
          <?php 
		  }
		  ?>
        </table>
      </td>
    </tr>
    <tr> 
      <td height="24" bgcolor="#F1F5F2" class="bline2">&nbsp;</td>
    </tr>
  </table>
  <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td height="56">
	<table width="100%" border="0" cellspacing="1" cellpadding="1">
        <tr> 
          <td width="17%">&nbsp;</td>
          <td width="83%"><table width="214" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="115"><input name="imageField" type="image" src="img/button_ok.gif" width="60" height="22" border="0"></td>
                <td width="99"><img src="img/button_reset.gif" width="60" height="22" border="0" onClick="location.reload();" style="cursor:hand"></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
</table>
</form>
<?php 
$dsql->Close();
?>
</body>
</html>