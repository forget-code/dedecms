<?
require("config.php");
if(empty($id)) $id="";
if(empty($ID)) $ID=$id;
$ID = ereg_replace("[^0-9]","",$ID);
if($ID=="") 
{
	echo "û����ID��!";
	exit();
}
$conn = connectMySql();
$rs = mysql_query("Select dede_art.title,dede_art.dtime,dede_art.stime,dede_art.rank,dede_arttype.typedir From dede_art left join dede_arttype on dede_art.typeid=dede_arttype.ID where dede_art.ID=$ID",$conn);
$row = mysql_fetch_object($rs);
$title = $row->title;
$arturl = getFileName($row->stime,$ID,$row->typedir,$row->rank);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�û�����</title>
<link href="../base.css" rel="stylesheet" type="text/css">
</head>
<body>
<table width="650" border="0" align="center" cellspacing="2">
  <tr> 
    <td><img src="img/feedback.gif" width="320" height="46"></td>
  </tr>
  <tr> 
    <td bgcolor="#CCCC99" height="6"></td>
  </tr>
  <tr>
    <td>�����ʾǰ100�����ۣ������<a href="<?=$arturl?>"><u>���ز鿴ԭ�ģ�<?=$title?></u></a></td>
  </tr>
  <tr> 
    <td> 
      <?
    $rs = mysql_query("select * from dede_feedback where artID=$ID And ischeck=1 order by ID desc limit 0,100",$conn);
    while($row = mysql_fetch_object($rs))
    {	
    ?>
      <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
        <tr bgcolor="#F7F7F7"> 
          <td width="23%">&nbsp;�����ˣ� 
            <?=$row->username?>
          </td>
          <td width="43%"> &nbsp;IP��ַ�� 
            <?=$row->ip?>
          </td>
          <td width="34%">&nbsp;ʱ�䣺 
            <?=$row->dtime?>
          </td>
        </tr>
        <tr align="center" bgcolor="#FFFFFF"> 
          <td height="28" colspan="3"> <table width="98%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td>
                  <?=$row->msg?>
                </td>
              </tr>
            </table></td>
        </tr>
      </table>
      <table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="3"></td>
        </tr>
      </table>
      <?
	  }
	  ?>
    </td>
  </tr>
  <tr> 
    <td bgcolor="#CCCC99" height="6"></td>
  </tr>
  <tr> 
    <td> <table width="100%" border="0" cellspacing="2">
        <form action="sendfeedback.php" method="post" name="feedback">
          <input type="hidden" name="artID" value="<?=$id?>">
          <tr> 
            <td>�û����� 
              <input name="username" type="text" id="username" size="10" class="nb">
              ��<a href="/member/reg.php" target="_blank"><u>��ע��</u></a>�� ���룺 
              <input name="pwd" type="text" id="pwd" size="10"  class="nb"> <input name="notuser[]" type="checkbox" id="notuser" value="1">
              �������� <a href='javascript:if(document.feedback.msg.value!="") document.feedback.submit(); else alert("�������ݲ���Ϊ�գ�");' class="coolbg" style="width:60">&nbsp;�������� 
              </a></td>
          </tr>
          <tr> 
            <td>�������ݣ�(���ܳ���120��)<br>
              ��ϵͳ���¼������IP�������ػ�����������߷��档</td>
          </tr>
          <tr> 
            <td><textarea name="msg" cols="70" rows="4" id="msg"></textarea></td>
          </tr>
        </form>
      </table></td>
  </tr>
</table>
	</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
