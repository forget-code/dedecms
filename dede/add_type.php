<?
require_once("config.php");
require_once("inc_modpage.php");
$conn = connectMySql();
if(empty($ID)) $ID="";
if(empty($listtype)) $listtype="";
if(empty($modname)) $modname="";
$ID = ereg_replace("[^0-9]","",$ID);
if(empty($channeltype)) $channeltype = "";
if(!empty($typename))
{
     if(!isset($ispart)) $ispart=0;
     $description = ereg_replace("[\"><'\r\n]","",trim($description));
     if(!empty($ID))
     {
	    $fullpath = $base_dir.$art_dir."/$nextdir/$typedir";
	    if($typedir!=""&&is_dir($fullpath))
	    {
	    	echo "<script>alert('Ŀ¼�Ѵ���,�����Ŀ¼·����');history.go(-1);</script>";
	    	exit();
	    }
	    $in_query = "insert into dede_arttype(reID,typename,typedir,isdefault,defaultname,
	    issend,channeltype,modname,maxpage,ispart,description)
	    Values($ID,'$typename','',$isdefault,'$defaultname',
	    $issend,$channeltype,'$modname',$maxpage,$ispart,'$description')";
	    mysql_query($in_query,$conn);
	    $nid = mysql_insert_id($conn);
	    if($nid!="")
	    {
	    	if($typedir=="") $typedir=$nid;
	    	else
	    	{
	    		if(!is_dir($fullpath)) @mkdir($base_dir.$art_dir."/$nextdir/$typedir",0777);
	    		$typedir = "$nextdir/$typedir";
	    	}
	    	mysql_query("Update dede_arttype set typedir='$typedir' where ID=$nid",$conn);
	    	if(file_exists($base_dir.$mod_dir."/list/list_user_$ID.htm"))
	    	@copy($base_dir.$mod_dir."/list/list_user_$ID.htm",$base_dir.$mod_dir."/list/list_user_$nid.htm"); 
	    	if(file_exists($base_dir.$mod_dir."/view/mod/viewart_user_$ID.htm"))
	    	@copy($base_dir.$mod_dir."/view/mod/viewart_user_$ID.htm",$base_dir.$mod_dir."/view/mod/viewart_user_$nid.htm");
	    }
	    else
	    {
	    	echo "<script>alert('�½���Ƶ��ʱʧ�ܣ�');//history.go(-1);</script>";
	    	echo mysql_error();
	    	exit();
	    }
	 }
	 else
	 {
	    $fullpath = $base_dir.$art_dir."/$typedir";
	    if($typedir!=""&&is_dir($fullpath))
	    {
	    	echo "<script>alert('Ŀ¼�Ѵ���,�����Ŀ¼��');history.go(-1);</script>";
	    	exit();
	    }
	    $in_query = "insert into dede_arttype(reID,typename,typedir,isdefault,defaultname,issend,channeltype,modname,maxpage,ispart,description) Values(0,'$typename','',$isdefault,'$defaultname',$issend,$channeltype,'$modname',$maxpage,'$ispart','$description')";
	    mysql_query($in_query,$conn);
	    $nid = mysql_insert_id($conn);
	    if($nid!="")
	    {
	    	if($typedir=="") $typedir=$nid;
	    	if(!is_dir($fullpath))
	    	{
	    		@mkdir($base_dir.$art_dir."/$typedir",$dir_purview);
	    	}
	    	mysql_query("Update dede_arttype set typedir='$typedir' where ID=$nid",$conn);
	    }
	    else
	    {
	    	echo "<script>alert('�½���Ƶ��ʱʧ�ܣ�');history.go(-1);</script>";
	    	exit();
	    }
	 }
	 echo "<script>alert('�ɹ�����һ��Ƶ����');location.href='list_type.php?ID=$ID';</script>";
	 exit();
	 
}
if($listtype!="all")
{
	$rs = mysql_query("Select dede_arttype.*,dede_channeltype.typename as ctypename From dede_arttype left join dede_channeltype on dede_channeltype.ID=dede_arttype.channeltype where dede_arttype.ID=$ID",$conn);
	$row = mysql_fetch_object($rs);
	$typedir = $row->typedir;
	$channeltype=$row->channeltype;
	$channelname=$row->ctypename;
	$modname=$row->modname;
	$maxpage=$row->maxpage;
	$issend = $row->issend;
}
if(empty($maxpage)) $maxpage=100;
if(empty($issend)) $issend=0;
?>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
<title>Ƶ������</title>
<link href='base.css' rel='stylesheet' type='text/css'>
<script src='menu.js' language='JavaScript'></script>
</head>
<body background='img/allbg.gif' leftmargin='15' topmargin='10'>
<table width="98%" border="0" cellpadding="3" cellspacing="1" bgcolor="#666666">
  <tr> 
    <td height="19" background='img/tbg.gif'><a href="list_type.php"><u>Ƶ������</u></a>&gt;&gt;[����Ƶ��</td>
  </tr>
  <tr> 
    <td height="95" align="center" bgcolor="#FFFFFF">
    <table width="90%" border="0" cellspacing="0" cellpadding="0">
        <form name="form1" action="add_type.php" method="post">
          <input type="hidden" name="ID" value="<?if(!empty($ID)) echo $ID;?>">
          <input type="hidden" name="nextdir" value="<?if(!empty($typedir)) echo $typedir;?>">
          <tr> 
            <td colspan="2">�Ƿ�֧��Ͷ�壺</td>
          </tr>
          <tr> 
            <td  colspan="2" height="30"> <input type='radio' name='issend' value='0' class='np' <?if($issend=="0") echo " checked";?>>
              ��֧�� &nbsp;&nbsp; <input type='radio' name='issend' value='1' class='np' <?if($issend=="1") echo " checked";?>>
              ֧�� </td>
          </tr>
          <tr> 
            <td colspan="2">������Ƶ�����ƣ�</td>
          </tr>
          <tr> 
            <td height="30"  colspan="2"> <input name="typename" type="text" id="typename" size="20">
              �������鵵ҳ���� <input name="maxpage" size="8" type="text" value="<?=$maxpage?>">
              [-1Ϊ����] </td>
          </tr>
          <tr> 
            <td colspan="2">������Ŀ¼���ƣ�(������Ŀ¼�ڵ��¼�Ŀ¼�������밴ID������,��������)</td>
          </tr>
          <tr> 
            <td  colspan="2" height="30"> 
              <?
            echo $art_dir."/";
            if(!empty($typedir)) echo $typedir."/";
            ?>
              <input name="typedir" type="text" id="typedir"></td>
          </tr>
          <tr> 
            <td  colspan="2" height="30"> �������ͣ� &nbsp;&nbsp; <select name="channeltype">
                <?
            if(empty($channeltype)) $channeltype="0";
            $rs2 = mysql_query("select * from dede_channeltype where ID!=$channeltype order by ID",$conn);
            if($listtype!="all")
            	echo "    <option value='$channeltype'>$channelname</option>\r\n";
            else
            	while($row2=mysql_fetch_object($rs2))
            	{
            		echo "    <option value='".$row2->ID."'>".$row2->typename."</option>\r\n";
            	}
            ?>
              </select> &nbsp; ģ�壺 
              <select name="modname">
                <?
            $mp = new modPage();
            if($listtype=="all")
            	$ds = $mp->GetModArray();
            else
            	$ds = $mp->GetModArray($modname);
            if($ds!="")
            {
            	foreach($ds as $d)
            		echo "<option value='$d'>$d</option>\r\n";
            }
            ?>
              </select> &nbsp; <script language="javascript">
            function viewSelMode()
            {
            	baseUrl = "<?=$mod_dir?>";
            	modname = document.form1.modname[document.form1.modname.selectedIndex].value;
            	fullUrl = baseUrl+"/"+modname+"/info.gif";
            	window.open(fullUrl, 'imagein', 'scrollbars=no,resizable=no,width=325,height=245,left=100, top=50,screenX=0,screenY=0');
            }
            </script> <input type="button" value="Ԥ��ģ��" name="vvv" onClick="viewSelMode();"> 
            </td>
          </tr>
          <tr> 
            <td  colspan="2" height="30"> <input type='radio' name='isdefault' value='1' class='np' checked>
              ��Ĭ��ҳ &nbsp; <input type='radio' name='isdefault' value='0' class='np'>
              ����Ĭ��ҳ &nbsp; <input type='radio' name='isdefault' value='-1' class='np'>
              ʹ�ö�̬�б�ҳ </td>
          </tr>
          <tr> 
            <td colspan="2">Ĭ��ҳ�����ƣ� <input name="defaultname" type="text" value="index.html"></td>
          </tr>
          <tr> 
            <td height="30" colspan="2">
            <input name="ispart" type="checkbox" id="ispart" value="1"<?if($listtype=="all") echo "checked";?>>
              �ѱ�Ŀ¼��Ϊ���(��ʹ�ð��ģ�壬���<u>û���¼���Ŀ</u>����ѡ��)</td>
          </tr>
          <tr>
            <td height="30" colspan="2">��Ŀ���������������ģ������{dede:field name='description'/}��Ϊ�ؼ��ַ���meta����У�</td>
          </tr>
          <tr> 
            <td height="30" colspan="2">
			<textarea name="description" cols="40" rows="3" id="description"></textarea>
              [125��������,250�ַ�] </td>
          </tr>
          <tr> 
            <td width="51%" height="30"></td>
            <td width="49%"><input type="button" name="Submit" value=" �ύ " onClick="javascript:if(document.form1.typename.value!='') document.form1.submit();"> 
              &nbsp; <input type="button" name="Submit2" value=" ���� " onClick="javascript:location.href='list_type.php';"></td>
          </tr>
          <tr> 
            <td height="20" colspan="2">&nbsp;</td>
          </tr>
        </form>
      </table></td>
  </tr>
</table>
</body>
</html>
