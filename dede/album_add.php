<?
require_once(dirname(__FILE__)."/config.php");
require_once(dirname(__FILE__)."/inc/inc_catalog_options.php");
$channelid="2";
if(empty($cid)) $cid = 0;
$dsql = new DedeSql(false);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>����ͼƬ��</title>
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
	   document.form1.title.focus();
	   return false;
  }
  if(document.form1.typeid.value==0){
	   alert("��ѡ�񵵰��������");
	   return false;
  }
  return true;
}

function CheckSelTable(nnum){
	var cbox = $Obj('isokcheck'+nnum);
	var seltb = $Obj('seltb'+nnum);
	if(cbox.checked) seltb.style.display = 'none';
	else seltb.style.display = 'block';
}

var startNum = 1;
function MakeUpload(mnum)
{
   var endNum = 0;
   var upfield = document.getElementById("uploadfield");
   var pnumObj = document.getElementById("picnum");
   var fhtml = "";
 
   if(mnum==0) endNum = startNum + Number(pnumObj.value);
   else endNum = mnum;
   if(endNum>120) endNum = 120;
   
   for(startNum;startNum < endNum;startNum++){
	   fhtml = "";
	   fhtml += "<table width='600'><tr><td><input type='checkbox' name='isokcheck"+startNum+"' id='isokcheck"+startNum+"' value='1' class='np' onClick='CheckSelTable("+startNum+")'>��ʾ/����ͼƬ["+startNum+"]��ѡ��</td></tr></table>";
	   fhtml += "<table width=\"600\" border=\"0\" id=\"seltb"+startNum+"\" cellpadding=\"1\" cellspacing=\"1\" bgcolor=\"#E8F5D6\" style=\"margin-bottom:6px;margin-left:10px\"><tobdy>";
	   fhtml += "<tr bgcolor=\"#F4F9DD\">\r\n";
	   fhtml += "<td height=\"25\" colspan=\"2\">��<strong>ͼƬ"+startNum+"��</strong></td>";
	   fhtml += "</tr>";
	   fhtml += "<tr bgcolor=\"#FFFFFF\"> ";
	   fhtml += "<td width=\"429\" height=\"25\"> �������ϴ��� ";
	   fhtml += "<input type=\"file\" name='imgfile"+startNum+"' style=\"width:330px\"  onChange=\"SeePic(document.picview"+startNum+",document.form1.imgfile"+startNum+");\"></td>";
	   fhtml += "<td width=\"164\" rowspan=\"3\" align=\"center\"><img src=\"img/pview.gif\" width=\"150\" id=\"picview"+startNum+"\" name=\"picview"+startNum+"\"></td>";
	   fhtml += "</tr>";
	   fhtml += "<tr bgcolor=\"#FFFFFF\"> ";
	   fhtml += "<td height=\"25\"> ��ָ����ַ�� ";
	   fhtml += "<input type=\"text\" name='imgurl"+startNum+"' style=\"width:260px\"> ";
	   fhtml += "<input type=\"button\" name='selpic"+startNum+"' value=\"ѡȡ\" style=\"width:65px\" onClick=\"SelectImageN('form1.imgurl"+startNum+"','big','picview"+startNum+"')\">";
	   fhtml += "</td></tr>";
	   fhtml += "<tr bgcolor=\"#FFFFFF\"> ";
	   fhtml += "<td height=\"56\">��ͼƬ��飺 ";
	   fhtml += "<textarea name='imgmsg"+startNum+"' style=\"height:46px;width:330px\"></textarea> </td>";
	   fhtml += "</tr></tobdy></table>\r\n";
	   upfield.innerHTML += fhtml;
  }
}

-->
</script>
</head>
<body topmargin="8">
<form name="form1" action="album_add_action.php" enctype="multipart/form-data" method="post" onSubmit="return checkSubmit();">
<input type="hidden" name="channelid" value="<?=$channelid?>">
<input type="hidden" name="imagebody" value="">
  <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr> 
      <td width="4%" height="30"><IMG height=14 src="img/book1.gif" width=20> 
        &nbsp;</td>
      <td width="85%"><a href="catalog_do.php?cid=<?=$cid?>&channelid=<?=$channelid?>&dopost=listArchives"><u>ͼ���б�</u></a>&gt;&gt;������ͼ��</td>
      <td width="10%">&nbsp; <a href="catalog_main.php">[<u>��Ŀ����</u>]</a> </td>
      <td width="1%">&nbsp;</td>
    </tr>
  </table>
  <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" id="head1" style="border-bottom:1px solid #CCCCCC">
    <tr> 
      <td colspan="2"> <table width="168" border="0" cellpadding="0" cellspacing="0">
          <tr> 
            <td width="84" height="24" align="center" background="img/itemnote1.gif">&nbsp;�������&nbsp;</td>
            <td width="84" align="center" background="img/itemnote2.gif"><a href="#" onClick="ShowItem2()"><u>ͼ������</u></a>&nbsp;</td>
          </tr>
        </table></td>
    </tr>
  </table>
  <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" id="head2" style="border-bottom:1px solid #CCCCCC;display:none">
    <tr> 
      <td colspan="2"> <table width="168" height="24" border="0" cellpadding="0" cellspacing="0">
          <tr> 
            <td width="84" align="center" background="img/itemnote2.gif"><a href="#" onClick="ShowItem1()"><u>�������</u></a>&nbsp;</td>
            <td width="84" align="center" background="img/itemnote1.gif">ͼ������&nbsp;</td>
          </tr>
        </table></td>
    </tr>
  </table>
  <table width="98%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr><td height="2"></td></tr>
