<?
require(dirname(__FILE__)."/config.php");
if(!isset($_COOKIE['ENV_GOBACK_URL'])) $ENV_GOBACK_URL = "";
else $ENV_GOBACK_URL="member_main.php";
$ID = ereg_replace("[^0-9]","",$ID);
$dsql = new DedeSql(false);
$row=$dsql->GetOne("select  * from #@__member where ID='$ID'");
$dsql->Close();
?>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
<title>�鿴��Ա</title>
<link href='base.css' rel='stylesheet' type='text/css'>
<script language='javascript'src='area.js'></script>
<script>
function checkSubmit()
{
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
}
</script>
</head>
<body background='img/allbg.gif' leftmargin='8' topmargin='8'>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#666666">
  <tr>
    <td height="19" background="img/tbg.gif"><a href='<?=$ENV_GOBACK_URL?>'><b>��Ա����</b></a>&gt;&gt;�鿴��Ա</td>
</tr>
<tr>
<td height="200" bgcolor="#FFFFFF" valign="top"><table width="98%" border="0" cellspacing="0" cellpadding="0" >
        <tr> 
          <td colspan="2" height="10" ></td>
        </tr>
        <form name="form2" action="member_do.php" method="post" onSubmit="return checkSubmit();">
          <input type="hidden" name="dopost" value="edituser" />
          <input type="hidden" name="ID" value="<?=$ID?>" />
          <input type="hidden" name="oldprovince" value="<?=$row['province']?>" />
          <input type="hidden" name="oldcity" value="<?=$row['city']?>" />
          <tr> 
            <td width="17%" height="25" align="right" >�û�����</td>
            <td width="83%" height="25" > 
              <?=$row['userid']?>
            </td>
          </tr>
          <tr> 
            <td height="25" align="right" >�ܡ��룺</td>
            <td height="25" >
              <?=$row['pwd']?>
            </td>
          </tr>
          <tr> 
            <td height="25" align="right" >ע��</td>
            <td height="25" >ʱ�䣺 
              <?=GetDateTimeMk($row['jointime'])?>
              ���ɣУ� 
              <?=$row['joinip']?>
            </td>
          </tr>
          <tr> 
            <td height="25" align="right" >�����¼</td>
            <td height="25" >ʱ�䣺 
              <?=GetDateTimeMk($row['logintime'])?>
              ���ɣУ� 
              <?=$row['loginip']?>
            </td>
          </tr>
          <tr> 
            <td height="25" align="right" >�������䣺</td>
            <td height="25" ><input name="email" type="text" id="email" value="<?=$row['email']?>" style="width:150;height:20" > 
            </td>
          </tr>
          <tr> 
            <td height="25" align="right" >�ǡ��ƣ�</td>
            <td height="25" ><input name="uname" type="text" value="<?=$row['uname']?>" id="uname" size="20" style="width:150;height:20" ></td>
          </tr>
          <tr> 
            <td height="25" align="right" >�ԡ���</td>
            <td height="25" > <input type="radio" name="sex" value="��"<?if($row['sex']=="��" ) echo" checked" ;?>>
              ��&nbsp; <input type="radio" name="sex" value="Ů"<?if($row['sex']=="Ů" ) echo" checked" ;?>>
              Ů</td>
          </tr>
          <tr> 
            <td height="25" colspan="2" ><hr width="80%" size="1" noshade> </td>
          </tr>
          <tr> 
            <td height="25" align="right" >���գ�</td>
            <td height="25" ><input name="birthday" type="text" id="birthday" size="20" value="<?=$row['birthday']?>" > 
            </td>
          </tr>
          <tr> 
            <td height="25" align="right" >���ͣ�</td>
            <td height="25" > <select name="weight" >
                <option value='<?=$row['weight']?>'> 
                <?=$row['weight']?>
                </option>
                <option value='ƽ��'>ƽ��</option>
                <option value='����/��ϸ'>����/��ϸ</option>
                <option value='��׳'>��׳</option>
                <option value='����'>����</option>
                <option value='����'>����</option>
              </select> &nbsp;��ߣ� 
              <input name="height" value="<?=$row['height']?>" type="text" id="height" size="5" >
              ����</td>
          </tr>
          <tr> 
            <td height="25" align="right" >ְҵ��</td>
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
            <td height="25" align="right" >���ڵ�����</td>
            <td height="25" >&nbsp;</td>
          </tr>
          <tr> 
            <td height="25" align="right" >���ģ�</td>
            <td height="25" ><select name="province" size="1" id="province" width="4" onchange="javascript:selNext(this.document.form2.city,this.value)" style="width:85">
                <option value="0" selected>--����--</option>
              </select> <script language='javascript'>
selTop(this.document.form2.province);
</script> &nbsp;���У� 
              <select id="city" name="city" width="4" style="width:85" >
                <option value="0" selected>--����--</option>
              </select> </td>
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
            <td height="67" > <input type="submit" name="Submit" value="ȷ���޸�" > 
              &nbsp;&nbsp; <input type="reset" name="Submit22" value="����" > </td>
          </tr>
        </form>
      </table> </td>
</tr>
</table>
<?
$dsql->Close();
?>
</body>
</html>