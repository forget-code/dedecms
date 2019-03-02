<?php 
require_once(dirname(__FILE__)."/config.php");
require_once(dirname(__FILE__)."/inc/inc_catalog_options.php");
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
	$irow = 4;
	$icol = 4;
	$isrm = 1;
}
else
{
	$imgurls = $addRow["imgurls"];
	$maxwidth = $addRow["maxwidth"];
	$pagestyle = $addRow["pagestyle"];
	$irow = $addRow["row"];
	$icol = $addRow["col"];
	$isrm = $addRow["isrm"];
	$maxwidth = $addRow["maxwidth"];
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
<script language='javascript' src='main.js'></script>
<script language="javascript">
<!--
function checkSubmit()
{
   if(document.form1.title.value==""){
	   alert("�ĵ����ⲻ��Ϊ�գ�");
	   return false;
  }
  //myimage = document.getElementById("myimages");
  //document.form1.imagebody = myimage.innerHTML;
  return true;
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
	   fhtml += "<input type=\"button\" name='selpic"+startNum+"' value=\"ѡȡ\" style=\"width:65px\" onClick=\"SelectImageN('form1.imgurl"+startNum+"','big','picview"+startNum+"')\" class='nbt'>";
	   fhtml += "</td></tr>";
	   fhtml += "<tr bgcolor=\"#FFFFFF\"> ";
	   fhtml += "<td height=\"56\">��ͼƬ��飺 ";
	   fhtml += "<textarea name='imgmsg"+startNum+"' style=\"height:46px;width:330px\"></textarea> </td>";
	   fhtml += "</tr></tobdy></table>\r\n";
	   upfield.innerHTML += fhtml;
  }
}

function CheckSelTable(nnum){
	var cbox = $Obj('isokcheck'+nnum);
	var seltb = $Obj('seltb'+nnum);
	if(cbox.checked) seltb.style.display = 'none';
	else seltb.style.display = 'block';
}
-->
</script>
</head>
<body topmargin="8">
<form name="form1" action="album_edit_action.php" enctype="multipart/form-data" method="post" onSubmit="return checkSubmit();">
<input type="hidden" name="channelid" value="<?php echo $channelid?>">
<input type="hidden" name="ID" value="<?php echo $aid?>">
  <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr> 
      <td width="4%" height="30"><IMG height=14 src="img/book1.gif" width=20> 
        &nbsp;</td>
      <td width="85%"><a href="catalog_do.php?cid=<?php echo $arcRow["typeid"]?>&dopost=listArchives"><u>ͼ���б�</u></a>&gt;&gt;����ͼ��</td>
      <td width="10%">&nbsp; <a href="catalog_main.php">[<u>��Ŀ����</u>]</a> </td>
      <td width="1%">&nbsp;</td>
    </tr>
  </table>
  <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" id="head1" class="htable">
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
            <td width="90">ͼ�����⣺</td>
            <td width="240">
<input name="title" type="text" id="title" style="width:200" value="<?php echo $arcRow["title"]?>">
            </td>
            <td width="90">���Ӳ�����</td>
            <td> 
              <input name="iscommend" type="checkbox" id="iscommend" value="11" class="np"<?php  if($arcRow["iscommend"]>10) echo " checked";?>>
              �Ƽ� 
              <input name="isbold" type="checkbox" id="isbold" value="5" class="np"<?php  if($arcRow["iscommend"]==5||$arcRow["iscommend"]==16) echo " checked";?>>
              �Ӵ�
              <input name="isjump" type="checkbox" onClick="ShowUrlTrEdit()" id="isjump" value="1" class="np"<?php  echo $arcRow["redirecturl"]=="" ? "" : " checked";?>>
              ��ת��ַ
            </td>
          </tr>
        </table></td>
    </tr>
    <tr>
      <td height="24" colspan="4" class="bline" id="redirecturltr" style="display:<?php  echo $arcRow["redirecturl"]=="" ? "none" : "block";?>">
	   <table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90">&nbsp;��ת��ַ��</td>
            <td> <input name="redirecturl" type="text" id="redirecturl" style="width:300" value="<?php echo $arcRow["redirecturl"]?>"> 
            </td>
          </tr>
       </table>
	 </td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline"> <table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90">���Ա��⣺</td>
            <td width="240">
