<?php 
require_once(dirname(__FILE__)."/config.php");
CheckPurview('c_New');
$dsql = new DedeSql(false);
$row = $dsql->GetOne("Select ID From #@__channeltype order by ID desc limit 0,1 ");
$newid = $row['ID']+1;
if($newid<10) $newid = $newid+10;
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>����Ƶ��</title>
<style type="text/css">
<!--
body {
	background-image: url(img/allbg.gif);
}
-->
</style>
<script language="javascript">
<!--
function SelectGuide(fname)
{
   var posLeft = window.event.clientY-200;
   var posTop = window.event.clientX-200;
   window.open("mychannel_field_make.php?f="+fname, "popUpImagesWin", "scrollbars=yes,resizable=no,statebar=no,width=600,height=420,left="+posLeft+", top="+posTop);
}
-->
</script>
<link href="base.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.STYLE1 {color: #FF0000}
-->
</style>
</head>
<body topmargin="8">
<table width="98%"  border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#98CAEF">
  <form name="form1" action="mychannel_add_action.php" method="post">
    <tr> 
      <td height="20" colspan="2" background="img/tbg.gif"> <b>&nbsp;<a href="mychannel_main.php"><u>Ƶ��ģ�͹���</u></a> 
        &gt; ����Ƶ��ģ�ͣ�</b> </td>
    </tr>
    <tr> 
      <td width="19%" height="28" align="center" bgcolor="#FFFFFF">Ƶ��ID</td>
      <td width="81%" bgcolor="#FFFFFF"> <input name="ID" type="text" id="ID" size="10" value="<?php echo $newid?>">
        * �����֣����ɸ��ģ�������Ψһ�ԣ� </td>
    </tr>
    <tr> 
      <td align="center" bgcolor="#FFFFFF">���ֱ�ʶ</td>
      <td bgcolor="#FFFFFF"> <input name="nid" type="text" id="nid">
        *<br> 
        �����ɸ��ģ�������Ψһ�ԣ�������Ӣ�ġ����ֻ��»�����ɣ���Ϊ����Unixϵͳ�޷�ʶ�������ļ���Ƶ��Ĭ���ĵ�ģ���� ��default/article_���ֱ�ʶ.htm�����б�ģ�塢����ģ�����ƣ� </td>
    </tr>
    
    <tr> 
      <td height="28" align="center" bgcolor="#FFFFFF">Ƶ������</td>
      <td bgcolor="#FFFFFF"> <input name="typename" type="text" id="typename">
        * ��Ƶ�����������ƣ� </td>
    </tr>
    <tr> 
      <td height="28" align="center" bgcolor="#FFFFFF">���ӱ�</td>
      <td bgcolor="#FFFFFF"> <input name="addtable" type="text" id="addtable" value="<?php echo $cfg_dbprefix; ?>addon<?php echo $newid; ?>">
        ������Ӣ�ġ����֡��»������ * 
        <input name="ismake" type="checkbox" class="np" id="ismake" value="1">
        ���Ѿ��ֶ������˱� </td>
    </tr>
    <tr> 
      <td height="28" align="center" bgcolor="#FFFFFF">ģ������</td>
      <td bgcolor="#FFFFFF"> <input name="issystem" type="radio" class="np" value="0" checked>
        �Զ�ģ�� 
        <input type="radio" name="issystem" value="1" class="np">
        ϵͳģ�͡������Ϊ<u>ϵͳģ��</u>����ֹɾ������ѡ��ɸ��ģ� </td>
    </tr>
    <tr> 
      <td height="28" align="center" bgcolor="#FFFFFF">�Ƿ�֧�ֻ�ԱͶ�壺</td>
      <td bgcolor="#FFFFFF"> <input name="issend" type="radio" class="np" value="0" checked>
        ��֧�֡� 
        <input type="radio" name="issend" class="np" value="1">
        ֧�� </td>
    </tr>
    <tr> 
      <td height="28" align="center" bgcolor="#FFFFFF">��Ա���Ͷ�弶��</td>
      <td bgcolor="#FFFFFF"><select name="sendrank" id="sendrank" style="width:120">
          <?php 
              $urank = $cuserLogin->getUserRank();
              $dsql->SetQuery("Select * from #@__arcrank where adminrank<='$urank' And rank>=10");
              $dsql->Execute();
              while($row2 = $dsql->GetObject())
              {
              	echo "     <option value='".$row2->rank."'>".$row2->membername."</option>\r\n";
              }
          ?>
        </select> </td>
    </tr>
    <tr> 
      <td height="28" align="center" bgcolor="#FFFFFF">��Ա���Ĭ��״̬��</td>
      <td bgcolor="#FFFFFF"><input name="arcsta" class="np" type="radio" value="-1" checked>
        δ��� 
        <input name="arcsta" class="np" type="radio" value="0">
        ����ˣ��Զ�����HTML�� 
        <input name="arcsta" class="np" type="radio" value="1">
        ����ˣ���ʹ�ö�̬�ĵ���</td>
    </tr>
    <tr>
      <td align="center" bgcolor="#FFFFFF">�б����ֶΣ�</td>
      <td bgcolor="#FFFFFF"><input name="listadd" type="text" id="listadd" size="50">
        <br>
(��&quot;,&quot;�ֿ����������б�ģ��{dede:list}{/dede:list}����[field:name/]����) </td>
    </tr>
    <tr>
      <td height="45" align="center" bgcolor="#FFFFFF">�����ֶ����ã�</td>
      <td bgcolor="#FFFFFF"><span class="STYLE1">��ǰ�汾����߰汾��Dedecms�У�����Ҫ�ڽ���ģ��ʱ�����ֶΣ�����ģ�ͺ��ڡ����ġ�ģ�͵ĵط�����ֶμ��ɡ�</span></td>
    </tr>
    
    <tr>
      <td colspan="2" bgcolor="#F9FFEC">���������µ�ѡ������û���Լ����¿������ģ�͵ĳ��򣬱���Ĭ�ϼ��ɣ�ϵͳ���Զ����ɷ�������</td>
    </tr>
    <tr> 
      <td height="28" align="center" bgcolor="#FFFFFF">������������</td>
      <td bgcolor="#FFFFFF"> <input name="addcon" type="text" id="addcon" value="archives_add.php" size="35">
        * </td>
    </tr>
    <tr> 
      <td height="28" align="center" bgcolor="#FFFFFF">�����޸ĳ���</td>
      <td bgcolor="#FFFFFF"> <input name="editcon" type="text" id="editcon" value="archives_edit.php" size="35">
        * </td>
    </tr>
    <tr> 
      <td height="28" align="center" bgcolor="#FFFFFF">�����������</td>
      <td bgcolor="#FFFFFF"><input name="mancon" type="text" id="mancon" value="content_list.php" size="35">        
      * </td>
    </tr>
    
    <tr bgcolor="#F9FDF0"> 
      <td height="28" colspan="2"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="26%" height="45">&nbsp;</td>
            <td width="15%"><input name="imageField" class="np" type="image" src="img/button_ok.gif" width="60" height="22" border="0"></td>
            <td width="59%"><img src="img/button_back.gif" width="60" height="22" onClick="location='mychannel_main.php';" style="cursor:hand"></td>
          </tr>
        </table></td>
    </tr>
  </form>
</table>
<?php 
$dsql->Close();
?>
</body>
</html>