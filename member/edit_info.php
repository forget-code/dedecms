<?
require_once(dirname(__FILE__)."/config.php");
CheckRank(0,0);
$dsql=new DedeSql();
$row=$dsql->GetOne("select  * from #@__member where ID='".$cfg_ml->M_ID."'");
$dsql->Close();
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=gb2312">
<title>���Ļ�Ա����</title>
<link href="base.css" rel="stylesheet" type="text/css">
<script language='javascript'src='area.js'></script>
<script>
function checkSubmit()
{
if(document.form2.userpwdok.value!=document.form2.userpwd.value)
{
  document.form2.userpwdok.focus();
  alert("�������벻һ�£�");
  return false;
}
if(document.form2.email.value=="")
{
  document.form2.email.focus();
  alert("Email����Ϊ�գ�");
  return false;
}
if(document.form2.uname.value=="")
{
  document.form2.uname.focus();
  alert("�û��ǳƲ���Ϊ�գ�");
  return false;
}
if(document.form2.vdcode.value=="")
{
  document.form2.vdcode.focus();
  alert("��֤�벻��Ϊ�գ�");
  return false;
}
}
</script>	
</head>
<body leftmargin="0" topmargin="0">
<table  width="760"  border="0"  align="center"  cellpadding="0"  cellspacing="0" >
<tr bgcolor="#FFFFFF" >
<td  height="50" colspan="3" ><img src="img/member.gif"  width="320"  height="46" ></td>
</tr>
<tr>
<td width="17" rowspan="2" bordercolor="#FFFFFF" bgcolor="#808DB5" >&nbsp;</td>
<td bordercolor="#FFFFFF" bgcolor="#808DB5" width="168" >&nbsp;</td>
<td width="575" align="right" bordercolor="#FFFFFF" bgcolor="#FFFFFF" >
<?=$cfg_member_menu?>
</td>
</tr>
<tr>
<td colspan="2" valign="top" ><table width="100%" height="300" border="0" cellpadding="1" cellspacing="1" bgcolor="#000000" >
<tr>
<td height="194" align="center" valign="top" bgcolor="#FFFFFF" >
<table width="98%" border="0" cellspacing="0" cellpadding="0" >
<tr>
<td colspan="2" height="10" ></td>
</tr>
<form name="form2" action="index_do.php" method="post" onSubmit="return checkSubmit();">
<input type="hidden" name="fmdo" value="user" />
<input type="hidden" name="dopost" value="editUser" />
<input type="hidden" name="oldprovince" value="<?=$row['province']?>" />
<input type="hidden" name="oldcity" value="<?=$row['city']?>" />
<tr valign="bottom" >
<td height="21" background="img/tbg.gif" colspan="2" ><strong>��&nbsp;���ĸ������ϣ�</strong></td>
</tr>
<tr>
<td width="17%" height="25" align="right" >��½�û�����</td>
<td width="83%" height="25" >
<?=$row['userid']?>
</td>
</tr>
<tr>
<td height="25" align="right" >ԭ��¼���룺</td>
<td height="25" ><input type="password" name="oldpwd" style="width:150;height:20" >
*������ȷ����������κ����ϣ�</td>
</tr>
<tr>
<td height="25" align="right" >�����룺</td>
<td height="25" ><input name="userpwd" type="password" id="userpwd" size="18" style="width:150;height:20" >
&nbsp;ȷ�����룺
<input name="userpwdok" type="password" id="userpwdok" value="" size="18" style="width:150;height:20" >
&nbsp;�������������գ�</td>
</tr>
<tr>
<td height="25" align="right" >���Email��</td>
<td height="25" ><input name="email" type="text" id="email" value="<?=$row['email']?>" style="width:150;height:20" >
&nbsp;*</td>
</tr>
<tr>
<td height="25" align="right" >�����ǳƣ�</td>
<td height="25" ><input name="uname" type="text" value="<?=$row['uname']?>" id="uname" size="20" style="width:150;height:20" >
&nbsp;*�Ա�
<input type="radio" name="sex" value="��"<?if($row['sex']=="��" ) echo" checked" ;?>>
��&nbsp;<input type="radio" name="sex" value="Ů"<?if($row['sex']=="Ů" ) echo" checked" ;?>>
Ů</td>
</tr>
<tr>
<td height="25" align="right" >��֤�룺</td>
<td height="25" ><table width="200" border="0" cellspacing="0" cellpadding="0" >
<tr>
<td width="84" ><input name="vdcode" type="text" id="vdcode" size="10" ></td>
<td width="116" ><img src='../include/validateimg.php'width='50'height='20'></td>
</tr>
</table></td>
</tr>
<tr>
<td height="25" colspan="2" ><hr width="80%" size="1" noshade>
</td>
</tr>
<tr>
<td height="25" align="right" >������գ�</td>
<td height="25" ><input name="birthday" type="text" id="birthday" size="20" value="<?=$row['birthday']?>" >
</td>
</tr>
<tr>
<td height="25" align="right" >������ͣ�</td>
<td height="25" >
<select name="weight" >
<option value='<?=$row['weight']?>'><?=$row['weight']?></option>
<option value='ƽ��'>ƽ��</option>
<option value='����/��ϸ'>����/��ϸ</option>
<option value='��׳'>��׳</option>
<option value='����'>����</option>
<option value='����'>����</option>
</select>&nbsp;��ߣ�
<input name="height" value="<?=$row['height']?>" type="text" id="height" size="5" >
����</td>
</tr>
<tr>
<td height="25" align="right" >���ְҵ��</td>
<td height="25" ><input type="radio" name="job" value="ѧ��" <?if($row['job']=="ѧ��" ) echo" checked" ;?>>
ѧ��
<input type="radio" name="job" value="ְԱ" <?if($row['job']=="ְԱ" ) echo" checked" ;?>>
ְԱ
<input type="radio" name="job" value="����" <?if($row['job']=="����" ) echo" checked" ;?>>
����
<input type="radio" name="job" value="ʧҵ��" <?if($row['job']=="ʧҵ��" ) echo" checked" ;?>>
ʧҵ��</td>
</tr>
<tr>
<td height="25" align="right" >�����ڵĵ�����</td>
<td height="25" >
<select name="province" size="1" id="province" width="4" onchange="javascript:selNext(this.document.form2.city,this.value)" style="width:85">
<option value="0" selected>--����--</option>
</select>
<script language='javascript'>
selTop(this.document.form2.province);
</script>&nbsp;���У�
<select id="city" name="city" width="4" style="width:85" >
<option value="0" selected>--����--</option>
</select>
</td>
</tr>
<tr>
<td height="25" align="right" >���ҽ��ܣ�</td>
<td height="25" >[������125������]&nbsp;</td>
</tr>
<tr>
<td height="25" align="right" >&nbsp;</td>
<td height="25" ><textarea name="myinfo" cols="40" rows="3" id="myinfo" ><?=$row['myinfo']?></textarea></td>
</tr>
<tr>
<td height="25" align="right" >����ǩ����</td>
<td height="25" >[����̳��ʹ�ã�������125������]</td>
</tr>
<tr>
<td height="25" align="right" >&nbsp;</td>
<td height="25" ><textarea name="mybb" cols="40" rows="3" id="mybb" ><?=$row['mybb']?></textarea></td>
</tr>
<tr>
<td height="25" colspan="2" ><hr width="80%" size="1" noshade></td>
</tr>
<tr>
<td height="25" align="right" >OICQ���룺</td>
<td height="25" ><input name="oicq" type="text" value="<?=$row['oicq']?>" id="oicq" size="20" style="width:150;height:20" >
</td>
</tr>
<tr>
<td height="25" align="right" >��ϵ�绰��</td>
<td height="25" ><input name="tel" type="text" value="<?=$row['tel']?>" id="tel" size="20" style="width:150;height:20" >
&nbsp;[��վ��Ա����ϵ�绰һ�ɶ��Ᵽ��]</td>
</tr>
<tr>
<td height="25" align="right" >������ҳ��</td>
<td height="25" ><input name="homepage" value="<?=$row['homepage']?>" type="text" id="homepage" size="25" >
</td>
</tr>
<tr>
<td height="67" align="right" >&nbsp;</td>
<td height="67" >
<input type="submit" name="Submit" value="ȷ���޸�" >
&nbsp;&nbsp;
<input type="reset" name="Submit22" value="����" >
</td>
</tr>
</form>
</table></td>
</tr>
</table></td>
</tr>
</table>
<p align='center'>
<?=$cfg_powerby?>
</p>
</body>
</html>
