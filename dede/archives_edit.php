<?
require_once(dirname(__FILE__)."/config.php");
require_once(dirname(__FILE__)."/inc/inc_catalog_options.php");
require_once(dirname(__FILE__)."/../include/pub_dedetag.php");
require_once(dirname(__FILE__)."/inc/inc_archives_all.php");
$aid = ereg_replace("[^0-9]","",$aid);
if($aid=="")
{
	ShowMsg("��ûָ���ĵ�ID����������ʱ�ҳ�棡","-1");
	exit();
}
$dsql = new DedeSql(false);
//��ȡ�鵵��Ϣ
//------------------------------
$arcQuery = "Select 
#@__channeltype.typename as channelname,
#@__arcrank.membername as rankname,
#@__archives.* 
From #@__archives
left join #@__channeltype on #@__channeltype.ID=#@__archives.channel 
left join #@__arcrank on #@__arcrank.rank=#@__archives.arcrank
where #@__archives.ID='$aid'";

$dsql->SetQuery($arcQuery);
$arcRow = $dsql->GetOne($arcQuery);
if(!is_array($arcRow)){
	$dsql->Close();
	ShowMsg("��ȡ����������Ϣ����!","-1");
	exit();
}
//----------------------------
$query = "Select * From #@__channeltype where ID='".$arcRow['channel']."'";
$cInfos = $dsql->GetOne($query);
if(!is_array($cInfos)){
	$dsql->Close();
	ShowMsg("��ȡƵ��������Ϣ����!","-1");
	exit();
}
$channelid = $arcRow['channel'];
$addtable = $cInfos['addtable'];
//-----------------------
$addQuery = "Select * From ".$cInfos['addtable']." where aid='$aid'";
$addRow = $dsql->GetOne($addQuery);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�����ĵ�</title>
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
function checkSubmit()
{
   if(document.form1.title.value==""){
	 alert("�ĵ����ⲻ��Ϊ�գ�");
	 return false;
  }
  if(document.form1.seltypeid.value==0&&document.form1.typeid.value==0){
	   alert("��ѡ�񵵰��������");
	   return false;
  }
}
-->
</script>
</head>
<body topmargin="8">
<form name="form1" action="archives_edit_action.php" enctype="multipart/form-data" method="post" onSubmit="return checkSubmit();">
  <input type="hidden" name="channelid" value="<?=$channelid?>">
  <input type="hidden" name="ID" value="<?=$aid?>">
  <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr> 
      <td width="4%" height="30"><IMG height=14 src="img/book1.gif" width=20> 
        &nbsp;</td>
      <td width="85%"><a href="catalog_do.php?cid=<?=$arcRow['typeid']?>&dopost=listArchives"><u>�ĵ��б�</u></a><a href="catalog_do.php?cid=<?=$arcRow["typeid"]?>&dopost=listArchives"></a>&gt;&gt;�����ĵ�</td>
      <td width="10%">&nbsp; <a href="catalog_main.php">[<u>��Ŀ����</u>]</a> </td>
      <td width="1%">&nbsp;</td>
    </tr>
  </table>
  <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" id="head1" style="border-bottom:1px solid #CCCCCC">
    <tr> 
      <td colspan="2"> <table width="168" border="0" cellpadding="0" cellspacing="0">
          <tr> 
            <td width="84" height="24" align="center" background="img/itemnote1.gif">&nbsp;�������&nbsp;</td>
            <td width="84" align="center" background="img/itemnote2.gif"><a href="#" onClick="ShowItem2()"><u>��������</u></a>&nbsp;</td>
          </tr>
        </table></td>
    </tr>
  </table>
  <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" id="head2" style="border-bottom:1px solid #CCCCCC;display:none">
    <tr> 
      <td colspan="2"> <table width="168" height="24" border="0" cellpadding="0" cellspacing="0">
          <tr> 
            <td width="84" align="center" background="img/itemnote2.gif"><a href="#" onClick="ShowItem1()"><u>�������</u></a>&nbsp;</td>
            <td width="84" align="center" background="img/itemnote1.gif">��������&nbsp;</td>
          </tr>
        </table></td>
    </tr>
  </table>
  <table width="98%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr><td height="2"></td></tr>
</table>
  <table width="98%"  border="0" align="center" cellpadding="2" cellspacing="2" id="needset">
    <tr> 
      <td height="24" colspan="4" class="bline"> <table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90">�ĵ����⣺</td>
            <td width="240">
