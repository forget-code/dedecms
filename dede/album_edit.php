<?
require_once(dirname(__FILE__)."/config.php");
require_once(dirname(__FILE__)."/../include/inc_typelink.php");
require_once(dirname(__FILE__)."/../include/pub_dedetag.php");
$aid = ereg_replace("[^0-9]","",$aid);
$channelid="2";
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
$addQuery = "Select * From #@__addonimages where aid='$aid'";

$dsql->SetQuery($arcQuery);
$arcRow = $dsql->GetOne($arcQuery);
if(!is_array($arcRow)){
	$dsql->Close();
	ShowMsg("��ȡ����������Ϣ����!","-1");
	exit();
}

$addRow = $dsql->GetOne($addQuery);
if(!is_array($addRow)){
	$imgurls = "";
	$pagestyle = 1;
	$maxwidth = $cfg_album_width;
}
else
{
	$imgurls = $addRow["imgurls"];
	$maxwidth = $addRow["maxwidth"];
	$pagestyle = $addRow["pagestyle"];
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�޸�ͼƬ��</title>
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
	   alert("�ĵ����ⲻ��Ϊ�գ�");
	   document.form1.title.focus();
	   return false;
  }
  //myimage = document.getElementById("myimages");
  //document.form1.imagebody = myimage.innerHTML;
  return true;
}
function ShowColor(){
	var fcolor=showModalDialog("img/color.htm?ok",false,"dialogwidth:106px;dialogHeight:110px;status:0;dialogTop:"+(window.event.clientY+120)+";dialogLeft:"+(window.event.clientX));
	if(fcolor!=null && fcolor!="undefined") document.form1.color.value = fcolor;
}

function SeePic(img,f)
{
   if ( f.value != "" ) { img.src = f.value; }
}

function SelectImage(fname,stype)
{
   var posLeft = window.event.clientY-200;
   var posTop = window.event.clientX-200;
   window.open("../include/dialog/select_images.php?f="+fname+"&imgstick="+stype, "popUpImagesWin", "scrollbars=yes,resizable=yes,statebar=no,width=600,height=400,left="+posLeft+", top="+posTop);
}

function MakeUpload()
{
   var startNum = 1;
   var upfield = document.getElementById("uploadfield");
   var endNum =  document.form1.picnum.value;
   if(endNum>40) endNum = 40;
   upfield.innerHTML = "";
   for(startNum;startNum<=endNum;startNum++){
	   upfield.innerHTML += "ͼƬ"+startNum+"��<input type='text' name='imgurl"+startNum+"' style='width:250'> ";
	   upfield.innerHTML += "<input name='selpic"+startNum+"' style='width:50' type='button' value='ѡȡ' onClick=\"SelectImage('form1.imgurl"+startNum+"','big')\"> ";
	   upfield.innerHTML += "��飺<input type='text' name='imgmsg"+startNum+"' style='width:200'><br/>\r\n";
	 }
}

