<?
require("config.php");
if(!isset($typename)) $typename="";
if(!isset($typedir)) $typedir="";
if(!isset($body)) $body="";
if(isset($addhome))
{
	$typename = "��վ��ҳ";
	$typedir = "index.html";
	$fp = fopen($base_dir.$mod_dir."/index.htm","r");
	$body = fread($fp,filesize($base_dir.$mod_dir."/index.htm"));
	fclose($fp);
}
if($cuserLogin->getUserChannel()>0)
{
	if(!isset($ID)) $ID=$cuserLogin->getUserChannel();
}
if(isset($ID))
{
	$conn = connectMySql();
	$rs = mysql_query("Select * from dede_arttype where ID=$ID",$conn);
	$row = mysql_fetch_object($rs);
	$dfname = $row->defaultname;
	$typedir = $art_dir."/".$row->typedir."/".$dfname;
	$typename = "��Ŀ��".$row->typename;
	$modname = $base_dir.$mod_dir."/".$row->modname."/part.htm";
	$fp = fopen($modname,"r");
	$body = fread($fp,filesize($modname));
	fclose($fp);
}
else
{
	$ID="0";
}
?>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
<title>��վ������</title>
<link href='base.css' rel='stylesheet' type='text/css'>
</head>
<body background='img/allbg.gif' leftmargin='8' topmargin='8'>
<table width="99%" border="0" cellpadding="3" cellspacing="1" bgcolor="#666666">
  <tr>
    <td height="19" background='img/tbg.gif'>&nbsp;<strong>��վ������&nbsp;&nbsp;[<a href="make_part.php?job=all"><u>�������а��</u></a>]</strong></td>
</tr>
<tr>
    <td height="94" bgcolor="#FFFFFF"> 
      <table width="98%" border="0" cellspacing="2" cellpadding="0">
        <tr bgcolor="#CCCC99"> 
          <td colspan="3"> &nbsp;<b>���ģ�����</b></td>
        </tr>
        <form name="form2">
          <tr> 
            <td colspan="3" height="40"> ģ�壺 
              <select name="sel">
                <option value='0'>----��ѡ��----</option>
                <?
          $conn = connectMySql();
          if($cuserLogin->getUserChannel()<=0)
			$typeCallLimit = "";
		else
			$typeCallLimit = " where typeid=".$cuserLogin->getUserChannel();
          $rs = mysql_query("Select ID,pname,fname From dede_partmode $typeCallLimit",$conn);
          while($row=mysql_fetch_object($rs))
          {
          	$ID = $row->ID;
          	$pname = $row->pname;
          	echo "<option value='$ID'>$pname</option>\r\n";
          }
          ?>
              </select> &nbsp; <input type="button" name="s1" value="Ԥ��" onClick="window.open('web_type_webtest.php?ID='+document.form2.sel.value+'&job=view');"> 
              &nbsp; <input type="button" name="s3" value="ɾ��" onClick="location.href='web_type_webtest.php?ID='+document.form2.sel.value+'&job=del';"> 
              &nbsp; <input type="button" name="s4" value="�༭" onClick="location.href='web_type_webtest.php?ID='+document.form2.sel.value+'&job=edit';"> 
              &nbsp; <input type="button" name="s2" value="����HTML" onClick="location.href='web_type_webtest.php?ID='+document.form2.sel.value+'&job=make';"> 
            </td>
          </tr>
        </form>
        <form action="web_type_webupload.php" method="POST" name="upfrom">
          <input name="typeid" type="hidden" value="<?=$ID?>">
          <tr bgcolor="#CCCC99"> 
            <td colspan="3"> &nbsp;<b>�ϴ��µ��Զ�����ģ�壺</b><a name="up"></a></td>
          </tr>
          <tr> 
            <td colspan="3" bgcolor="#FAFCF3">��վ��齨��ȫ���Ը�Ŀ¼Ϊ����·���������ɺ��ϴ������ݿ��С�</td>
          </tr>
          <tr> 
            <td height="30" colspan="3">���ģ�����ƣ� 
              <input name="pname" type="text" id="pname" size="18" value="<?=$typename?>">
              Ҫ���ɵ��ļ��� 
              <?
              if($typedir=="") $typedir=@ereg_replace("^/","",$index_url)."/your_file.html";
              ?>
              <input name="fname" type="text" id="fname" size="35" value="<?=$typedir?>"> 
            </td>
          </tr>
          <tr> 
            <td width="12%" height="22">ģ�����ݣ�</td>
            <td width="71%">(���鸴��HTML��DW��Frontpage�б༭)&nbsp;</td>
            <td width="17%"><input type="submit" name="Submit" value=" �ύ "></td>
          </tr>
          <tr align="center"> 
            <td height="40" colspan="3">
            <textarea name="body" cols="70" rows="15" id="body"><?=$body?></textarea> 
            </td>
          </tr>
        </form>
        <form name="mycode" action="make_part_test.php" target="_blank" method="post">
          <tr bgcolor="#FFFFFF"> 
            <td colspan="3">&nbsp;</td>
          </tr>
          <tr bgcolor="#CCCC99">
            <td colspan="3"><b>����ο���<a href="web_mode.php#part"><u>����ϸ��˵��&gt;&gt;&gt;</u></a></b></td>
          </tr>
          <tr> 
            <td height="34" colspan="3">���Դ��룺 
            <textarea name="testcode" cols="56" rows="4" id="testcode"></textarea>
              ��
              <input type="submit" name="Submit2" value="ȷ������"> </td>
          </tr>
        </form>
        <tr> 
          <td height="40" colspan="3"><?include("parthelp.html");?></td>
        </tr>
      </table> </td>
</tr>
</table>
</body>
</html>