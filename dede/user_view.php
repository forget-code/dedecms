<?
require("config.php");
function enStr($str)
{
	$str = str_replace("<","$lt;",$str);
	$str = str_replace("\r","",$str);
	$str = str_replace("\n","<br>\n",$str);
	$str = trim($str);
	$str = str_replace("  ","&nbsp;&nbsp;",$str);
	return($str);
}
setcookie("ENV_GOBACK_URL",$dedeNowurl,time()+3600,"/");
$ID=ereg_replace("[^0-9]","",$ID);
if($ID==""){exit();}
$sql = "Select dede_member.*,dede_aera.name as aeraname From dede_member left join dede_aera on dede_aera.ID=dede_member.aera where dede_member.ID=$ID";
$conn = connectMySql();
$rs=mysql_query($sql,$conn);
$row=mysql_fetch_object($rs);
$sex=$row->sex;
if($sex=="1") $sex="��";
else $sex="Ů";
$mypic = $base_dir."/member/upimg/$ID.jpg";
$mypicurl = "/member/upimg/$ID.jpg";
?>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
<title>��Ա����</title>
<link href='base.css' rel='stylesheet' type='text/css'>
<script src='menu.js' language='JavaScript'></script>
</head>
<body background="img/allbg.gif" leftmargin='6' topmargin='6'>
<form name="f1" method="post" action="user_modok.php">
<input type="hidden" name="ID" value="<?=$row->ID?>">
<table width="96%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#333333">
  <tr> 
    <td height="24" align="center" background='img/tbg.gif'><strong>�鿴��Ա����</strong></td>
  </tr>
  <tr> 
    <td bgcolor="#FFFFFF">
    <table width="96%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="18%" height="25" align="right">��¼ID��</td>
          <td width="82%">&nbsp;<?=$row->userid?></td>
        </tr>
        <tr> 
          <td height="25" align="right">��&nbsp;&nbsp;�룺</td>
          <td>&nbsp;<?=$row->pwd?></td>
        </tr>
        <tr> 
          <td height="25" align="right">�û�����</td>
          <td> 
		  <?
		  $rs2 = mysql_query("select * from dede_membertype where rank=".$row->rank,$conn);
		  $row2 = mysql_fetch_array($rs2);
		  echo $row2["membername"];
		  ?>
		  &nbsp;&nbsp;<a href="user_check.php?ID=<?=$ID?>&nowrank=<?=$row->rank?>">[<u>����˸��ļ���</u>]</a></td>
        </tr>
        <tr> 
          <td height="25" colspan="2"><table width="100%" border="0" cellspacing="2" cellpadding="0">
              <tr> 
                <td width="17%" height="25" align="right">Email��</td>
                <td width="83%" height="25"><?=$row->email?>
                </td>
              </tr>
              <tr> 
                <td height="25" align="right">�����ǳƣ�</td>
                <td height="25"><?=$row->uname?>
                  �Ա� 
                  <input type="radio" name="sex" value="1" <?if($row->sex==1) echo "checked"?>>
                  �� &nbsp; <input type="radio" name="sex" value="0" <?if($row->sex==0) echo "checked"?>>
                  Ů </td>
              </tr>
              <tr> 
                <td height="25" colspan="2"> <hr width="80%" size="1" noshade> 
                </td>
              </tr>
              <tr> 
                <td height="25" align="right">���䣺</td>
                <td height="25"><input name="age" type="text" id="age" size="3" value="<?=$row->age?>"> 
                  &nbsp;&nbsp;���գ� 
                  <input name="birthday" type="text" id="birthday" size="15" value="<?=$row->birthday?>"> 
                  &nbsp;[&quot;��-��-��&quot;��&quot;��-��&quot;��&quot;X��X��&quot;]</td>
              </tr>
              <tr> 
                <td height="25" align="right">���ͣ�</td>
                <td height="25"> <select name="weight">
                    <option value='ƽ��'<?if($row->weight=="ƽ��") echo " selected"?>>ƽ��</option>
                    <option value='����/��ϸ'<?if($row->weight=="����/��ϸ") echo " selected"?>>����/��ϸ</option>
                    <option value='��׳'<?if($row->weight=="��׳") echo " selected"?>>��׳</option>
                    <option value='����'<?if($row->weight=="����") echo " selected"?>>����</option>
                    <option value='����'<?if($row->weight=="����") echo " selected"?>>����</option>
                  </select> &nbsp;��ߣ� 
                  <input name="height" type="text" id="height" size="5" value="<?=$row->height?>">
                  ����</td>
              </tr>
              <tr> 
                <td height="25" align="right">ְҵ��</td>
                <td height="25"><input type="radio" name="job" value="ѧ��"<?if($row->job=="ѧ��") echo " checked"?>>
                  ѧ��&nbsp; <input name="job" type="radio" value="ְԱ"<?if($row->job=="ְԱ") echo " checked"?>>
                  ְԱ 
                  <input type="radio" name="job" value="����"<?if($row->job=="����") echo " checked"?>>
                  ���� 
                  <input type="radio" name="job" value="ʧҵ��"<?if($row->job=="ʧҵ��") echo " checked"?>>
                  ʧҵ��</td>
              </tr>
              <tr> 
                <td height="25" align="right">���ڵĵ�����</td>
                <td height="25">
				<select name="aera" id="aera">
                    <?
