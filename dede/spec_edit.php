<?
require_once(dirname(__FILE__)."/config.php");
CheckPurview('spec_Edit');
require_once(dirname(__FILE__)."/../include/inc_typelink.php");
require_once(dirname(__FILE__)."/../include/pub_dedetag.php");
$aid = ereg_replace("[^0-9]","",$aid);
$channelid="-1";
$dsql = new DedeSql(false);
//��ȡ�鵵��Ϣ
//------------------------------
$arcQuery = "Select 
#@__channeltype.typename as channelname,
#@__archives.* 
From #@__archives
left join #@__channeltype on #@__channeltype.ID=#@__archives.channel 
where #@__archives.ID='$aid'";
$addQuery = "Select * From #@__addonspec where aid='$aid'";

$dsql->SetQuery($arcQuery);
$arcRow = $dsql->GetOne($arcQuery);
if(!is_array($arcRow)){
	$dsql->Close();
	ShowMsg("��ȡ����������Ϣ����!","-1");
	exit();
}

$addRow = $dsql->GetOne($addQuery);

if(!is_array($addRow))
{
	$addRow["note"] = "";
}

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>����ר��</title>
<style type="text/css">
<!--
body { background-image: url(img/allbg.gif); }
-->
</style>
<link href="base.css" rel="stylesheet" type="text/css">
<script language='javascript' src='main.js'></script>
<script language="javascript">
<!--
function SelectTemplets(fname)
{
     var posLeft = window.event.clientY-200;
     var posTop = window.event.clientX-300;
     window.open("../include/dialog/select_templets.php?f="+fname, "poptempWin", "scrollbars=yes,resizable=yes,statebar=no,width=600,height=400,left="+posLeft+", top="+posTop);
}
function SelectArcList(fname)
{
   var posLeft = 10;
   var posTop = 10;
   window.open("content_select_list.php?f="+fname, "selArcList", "scrollbars=yes,resizable=yes,statebar=no,width=700,height=500,left="+posLeft+", top="+posTop);
}
function checkSubmit()
{
   if(document.form1.title.value==""){
	   alert("ר�����Ʋ���Ϊ�գ�");
	   return false;
  }
}
/*
function ShowHide(objname)
{
   var obj = document.getElementById(objname);
   if(obj.style.display=="none") obj.style.display = "block";
	 else obj.style.display="none";
}
function ShowItem1()
{
    ShowObj('head1');
	ShowObj('needset');
	HideObj('head2');
	HideObj('adset');
}
function ShowItem2()
{
    ShowObj('head2');
	ShowObj('adset');
	HideObj('head1');
	HideObj('needset');
}


function ShowColor(){
	var fcolor=showModalDialog("img/color.htm?ok",false,"dialogWidth:106px;dialogHeight:110px;status:0;dialogTop:"+(window.event.clientY+120)+";dialogLeft:"+(window.event.clientX));
	if(fcolor!=null && fcolor!="undefined") document.form1.color.value = fcolor;
}

function SeePic(img,f)
{
   if ( f != "" ) { img.src = f; }
}


function SelectImage(fname,vlist)
{
   var posLeft = window.event.clientY-100;
   var posTop = window.event.clientX-400;
   window.open("../include/dialog/select_images.php?f="+fname+"&imgstick="+vlist, "popUpImagesWin", "scrollbars=yes,resizable=yes,statebar=no,width=600,height=400,left="+posLeft+", top="+posTop);
}
*/
-->
</script>
</head>
<body topmargin="8">
<form name="form1" action="spec_edit_action.php" enctype="multipart/form-data" method="post" onSubmit="return checkSubmit();">
<input type="hidden" name="ID" value="<?=$arcRow['ID']?>">
<input type="hidden" name="channelid" value="<?=$channelid?>">
<input type="hidden" name="arcrank" value="<?=$arcRow['arcrank']?>">
<input type="hidden" name="source" value="��վ">
<input type="hidden" name="typeid2" value="0">
  <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr> 
      <td width="4%" height="30"><IMG height=14 src="img/book1.gif" width=20> 
        &nbsp;</td>
      <td width="85%"><a href="content_s_list.php"><u>ר���б�</u></a><a href="catalog_do.php?cid=<?=$cid?>&channelid=<?=$channelid?>&dopost=listArchives"></a>&gt;&gt;�޸�ר��</td>
      <td width="10%">&nbsp; <a href="makehtml_spec.php">[<u>����HTML</u>]</a></td>
      <td width="1%">&nbsp;</td>
    </tr>
  </table>
  <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" id="head1" style="border-bottom:1px solid #CCCCCC">
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
  <table width="98%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr><td height="2"></td></tr>