<input name="title" type="text" id="title" style="width:200" value="<?=$arcRow["title"]?>">
            </td>
            <td width="90">���Ӳ�����</td>
            <td> 
              <input name="iscommend" type="checkbox" id="iscommend" value="11" class="np"<? if($arcRow["iscommend"]>10) echo " checked";?>>
              �Ƽ� 
              <input name="isbold" type="checkbox" id="isbold" value="5" class="np"<? if($arcRow["iscommend"]==5||$arcRow["iscommend"]==16) echo " checked";?>>
              �Ӵ�
              <input name="isjump" type="checkbox" onClick="ShowUrlTrEdit()" id="isjump" value="1" class="np"<? echo $arcRow["redirecturl"]=="" ? "" : " checked";?>>
              ��ת��ַ
            </td>
          </tr>
        </table></td>
    </tr>
    <tr>
      <td height="24" colspan="4" class="bline" id="redirecturltr" style="display:<? echo $arcRow["redirecturl"]=="" ? "none" : "block";?>">
	   <table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90">&nbsp;��ת��ַ��</td>
            <td> <input name="redirecturl" type="text" id="redirecturl" style="width:300" value="<?=$arcRow["redirecturl"]?>"> 
            </td>
          </tr>
       </table>
	 </td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline">
      	<table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90">���Ա��⣺</td>
            <td width="240">
<input name="shorttitle" type="text" value="<?=$arcRow["shorttitle"]?>" id="shorttitle" style="width:200">
            </td>
            <td width="90">�Զ����ԣ�</td>
            <td> 
              <select name='arcatt' style='width:150'>
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
              </select>
            </td>
          </tr>
        </table>
        </td>
    </tr>
    <tr id="pictable"> 
      <td height="24" colspan="4" class="bline"> <table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90" height="81">
            	&nbsp;�� �� ͼ��<br/>
            	&nbsp;<input type='checkbox' class='np' name='ddisremote' value='1'>Զ��
            </td>
            <td width="340"> 
              <input name="picname" type="text" id="picname" style="width:230" value="<?=$arcRow["litpic"]?>"> 
              <input type="button" name="Submit" value="���..." style="width:60" onClick="SelectImage('form1.picname','');">
            </td>
            <td align="center"><img src="<?if($arcRow["litpic"]!="") echo $arcRow["litpic"]; else echo "img/pview.gif";?>" width="150" height="100" id="picview" name="picview"> 
            </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline"> 
        <table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90">�ĵ���Դ��</td>
            <td width="240"> <input name="source" type="text" id="source" style="width:160" value="<?=$arcRow["source"]?>" size="16">
              <input name="selsource" type="button" id="selsource" value="ѡ��"></td>
            <td width="90">�����ߣ�</td>
            <td> 
              <input name="writer" type="text" id="writer" style="width:120" value="<?=$arcRow["writer"]?>"> 
              <input name="selwriter" type="button" id="selwriter" value="ѡ��"> 
            </td>
          </tr>
        </table>
        <script language='javascript'>InitPage();</script> </td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline"> <table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90">�ĵ�����</td>
            <td width="240"> <select name="sortup" id="sortup" style="width:150">
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
            <td width="90">������ɫ��</td>
            <td> <input name="color" type="text" id="color" style="width:120" value="<?=$arcRow["color"]?>"> 
              <input name="modcolor" type="button" id="modcolor" value="ѡȡ" onClick="ShowColor()"> 
            </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline"> <table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90">�Ķ�Ȩ�ޣ�</td>
            <td width="240"> 
              <select name="arcrank" id="arcrank" style="width:150">
                <option value='<?=$arcRow["arcrank"]?>'>
                <?=$arcRow["rankname"]?>
                </option>
                <?
              $urank = $cuserLogin->getUserRank();
              $dsql->SetQuery("Select * from #@__arcrank where adminrank<='$urank'");
              $dsql->Execute();
              while($row = $dsql->GetObject())
              {
              	echo "     <option value='".$row->rank."'>".$row->membername."</option>\r\n";
              }
              ?>
              </select>
            </td>
            <td width="90">����ѡ�</td>
            <td> <input name="ishtml" type="radio" class="np" value="1"<?if($arcRow["ismake"]!=-1) echo " checked";?>>
              ����HTML 
              <input type="radio" name="ishtml" class="np" value="0"<?if($arcRow["ismake"]==-1) echo " checked";?>>
              ����̬��� </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="75" colspan="4" class="bline"> <table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90" height="51">�ĵ�ժҪ��</td>
            <td width="240"> 
              <textarea name="description" rows="3" id="description" style="width:200"><?=$arcRow["description"]?></textarea>
            </td>
            <td width="90">�ؼ��֣�</td>
            <td> <textarea name="keywords" rows="3" id="keywords" style="width:200"><?=$arcRow["keywords"]?></textarea> 
            </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline"> <table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90">¼��ʱ�䣺</td>
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
      <td height="24" colspan="4" class="bline"> <table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90">����ʱ�䣺</td>
            <td width="360"> 
              <?
			$nowtime = GetDateTimeMk($arcRow["pubdate"]);
			echo "<input name=\"pubdate\" value=\"$nowtime\" type=\"text\" id=\"pubdate\" style=\"width:200\">";
			?>
            </td>
            <td width="90" align="center">���ѵ�����</td>
            <td>
