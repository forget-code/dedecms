<?
require_once(dirname(__FILE__)."/config.php");
require_once(dirname(__FILE__)."/../include/inc_typelink.php");
$channelid="4";
if(empty($cid)) $cid = 0;
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>����Flash</title>
<style type="text/css">
<!--
body { background-image: url(img/allbg.gif); }
-->
</style>
<link href="base.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" media="all" href="../include/calendar/calendar-win2k-1.css" title="win2k-1" />
<script type="text/javascript" src="../include/calendar/calendar.js"></script>
<script type="text/javascript" src="../include/calendar/calendar-cn.js"></script>
<script language="javascript">
<!--
function showHide(objname)
{
   var obj = document.getElementById(objname);
   if(obj.style.display=="none") obj.style.display = "block";
	 else obj.style.display="none";
}
function checkSubmit()
{
   if(document.form1.title.value==""){
	   alert("���±��ⲻ��Ϊ�գ�");
	   document.form1.title.focus();
	   return false;
   }
   if(document.form1.seltypeid.value==0&&document.form1.typeid.value==0){
	   alert("��ѡ�񵵰��������");
	   return false;
  }
  mflash = document.getElementById("myflash");
  document.form1.remoteflash.value = mflash.innerHTML;
}
function ShowColor(){
	var fcolor=showModalDialog("img/color.htm?ok",false,"dialogWidth:106px;dialogHeight:110px;status:0;dialogTop:"+(window.event.clientY+120)+";dialogLeft:"+(window.event.clientX));
	if(fcolor!=null && fcolor!="undefined") document.form1.color.value = fcolor;
}

function SeePic(img,f)
{
   if ( f.value != "" ) { img.src = f.value; }
}

function SelectFlash()
{
   var posLeft = window.event.clientY-100;
   var posTop = window.event.clientX-400;
   window.open("../include/dialog/select_media.php?f=form1.flashurl", "popUpFlashWin", "scrollbars=yes,resizable=yes,statebar=no,width=500,height=350,left="+posLeft+", top="+posTop);
}

function SelectImage()
{
   var posLeft = window.event.clientY-100;
   var posTop = window.event.clientX-400;
   window.open("../include/dialog/select_images.php?f=form1.picname", "popUpImagesWin", "scrollbars=yes,resizable=yes,statebar=no,width=600,height=400,left="+posLeft+", top="+posTop);
}

function SelectKeywords(f)
{
	var posLeft = window.event.clientY-100;
  var posTop = window.event.clientX-500;
  window.open("article_keywords_select.php?f="+f, "popUpkwWin", "scrollbars=yes,resizable=yes,statebar=no,width=600,height=450,left="+posLeft+", top="+posTop);
}

-->
</script>
</head>
<body topmargin="8">
<form name="form1" action="action_flash_save.php" enctype="multipart/form-data" method="post" onSubmit="return checkSubmit();">
<input type="hidden" name="channelid" value="<?=$channelid?>">
<input type="hidden" name="remoteflash" value="">
<table width="98%"  border="0" align="center" cellpadding="1" cellspacing="1">
  <tr> 
    <td width="100%" height="26" colspan="2" background="img/tbg.gif" style="border:solid 1px #666666">
	  <table width="500" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="25" align="center">
          	<img src="img/dedeexplode.gif" width="11" height="11" border="0" onClick="showHide('infotable')" style="cursor: hand;">
          	</td>
          <td width="85"><strong>ͨ�ò�����</strong></td>
          <td width="390">
          <a href="catalog_do.php?cid=<?=$cid?>&channelid=<?=$channelid?>&dopost=listArchives">[<u>FLASH�б�</u>]</a>
          &nbsp;
          <a href="catalog_main.php">[<u>��Ŀ����</u>]</a>
          </td>
        </tr>
      </table>
      </td>
  </tr>
