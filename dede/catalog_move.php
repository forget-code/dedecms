<?php 
require_once("config.php");
CheckPurview('t_Move');
require_once(dirname(__FILE__)."/../include/inc_typelink.php");
if(empty($typeid)) $typeid="";
if(empty($job)) $job="movelist";
$typeid = ereg_replace("[^0-9]","",$typeid);
$dsql = new DedeSql(false);
$row  = $dsql->GetOne("Select reID,typename,channeltype From #@__arctype where ID='$typeid'");
$typename = $row['typename'];
$reID = $row['reID'];
$channelid = $row['channeltype'];
//�ƶ���Ŀ
//------------------
if($job=="moveok")
{
	if($typeid==$movetype)
	{
		$dsql->Close();
		ShowMsg("�ƶԶ����Ŀ��λ����ͬ��","catalog_main.php");
	  exit();
	}
	if(IsParent($movetype,$typeid,$dsql))
	{
		$dsql->Close();
		ShowMsg("���ܴӸ����ƶ������࣡","catalog_main.php");
	  exit();
	}
	$dsql->SetQuery("Update #@__arctype set reID='$movetype' where ID='$typeid'");
	$dsql->ExecuteNoneQuery();
	$dsql->Close();
	//�������β˵�
   $rndtime = time();
   $rflwft = "<script language='javascript'>
   if(window.navigator.userAgent.indexOf('MSIE')>=1){
     if(top.document.frames.menu.location.href.indexOf('catalog_menu.php')>=1)
     { top.document.frames.menu.location = 'catalog_menu.php?$rndtime'; }
   }else{
  	 if(top.document.getElementById('menu').src.indexOf('catalog_menu.php')>=1)
     { top.document.getElementById('menu').src = 'catalog_menu.php?$rndtime'; }
   }
   </script>";
   echo $rflwft;
	ShowMsg("�ɹ��ƶ�Ŀ¼��","catalog_main.php");
	exit();
}
function IsParent($myid,$topid,$dsql)
{
	$row = $dsql->GetOne("select ID,reID from #@__arctype where ID='$myid'");
	if($row['reID']==$topid) return true;
	else if($row['reID']==0) return false;
	else return IsParent($row['reID'],$topid,$dsql);
}
///////////////////////////////////////////////////


$tl = new TypeLink($typeid);
$typeOptions = $tl->GetOptionArray(0,0,$channelid);
$tl->Close();
$dsql->Close();

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�ƶ��б�</title>
<style type="text/css">
body {background-image: url(img/allbg.gif);}
</style>
<link href="base.css" rel="stylesheet" type="text/css">
</head>
<body topmargin="8">
<table width="98%"  border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#98CAEF">
  <tr>
    <td width="100%" height="24" colspan="2" background="img/tbg.gif">
    &nbsp;<a href="catalog_main.php"><u>��Ŀ����</u></a>&gt;&gt;�ƶ��б�
    </td>
  </tr>
  <tr>
    <td height="200" colspan="2" valign="top" bgcolor="#FFFFFF"> 
      <form name="form1" method="get" action="catalog_move.php">
      <input name="typeid" type="hidden" id="typeid" value="<?php echo $typeid?>">
      <input name="job" type="hidden" id="job" value="moveok">
	    <table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr> 
            <td colspan="2" height="12"></td>
          </tr>
          <tr> 
            <td height="25" colspan="2" bgcolor="#F2F8FB">
            &nbsp;�ƶ�Ŀ¼ʱ����ɾ��ԭ���Ѵ������б��ƶ��������¶���Ŀ����HTML�� 
            </td>
          </tr>
          <tr> 
            <td width="30%" height="25">��ѡ�����Ŀ�ǣ�</td>
            <td width="70%">
            <?php 
			echo "$typename($typeid)";
            ?>
            </td>
          </tr>
          <tr> 
            <td height="30">��ϣ���ƶ����Ǹ���Ŀ��</td>
            <td>
            <select name="movetype">
              <option value='0'>�ƶ�Ϊ������Ŀ</option>
              <?php echo $typeOptions?>
             </select>
            </td>
          </tr>
          <tr> 
            <td height="25" colspan="2" bgcolor="#F2F8FB">
            &nbsp;������Ӹ����ƶ����Ӽ�Ŀ¼��ֻ�����Ӽ������߼���ͬ����ͬ�����������
             </td>
          </tr>
          <tr> 
            <td height="74">&nbsp;</td>
            <td>
            <input type="submit" name="Submit" value="ȷ������" class='nbt'> �� 
            <input name="Submit11" type="button" id="Submit11" value="-������-" onClick="history.go(-1);" class='nbt'>
            </td>
          </tr>
        </table>
	  </form>
	  </td>
  </tr>
</table>
</body>
</html>