$ds=file("../member/aera.txt");
foreach($ds as $bb)
{
	$aa=split("\|",ereg_replace("[\r\n]","",$bb));
	if($aa[0]==$row->aera)
	   echo "<option value='".$aa[0]."' selected>".$aa[1]."</option>\r\n";
	else
	   echo "<option value='".$aa[0]."'>".$aa[1]."</option>\r\n";
}
?>
                  </select> &nbsp;���У� 
                  <input name="city" type="text" id="city" size="10" value="<?=$row->city;?>"> 
                  &nbsp;</td>
              </tr>
              <tr> 
                <td height="25" align="right">���ҽ��ܣ�</td>
                <td height="25">[������125������]</td>
              </tr>
              <tr> 
                <td height="25" align="right">&nbsp;</td>
                <td height="25"><textarea name="myinfo" cols="40" rows="3"><?=$row->myinfo;?></textarea></td>
              </tr>
              <tr> 
                <td height="25" align="right">����ǩ����</td>
                <td height="25">[����̳��ʹ�ã�������125������] </td>
              </tr>
              <tr> 
                <td height="25" align="right">&nbsp;</td>
                <td height="25"><textarea name="mybb" cols="40" rows="3"><?=$row->mybb;?></textarea></td>
              </tr>
              <tr> 
                <td height="25" colspan="2"> <hr width="80%" size="1" noshade></td>
              </tr>
              <tr> 
                <td height="25" align="right">OICQ���룺</td>
                <td height="25"><input name="oicq" type="text" size="20" value="<?=$row->oicq?>"></td>
              </tr>
              <tr> 
                <td height="25" align="right">��ϵ�绰��</td>
                <td height="25"><input name="tel" type="text" size="20" value="<?=$row->tel?>"> 
                  &nbsp; [��վ��Ա����ϵ�绰һ�ɶ��Ᵽ��]</td>
              </tr>
              <tr> 
                <td height="25" align="right">������ҳ��</td>
                <td height="25"><input name="homepage" type="text" size="25" value="<?=$row->homepage?>"></td>
              </tr>
              <tr> 
                <td height="67" align="right">&nbsp;</td>
                <td height="67"> <input type="submit" name="Submit" value=" ��������  "> 
                  &nbsp;&nbsp; <input type="button" name="Submit22" value=" ���� " onClick="location.href='<?=$ENV_GOBACK_URL?>';"></td>
              </tr>
            </table>
            </td>
        </tr>
      </table></td>
  </tr>
</table>
</form>
</body>
</html>
