<?
require_once("config.php");
require_once("inc_modpage.php");
require_once("inc_typelink.php");
$conn = connectMySql();
if(!empty($typename))
{
	 if(!isset($ispart)) $ispart=0;
     $description = ereg_replace("[\"><'\r\n]","",trim($description));
	 if($reID=="0")
	 {
	 	$tl = new TypeLink();
		$sunids = str_replace(".typeid","ID",$tl->GetSunID($ID,""));
	 }
	 else
	 {
	 	$sunids="ID=$ID";
	 }
	 $in_query = "update dede_arttype set typename='$typename',isdefault='$isdefault',defaultname='$defaultname',modname='$modname',maxpage='$maxpage',ispart='$ispart',description='$description' where ID=$ID";
	 mysql_query($in_query,$conn);
	 mysql_query("update dede_arttype set issend=$issend,channeltype=$channeltype where $sunids",$conn);
	 echo "<script>alert('�ɹ�����һ����Ŀ��');location.href='list_type.php?ID=$ID';</script>";
	 exit();
	 
}
$rs = mysql_query("Select dede_arttype.*,dede_channeltype.typename as channelname From dede_arttype left join dede_channeltype on dede_channeltype.ID=dede_arttype.channeltype where dede_arttype.ID=$ID",$conn);
$row = mysql_fetch_object($rs);
?>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
<title>������Ŀ</title>
<link href='base.css' rel='stylesheet' type='text/css'>
<script src='menu.js' language='JavaScript'></script>
</head>
<body background='img/allbg.gif' leftmargin='6' topmargin='6'>
<table width="98%" border="0" cellpadding="3" cellspacing="1" bgcolor="#666666">
  <tr> 
    <td height="19" background='img/tbg.gif'><a href="list_type.php"><u>Ƶ������</u></a>&gt;&gt;������Ŀ</td>
  </tr>
  <tr> 
    <td height="95" align="center" bgcolor="#FFFFFF">
    <table width="96%" border="0" cellspacing="0" cellpadding="0">
        <form name="form1" action="mod_type.php" method="post">
          <input type="hidden" name="ID" value="<?=$ID?>">
          <input type="hidden" name="reID" value="<?=$row->reID?>">
          <input type="hidden" name="oldchannel" value="<?=$row->channeltype?>">
          <tr> 
            <td colspan="2">�Ƿ�֧��Ͷ�壺</td>
          </tr>
          <tr> 
            <td  colspan="2" height="30">
            <input type='radio' name='issend' value='0' class='np'<?if($row->issend=="0") echo " checked";?>> ��֧��
            &nbsp;&nbsp;
            <input type='radio' name='issend' value='1' class='np'<?if($row->issend=="1") echo " checked";?>> ֧��
            </td>
          </tr>
          <tr> 
            <td colspan="2">
            Ŀ¼���ƣ�
            </td>
          </tr>
          <tr> 
            <td colspan="2" height="30">
            <input name="typename" size="20" type="text" id="typename" value="<?=$typeoldname?>">
       �������鵵ҳ����<input name="maxpage" type="text" size="8" value="<?=$row->maxpage?>"> [-1Ϊ����]
            </td>
          </tr>
          <tr> 
            <td  colspan="2" height="30">
            �������ͣ�
            &nbsp;&nbsp;
            <select name="channeltype">
            <?
            if($row->reID!="0")
            	echo "<option value=".$row->channeltype.">".$row->channelname."</option>\r\n";
            else
            {
            	echo "<option value=".$row->channeltype.">--������--</option>\r\n";
            	$rs2 = mysql_query("select * from dede_channeltype order by ID",$conn);
            	while($row2=mysql_fetch_object($rs2))
            	{
            		echo "    <option value='".$row2->ID."'>".$row2->typename."</option>\r\n";
            	}
            }
            ?>
            </select>
            &nbsp;
            ģ�壺
            <select name="modname">
            <?
            $mp = new modPage();
            $ds = $mp->GetModArray($row->modname);
            if($ds!="")
            {
            	foreach($ds as $d)
            		echo "<option value='$d'>$d</option>\r\n";
            }
            ?>
            </select>
            &nbsp;
            <script language="javascript">
            function viewSelMode()
            {
            	baseUrl = "<?=$mod_dir?>";
            	modname = document.form1.modname[document.form1.modname.selectedIndex].value;
            	fullUrl = baseUrl+"/"+modname+"/info.gif";
            	window.open(fullUrl, 'imagein', 'scrollbars=no,resizable=no,width=325,height=245,left=100, top=50,screenX=0,screenY=0');
            }
            </script>
            <input type="button" value="Ԥ��ģ��" name="vvv" onClick="viewSelMode();">
            </td>
          </tr>
          <tr> 
            <td height="20" colspan="2" bgcolor="#F0F8E7">
            ֻ������Ƶ�����ܸ���[��������]�����ĺ����е��¼��ӷ�����������ͻ���Ÿ��ġ�
            </td>
          </tr>
          <tr> 
            <td  colspan="2" height="30">
            <input type='radio' name='isdefault' value='1' class='np'<?if($row->isdefault=="1") echo " checked";?>>
              ��Ĭ��ҳ&nbsp;
              <input type='radio' name='isdefault' value='0' class='np'<?if($row->isdefault=="0") echo " checked";?>>
              ����Ĭ��ҳ&nbsp;
            <input type='radio' name='isdefault' value='-1' class='np'<?if($row->isdefault=="-1") echo " checked";?>>
            ʹ�ö�̬�б�ҳ
              </td>
          </tr>
          <tr> 
            <td colspan="2">Ĭ��ҳ�����ƣ�<input name="defaultname" type="text" value="<?=$row->defaultname?>"></td>
          </tr>
		  <tr> 
            <td height="30" colspan="2">
            <input name="ispart" type="checkbox" id="ispart" value="1"<?if($row->ispart==1) echo "checked";?>>
              �ѱ�Ŀ¼��Ϊ���(��ʹ�ð��ģ�壬���<u>û���¼���Ŀ</u>����ѡ��)</td>
          </tr>
          <tr>
            <td height="30" colspan="2">��Ŀ���������������ģ������{dede:field name='description'/}��Ϊ�ؼ��ַ���meta����У�</td>
          </tr>
          <tr> 
            <td height="30" colspan="2">
			<textarea name="description" cols="40" rows="3" id="description"><?=$row->description?></textarea>
              [125��������,250�ַ�] </td>
          </tr>
          <tr> 
            <td width="51%" height="30"> 
            </td>
            <td width="49%"><input type="button" name="Submit" value="�������" onClick="javascript:if(document.form1.typename.value!='') document.form1.submit();"> 
              &nbsp; <input type="button" name="Submit2" value="Ƶ������" onClick="javascript:location.href='list_type.php';">
              &nbsp; <input type="button" name="Submit2" value="����ǰҳ" onClick="javascript:history.go(-1);">
              </td>
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
