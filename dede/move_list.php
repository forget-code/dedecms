<?
require_once("config.php");
require_once("inc_typelink.php");
if(empty($typeid)) $typeid="";
if(empty($job)) $job="movelist";
if($typeid=="") exit();
list($ID,$typename)=split("`",$typeid);
$tl = new typeLink();
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
<table width="98%"  border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#666666">
  <tr>
    <td width="100%" height="24" colspan="2" background="img/tbg.gif">
    &nbsp;<a href="list_type.php"><u>Ƶ������</u></a>&gt;&gt;�ƶ��б�
    </td>
  </tr>
  <tr>
    <td height="200" colspan="2" valign="top" bgcolor="#FFFFFF"> 
      <form name="form1" method="get" action="move_listok.php">
	    <table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr> 
            <td colspan="2" height="12"></td>
          </tr>
          <tr> 
            <td height="25" colspan="2" bgcolor="#F2F8FB">
            &nbsp;�ƶ�Ŀ¼ʱ����ɾ��ԭ���Ѵ������б��ƶ��������¶���Ŀ����HTML�� 
              <input name="typeid" type="hidden" id="typeid" value="<?=$ID?>">
              <input name="job" type="hidden" id="job" value="<?=$job?>">
              </td>
          </tr>
          <tr> 
            <td width="30%" height="25">��ѡ�����Ŀ�ǣ�</td>
            <td width="70%">
            <?
			echo "$typename($ID)";
            ?>
            </td>
          </tr>
          <tr> 
            <td height="30">��ϣ��<?if($job=="movelist") echo "�ƶ�"; else echo "�ϲ�";?>���Ǹ���Ŀ��</td>
            <td>
            <select name="gototype">
                <option value='0'>�ƶ�Ϊ������Ŀ</option>
                <?
				if($cuserLogin->getUserChannel()<=0)
					$tl->GetOptionArray();
				else
					$tl->GetOptionArray(0,$cuserLogin->getUserChannel());
				?>
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
            <input type="submit" name="Submit" value="ȷ������"> �� 
            <input name="Submit11" type="button" id="Submit11" value="-������-" onClick="history.go(-1);">
            </td>
          </tr>
        </table>
	  </form>
	  </td>
  </tr>
</table>
</body>
</html>