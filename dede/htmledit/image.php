<?
require_once("../config.php");
require_once("../inc_pic_resize.php");
if(empty($to_do_post)) $to_do_post="";
if(empty($imgwidthValue)) $imgwidthValue="";
if(empty($imgheightValue)) $imgheightValue="";
if(empty($urlValue)) $urlValue="";
if(empty($imgsrcValue)) $imgsrcValue="";
if(empty($imgurl)) $imgurl="";
if(empty($dd)) $dd="";
if($to_do_post=="yes")
{
	if(!eregi("\.(jpg|gif|png)$",$pic_name))
	{
		ShowMsg("���ͼƬ��ʽ���ϣ�ͼƬ����Ϊ��\\njpeg��gif��png�е�һ�֡�","");
	}
	else if($pic_size>500000)
	{
		ShowMsg("�������ϴ�����500K��ͼƬ��","");
	}
	else
	{
		$imgUrl = $img_dir."/".strftime("%Y%m%d",time());
		$imgPath = $base_dir.$imgUrl;
		$milliSecond = strftime("%H%M%S",time()).mt_rand(100,999);
		$rndFileName = $milliSecond;
		if(!is_dir($imgPath)) @mkdir($imgPath,0777);
		if(eregi("\.jpg$",$pic_name)) $shortName = ".jpg";
		else if(eregi("\.gif$",$pic_name)) $shortName = ".gif";
		else if(eregi("\.png$",$pic_name)) $shortName = ".png";
		else $shortName = ".jpg";
		if($dd=="yes")
		{
			
			pic_resize($pic,$imgPath."/".$rndFileName."lit".$shortName,$w,$h);
			$urlValue = $imgUrl."/".$rndFileName.$shortName;
			$imgsrcValue = $imgUrl."/".$rndFileName."lit".$shortName;
			$sizes = GetImageSize($imgPath."/".$rndFileName."lit".$shortName,&$info);
		}
		else
		{	
			$imgsrcValue = $imgUrl."/".$rndFileName.$shortName;
			$urlValue = $imgUrl."/".$rndFileName.$shortName;
			$sizes = GetImageSize($pic,&$info);
		}
		copy($pic,$imgPath."/".$rndFileName.$shortName);
		@unlink($pic);
		$imgwidthValue = $sizes[0];
		$imgheightValue = $sizes[1];
		ShowMsg("�ɹ��ϴ�һ��ͼƬ��","");
	}
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
var baseUrl;
baseUrl="<?=$imgurl?>";
function SeePic(img,f)
{
   if ( f.value != "" ) { img.src = f.value; }
}
function showPicList()
{
	window.open("../piclist.php", 'piclist', 'scrollbars=yes,resizable=no,width=500,height=400,left=50, top=50,screenX=0,screenY=0');
}
function ImageOK()
{
	var inImg,imgalign;
	if(document.form1.align.value!="0") imgalign=" align='"+document.form1.align.value+"'";
	else imgalign=" ";
	inImg = "<img src='"+ document.form1.imgsrc.value +"' width='"+ document.form1.imgwidth.value +"' height='"+ document.form1.imgheight.value +"' border='"+ document.form1.border.value +"' alt='"+ document.form1.alt.value +"'"+imgalign+">";
	if(document.form1.url.value!="") inImg = "<a href='"+ document.form1.url.value +"' target='_blank'>"+ inImg +"</a>\r\n";
	inImg = inImg.replace(" >",">");
	window.opener.doc.selection.createRange().pasteHTML(inImg);
	window.opener=true;
    window.close();
}
</script>
</HEAD>
<body bgcolor="#F2F4F3" leftmargin="4" topmargin="2">
<form enctype="multipart/form-data" name="form1" id="form1" method="post">
<input type="hidden" name="to_do_post" value="yes">
  <table width="100%" border="0">
    <tr height="20"> 
      <td colspan="3">
      <fieldset>
        <legend>ͼƬ����</legend>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="65" height="25" align="right">��ַ��</td>
            <td colspan="2"><input name="imgsrc" type="text" id="imgsrc" size="30" onChange="SeePic(document.form1.picview,document.form1.imgsrc);" value="<?=$imgsrcValue?>"> 
              &nbsp; <input onclick="showPicList();" type="button" name="Submit22" value="����ļ�"></td>
          </tr>
          <tr> 
            <td height="25" align="right">��ȣ�</td>
            <td colspan="2" nowrap> <input type="text"  id="imgwidth" name="imgwidth" size="8" value="<?=$imgwidthValue?>"> 
              &nbsp;&nbsp; �߶�: 
              <input name="imgheight" type="text" id="imgheight" size="8" value="<?=$imgheightValue?>"></td>
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
            <td nowrap><select name="align" id="align">
                <option value="0" selected>Ĭ��</option>
                <option value="right">�Ҷ���</option>
                <option value="align">�м�</option>
                <option value="left">�����</option>
                <option value="top">����</option>
                <option value="bottom">�ײ�</option>
              </select></td>
            <td align="center" nowrap><input onClick="ImageOK();" type="button" name="Submit2" value=" ȷ�� "> 
              <input type="button" name="Submit" onClick="window.close();" value=" ȡ�� "> 
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
            <td colspan="2" nowrap><input name="pic" type="file" id="pic" onChange="SeePic(document.form1.picview,document.form1.pic);" style="height:22"> 
              &nbsp; <input type="submit" name="picSubmit" id="picSubmit" value=" �� ��  " style="height:22"></td>
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
      <td height="140" colspan="2" nowrap> <table width="150" height="120" border="0" cellpadding="1" cellspacing="1" bgcolor="#333333">
          <tr> 
            <td align="center" bgcolor="#FFFFFF"><img name="picview" src="" width="140" height="110" alt="Ԥ��ͼƬ" style="background-color: #F5F8F3"></td>
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
