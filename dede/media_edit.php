<?php 
require_once(dirname(__FILE__)."/config.php");
if(empty($dopost)) $dopost = "";
isset($_COOKIE['ENV_GOBACK_URL']) ? $backurl=$_COOKIE['ENV_GOBACK_URL'] : $backurl="javascript:history.go(-1);";

/*---------------------------
function __del_file() //ɾ������
-----------------------------*/
if($dopost=='del'){
	CheckPurview('sys_DelUpload');
	if(empty($ids)) $ids="";
	$dsql = new DedeSql(false);
	if($ids==""){
    $myrow = $dsql->GetOne("Select url From #@__uploads where aid='".$aid."'");
    $truefile = $cfg_basedir.$myrow['url'];
    $rs = 0;
		if(!file_exists($truefile)||$myrow['url']=="") $rs = 1;
		else $rs = @unlink($truefile);
    if($rs==1){
       $msg = "�ɹ�ɾ��һ��������";
       $dsql->ExecuteNoneQuery("Delete From #@__uploads where aid='".$aid."'");
    }
    $dsql->Close();
    ShowMsg($msg,$backurl);
    exit();
	}else{
		$ids = explode(',',$ids);
		$idquery = "";
		foreach($ids as $aid){
			if($idquery=="") $idquery .= " where aid='$aid' ";
			else $idquery .= " Or aid='$aid' ";
		}
		$dsql->SetQuery("Select aid,url From #@__uploads $idquery ");
		$dsql->Execute();
		while($myrow=$dsql->GetArray()){
			$truefile = $cfg_basedir.$myrow['url'];
			$rs = 0;
			if(!file_exists($truefile)||$myrow['url']=="") $rs = 1;
			else $rs = @unlink($truefile);
			if($rs==1){
				$dsql->ExecuteNoneQuery("Delete From #@__uploads where aid='".$myrow['aid']."'"); 
			}
		}
		$dsql->Close();
		ShowMsg('�ɹ�ɾ��ѡ�����ļ���',$backurl);
		exit();
	}
}
/*--------------------------------
function __save_edit() //�������
-----------------------------------*/
else if($dopost=='save'){
	if($aid=="") exit();
	//����Ƿ����޸�Ȩ��
	$dsql = new DedeSql(false);
  $myrow = $dsql->GetOne("Select * From #@__uploads where aid='".$aid."'");
  $dsql->Close();
	if($myrow['adminid']!=$cuserLogin->getUserID()){ CheckPurview('sys_Upload'); }
	//����ļ�����
	$addquery = "";
	if(is_uploaded_file($upfile)){
		 if($mediatype==1){
		 	  $sparr = Array("image/pjpeg","image/jpeg","image/gif","image/png","image/x-png","image/wbmp");
		 	  if(!in_array($upfile_type,$sparr)){
		 	  	ShowMsg("���ϴ��Ĳ���ͼƬ���͵��ļ���","javascript:history.go(-1);");
		 	  	exit();
		 	  }
		 }
     else if($mediatype==2){
     	  $sparr = Array("application/x-shockwave-flash");
     	  if(!in_array($upfile_type,$sparr)){
		 	  	ShowMsg("���ϴ��Ĳ���Flash���͵��ļ���","javascript:history.go(-1);");
		 	  	exit();
		 	  }
     }else if($mediatype==3){
     	  if(!eregi('audio|media|video',$upfile_type)){
     	  	ShowMsg("���ϴ���Ϊ����ȷ���͵�Ӱ���ļ���","javascript:history.go(-1);");
		 	  	exit();
     	  }
     	  if(!eregi("\.".$cfg_mediatype,$upfile_name)){
     	  	ShowMsg("���ϴ���Ӱ���ļ���չ���޷���ʶ�������ϵͳ���õĲ�����","javascript:history.go(-1);");
		 	  	exit();
     	  }
     }else{
     	  if(!eregi("\.".$cfg_softtype,$upfile_name)){
     	  	ShowMsg("���ϴ��ĸ�����չ���޷���ʶ�������ϵͳ���õĲ�����","javascript:history.go(-1);");
		 	  	exit();
     	  } 
     }
     //�����ļ�
     $nowtime = mytime();
     $oldfile = $myrow['url'];
     $oldfiles = explode('/',$oldfile);
     $fullfilename = $cfg_basedir.$oldfile;
     $oldfile_path = ereg_replace($oldfiles[count($oldfiles)-1]."$","",$oldfile);
		 if(!is_dir($cfg_basedir.$oldfile_path)){
		 	  MkdirAll($cfg_basedir.$oldfile_path,777);
		 	  CloseFtp();
		 }
		 @move_uploaded_file($upfile,$fullfilename);
		 if($mediatype==1){
		 	  require_once(dirname(__FILE__)."/../include/inc_photograph.php");
		 	  if(in_array($upfile_type,$cfg_photo_typenames)) WaterImg($fullfilename,'up');
		 }
		 $filesize = $upfile_size;
		 $imgw = 0;
		 $imgh = 0;
		 if($mediatype==1){
		 	 $info = "";
       $sizes[0] = 0; $sizes[1] = 0;
	     @$sizes = getimagesize($fullfilename,$info);
	     $imgw = $sizes[0];
	     $imgh = $sizes[1];
		 }
		 if($imgw>0) $addquery = ",width='$imgw',height='$imgh',filesize='$filesize' ";
		 else $addquery = ",filesize='$filesize' ";
	}
	else{ $fileurl = $filename; }
  //д�����ݿ�
  $query = " update #@__uploads set title='$title',mediatype='$mediatype',playtime='$playtime'";
  $query .= "$addquery where aid='$aid' ";
  $dsql = new DedeSql(false);
  $dsql->ExecuteNoneQuery($query);
  $dsql->Close();
  ShowMsg('�ɹ�����һ�򸽼����ݣ�','media_edit.php?aid='.$aid);
  exit();
}
else
{
  //��ȡ������Ϣ
  //--------------------------------
  CheckPurview('sys_Upload,sys_MyUpload');
  $dsql = new DedeSql(false);
  $myrow = $dsql->GetOne("Select * From #@__uploads where aid='".$aid."'");
  $dsql->Close();
  if(!is_array($myrow)){
	  ShowMsg('�����Ҳ����˱�ŵĵ�����','javascript:;');
	  exit();
  }
}
?>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
<title>�����ļ�</title>
<link href='base.css' rel='stylesheet' type='text/css'>
<style>
.coolbg2 {
border: 1px solid #000000;
background-color: #F2F5E9;
height:18px
}
</style>
<script language='javascript'>
function CheckSubmit()
{
	if(document.form1.title.value==""){
		alert("���趨ý����⣡");
		document.form1.title.focus();
		return false;
	}
}
</script>
</head>
<body background='img/allbg.gif' leftmargin='8' topmargin='8'>
<table width="99%" border="0" cellpadding="3" cellspacing="1" bgcolor="#98CAEF">
<tr> 
<td height="19" background='img/tbg.gif'>
<table width="98%" border="0" cellpadding="0" cellspacing="0">
<tr> 
<td width="2%" align="center" valign="middle"><img src="img/item_tt2.gif" width="7" height="15"></td>
<td width="44%"><strong>����ý�壺</strong></td>
<td width="54%" align="right">[<a href='media_main.php'><u>����/ý�����ݹ���</u></a>]</td>
</tr>
</table></td>
</tr>
<tr> 
<td height="19" bgcolor="#ffffff">
<img src="img/help.gif" border="0">
��ʾ��ͼƬ���ͽ�֧��jpg��png��gif��wbmp��ʽ��flashΪ.swf��ʽ������Ƶ�͸���Ϊ�޶���չ��������(����ϵͳ�������޸�)��
</td>
</tr>
<tr> 
<td height="69" align="center" valign="top" bgcolor="#FFFFFF">
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
<form enctype="multipart/form-data" name='form1' action="media_edit.php" method="POST" onSubmit="return CheckSubmit();">
<input type="hidden" name="dopost" value="save">
<input type="hidden" name="aid" value="<?php echo $aid?>"> 
<tr> 
<td width="15%" height="30" align="center" bgcolor="#FFFFFF"class='bline'>ý�����ͣ�</td>
<td width="85%" height="25" bgcolor="#FFFFFF"class='bline'>
	<input type="radio" name="mediatype" class="np" value="1"<?php  if($myrow['mediatype']==1) echo " checked"; ?>>
