<?php 
require_once(dirname(__FILE__)."/config.php");
CheckPurview('sys_Edit');
if(empty($dopost)) $dopost = "";
$configfile = dirname(__FILE__)."/../include/config_hand.php";
$configfile_bak = dirname(__FILE__)."/../include/config_hand_bak.php";

if(!is_writeable($configfile)){
	echo "�����ļ�'{$configfile}'��֧��д�룬�Ͻ��޸�ϵͳ���ò�����";
	exit();
}

if(empty($gp)) $gp = 1;

//�������
if($dopost=="save")
{
	$dsql = new DedeSql(false);
	foreach($_POST as $k=>$v){
		if(ereg("^edit___",$k)) $v = cn_substr(${$k},250);
		else continue;
		$k = ereg_replace("^edit___","",$k);
		$dsql->ExecuteNoneQuery("Update #@__sysconfig set value='$v' where varname='$k' And `group`<>-1 ");
		//echo "$k = $v <br>";
	}
	$dsql->SetQuery("Select varname,value From #@__sysconfig order by aid asc");
  $dsql->Execute();
  if($dsql->GetTotalRow()<=0){
		$dsql->Close();
		ShowMsg("�ɹ���������������ݿ��ȡ��������ʱʧ�ܣ��޷����������ļ���","-1");
	  exit();
	}
  copy($configfile,$configfile_bak);
	$fp = fopen($configfile,'w');
	flock($fp,3);
	fwrite($fp,"<"."?php\r\n");
  while($row = $dsql->GetArray()){
  	fwrite($fp,"\${$row['varname']} = '".str_replace("'","\\'",$row['value'])."';\r\n");
  }
  fwrite($fp,"?".">");
  fclose($fp);
	$dsql->Close();
	ShowMsg("�ɹ�����վ�����ã�","sys_info.php");
	exit();
}
?>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
<title>ϵͳ���ò���</title>
<link href='base.css' rel='stylesheet' type='text/css'>
<script language='javascript'>
	function ShowConfig(em){
		var allgr = 6;
		for(var i=1;i<=allgr;i++){
			if(i==em) document.getElementById('td'+i).style.display = 'block';
			else document.getElementById('td'+i).style.display = 'none';
		}
	}
	function $Obj(objname){
	    return document.getElementById(objname);
    }
	function ShowHide(objname){
        var obj = $Obj(objname);
        if(obj.style.display == "block" || obj.style.display == ""){  obj.style.display = "none"; }
        else{  obj.style.display = "block"; }
    }
</script>
</head>
<style>
.npvar { width:90% }
</style>
<body background='img/allbg.gif' leftmargin='8' topmargin='8'>
<center>
    <table width="98%" border="0" cellpadding="2" cellspacing="1" bgcolor="#98CAEF" style="margin-bottom:8px" align="center">
      <tr> 
        <td height="24" background="img/tbg.gif"> &nbsp;<b>DedeCmsϵͳ���ò�����</b> 
        </td>
      </tr>
      <tr>
        <td height="24" bgcolor="#ffffff" align="center"> 
          <?php 
$ds = file(dirname(__FILE__)."/inc/configgroup.txt");
$i = 0;
foreach($ds as $dl)
{
	$dl = trim($dl);
	if(empty($dl)) continue;
	$dls = explode(',',$dl);
	$i++;
	if($i>1) echo " | <a href='javascript:ShowConfig($i)'>{$dls[1]}</a> ";
	else{
		echo " <a href='javascript:ShowConfig($i)'>{$dls[1]}</a> ";
	}
}
?>
          | <a href="#" onclick="ShowHide('addvar')">����±���</a></td>
      </tr>
      <tr id="addvar" style="display:none"> 
        <td height="24" bgcolor="#ffffff" align="center">
		<form name="fadd" action="sys_info_add.php" method="post">
		<table width="98%" border="0" cellspacing="0" cellpadding="0">
            <tr> 
              <td width="10%" height="26">�������ƣ�</td>
              <td width="23%"> <input name="varname" type="text" id="varname" class="npvar"> 
              </td>
              <td width="10%" align="center">����ֵ��</td>
              <td width="23%"> <input name="varvalue" type="text" id="varvalue" class="npvar"> 
              </td>
              <td width="10%" align="center">�������ͣ�</td>
              <td><input name="vartype" type="radio" class="np" value="string" checked>
                �ִ�/���� 
                <input type="radio" name="vartype" value="bool" class="np">
                ����(��/��)</td>
            </tr>
            <tr> 
              <td height="26">����˵����</td>
              <td><input type="text" name="varmsg"  id="varmsg" class="npvar"></td>
              <td width="10%" align="center">�����飺</td>
              <td width="23%"> 
                <?php 
			  echo "<select name='vargroup' class='npvar'>\r\n";
			  foreach($ds as $dl){
	              $dl = trim($dl);
	              if(empty($dl)) continue;
	              $dls = explode(',',$dl);
				  echo "<option value='{$dls[0]}'>{$dls[1]}</option>\r\n";
		      }
			  echo "</select>\r\n";
			  ?>
              </td>
              <td colspan="2"><input type="submit" name="Submit" value="�������" class="nbt"></td>
            </tr>
          </table>
		  </form>
		  </td>
      </tr>
    </table>