<input name="money" type="text" id="money" value="<?=$arcRow["money"]?>" size="10">
            </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline"> <table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90">�ĵ�����Ŀ��</td>
            <td width="417"> 
              <?
           	$typeOptions = GetOptionList($arcRow["typeid"],$cuserLogin->getUserChannel(),$channelid);
           	echo "<select name='typeid' style='width:300'>\r\n";
            if($arcRow["typeid"]=="0") echo "<option value='0' selected>��ѡ��������...</option>\r\n";
            echo $typeOptions;
            echo "</select>";
			    ?>
            </td>
            <td width="293">��ֻ�����ڰ�ɫѡ�����Ŀ�з�����ǰ�������ݣ�</td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline"> <table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90">�ĵ�����Ŀ��</td>
            <td> 
              <?
            $typeOptions = GetOptionList($arcRow["typeid2"],$cuserLogin->getUserChannel(),$channelid);
            echo "<select name='typeid2' style='width:300'>\r\n";
            if($arcRow["typeid2"]=="0") echo "<option value='0' selected>��ѡ�񸱷���...</option>\r\n";
            echo $typeOptions;
            echo "</select>";
            ?>
            </td>
          </tr>
        </table></td>
    </tr>
  </table>
  <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr><td height="2"></td></tr>
</table>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" style="display:none" id="adset">
  <tr>
    <td>
      <table width="100%"  border="0" align="center" cellpadding="2" cellspacing="2" id="addtable">
        <?
        $dtp = new DedeTagParse();
	      $dtp->SetNameSpace("field","<",">");
        $dtp->LoadSource($cInfos['fieldset']);
        $dede_addonfields = "";
        if(is_array($dtp->CTags))
        {
        	foreach($dtp->CTags as $tid=>$ctag){
        		if($dede_addonfields=="") $dede_addonfields = $ctag->GetName().",".$ctag->GetAtt('type');
        		else $dede_addonfields .= ";".$ctag->GetName().",".$ctag->GetAtt('type');
        ?>
        <tr> 
          <td width="100%" height="24" colspan="4" class="bline">
          	<?
          	echo GetFormItemValue($ctag,$addRow[$ctag->GetName()]);
          	?>
          </td>
         </tr>
         <?
         }
         echo "<input type='hidden' name='dede_addtablename' value=\"".$addtable."\">\r\n";
         echo "<input type='hidden' name='dede_addonfields' value=\"".$dede_addonfields."\">\r\n";
         }
         ?>
      </table>
    </td>
  </tr>
</table>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
      <td height="56" valign="top"><table width="100%" border="0" cellspacing="1" cellpadding="1">
          <tr> 
            <td width="17%">&nbsp;</td>
            <td width="83%"><table width="214" border="0" cellspacing="0" cellpadding="0">
                <tr> 
                  <td width="115"><input name="imageField" type="image" src="img/button_ok.gif" width="60" height="22" border="0" class="np"></td>
                  <td width="99"> <img src="img/button_reset.gif" width="60" height="22" border="0" onClick="location.reload();" style="cursor:hand"> 
                  </td>
                </tr>
              </table></td>
          </tr>
        </table> </td>
  </tr>
</table>
</form>
<script language='javascript'>if($Nav()!="IE") ShowObj('adset');</script>
<?
$dsql->Close();
?>
</body>
</html>