<?
require_once(dirname(__FILE__)."/config.php");
require_once(dirname(__FILE__)."/inc/inc_catalog_options.php");
$channelid="3";
if(empty($cid)) $cid = 0;
$dsql = new DedeSql(false);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>���������</title>
<style type="text/css">
<!--
body { background-image: url(img/allbg.gif); }
-->
</style>
<link href="base.css" rel="stylesheet" type="text/css">
<script language='javascript' src='main.js'></script>
<script language="javascript">
<!--
function checkSubmit()
{
   if(document.form1.title.value==""){
	   alert("������Ʋ���Ϊ�գ�");
	   document.form1.title.focus();
	   return false;
  }
  if(document.form1.typeid.value==0){
	   alert("��ѡ�񵵰��������");
	   return false;
  }
}

function MakeUpload()
{
   var startNum = 2;
   var upfield = document.getElementById("uploadfield");
   var endNum =  document.form1.picnum.value;
   if(endNum>9) endNum = 9;
   upfield.innerHTML = "";
   for(startNum;startNum<=endNum;startNum++){
	   upfield.innerHTML += "�����ַ"+startNum+"��<input type='text' name='softurl"+startNum+"' style='width:280' value='http://'> ";
	   upfield.innerHTML += " ";
	   upfield.innerHTML += "���������ƣ�<input type='text' name='servermsg"+startNum+"' style='width:150'><br/>\r\n";
	 }
}
-->
</script>
</head>
<body topmargin="8">
<form name="form1" action="soft_add_action.php" enctype="multipart/form-data" method="post" onSubmit="return checkSubmit();">
<input type="hidden" name="channelid" value="<?=$channelid?>">
  <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr> 
      <td width="4%" height="30"><IMG height=14 src="img/book1.gif" width=20> 
        &nbsp;</td>
      <td width="64%"><a href="catalog_do.php?cid=<?=$cid?>&channelid=<?=$channelid?>&dopost=listArchives"><u>����б�</u></a>&gt;&gt;���������</td>
      <td width="31%" align="right">&nbsp; <a href="catalog_main.php">[<u>��Ŀ����</u>]</a> 
        [<a href="soft_config.php"><u>����Ƶ�������趨</u></a>]</td>
      <td width="1%">&nbsp;</td>
    </tr>
  </table>
  <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" id="head1" style="border-bottom:1px solid #CCCCCC">
    <tr> 
      <td colspan="2">
	  <table border="0" cellpadding="0" cellspacing="0">
          <tr> 
            <td width="84" height="24" align="center" background="img/itemnote1.gif">&nbsp;�������&nbsp;</td>
            <td width="84" align="center" background="img/itemnote2.gif"><a href="#" onClick="ShowItem2()"><u>�������</u></a>&nbsp;</td>
          </tr>
        </table></td>
    </tr>
  </table>
  <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" id="head2" style="border-bottom:1px solid #CCCCCC;display:none">
    <tr> 
      <td colspan="2">
	  <table height="24" border="0" cellpadding="0" cellspacing="0">
          <tr> 
            <td width="84" align="center" background="img/itemnote2.gif"><a href="#" onClick="ShowItem1()"><u>�������</u></a>&nbsp;</td>
            <td width="84" align="center" background="img/itemnote1.gif">�������&nbsp;</td>
          </tr>
        </table></td>
    </tr>
  </table>
  <table width="98%" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
      <td height="2"></td>
    </tr>
  </table>
  <table width="98%"  border="0" align="center" cellpadding="2" cellspacing="2" id="needset">
    <tr> 
      <td width="400%" height="24" colspan="4" class="bline"> <table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90">&nbsp;������ƣ�</td>
            <td width="250"> <input name="title" type="text" id="title" style="width:230"> 
            </td>
            <td width="90">���Ӳ�����</td>
            <td>
            	<input name="iscommend" type="checkbox" id="iscommend" value="11" class="np">
              �Ƽ� 
              <input name="isbold" type="checkbox" id="isbold" value="5" class="np">
              �Ӵ�
              <input name="isjump" type="checkbox" id="isjump" value="1" onClick="ShowUrlTr()" class="np">
              ��ת��ַ
            </td>
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
       </table>
	 </td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline"> <table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90">���Ա��⣺</td>
            <td width="250"> <input name="shorttitle" type="text" id="shorttitle" style="width:150"> 
            </td>
            <td width="90">�Զ������ԣ�</td>
            <td> <select name='arcatt' style='width:150'>
                <option value='0'>��ͨ�ĵ�</option>
                <?
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
                    <input type="button" name="Submit2" value="����վ��ѡ��" style="width:120" onClick="SelectImage('form1.picname','small');"> 
                  </td>
                </tr>
              </table></td>
            <td width="201" align="center"><img src="img/pview.gif" width="150" id="picview" name="picview"></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline"><table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90">&nbsp;�����Դ��</td>
            <td width="240"> 
              <input name="source" type="text" id="source" style="width:200">
            </td>
            <td width="90">������ߣ�</td>
            <td width="159"><input name="writer" type="text" id="writer" style="width:120"></td>
			<td>&nbsp;</td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline"> <table width="800" border="0" cellspacing="0" cellpadding="0">
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
            <td width="159"> <input name="color" type="text" id="color" style="width:120"> 
            </td>
            <td> <input name="modcolor" type="button" id="modcolor" value="ѡȡ" onClick="ShowColor()"> 
            </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline"><table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90">&nbsp;�Ķ�Ȩ�ޣ�</td>
            <td width="240"> <select name="arcrank" id="arcrank" style="width:150">
                <?
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
      <td height="76" colspan="4" class="bline"> <table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90" height="51">&nbsp;��Ҫ˵����</td>
            <td width="240"> <textarea name="description" rows="3" id="description" style="width:200"></textarea> 
            </td>
            <td width="90">�ؼ��֣�</td>
            <td width="234"> <textarea name="keywords" rows="3" id="keywords" style="width:200"></textarea> 
            </td>
            <td width="146" align="center"> �ÿո�ֿ�<br/> <input type="button" name="Submit" value="���..." style="width:56;height:20" onClick="SelectKeywords('form1.keywords');"> 
            </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline"><table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90">&nbsp;&nbsp;����ʱ�䣺</td>
            <td width="400"> 
              <?
			$nowtime = GetDateTimeMk(mytime());
			echo "<input name=\"pubdate\" value=\"$nowtime\" type=\"text\" id=\"pubdate\" style=\"width:200\">";
			?>
            </td>
            <td width="99" align="center">���ѵ�����</td>
            <td width="211"> <input name="money" type="text" id="money" value="0" size="10"> 
            </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline"> <table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90">&nbsp;�������Ŀ��</td>
            <td width="400"> 
              <?
           	$typeOptions = GetOptionList($cid,$cuserLogin->getUserChannel(),$channelid);
		        echo "<select name='typeid' style='width:300'>\r\n";
            echo "<option value='0'>��ѡ��������...</option>\r\n";
            echo $typeOptions;
            echo "</select>";
			     ?>
            </td>
            <td>��ֻ�����ڰ�ɫѡ�����Ŀ�з�����ǰ�������ݣ�</td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" bgcolor="#FFFFFF" class="bline2"> <table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90">&nbsp;�������Ŀ��</td>
            <td> 
              <?
            echo "<select name='typeid2' style='width:300'>\r\n";
            echo "<option value='0' selected>��ѡ�񸱷���...</option>\r\n";
            echo $typeOptions;
            echo "</select>";
            ?>
            </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" bgcolor="#FFFFFF" class="bline2">&nbsp; </td>
    </tr>
  </table>
  <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr><td height="6"></td></tr>
