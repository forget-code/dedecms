<?
require_once(dirname(__FILE__)."/config.php");
SetPageRank(5);
if(empty($ID)) $ID="0";
$ID = ereg_replace("[^0-9]","",$ID);
$dsql = new DedeSql(false);
$dsql->SetQuery("Select #@__arctype.*,#@__channeltype.typename as ctypename From #@__arctype left join #@__channeltype on #@__channeltype.ID=#@__arctype.channeltype where #@__arctype.ID=$ID");
$myrow = $dsql->GetOne();
if(empty($dopost)) $dopost = "";
//---------------------------------------------
//�����¼���Ӧ��ע����ĺ�����Ϊ�˷�����UltraEdit����ʾ
//---------------------------------------------
/*---------------------
function action_save();
----------------------*/
if($dopost=="save")
{
   $description = Html2Text($description);
   $keywords = Html2Text($keywords);
   if(empty($isinherit)) $isinherit = 0;
   
   $upquery = "Update #@__arctype set 
   sortrank = '$sortrank',
   typename = '$typename',
   isdefault = '$isdefault',
   defaultname = '$defaultname',
   issend = '$issend',
   channeltype = '$channeltype',
   tempindex = '$tempindex',
   templist = '$templist',
   temparticle = '$temparticle',
   tempone = '$tempone',
   namerule = '$namerule',
   namerule2 = '$namerule2',
   ispart = '$ispart',
   description = '$description',
   keywords = '$keywords'
   where ID='$ID'";
   $dsql->SetQuery($upquery);
   if(!$dsql->ExecuteNoneQuery($upquery)){
   	 $dsql->Close();
   	 ShowMsg("���浱ǰ��Ŀ����ʱʧ�ܣ�����������������Ƿ�������⣡","-1");
   	 exit();
   }
   require_once(dirname(__FILE__)."/../include/inc_typeunit2.php");
   $tu = new TypeUnit();
   $tu->GetSunTypes($ID);
   $idarr = $tu->idArray;
   $idsql = "";
   foreach($idarr as $idd){
   	 if($idd=="") continue;
   	 if($idsql=="")  $idsql = " ID='$idd' ";
   	 else $idsql .= " or ID='$idd' ";
   }
   if($idsql!="") $idsql = " And ($idsql) ";
   //�����¼���Ŀ���������͡�ģ�塢��������
   //--------------------------
   if($isinherit==1){
   	  $upquery = "Update #@__arctype set 
         isdefault = '$isdefault',
         defaultname = '$defaultname',
         issend = '$issend',
         tempindex = '$tempindex',
         templist = '$templist',
         temparticle = '$temparticle',
         tempone = '$tempone',
         namerule = '$namerule',
         namerule2 = '$namerule2'
      where ID>0 $idsql";
      $dsql->SetQuery($upquery);
      if(!$dsql->ExecuteNoneQuery($upquery)){
   	     $dsql->Close();
   	     ShowMsg("��������Ŀ��Ϣ����ʱʧ�ܣ�������������Ƿ�������⣡","-1");
   	     exit();
      }
   }
   //���Ϊ������Ŀ�������¼���Ŀ����������
   //--------------------------
   if($reID==0){
   	 $upquery = "Update #@__arctype set channeltype = '$channeltype' where ID>0 $idsql";
      $dsql->SetQuery($upquery);
      if(!$dsql->ExecuteNoneQuery($upquery)){
   	     $dsql->Close();
   	     ShowMsg("��������Ŀ��Ϣ����ʱʧ�ܣ�������������Ƿ�������⣡","-1");
   	     exit();
      }
   }
   $tu->Close();
   $dsql->Close();
   ShowMsg("�ɹ�����һ�����࣡","catalog_main.php");
   exit();
}//End dopost==save
?>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
<title>��Ŀ����</title>
<link href='base.css' rel='stylesheet' type='text/css'>
<script language="javascript">
	function SelectTemplets(fname)
  {
     var posLeft = window.event.clientY-200;
     var posTop = window.event.clientX-300;
     window.open("../include/dialog/select_templets.php?f="+fname, "poptempWin", "scrollbars=yes,resizable=yes,statebar=no,width=600,height=400,left="+posLeft+", top="+posTop);
  }