</table>
<table width="98%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr><td height="2"></td></tr>
</table>
  <table width="98%"  border="0" align="center" cellpadding="2" cellspacing="2" id="infotable">
    <tr> 
      <td width="400%" height="24" colspan="4" class="bline"> <table width="600" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="80">��Ʒ���ƣ�</td>
            <td width="224"><input name="title" type="text" id="title" style="width:200"></td>
            <td width="73">������</td>
            <td width="223"> <input name="iscommend" type="checkbox" id="iscommend" value="11" class="np">
              �Ƽ� 
              <input name="isbold" type="checkbox" id="isbold" value="5" class="np">
              �Ӵ�</td>
          </tr>
        </table></td>
    </tr>
    <tr id="pictable"> 
      <td height="24" colspan="4" class="bline"> <table width="600" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="78" height="81">����ͼ��</td>
            <td width="337"> <table width="100%" border="0" cellspacing="1" cellpadding="1">
                <tr> 
                  <td height="30">
				  <input name="litpic" type="file" id="litpic" style="width:280" onChange="SeePic(document.picview,document.form1.litpic);"> 
                  </td>
                </tr>
                <tr> 
                  <td height="30">
				  <input name="picname" type="text" id="picname" style="width:154">
                   <input type="button" name="Submit" value="����վ��ѡ��" style="width:120" onClick="SelectImage();">
				   </td>
                </tr>
              </table></td>
            <td width="185" align="center"><img src="img/pview.gif" width="150" id="picview" name="picview"></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline"><table width="600" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="80">FLASH��Դ��</td>
            <td width="224"> <input name="source" type="text" id="source" style="width:200"> 
            </td>
            <td width="63">���ߣ�</td>
            <td width="159"><input name="writer" type="text" id="writer" style="width:120"> 
            </td>
            <td width="74" align="center">&nbsp; </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline"><table width="600" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="80">��������</td>
            <td width="224"> <select name="sortup" id="sortup" style="width:150">
                <option value="0" selected>Ĭ������</option>
                <option value="7">�ö�һ��</option>
                <option value="30">�ö�һ����</option>
                <option value="90">�ö�������</option>
                <option value="180">�ö�����</option>
                <option value="360">�ö�һ��</option>
              </select> </td>
            <td width="63">������ɫ��</td>
            <td width="159"> <input name="color" type="text" id="color" style="width:120"> 
            </td>
            <td width="74" align="center"><input name="modcolor" type="button" id="modcolor" value="ѡȡ" onClick="ShowColor()"></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline"><table width="600" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="80">�Ķ�Ȩ�ޣ�</td>
            <td width="224">
            	<select name="arcrank" id="arcrank" style="width:150">
                <?
              $urank = $cuserLogin->getUserRank();
              $dsql = new DedeSql(false);
              $dsql->SetQuery("Select * from #@__arcrank where adminrank<='$urank'");
              $dsql->Execute();
              while($row = $dsql->GetObject())
              {
              	echo "     <option value='".$row->rank."'>".$row->membername."</option>\r\n";
              }
              $dsql->Close();
              ?>
              </select> </td>
            <td width="63">����ѡ�</td>
            <td><input name="ishtml" type="radio" class="np" value="1" checked>
              ����HTML 
              <input type="radio" name="ishtml" class="np" value="0">
              ����̬���</td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="75" colspan="4" class="bline">
<table width="600" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="80" height="51">����ժҪ��</td>
            <td width="224"> <textarea name="description" rows="3" id="description" style="width:200"></textarea> 
            </td>
            <td width="63">�ؼ��֣�</td>
            <td width="159"> <textarea name="keywords" rows="3" id="keywords" style="width:150"></textarea> 
            </td>
            <td width="74" align="center"> �ÿո�ֿ�<br/> <input type="button" name="Submit" value="���..." style="width:56;height:20" onClick="SelectKeywords('form1.keywords');"> 
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline"><table width="600" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="80">����ʱ�䣺</td>
            <td width="286"> 
              <?
			$nowtime = GetDateTimeMk(time());
			echo "<input name=\"pubdate\" value=\"$nowtime\" type=\"text\" id=\"pubdate\" style=\"width:200\">";
			echo "<input name=\"selPubtime\" type=\"button\" id=\"selkeyword\" value=\"ѡ��\" onClick=\"showCalendar('pubdate', '%Y-%m-%d %H:%M:00', '24');\">";
			?>
            </td>
            <td width="82" align="center">���ѵ�����</td>
            <td width="152"><input name="money" type="text" id="money" value="0" size="10"></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline"><table width="600" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="80">�����ࣺ</td>
            <td width="446"> 
              <?
           	$tl = new TypeLink($cid);
           	$typeOptions = $tl->GetOptionArray(0,$cuserLogin->getUserChannel(),$channelid);
           	if($cid>0)
           	{
           	   echo "<input type='hidden' name='seltypeid' value='$cid'>"; 
			         echo "<span id='type1info'>".$tl->GetPositionLink(false)."</span>"; 
            }else
            { 
			         echo "<input type='hidden' name='seltypeid' value='0'>"; 
			         echo "<select name='typeid' style='width:300'>\r\n";
               echo "<option value='0' selected>��ѡ��������...</option>\r\n";
            	 echo $typeOptions;
            	 echo "</select>";
			      } 
			    ?>
            </td>
            <td width="74" align="center"> <input name='modtype' type='button' onClick="showHide('typeidSelectFrom');"; id='modtype3' value='����'> 
            </td>
          </tr>
        </table></td>
    </tr>
    <tr id='typeidSelectFrom' style='display:none'> 
      <td height="24" colspan="4" class="bline"><table width="600" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="80">&nbsp;</td>
            <td> 
              <?
            if($cid>0){
              echo "<select name='typeid' style='width:300'>\r\n";
              echo "<option value='0' selected>��ѡ��������...</option>\r\n";
              echo $typeOptions;
              echo "</select>";
            }
            ?>
            </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline"><table width="600" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="80">�����ࣺ</td>
            <td width="446"> 
              <?
            echo "<select name='typeid2' style='width:300'>\r\n";
            echo "<option value='0' selected>��ѡ�񸱷���...</option>\r\n";
            echo $typeOptions;
            echo "</select>";
            $tl->Close();
            ?>
            </td>
            <td width="74" align="center">&nbsp; </td>
          </tr>
        </table></td>
    </tr>
  </table>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr><td height="6"></td></tr>
