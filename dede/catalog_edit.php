<?
require_once(dirname(__FILE__)."/config.php");
if(empty($dopost)) $dopost = "";
if(empty($ID)) $ID="0";
$ID = ereg_replace("[^0-9]","",$ID);

//���Ȩ�����
CheckPurview('t_Edit,t_AccEdit');
//�����Ŀ�������
CheckCatalog($ID,"����Ȩ���ı���Ŀ��");

$dsql = new DedeSql(false);

//----------------------------------
//����Ķ� Action Save
//-----------------------------------
if($dopost=="save")
{
	 $description = Html2Text($description);
   $keywords = Html2Text($keywords);
   
   if($cfg_cmspath!="") $typedir = ereg_replace("^{$cfg_cmspath}","{cmspath}",$typedir);
   else if(!eregi("{cmspath}",$typedir)) $typedir = "{cmspath}".$typedir;
   
   $upquery = "
     Update #@__arctype set
     issend='$issend',
     sortrank='$sortrank',
     typename='$typename',
     typedir='$typedir',
     isdefault='$isdefault',
     defaultname='$defaultname',
     issend='$issend',
     channeltype='$channeltype',
     tempindex='$tempindex',
     templist='$templist',
     temparticle='$temparticle',
     tempone='$tempone',
     namerule='$namerule',
     namerule2='$namerule2',
     ispart='$ispart',
     corank='$corank',
     description='$description',
     keywords='$keywords',
     moresite='$moresite',
     siterefer='$siterefer',
     sitepath='$sitepath',
     siteurl='$siteurl',
     ishidden='$ishidden'
   where ID='$ID'";
   
   if(!$dsql->ExecuteNoneQuery($upquery)){
   	 ShowMsg("���浱ǰ��Ŀ����ʱʧ�ܣ�����������������Ƿ�������⣡","-1");
   	 exit();
   }
   
   //���ѡ������Ŀ��Ͷ�壬���¶�����ĿΪ��Ͷ��
   if($topID>0 && $issend==1){
   	 $dsql->ExecuteNoneQuery("Update #@__arctype set issend='$issend' where ID='$topID'; ");
   }
   
   //��������Ŀ����
   if(!empty($upnext))
   {
   	 require_once(dirname(__FILE__)."/../include/inc_typelink.php");
   	 $tl = new TypeLink($ID);
   	 $slinks = $tl->GetSunID($ID,'###',0);
   	 $slinks = str_replace("###.typeid","ID",$slinks);
   	 $upquery = "
       Update #@__arctype set
       issend='$issend',
       sortrank='$sortrank',
       defaultname='$defaultname',
       channeltype='$channeltype',
       tempindex='$tempindex',
       templist='$templist',
       temparticle='$temparticle',
       namerule='$namerule',
       namerule2='$namerule2',
       moresite='$moresite',
       siterefer='$siterefer',
       sitepath='$sitepath',
       siteurl='$siteurl',
       ishidden='$ishidden'
     where 1=1 And $slinks";
   
     if(!$dsql->ExecuteNoneQuery($upquery)){
   	   ShowMsg("���ĵ�ǰ��Ŀ�ɹ����������¼���Ŀ����ʱʧ�ܣ�","-1");
   	   exit();
     }
     $tl->Close();
     
   }
   //--------------------------
   $dsql->Close();
   ShowMsg("�ɹ�����һ�����࣡","catalog_main.php");
   exit();
}//End Save Action


$dsql->SetQuery("Select #@__arctype.*,#@__channeltype.typename as ctypename From #@__arctype left join #@__channeltype on #@__channeltype.ID=#@__arctype.channeltype where #@__arctype.ID=$ID");
$myrow = $dsql->GetOne();
$topID = $myrow['topID'];
if($topID>0)
{
	$toprow = $dsql->GetOne("Select moresite,siterefer,sitepath,siteurl From #@__arctype where ID=$topID");
	foreach($toprow as $k=>$v){
	  if(!ereg("[0-9]",$k)) $myrow[$k] = $v;
	}
}
//��ȡƵ��ģ����Ϣ
$channelid = $myrow['channeltype'];
$row = $dsql->GetOne("select * from #@__channeltype where ID='$channelid'");
$nid = $row['nid'];
//��ȡ����ģ������
$dsql->SetQuery("select * from #@__channeltype where ID>-1 And isshow=1 order by ID");
$dsql->Execute();
while($row=$dsql->GetObject())
{
  $channelArray[$row->ID]['typename'] = $row->typename;
  $channelArray[$row->ID]['nid'] = $row->nid;
}
//����Ŀ�Ƿ�Ϊ����վ��
if(!empty($myrow['moresite'])){
	 $moresite = $myrow['moresite'];
}else{
	 $moresite = 0;
}

