<?
require("config.php");
if(empty($typeids)) $typeids="";
if($typeids=="") exit();
$typeids = ereg_replace(",$","",trim($typeids));
$typeids = split(",",$typeids);
$ids = "";
foreach($typeids as $typeid)
{
	list($ID,$typename)=split("`",$typeid);
	$ids.=$ID."`";
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>��̬���б�</title>
<style type="text/css">
body {background-image: url(img/allbg.gif);}
</style>
<link href="base.css" rel="stylesheet" type="text/css">
</head>
<body topmargin="8">
<table width="98%"  border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#666666">
  <tr>
    <td width="100%" height="24" colspan="2" background="img/tbg.gif">
    &nbsp;<a href="list_type.php"><u>Ƶ������</u></a>&gt;&gt;��̬���б�
    </td>
  </tr>
  <tr>
    <td height="200" colspan="2" valign="top" bgcolor="#FFFFFF"> 
      <form name="form1" method="post" action="make_list.php">
	    <table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr> 
            <td colspan="2" height="12"></td>
          </tr>
          <tr> 
            <td height="25" colspan="2" bgcolor="#F2F8FB">
            ����û��Ѿ�ָ��Ϊ��ʹ�ö�̬�б�ҳ������Ŀ�����ᱻ����ΪHTML�� 
              <input name="typeid" type="hidden" id="typeid" value="<?=$ids?>">
              <input name="job" type="hidden" id="job" value="setlist">
              </td>
          </tr>
          <tr> 
            <td width="21%" height="25">��ѡ�����Ŀ�ǣ�</td>
            <td width="79%">
            <?
            foreach($typeids as $typeid)
			{
				list($ID,$typename)=split("`",$typeid);
				echo "$typename($ID),";
			}
            ?>
            </td>
          </tr>
          <tr> 
            <td height="30">��ϣ���Ĺ鵵��ʽ��</td>
            <td> <input name="actype" type="radio" value="acdefault" class="np" checked>
              ��ϵͳĬ�ϵķ�ʽ 
              <input type="radio" name="actype" value="actime"  class="np">
              ֻ�鵵�ض�ʱ�����ڵ��ĵ�</td>
          </tr>
          <tr> 
            <td height="30">���ݵķ���ʱ�䣺</td>
            <td>ֻ�鵵�� 
              <input name="starttime" type="text" id="starttime" size="20" value="<?=strftime("%Y-%m-%d",time())?>">
              ����ļ�</td>
          </tr>
          <tr> 
            <td height="74">&nbsp;</td>
            <td> <input type="submit" name="Submit" value="��ʼ����HTML"> �� 
              <input name="Submit11" type="button" id="Submit11" value="-������-" onClick="history.go(-1);"></td>
          </tr>
        </table>
	  </form>
	  </td>
  </tr>
</table>
</body>
</html>