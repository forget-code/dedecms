<?
require_once(dirname(__FILE__)."/config.php");
CheckPurview('sys_Edit');
require_once(dirname(__FILE__)."/../include/inc_photograph.php");
if($cfg_photo_support==""){ echo "���ϵͳû��װGD�⣬������ʹ�ñ����ܣ�"; }
$ImageWaterConfigFile = dirname(__FILE__)."/../include/inc_photowatermark_config.php";
if(empty($action)) $action = "";
if($action=="save")
{
   $vars = array('photo_markup','photo_markdown','photo_wwidth','photo_wheight','photo_waterpos','photo_watertext','photo_fontsize','photo_fontcolor','photo_diaphaneity');
   $configstr = "";
   foreach($vars as $v){
   	 ${$v} = str_replace("'","",${$v});
   	 $configstr .= "\${$v} = '".${$v}."';\r\n";
   }
   $shortname = "";
   if(is_uploaded_file($newimg)){
   	  $imgfile_type = strtolower(trim($newimg_type));
      if(!in_array($imgfile_type,$cfg_photo_typenames)){
		  ShowMsg("�ϴ���ͼƬ��ʽ������ʹ�� {$cfg_photo_support}��ʽ������һ�֣�","-1");
		  exit();
	   }
	   if($imgfile_type=='image/bmp') $shortname = ".bmp";
	   else if($imgfile_type=='image/png') $shortname = ".png";
	   else if($imgfile_type=='image/gif') $shortname = ".gif";
	   else $shortname = ".jpg";
	   $photo_markimg = 'mark'.$shortname;
	   @move_uploaded_file($newimg,dirname(__FILE__)."/../include/data/".$photo_markimg);
   }
   $configstr .= "\$photo_markimg = '{$photo_markimg}';\r\n";
   $configstr = "<"."?\r\n".$configstr."?".">\r\n";
   $fp = fopen($ImageWaterConfigFile,"w") or die("д���ļ� $ImageWaterConfigFile ʧ�ܣ�����Ȩ�ޣ�");
   fwrite($fp,$configstr);
   fclose($fp);
   echo "<script>alert('�޸����óɹ���');</script>\r\n";
}
require_once($ImageWaterConfigFile);
?>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
<title>ϵͳ���ò��� - ͼƬˮӡ����</title>
<link href='base.css' rel='stylesheet' type='text/css'>
</head>
<body background='img/allbg.gif' leftmargin='8' topmargin='8'>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#666666">
  <form action="sys_info_mark.php" method="post" enctype="multipart/form-data">
  <input type="hidden" name="action" value="save">
  <input type="hidden" name="photo_markimg" value="<?=$photo_markimg?>">
  <tr> 
    <td height="26" colspan="2" bgcolor="#FFFFFF" background="img/tbg.gif">
	<b>DedeCmsϵͳ���ò���</b> - <strong>ͼƬˮӡ����</strong>    </td>
  </tr>
  <tr bgcolor="#FFFFFF"> 
    <td width="41%" height="24">�ϴ���ͼƬ�Ƿ�ʹ��ͼƬˮӡ���ܣ�<br> </td>
    <td width="59%"> <input class="np" type="radio" value="1" name="photo_markup"<?if($photo_markup==1) echo ' checked';?>>
      ���� 
      <input class="np" type="radio" value="0" name="photo_markup"<?if($photo_markup==0) echo ' checked';?>>
      �ر� </td>
  </tr>
  <tr bgcolor="#FFFFFF"> 
    <td height="24">�ɼ���ͼƬ�Ƿ�ʹ��ͼƬˮӡ���ܣ�</td>
    <td> <input class="np" type="radio" value="1" name="photo_markdown"<?if($photo_markdown==1) echo ' checked';?>>
      ���� 
        <input class="np" type="radio" value="0" name="photo_markdown"<?if($photo_markdown==0) echo ' checked';?>>
      �ر� </td>
  </tr>
  <tr bgcolor="#FFFFFF"> 
    <td height="24">���ˮӡ��ͼƬ��С���ƣ�����Ϊ0Ϊ���ޣ���</td>
    <td> �� 
      <input name="photo_wwidth" type=text id="photo_wwidth"   value="<?=$photo_wwidth?>" size="5">
      �ߣ� 
      <input name="photo_wheight" type=text id="photo_wheight"  value="<?=$photo_wheight?>" size="5"> </td>
  </tr>
  
  <tr bgcolor="#FFFFFF"> 
    <td height="24">ˮӡͼƬ�ļ�������������ڣ���ʹ������ˮӡ����</td>
    <td><img src="../include/data/<?=$photo_markimg?>" alt="dede"></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="24">�ϴ���ͼƬ��</td>
    <td>
	<input name="newimg" type="file" id="newimg" style="width:300">
    <br>
	<? echo "���ϵͳ֧�ֵ�ͼƬ��ʽ��".$cfg_photo_support; ?>
	</td>
  </tr>
  <tr bgcolor="#FFFFFF"> 
    <td height="24">ˮӡͼƬ���֣���֧�����ģ���</td>
    <td> <input type="text" name="photo_watertext"  value="<?=$photo_watertext?>"></td>
  </tr>
  <tr bgcolor="#FFFFFF"> 
    <td height="24">ˮӡͼƬ���������С��</td>
    <td> <input name="photo_fontsize" type=text id="photo_fontsize"  value="<?=$photo_fontsize?>"></td>
  </tr>
  <tr bgcolor="#FFFFFF"> 
    <td height="24">ˮӡͼƬ������ɫ��Ĭ��#FF0000Ϊ��ɫ����</td>
    <td> <input name="photo_fontcolor" type=text id="photo_fontcolor"  value="<?=$photo_fontcolor?>"></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="24">ˮӡ͸���ȣ�0��100��ֵԽСԽ͸������</td>
    <td><input name="photo_diaphaneity" type=text id="photo_diaphaneity"  value="<?=$photo_diaphaneity?>"></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="24">ˮӡλ�ã�</td>
    <td>
	<input class="np" type="radio" name="photo_waterpos"  value="0"<?if($photo_waterpos==0) echo ' checked';?>>
          ���λ��
	<table width="300" border="1" cellspacing="0" cellpadding="0">
      <tr>
        <td width="33%"><input class="np" type="radio" name="photo_waterpos"  value="1"<?if($photo_waterpos==1) echo ' checked';?>>
          ��������</td>
        <td width="33%"><input class="np" type="radio" name="photo_waterpos"  value="4"<?if($photo_waterpos==4) echo ' checked';?>>
          ��������</td>
        <td><input class="np" type="radio" name="photo_waterpos"  value="7"<?if($photo_waterpos==7) echo ' checked';?>>
          ��������</td>
      </tr>
      <tr>
        <td><input class="np" type="radio" name="photo_waterpos"  value="2"<?if($photo_waterpos==2) echo ' checked';?>>
          ��߾���</td>
        <td><input class="np" type="radio" name="photo_waterpos"  value="5"<?if($photo_waterpos==5) echo ' checked';?>>
          ͼƬ����</td>
        <td><input class="np" type="radio" name="photo_waterpos"  value="8"<?if($photo_waterpos==8) echo ' checked';?>>
          �ұ߾���</td>
      </tr>
      <tr>
        <td><input class="np" type="radio" name="photo_waterpos"  value="3"<?if($photo_waterpos==3) echo ' checked';?>>
          �ײ�����</td>
        <td><input class="np" type="radio" name="photo_waterpos"  value="6"<?if($photo_waterpos==6) echo ' checked';?>>
          �ײ�����</td>
        <td><input name="photo_waterpos" type="radio" class="np"  value="9"<?if($photo_waterpos==9) echo ' checked';?>>
          �ײ�����</td>
      </tr>
    </table></td>
  </tr>
  
  <tr bgcolor="#F3FCE4"> 
    <td height="37" colspan="2">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="7%">&nbsp;</td>
          <td width="93%">
		  <input name="imageField" class="np" type="image" src="img/button_ok.gif" width="60" height="22" border="0">
            ��&nbsp;
		 <img src="img/button_reset.gif" width="60" height="22">		  </td>
        </tr>
      </table>	  </td>
  </tr>
  </form>
</table>
</body>
</html>
