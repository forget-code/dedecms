<?
require_once("config.php");
require("inc_modpage.php");
?>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
<title>��ҳ������</title>
<link href='base.css' rel='stylesheet' type='text/css'>
</head>
<body background='img/allbg.gif' leftmargin='8' topmargin='8'>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#666666">
  <tr>
    <td height="19" background="img/tbg.gif"><strong>��ҳ������</strong>&nbsp;&nbsp;</td>
</tr>
<tr>
    <td height="200" bgcolor="#FFFFFF" valign="top"> ��<br>
      <table width="90%" border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#CCCCCC">
        <tr bgcolor="#F9F8F4"> 
          <td colspan="5">��ҳ�򵼵�ģ�屣���ڡ�<?=$mod_dir?>/��ҳ�򵼡����ļ����ڣ���ҳ���ļ����ɵ�·�����ܸ��ģ�ֻ�ܴ���Ϊ����Ŀ¼/�㶨����ļ�������index.html�ȣ�����</td>
        </tr>
		<form name="homepageform" action="make_part_testhome.php" method="post">
		<input type="hidden" name="job" value="view">
		<tr bgcolor="#FFFFFF"> 
          <td colspan="3">&nbsp;ѡ��ģ����</td>
          <td width="40%" align="center" bgcolor="#FFFFFF">
		  <select name="modname" id="modname" style="width:180">
		  <?
		  if(empty($modname)) $modname="";
		  $mp = new modPage();
		  $ds = $mp->GetHomePageArrays($modname);
		  if($modname=="") $modname=$ds[0];
		  if(count($ds)>0)
		  foreach($ds as $d)
		  {
		  	echo "<option value='$d'>$d</option>\r\n";
		  }
		  ?>
          </select>
		  <input type="hidden" name="selmode" value="<?=$modname?>">
		  </td>
          <td width="41%"> 
		  <input type="button" name="ss1111" value="����ģ��" onClick="location='add_home_page.php?modname='+document.homepageform.modname.value;">&nbsp;
&nbsp;          </td>
        </tr>
		<tr bgcolor="#FFFFFF"> 
          <td colspan="3">&nbsp;���ɵ��ļ����ƣ�</td>
          <td align="center" bgcolor="#FFFFFF">
		  <input name="filename" type="text" id="filename" value="<?=@ereg_replace("^/","",$index_url)."/"?>index.html" style="width:180">		  </td>
          <td>&nbsp;</td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td height="32" colspan="5" align="center">
              <table width="90%" border="0" cellspacing="2" cellpadding="2">
                <tr> 
                  <td>
				  <textarea name="testcode" cols="70" rows="12" id="testcode"><?
				  $modfile = $base_dir.$mod_dir."/��ҳ��/$modname";
				  $fp = fopen($modfile,"r");
				  echo fread($fp,filesize($modfile));
				  fclose($fp);
				  ?></textarea>
				  </td>
                </tr>
                <tr>
                  <td height="30">�����������Щ���ɵĴ����õ�Dreamweaver�������о�����ᷢ��һ��ǿ������ݹ���ϵͳ������Щ�ķ���ʹ�úͼ򵥣�</td>
                </tr>
                <tr> 
                  <td height="30" align="center">
<input type="submit" name="Submit11" value=" Ԥ��һ�� " onClick="document.homepageform.job.value='view';document.homepageform.target='_blank';";>
��<input type="submit" name="Submit22" value=" ����ģ�� " onClick="document.homepageform.job.value='save';document.homepageform.target='_self';">
��<input type="submit" name="Submit22" value="������ҳ" onClick="document.homepageform.job.value='make';document.homepageform.target='_blank';">
                  </td>
                </tr>
              </table>
            </td>
        </tr>
		</form>
      </table>
    <br>    </td>
</tr>
</table>
</body>
</html>