</table>
<table width="98%" border="0" align="center" cellpadding="1" cellspacing="0">
  <tr>
    <td><table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
        <tr> 
          <td width="100%" height="26" colspan="2" background="img/tbg.gif" style="border:solid 1px #666666"> 
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td width="5%" align="center">
                	<img src="img/dedeexplode.gif" width="11" height="11" border="0" onClick="showHide('addtable')" style="cursor: hand;">
                </td>
                  <td width="61%"><strong>���Ӳ�����</strong></td>
                <td width="34%">&nbsp;</td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
</table>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr><td height="2"></td></tr>
</table>
  <table width="98%"  border="0" align="center" cellpadding="2" cellspacing="2" id="addtable">
    <tr> 
      <td width="100%" height="24" colspan="4" class="bline"><table width="600" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="80">�ļ���С��</td>
            <td width="178">
            	<input name="filesize" type="text" id="softsize2" style="width:100" value="1"> 
              <select name="unit" id="unit">
                <option value="MB" selected>MB</option>
                <option value="KB">KB</option>
              </select> </td>
            <td width="75">����ʱ�䣺</td>
            <td width="267">
            	<input name="tm" type="text" id="tm" size="5" value="3">
              ��
              <input name="ts" type="text" id="ts" size="5" value="0">
              ��
             </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline">
      	<table width="600" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="80">��Ʒ���ͣ�</td>
            <td width="180">
			<select name="flashtype" id="flashtype">
                <option value="��ƪ�糡">��ƪ�糡</option>
				<option value="��ƪ�糡">��ƪ�糡</option>
                <option value="MTV">MTV</option>
				<option value="��Ц����" selected>��Ц����</option>
                <option value="С��Ϸ">С��Ϸ</option>
              </select>
			  </td>
            <td width="72">��Ʒ�ȼ���</td>
            <td width="268"><select name="flashrank" id="flashrank" style="width:100">
                <option value="1">һ��</option>
                <option value="2">����</option>
                <option value="3" selected>���� </option>
                <option value="4">����</option>
                <option value="5">����</option>
              </select></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline">
      	<table width="600" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="80">ӰƬ��ȣ�</td>
            <td width="520">
            	<input name="width" type="text" id="width" size="10" value="500">
              �߶ȣ�
              <input name="height" type="text" id="height" size="10" value="400">
             </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline">
      	<table width="600" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="72">FLASH��ַ��</td>
            <td width="320"> <input name="flashurl" type="text" id="flashurl" size="40"></td>
            <td width="141"><input name="downremote" type="checkbox" id="downremote" value="1" class="np">
              Զ���ļ����ػ�</td>
            <td width="67" align="center">
			<input name="selflash" type="button" id="modcolor3" value="ѡȡ" onClick="SelectFlash()"> 
            </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="100" colspan="4" class="bline">
	  &nbsp;&nbsp;��Flash�ӱ����ҳ����(ѡ������Ȼ����Ctrl+C����������Ctrl+V)��ճ�������������ֱ�ӻ�ȡ��ַ���ϴ�������������ѡ��"Զ���ļ����ػ�"����
	  <br/>
	  &nbsp;&nbsp;ճ��λ�ã�
	  <br/>
	  <span id='myflash' style='border:solid 1px #CCCCCC;width:100%;height:150' contentEditable="true"></span>
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
</body>
</html>