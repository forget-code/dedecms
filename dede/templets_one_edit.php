<?
require(dirname(__FILE__)."/config.php");
CheckPurview('temp_One');
if(empty($dopost)) $dopost = "";
if(empty($aid)) $aid = "";
$dsql = new DedeSql(false);
//////////////////////////////////////////
if($dopost=="saveedit")
{
  require_once(dirname(__FILE__)."/../include/inc_arcpart_view.php");
	$uptime = mytime();
	$body = str_replace('&quot;','\\"',$body);
	$filename = ereg_replace("^/","",$nfilename);
	//����������ļ�����ɾ�����ļ�
	if($oldfilename!=$filename)
	{
		$oldfilename = $cfg_basedir.$cfg_cmspath."/".$oldfilename;
		if(is_file($oldfilename)) unlink($oldfilename);
	}
	$inQuery = "
	 update #@__sgpage set
	 title='$title',
	 ismake='$ismake',
	 filename='$filename',
	 uptime='$uptime',
	 body='$body'
	 where aid='$aid';
	";
	$dsql->SetQuery($inQuery);
	if(!$dsql->ExecuteNoneQuery())
	{
		$dsql->Close();
		ShowMsg("����ҳ������ʱʧ�ܣ����鳤���Ƿ������⣡","-1");
	  exit();
	}
	$dsql->Close();
	$filename = $cfg_basedir.$cfg_cmspath."/".$filename;
	if($ismake==1){
	  $pv = new PartView();
    $pv->SetTemplet(stripslashes($body),"string");
    $pv->SaveToHtml($filename);
    $pv->Close();
  }
  else{
  	$fp = fopen($filename,"w") or die("������{$filename} ʧ�ܣ�������û��Ȩ�ޣ�");
  	fwrite($fp,stripslashes($body));
  	fclose($fp);
  }
	ShowMsg("�ɹ�����һ��ҳ�棡","templets_one.php");
	exit();
}
else if($dopost=="delete")
{
   $row = $dsql->GetOne("Select filename From #@__sgpage where aid='$aid'");
   $filename = $cfg_basedir.$cfg_cmspath."/".$row['filename'];
   $dsql->SetQuery("Delete From #@__sgpage where aid='$aid'");
   $dsql->ExecuteNoneQuery();
   $dsql->Close();
   if(is_file($filename)) unlink($filename);
   ShowMsg("�ɹ�ɾ��һ��ҳ�棡","templets_one.php");
   exit();
}
else if($dopost=="make")
{
	require_once(dirname(__FILE__)."/../include/inc_arcpart_view.php");
	$dsql->SetQuery("update #@__sgpage set uptime='".mytime()."' where aid='$aid'");
  $dsql->ExecuteNoneQuery();
	$row = $dsql->GetOne("Select * From #@__sgpage where aid='$aid'");
	$fileurl = $cfg_cmspath."/".$row['filename'];
	$filename = $cfg_basedir.$cfg_cmspath."/".$row['filename'];
	if($row['ismake']==1)
	{
	  $pv = new PartView();
      $pv->SetTemplet($row['body'],"string");
      $pv->SaveToHtml($filename);
      $pv->Close();
   }
   else
   {  
    	$fp = fopen($filename,"w") or die("������{$filename} ʧ�ܣ�������û��Ȩ�ޣ�");
  	  fwrite($fp,$row['body']);
      fclose($fp);
   }
	$dsql->Close();
	ShowMsg("�ɹ�����һ��ҳ�棡",$fileurl);
	exit();
}
$row = $dsql->GetOne("Select  * From #@__sgpage where aid='$aid'");
$dsql->Close();
?>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
<title>�����Զ���ҳ��</title>
<link href='base.css' rel='stylesheet' type='text/css'>
<script language="javascript">
function checkSubmit()
{
	if(document.form1.title.value=="")
	{
		alert("ҳ�����Ʋ���Ϊ�գ�");
		document.form1.title.focus();
		return false;
	}
	if(document.form1.nfilename.value=="")
	{
		alert("�ļ�������Ϊ�գ�");
		document.form1.nfilename.focus();
		return false;
	}
}
</script>
</head>
<body background='img/allbg.gif' leftmargin='8' topmargin='8'>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#666666">
<tr>
    <td height="19" background="img/tbg.gif"> <b><a href="templets_one.php"><u>����ҳ�����</u></a></b>&gt;&gt;����ҳ�� 
    </td>
</tr>
<tr>
    <td height="200" bgcolor="#FFFFFF" valign="top">
	<table width="100%" border="0" cellspacing="4" cellpadding="2">
        <form action="templets_one_edit.php" method="post" name="form1" onSubmit="return checkSubmit()">
          <input type='hidden' name='dopost' value='saveedit'>
		  <input type='hidden' name='aid' value='<?=$aid?>'>
          <tr> 
            <td width="15%" height="24" align="center">ҳ�����ƣ�</td>
            <td> 
              <input name="title" type="text" id="title" size="30" value="<?=$row['title']?>"></td>
          </tr>
          <tr> 
            <td height="24" align="center" bgcolor="#F3FBEC">�����ļ�����</td>
            <td bgcolor="#F3FBEC">
			       <input name="oldfilename" type="hidden" id="oldfilename" value="<?=$row['filename']?>">
			       <input name="nfilename" type="text" id="nfilename" size="30" value="<?=$row['filename']?>">
             �������CMS��װĿ¼��
            </td>
          </tr>
          <tr> 
            <td height="24" align="center">�Ƿ���룺</td>
            <td>
            	<input name="ismake" type="radio" value="1"<?if($row['ismake']==1) echo " checked";?>>
              ��ģ���ǣ�Ҫ���� 
              <input type="radio" name="ismake" value="0"<?if($row['ismake']==0) echo " checked";?>>
              ����ģ���ǣ�����Ҫ����</td>
          </tr>
          <tr> 
            <td height="24" colspan="2" bgcolor="#F3FBEC">�ļ����ݣ�</td>
          </tr>
          <tr> 
            <td height="80" colspan="2" align="center"> 
              <?
	GetEditor("body",$row['body'],"500","Default","print","true");
	?>
            </td>
          </tr>
          <tr> 
            <td height="53" align="center">&nbsp;</td>
            <td><input name="imageField" type="image" src="img/button_ok.gif" width="60" height="22" border="0"></td>
          </tr>
        </form>
      </table>
	 </td>
</tr>
</table>
</body>
</html>