<input name="shorttitle" type="text" value="<?php echo $arcRow["shorttitle"]?>" id="shorttitle" style="width:200">
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
            		if($arcRow["arcatt"]==$trow->att) echo "<option value='{$trow->att}' selected>{$trow->attname}</option>";
            		else echo "<option value='{$trow->att}'>{$trow->attname}</option>";
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
            <td width="90" height="40"> &nbsp;�� �� ͼ��<br/> &nbsp; <input type='checkbox' class='np' name='ddisremote' value='1'>
              Զ�� </td>
            <td> <table width="98%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="56%" height="107"> 
                    <input name="picname" type="text" id="picname" style="width:300" value="<?php echo $arcRow["litpic"]?>"> 
                    <input type="button" name="Submit" value="���..." style="width:60" onClick="SelectImage('form1.picname','');" class='nbt'></td>
                  <td width="44%"><img src="<?php echo $arcRow["litpic"]?>" width="150" id="picview" name="picview"></td>
                </tr>
              </table></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline"> <table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90">ͼƬ��Դ��</td>
            <td width="240"> 
              <input name="source" type="text" id="source" style="width:200" value="<?php echo $arcRow["source"]?>">
            </td>
            <td width="90">&nbsp;</td>
            <td width="159">&nbsp; </td>
            <td>&nbsp; </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline"> <table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90">��������</td>
            <td width="240"> 
              <select name="sortup" id="sortup" style="width:150">
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
              </select>
            </td>
            <td width="90">������ɫ��</td>
            <td width="159"> <input name="color" type="text" id="color" style="width:120" value="<?php echo $arcRow["color"]?>"> 
            </td>
            <td> 
              <input name="modcolor" type="button" id="modcolor" value="ѡȡ" onClick="ShowColor()" class='nbt'></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline"> <table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90">�Ķ�Ȩ�ޣ�</td>
            <td width="240"> 
              <select name="arcrank" id="arcrank" style="width:150">
                <option value='<?php echo $arcRow["arcrank"]?>'>
                <?php echo $arcRow["rankname"]?>
                </option>
                <?php 
              $urank = $cuserLogin->getUserRank();
              $dsql = new DedeSql(false);
              $dsql->SetQuery("Select * from #@__arcrank where adminrank<='$urank'");
              $dsql->Execute();
              while($row = $dsql->GetObject()){
              	echo "     <option value='".$row->rank."'>".$row->membername."</option>\r\n";
              }
              ?>
              </select>
            </td>
            <td width="90">����ѡ�</td>
            <td><input name="ishtml" type="radio" class="np" value="1"<?php if($arcRow["ismake"]!=-1) echo " checked";?>>
              ����HTML 
              <input type="radio" name="ishtml" class="np" value="0"<?php if($arcRow["ismake"]==-1) echo " checked";?>>
              ����̬���</td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="75" colspan="4" class="bline"> <table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90" height="51">ͼ��˵����</td>
            <td width="240"> 
              <textarea name="description" rows="3" id="description" style="width:200"><?php echo $arcRow["description"]?></textarea>
            </td>
            <td width="90">�� �� �֣�</td>
            <td> <textarea name="keywords" rows="3" id="keywords" style="width:200"><?php echo $arcRow["keywords"]?></textarea></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline"> <table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90">¼��ʱ�䣺</td>
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
      <td height="24" colspan="4" class="bline"> <table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90">����ʱ�䣺</td>
            <td width="240"> 
              <?php 
			$nowtime = GetDateTimeMk($arcRow["pubdate"]);
			echo "<input name=\"pubdate\" value=\"$nowtime\" type=\"text\" id=\"pubdate\" style=\"width:200\">";
			?>
            </td>
            <td width="90" align="center">���ѵ�����</td>
            <td>
<input name="money" type="text" id="money" value="<?php echo $arcRow["money"]?>" size="10">
            </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline"> <table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90">�����ࣺ</td>
            <td width="400"> 
          <?php 
           	$dsql = new DedeSql(false);
           	$seltypeids = $dsql->GetOne("Select ID,typename From #@__arctype where ID='".$arcRow["typeid"]."' ");
			    if(is_array($seltypeids)){
			         echo GetTypeidSel('form1','typeid','selbt1',$arcRow["channel"],$seltypeids['ID'],$seltypeids['typename']);
			    }
			    ?>
            </td>
            <td> ��ֻ�����ڰ�ɫѡ�����Ŀ�з�����ǰ�������ݣ�</td>
          </tr>
        </table></td>
    </tr>
    <tr>
      <td height="24" colspan="4" bgcolor="#FFFFFF" class="bline2">
