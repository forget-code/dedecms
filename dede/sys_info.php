<?
require("config.php");
?>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
<title>�հ״���</title>
<link href='base.css' rel='stylesheet' type='text/css'>
</head>
<body background='img/allbg.gif' leftmargin='8' topmargin='8'>
<table width="98%" border="0" cellpadding="2" cellspacing="1" bgcolor="#666666" align="center">
  <tr>
    <td height="23" background="img/tbg.gif"> &nbsp;<b>��ӭʹ��Dede���ݹ���ϵͳ2.0��ϵͳ��װ����</b></td>
</tr>
<tr>
    <td height="320" align="center" valign="top"  bgcolor="#FFFFFF"><table width="98%"  border="0" cellspacing="0" cellpadding="4">
      <tr>
        <td height="30" colspan="2">����������ϵͳ��װ���޷��������У���鿴ϵͳ�����Ƿ���ȷ���������ȷ������config_base.php���ֶ����ģ��������Ȼ�޷�����ʹ�ñ�ϵͳ����ѯʱ�뽫��Щ�������͸����ǣ��Ա�����������ԭ��</td>
        </tr>
      <tr bgcolor="#F8F7F5">
        <td height="24">��վ��·��($base_dir)��</td>
        <td><?=$base_dir?></td>
      </tr>
      <tr>
        <td height="24">��վ��ַ($base_url)��</td>
        <td><?=$base_url?></td>
      </tr>
      <tr bgcolor="#F8F7F5">
        <td width="41%" height="24">��վ����($webname)��</td>
        <td width="59%"><?=$webname?></td>
      </tr>
      <tr>
        <td height="24">���´�Ÿ�Ŀ¼($art_dir)��</td>
        <td><?=$art_dir?></td>
      </tr>
      <tr>
        <td height="24" colspan="2">�հױ�ʾΪ��Ŀ¼�����б�ʾĿ¼�Ĳ��������������ܴ���/����</td>
        </tr>
      <tr bgcolor="#F8F7F5">
        <td height="24">�����Ÿ�Ŀ¼($art_php_dir)��</td>
        <td width="59%"><?=$art_php_dir?></td>
      </tr>
      <tr>
        <td height="24">ͼƬ�������Ŀ¼($imgview_dir)��</td>
        <td width="59%">          <?=$imgview_dir?></td>
      </tr>
      <tr bgcolor="#F8F7F5">
        <td height="24">�ϴ��Ĵ�ͼƬ��·��($img_dir)��</td>
        <td width="59%"><?=$img_dir?></td>
      </tr>
      <tr>
        <td height="24">����ͼ��ŵ�·��($ddimg_dir)��</td>
        <td width="59%"><?=$ddimg_dir?></td>
      </tr>
      <tr bgcolor="#F8F7F5">
        <td height="24">�ϴ������Ŀ¼($soft_dir)��</td>
        <td width="59%"><?=$soft_dir?></td>
      </tr>
      <tr>
        <td height="24">ģ��Ĵ��Ŀ¼($mod_dir)��</td>
        <td width="59%"><?=$mod_dir?></td>
      </tr>
      <tr bgcolor="#F8F7F5">
        <td height="24">���ݱ���Ŀ¼($bak_dir)��</td>
        <td width="59%"><?=$bak_dir?></td>
      </tr>
      <tr>
        <td height="24">�½�Ŀ¼��Ȩ��($dir_purview)��</td>
        <td><?="0".decoct($dir_purview)?></td>
      </tr>
	  <tr bgcolor="#F8F7F5">
        <td height="24">����Ա��Email($admin_email)��</td>
        <td width="59%"><?=$admin_email?></td>
      </tr>
      <tr>
        <td height="24">�����ļ�����չ��($art_shortname)��</td>
        <td width="59%"><?=$art_shortname?></td>
      </tr>
      <tr bgcolor="#F8F7F5">
        <td height="24">��Ƿ��</td>
        <td width="59%"><?=$tag_start_char."dede:tagname/".$tag_end_char?>&nbsp;</td>
      </tr>
      <tr>
        <td height="24">���ݷ�������</td>
        <td><?=$dbhost?></td>
      </tr>
	  <tr bgcolor="#F8F7F5">
        <td height="24">���ݿ⣺</td>
        <td width="59%"><?=$dbname?></td>
      </tr>
      <tr>
        <td height="24">���ݿ��û�����</td>
        <td width="59%"><?=$dbusername?></td>
      </tr>
      <tr bgcolor="#F8F7F5">
        <td height="24" bgcolor="#F8F7F5">���ݿ����룺</td>
        <td width="59%">******</td>
      </tr>
      <tr>
        <td height="24">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr bgcolor="#F8F7F5">
        <td height="24">���±���λ��($art_nametag)��</td>
        <td><?=$art_nametag?></td>
      </tr>
      <tr>
        <td height="24" colspan="2">//[1] listdir ��ʾ����Ŀ��Ŀ¼���� ID.
          <?=$art_shortname?> 
          ����ʽ�����ļ�<br>
          //[2] maketime ��ʾ�� $artdir/year/monthday/ID.
          <?=$art_shortname?> 
          �������ļ�</td>
        </tr>
      <tr bgcolor="#F8F7F5">
        <td height="24">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="24">&nbsp;</td>
        <td width="59%">&nbsp;</td>
      </tr>
    </table></td>
</tr>
</table>
<center>
<a href="http://www.dedecms.com" target="_blank">Power by PHP+MySQL ֯��֮�� 2004-2006 �ٷ���վ��www.DedeCMS.com</a>
<br>
�����������κ��˲��ðѱ�ϵͳ���ж��ο�������Ϊ��ҵ������ۣ�<br>
���Ǳ����Զ��ο���������Ϊ��Դ��Ŀ�����İ汾��������ʽ��ʹ��Ȩ����
</center>
</body>
</html>