<form action="sys_info.php" method="post" name="form1">
<input type="hidden" name="dopost" value="save">
<?php 
$dsql = new DedeSql(false);
$n = 0;
foreach($ds as $dl)
{
	$dl = trim($dl);
	if(empty($dl)) continue;
	$dls = explode(',',$dl);
	$n++;
?>
<a name='#<?php echo $dls[1]?>'></a>
<table width="98%" border="0" cellpadding="2" cellspacing="1" bgcolor="#98CAEF" 
	align="center" style="margin-bottom:8px;<?php  if($n==$gp) echo "display:block"; else echo "display:none"; ?>" id="td<?php echo $n?>">
<tr>
<td height="24" background="img/tbg.gif">
&nbsp;<b><?php echo $dls[1]?></b>
<?php  if($dls[0]==-1) echo "�����������֧���ڴ˸��ģ�"; ?>
</td>
</tr>
<tr> 
<td bgcolor="#FFFFFF">
<table width="100%" border="0" cellspacing="1" cellpadding="1">
<tr align="center" bgcolor="#CCEBFD" height="24"> 
<td width="35%">����˵��</td>
<td width="45%" bgcolor="#CCEBFD">����ֵ</td>
<td width="20%">������</td>
</tr>
<?php 
$dsql->SetQuery("Select * From #@__sysconfig where `group`='".$dls[0]."' order by aid asc");
$dsql->Execute();
$i = 1;
while($row = $dsql->GetArray())
{
	if($i%2==0) $bgcolor = "#FFFFFF";
	else $bgcolor = "#ECF8FF";
	$i++;
?>
<tr align="center" height="24" bgcolor="<?php echo $bgcolor?>" 
	onMouseMove="javascript:this.bgColor='#D0EEFD';" 
	onMouseOut="javascript:this.bgColor='<?php echo $bgcolor?>';"> 
<td> 
<?php echo $row['info']?>��
</td>
<td align="left">
<?php 
if($row['type']=='bool'){
	$c1=""; $c2 = "";
	$row['value']=='��' ? $c1=" checked" : $c2=" checked";
	echo "<input type='radio' class='np' name='edit___{$row['varname']}' value='��'$c1>�� ";
	echo "<input type='radio' class='np' name='edit___{$row['varname']}' value='��'$c2>�� ";
}else if(strlen($row['value'])>30){
  echo "<textarea name='edit___{$row['varname']}' row='4' id='edit___{$row['varname']}' style='width:100%;height:50'>{$row['value']}</textarea>";
}else{
  echo "<input type='text' name='edit___{$row['varname']}' id='edit___{$row['varname']}' value='{$row['value']}' style='width:80%'>";
}
?>
</td>
<td><?php echo $row['varname']?></td>
</tr>
<?php 
}
?>
</table>
</td>
</tr>
</table>
<?php 
}
$dsql->Close();
?>
    <table width="98%" border="0" cellpadding="2" cellspacing="1" bgcolor="#98CAEF" style="margin-bottom:8px" align="center">
      <tr bgcolor="#FFCC00"> 
        <td height="26" colspan="3" bgcolor="#C4E3FB"> <strong>&nbsp;�޸����ú�ϵͳ����� 
          ../include/config_hand.php �ļ����壬����������⣬���� config_hand_bak.php ��ԭ��<strong> 
          </strong></strong></td>
      </tr>
      <tr bgcolor="#F3FFDD"> 
        <td height="50" colspan="3" bgcolor="#ECF8FF"> <table width="98%" border="0" cellspacing="1" cellpadding="1">
            <tr> 
              <td width="11%">&nbsp;</td>
              <td width="11%"><input name="imageField" type="image" src="img/button_ok.gif" width="60" height="22" border="0" class="np"></td>
              <td width="78%"><img src="img/button_reset.gif" width="60" height="22" style="cursor:hand" onclick="document.form1.reset()"></td>
            </tr>
          </table></td>
      </tr>
    </table>
  </form>
</center>
</body>
</html>