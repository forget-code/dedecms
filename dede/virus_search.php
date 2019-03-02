<?php 
require_once(dirname(__FILE__)."/config.php");
@set_time_limit(3600);
if(empty($dopost)) $dopost = '';

//�߼�����
//-------------------------------------
function GoSearchVir($fdir){
	global $tcc,$scc,$ddfiles,$shortname,$minsize,$maxsize,$crday,$cfg_basedir;
	$dh = dir($fdir);
	while($filename = $dh->read()){
		if($filename=='.'||$filename=='..') continue;
		$truefile = $fdir."/".$filename;
		if(is_dir($truefile)) GoSearchVir($truefile);
		if(!is_file($truefile)) continue;
		$scc++;
		$ftime = filemtime($truefile);
		$fsize = filesize($truefile);
		$ntime = time() - ($crday * 24 * 3600);
		if(eregi("\.".$shortname,$filename) && $ftime > $ntime
		&& ($fsize<$minsize || $fsize>$maxsize))
		{
			$nfsize = number_format($fsize/1024,2).'K';
			if(in_array($filename,$ddfiles)) continue;
			if($fsize<$minsize){
				$fp = fopen($truefile,'r');
				$tstr = fread($fp,$fsize);
				fclose($fp);
				if(!eregi("eval|fopen|unlink|rename",$tstr)) continue;
			}
			$furl = str_replace($cfg_basedir,"",$truefile);
			echo "<li><input type='checkbox' name='vfiles[]' value='$furl' class='np'> <a href='$furl' target='_blank'><u>$furl</u></a> �������ڣ�".GetDateTimeMk($ftime)." ��С��{$nfsize} </li>\r\n";
			$tcc++;
		}
	}
	$dh->close();
}
function GoReplaceFile($fdir){
	global $tcc,$scc,$shortname,$cfg_basedir,$sstr,$rpstr;
	$dh = dir($fdir);
	while($filename = $dh->read()){
		if($filename=='.'||$filename=='..') continue;
		$truefile = $fdir."/".$filename;
		if(is_dir($truefile)) GoReplaceFile($truefile);
		if(!is_file($truefile)) continue;
		$scc++;
		$fsize = filesize($truefile);
		if(eregi("\.(".$shortname.")",$filename))
		{
			$fp = fopen($truefile,'r');
			$tstr = fread($fp,$fsize);
			$tstr = eregi_replace($sstr,$rpstr,$tstr);
			fclose($fp);
			if(is_writeable($truefile)){
			  $fp = fopen($truefile,'w');
			  fwrite($fp,$tstr);
			  fclose($fp);
			  $tcc++;
			}else{
				$furl = str_replace($cfg_basedir,"",$truefile);
				echo "<li>�ļ��� {$rurl} ����д�룡</li>";
			}
		}
	}
	$dh->close();
}
//----------------------------------

