<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
<title>�����뻹ԭ</title>
<link href='base.css' rel='stylesheet' type='text/css'>
<script language="javascript">
function selAll()
{
	for(i=0;i<document.formbak2.files.length;i++)
	{
		document.formbak2.files[i].checked=true;
	}
}
function selNone()
{
	for(i=0;i<document.formbak2.files.length;i++)
	{
		document.formbak2.files[i].checked=false;
	}
}
function GetSubmit()
{
	for(i=0;i<document.formbak2.files.length;i++)
	{
		if(document.formbak2.files[i].checked)
		{
			document.formbak2.refiles.value+="*"+document.formbak2.files[i].value;
		}
	}
	return true;
}
</script>
</head>
<body background='img/allbg.gif' leftmargin='8' topmargin='8'>
<table width="99%" border="0" cellpadding="3" cellspacing="1" bgcolor="#666666">
  <tr>
    <td height="19" background="img/tbg.gif" bgcolor="#E7E7E7"> &nbsp;<b>���ݱ���</b></td>
</tr>
<tr>
    <td height="215" align="center" bgcolor="#FFFFFF"> 
      <table width="96%" border="0" cellspacing="1" cellpadding="0">
      <form name="form1" action="sys_bakdatnew_ok.php">
        <tr> 
          <td width="25%" bgcolor="#F1F2EC"><strong>�����ض����ݣ�</strong></td>
          <td width="75%" bgcolor="#F1F2EC" align="right"> <input type="submit" name="Submit0" value=" " style="width:0"><input type="submit" name="Submit" value="ȷ������"></td>
        </tr>    
          <tr> 
            <td height="45" align="right">��ѡ��Ҫ���ݵı�</td>
            <td>
            <select name="baktable" id="baktable">
			<option value='dede_art'>dede_art</option>
			<option value='dede_feedback'>dede_feedback</option>
			<option value='dede_member'>dede_member</option>
              </select> </td>
          </tr>
          <tr> 
            <td height="25" align="right">���·����</td>
            <td><?=$bak_dir?></td>
          </tr>
          <tr> 
            <td height="25" align="right">���ݷ�ʽ��</td>
            <td>
            <input type="radio" name="baktype" value="tid" class="np" checked>
            ָ������ID
            <input type="radio" name="baktype" value="fsize" class="np">
            ָ�������ļ���С
            <input type="radio" name="baktype" value="stime" class="np">
            ָ����ʼʱ��
            </td>
          </tr>
          <tr> 
            <td height="25" align="right">ָ��ID��</td>
            <td>
            ��ʼID��
            <input type="input" name="tidstart" value="" style="width:50">
			����ID��
            <input type="input" name="tidend" value="" style="width:50">
            </td>
          </tr>
          <tr> 
            <td height="25" align="right">�����ļ���С��</td>
            <td>
            <input type="input" name="filesize" value="2" style="width:50"> (M)
            </td>
          </tr>
          <tr> 
            <td height="25" align="right">ָ��ʱ�䣺</td>
            <td>
            ��ʼʱ�䣺
            <input type="input" name="timestart" value="<?=strftime("%Y-%m-%d",time())?>" style="width:80">
			����ʱ�䣺
            <input type="input" name="timeend" value="<?=strftime("%Y-%m-%d",time())?>" style="width:80">
            (�� xxxx-xx-xx ��ʽ)
            </td>
          </tr>
        </form>
        <tr align="center"> 
          <td colspan="2" bgcolor="#F1F2EC">���ݱ���˵��</td>
        </tr>
        <tr> 
          <td height="32" colspan="2">�������ݰ�ÿ���������ɶ�Ӧ��txt�ļ���������SQL��Insert��䣬ǰ�����~��������ʶ�������ڡ�ִ��MySQL����Ĳ�����������ЩSQL��䣬���Ƚ�~Insert 
            �滻Ϊ�� Insert�������Ҫ����վ����ƽ̨ת�ƣ���Ҫ���������ǣ�[1]�������ݣ�[2]���ļ��ϴ�������վ�ռ䣬��������setup.php����ԭ���������ٰ�װһ�飬Ȼ��ԭ���ݼ��ɡ�</td>
        </tr>
        <tr> 
          <td bgcolor="#F1F2EC" colspan="2">&nbsp;</td>
        </tr>
      </table></td>
</tr>
</table>
</body>
</html>