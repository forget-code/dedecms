<?
require("config.php");
if(empty($imgurl)) $imgurl="";
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>����ͼƬ</title>
<link href="../base.css" rel="stylesheet" type="text/css">
<script>
function SeePic(img,f)
{
   if ( f.value != "" ) { img.src = f.value; }
}
</script>
</head>
<body bgcolor="#EAEBE7" leftmargin="0" topmargin="0">
<table width="290" border="0" cellspacing="0" cellpadding="0">
  <form name="form2" action="insertpictureok.php" method="POST" enctype="multipart/form-data">
  <tr> 
    <td height="25" colspan="2">&nbsp;&nbsp;�ϴ���ͼƬ</td>
  </tr>
  
  <tr> 
    <td colspan="2">&nbsp;&nbsp;ͼƬ����ܳ���200K</td>
  </tr>
  <tr> 
    <td colspan="2">&nbsp;&nbsp;<input name="pic" type="file" id="pic" size="15" onChange="SeePic(document.picview,document.form2.pic);"> &nbsp; <input type="button" name="Submit2" value="�� ��" onclick='if(document.form2.pic.value!="") document.form2.submit();'></td>
  </tr>
  <tr align="center"> 
    <td height="129" colspan="2"> 
      <table width="90%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="120" align="center"> 
            <fieldset>
           <legend></legend>
	   <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="120" align="center"><a href='javascript:SeePic(document.picview,document.form2.upic);'><img src='img/defdd.gif' width='150' height='100' border='0' name="picview"></a></td>
              </tr>
            </table>
	 </fieldset>
	</td>
        </tr>
      </table></td>
  </tr>
  </form>
</table>
</body>
</html>