</table>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr><td height="2"></td></tr>
</table>
  <table width="98%"  border="0" align="center" cellpadding="2" cellspacing="2" style="display:none" id="adset">
    <tr> 
      <td width="100%" height="24" colspan="4" class="bline"> <table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90">&nbsp;�ļ����ͣ�</td>
            <td width="240"> 
              <select name="filetype" id="filetype" style="width:100">
                <option value=".exe" selected>.exe</option>
                <option value=".zip">.zip</option>
                <option value=".rar">.rar</option>
                <option value=".iso">.iso</option>
                <option value=".gz">.gz</option>
                <option value="����">����</option>
              </select>
            </td>
            <td width="90">�������ԣ�</td>
            <td> 
              <select name="language" id="language" style="width:100">
                <option value="��������" selected>��������</option>
                <option value="Ӣ�����">Ӣ�����</option>
                <option value="��������">��������</option>
                <option value="��������">��������</option>
              </select>
            </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline"><table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90">&nbsp;������ͣ�</td>
            <td width="240"> 
              <select name="softtype" id="softtype" style="width:100">
                <option value="�������" selected>�������</option>
                <option value="�������">�������</option>
                <option value="��������">��������</option>
              </select>
            </td>
            <td width="90">��Ȩ��ʽ��</td>
            <td> 
              <select name="accredit" id="accredit" style="width:100">
                <option value="�������" selected>�������</option>
                <option value="������">������</option>
                <option value="��Դ���">��Դ���</option>
                <option value="��ҵ���">��ҵ���</option>
                <option value="�ƽ����">�ƽ����</option>
                <option value="��Ϸ���">��Ϸ���</option>
              </select>
            </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline"><table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90">&nbsp;���л�����</td>
            <td width="240"> 
              <input type='text' name='os' value='Win2003,WinXP,Win2000,Win9X' style='width:200'>
            </td>
            <td width="90">����ȼ���</td>
            <td> 
              <select name="softrank" id="softrank" style="width:100">
                <option value="1">һ��</option>
                <option value="2">����</option>
                <option value="3" selected>���� </option>
                <option value="4">����</option>
                <option value="5">����</option>
              </select>
            </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline"><table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90">&nbsp;�ٷ���ַ��</td>
            <td width="240">