<table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90">�����ࣺ</td>
            <td width="400"><?php 
			$seltypeids = $dsql->GetOne("Select ID,typename From #@__arctype where ID='".$arcRow["typeid2"]."' ");
			if(is_array($seltypeids)){
			   echo GetTypeidSel('form1','typeid2','selbt2',$arcRow["channel"],$seltypeids['ID'],$seltypeids['typename']);
			}else{
			   echo GetTypeidSel('form1','typeid2','selbt2',$arcRow["channel"],0,'��ѡ��...');
			}
            ?></td>
            <td>&nbsp; </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr> 
      <td height="24" colspan="4" bgcolor="#FFFFFF" class="bline2">&nbsp; </td>
    </tr>
  </table>
  <table width="98%"  border="0" align="center" cellpadding="2" cellspacing="2" style="display:none" id="adset">
    <tr> 
      <td height="24" colspan="4" class="bline"><table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90">���ַ�ʽ��</td>
            <td> <input name="pagestyle" type="radio" class="np" value="1"<?php  if($pagestyle==1) echo " checked"; ?>>
              ��ҳ��ʾ 
              <input name="pagestyle" class="np" type="radio" value="2"<?php  if($pagestyle==2) echo " checked"; ?>>
              �ֶ�ҳ��ʾ 
              <input name="pagestyle" class="np" type="radio" value="3"<?php  if($pagestyle==3) echo " checked"; ?>>
              ���ж�����ʾ</td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline"> <table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90">����ʽ������</td>
            <td>�� 
              <input name="row" type="text" id="row" size="6" value="<?php echo $irow?>">
              ���� 
              <input name="col" type="text" id="col" size="6" value="<?php echo $icol?>">
              ��ͼƬ������ƣ� 
              <input name="ddmaxwidth" type="text" id="ddmaxwidth" size="6" value="150">
              ����
			  </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline"> <table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90">���ƿ�ȣ�</td>
            <td> <input name="maxwidth" type="text" id="maxwidth" size="10" value="<?php echo $maxwidth?>">
              (��ֹͼƬ̫����ģ��ҳ�����) </td>
          </tr>
        </table></td>
    </tr>
    <tr>
      <td height="24" colspan="4" class="bline"><table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90">Զ��ͼƬ��</td>
            <td>
			<input name="isrm" type="checkbox" id="isrm" class="np" value="1"<?php if($isrm==1) echo " checked";?>>
            ����Զ��ͼƬ
			 </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td width="100%" height="24" colspan="4" class="bline"> <table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90">ͼƬ��</td>
            <td> <input name="picnum" type="text" id="picnum" size="8" value="10"> 
              <input name='kkkup' type='button' id='kkkup2' value='���ӱ�' onClick="MakeUpload(0);" class='nbt'>
              ע�����40����ͼƬ����������дԶ����ַ </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline"> 
        <?php 
       $j = 1;
       if($imgurls!=""){
       	 $dtp = new DedeTagParse();
       	 $dtp->LoadSource($imgurls);
       	 if(is_array($dtp->CTags))
       	 {
       	 	 foreach($dtp->CTags as $ctag){
       	 	 	 if($ctag->GetName()=="img"){
                     $fhtml = "<input type='hidden' name='oldddimg$j' value='".$ctag->GetAtt("ddimg")."'>";
	   $fhtml .= "<table width='600'><tr><td><input type='checkbox' name='isokcheck$j' id='isokcheck$j' value='1' class='np' onClick='CheckSelTable($j)'>��ʾ/����ͼƬ[$j]��ѡ��</td></tr></table>";
	   $fhtml .= "<table width=\"600\" border=\"0\" id=\"seltb$j\" cellpadding=\"1\" cellspacing=\"1\" bgcolor=\"#E8F5D6\" style=\"margin-bottom:6px;margin-left:10px\"><tobdy>";
	   $fhtml .= "<tr bgcolor=\"#F4F9DD\">\r\n";
	   $fhtml .= "<td height=\"25\" colspan=\"2\">��<strong>ͼƬ{$j}��</strong></td>";
	   $fhtml .= "</tr>";
	   $fhtml .= "<tr bgcolor=\"#FFFFFF\"> ";
	   $fhtml .= "<td width=\"429\" height=\"25\"> �������ϴ��� ";
	   $fhtml .= "<input type=\"file\" name='imgfile$j' style=\"width:330px\" onChange=\"SeePic(document.picview$j,document.form1.imgfile$j);\"></td>";
	   $fhtml .= "<td width=\"164\" rowspan=\"3\" align=\"center\"><img src=\"".trim($ctag->GetInnerText())."\" width=\"150\" id=\"picview$j\" name=\"picview$j\"></td>";
	   $fhtml .= "</tr>";
	   $fhtml .= "<tr bgcolor=\"#FFFFFF\"> ";
	   $fhtml .= "<td height=\"25\"> ��ָ����ַ�� ";
	   $fhtml .= "<input type=\"text\" name='imgurl$j' style=\"width:260px\" value=\"".trim($ctag->GetInnerText())."\" > ";
	   $fhtml .= "<input type=\"button\" name='selpic$j' value=\"ѡȡ\" style=\"width:65px\" onClick=\"SelectImageN('form1.imgurl$j','big','picview$j')\" class='nbt'>";
	   $fhtml .= "</td></tr>";
	   $fhtml .= "<tr bgcolor=\"#FFFFFF\"> ";
	   $fhtml .= "<td height=\"56\">��ͼƬ��飺 ";
	   $fhtml .= "<textarea name='imgmsg$j' style=\"height:46px;width:330px\">".$ctag->GetAtt("text")."</textarea> </td>";
	   $fhtml .= "</tr></tobdy></table>\r\n";
       	 	 	 	 echo $fhtml; 
       	 	 	 	 $j++;
       	 	 	 }
       	 	 }
       	 }
       	 $dtp->Clear();
       }
       ?>
        <span id="uploadfield"></span>
		<script language="JavaScript">
		startNum = <?php echo $j?>;
		</script>
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
<?php 
$dsql->Close();
?>
</body>
</html>