if($myrow['topID']==0){
	PutCookie('lastCid',$ID,3600*24,"/");
}
?>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
<title>��Ŀ����</title>
<link href='base.css' rel='stylesheet' type='text/css'>
<script language="javascript">
var channelArray = new Array();
<?    
$i = 0;
foreach($channelArray as $k=>$arr){
  echo "channelArray[$k] = \"{$arr['nid']}\";\r\n";
}
?>
	
function SelectTemplets(fname){
   var posLeft = window.event.clientY-200;
   var posTop = window.event.clientX-300;
   window.open("../include/dialog/select_templets.php?f="+fname, "poptempWin", "scrollbars=yes,resizable=yes,statebar=no,width=600,height=400,left="+posLeft+", top="+posTop);
}
  
function ShowHide(objname){
  var obj = document.getElementById(objname);
  if(obj.style.display == "block" || obj.style.display == "")
	   obj.style.display = "none";
  else
	   obj.style.display = "block";
}
  
function ShowObj(objname){
   var obj = document.getElementById(objname);
	 obj.style.display = "block";
}
  
function HideObj(objname){
  var obj = document.getElementById(objname);
	obj.style.display = "none";
}
  
function ShowItem1(){
  ShowObj('head1'); ShowObj('needset'); HideObj('head2'); HideObj('adset');
}
  
function ShowItem2(){
  ShowObj('head2'); ShowObj('adset'); HideObj('head1'); HideObj('needset');
}
  
function CheckTypeDir(){
  var upinyin = document.getElementById('upinyin');
  var tpobj = document.getElementById('typedir');
  if(upinyin.checked) tpobj.style.display = "none";
  else tpobj.style.display = "block";
}
  
function ParTemplet(obj)
{
  var sevvalue = channelArray[obj.value];
  var tempindex = document.getElementsByName('tempindex');
  var templist = document.getElementsByName('templist');
  var temparticle = document.getElementsByName('temparticle');
  //var dfstyle = document.getElementsByName('dfstyle');
  //var dfstyleValue = dfstyle[0].value;
  tempindex[0].value = "{style}/index_"+sevvalue+".htm";
  templist[0].value = "{style}/list_"+sevvalue+".htm";
  temparticle[0].value = "{style}/article_"+sevvalue+".htm";
}
  
function checkSubmit()
{
   if(document.form1.typename.value==""){
		  alert("��Ŀ���Ʋ���Ϊ�գ�");
		  document.form1.typename.focus();
		  return false;
	 }
	 return true;
}
</script>
</head>
<body leftmargin='15' topmargin='10'>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#111111" style="BORDER-COLLAPSE: collapse">
  <tr> 
    <td width="100%" height="20" valign="top">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td height="30"><IMG height=14 src="img/book1.gif" width=20> &nbsp;<a href="catalog_main.php"><u>��Ŀ����</u></a>&gt;&gt;������Ŀ</td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td width="100%" height="1" background="img/sp_bg.gif"></td>
  </tr>
</table>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr><td height="10"></td></tr>
  <tr>
  <form name="form1" action="catalog_edit.php" method="post" onSubmit="return checkSubmit();">
  <input type="hidden" name="dopost" value="save">
  <input type="hidden" name="ID" value="<?=$ID?>">
  <input type="hidden" name="topID" value="<?=$myrow['topID']?>">
  <td height="95" align="center" bgcolor="#FFFFFF">
	<table width="100%" border="0" cellspacing="0" id="head1" cellpadding="0" style="border-bottom:1px solid #CCCCCC">
     <tr> 
       <td colspan="2" bgcolor="#FFFFFF">