<input name="officialUrl" type="text" id="officialUrl" value="http://">
            </td>
            <td width="90">������ʾ��</td>
            <td>
<input name="officialDemo" type="text" id="officialDemo">
            </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline"><table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90">&nbsp;�����С��</td>
            <td width="240"> 
              <input name="softsize" type="text" id="softsize" style="width:100"> 
              <select name="unit" id="unit">
                <option value="MB" selected>MB</option>
                <option value="KB">KB</option>
                <option value="GB">GB</option>
              </select>
            </td>
            <td width="90">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" bgcolor="#F1F5F2" class="bline2"><strong>&nbsp;��������б�</strong></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline"><table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90">&nbsp;�������أ�</td>
            <td>
            	<input name="softurl1" type="text" id="softurl1" size="40">
            	<input name="sel1" type="button" id="sel1" value="ѡȡ" onClick="SelectSoft('form1.softurl1')"> 
            </td>
          </tr>
        </table></td>
    </tr>
    <tr>
      <td height="24" colspan="4" class="bline"><table width="600" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90">&nbsp;������ַ��</td>
            <td>
            	<input name="picnum" type="text" id="picnum" size="8" value="5"> 
              <input name='kkkup' type='button' id='kkkup2' value='���ɱ�' onClick="MakeUpload();">
              (���Ϊ9������)
            </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline">
        <?
	  echo "<span id='uploadfield'></span>";
	  ?>
      </td>
    </tr>
    <tr> 
      <td height="24" colspan="4" bgcolor="#F1F5F2" class="bline2"><strong>�����ϸ���ܣ�</strong></td>
    </tr>
    <tr> 
      <td height="100" colspan="4" class="bline"> 
        <?
	GetEditor("body","",250,"Small");
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
                <td width="99"><img src="img/button_reset.gif" width="60" height="22" border="0" onClick="location.reload();" style="cursor:hand"></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
</table>
</form>
<script language='javascript'>if($Nav()!="IE") ShowObj('adset');</script>
<?
$dsql->Close();
?>
</body>
</html>