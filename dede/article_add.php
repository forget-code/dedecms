<?php 
require_once(dirname(__FILE__)."/config.php");
require_once(dirname(__FILE__)."/inc/inc_catalog_options.php");
$channelid="1";
if(empty($cid)) $cid = 0;
$dsql = new DedeSql(false);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>��������</title>
<style type="text/css">
<!--
body { background-image: url(img/allbg.gif); }
-->
</style>
<link href="base.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../include/dedeajax.js"></script>
<script language='javascript' src='main.js'></script>
<script language="javascript">
<!--
function SelectTemplets(fname){
   var posLeft = window.event.clientY-200;
   var posTop = window.event.clientX-300;
   window.open("../include/dialog/select_templets.php?f="+fname, "poptempWin", "scrollbars=yes,resizable=yes,statebar=no,width=600,height=400,left="+posLeft+", top="+posTop);
}

function checkSubmit()
{
  if(document.form1.title.value==""){
	   alert("���±��ⲻ��Ϊ�գ�");
	   return false;
  }
  if(document.form1.typeid.value==0){
	   alert("��ѡ�񵵰��������");
	   return false;
  }
}
-->
</script>
</head>
<body topmargin="8">
<form name="form1" action="article_add_action.php" enctype="multipart/form-data" method="post" onSubmit="return checkSubmit()">
  <input type="hidden" name="channelid" value="<?php echo $channelid?>">
  <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr> 
      <td width="4%" height="30"><IMG height=14 src="img/book1.gif" width=20> &nbsp;</td>
      <td width="85%"><a href="catalog_do.php?cid=<?php echo $cid?>&channelid=<?php echo $channelid?>&dopost=listArchives"><u>�����б�</u></a>&gt;&gt;��������</td>
      <td width="10%">&nbsp; <a href="catalog_main.php">[<u>��Ŀ����</u>]</a> </td>
      <td width="1%">&nbsp;</td>
    </tr>
  </table>
  <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" id="head1" class="htable">
    <tr> 
      <td colspan="2"> 
        <table width="168" border="0" cellpadding="0" cellspacing="0">
          <tr> 
            <td width="84" height="24" align="center" background="img/itemnote1.gif">&nbsp;�������&nbsp;</td>
            <td width="84" align="center">&nbsp;</td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
  <table width="98%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr><td height="2"></td></tr>