-->
</script>
</head>
<body topmargin="8">
<form name="form1" action="action_album_edit_save.php" enctype="multipart/form-data" method="post" onSubmit="return checkSubmit();">
<input type="hidden" name="channelid" value="<?=$channelid?>">
<input type="hidden" name="ID" value="<?=$aid?>">
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
          <a href="catalog_do.php?cid=<?=$arcRow["typeid"]?>&dopost=listArchives">[<u>ͼ���б�</u>]</a>
          &nbsp;
          <a href="catalog_main.php">[<u>Ƶ������</u>]</a>
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
      <td width="400%" height="24" colspan="4" class="bline">
      	<table width="600" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="80">ͼ�����⣺</td>
            <td width="224"><input name="title" type="text" id="title" style="width:200" value="<?=$arcRow["title"]?>"></td>
            <td width="73">���Ӳ�����</td>
            <td width="223">
            	<input name="iscommend" type="checkbox" id="iscommend" value="11" class="np"<? if($arcRow["iscommend"]>10) echo " checked";?>>
              �Ƽ� 
              <input name="isbold" type="checkbox" id="isbold" value="5" class="np"<? if($arcRow["iscommend"]==5||$arcRow["iscommend"]==16) echo " checked";?>>
              �Ӵ�
             </td>
          </tr>
        </table></td>
    </tr>
    <tr id="pictable"> 
      <td height="24" colspan="4" class="bline">
	   <table width="600" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="78" height="81">����ͼ��</td>
            <td width="337">
              <input name="picname" type="text" id="picname" style="width:230" value="<?=$arcRow["litpic"]?>">
              <input type="button" name="Submit" value="���..." style="width:60" onClick="SelectImage('form1.picname','');"> 
            </td>
            <td width="185" align="center"><img src="<?if($arcRow["litpic"]!="") echo $arcRow["litpic"]; else echo "img/pview.gif";?>" width="150" height="100" id="picview" name="picview">
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline">
      	<table width="600" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="80">ͼƬ��Դ��</td>
            <td width="224"> <input name="source" type="text" id="source" style="width:200" value="<?=$arcRow["source"]?>"> 
            </td>
            <td width="63">&nbsp;</td>
            <td width="159">&nbsp; </td>
            <td width="74" align="center">&nbsp; </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline">
	  <table width="600" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="80">��������</td>
            <td width="224">
            	<select name="sortup" id="sortup" style="width:150">
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
            <td width="159"> 
            	<input name="color" type="text" id="color" style="width:120" value="<?=$arcRow["color"]?>"> 
            </td>
            <td width="74" align="center"><input name="modcolor" type="button" id="modcolor" value="ѡȡ" onClick="ShowColor()"></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline">
      	<table width="600" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="80">�Ķ�Ȩ�ޣ�</td>
            <td width="224">
            	<select name="arcrank" id="arcrank" style="width:150">
                <option value='<?=$arcRow["arcrank"]?>'><?=$arcRow["rankname"]?></option>
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
            <td><input name="ishtml" type="radio" class="np" value="1"<?if($arcRow["ismake"]!=-1) echo " checked";?>>
              ����HTML 
              <input type="radio" name="ishtml" class="np" value="0"<?if($arcRow["ismake"]==-1) echo " checked";?>>
              ����̬���</td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="75" colspan="4" class="bline"> 
        <table width="600" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="80" height="51">ͼ��˵����</td>
            <td width="224"> <textarea name="description" rows="3" id="description" style="width:200"><?=$arcRow["description"]?></textarea> 
            </td>
            <td width="63">�ؼ��֣�</td>
            <td> <textarea name="keywords" rows="3" id="keywords" style="width:200"><?=$arcRow["keywords"]?></textarea></td>
          </tr>
        </table>
      </td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline">
      	<table width="600" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="80">¼��ʱ�䣺</td>
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
            <td width="82" align="center">���ѵ�����</td>
            <td width="152"><input name="money" type="text" id="money" value="<?=$arcRow["money"]?>" size="10"></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline">
	  <table width="600" border="0" cellspacing="0" cellpadding="0">
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
            <td width="74" align="center"><input name='modtype' type='button' onClick="showHide('typeidSelectFrom');"; id='modtype3' value='����'> 
            </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline2">
      	<table width="600" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="80">�����ࣺ</td>
            <td width="446"> 
              <?
            $tl->SetTypeID($arcRow["typeid2"]);
           	$typeOptions = $tl->GetOptionArray($arcRow["typeid2"],$cuserLogin->getUserChannel(),$channelid);
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
                	<img src="img/dedeexplode.gif" width="11" height="11" border="0" onClick="showHide('bodytable')" style="cursor: hand;">
                </td>
                  <td width="61%"><strong>�ϴ�ͼƬ��</strong></td>
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
      <td height="24" colspan="4" class="bline"><table width="600" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="80">���ַ�ʽ��</td>
            <td> <input name="pagestyle" type="radio" class="np" value="1"<? if($pagestyle==1) echo " checked"; ?>>
              ��ҳ��ʾ 
              <input name="pagestyle" class="np" type="radio" value="2"<? if($pagestyle==2) echo " checked"; ?>>
              �ֶ�ҳ��ʾ </td>
          </tr>
        </table></td>
    </tr>
    <tr>
      <td height="24" colspan="4" class="bline"><table width="600" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="80">���ƿ�ȣ�</td>
            <td><input name="maxwidth" type="text" id="maxwidth" size="10" value="<?=$maxwidth?>">
              (��ֹͼƬ̫����ģ��ҳ�����) </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td width="100%" height="24" colspan="4" class="bline"> <table width="600" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="80">ͼƬ��</td>
            <td> <input name="picnum" type="text" id="picnum" size="8" value="10"> 
              <input name='kkkup' type='button' id='kkkup2' value='���ӱ�' onClick="MakeUpload();">
              ע�����40����ͼƬ����������дԶ����ַ </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline"> 
        <?
       $j = 1;
       if($imgurls!=""){
       	 $dtp = new DedeTagParse();
       	 $dtp->LoadSource($imgurls);
       	 if(is_array($dtp->CTags))
       	 {
       	 	 foreach($dtp->CTags as $ctag){
       	 	 	 if($ctag->GetName()=="img"){
       	 	 	 	 $nform = "ͼƬ1��<input style='width: 250px' name='oimgurl$j' size='20' value='".trim($ctag->GetInnerText())."'>
<input style='width: 50px' onclick=\"SelectImage('form1.oimgurl$j','big')\" type='button' value='ѡȡ' name='oselpic$j'> 
��飺<input style='width: 200px' name='oimgmsg$j' size='20' value=".$ctag->GetAtt("text")."><br/>\r\n";
       	 	 	 	 echo $nform; 
       	 	 	 	 $j++;
       	 	 	 }
       	 	 }
       	 }
       	 $dtp->Clear();
       }
       ?>
        <span id="uploadfield">ͼƬ1��
        <input style="WIDTH: 250px" name="imgurl1" size="20">
        <input style="WIDTH: 50px" onclick="SelectImage('form1.imgurl1','big')" type="button" value="ѡȡ" name="selpic1">
        ��飺
        <input style="WIDTH: 200px" name="imgmsg1" size="20">
        <br/>
        ͼƬ2��
        <input style="WIDTH: 250px" name="imgurl2" size="20">
        <input style="WIDTH: 50px" onclick="SelectImage('form1.imgurl2','big')" type="button" value="ѡȡ" name="selpic2">
        ��飺
        <input style="WIDTH: 200px" name="imgmsg2" size="20">
        <br/>
        ͼƬ3��
        <input style="WIDTH: 250px" name="imgurl3" size="20">
        <input style="WIDTH: 50px" onclick="SelectImage('form1.imgurl3','big')" type="button" value="ѡȡ" name="selpic3">
        ��飺
        <input style="WIDTH: 200px" name="imgmsg3" size="20">
        <br/>
        ͼƬ4��
        <input style="WIDTH: 250px" name="imgurl4" size="20">
        <input style="WIDTH: 50px" onclick="SelectImage('form1.imgurl4','big')" type="button" value="ѡȡ" name="selpic4">
        ��飺
        <input style="WIDTH: 200px" name="imgmsg4" size="20">
        <br/>
        ͼƬ5��
        <input style="WIDTH: 250px" name="imgurl5" size="20">
        <input style="WIDTH: 50px" onclick="SelectImage('form1.imgurl5','big')" type="button" value="ѡȡ" name="selpic5">
        ��飺
        <input style="WIDTH: 200px" name="imgmsg5" size="20">
        <br/>
        ��</span> </td>
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
<?
$dsql->Close();
?>
</body>
</html>