ͼƬ 
<input type="radio" name="mediatype" class="np" value="2"<?php  if($myrow['mediatype']==2) echo " checked"; ?>>
FLASH 
<input type="radio" name="mediatype" class="np" value="3"<?php  if($myrow['mediatype']==3) echo " checked"; ?>>
��Ƶ/��Ƶ 
<input type="radio" name="mediatype" class="np" value="4"<?php  if($myrow['mediatype']==4) echo " checked"; ?>>
����/����
</td>
</tr>
<tr> 
<td height="30" align="center" bgcolor="#FFFFFF"class='bline'>˵�����⣺</td>
<td height="25" bgcolor="#FFFFFF"class='bline'>
	<input name="title" type="text" id="title" size="30" value="<?php echo $myrow['title']?>">
</td>
</tr>
<tr> 
<td height="30" align="center" bgcolor="#FFFFFF"class='bline'>����˵����</td>
<td height="30" bgcolor="#FFFFFF"class='bline' colspan='2'>ͼƬ����Ҫָ�����������ߡ����������Ӳ����������ý���ļ�����û��������</td>
</tr>
<tr> 
<td height="30" align="center" bgcolor="#FFFFFF" class='bline'>���Ӳ�����</td>
<td height="25" bgcolor="#FFFFFF" class='bline'>
	�� 
