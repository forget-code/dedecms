<?
require_once(dirname(__FILE__)."/config.php");
require_once(dirname(__FILE__)."/../include/pub_dedetag.php");
CheckPurview('c_Edit');
if(empty($dopost)) $dopost="";
$ID = ereg_replace("[^0-9\-]","",$ID);
if($dopost=="show")
{
	$dsql = new DedeSql(false);
	$dsql->SetQuery("update #@__channeltype set isshow=1 where ID='$ID'");
	$dsql->ExecuteNoneQuery();
	$dsql->Close();
	ShowMsg("�����ɹ���","mychannel_main.php");
	exit();
}
else if($dopost=="hide")
{
	$dsql = new DedeSql(false);
	$dsql->SetQuery("update #@__channeltype set isshow=0 where ID='$ID'");
	$dsql->ExecuteNoneQuery();
	$dsql->Close();
	ShowMsg("�����ɹ���","mychannel_main.php");
	exit();
}
else if($dopost=="save")
{
	
	$query = "
	update #@__channeltype set 
	typename = '$typename',
	addtable = '$addtable',
	addcon = '$addcon',
	mancon = '$mancon',
	editcon = '$editcon',
	fieldset = '$fieldset',
	listadd = '$listadd',
	issend = '$issend',
	arcsta = '$arcsta',
	sendrank = '$sendrank'
	where ID='$ID'
	";
	
	$dtp = new DedeTagParse();
	$dtp->SetNameSpace("field","<",">");
  $dtp->LoadSource(stripslashes($fieldset));
  if(!is_array($dtp->CTags)){
  	$dsql->Close();
  	ShowMsg("���ò�����Ч��","-1");
  	exit();
  }
  
  $dsql = new DedeSql(false);
  $trueTable = str_replace("#@__",$cfg_dbprefix,$addtable);
	if(!$dsql->IsTable($trueTable)){
		$dsql->Close();
  	ShowMsg("ϵͳ�Ҳ�������ָ���ı� $trueTable �����ֹ����������","-1");
  	exit();
  }
	$dsql->SetQuery($query);
	$dsql->ExecuteNoneQuery();
	
if($issystem!=1){ ////�Է�ϵͳģ�ͣ�������ݿ����Ƿ����ĳ�ֶΣ����û�о����ӣ��������޸�
	$fields = Array();
	$rs = mysql_query("show fields from $trueTable",$dsql->linkID);
	while($row = mysql_fetch_array($rs)){
		$fields[$row['Field']] = $row['Type'];
	}
  foreach($dtp->CTags as $tid=>$ctag)
  {
  	 $fieldname = $ctag->GetName();
     $dfvalue = $ctag->GetAtt('default');
     $isnull = $ctag->GetAtt('isnull');
     $dtype = $ctag->GetAtt('type');
     $mxlen = $ctag->GetAtt('maxlength');
     if($dtype=="int"||$dtype=="datetime")
     {
    		if($dfvalue=="" || ereg("[^0-9]",$dfvalue)){ $dfvalue = 0; }
    		if($isnull=="true") $tabsql = " `$fieldname` int(11) default NULL;";
    		else $tabsql = " `$fieldname` int(11) NOT NULL default '$dfvalue';";
    		$buideType = "int(11)";
     }else if($dtype=="float"){
    		if($isnull=="true") $tabsql = " `$fieldname` float default NULL;";
    		else $tabsql = " `$fieldname` float NOT NULL default '$dfvalue';";
    		$buideType = "float";
     }else if($dtype=="img"||$dtype=="media"||$dtype=="addon"){
    		if($mxlen=="") $mxlen = 200;
    		if($mxlen > 255) $mxlen = 50;
    		$tabsql = " `$fieldname` varchar($mxlen) NOT NULL default '$dfvalue';";
    		$buideType = "varchar($mxlen)";
     }else if($dtype=="multitext"||$dtype=="htmltext"){
    		if($isnull=="true") $tabsql = " `$fieldname` text NOT NULL;";
    		else $tabsql = " `$fieldname` text;";
    		$buideType = "text";
     }else if($dtype=="textdata"){
    		$tabsql = " `$fieldname` varchar(100) NOT NULL default '';";
    		$buideType = "varchar(100)";
     }else{
    		if($mxlen=="") $mxlen = 50;
    		if($mxlen > 255) $mxlen = 250;
    		$tabsql = " `$fieldname` varchar($mxlen) NOT NULL default '$dfvalue';";
    		$buideType = "varchar($mxlen)";
     }
     if(isset($fields[$fieldname]) && $fields[$fieldname]!=$buideType){
     	  $tabsql = "ALTER TABLE `$trueTable` CHANGE `$fieldname` ".$tabsql;
     }else if(!isset($fields[$fieldname])){
     	$tabsql = "ALTER TABLE `$trueTable` ADD ".$tabsql;
     }else{
     	 $tabsql = "";
     }
     if($tabsql!=""){
     	 $dsql->ExecuteNoneQuery($tabsql);
     	 $tabsql = "";
     }
  }
}//�Է�ϵͳģ�ͣ��޸��ֶ�
	$dsql->Close();
	ShowMsg("�ɹ�����һ��ģ�ͣ�","mychannel_main.php");
	exit();
}
else if($dopost=="gettemplets"){
	require_once(dirname(__FILE__)."/../include/pub_oxwindow.php");
  $dsql = new DedeSql(false);
  $row = $dsql->GetOne("Select * From #@__channeltype where ID='$ID'");
  $dsql->Close();
  $wintitle = "Ƶ������-�鿴ģ��";
	$wecome_info = "<a href='mychannel_main.php'>Ƶ������</a>::�鿴ģ��";
	  $win = new OxWindow();
	  $win->Init("","js/blank.js","");
	  $win->AddTitle("Ƶ������".$row['typename']."��Ĭ��ģ���ļ�˵����");
	  $msg = "
	    �ĵ�ģ�壺{$cfg_templets_dir}/{$cfg_df_style}/article_{$row['nid']}.htm
	     <a href='file_manage_view.php?fmdo=edit&filename=article_{$row['nid']}.htm&activepath=".urlencode("{$cfg_templets_dir}/{$cfg_df_style}")."'>[�޸�]</a><br/>
	    �б�ģ�壺{$cfg_templets_dir}/{$cfg_df_style}/list_{$row['nid']}.htm 
	    <a href='file_manage_view.php?fmdo=edit&filename=list_{$row['nid']}.htm&activepath=".urlencode("{$cfg_templets_dir}/{$cfg_df_style}")."'>[�޸�]</a>
	    <br/>
	    Ƶ������ģ�壺{$cfg_templets_dir}/{$cfg_df_style}/index_{$row['nid']}.htm
	    <a href='file_manage_view.php?fmdo=edit&filename=index_{$row['nid']}.htm&activepath=".urlencode("{$cfg_templets_dir}/{$cfg_df_style}")."'>[�޸�]</a>
	  ";
	  $win->AddMsgItem("<div style='padding:20px;line-height:300%'>$msg</div>");
	  $winform = $win->GetWindow("hand","");
	  $win->Display();
	  exit();
}
else if($dopost=="delete")
{
	CheckPurview('c_Del');
	$dsql = new DedeSql(false);
  $row = $dsql->GetOne("Select * From #@__channeltype where ID='$ID'");
  if($row['issystem'] == 1)
  {
  	$dsql->Close();
  	ShowMsg("ϵͳģ�Ͳ�����ɾ����","mychannel_main.php");
	  exit();
  }
  
  if(empty($job)) $job="";
  
  if($job=="") //ȷ����ʾ
  {
  	require_once(dirname(__FILE__)."/../include/pub_oxwindow.php");
  	$dsql->Close();
  	$wintitle = "Ƶ������-ɾ��ģ��";
	  $wecome_info = "<a href='mychannel_main.php'>Ƶ������</a>::ɾ��ģ��";
	  $win = new OxWindow();
	  $win->Init("mychannel_edit.php","js/blank.js","POST");
	  $win->AddHidden("job","yes");
	  $win->AddHidden("dopost",$dopost);
	  $win->AddHidden("ID",$ID);
	  $win->AddTitle("��ȷʵҪɾ�� (".$row['typename'].") ���Ƶ����");
	  $winform = $win->GetWindow("ok");
	  $win->Display();
	  exit();
  }
  else if($job=="yes") //����
  {
    require_once(dirname(__FILE__)."/../include/inc_typeunit_admin.php");
    $ut = new TypeUnit();
    $dsql->SetQuery("Select ID From #@__arctype where reID='0' And channeltype='$ID'");
    $dsql->Execute();
    $ids = "";
    while($row = $dsql->GetObject()){
  	  $ut->DelType($row->ID,"yes");
    }
    $dsql->SetQuery("Delete From #@__channeltype where ID='$ID'");
    $dsql->ExecuteNoneQuery();
    $dsql->Close();
	  $ut->Close();
	  ShowMsg("�ɹ�ɾ��һ��ģ�ͣ�","mychannel_main.php");
	  exit();
 }
 
}
$dsql = new DedeSql(false);
$row = $dsql->GetOne("Select * From #@__channeltype where ID='$ID'");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>����Ƶ��ģ��</title>
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
</head>
<body topmargin="8">
<table width="98%"  border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#666666">
  <form name="form1" action="mychannel_edit.php" method="post">
    <input type='hidden' name='ID' value='<?=$ID?>'>
    <input type='hidden' name='dopost' value='save'>
    <input type='hidden' name='issystem' value='<?=$row['issystem']?>'>
    <tr> 
      <td height="20" colspan="2" background="img/tbg.gif"> <b>&nbsp;<a href="mychannel_main.php"><u>Ƶ��ģ�͹���</u></a> 
        &gt; ����Ƶ��ģ�ͣ�</b> </td>
    </tr>
    <?
	if($row['issystem'] == 1)
	{
	?>
    <tr> 
      <td colspan="2" bgcolor="#FFFFFF" style="color:red"> ��Ŀǰ��չ������ϵͳģ�ͣ�ϵͳģ��һ��Է�������͹�������Ѿ��̻����������Ҹ���ϵͳģ�ͽ��ᵼ��ʹ�������������͵�Ƶ�����ܱ����� 
      </td>
    </tr>
    <?
	}
	?>
    <tr> 
      <td width="19%" align="center" bgcolor="#FFFFFF">Ƶ��ID</td>
      <td width="81%" bgcolor="#FFFFFF"> 
        <?=$row['ID']?>
      </td>
    </tr>
    <tr> 
      <td align="center" bgcolor="#FFFFFF">���ֱ�ʶ</td>
      <td bgcolor="#FFFFFF"> 
        <?=$row['nid']?>
      </td>
    </tr>
    <!--tr> 
      <td align="center" bgcolor="#FFFFFF">�Ƿ�����Ͷ��</td>
      <td bgcolor="#FFFFFF"> 
        
      </td>
    </tr-->
    <tr> 
      <td align="center" bgcolor="#FFFFFF">Ƶ������</td>
      <td bgcolor="#FFFFFF"><input name="typename" type="text" id="typename" value="<?=$row['typename']?>"></td>
    </tr>
    <tr> 
      <td align="center" bgcolor="#FFFFFF">���ӱ�</td>
      <td bgcolor="#FFFFFF"><input name="addtable" type="text" id="addtable" value="<?=$row['addtable']?>">
        ( #@__ �Ǳ�ʾ���ݱ�ǰ׺)</td>
    </tr>
    <tr> 
      <td align="center" bgcolor="#FFFFFF">�Ƿ�֧�ֻ�ԱͶ�壺</td>
      <td bgcolor="#FFFFFF"> <input name="issend" type="radio" class="np" value="0"<? if($row['issend']==0) echo " checked"; ?>>
        ��֧�� 
        <input type="radio" name="issend" class="np" value="1"<? if($row['issend']==1) echo " checked"; ?>>
        ֧�� </td>
    </tr>
    <tr>
      <td align="center" bgcolor="#FFFFFF">��Ա���Ͷ�弶��</td>
      <td bgcolor="#FFFFFF"><select name="sendrank" id="sendrank" style="width:120">
          <?
              $urank = $cuserLogin->getUserRank();
              $dsql->SetQuery("Select * from #@__arcrank where adminrank<='$urank' And rank>=10");
              $dsql->Execute();
              while($row2 = $dsql->GetObject())
              {
              	if($row2->rank==$row['sendrank']) echo "     <option value='".$row2->rank."' selected>".$row2->membername."</option>\r\n";
				else echo "     <option value='".$row2->rank."'>".$row2->membername."</option>\r\n";
              }
          ?>
        </select></td>
    </tr>
    <tr> 
      <td align="center" bgcolor="#FFFFFF">��Ա���Ĭ��״̬��</td>
      <td bgcolor="#FFFFFF">
	   <input name="arcsta" class="np" type="radio" value="-1"<? if($row['arcsta']==-1) echo " checked";?>>
        δ��� 
        <input name="arcsta" class="np" type="radio" value="0"<? if($row['arcsta']==0) echo " checked";?>>
        ����ˣ��Զ�����HTML�� 
        <input name="arcsta" class="np" type="radio" value="1"<? if($row['arcsta']==1) echo " checked";?>>
        ����ˣ���ʹ�ö�̬�ĵ���</td>
    </tr>
    <tr> 
      <td align="center" bgcolor="#FFFFFF">������������</td>
      <td bgcolor="#FFFFFF"><input name="addcon" type="text" id="addcon" value="<?=$row['addcon']?>"></td>
    </tr>
    <tr> 
      <td align="center" bgcolor="#FFFFFF">�����޸ĳ���</td>
      <td bgcolor="#FFFFFF"><input name="editcon" type="text" id="editcon" value="<?=$row['editcon']?>"></td>
    </tr>
    <tr> 
      <td align="center" bgcolor="#FFFFFF">�����������</td>
      <td bgcolor="#FFFFFF"><input name="mancon" type="text" id="mancon" value="<?=$row['mancon']?>"></td>
    </tr>
    <tr> 
      <td align="center" bgcolor="#FFFFFF">�б����ֶΣ�</td>
      <td bgcolor="#FFFFFF"><input name="listadd" type="text" id="listadd" size="50" value="<?=$row['listadd']?>"> 
        <br>
        (��&quot;,&quot;�ֿ����������б�ģ��{dede:list}{/dede:list}����[field:name/]����)</td>
    </tr>
    <tr> 
      <td height="24" align="center" bgcolor="#FFFFFF">�����ֶ����ã�</td>
      <td rowspan="2" bgcolor="#FFFFFF"><textarea name="fieldset"  style="width:600" rows="12" id="fieldset"><?=$row['fieldset']?></textarea></td>
    </tr>
    <tr> 
      <td height="110" align="center" valign="top" bgcolor="#FFFFFF"> <input name="fset" type="button" id="fset" value="�ֶ������" onClick="SelectGuide('form1.fieldset')"> 
        <br> <br> <a href="help_addtable.php" target="_blank"><u>ģ�͸����ֶζ���ο�</u></a></td>
    </tr>
    <tr bgcolor="#F9FDF0"> 
      <td height="28" colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="26%">&nbsp;</td>
            <td width="15%"><input name="imageField" class="np" type="image" src="img/button_ok.gif" width="60" height="22" border="0"></td>
            <td width="59%"><img src="img/button_back.gif" width="60" height="22" onClick="location='mychannel_main.php';" style="cursor:hand"></td>
          </tr>
        </table></td>
    </tr>
  </form>
</table>
<?
$dsql->Close();
?>
</body>
</html>