<?php 
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
<input type="hidden" name="ID" value="<?php echo $arcRow['ID']?>">
<input type="hidden" name="channelid" value="<?php echo $channelid?>">
<input type="hidden" name="arcrank" value="<?php echo $arcRow['arcrank']?>">
<input type="hidden" name="source" value="��վ">
<input type="hidden" name="typeid2" value="0">
  <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr> 
      <td width="4%" height="30"><IMG height=14 src="img/book1.gif" width=20> 
        &nbsp;</td>
      <td width="85%"><a href="content_s_list.php"><u>ר���б�</u></a><a href="catalog_do.php?cid=<?php echo $cid?>&channelid=<?php echo $channelid?>&dopost=listArchives"></a>&gt;&gt;�޸�ר��</td>
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
  <table width="98%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr><td height="2"></td></tr>
</table>
  <table width="98%"  border="0" align="center" cellpadding="2" cellspacing="2" id="needset">
    <tr> 
      <td width="400%" height="24" colspan="4" class="bline"> <table width="600" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="80">ר�����ƣ�</td>
            <td width="224"><input name="title" type="text" id="title" style="width:200" value="<?php echo $arcRow['title']?>"></td>
            <td width="73">���Ӳ�����</td>
            <td width="223"> <input name="iscommend" type="checkbox" id="iscommend" value="11" class="np"<?php  if($arcRow["iscommend"]>10) echo " checked";?>>
              �Ƽ� 
              <input name="isbold" type="checkbox" id="isbold" value="5" class="np"<?php  if($arcRow["iscommend"]>10) echo " checked";?>>
              �Ӵ� </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline"> <table width="600" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="80">С���⣺</td>
            <td width="224"><input name="shorttitle" type="text" value="<?php echo $arcRow["shorttitle"]?>" id="shorttitle" style="width:200"></td>
            <td width="73">�Զ����ԣ�</td>
            <td width="223"> <select name='arcatt' style='width:150'>
                <option value='0'>��ͨ�ĵ�</option>
                <?php 
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
            <td width="337"> <input name="picname" type="text" id="picname" style="width:230" value="<?php echo $arcRow["litpic"]?>"> 
              <input type="button" name="Submit" value="���..." style="width:60" onClick="SelectImage('form1.picname','');" class='nbt'> 
            </td>
            <td width="185" align="center"><img src="<?php if($arcRow["litpic"]!="") echo $arcRow["litpic"]; else echo "img/pview.gif";?>" width="150" height="100" id="picview" name="picview"> 
            </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline"><table width="600" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="80">ר��ģ�壺</td>
            <td> <input name="templet" type="text" id="templet" size="30" value="<?php echo $arcRow["templet"]?>"> 
              <input type="button" name="set3" value="���..." style="width:60" onClick="SelectTemplets('form1.templet');" class='nbt'> 
            </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline"><table width="600" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="80">���α༭��</td>
            <td width="224"><input name="writer" type="text" id="writer" value="<?php echo $arcRow["writer"]?>"> 
            </td>
            <td width="63">����ѡ�</td>
            <td> <input name="ishtml" type="radio" class="np" value="1"<?php if($arcRow["ismake"]!=-1) echo " checked";?>>
              ����HTML 
              <input type="radio" name="ishtml" class="np" value="0"<?php if($arcRow["ismake"]==-1) echo " checked";?>>
              ����̬��� </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline"> <table width="600" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="80">��������</td>
            <td width="224"> <select name="sortup" id="sortup" style="width:150">
                <?php 
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
            <td width="159"> <input name="color" type="text" id="color" style="width:120" value="<?php echo $arcRow["color"]?>"> 
            </td>
            <td width="74" align="center"><input name="modcolor" type="button" id="modcolor" value="ѡȡ" onClick="ShowColor()" class='nbt'></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline"><table width="600" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td height="78">ר��˵����</td>
            <td> <textarea name="description" rows="4" id="textarea" style="width:350"><?php echo $arcRow["description"]?></textarea> 
            </td>
          </tr>
          <tr> 
            <td width="80" height="51">�ؼ��֣�</td>
            <td> <textarea name="keywords" rows="3" id="textarea2" style="width:180"><?php echo $arcRow["keywords"]?></textarea> 
            </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline"> <table width="600" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="80">����ʱ�䣺</td>
            <td> 
              <?php 
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
              <?php 
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
            <td width="446"><?php 
			//$dsql = new DedeSql(false);
			$seltypeids = $dsql->GetOne("Select ID,typename From #@__arctype where ID='".$arcRow["typeid"]."' ");
			if(is_array($seltypeids)){
			   echo GetTypeidSel('form1','typeid','selbt2',0,$seltypeids['ID'],$seltypeids['typename']);
			}else{
			   echo GetTypeidSel('form1','typeid','selbt2',0,0,'��ѡ��...');
			}
            ?></td>
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
          <?php 
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
              <?php echo $i?>
              ���ƣ�</td>
            <td colspan="2"> <table width="600" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="310"><input name="notename<?php echo $i?>" type="text" id="notename<?php echo $i?>" style="width:300" value="<?php echo $notename?>"> 
                  </td>
                  <td width="90" align="center">�ڵ��ʶ��</td>
                  <td width="200"><input name="noteid<?php echo $i?>" type="text" id="noteid<?php echo $i?>" style="width:100" value="<?php echo $noteid?>"></td>
                </tr>
              </table></td>
          </tr>
          <tr> 
            <td>�ڵ������б�</td>
            <td><textarea name="arcid<?php echo $i?>" rows="3" id="arcid<?php echo $i?>" style="width:90%"><?php echo $idlist?></textarea></td>
            <td align="center">
            <input name="selarc<?php echo $i?>" type="button" id="selarc<?php echo $i?>2" value="ѡ��ڵ�����" style="width:100" onClick="SelectArcList('form1.arcid<?php echo $i?>');" class='nbt'>
            </td>
          </tr>
          <tr> 
            <td>�ĵ���Դ��</td>
            <td colspan="2">
            	<input name="isauto<?php echo $i?>" type="radio" id="isauto<?php echo $i?>" value="0" class="np"<?php if($isauto==0) echo " checked";?>>
            	�������б�
            	<input name="isauto<?php echo $i?>" type="radio" id="isauto<?php echo $i?>" value="1" class="np"<?php if($isauto==1) echo " checked";?>>
            	�Զ���ȡ�ĵ�
            	&nbsp;
            	�ؼ��֣�
            	<input name="keywords<?php echo $i?>" type="text" value="<?php echo $keywords?>" id="keywords<?php echo $i?>" value="" size="16">(���ŷֿ�)
            	��ĿID��
            	<input name="typeid<?php echo $i?>" type="text" value="<?php echo $typeid?>" id="typeid<?php echo $i?>" value="0" size="4">
            </td>
          </tr>
          <tr> 
            <td height="51" rowspan="2" valign="top">�ڵ㲼�֣�<br/> </td>
            <td colspan="2">������ <input name="col<?php echo $i?>" type="text" id="col<?php echo $i?>" value="<?php echo $col?>" size="3">
              ͼƬ�ߣ� <input name="imgheight<?php echo $i?>" type="text" id="imgheight<?php echo $i?>" value="<?php echo $imgwidth?>" size="3">
              ͼƬ�� <input name="imgwidth<?php echo $i?>" type="text" id="imgwidth<?php echo $i?>" value="<?php echo $imgheight?>" size="3">
              ���ⳤ��
              <input name="titlelen<?php echo $i?>" type="text" id="titlelen<?php echo $i?>" value="<?php echo $titlelen?>" size="3">
              ��鳤�� 
              <input name="infolen<?php echo $i?>" type="text" id="infolen<?php echo $i?>" value="<?php echo $infolen?>" size="3"> 
              �ĵ����� 
              <input name="rownum<?php echo $i?>" type="text" id="rownum<?php echo $i?>" value="<?php echo $rownum?>" size="3">
            </td>
          </tr>
          <tr> 
            <td colspan="2">������¼��ģ�壺<br/>
            <textarea name="listtmp<?php echo $i?>" rows="3" id="listtmp<?php echo $i?>" style="width:60%"><?php echo $temp?></textarea></td>
          </tr>
      <?php 
      	$i++;
      }}
      $dtp->Clear();
		  for($i;$i<=$cfg_specnote;$i++)
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
            <td><textarea name="arcid<?php echo $i?>" rows="3" id="arcid<?php echo $i?>" style="width:90%"></textarea></td>
            <td align="center">
            <input name="selarc<?php echo $i?>" type="button" id="selarc<?php echo $i?>2" value="ѡ��ڵ�����" style="width:100" onClick="SelectArcList('form1.arcid<?php echo $i?>');" class='nbt'>
            </td>
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
            	<input name="keywords<?php echo $i?>" type="text" id="keywords<?php echo $i?>" value="" size="16">(�ո�ֿ�)
            	��ĿID��
            	<input name="typeid<?php echo $i?>" type="text" id="typeid<?php echo $i?>" value="0" size="4">
            </td>
          </tr>
          <tr> 
            <td height="51" rowspan="2" valign="top">�ڵ㲼�֣�<br/> </td>
            <td colspan="2">������ <input name="col<?php echo $i?>" type="text" id="col<?php echo $i?>" value="1" size="3">
              ͼƬ�ߣ� <input name="imgheight<?php echo $i?>" type="text" id="imgheight<?php echo $i?>" value="90" size="3">
              ͼƬ�� <input name="imgwidth<?php echo $i?>" type="text" id="imgwidth<?php echo $i?>" value="120" size="3">
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