<table width="168" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="84" height="24" align="center" background="img/itemnote1.gif">&nbsp;����ѡ��&nbsp;</td>
                  <td width="84" align="center" background="img/itemnote2.gif"><a href="#" onClick="ShowItem2()"><u>�߼�ѡ��</u></a>&nbsp;</td>
                </tr>
              </table>
            </td>
          </tr>
        </table> 
        <table width="100%" border="0" cellspacing="0" id="head2" cellpadding="0" style="border-bottom:1px solid #CCCCCC;display:none">
          <tr>
            <td colspan="2" bgcolor="#FFFFFF">
<table width="168" height="24" border="0" cellpadding="0" cellspacing="0">
                <tr> 
                  <td width="84" align="center" background="img/itemnote2.gif" bgcolor="#F2F7DF"><a href="#" onClick="ShowItem1()"><u>����ѡ��</u></a>&nbsp;</td>
                  <td width="84" align="center" background="img/itemnote1.gif">�߼�ѡ��&nbsp;</td>
                </tr>
              </table>
            </td>
          </tr>
       </table>
	    <table width="100%" border="0"  id="needset" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="120" class='bline' height="26">�Ƿ�֧��Ͷ�壺</td>
            <td class='bline'> <input type='radio' name='issend' value='0' class='np' <?if($myrow['issend']=="0") echo " checked";?>>
              ��֧��&nbsp; <input type='radio' name='issend' value='1' class='np' <?if($myrow['issend']=="1") echo " checked";?>>
              ֧�� </td>
          </tr>
          <tr> 
            <td width="120" class='bline' height="26">�Ƿ�������Ŀ��</td>
            <td class='bline'> <input type='radio' name='ishidden' value='0' class='np'<?if($myrow['ishidden']=="0") echo " checked";?>>
              ��ʾ��&nbsp; <input type='radio' name='ishidden' value='1' class='np'<?if($myrow['ishidden']=="1") echo " checked";?>>
              ���� </td>
          </tr>
          <tr> 
            <td class='bline' height="26">��Ŀ���ƣ�</td>
            <td class='bline'><input name="typename" type="text" id="typename" size="30" value="<?=$myrow['typename']?>"></td>
          </tr>
          <tr> 
            <td class='bline' height="26"> ����˳�� </td>
            <td class='bline'> <input name="sortrank" size="6" type="text" value="<?=$myrow['sortrank']?>">
              ���ɵ� -&gt; �ߣ� </td>
          </tr>
          <tr> 
            <td class='bline' height="26">���Ȩ�ޣ�</td>
            <td class='bline'> <select name="corank" id="corank" style="width:100">
                <?
              $dsql->SetQuery("Select * from #@__arcrank where rank >= 0");
              $dsql->Execute();
              while($row = $dsql->GetObject())
              {
              	if($myrow['corank']==$row->rank)
              	  echo "<option value='".$row->rank."' selected>".$row->membername."</option>\r\n";
				        else
				          echo "<option value='".$row->rank."'>".$row->membername."</option>\r\n";
              }
              ?>
              </select>
              (��������Ŀ����ĵ����Ȩ��) </td>
          </tr>
          <tr> 
            <td class='bline' height="26">�ļ�����Ŀ¼��</td>
            <td class='bline'> <input name="typedir" type="text" id="typedir" value="<?=$myrow['typedir']?>" style="width:300"> 
            </td>
          </tr>
          <tr> 
            <td class='bline' height="26">����ģ�ͣ� &nbsp; </td>
            <td class='bline'> <select name="channeltype" id="channeltype" style="width:200px" onChange="ParTemplet(this)">
                <?    
            foreach($channelArray as $k=>$arr)
            {
            	if($k==$channelid) echo "    <option value='{$k}' selected>{$arr['typename']}|{$arr['nid']}</option>\r\n";
              else  echo "    <option value='{$k}'>{$arr['typename']}|{$arr['nid']}</option>\r\n";
            }
            ?>
              </select> </td>
          </tr>
          <tr> 
            <td class='bline' height="26">��Ŀ�б�ѡ�</td>
            <td class='bline'> <input type='radio' name='isdefault' value='1' class='np'<? if($myrow['isdefault']==1) echo" checked";?>>
              ���ӵ�Ĭ��ҳ 
              <input type='radio' name='isdefault' value='0' class='np'<? if($myrow['isdefault']==0) echo" checked";?>>
              ���ӵ��б��һҳ 
              <input type='radio' name='isdefault' value='-1' class='np'<? if($myrow['isdefault']==-1) echo" checked";?>>
              ʹ�ö�̬ҳ </td>
          </tr>
          <tr> 
            <td class='bline' height="26">Ĭ��ҳ�����ƣ� </td>
            <td class='bline'><input name="defaultname" type="text" value="<?=$myrow['defaultname']?>"></td>
          </tr>
          <tr> 
            <td height="26" class='bline'>��Ŀ���ԣ�</td>
            <td class='bline'> <input name="ispart" type="radio" id="radio" value="0" class='np'<? if($myrow['ispart']==0) echo" checked";?>>
              �����б���Ŀ�������ڱ���Ŀ�����ĵ����������ĵ��б�<br> <input name="ispart" type="radio" id="radio2" value="1" class='np'<? if($myrow['ispart']==1) echo" checked";?>>
              Ƶ�����棨��Ŀ�����������ĵ���<br> <input name="ispart" type="radio" id="radio3" value="2" class='np'<? if($myrow['ispart']==2) echo" checked";?>>
              ����ҳ�棨��Ŀ�����������ĵ��� </td>
          </tr>
        </table>
	    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="display:none" id="adset">
          <tr> 
            <td class='bline' width="120" height="24">��վ��֧�֣�</td>
            <td class='bline'> <input name="moresite" type="radio"  class="np" value="0"<? if($myrow['moresite']==0) echo" checked";?>>
              ������ 
              <input type="radio" name="moresite" class="np" value="1"<? if($myrow['moresite']==1) echo" checked";?>>
              ���� </td>
          </tr>
          <tr> 
            <td height="24" bgcolor="#F3F7EA">˵����</td>
            <td bgcolor="#F3F7EA">�����󶨽���Ҫ�ڶ�����Ŀ�趨���¼���Ŀ������Ч��</td>
          </tr>
          <tr> 
            <td class='bline' height="24">��������</td>
            <td class='bline'> <input name="siteurl" type="text" id="siteurl" size="35" value="<?=$myrow['siteurl']?>">
              (��� http://��һ������������ĸ���ַ) </td>
          </tr>
          <tr> 
            <td class='bline' height="24">վ���Ŀ¼��</td>
            <td class='bline'> <input name="sitepath" type="text" id="sitepath" size="35" value="<?=$myrow['sitepath']?>"> 
              <input name="siterefer" type="radio" id="siterefer1" class="np" value="1"<? if($myrow['siterefer']==1) echo" checked";?>>
              ����ڵ�ǰվ���Ŀ¼ 
              <input name="siterefer" type="radio" id="siterefer2" class="np" value="2"<? if($myrow['siterefer']==2) echo" checked";?>>
              ����·�� </td>
          </tr>
          <tr id='helpvar1' style='display:none'> 
            <td height="24" bgcolor="#F3F7EA">֧�ֱ����� </td>
            <td bgcolor="#F3F7EA"> {tid}��ʾ��ĿID��<br>
              {cid}��ʾƵ��ģ�͵�'����ID' <font color='#888888'> �� 
              <?
              foreach($channelArray as $k=>$arr)
              {
            	   echo "{$arr['typename']}({$arr['nid']})��";
              }
             ?>
              �� </font> <br/>
              ģ���ļ���Ĭ��λ���Ƿ���ģ��Ŀ¼ "cms��װĿ¼ 
              <?=$cfg_templets_dir ?>
              " �ڡ� 
              <input type='hidden' value='{style}' name='dfstyle'> </td>
          </tr>
          <tr> 
            <td height="26">����ģ�壺</td>
            <td> <input name="tempindex" type="text" value="<?=$myrow['tempindex']?>" style="width:300"> 
              <input type="button" name="set1" value="���..." style="width:60" onClick="SelectTemplets('form1.tempindex');"> 
              <img src="img/help.gif" alt="����" width="16" height="16" border="0" style="cursor:hand" onclick="ShowHide('helpvar1')"> 
            </td>
          </tr>
          <tr> 
            <td height="26">�б�ģ�壺</td>
            <td> <input name="templist" type="text" value="<?=$myrow['templist']?>" style="width:300"> 
              <input type="button" name="set3" value="���..." style="width:60" onClick="SelectTemplets('form1.templist');"> 
            </td>
          </tr>
          <tr> 
            <td height="26">����ģ�壺</td>
            <td><input name="temparticle" type="text" value="<?=$myrow['temparticle']?>" style="width:300"> 
              <input type="button" name="set4" value="���..." style="width:60" onClick="SelectTemplets('form1.temparticle');"> 
            </td>
          </tr>
          <tr> 
            <td height="26">����ҳ��ģ�壺</td>
            <td><input name="tempone" type="text" value="<?=$myrow['tempone']?>" style="width:300"> 
              <input type="button" name="set2" value="���..." style="width:60" onClick="SelectTemplets('form1.tempone');"> 
            </td>
          </tr>
          <tr id='helpvar2' style='display:none'> 
            <td height="24" bgcolor="#F3F7EA">֧�ֱ����� </td>
            <td height="24" bgcolor="#F3F7EA"> {Y}��{M}��{D} ������<br/>
              {timestamp} INT���͵�UNIXʱ���<br/>
              {aid} ����ID<br/>
              {pinyin} ƴ��+����ID<br/>
              {py} ƴ������+����ID<br/>
              {typedir} ��ĿĿ¼ <br/>
              {cc} ����+ID������ת��Ϊ�ʺϵ���ĸ <br/>
              </td>
          </tr>
          <tr> 
            <td height="26">������������</td>
            <td> <input name="namerule" type="text" id="namerule" value="<?=$myrow['namerule']?>" size="40"> 
              <img src="img/help.gif" alt="����" width="16" height="16" border="0" style="cursor:hand" onclick="ShowHide('helpvar2')"> 
            </td>
          </tr>
          <tr id='helpvar3' style='display:none'> 
            <td height="24" bgcolor="#F3F7EA">֧�ֱ����� </td>
            <td bgcolor="#F3F7EA">{page} �б��ҳ��</td>
          </tr>
          <tr> 
            <td height="26">�б���������</td>
            <td> <input name="namerule2" type="text" id="namerule2" value="<?=$myrow['namerule2']?>" size="40"> 
              <img src="img/help.gif" alt="����" width="16" height="16" border="0" style="cursor:hand" onclick="ShowHide('helpvar3')"></td>
          </tr>
          <tr> 
            <td height="65">�ؼ��֣�</td>
            <td> <textarea name="keywords" cols="40" rows="3" id="keywords"><?=$myrow['keywords']?></textarea> 
            </td>
          </tr>
          <tr>
            <td height="65">��Ŀ������</td>
            <td height="65"><textarea name="description" cols="40" rows="3" id="textarea"><?=$myrow['description']?></textarea></td>
          </tr>
          <tr> 
            <td height="45">�̳�ѡ�</td>
            <td> 
              <input name="upnext" type="checkbox" id="upnext" value="1" class="np">
              ͬʱ�����¼���Ŀ�����Ȩ�ޡ��������͡�ģ�������������ͨ������
            </td>
          </tr>
        </table>
          <table width="98%" border="0" cellspacing="0" cellpadding="0">
		       <tr> 
            <td width="1%" height="50"></td>
            <td width="99%" valign="bottom">
            <input name="imageField" type="image" src="img/button_ok.gif" width="60" height="22" border="0" class="np">
            &nbsp;&nbsp;&nbsp;
            <a href="catalog_main.php"><img src="img/button_back.gif" width="60" height="22" border="0"></a>
			    </td>
          </tr>
        </table></td>
	  </form>
  </tr>
</table>
<?
$dsql->Close();
?>
</body>
</html>
