<?
require(dirname(__FILE__)."/../include/inc_vote.php");
if(empty($dopost)) $dopost = "";
if(empty($aid)) $aid="";
$aid = ereg_replace("[^0-9]","",$aid);
if($aid=="")
{
	ShowMsg("ûָ��ͶƱ��Ŀ��ID��","-1");
	exit();
}
$vo = new DedeVote($aid);
$rsmsg = "";
if($dopost=="send")
{
  if(!empty($voteitem)){
  	$rsmsg = "<br>&nbsp;�㷽�ŵ�ͶƱ״̬��".$vo->SaveVote($voteitem)."<br>";
  }
}
$vo->Close(); //����������ر������ݿ�
              //$vo�ǻ������õ�
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>ͶƱ���</title>
<link href="../base.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style2 { color: #CC0000;font-size: 11pt; }
-->
</style>
</head>
<body>
<table width="650" border="0" align="center" cellspacing="2">
  <tr> 
    <td><img src="img/vote.gif" width="320" height="46"></td>
  </tr>
  <tr> 
    <td bgcolor="#CCCC99" height="6"></td>
  </tr>
  <tr>
    <td height="28">
    	<span class="style2">&nbsp;ͶƱ���ƣ�<?=$vo->VoteInfos['votename']?></span>
    	<?=$rsmsg?>
    </td>
  </tr>
  <tr>
    <td bgcolor="#F0F2EA">&nbsp;�������ͶƱ����������<?=$vo->VoteInfos['totalcount']?></td>
  </tr>
  <tr>
    <td bgcolor="#DFEAE4">&nbsp;ͶƱ�����</td>
  </tr>
  <tr> 
    <td> 
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="3"></td>
        </tr>
		   <tr>
          <td height="100" align="center" valign="top">
          <?
          echo $vo->GetVoteResult("98%",30,"30%");
          ?>
          
      </td>
        </tr>
		    <tr>
          <td height="3"></td>
        </tr>
      </table> 
    </td>
  </tr>
  <tr> 
    <td bgcolor="#CCCC99" height="6"></td>
  </tr>
  <tr> 
    <td align="center" height="30">
    	<a href="http://www.dedecms.com" target="_blank">Power by DedeCms ֯�����ݹ���ϵͳ</a>
    </td>
  </tr>
</table>
	</td>
  </tr>
  <tr>
    <td height="20">&nbsp;</td>
  </tr>
</table>
</body>
</html>