<input name="mediawidth" type="text" id="mediawidth" size="5" value="<?php echo $myrow['width']?>">
(����)���ߣ� 
<input name="mediaheight" type="text" id="mediaheight" size="5" value="<?php echo $myrow['height']?>">
(����)������ʱ�䣺 
<input name="playtime" type="text" id="playtime" size="5" value="<?php echo $myrow['playtime']?>">
(����)
</td>
</tr>
<tr>
<td height="30" align="center" bgcolor="#FFFFFF"class='bline'>ԭ�ļ���</td>
<td bgcolor="#FFFFFF"class='bline'>
<input name="filename" type="text" id="filename" style='width:450' value="<?php echo $myrow['url']?>">
<a href='<?php echo $myrow['url']?>' target='_blank'>[�鿴]</a>
</td>
</tr>
<?php 
if($myrow['mediatype']==1)
{
 	$fullfilename = $cfg_basedir.$myrow['url'];
 	if(file_exists($fullfilename)){
 		$info = "";
 		$sizes = getimagesize($fullfilename,$info);
 		if(is_array($sizes)){
 			if($sizes[0]>200) $w=200;
 			else $w = $sizes[0];
?>
<tr>
<td height="30" align="center" bgcolor="#FFFFFF"class='bline'>Ԥ����</td>
<td bgcolor="#FFFFFF"class='bline'>
<a href='<?php echo $myrow['url']?>' target='_blank'><img src='<?php echo $myrow['url']."?q=".mytime()?>' width='<?php echo $w?>' border='0' id='picview'></a>
</td>
</tr>
<?php  } } } ?>
<tr> 
<td height="25" align="center" bgcolor="#FFFFFF"class='bline'>
	�����ļ���
</td>
<td bgcolor="#FFFFFF"class='bline'>
<input name="upfile" type="file" id="upfile" style='width:300'>
</td>
</tr>
<tr> 
<td height="62" colspan="2" bgcolor="#FFFFFF"class='bline'>
<table width="60%" border="0" cellspacing="0" cellpadding="0">
<tr> 
<td align="center">
<input class="np" name="imageField" type="image" src="img/button_save.gif" width="60" height="22" border="0"> 
</td>
</tr>
</table>
</td>
</tr>
</form>
</table>
</td>
</tr>
</table>
</body>
</html>