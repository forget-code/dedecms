<?
require("config.php");
require("inc_makeart.php");

if(isset($isdd[0])) $isdd = $isdd[0];
else $isdd=0;

//��������
if(empty($artID))
{
	$conn = connectMySql();
	//--������յ�����--------------------
	$title = trim(cn_substr($title,100));
	$source = trim(cn_substr($source,50));
	$writer = trim(cn_substr($writer,50));
	$msg = cn_substr($shortmsg,500);
	
	if(!empty($stime))
		$stime = trim($stime);
	else
	{
		$stime = strftime("%Y-%m-%d",time());
	}
	
	$ishtml = $ishtml;
	$body = str_replace($base_url,"",$artbody);
	
	if(isset($redtitle[0])) $redtitle = $redtitle[0];
	else $redtitle=0;
	
	$adminid=$cuserLogin->getUserID();
	//---���·���ʱ��--------
	$dtime = strftime("%Y-%m-%d %H:%M:%S",time());
	
	
	//��ȡ����body�е�Զ��ͼƬ
	if(!empty($saveremoteimg))
	{
		$body = stripslashes($body);
		$img_array = array();
		preg_match_all("/(src|SRC)=[\"|'| ]{0,}(http:\/\/(.*)\.(gif|jpg|jpeg|bmp|png))/isU",$body,$img_array);
		$img_array = array_unique($img_array[2]);
		set_time_limit(0);
		$imgUrl = $img_dir."/".strftime("%Y%m%d",time());
		$imgPath = $base_dir.$imgUrl;
		$milliSecond = strftime("%H%M%S",time());
		if(!is_dir($imgPath)) @mkdir($imgPath,0777);
		foreach($img_array as $key =>$value)
		{
			$value = trim($value);
			$get_file = @file_get_contents($value);
			$rndFileName = $imgPath."/".$milliSecond.$key.".".substr($value,-3,3);
			$fileurl = $imgUrl."/".$milliSecond.$key.".".substr($value,-3,3);
			if($get_file)
			{
				$fp = @fopen($rndFileName,"w");
				@fwrite($fp,$get_file);
				@fclose($fp);
			}
			$body = ereg_replace($value,$fileurl,$body);
		}
		$body = addslashes($body);
	}
	
	//---���뵽���ݿ��SQL���-------------
	$inQuery = "
INSERT INTO dede_art(typeid,title,source,writer,rank,
stime,isdd,click,msg,redtitle,ismake,body,userid,spec)
 VALUES ('$typeid','$title','$source','$writer','$rank',
'$stime','0','0','$msg','$redtitle','0','$body','$adminid','0')";
	mysql_query($inQuery,$conn);
	$artID = mysql_insert_id($conn);
	if($rank==0)
	{
		$mr = new makeArt();
		$mr->makeArtDone($artID);
	}
	$rs = mysql_query("select typename from dede_arttype where ID=$typeid",$conn);
	$row = mysql_fetch_object($rs);
	$typename = $row->typename;
}
//��������ͼ
else
{
	$conn = connectMySql();
	$isdd="1";
	if(!isset($typeid))
	{
		$rs = mysql_query("select dede_art.typeid,dede_arttype.typename from dede_art left join dede_arttype on dede_arttype.ID=dede_art.typeid where dede_art.ID=$artID",$conn);
		$row = mysql_fetch_object($rs);
		$typename = $row->typename;
		$typeid = $row->typeid;
	}
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�ɹ���ʾ</title>
<link href="base.css" rel="stylesheet" type="text/css">
<script src="menu.js" language="JavaScript"></script>
<style>
.bt{border-left: 1px solid #FFFFFF; border-right: 1px solid #666666; border-top: 1px solid #FFFFFF; border-bottom: 1px solid #666666; background-color: #C0C0C0}
</style>
</head>
<body background="img/allbg.gif" leftmargin="6" topmargin="6">
<br>
 <?
	  if($isdd=="1")
	  {
	  ?>
<table width="411" border="0" cellpadding="1" cellspacing="1" bgcolor="#666666" align="center">
  <tr align="center"> 
    <td width="407" height="26" colspan="2" align="center" background='img/tbg.gif'><strong>�ϴ�����ͼƬ</strong></td>
  </tr>
  <tr bgcolor="#FFFFFF"> 
    <td height="141" colspan="2" align="center"> 
	  <table width="90%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td height="49">&nbsp;&nbsp;&nbsp;&nbsp;��ѡ���������ͼƬ���ţ�����������ϴ�һ������ͼ�Ա��Ժ�����ͼƬ�����б�����ר����ѡ�ã���ѱ���W��H--1:1����</td>
        </tr>
        <form action="add_lit_pic.php" name="form1" method="post" enctype="multipart/form-data">
          <input type="hidden" name="artID" value="<?=$artID?>">
          <input type="hidden" name="typeid" value="<?=$typeid?>">
          <input type="hidden" name="typename" value="<?=$typename?>">
		  <tr> 
            <td height="38">
            &nbsp; ͼƬ���:<input type="text" name="picw" value="200" size="4">
            �߶�:<input type="text" name="pich" value="200" size="4">
            </td>
           </tr>
		  <tr> 
            <td height="38">&nbsp; 
              <input type="file" name="litpic"> &nbsp;&nbsp; <input type="submit" name="Submit" value="�ύ"></td>
          </tr>
        </form>
        <tr>
          <td>&nbsp;&nbsp;&nbsp;&nbsp;����㲻���ϴ�����ͼ����ѡ�����²�����</td>
        </tr>
        <tr> 
          <td height="43">&nbsp;&nbsp;&nbsp;&nbsp; 
            <a href='add_news_view.php?typeid=<?=$typeid?>&typename=<?=$typename?>'>[<u>����������</u>]</a> &nbsp;&nbsp; <a href='list_news.php'>[<u>�����б�</u>]</a>&nbsp; 
            <a href='<?=$art_php_dir?>/viewart.php?artID=<?=$artID?>' target='_blank'>[<u>�鿴����</u>]</a>&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
<br>
<?
}
else
{
?>
<table width="409" border="0" cellpadding="1" cellspacing="1" bgcolor="#666666" align="center">
          <tr align="center"> 
            <td width="405" height="26" colspan="2" background='img/tbg.gif'><strong>���·����ɹ�!</strong></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            
          <td height="85" colspan="2" align="center"> ����: 
            <?=$title?>
            
      <p> <a href='add_news_view.php?typeid=<?=$typeid?>&typename=<?=$typename?>'>[<u>����������</u>]</a> 
        &nbsp;&nbsp; <a href='list_news.php'>[<u>�����б�</u>]</a>&nbsp; <a href='<?=$art_php_dir?>/viewart.php?artID=<?=$artID?>' target='_blank'>[<u>�鿴����</u>]</a>&nbsp; 
    </td>
          </tr>
      </table>
	  <?
	  }
	  ?>
</body>
<?
echo mysql_error();
?>
</html>