</table>
  <table width="98%"  border="0" align="center" cellpadding="2" cellspacing="2" id="needset">
    <tr> 
      <td height="24" colspan="4" class="bline"> <table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90">&nbsp;���±��⣺</td>
            <td width="250"> <input name="title" type="text" id="title" style="width:230"> 
            </td>
            <td width="90">���Ӳ�����</td>
            <td> <input name="iscommend" type="checkbox" id="iscommend" value="11" class="np">
              �Ƽ� 
              <input name="isbold" type="checkbox" id="isbold" value="5" class="np">
              �Ӵ� 
              <input name="isjump" type="checkbox" id="isjump" value="1" onClick="ShowUrlTr()" class="np">
              ��ת��ַ</td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline" id="redirecturltr" style="display:none"> 
        <table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90">&nbsp;��ת��ַ��</td>
            <td> <input name="redirecturl" type="text" id="redirecturl" style="width:300" value=""> 
            </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline"> <table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90">&nbsp;���Ա��⣺</td>
            <td width="250"> <input name="shorttitle" type="text" id="shorttitle" style="width:150"> 
            </td>
            <td width="90">�Զ������ԣ�</td>
            <td> <select name='arcatt' style='width:150'>
                <option value='0'>��ͨ�ĵ�</option>
                <?php 
            	$dsql->SetQuery("Select * From #@__arcatt order by att asc");
            	$dsql->Execute();
            	while($trow = $dsql->GetObject())
            	{
            		echo "<option value='{$trow->att}'>{$trow->attname}(att={$trow->att})</option>";
            	}
            	?>
              </select> </td>
          </tr>
        </table></td>
    </tr>
    <tr id="pictable"> 
      <td height="24" colspan="4" class="bline"> <table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="135" height="81"> &nbsp;�� �� ͼ��<br/> &nbsp; <input type='checkbox' class='np' name='ddisremote' value='1' id='ddisremote' onClick="CkRemote('ddisremote','litpic')">
              Զ��ͼƬ <br> </td>
            <td width="464"><table width="100%" border="0" cellspacing="1" cellpadding="1">
                <tr> 
                  <td height="30"> �����ϴ��������������ť 
                    <input name="litpic" type="file" id="litpic" class="np" style="width:200" onChange="SeePic(document.picview,document.form1.litpic);"> 
                  </td>
                </tr>
                <tr> 
                  <td height="30"> <input name="picname" type="text" id="picname" style="width:250"> 
                    <input type="button" name="Submit2" value="����վ��ѡ��" style="width:120" onClick="SelectImage('form1.picname','small');" class='nbt'> 
                  </td>
                </tr>
              </table></td>
            <td width="201" align="center"><img src="img/pview.gif" width="150" id="picview" name="picview"></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline"> <table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90">&nbsp;������Դ��</td>
            <td width="240"><input name="source" type="text" id="source" style="width:160" size="16"> 
              <input name="selsource" type="button" id="selsource" value="ѡ��" class='nbt'></td>
            <td width="90">�����ߣ�</td>
            <td> <input name="writer" type="text" id="writer" style="width:120"> 
              <input name="selwriter" type="button" id="selwriter" value="ѡ��" class='nbt'> 
            </td>
          </tr>
        </table>
        <script language='javascript'>InitPage();</script> </td>
    </tr>
    <tr>
      <td height="24" colspan="4" class="bline"><table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90">&nbsp;����ģ�壺</td>
            <td> <input name="templet" type="text" id="templet" size="30"> 
              <input type="button" name="set3" value="���..." style="width:60" onClick="SelectTemplets('form1.templet');" class='nbt'>
              �������ģ��Ϊ�գ���ʹ������������Ŀ�����ģ�壩 </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline"><table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90" height="22">&nbsp;��������</td>
            <td width="240"> <select name="sortup" id="sortup" style="width:150">
                <option value="0" selected>Ĭ������</option>
                <option value="7">�ö�һ��</option>
                <option value="30">�ö�һ����</option>
                <option value="90">�ö�������</option>
                <option value="180">�ö�����</option>
                <option value="360">�ö�һ��</option>
              </select> </td>
            <td width="90">������ɫ��</td>
            <td> <input name="color" type="text" id="color" style="width:120"> 
              <input name="modcolor" type="button" id="modcolor" value="ѡȡ" onClick="ShowColor()" class='nbt'> 
            </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline"> <table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90">&nbsp;�Ķ�Ȩ�ޣ�</td>
            <td width="240"> <select name="arcrank" id="arcrank" style="width:150">
                <?php 
              $urank = $cuserLogin->getUserRank();
              $dsql->SetQuery("Select * from #@__arcrank where adminrank<='$urank'");
              $dsql->Execute();
              while($row = $dsql->GetObject())
              {
              	echo "     <option value='".$row->rank."'>".$row->membername."</option>\r\n";
              }
              ?>
              </select> </td>
            <td width="90">����ѡ�</td>
            <td> <input name="ishtml" type="radio" class="np" value="1" checked>
              ����HTML 
              <input type="radio" name="ishtml" class="np" value="0">
              ����̬���</td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="70" colspan="4" class="bline"> <table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90" height="51">&nbsp;����ժҪ��</td>
            <td width="240"> <textarea name="description" rows="3" id="description" style="width:200"></textarea> 
            </td>
            <td width="90">�ؼ��֣�</td>
            <td width="234"> <textarea name="keywords" rows="3" id="keywords" style="width:200"></textarea> 
            </td>
            <td width="146" align="center"> <input name="autokey" type="checkbox" onClick="ShowHide('keywords');"; class="np" id="autokey" value="1">
              �Զ� <br/>
              �ÿո�ֿ�<br/> <input type="button" name="Submit" value="���..." style="width:56;height:20" onClick="SelectKeywords('form1.keywords');" class='nbt'> 
            </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline"><table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90">&nbsp;����ʱ�䣺</td>
            <td width="400"> 
              <?php 
			$nowtime = GetDateTimeMk(mytime());
			echo "<input name=\"pubdate\" value=\"$nowtime\" type=\"text\" id=\"pubdate\" style=\"width:200\">";
			?>
            </td>
            <td width="82" align="center">���ѵ�����</td>
            <td> <input name="money" type="text" id="money" value="0" size="10"> 
            </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline"><table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90">&nbsp;��������Ŀ��</td>
            <td width="400"> 
            <?php 
           	if(empty($cid)) echo GetTypeidSel('form1','typeid','selbt1',$channelid);
           	else{
           	  $typeOptions = GetOptionList($cid,$cuserLogin->getUserChannel(),$channelid);
		          echo "<select name='typeid' style='width:300'>\r\n";
              echo "<option value='0'>��ѡ��������...</option>\r\n";
              echo $typeOptions;
              echo "</select>";
            }
			      ?>
            </td>
            <td>��ֻ�����ڰ�ɫѡ�����Ŀ�з�����ǰ�������ݣ�</td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline"> <table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90">&nbsp;���¸���Ŀ��</td>
            <td> 
			  <?php echo GetTypeidSel('form1','typeid2','selbt2',$channelid)?>
			  </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="6" colspan="4"></td>
    </tr>
  </table>
  <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" id="head2" style="border-bottom:1px solid #CCCCCC;">
    <tr> 
      <td colspan="2"> <table width="168" height="24" border="0" cellpadding="0" cellspacing="0">
          <tr> 
            <td width="84" align="center" background="img/itemnote1.gif">��������</td>
            <td width="84" align="center">&nbsp;</td>
          </tr>
        </table></td>
    </tr>
  </table>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr><td height="2"></td></tr>