</table>
  <table width="98%"  border="0" align="center" cellpadding="2" cellspacing="2" id="needset">
    <tr> 
      <td width="400%" height="24" colspan="4" class="bline"> <table width="600" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="80">ר�����ƣ�</td>
            <td width="224"><input name="title" type="text" id="title" style="width:200" value="<?=$arcRow['title']?>"></td>
            <td width="73">���Ӳ�����</td>
            <td width="223"> <input name="iscommend" type="checkbox" id="iscommend" value="11" class="np"<? if($arcRow["iscommend"]>10) echo " checked";?>>
              �Ƽ� 
              <input name="isbold" type="checkbox" id="isbold" value="5" class="np"<? if($arcRow["iscommend"]>10) echo " checked";?>>
              �Ӵ� </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline"> <table width="600" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="80">С���⣺</td>
            <td width="224"><input name="shorttitle" type="text" value="<?=$arcRow["shorttitle"]?>" id="shorttitle" style="width:200"></td>
            <td width="73">�Զ����ԣ�</td>
            <td width="223"> <select name='arcatt' style='width:150'>
                <option value='0'>��ͨ�ĵ�</option>
                <?
            	$dsql->SetQuery("Select * From #@__arcatt order by att asc");
            	$dsql->Execute();
            	while($trow = $dsql->GetObject())
            	{
            		if($arcRow["arcatt"]==$trow->att) echo "<option value='{$trow->att}' selected>{$trow->attname}</option>";
            		else echo "<option value='{$trow->att}'>{$trow->attname}</option>";
            	}
            	?>
              </select> </td>
          </tr>
        </table></td>
    </tr>
    <tr id="pictable"> 
      <td height="24" colspan="4" class="bline"> <table width="600" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="78" height="81">
            	&nbsp;�� �� ͼ��<br/>
            	&nbsp;<input type='checkbox' class='np' name='ddisremote' value='1'>Զ��
            </td>
            <td width="337"> <input name="picname" type="text" id="picname" style="width:230" value="<?=$arcRow["litpic"]?>"> 
              <input type="button" name="Submit" value="���..." style="width:60" onClick="SelectImage('form1.picname','');"> 
            </td>
            <td width="185" align="center"><img src="<?if($arcRow["litpic"]!="") echo $arcRow["litpic"]; else echo "img/pview.gif";?>" width="150" height="100" id="picview" name="picview"> 
            </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline"><table width="600" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="80">ר��ģ�壺</td>
            <td> <input name="templet" type="text" id="templet" size="30" value="<?=$arcRow["templet"]?>"> 
              <input type="button" name="set3" value="���..." style="width:60" onClick="SelectTemplets('form1.templet');"> 
            </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline"><table width="600" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="80">���α༭��</td>
            <td width="224"><input name="writer" type="text" id="writer" value="<?=$arcRow["writer"]?>"> 
            </td>
            <td width="63">����ѡ�</td>
            <td> <input name="ishtml" type="radio" class="np" value="1"<?if($arcRow["ismake"]!=-1) echo " checked";?>>
              ����HTML 
              <input type="radio" name="ishtml" class="np" value="0"<?if($arcRow["ismake"]==-1) echo " checked";?>>
              ����̬��� </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline"> <table width="600" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="80">��������</td>
            <td width="224"> <select name="sortup" id="sortup" style="width:150">
                <?
                $subday = SubDay($arcRow["sortrank"],$arcRow["senddate"]);
                echo "<option value='0'>��������</option>\r\n";
                if($subday>0) echo "<option value='$subday' selected>�ö� $subday ��</option>\r\n";
                ?>
                <option value="7">�ö�һ��</option>
                <option value="30">�ö�һ����</option>
                <option value="90">�ö�������</option>
                <option value="180">�ö�����</option>
                <option value="360">�ö�һ��</option>
              </select> </td>
            <td width="63">������ɫ��</td>
            <td width="159"> <input name="color" type="text" id="color" style="width:120" value="<?=$arcRow["color"]?>"> 
            </td>
            <td width="74" align="center"><input name="modcolor" type="button" id="modcolor" value="ѡȡ" onClick="ShowColor()"></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline"><table width="600" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td height="78">ר��˵����</td>
            <td> <textarea name="description" rows="4" id="textarea" style="width:350"><?=$arcRow["description"]?></textarea> 
            </td>
          </tr>
          <tr> 
            <td width="80" height="51">�ؼ��֣�</td>
            <td> <textarea name="keywords" rows="3" id="textarea2" style="width:180"><?=$arcRow["keywords"]?></textarea> 
            </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline"> <table width="600" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="80">����ʱ�䣺</td>
            <td> 
              <?
			         $addtime = GetDateTimeMk($arcRow["senddate"]);
			         echo "$addtime (��׼���������HTML���Ƶ�����ʱ��) <input type='hidden' name='senddate' value='".$arcRow["senddate"]."'>";
			        ?>
            </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline"> <table width="600" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="80">����ʱ�䣺</td>
            <td> 
              <?
			$nowtime = GetDateTimeMk($arcRow["pubdate"]);
			echo "<input name=\"pubdate\" value=\"$nowtime\" type=\"text\" id=\"pubdate\" style=\"width:200\">";
			echo "<input name=\"selPubtime\" type=\"button\" id=\"selkeyword\" value=\"ѡ��\" onClick=\"showCalendar('pubdate', '%Y-%m-%d %H:%M:00', '24');\">";
			?>
            </td>
            <td width="234">&nbsp;</td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline"><table width="600" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="80">�����ࣺ</td>
            <td width="446"> 
              <?
           	$tl = new TypeLink($arcRow["typeid"]);
           	$typeOptions = $tl->GetOptionArray($arcRow["typeid"],$cuserLogin->getUserChannel(),$channelid);
           	echo "<select name='typeid' style='width:300'>\r\n";
            if($arcRow["typeid"]=="0") echo "<option value='0' selected>��ѡ��������...</option>\r\n";
            echo $typeOptions;
            echo "</select>";
			 ?>
            </td>
            <td width="74" align="center">&nbsp; </td>
          </tr>
        </table></td>
    </tr>
  </table>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr><td height="2"></td></tr>
