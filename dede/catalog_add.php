<?
require_once(dirname(__FILE__)."/config.php");
if(empty($ID)) $ID="0";
if(empty($listtype)) $listtype="";
if(empty($dopost)) $dopost = "";
if(empty($channeltype)) $channeltype = "";
if(empty($issend)) $issend="0";
$ID = ereg_replace("[^0-9]","",$ID);
$dsql = new DedeSql(false);
//--------------------------
//��ȡ�Ӹ�Ŀ¼�̳е�Ĭ�ϲ���
//--------------------------
if($listtype!="all" && $dopost=="")
{
	$dsql->SetQuery("Select #@__arctype.*,#@__channeltype.typename as ctypename From #@__arctype left join #@__channeltype on #@__channeltype.ID=#@__arctype.channeltype where #@__arctype.ID=$ID");
	$row = $dsql->GetOne();
	$typedir = $row['typedir'];
	$channeltype=$row['channeltype'];
	$channelname=$row['ctypename'];
	$issend = $row['issend'];
}
//---------------------------------------------
//�����¼���Ӧ��ע����ĺ�����Ϊ�˷�����UltraEdit����ʾ
//---------------------------------------------
/*---------------------
function action_save();
----------------------*/
if($dopost=="save")
{
   if(empty($reID)) $reID = 0;
   $description = Html2Text($description);
   $keywords = Html2Text($keywords);
   
   //�������±���Ŀ¼
   if(empty($isnext)) $isnext = 0;
   if($isnext==0) $nextdir = "/";
   if($typedir=="" && $ispart!=2) $typedir = GetPinyin($typename);
   else $typedir = str_replace("\\","/",$typedir);
   $typedir = $nextdir.ereg_replace("^/","",$typedir);
   
   if(!CreateDir($typedir))
   {
   	  $dsql->Close();
   	  ShowMsg("����Ŀ¼ $fullpath ʧ�ܣ��������·���Ƿ�������⣡","-1");
   	  exit();
   }
   
   $in_query = "insert into #@__arctype(
   reID,sortrank,typename,typedir,isdefault,defaultname,issend,channeltype,
   tempindex,templist,temparticle,tempone,modname,namerule,namerule2,
   ispart,description,keywords)Values(
   '$reID','$sortrank','$typename','$typedir','$isdefault','$defaultname','$issend','$channeltype',
   '$tempindex','$templist','$temparticle','$tempone','default','$namerule','$namerule2',
   '$ispart','$description','$keywords')";
   $dsql->SetQuery($in_query);
   if(!$dsql->ExecuteNoneQuery($in_query))
   {
   	 $dsql->Close();
   	 ShowMsg("����Ŀ¼����ʱʧ�ܣ�����������������Ƿ�������⣡","-1");
   	 exit();
   }
   
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
        <form name="form1" action="catalog_add.php" method="post">
          <input type="hidden" name="dopost" value="save">
          <input type="hidden" name="reID" value="<?if(!empty($ID)) echo $ID;?>">
          <tr> 
            <td height="26" width="120">�Ƿ�֧��Ͷ�壺</td>
            <td><input type='radio' name='issend' value='0' class='np' <?if($issend=="0") echo " checked";?>>
              ��֧�� &nbsp;&nbsp; <input type='radio' name='issend' value='1' class='np' <?if($issend=="1") echo " checked";?>>
              ֧�� </td>
          </tr>
          <tr> 
            <td height="26">��Ŀ���ƣ�</td>
            <td><input name="typename" type="text" id="typename" size="30"></td>
          </tr>
          <tr> 
            <td height="26"> ����˳�� </td>
            <td><input name="sortrank" size="6" type="text" value="50">���ɵ� -&gt; �ߣ� </td>
          </tr>
          <tr> 
            <td height="26">�ϼ�Ŀ¼��</td>
            <td> 
              <?
            $pardir = $cfg_arcdir."/";
            if(!empty($typedir)) $pardir = $typedir."/";
            echo $pardir;
            ?>
              <input name="nextdir" type="hidden" id="nextdir" value="<?=$pardir?>"> 
            </td>
          </tr>
          <tr> 
            <td height="26">�ļ�����Ŀ¼��</td>
            <td> <input name="typedir" type="text" id="typedir"> <input name="isnext" type="checkbox" id="isnext" class="np" value="1" checked>
              ���ϼ�Ŀ¼���� 
              <input name="upinyin" type="checkbox" id="upinyin" class="np" value="1" checked>
              ʹ��ƴ�� </td>
          </tr>
          <tr> 
            <td height="26"> �������ͣ� &nbsp; </td>
            <td> <select name="channeltype" style="width:200px">
                <?
            if(empty($channeltype)) $channeltype="0";
            $dsql->SetQuery("select * from #@__channeltype where ID!=$channeltype And ID>-1 And isshow=1 order by ID");
            $dsql->Execute();
            if($listtype!="all")
            	echo "    <option value='$channeltype'>$channelname</option>\r\n";
            else
            {
            	while($row=$dsql->GetObject())
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
              <input type='radio' name='isdefault' value='1' class='np' checked>
              ���ӵ�Ĭ��ҳ
              <input type='radio' name='isdefault' value='0' class='np'>
              ���ӵ��б��һҳ
              <input type='radio' name='isdefault' value='-1' class='np'>
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
            	<input name="ispart" type="radio" id="radio" value="0" class='np' checked>
              ��ͳ���б���ʽ
              <input name="ispart" type="radio" id="radio" value="1" class='np'>
              ʹ�÷���ģ�� 
              <input name="ispart" type="radio" id="radio" value="2" class='np'>
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
            	<input name="tempindex" type="text" value="default/index_{cid}.htm" style="width:300">
            	<input type="button" name="set1" value="���..." style="width:60" onClick="SelectTemplets('form1.tempindex');">
            </td>
          </tr>
          <tr> 
            <td height="26">����ҳ��ģ�壺</td>
            <td>
            	<input name="tempone" type="text" value="" style="width:300">
            	<input type="button" name="set2" value="���..." style="width:60" onClick="SelectTemplets('form1.tempone');">
            </td>
          </tr>
          <tr> 
            <td height="26">�б�ģ�壺</td>
            <td>
            	<input name="templist" type="text" value="default/list_{cid}.htm" style="width:300">
            	<input type="button" name="set3" value="���..." style="width:60" onClick="SelectTemplets('form1.templist');">
            </td>
          </tr>
          <tr> 
            <td height="26">����ģ�壺</td>
            <td>
            	<input name="temparticle" type="text" value="default/article_{cid}.htm" style="width:300">
              <input type="button" name="set4" value="���..." style="width:60" onClick="SelectTemplets('form1.temparticle');">
            </td>
          </tr>
          <tr> 
            <td height="26" colspan="2"> (Y��M��DΪ�����գ�YMD����ϲ������С�.������������{aid}�ɻ�Ϊ{pinyin}��ʾ��ƴ��+����ID��) 
            </td>
          </tr>
          <tr> 
            <td height="26">������������</td>
            <td>{typedir}/ 
              <input name="namerule" type="text" id="namerule" value="{Y}/{M}{D}/{aid}.html" size="30"> 
            </td>
          </tr>
          <tr> 
            <td height="26">�б���������</td>
            <td>{typedir}/ 
              <input name="namerule2" type="text" id="namerule2" value="list_{page}.html" size="30"></td>
          </tr>
          <tr> 
            <td height="65">�ؼ��֣�</td>
            <td> <textarea name="keywords" cols="40" rows="3" id="keywords"></textarea> 
            </td>
          </tr>
          <tr> 
            <td height="65">��Ŀ������</td>
            <td height="65"> <textarea name="description" cols="40" rows="3" id="textarea2"></textarea></td>
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
