<?php 
require(dirname(__FILE__)."/config.php");
CheckPurview('member_Edit');
if(!isset($_COOKIE['ENV_GOBACK_URL'])) $ENV_GOBACK_URL = "";
else $ENV_GOBACK_URL="member_main.php";
$ID = ereg_replace("[^0-9]","",$ID);
$dsql = new DedeSql(false);
$row=$dsql->GetOne("select  * from #@__member where ID='$ID'");
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
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#98CAEF">
  <tr>
    <td height="19" background="img/tbg.gif"><a href='<?php echo $ENV_GOBACK_URL?>'><b>��Ա����</b></a>&gt;&gt;�鿴��Ա</td>
</tr>
<tr>
<td height="200" bgcolor="#FFFFFF" valign="top"><table width="98%" border="0" cellspacing="0" cellpadding="0" >
        <tr> 
          <td colspan="2" height="10" ></td>
        </tr>
        <form name="form2" action="member_do.php" method="post" onSubmit="return checkSubmit();">
          <input type="hidden" name="dopost" value="edituser" />
          <input type="hidden" name="ID" value="<?php echo $ID?>" />
          <tr> 
            <td width="17%" height="25" align="right" >�û�����</td>
            <td width="83%" height="25" > 
              <?php echo $row['userid']?>
            </td>
          </tr>
          <tr> 
            <td height="25" align="right" >�ܡ��룺</td>
            <td height="25" > 
              <?php echo $row['pwd']?>
            </td>
          </tr>
          <tr> 
            <td height="25" align="right" >��Ա�ȼ���</td>
            <td height="25" >
			<?php 
			$MemberTypes = "";
  $dsql->SetQuery("Select rank,membername From #@__arcrank where rank>0");
  $dsql->Execute();
  $MemberTypes[0] = "δ��˻�Ա";
  while($nrow = $dsql->GetObject()){
	  $MemberTypes[$nrow->rank] = $nrow->membername;
  }
  $options = "<select name='membertype' style='width:100px'>\r\n";
  foreach($MemberTypes as $k=>$v)
  {
  	if($k!=$row['membertype']) $options .= "<option value='$k'>$v</option>\r\n";
  	else $options .= "<option value='$k' selected>$v</option>\r\n";
  }
  $options .= "</select>\r\n";
			echo $options;
			?>
			</td>
          </tr>
          <tr> 
            <td height="25" align="right" >����ʱ�䣺</td>
            <td height="25">
			<input name="uptime" type="text" id="uptime" value="<?php echo GetDateTimeMk($row['uptime'])?>" style="width:200px">
			�������Ҫ������Ա���������ô�ʱ��Ϊ��ǰʱ�䣩
			</td>
          </tr>
          <tr> 
            <td height="25" align="right" >��Ա������</td>
            <td height="25">
			<input name="exptime" type="text" id="exptime" value="<?php echo $row['exptime']?>" style="width:100px">
			�������Ҫ������Ա����Ա�����������0��
			</td>
          </tr>
          <tr> 
            <td height="25" align="right" >��Ա��ң�</td>
            <td height="25">
			<input name="money" type="text" id="money" value="<?php echo $row['money']?>" style="width:100px">
			</td>
          </tr>
          <tr bgcolor="#F9FDEA"> 
            <td height="25" align="right" >�ռ���Ϣ��</td>
            <td height="25" > 
              <table width="90%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td height="22" style="border-bottom:1px solid #999999">�����£� 
                    ( 
                    <?php echo $row['c1']?>
                    ) ͼ���� ( 
                    <?php echo $row['c2']?>
                    ) ������ ( 
                    <?php echo $row['c3']?>
                    ) </td>
                </tr>
                <tr>
                  <td height="22" style="border-bottom:1px solid #999999">���ռ�չʾ������ 
                    ( 
                    <?php echo $row['spaceshow']?>
                    ) �ĵ��ܵ���� ( 
                    <?php echo $row['pageshow']?>
                    ) </td>
                </tr>
              </table></td>
          </tr>
          <tr> 
            <td height="25" align="right" >ע��ʱ�䣺</td>
            <td height="25" >
              <?php echo GetDateTimeMk($row['jointime'])?>
              ���ɣУ� 
              <?php echo $row['joinip']?>
            </td>
          </tr>
          <tr> 
            <td height="25" align="right" >�����¼ʱ�䣺</td>
            <td height="25" >
              <?php echo GetDateTimeMk($row['logintime'])?>
              ���ɣУ� 
              <?php echo $row['loginip']?>
            </td>
          </tr>
          <tr> 
            <td height="25" align="right" >�������䣺</td>
            <td height="25" ><input name="email" type="text" id="email" value="<?php echo $row['email']?>" style="width:150;height:20" > 
            </td>
          </tr>
          <tr> 
            <td height="25" align="right" >�ǡ��ƣ�</td>
            <td height="25" ><input name="uname" type="text" value="<?php echo $row['uname']?>" id="uname" size="20" style="width:150;height:20" ></td>
          </tr>
          <tr> 
            <td height="25" align="right" >�ԡ���</td>
            <td height="25" > <input type="radio" name="sex" class="np" value="��"<?php if($row['sex']=="��" ) echo" checked" ;?>>
              �� &nbsp; <input type="radio" name="sex" class="np" value="Ů"<?php if($row['sex']=="Ů" ) echo" checked" ;?>>
              Ů </td>
          </tr>
          <tr> 
            <td height="25" align="right" >�Ƽ�����</td>
            <td height="25" ><input name="matt" type="text" id="matt" value="<?php echo $row['matt']?>" size="10"></td>
          </tr>
          <tr> 
            <td height="25" align="right" >���գ�</td>
            <td height="25" ><input name="birthday" type="text" id="birthday" size="20" value="<?php echo $row['birthday']?>" > 
            </td>
          </tr>
          <tr> 
            <td height="25" align="right" >���ͣ�</td>
            <td height="25" > <select name="weight" >
                <option value='<?php echo $row['weight']?>'> 
                <?php echo $row['weight']?>
                </option>
                <option value='ƽ��'>ƽ��</option>
                <option value='����/��ϸ'>����/��ϸ</option>
                <option value='��׳'>��׳</option>
                <option value='����'>����</option>
                <option value='����'>����</option>
              </select> &nbsp;��ߣ� 
              <input name="height" value="<?php echo $row['height']?>" type="text" id="height" size="5" >
              ����</td>
          </tr>
          <tr> 
            <td height="25" align="right" >ְҵ��</td>
            <td height="25" > <input type="radio" class="np" name="job" value="ѧ��" <?php if($row['job']=="ѧ��" ) echo" checked" ;?>>
              ѧ�� 
              <input type="radio" class="np" name="job" value="ְԱ" <?php if($row['job']=="ְԱ" ) echo" checked" ;?>>
              ְԱ 
              <input type="radio" class="np" name="job" value="����" <?php if($row['job']=="����" ) echo" checked" ;?>>
              ���� 
              <input type="radio" class="np" name="job" value="ʧҵ��" <?php if($row['job']=="ʧҵ��" ) echo" checked" ;?>>
              ʧҵ�� </td>
          </tr>
          <tr> 
            <td height="25" align="right" >����������</td>
            <td height="25" > <select name="province" size="1" id="province" width="4" onchange="javascript:selNext(this.document.form2.city,this.value)" style="width:85">
                <option value="0">--����--</option>
                <?php 
				 $dsql->SetQuery("Select * From #@__area where rid=0");
				 $dsql->Execute();
				 while($rowa = $dsql->GetArray()){
				    if($row['province']==$rowa['eid'])
					{ echo "<option value='".$rowa['eid']."' selected>".$rowa['name']."</option>\r\n"; }
					else
					{ echo "<option value='".$rowa['eid']."'>".$rowa['name']."</option>\r\n"; }
				 }
				 ?>
              </select> &nbsp;���У� 
              <select id="city" name="city" width="4" style="width:85" >
                <option value="0">--����--</option>
                <?php 
				 if(!empty($row['province'])){
				 $dsql->SetQuery("Select * From #@__area where rid=".$row['province']);
				 $dsql->Execute();
				 while($rowa = $dsql->GetArray()){
				    if($row['city']==$rowa['eid'])
					{ echo "<option value='".$rowa['eid']."' selected>".$rowa['name']."</option>\r\n"; }
					else
					{ echo "<option value='".$rowa['eid']."'>".$rowa['name']."</option>\r\n"; }
				 }}
				 ?>
              </select> </td>
          </tr>
          <tr align="center"> 
            <td height="25" colspan="2" > <hr width="80%" size="1" noshade> </td>
          </tr>
          <tr> 
            <td height="25" align="right" >OICQ���룺</td>
            <td height="25" ><input name="oicq" type="text" value="<?php echo $row['oicq']?>" id="oicq" size="20" style="width:150;height:20" > 
            </td>
          </tr>
          <tr> 
            <td height="25" align="right" >��ϵ�绰��</td>
            <td height="25" ><input name="tel" type="text" value="<?php echo $row['tel']?>" id="tel" size="20" style="width:150;height:20" > 
              &nbsp;[��վ��Ա����ϵ�绰һ�ɶ��Ᵽ��]</td>
          </tr>
          <tr> 
            <td height="25" align="right" >������ҳ��</td>
            <td height="25" ><input name="homepage" value="<?php echo $row['homepage']?>" type="text" id="homepage" size="25" ></td>
          </tr>
          <tr> 
            <td height="25" align="right" >��ϵ��ַ��</td>
            <td height="25" > <input name="address" value="<?php echo $row['address']?>" type="text" id="address" size="25" > 
            </td>
          </tr>
          <tr> 
            <td height="70" align="right" >���ҽ��ܣ�</td>
            <td height="70" > <textarea name="myinfo" cols="40" rows="3" id="textarea3" ><?php echo $row['myinfo']?></textarea></td>
          </tr>
          <tr> 
            <td height="71" align="right" >����ǩ����</td>
            <td height="71" > <textarea name="mybb" cols="40" rows="3" id="textarea4" ><?php echo $row['mybb']?></textarea></td>
          </tr>
          <tr align="center"> 
            <td height="25" colspan="2" > <hr width="80%" size="1" noshade> </td>
          </tr>
          <tr> 
            <td height="25" align="right" >�ռ����ƣ� </td>
            <td height="25" ><input name="spacename" type="text" id="spacename" size="35" value="<?php echo $row['spacename']?>"></td>
          </tr>
          <tr> 
            <td height="130" align="right" >�ռ乫�棺</td>
            <td height="130" ><textarea name="news" cols="50" rows="8" id="textarea7" ><?php echo $row['news']?></textarea></td>
          </tr>
          <tr> 
            <td height="130" align="right" >��ϸ���ϣ�</td>
            <td height="130" ><textarea name="fullinfo" cols="50" rows="8" id="textarea8" ><?php echo $row['fullinfo']?></textarea> 
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
<?php 
$dsql->Close();
?>
</body>
</html>