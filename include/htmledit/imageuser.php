<?
require_once(dirname(__FILE__)."/../dialoguser/config.php");
require_once(dirname(__FILE__)."/../inc_photograph.php");
if(empty($dopost)) $dopost="";
if(empty($imgwidthValue)) $imgwidthValue=400;
if(empty($imgheightValue)) $imgheightValue=300;
if(empty($urlValue)) $urlValue="";
if(empty($imgsrcValue)) $imgsrcValue="";
if(empty($imgurl)) $imgurl="";
if(empty($dd)) $dd="";
if($dopost=="upload")
{
	if(empty($imgfile)) $imgfile="";
	if(!is_uploaded_file($imgfile)){
		 ShowMsg("��û��ѡ���ϴ����ļ�!","-1");
	   exit();
	}
	if(ereg("^text",$imgfile_type)){
		ShowMsg("�������ı����͸���!","-1");
		exit();
	}
	if($imgfile_size > $cfg_mb_upload_size*1024){
	   @unlink(is_uploaded_file($imgfile));
		 ShowMsg("���ϴ����ļ�������{$cfg_mb_upload_size}K���������ϴ���","-1");
		 exit();
	}
	if(!eregi("\.(jpg|gif|png|bmp)$",$imgfile_name)){
		ShowMsg("�����ϴ����ļ����ͱ���ֹ��","-1");
		exit();
	}
	CheckUserSpace($cfg_ml->M_ID);
	$sparr = Array("image/pjpeg","image/jpeg","image/gif","image/png","image/x-png","image/wbmp");
  $imgfile_type = strtolower(trim($imgfile_type));
  if(!in_array($imgfile_type,$sparr)){
		ShowMsg("�ϴ���ͼƬ��ʽ������ʹ��JPEG��GIF��PNG��WBMP��ʽ������һ�֣�","-1");
		exit();
	}
	$nowtime = mytime();
	$savepath = $cfg_user_dir."/".$cfg_ml->M_ID."/".strftime("%y%m",$nowtime);
  CreateDir($savepath);
  $rndname = dd2char(strftime("%d%H%M%S",$nowtime).$cfg_ml->M_ID.mt_rand(1000,9999));
	$filename = $savepath."/".$rndname;
	CloseFtp();
	$fs = explode(".",$imgfile_name);
	if(eregi("php|asp|pl|shtml|jsp|cgi",$fs[count($fs)-1])){
		exit();
	}
	$bfilename = $filename.".".$fs[count($fs)-1];
	$litfilename = $filename."_lit.".$fs[count($fs)-1];
	$rndname  = $rndname.$fs[count($fs)-1];
  $fullfilename = $cfg_basedir.$bfilename;
  $full_litfilename = $cfg_basedir.$litfilename;
  if(file_exists($fullfilename)){
  	ShowMsg("��Ŀ¼�Ѿ�����ͬ�����ļ�������ģ�","-1");
		exit();
  }
  @move_uploaded_file($imgfile,$fullfilename);
	$dsql = new DedeSql(false);
	if($dd=="yes")
	{
			copy($fullfilename,$full_litfilename);
			if(in_array($imgfile_type,$cfg_photo_typenames)) ImageResize($full_litfilename,$w,$h);
			$urlValue = $bfilename;
			$imgsrcValue = $litfilename;
			$info = "";
			$sizes = getimagesize($full_litfilename,$info);
			$imgwidthValue = $sizes[0];
	    $imgheightValue = $sizes[1];
	    $imgsize = filesize($full_litfilename);
	    $inquery = "
       INSERT INTO #@__uploads(title,url,mediatype,width,height,playtime,filesize,uptime,adminid,memberid) 
       VALUES ('�Ի������ϴ� {$rndname} ��Сͼ','$imgsrcValue','1','$imgwidthValue','$imgheightValue','0','{$imgsize}','{$nowtime}','0','".$cfg_ml->M_ID."');
     ";
     $dsql->ExecuteNoneQuery($inquery);
	}else{	
		$imgsrcValue = $bfilename;
		$urlValue = $bfilename;
		$info = "";
		$sizes = getimagesize($fullfilename,$info);
		$imgwidthValue = $sizes[0];
	  $imgheightValue = $sizes[1];
	  $imgsize = filesize($fullfilename);
	}
	$bsizes = getimagesize($fullfilename,$info);
  $bimgwidthValue = $bsizes[0];
	$bimgheightValue = $bsizes[1];
	$bimgsize = filesize($fullfilename);
	$inquery = "
    INSERT INTO #@__uploads(title,url,mediatype,width,height,playtime,filesize,uptime,adminid,memberid) 
    VALUES ('�Ի������ϴ���ͼƬ','$bfilename','1','$bimgwidthValue','$bimgheightValue','0','{$bimgsize}','{$nowtime}','0','".$cfg_ml->M_ID."');
   ";
  $dsql->ExecuteNoneQuery($inquery);
  $dsql->Close();
	if(in_array($imgfile_type,$cfg_photo_typenames)) WaterImg($fullfilename,'up');
	$kkkimg = $urlValue;
	$imgwidthValue = $sizes[0];
	$imgheightValue = $sizes[1];
}
?>
<HTML>
<HEAD>
<title>����ͼƬ</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<style>
td{font-size:10pt;}
</style>
<script language=javascript>
function SeePic(img,f)
{
   if ( f.value != "" ) { img.src = f.value; }
}
function ImageOK()
{
	var inImg,ialign,iurl,imgwidth,imgheight,ialt,isrc,iborder;
	ialign = document.form1.ialign.value;
	iborder = document.form1.border.value;
	imgwidth = document.form1.imgwidth.value;
	imgheight = document.form1.imgheight.value;
	ialt = document.form1.alt.value;
	isrc = document.form1.imgsrc.value;
	iurl = document.form1.url.value;
	if(ialign!=0) ialign = " align='"+ialign+"'";
	inImg  = "<img src='"+ isrc +"' width='"+ imgwidth;
	inImg += "' height='"+ imgheight +"' border='"+ iborder +"' alt='"+ ialt +"'"+ialign+"/>";
	if(iurl!="") inImg = "<a href='"+ iurl +"' target='_blank'>"+ inImg +"</a>\r\n";
	window.returnValue = inImg;
  window.close();
}
function SelectMedia(fname)
{
   var posLeft = window.event.clientY-100;
   var posTop = window.event.clientX-400;
   window.open("../dialoguser/select_images.php?f="+fname+"&imgstick=big", "popUpImgWin", "scrollbars=yes,resizable=yes,statebar=no,width=600,height=400,left="+posLeft+", top="+posTop);
}
function UpdateImageInfo()
{
	var imgsrc = document.form1.imgsrc.value;
	if(imgsrc!="")
	{
	  var imgObj = new Image();
	  imgObj.src = imgsrc;
	  document.form1.himgheight.value = imgObj.height;
	  document.form1.himgwidth.value = imgObj.width;
	  document.form1.imgheight.value = imgObj.height;
	  document.form1.imgwidth.value = imgObj.width;
  }
}
function UpImgSizeH()
{
   var ih = document.form1.himgheight.value;
   var iw = document.form1.himgwidth.value;
   var iih = document.form1.imgheight.value;
   var iiw = document.form1.imgwidth.value;
   if(ih!=iih && iih>0 && ih>0 && document.form1.autoresize.checked)
   {
      document.form1.imgwidth.value = Math.ceil(iiw * (iih/ih));
   }
}
function UpImgSizeW()
{
   var ih = document.form1.himgheight.value;
   var iw = document.form1.himgwidth.value;
   var iih = document.form1.imgheight.value;
   var iiw = document.form1.imgwidth.value;
   if(iw!=iiw && iiw>0 && iw>0 && document.form1.autoresize.checked)
   {
      document.form1.imgheight.value = Math.ceil(iih * (iiw/iw));
   }
}
</script>
<link href="base.css" rel="stylesheet" type="text/css">
<base target="_self">
</HEAD>
<body bgcolor="#EBF6CD" leftmargin="4" topmargin="2">
<form enctype="multipart/form-data" name="form1" id="form1" method="post">
<input type="hidden" name="dopost" value="upload">
<input type="hidden" name="himgheight" value="<?=$imgheightValue?>">
<input type="hidden" name="himgwidth" value="<?=$imgwidthValue?>">
  <table width="100%" border="0">
    <tr height="20"> 
      <td colspan="3">
      <fieldset>
        <legend>ͼƬ����</legend>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="65" height="25" align="right">��ַ��</td>
            <td colspan="2">
            	<input name="imgsrc" type="text" id="imgsrc" size="30" onChange="SeePic(document.form1.picview,document.form1.imgsrc);" value="<?=$imgsrcValue?>">
              <input onClick="SelectMedia('form1.imgsrc');" type="button" name="selimg" value=" ������... " class="binput" style="width:80"> 
            </td>
          </tr>
          <tr> 
            <td height="25" align="right">��ȣ�</td>
            <td colspan="2" nowrap>
            	<input type="text"  id="imgwidth" name="imgwidth" size="8" value="<?=$imgwidthValue?>" onChange="UpImgSizeW()"> 
              &nbsp;&nbsp; �߶�: 
              <input name="imgheight" type="text" id="imgheight" size="8" value="<?=$imgheightValue?>" onChange="UpImgSizeH()">
              <input type="button" name="Submit" value="ԭʼ" class="binput" style="width:40" onclick="UpdateImageInfo()">
              <input name="autoresize" type="checkbox" id="autoresize" value="1" checked>
              ����Ӧ
              </td>
          </tr>
          <tr> 
            <td height="25" align="right">�߿�</td>
            <td colspan="2" nowrap><input name="border" type="text" id="border" size="4" value="0"> 
              &nbsp;�������: 
              <input name="alt" type="text" id="alt" size="10"></td>
          </tr>
          <tr> 
            <td height="25" align="right">���ӣ�</td>
            <td width="166" nowrap><input name="url" type="text" id="url" size="30"   value="<?=$urlValue?>"></td>
            <td width="155" align="center" nowrap>&nbsp;</td>
          </tr>
		  <tr>
            <td height="25" align="right">���룺</td>
            <td nowrap><select name="ialign" id="ialign">
                <option value="0" selected>Ĭ��</option>
                <option value="right">�Ҷ���</option>
                <option value="center">�м�</option>
                <option value="left">�����</option>
                <option value="top">����</option>
                <option value="bottom">�ײ�</option>
              </select></td>
            <td align="center" nowrap><input onClick="ImageOK();" type="button" name="Submit2" value=" ȷ�� " class="binput"> 
              <input type="button" name="Submit" onClick="window.close();" value=" ȡ�� " class="binput"> 
            </td>
          </tr>
        </table>
        </fieldset>
        </td>
    </tr>
    <tr height="25"> 
      <td colspan="3" nowrap> <fieldset>
        <legend>�ϴ���ͼƬ</legend>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr height="30"> 
            <td align="right" nowrap>����ͼƬ��</td>
            <td colspan="2" nowrap><input name="imgfile" type="file" id="imgfile" onChange="SeePic(document.form1.picview,document.form1.imgfile);" style="height:22" class="binput"> 
              &nbsp; <input type="submit" name="picSubmit" id="picSubmit" value=" �� ��  " style="height:22" class="binput"></td>
          </tr>
          <tr height="30"> 
            <td align="right" nowrap>��ѡ���</td>
            <td colspan="2" nowrap>
			<input type="checkbox" name="dd" value="yes">��������ͼ
				&nbsp;
			����ͼ���
              <input name="w" type="text" value="160" size="3">
		   ����ͼ�߶�
              <input name="h" type="text" value="120" size="3">
			</td>
          </tr>
        </table>
        </fieldset></td>
    </tr>
    <tr height="50"> 
      <td height="140" align="right" nowrap>Ԥ����:</td>
      <td height="140" colspan="2" nowrap>
	  <table width="150" height="120" border="0" cellpadding="1" cellspacing="1">
          <tr> 
            <td align="center"><img name="picview" src="img/picview.gif" width="160" height="120" alt="Ԥ��ͼƬ"></td>
          </tr>
        </table>
        <script language="JavaScript">
		if(document.form1.imgsrc.value!="")
		{
			SeePic(document.form1.picview,document.form1.imgsrc);
		}
		</script> </td>
    </tr>
  </table>
</form>
</body>
</HTML>
