<?
require("config.php");
$conn = connectMySql();
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>��Ա���ϸ���</title>
<link href="../base.css" rel="stylesheet" type="text/css">
<script>
function checkSubmit()
{
if(document.form2.email.value=="")
{
 document.form2.email.focus();
 alert("Email ����Ϊ�գ�");
 return false;
}
if(document.form2.uname.value=="")
{
 document.form2.uname.focus();
 alert("�û��ǳƲ���Ϊ�գ�");
 return false;
}
}
</script>	
</head>
<body leftmargin="0" topmargin="0">
<?
$result = mysql_query("Select * From dede_member where ID=".$_COOKIE["cookie_user"],$conn);
$row = mysql_fetch_object($result);
?>
<table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr bgcolor="#FFFFFF"> 
    <td height="30" colspan="4"><img src="img/member.gif" width="320" height="46"></td>
  </tr>
  <tr> 
    <td bordercolor="#FFFFFF" bgcolor="#808DB5" width="30">&nbsp;</td>
    <td bordercolor="#FFFFFF" bgcolor="#808DB5" width="220">&nbsp;</td>
    <td bordercolor="#FFFFFF" bgcolor="#808DB5" width="250">&nbsp;</td>
    <td width="200" align="right"><a href="index.php"><u>��������</u></a> <a href="/"><u>��վ��ҳ</u></a> 
      <a href="exit.php?job=all"><u>�˳���¼</u></a></td>
  </tr>
  <tr> 
    <td width="30" bgcolor="#808DB5">&nbsp;</td>
    <td colspan="3" rowspan="2" valign="top"> <table width="100%" height="300" border="0" cellpadding="1" cellspacing="1" bgcolor="#000000">
        <form action="user_modok.php" name="form2" method="POST" onSubmit="return checkSubmit();">
          <tr> 
            <td height="194" align="center" bgcolor="#FFFFFF"> <table width="90%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
                  <td height="25" colspan="2"><table width="60%" border="0" cellspacing="1" cellpadding="1">
                      <tr> 
                        <td bgcolor="#CCCCCC"><strong>&nbsp;��ȫѡ��</strong> <input name="ismodpwd" type="radio" value="no" checked>
                          �������� 
                          <input name="ismodpwd" type="radio" value="yes">
                          ���ĸ�����</td>
                      </tr>
                    </table></td>
                </tr>
                <tr> 
                  <td width="18%" height="25" align="right">�����룺</td>
                  <td width="82%"><input name="oldpwd" type="oldpwd" id="password" size="15"> 
                    &nbsp;*</td>
                </tr>
                <tr> 
                  <td height="25" align="right">�����룺</td>
                  <td><input name="newpwd" type="password" id="newpwd" size="15"> 
                    &nbsp;*</td>
                </tr>
                <tr> 
                  <td height="25" align="right">ȷ�������룺</td>
                  <td><input name="newpwd2" type="password" id="newpwd2" size="15"> 
                    &nbsp;* &nbsp; <input type="submit" name="Submit" value=" ȷ������ "></td>
                </tr>
                <tr> 
                  <td height="25" colspan="2"><table width="100%" border="0" cellspacing="2" cellpadding="0">
                      <tr> 
                        <td height="25" colspan="2"><table width="60%" border="0" cellspacing="0" cellpadding="0">
                            <tr> 
                              <td bgcolor="#CCCCCC"><strong>&nbsp;���ϸ���</strong></td>
                            </tr>
                          </table></td>
                      </tr>
                      <tr> 
                        <td width="17%" height="25" align="right">���Email��</td>
                        <td width="83%" height="25"><input name="email" type="text" id="email" value="<?=$row->email?>">
                          *</td>
                      </tr>
                      <tr> 
                        <td height="25" align="right">��������ǳƣ�</td>
                        <td height="25"><input name="uname" type="text" id="uname" size="20" value="<?=$row->uname?>">
                          *&nbsp; �Ա� 
                          <input type="radio" name="sex" value="1" <?if($row->sex==1) echo "checked"?>>
                          �� &nbsp; <input type="radio" name="sex" value="0" <?if($row->sex==0) echo "checked"?>>
                          Ů </td>
                      </tr>
                      <tr> 
                        <td height="25" colspan="2"> <hr width="80%" size="1" noshade> 
                        </td>
                      </tr>
                      <tr> 
                        <td height="25" align="right">������䣺</td>
                        <td height="25"><input name="age" type="text" id="age" size="3" value="<?=$row->age?>"> 
                          &nbsp;&nbsp;���գ� 
                          <input name="birthday" type="text" id="birthday" size="15" value="<?=$row->birthday?>"> 
                          &nbsp;[&quot;��-��-��&quot;��&quot;��-��&quot;��&quot;X��X��&quot;]</td>
                      </tr>
                      <tr> 
                        <td height="25" align="right">������ͣ�</td>
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
                        <td height="25" align="right">���ְҵ��</td>
                        <td height="25"><input type="radio" name="job" value="ѧ��"<?if($row->job=="ѧ��") echo " checked"?>>
                          ѧ��&nbsp; <input name="job" type="radio" value="ְԱ"<?if($row->job=="ְԱ") echo " checked"?>>
                          ְԱ 
                          <input type="radio" name="job" value="����"<?if($row->job=="����") echo " checked"?>>
                          ���� 
                          <input type="radio" name="job" value="ʧҵ��"<?if($row->job=="ʧҵ��") echo " checked"?>>
                          ʧҵ��</td>
                      </tr>
                      <tr> 
                        <td height="25" align="right">�����ڵĵ�����</td>
                        <td height="25"> <select name="aera" id="aera">
                            <?
$ds=file("aera.txt");
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
                        <td height="67"> <input type="submit" name="Submit" value=" ȷ������ "> 
                          &nbsp;&nbsp; <input type="reset" name="Submit22" value=" �� �� "></td>
                      </tr>
                    </table></td>
                </tr>
              </table></td>
          </tr>
        </form>
      </table></td>
  </tr>
  <tr> 
    <td bgcolor="#808DB5">&nbsp;</td>
  </tr>
</table>
<br>
</body>
</html>