</script>
</head>
<body background='img/allbg.gif' leftmargin='15' topmargin='10'>
<table width="98%" border="0" cellpadding="3" cellspacing="1" bgcolor="#666666">
  <tr> 
    <td height="19" background='img/tbg.gif'><a href="catalog_main.php"><u>��Ŀ����</u></a>&gt;&gt;������Ŀ</td>
  </tr>
  <tr> 
    <td height="95" align="center" bgcolor="#FFFFFF">
    <table width="98%" border="0" cellspacing="0" cellpadding="0">
        <form name="form1" action="catalog_edit.php" method="post">
          <input type="hidden" name="dopost" value="save">
          <input type="hidden" name="ID" value="<?=$myrow['ID'];?>">
          <input type="hidden" name="reID" value="<?=$myrow['reID'];?>">
          <tr> 
            <td height="26" width="120">�Ƿ�֧��Ͷ�壺</td>
            <td><input type='radio' name='issend' value='0' class='np' <?if($myrow['issend']=="0") echo " checked";?>>
              ��֧�� &nbsp;&nbsp; <input type='radio' name='issend' value='1' class='np' <?if($myrow['issend']=="1") echo " checked";?>>
              ֧�� </td>
          </tr>
          <tr> 
            <td height="26">��Ŀ���ƣ�</td>
            <td><input name="typename" type="text" id="typename" size="30" value="<?=$myrow['typename']?>"></td>
          </tr>
          <tr> 
            <td height="26"> ����˳�� </td>
            <td><input name="sortrank" size="6" type="text" value="<?=$myrow['sortrank']?>">���ɵ� -&gt; �ߣ�</td>
          </tr>
          <tr> 
            <td height="26">�ļ�����Ŀ¼��</td>
            <td>
            	<?=$myrow['typedir']?>
            </td>
          </tr>
          <tr> 
            <td height="26"> �������ͣ� &nbsp; </td>
            <td>
            <select name="channeltype" style="width:200px">
           <?
            $dsql->SetQuery("select * from #@__channeltype where ID='".$myrow['channeltype']."'");
            $dsql->Execute("c");
            $row=$dsql->GetObject("c");
            echo "    <option value='".$row->ID."' selected>".$row->typename."(cid=".$row->nid.")</option>\r\n";
            if($myrow['reID']==0)
            {
            	$dsql->SetQuery("select * from #@__channeltype where And ID>-1 And ID<>'".$myrow['channeltype']."'");
              $dsql->Execute("c");
              while($row=$dsql->GetObject("c"))
              {
              	echo "    <option value='".$row->ID."'>".$row->typename."(cid=".$row->nid.")</option>\r\n";
              }
            }
           ?>
              </select> </td>
          </tr>
          <tr> 
            <td height="26">�б�ҳѡ�</td>
            <td>
              <input type='radio' name='isdefault' value='1' class='np'<? if($myrow['isdefault']==1) echo " checked";?>>
              ���ӵ�Ĭ��ҳ
              <input type='radio' name='isdefault' value='0' class='np'<? if($myrow['isdefault']==0) echo " checked";?>>
              ���ӵ��б��һҳ
              <input type='radio' name='isdefault' value='-1' class='np'<? if($myrow['isdefault']==-1) echo " checked";?>>
              �б�ʹ�ö�̬ҳ
            </td>
          </tr>
          <tr> 
            <td height="26">Ĭ��ҳ�����ƣ� </td>
            <td><input name="defaultname" type="text" value="index.html"></td>
          </tr>
          <tr> 
            <td height="26">��Ŀ���ԣ�</td>
            <td> 
            	<input name="ispart" type="radio" id="radio" value="0" class='np'<? if($myrow['ispart']==0) echo " checked";?>>
              ��ͳ���б���ʽ
              <input name="ispart" type="radio" id="radio" value="1" class='np'<? if($myrow['ispart']==1) echo " checked";?>>
              ʹ�÷���ģ�� 
              <input name="ispart" type="radio" id="radio" value="2" class='np'<? if($myrow['ispart']==2) echo " checked";?>>
              ʹ���õ���ҳ����Ϊ��Ŀ
            </td>
          </tr>
          <tr> 
            <td height="26">ģ�������</td>
            <td>
            {tid}��ʾ��ĿID��{cid}��ʾ��Ŀ��'����ID'(�������͵ġ�(cid=***)�����Ӣ��)
            <br/>
            ģ���ļ���Ĭ��λ���Ƿ���ģ��Ŀ¼ "cms��װĿ¼<?=$cfg_templets_dir ?>" �ڡ�
            </td>
          </tr>
          <tr> 
            <td height="26">����ģ�壺</td>
            <td>
            	<input name="tempindex" type="text" value="<?=$myrow['tempindex']?>" style="width:300">
              <input type="button" name="set4" value="���..." style="width:60" onClick="SelectTemplets('form1.tempindex');">
            </td>
          </tr>
          <tr> 
            <td height="26">����ҳ��ģ�壺</td>
            <td>
            	<input name="tempone" type="text" value="<?=$myrow['tempone']?>" style="width:300">
            	<input type="button" name="set3" value="���..." style="width:60" onClick="SelectTemplets('form1.tempone');">
            </td>
          </tr>
          <tr> 
            <td height="26">�б�ģ�壺</td>
            <td>
            	<input name="templist" type="text" value="<?=$myrow['templist']?>" style="width:300">
            	<input type="button" name="set2" value="���..." style="width:60" onClick="SelectTemplets('form1.templist');">
            </td>
          </tr>
          <tr> 
            <td height="26">����ģ�壺</td>
            <td>
            	<input name="temparticle" type="text" value="<?=$myrow['temparticle']?>" style="width:300">
            	<input type="button" name="set1" value="���..." style="width:60" onClick="SelectTemplets('form1.temparticle');">
            </td>
          </tr>
          <tr> 
            <td height="26" colspan="2"> (Y��M��DΪ�����գ�YMD����ϲ������С�.������������{aid}�ɻ�Ϊ{pinyin}��ʾ��ƴ��+����ID��) 
            </td>
          </tr>
          <tr> 
            <td height="26">������������</td>
            <td>{typedir}/ 
              <input name="namerule" type="text" id="namerule" value="<?=$myrow['namerule']?>" size="30"> 
            </td>
          </tr>
          <tr> 
            <td height="26">�б���������</td>
            <td>{typedir}/ 
              <input name="namerule2" type="text" id="namerule2" value="<?=$myrow['namerule2']?>" size="30"></td>
          </tr>
          <tr> 
            <td height="65">�ؼ��֣�</td>
            <td> <textarea name="keywords" cols="40" rows="3" id="keywords"><?=$myrow['keywords']?></textarea> 
            </td>
          </tr>
          <tr> 
            <td height="65">��Ŀ������</td>
            <td height="65"> <textarea name="description" cols="40" rows="3" id="description"><?=$myrow['description']?></textarea></td>
          </tr>
          <tr> 
            <td height="26">�̳�ѡ�</td>
            <td>
            	<input name="isinherit" type="checkbox" id="isinherit" value="1" class="np">
            	ͬʱ�����¼���Ŀ��ģ�塢���������ͨ������
            </td>
          </tr>
          <tr> 
            <td height="50"></td>
            <td>
            <input type="button" name="Submit" value=" �ύ " onClick="javascript:if(document.form1.typename.value!='') document.form1.submit();"> 
              ����
              <input type="button" name="Submit2" value=" ���� " onClick="javascript:location.href='catalog_main.php';"> 
            </td>
          </tr>
          <tr> 
            <td height="20" colspan="2">&nbsp;</td>
          </tr>
        </form>
      </table></td>
  </tr>
</table>
<?
$dsql->Close();
?>
</body>
</html>