</table>
  <table width="98%"  border="0" align="center" cellpadding="2" cellspacing="2" style="display:none" id="adset">
    <tr> 
      <td height="24" bgcolor="#F1F5F2" class="bline2"> <strong>ר��ڵ��б�</strong> 
        (�����б���ID1,ID2,ID3������ʽ�ֿ���ϵͳ���Զ��ų���ͬ�ڵ����ͬ����) <br/>
        ���ڵ�����¼ģ�����[field:fieldname /]��ǵ�ʹ�ã���ο�����ϵͳ�������� arclist ��ǵ�˵����</td>
    </tr>
    <tr> 
      <td height="24" valign="top" class="bline">
        <table width="800" border="0" cellspacing="2" cellpadding="2">
          <?
		  $speclisttmp = GetSysTemplets("spec_arclist.htm");
		  $i = 1;
		  $dtp = new DedeTagParse();
      $dtp->LoadSource($addRow["note"]);
      if(is_array($dtp->CTags)){
      foreach($dtp->CTags as $tagid=>$ctag)
      {
      	if($ctag->GetName()!="specnote") continue;
      	$notename = $ctag->GetAtt('name');
      	$col = $ctag->GetAtt('col');
      	$idlist = $ctag->GetAtt('idlist');
      	$imgwidth = $ctag->GetAtt('imgwidth');
      	$imgheight = $ctag->GetAtt('imgheight');
      	$titlelen = $ctag->GetAtt('titlelen');
      	$infolen = $ctag->GetAtt('infolen');
      	$temp = trim($ctag->GetInnerText());
      	$noteid = $ctag->GetAtt('noteid');
      	if(empty($noteid)) $noteid = $i;
      	$isauto = $ctag->GetAtt('isauto');
      	if(empty($isauto)) $isauto = 0;
      	$keywords = $ctag->GetAtt('keywords');
      	$typeid = $ctag->GetAtt('typeid');
      	if(empty($typeid)) $typeid = 0;
      	$rownum = $ctag->GetAtt('rownum');
      	if(empty($rownum)) $rownum = 40;
      ?>
          <tr bgcolor="#EEF8E0"> 
            <td width="113">�ڵ� 
              <?=$i?>
              ���ƣ�</td>
            <td colspan="2"> <table width="600" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="310"><input name="notename<?=$i?>" type="text" id="notename<?=$i?>" style="width:300" value="<?=$notename?>"> 
                  </td>
                  <td width="90" align="center">�ڵ��ʶ��</td>
                  <td width="200"><input name="noteid<?=$i?>" type="text" id="noteid<?=$i?>" style="width:100" value="<?=$noteid?>"></td>
                </tr>
              </table></td>
          </tr>
          <tr> 
            <td>�ڵ������б�</td>
            <td><textarea name="arcid<?=$i?>" rows="3" id="arcid<?=$i?>" style="width:90%"><?=$idlist?></textarea></td>
            <td align="center"><input name="selarc<?=$i?>" type="button" id="selarc<?=$i?>2" value="ѡ��ڵ�����" style="width:100" onClick="SelectArcList('form1.arcid<?=$i?>');"></td>
          </tr>
          <tr> 
            <td>�ĵ���Դ��</td>
            <td colspan="2">
            	<input name="isauto<?=$i?>" type="radio" id="isauto<?=$i?>" value="0" class="np"<?if($isauto==0) echo " checked";?>>
            	�������б�
            	<input name="isauto<?=$i?>" type="radio" id="isauto<?=$i?>" value="1" class="np"<?if($isauto==1) echo " checked";?>>
            	�Զ���ȡ�ĵ�
            	&nbsp;
            	�ؼ��֣�
            	<input name="keywords<?=$i?>" type="text" value="<?=$keywords?>" id="keywords<?=$i?>" value="" size="16">(���ŷֿ�)
            	��ĿID��
            	<input name="typeid<?=$i?>" type="text" value="<?=$typeid?>" id="typeid<?=$i?>" value="0" size="4">
            </td>
          </tr>
          <tr> 
            <td height="51" rowspan="2" valign="top">�ڵ㲼�֣�<br/> </td>
            <td colspan="2">������ <input name="col<?=$i?>" type="text" id="col<?=$i?>" value="<?=$col?>" size="3">
              ͼƬ�ߣ� <input name="imgheight<?=$i?>" type="text" id="imgheight<?=$i?>" value="<?=$imgwidth?>" size="3">
              ͼƬ�� <input name="imgwidth<?=$i?>" type="text" id="imgwidth<?=$i?>" value="<?=$imgheight?>" size="3">
              ���ⳤ��
              <input name="titlelen<?=$i?>" type="text" id="titlelen<?=$i?>" value="<?=$titlelen?>" size="3">
              ��鳤�� 
              <input name="infolen<?=$i?>" type="text" id="infolen<?=$i?>" value="<?=$infolen?>" size="3"> 
              �ĵ����� 
              <input name="rownum<?=$i?>" type="text" id="rownum<?=$i?>" value="<?=$rownum?>" size="3">
            </td>
          </tr>
          <tr> 
            <td colspan="2">������¼��ģ�壺<br/>
            <textarea name="listtmp<?=$i?>" rows="3" id="listtmp<?=$i?>" style="width:60%"><?=$temp?></textarea></td>
          </tr>
      <?
      	$i++;
      }}
      $dtp->Clear();
		  for($i;$i<=$cfg_specnote;$i++)
		  {
		  ?>
          <tr bgcolor="#EEF8E0"> 
            <td width="113">�ڵ� 
              <?=$i?>
              ���ƣ�</td>
            <td colspan="2"> <table width="600" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="310"><input name="notename<?=$i?>" type="text" id="notename<?=$i?>" style="width:300"> 
                  </td>
                  <td width="90" align="center">�ڵ��ʶ��</td>
                  <td width="200"><input name="noteid<?=$i?>" type="text" id="noteid<?=$i?>" style="width:100"></td>
                </tr>
              </table></td>
          </tr>
          <tr> 
            <td>�ڵ������б�</td>
            <td><textarea name="arcid<?=$i?>" rows="3" id="arcid<?=$i?>" style="width:90%"></textarea></td>
            <td align="center"><input name="selarc<?=$i?>" type="button" id="selarc<?=$i?>2" value="ѡ��ڵ�����" style="width:100" onClick="SelectArcList('form1.arcid<?=$i?>');"></td>
          </tr>
          <tr> 
            <td>�ĵ���Դ��</td>
            <td colspan="2">
            	<input name="isauto<?=$i?>" type="radio" id="isauto<?=$i?>" value="0" class="np" checked>
            	�������б�
            	<input name="isauto<?=$i?>" type="radio" id="isauto<?=$i?>" value="1" class="np">
            	�Զ���ȡ�ĵ�
            	&nbsp;
            	�ؼ��֣�
            	<input name="keywords<?=$i?>" type="text" id="keywords<?=$i?>" value="" size="16">(�ո�ֿ�)
            	��ĿID��
            	<input name="typeid<?=$i?>" type="text" id="typeid<?=$i?>" value="0" size="4">
            </td>
          </tr>
          <tr> 
            <td height="51" rowspan="2" valign="top">�ڵ㲼�֣�<br/> </td>
            <td colspan="2">������ <input name="col<?=$i?>" type="text" id="col<?=$i?>" value="1" size="3">
              ͼƬ�ߣ� <input name="imgheight<?=$i?>" type="text" id="imgheight<?=$i?>" value="90" size="3">
              ͼƬ�� <input name="imgwidth<?=$i?>" type="text" id="imgwidth<?=$i?>" value="120" size="3">
              ���ⳤ��
              <input name="titlelen<?=$i?>" type="text" id="titlelen<?=$i?>" value="60" size="3">
              ��鳤�� 
              <input name="infolen<?=$i?>" type="text" id="infolen<?=$i?>" value="160" size="3"> 
              �ĵ����� 
              <input name="rownum<?=$i?>" type="text" id="rownum<?=$i?>" value="40" size="3">
            </td>
          </tr>
          <tr> 
            <td colspan="2">������¼��ģ�壺<br/> <textarea name="listtmp<?=$i?>" rows="3" id="listtmp<?=$i?>" style="width:60%"><?=$speclisttmp?></textarea></td>
          </tr>
          <?
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
<?
$dsql->Close();
?>
</body>
</html>