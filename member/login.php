<?
$page="login";
require("config.php");
$conn = connectMySql();
if(empty($email)) $email="";
if(empty($msg)) $msg="";
$email = str_replace(" ","",$email);
if($email!="")
{
	$rs = mysql_query("Select userid,pwd From dede_member where email='$email' limit 0,1",$conn);
	$row = mysql_fetch_object($rs,$conn);
	$userid=$row->userid;
	$pwd=$row->pwd;
	if($userid=="") $msg = "<br><font color='red'>���Email���������ݿ��У������������<a href='/member/reg.php'>[<u>ע���»�Ա</u>]</a></font><br>";
	else 
	{
		$msg = "����û����������ѷ��͵���������У�����գ�";
		$mailtitle = "���� $webname ���û���������";
		$mailbody = "\r\n�û�����'$userid'  ���룺'$pwd'\r\n\r\nDede��֯�λ�֮��!";
	    if(eregi("(.*)@(.*)\.(.*)",$email))
	     {
	       $headers = "From: $admin_email\r\nReply-To: $admin_email";
           @mail($email, $mailtitle, $mailbody, $headers);
	     }
	}
	
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>��Ա��¼</title>
<link href="../base.css" rel="stylesheet" type="text/css">	
</head>
<body leftmargin="0" topmargin="0">
<table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr bgcolor="#FFFFFF"> 
    <td height="50" colspan="4"><img src="img/member.gif" width="320" height="46"></td>
  </tr>
  <tr> 
    <td bordercolor="#FFFFFF" bgcolor="#808DB5" width="30">&nbsp;</td>
    <td bordercolor="#FFFFFF" bgcolor="#808DB5" width="220">&nbsp;</td>
    <td bordercolor="#FFFFFF" bgcolor="#808DB5" width="250">&nbsp;</td>
    <td width="200" align="right"><a href='/'><u>������ҳ</u></a></td>
  </tr>
  <tr> 
    <td width="30" bgcolor="#808DB5">&nbsp;</td>
    <td colspan="3" rowspan="2" valign="top">
    <table width="100%" height="200" border="0" cellpadding="1" cellspacing="1" bgcolor="#000000">
        <tr> 
          <td height="100" align="center" valign="top" bgcolor="#FFFFFF"><table width="98%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td height="6"></td>
              </tr>
              <tr> 
                <td><font color="#333333"> <strong>��Ա��¼��</strong></font></td>
              </tr>
			  <form name='form1' method='POST' action='loginok.php'>
              <tr> 
                <td height="85"> 
                  <table width='100%' border='0' cellspacing='0' cellpadding='0'>   
		              <tr>
                        <td width='51%' height="35">�û����� 
                          <input name='username' type='text' size='12' style='height:18'> &nbsp;���룺 
                        <input name='password' type='password' size='12' style='height:18'> </td>
                      <td width='49%'><input name='imageField2' type='image' src='img/log.gif' width='48' height='18' border='0' class='input_img'>
                          ����<a href='reg.php'>[<u>ע���»�Ա</u>]</a>����<a href='/'>[<u>������ҳ</u>]</a> 
                        </td>
                    </tr>
		          </table>
				  <hr size="1">
				  </td>
              </tr>
			  </form>
			  <form name='form2'>
              <tr> 
                <td height="57">���������ҵ����룬���������Email�� 
                  <input name="email" type="text" id="email">
                  &nbsp; 
                  <input type="submit" name="Submit" value="ȡ��">
                  <br>
                  <?=$msg?>
                  </td>
              </tr>
              </form>
            </table> </td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td bgcolor="#808DB5">&nbsp;</td>
  </tr>
</table>
<p align='center'><a href='http://www.dedecms.com'target='_blank'>Power by DedeCms ֯�����ݹ���ϵͳ</a></p>
</body></html>
