<!-- //���˹����� -->
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:6px">
        <tr align="center"> 
          
    <td height="24" colspan="2" class="mmt1">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:2px">
        <tr>
          <td width="28%" height="18" align="right" valign="top"><img src="img/dd/dedeexplode.gif" width="11" height="11" class="ittop"></td>
          <td width="72%"><strong>���˹�����</strong></td>
        </tr>
      </table>
      
    </td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td width="22%" height="21" align="center" class="mml"><img src="img/dd/stow.gif" width="16" height="16"></td>
          <td class="mmr"><a href="mystow.php"><u>�ҵ��ղؼ�</u></a></td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td width="22%" height="21" align="center" class="mml"><img src="img/dd/cd.gif" width="16" height="16"></td>
          <td class="mmr"><a href="guestbook_admin.php"><u>�ҵ����Բ�</u></a></td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td height="21" align="center" class="mml"><img src="img/dd/dir.gif" width="16" height="16"></td>
          <td class="mmr"><a href="mypay.php"><u>������Ѽ�¼</u></a></td>
        </tr>
		   <tr bgcolor="#FFFFFF"> 
          <td height="21" align="center" class="mml"><img src="img/dd/dir.gif" width="16" height="16"></td>
          <td class="mmr"><a href="my_operation.php"><u>��ʷ��������</u></a></td>
        </tr>
        <tr> 
          <td colspan="2" height="6" class="mmb">&nbsp;</td>
        </tr>
</table>
<!-- //���˿ռ� -->
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:6px">
        <tr align="center"> 
          
    <td height="24" colspan="2" class="mmt"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:2px">
        <tr> 
          <td width="28%" height="18" align="right" valign="top"><img src="img/dd/dedeexplode.gif" width="11" height="11" class="ittop"></td>
          <td width="72%"><strong>��������</strong></td>
        </tr>
      </table>
    </td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td height="21" align="center" class="mml"><img src="img/dd/menumember.gif" width="16" height="15"></td>
          <td class="mmr"><a href="edit_pwd.php"><u>��¼�������</u></a></td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td height="21" align="center" class="mml"><img src="img/dd/menumember.gif" width="16" height="15"></td>
          <td class="mmr"><a href="edit_info.php"><u>�������ϸ���</u></a></td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td height="21" align="center" class="mml"><img src="img/dd/home.gif" width="16" height="16"></td>
          <td class="mmr"><a href="space_info.php"><u>�ռ���Ϣ����</u></a></td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td height="21" align="center" class="mml"><img src="img/dd/dir.gif" width="16" height="16"></td>
          <td class="mmr"><a href="flink_main.php"><u>�������ӹ���</u></a></td>
        </tr>
        <tr> 
          <td colspan="2" height="6" class="mmb">&nbsp;</td>
        </tr>
</table>
<!-- //���� -->
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:6px">
        <tr align="center"> 
          
    <td height="24" colspan="2" class="mmt"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:2px">
        <tr> 
          <td width="28%" height="18" align="right" valign="top"><img src="img/dd/dedeexplode.gif" width="11" height="11" class="ittop"></td>
          <td width="72%"><strong>�ҵ��ĵ�</strong></td>
        </tr>
      </table>
      
    </td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td height="21" align="center" class="mml"><img src="img/dd/exe.gif" width="16" height="16"></td>
          <td class="mmr"><a href="article_add.php"><u>����������</u></a></td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td width="22%" height="21" align="center" class="mml"><img src="img/dd/dir.gif" width="16" height="16"></td>
          <td class="mmr"><a href="content_list.php?channelid=1"><u>�ѷ��������</u></a></td>
        </tr>
    <?php 
    if($cfg_mb_album=='��'){
    ?>    
    <tr bgcolor="#FFFFFF"> 
        <td height="21" align="center" class="mml"><img src="img/dd/exe.gif" width="16" height="16"></td>
        <td class="mmr"><a href="album_add.php"><u>������ͼ��</u></a></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
        <td width="22%" height="21" align="center" class="mml"><img src="img/dd/dir.gif" width="16" height="16"></td>
        <td class="mmr"><a href="content_list.php?channelid=2"><u>�ѷ����ͼ��</u></a></td>
    </tr>
  <?php  } ?>
     <tr bgcolor="#FFFFFF"> 
        <td height="21" align="center" class="mml"><img src="img/dd/image.gif" width="16" height="16"></td>
        <td class="mmr"><a href="space_upload.php"><u>��������</u></a></td>
     </tr>
     <tr bgcolor="#FFFFFF"> 
          <td height="21" align="center" class="mml"><img src="img/dd/dir2.gif" width="16" height="16"></td>
          <td class="mmr"><a href="archives_type.php"><u>�����ҵķ���</u></a></td>
    </tr>
        <tr> 
          <td colspan="2" height="6" class="mmb">&nbsp;</td>
        </tr>
</table>
<!-- �Զ���ģ��Ͷ�� -->
<?php 
if($cfg_mb_sendall=='��'){
if(!isset($dsql) || !is_object($dsql)){
	$dsql = new DedeSql(false);
}
$dsql->SetQuery("Select ID,typename From #@__channeltype where issend=1 And issystem=0");
$dsql->Execute();
while($menurow = $dsql->GetArray())
{
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:6px">
        <tr align="center"> 
          
    <td height="24" colspan="2" class="mmt"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:2px">
        <tr> 
          <td width="28%" height="18" align="right" valign="top"><img src="img/dd/dedeexplode.gif" width="11" height="11" class="ittop"></td>
          <td width="72%"><strong><?php echo $menurow['typename']?></strong></td>
        </tr>
      </table>
      
    </td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td height="21" align="center" class="mml"><img src="img/dd/exe.gif" width="16" height="16"></td>
          <td class="mmr"><a href="archives_add.php?channelid=<?php echo $menurow['ID']?>"><u>������<?php echo $menurow['typename']?></u></a></td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td width="22%" height="21" align="center" class="mml"><img src="img/dd/dir.gif" width="16" height="16"></td>
          <td class="mmr"><a href="content_list.php?channelid=<?php echo $menurow['ID']?>"><u>�ѷ���<?php echo $menurow['typename']?></u></a></td>
        </tr>
        <tr> 
          <td colspan="2" height="6" class="mmb">&nbsp;</td>
        </tr>
</table>
<?php 
}}
?>