</table>
  <table width="98%"  border="0" align="center" cellpadding="2" cellspacing="2" id="needset">
    <tr> 
      <td width="400%" height="24" colspan="4" class="bline"> <table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90">&nbsp;ͼ�����⣺</td>
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
            <td width="90">&nbsp;���Ա��⣺</td>
            <td width="250"><input name="shorttitle" type="text" id="shorttitle" style="width:150"> 
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
            <td width="135" height="81"> &nbsp;�� �� ͼ��<br/>
              &nbsp;
<input type='checkbox' class='np' name='ddisremote' value='1' id='ddisremote' onClick="CkRemote('ddisremote','litpic')">
              Զ��ͼƬ <br>
              &nbsp; 
              <input type='checkbox' class='np' name='ddisfirst' value='1'>
              ͼ����һ��ͼ </td>
            <td width="464"><table width="100%" border="0" cellspacing="1" cellpadding="1">
                <tr> 
                  <td height="30">
                  	�����ϴ��������������ť <input name="litpic" type="file" id="litpic" class="np" style="width:200" onChange="SeePic(document.picview,document.form1.litpic);"> 
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
            <td width="90">&nbsp;ͼƬ��Դ��</td>
            <td> <input name="source" type="text" id="source" style="width:200"> 
            </td>
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
      <td height="76" colspan="4" class="bline"> 
        <table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90" height="51">&nbsp;����ժҪ��</td>
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
            <td width="90">&nbsp;����ʱ�䣺</td>
            <td width="240"> 
              <?
			$nowtime = GetDateTimeMk(mytime());
			echo "<input name=\"pubdate\" value=\"$nowtime\" type=\"text\" id=\"pubdate\" style=\"width:200\">";
			?>
            </td>
            <td width="90" align="center">���ѵ�����</td>
            <td>
<input name="money" type="text" id="money" value="0" size="10">
            </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline"> <table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90">&nbsp;ͼ������Ŀ��</td>
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
            <td width="90">&nbsp;ͼ������Ŀ��</td>
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
      <td height="24" colspan="4" class="bline"><table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="80">&nbsp;���ַ�ʽ��</td>
            <td> <input name="pagestyle" type="radio" class="np" value="1">
              ��ҳ��ʾ 
              <input name="pagestyle" class="np" type="radio" value="2" checked>
              �ֶ�ҳ��ʾ 
              <input type="radio" name="pagestyle" value="3" class="np">
              ���ж���չʾ</td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline"><table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="80">&nbsp;����ʽ������</td>
            <td>�� 
              <input name="row" type="text" id="row" value="3" size="6">
              ���� 
              <input name="col" type="text" id="col" value="3" size="6">
              ��ͼƬ������ƣ� 
              <input name="ddmaxwidth" type="text" id="ddmaxwidth" value="150" size="6">
              ����</td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline"><table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="80">&nbsp;���ƿ�ȣ�</td>
            <td><input name="maxwidth" type="text" id="maxwidth" size="10" value="<?=$cfg_album_width?>">
              (��ֹͼƬ̫����ģ��ҳ�����) </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline"><table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="80">&nbsp;Զ��ͼƬ��</td>
            <td> <input name="isrm" type="checkbox" id="isrm" class="np" value="1" checked>
              ����Զ��ͼƬ </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td width="100%" height="24" colspan="4" class="bline"> <table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="80">&nbsp;ͼƬ��</td>
            <td> 
              <input name="picnum" type="text" id="picnum" size="8" value="10"> 
              <input name='kkkup' type='button' id='kkkup2' value='���ӱ�' onClick="MakeUpload(0);">
              �� ע�����60�����ֹ�ָ����ͼƬ����������дԶ����ַ�� </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline"> <span id="uploadfield"></span> 
        <script language="JavaScript">
	         MakeUpload(7);
	      </script> </td>
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
                  <td width="99"> <img src="img/button_reset.gif" width="60" height="22" border="0" onClick="location.reload();" style="cursor:hand"> 
                  </td>
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