</table>
  <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" id="adset">
    <tr> 
      <td width="100%" height="24" class="bline">
	  <table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90">&nbsp;����ѡ�</td>
            <td>
            	<input name="remote" type="checkbox" class="np" id="remote" value="1" checked>
              ����Զ��ͼƬ����Դ 
              <input name="dellink" type="checkbox" class="np" id="dellink" value="1">
              ɾ����վ������
              <input name="autolitpic" type="checkbox" class="np" id="autolitpic" value="1" checked>
              ��ȡ��һ��ͼƬΪ����ͼ
              </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td width="100%" height="24" class="bline">
	  <table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td>&nbsp;��ҳ��ʽ��</td>
            <td>
            	<input name="sptype" type="radio" class="np" value="hand"<?php if($cfg_arcautosp=='��') echo " checked"?>>
              �ֶ���ҳ 
              <input type="radio" name="sptype" value="auto" class="np"<?php if($cfg_arcautosp=='��') echo " checked"?>>
              �Զ���ҳ���Զ���ҳ��С�� 
              <input name="spsize" type="text" id="spsize" value="<?php echo $cfg_arcautosp_size?>" size="6">
              (K)
              </td>
          </tr>
          <tr> 
            <td width="90">&nbsp;</td>
            <td>���ֶ���ҳ����ֵĵط����� <font color="#FF0000">#p#��ҳ����#e# </font>���༭��������ð�ť��</td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" bgcolor="#FFFFFF">&nbsp;�������ݣ�</td>
    </tr>
    <tr> 
      <td> 
        <?php 
	GetEditor("body","",450);
	?>
      </td>
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
                <td width="99">
                	<img src="img/button_reset.gif" width="60" height="22" border="0" onClick="location.reload();" style="cursor:hand">
                </td>
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