<?php 
require_once(dirname(__FILE__)."/config.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�������ͱ任 </title>
<link href="base.css" rel="stylesheet" type="text/css">
</head>
<body background='img/allbg.gif' leftmargin='8' topmargin='8'>
<table width="98%" border="0" cellpadding="3" cellspacing="1" bgcolor="#98CAEF" align="center">
  <form action="member_password_action.php" name="form1" target="stafrm">
    <tr> 
      <td height="20" background='img/tbg.gif'><table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="30%"><strong><a href="co_main.php"><u>��Ա����</u></a> &gt;<A href="member_password.php" target="main"> �������ͱ任</A>��</strong> </td>
          <td align="right">&nbsp;</td>
        </tr>
      </table></td>
    </tr>
    <tr> 
      <td bgcolor="#FFFFFF">
<table width="100%" border="0" cellpadding="2" cellspacing="2">
          <tr bgcolor="#FFFFFF"> 
            <td colspan="4"><img src="img/help.gif" width="16" height="16">�������ͱ任����������;��<br>
              1����dedeԭ����������ʽ����תΪ���ܵ����룻<br>
              2��Ϊ���������ϵͳ�����ݣ������ϵ�����ϵͳ��<br>
              <font color="#FF0000"><strong>ע�����⣺<br>
              </strong>�������ѡ����MD5���ͣ��Ժ��޷�����ת��Ϊ������ʽ��Ψһ�������Ǽ���MD5���볤�ȣ��������Ҫ����phpwind��Discuz��������32λMD5(�����������ϵͳ�ǲ���Ҫת����)��</font></td>
          </tr>
          <tr bgcolor="#EFFAFE"> 
            <td width="18%">�������ͣ�</td>
            <td colspan="3"> <input type="radio" name="newtype" class="np" value="none"<?php  if($cfg_pwdtype=='none') echo ' checked';?>>
              ����(������) 
              <input type="radio" name="newtype" class="np" value="md5"<?php  if($cfg_pwdtype=='md5') echo ' checked';?>>
              MD5���� 
              <input type="radio" name="newtype" class="np" value="md5m16"<?php  if($cfg_pwdtype=='md5m16') echo ' checked';?>>
              MD5�м�16λ
              <input type="radio" name="newtype" class="np" value="dd"<?php  if($cfg_pwdtype=='dd') echo ' checked';?>>
              Dede�㷨
              </td>
          </tr>
          <tr> 
            <td>MD5���ȣ�</td>
            <td width="27%">
            	<input name="newmd5len" type="text" id="newmd5len" value="<?php echo $cfg_md5len?>">
            	
            </td>
            <td width="14%">Dede������Կ��</td>
            <td width="41%"><input name="newsign" type="text" id="newsign" value="<?php echo $cfg_ddsign?>"> 
            </td>
          </tr>
          <tr>
            <td height="29">��ȫȷ���룺</td>
            <td colspan="3"><table width="300"  border="0" cellspacing="0" cellpadding="0">
                <tr> 
                  <td width="90"><input type="text" name="validate" style="width:80;height:20"></td>
                  <td><img src='../include/vdimgck.php' width='50' height='20'></td>
                </tr>
              </table></td>
          </tr>
          <tr> 
            <td height="29">����ѡ�</td>
            <td colspan="3">
			<input name="notcdata" type="checkbox" id="notcdata" value="1" class="np" checked>������ת��(���޸�����)
			 </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr> 
      <td height="31" bgcolor="#F8FBFB" align="center">
	  <input type="submit" name="Submit" value="��ʼת����������" class="nbt"> 
      </td>
    </tr>
  </form>
  <tr bgcolor="#E5F9FF"> 
    <td height="20"> <table width="100%">
        <tr> 
          <td width="74%"><strong>�����</strong></td>
          <td width="26%" align="right"> <script language='javascript'>
            	function ResizeDiv(obj,ty)
            	{
            		if(ty=="+") document.all[obj].style.pixelHeight += 50;
            		else if(document.all[obj].style.pixelHeight>80) document.all[obj].style.pixelHeight = document.all[obj].style.pixelHeight - 50;
            	}
            	</script>
            [<a href='#' onClick="ResizeDiv('mdv','+');">����</a>] [<a href='#' onClick="ResizeDiv('mdv','-');">��С</a>] 
          </td>
        </tr>
      </table></td>
  </tr>
  <tr bgcolor="#FFFFFF"> 
    <td id="mtd"> <div id='mdv' style='width:100%;height:100;'> 
        <iframe name="stafrm" frameborder="0" id="stafrm" width="100%" height="100%"></iframe>
      </div>
      <script language="JavaScript">
	  document.all.mdv.style.pixelHeight = screen.height - 420;
	  </script> </td>
  </tr>
</table>
</body>
</html>