if($dopost=='search'){
   $tcc = 0;
   $scc = 0;
   $ddfile = "album_edit.php,catalog_add.php,file_manage_main.php,soft_edit.php,spec_edit.php,inc_archives_view.php,inc_arclist_view.php,inc_arcmember_view.php,inc_freelist_view.php,pub_collection.php,config_passport.php,downmix.php,inc_photowatermark_config.php";
   $ddfiles = explode(',',$ddfile);
   if(empty($crday)) $crday = 365;
	 $minsize = $minsize * 1024;
	 $maxsize = $maxsize * 1024;
	 $phead = "<html>
  <head>
  <meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
  <title>ľ��ɨ������</title>
  <link href='base.css' rel='stylesheet' type='text/css'>
  <style>
  li{width:100%;height:26px;border:1px solid #C9E3FA; margin:3px; list-style-type:none }
  .lii{ padding:3px; }
  </style>
  <body>
  <form action='virus_search.php' method='post' name='form1'>
  <input type='hidden' name='dopost' value='delete'>
";
	 echo $phead;
	 GoSearchVir($searchpath);
   echo "<li class='lii'> ";
   if($tcc>0) echo "<input type='submit' name='sb1' value='ɾ��ѡ�е��ļ���' class='nbt'><br><br>\r\n";
   echo "&nbsp;&nbsp;������ {$scc} ���ļ����ҵ� {$tcc} �������ļ���ɾ���ļ�����ں�̨����Ŀ¼����һ��virlog.txt�ļ�������ɾ֯��ϵͳ�ļ����Ӵ��ļ����һ���Щ�ļ�·������dede��ͬ�汾û�޸Ĺ����ļ��滻���ɣ� </li>\r\n";
   echo "</form><body></html>";
   exit();
}else if($dopost=='replace'){
	 $tcc = 0;
   $scc = 0;
	 $phead = "<html>
  <head>
  <meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
  <title>�����滻���</title>
  <link href='base.css' rel='stylesheet' type='text/css'>
  <style>
  li{width:100%;height:26px;border:1px solid #C9E3FA; margin:3px; list-style-type:none }
  .lii{ padding:3px; }
  </style>
  <body>
";
	 echo $phead;
	 $sstr = stripslashes($sstr);
	 $rpstr = stripslashes($rpstr);
	 GoReplaceFile($searchpath);
	 echo "<li class='lii'> ";
   echo "&nbsp;&nbsp;������ {$scc} ���ļ����ɹ��滻 {$tcc} ���ļ��� </li>\r\n";
   echo "<body></html>";
	 exit();
}else if($dopost=='delete')
{
	 if(is_array($vfiles)){
      $fp = fopen(dirname(__FILE__)."/virlog.txt","w");
      foreach($vfiles as $f){
      	unlink($cfg_basedir.$f);
      	fwrite($fp,$f."\r\n");
      	echo "ɾ���ļ��� ".$cfg_basedir.$f." <br>\r\n";
      }
      fclose($fp);
	 }
	 echo "�ɹ�ɾ������ָ���ļ���";
	 exit();
}

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>ľ��ɨ������</title>
<link href="base.css" rel="stylesheet" type="text/css">
<script language="javascript">
function CheckRp(){
  var dp1 = document.getElementById("dp1");
  var dp2 = document.getElementById("dp2");
  var rpct = document.getElementById("rpct");
  if(dp1.checked){
  	document.form1.shortname.value = "php|asp|aspx";
  	rpct.style.display = "none";
  }else{
    document.form1.shortname.value = "php|asp|aspx|htm|html|shtml";
    rpct.style.display = "block";
  }
}
</script>
</head>
<body background='img/allbg.gif' leftmargin='8' topmargin='8'>
<table width="98%" border="0" cellpadding="3" cellspacing="1" bgcolor="#98CAEF" align="center">
  <form action="virus_search.php" name="form1" target="stafrm" method="post">
  <tr> 
    <td height="20" background='img/tbg.gif'> <table width="98%" border="0" cellpadding="0" cellspacing="0">
        <tr> 
            <td width="30%" height="18"><strong>ľ��ɨ��������</strong></td>
          <td width="70%" align="right">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
  <tr>
      <td height="33" bgcolor="#FFFFFF">�������ļ���ԭ����ɨ���п��ɲ�����PHP�ļ������ض�������ļ��������Ѿ���Ⱦ�������ļ�����ָ���滻���ݹ����滻����Ⱦ���ļ����ݣ����ļ������ǳ��������£��������Ƚ�ռ�÷�������Դ����ȷ�ű���ʱ����ʱ��������ģ���������޷���ɲ�����</td>
  </tr>
  <tr> 
    <td height="48" bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="2" cellspacing="2">
          <tr bgcolor="#EBFBE6"> 
            <td><strong>&nbsp;�������ͣ�</strong></td>
            <td> <input name="dopost" type="radio" id="dp1" class="np" onclick="CheckRp()" value="search" checked>
              ɨ���ļ� 
              <input name="dopost" type="radio" id="dp2" value="replace" onclick="CheckRp()" class="np">
              �滻���� </td>
          </tr>
          <tr> 
            <td width="14%"><strong>&nbsp;��ʼ��·����</strong></td>
            <td width="86%"> <input name="searchpath" type="text" id="searchpath" style="width:60%" value="<?=$cfg_basedir?>">	
            </td>
          </tr>
          <tr> 
            <td bgcolor="#EBFBE6"><strong>&nbsp;�ļ������壺</strong></td>
            <td bgcolor="#EBFBE6">&nbsp;</td>
          </tr>
          <tr> 
            <td colspan="2"><table width="100%" border="0" cellspacing="1" cellpadding="1">
                <tr> 
                  <td height="30">&nbsp;�� չ ���� 
                    <input name="shortname" type="text" id="shortname" size="20" value="php|asp|aspx">
                    �ļ���С����С�ڣ� 
                    <input name="minsize" type="text" id="minsize" value="1" size="6">
                    K �� ���ڣ� 
                    <input name="maxsize" type="text" id="maxsize" value="20" size="6">
                    K�� �ļ��������ڣ� 
                    <input name="crday" type="text" id="crday" value="7" size="6">
                    �����ڡ�
                    <hr size="1">
                    ��˵����ͨ�������PHPľ�����ֻ�Ǽ�ʮ���ֽڣ�Ҫô��20K���ϣ�������Զ�����֯��ϵͳ����20K���ļ��� </td>
                </tr>
              </table></td>
          </tr>
          <tr id="rpct" style="display:none"> 
            <td height="64" colspan="2">
			<table width="100%" border="0" cellspacing="1" cellpadding="1">
                <tr bgcolor="#EDFCE2"> 
                  <td colspan="4"><strong>�����滻ѡ�</strong>���滻������ʹ��������ʽ���滻����ʱ���ж���չ�����ļ���С���ļ���������ѡ�����ԣ�</td>
                </tr>
                <tr> 
                  <td width="15%">&nbsp;�滻���ݣ�</td>
                  <td width="35%"><textarea name="sstr" id="sstr" style="width:90%;height:45px"></textarea></td>
                  <td width="15%">�� �� Ϊ��</td>
                  <td><textarea name="rpstr" id="rpstr" style="width:90%;height:45px"></textarea></td>
                </tr>
              </table>
			  </td>
          </tr>
        </table></td>
  </tr>
  <tr> 
    <td height="31" bgcolor="#F8FBFB" align="center">
	<input type="submit" name="Submit" value="��ʼִ�в���" class="nbt">
	</td>
  </tr>
  </form>
  <tr bgcolor="#E5F9FF"> 
    <td height="20"> <table width="100%">
        <tr> 
          <td width="74%"><strong>�������</strong></td>
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
    <td id="mtd">
    	<div id='mdv' style='width:100%;height:100;'> 
        <iframe name="stafrm" frameborder="0" id="stafrm" width="100%" height="100%"></iframe>
      </div>
      <script language="JavaScript">
	    document.all.mdv.style.pixelHeight = screen.height - 420;
	    </script>
	   </td>
  </tr>
</table>
</body>
</html>
