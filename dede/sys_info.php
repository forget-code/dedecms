<?
require_once(dirname(__FILE__)."/config.php");
?>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
<title>ϵͳ���ò���</title>
<link href='base.css' rel='stylesheet' type='text/css'>
</head>
<body background='img/allbg.gif' leftmargin='8' topmargin='8'>
<table width="98%" border="0" cellpadding="2" cellspacing="1" bgcolor="#666666" align="center">
  <tr>
    <td height="23" background="img/tbg.gif"> &nbsp;<b>DedeCmsϵͳ��װ��Ϣ��</b></td>
</tr>
<tr>
    <td height="320" align="center" valign="top"  bgcolor="#FFFFFF"><table width="98%"  border="0" cellspacing="0" cellpadding="4">
        <tr> 
          <td height="30" colspan="2">����������ϵͳ��װ���޷��������У���鿴ϵͳ�����Ƿ���ȷ���������ȷ������config_base.php���ֶ����ģ��������Ȼ�޷�����ʹ�ñ�ϵͳ����ѯʱ�뽫��Щ�������͸����ǣ��Ա�����������ԭ��</td>
        </tr>
        <tr bgcolor="#F8F7F5"> 
          <td height="24">��վ��·��($cfg_basedir)��</td>
          <td> 
            <?=$cfg_basedir?>
          </td>
        </tr>
        <tr> 
          <td height="24">��վ��ַ($cfg_basehost)��</td>
          <td> 
            <?=$cfg_basehost?>
          </td>
        </tr>
        <tr bgcolor="#F8F7F5"> 
          <td width="41%" height="24">��վ����($cfg_webname)��</td>
          <td width="59%"> 
            <?=$cfg_webname?>
          </td>
        </tr>
        <tr> 
          <td height="24">���´�Ÿ�Ŀ¼($cfg_arcdir)��</td>
          <td> 
            <?=$cfg_arcdir?>
          </td>
        </tr>
        <tr> 
          <td height="24" colspan="2">�հױ�ʾΪ��Ŀ¼�����б�ʾĿ¼�Ĳ��������������ܴ���/����</td>
        </tr>
        <tr bgcolor="#F8F7F5"> 
          <td height="24">�����Ÿ�Ŀ¼($cfg_plus_dir)��</td>
          <td width="59%"> 
            <?=$cfg_plus_dir?>
          </td>
        </tr>
        <tr> 
          <td height="24">ͼƬ�������Ŀ¼($cfg_medias_dir)��</td>
          <td width="59%"> 
            <?=$cfg_medias_dir?>
          </td>
        </tr>
        <tr bgcolor="#F8F7F5"> 
          <td height="24">�ϴ��Ĵ�ͼƬ��·��($cfg_image_dir)��</td>
          <td width="59%"> 
            <?=$cfg_image_dir?>
          </td>
        </tr>
        <tr> 
          <td height="24">����ͼ��ŵ�·��($ddcfg_image_dir)��</td>
          <td width="59%"> 
            <?=$ddcfg_image_dir?>
          </td>
        </tr>
        <tr bgcolor="#F8F7F5"> 
          <td height="24">�ϴ������Ŀ¼($cfg_soft_dir)��</td>
          <td width="59%"> 
            <?=$cfg_soft_dir?>
          </td>
        </tr>
        <tr> 
          <td height="24">ģ��Ĵ��Ŀ¼($cfg_templets_dir)��</td>
          <td width="59%"> 
            <?=$cfg_templets_dir?>
          </td>
        </tr>
        <tr bgcolor="#F8F7F5"> 
          <td height="24">���ݱ���Ŀ¼($cfg_backup_dir)��</td>
          <td width="59%"> 
            <?=$cfg_backup_dir?>
          </td>
        </tr>
        <tr> 
          <td height="24">�½�Ŀ¼��Ȩ��($cfg_dir_purview)��</td>
          <td> 
            <?="0".decoct($cfg_dir_purview)?>
          </td>
        </tr>
        <tr bgcolor="#F8F7F5"> 
          <td height="24">����Ա��Email($cfg_adminemail)��</td>
          <td width="59%"> 
            <?=$cfg_adminemail?>
          </td>
        </tr>
        <tr> 
          <td height="24">���ݷ�������</td>
          <td> 
            <?=$dbhost?>
          </td>
        </tr>
        <tr bgcolor="#F8F7F5"> 
          <td height="24">���ݿ⣺</td>
          <td width="59%"> 
            <?=$cfg_dbname?>
          </td>
        </tr>
        <tr> 
          <td height="24">���ݿ��û�����</td>
          <td width="59%"> 
            <?=$cfg_dbuser?>
          </td>
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
</center>
</body>
</html>