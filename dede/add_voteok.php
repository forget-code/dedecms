<?
require_once("config.php");
require_once("inc_vote.php");
$votetable="";
$votecode="";
$votename = ereg_replace("[\\/\*\?:<>\|'\"]","",trim($votename));
$votedir = $base_dir.$art_php_dir."/vote";
if(!is_dir($votedir)) @mkdir($votedir,0777);
$filename = $votedir."/".$votename.".dat";
if(file_exists($filename))
{
	echo "<script>alert('����ͬ����Ŀ������ɾ�������Ŀ\\n\\n�����һ�����ơ�');\r\nhistory.go(-1);</script>\r\n";
	exit();
}
$items = "";
$j=1;
for($i=1;$i<10;$i++)
{
	if(isset(${"voteitem".$i}))
	{
		$items.=$j.">0>".str_replace(">","",trim(${"voteitem".$i}))."\r\n";
		$j++;
	}
}
if($j<3)
{
	echo "<script>alert('����Ҫ������ͶƱѡ�');\r\nhistory.go(-1);</script>\r\n";
	exit();
}
$items = "0>0>".strftime("%Y-%m-%d",time())."\r\n".trim($items);
$fp = fopen($filename,"w") or die("�����ļ���".$filename."ʧ�ܡ�");
fwrite($fp,$items);
fclose($fp);
$vo = new DedeVote();
$vo->SetVote($votename);
$votetable =  $vo->GetVoteForm();
$votecode = "{dede:vote name='$votename'/}";
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�ɹ���ʾ</title>
<style>
.bt{border-left: 1px solid #FFFFFF; border-right: 1px solid #666666; border-top: 1px solid #FFFFFF; border-bottom: 1px solid #666666; background-color: #C0C0C0}
td {font-size: 9pt;line-height: 1.5;}
body {font-size: 9pt;line-height: 1.5;}
a:link { font-size: 9pt; color: #000000; text-decoration: none }
a:visited{ font-size: 9pt; color: #000000; text-decoration: none }
a:hover {color: red;background-color:yellow}
</style>
</head>
<body background="img/allbg.gif" leftmargin="6" topmargin="6">
<table width="80%" border="0" cellpadding="1" cellspacing="1" bgcolor="#666666" align="center">
  <tr align="center">
    <td height="26" colspan="2" background='img/tbg.gif'><strong>�ɹ�����һ��ͶƱ</strong></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="85" colspan="2" align="center">
      <table width="100%" border="0" cellspacing="4" cellpadding="4">
        <tr>
          <td width="22%" height="44">�����룺</td>
          <td width="78%"><textarea name="ta1" cols="40" rows="2" id="ta1"><?=$votecode?>
</textarea></td>
        </tr>
        <tr>
          <td height="59">ͶƱ����</td>
          <td><table width="180" border="0" cellspacing="1" cellpadding="1">
              <tr>
                <td><?=$votetable?></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td height="59">��HTML��</td>
          <td><textarea name="ta2" cols="40" rows="5" id="ta2"><?=$votetable?>
</textarea></td>
        </tr>
        <tr align="center" bgcolor="#E8FAE7">
          <td height="24" colspan="2"><a href="add_vote.php"><u>&lt;&lt;����ͶƱ&gt;&gt;</u></a>��<a href="add_vote_new.php"><u>&lt;&lt;����ͶƱ&gt;&gt;</u></a></td>
        </tr>
    </table></td>
  </tr>
</table>
</body>
</html>