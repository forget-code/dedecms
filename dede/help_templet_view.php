<?
require_once(dirname(__FILE__)."/config.php");
?>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
<title>ģ�����ο�--�ĵ�ģ����</title>
<link href='base.css' rel='stylesheet' type='text/css'>
<style type="text/css">
<!--
.style2 {color: #CC0000}
.style4 {color: #0000FF}
.style5 {color: #3300FF}
.style6 {
	color: #FF0000;
	font-weight: bold;
}
.style7 {color: #993300}
-->
</style>
</head>
<body background='img/allbg.gif' leftmargin='8' topmargin='8'>
<table width="99%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#666666">
<tr>
    <td height="19" background="img/tbg.gif"><b>ģ�����ο�--�ĵ�ģ����</b></td>
</tr>
<tr>
<td bgcolor="#FFFFFF" valign="top">
<table width="98%" border="0" cellspacing="2">
        <tr> 
          <td height="44" colspan="3" bgcolor="#FFFFFF">�ĵ�ģ����ָ�ĵ��鿴ҳ��ģ�壬���� cmspath/templets/article_*.htm<br>
            <font color="#FF0000">�༭ģ��ʱ�����ڣȣԣͣ�ģʽ����ģ����롣 </font></td>
        </tr>
        <tr> 
          <td colspan="3" bgcolor="#F9FBF0">�����ĵ���ǰλ��<a name="1"></a></td>
        </tr>
        <tr> 
          <td height="46" colspan="3">{dede:field name='position'/}</td>
        </tr>
        <tr> 
          <td colspan="3" bgcolor="#F9FBF0">�����ĵ��ֶ�ֵ<a name="2"></a></td>
        </tr>
        <tr> 
          <td height="59" colspan="3">{dede:field name='�ֶ�����'/} <br>
            �ֶ�������ָ archives ������и��ӱ���ֶ���Ϣ��</td>
        </tr>
        <tr> 
          <td colspan="3" bgcolor="#F9FBF0">�������������<a name="3"></a></td>
        </tr>
        <tr> 
          <td height="46" colspan="3">&lt;script src=&quot;{dede:field name='phpurl'/}/count.php?aid={dede:field 
            name='ID'/}&quot; language=&quot;javascript&quot;&gt;&lt;/script&gt; 
          </td>
        </tr>
        <tr> 
          <td colspan="3" bgcolor="#F9FBF0">����������������<a name="4"></a></td>
        </tr>
        <tr> 
          <td height="45" colspan="3">&lt;script src=&quot;{dede:field name='phpurl'/}/feedback_js.php?arcID={dede:field 
            name='ID'/}&quot; language=&quot;javascript&quot;&gt;&lt;/script&gt; 
          </td>
        </tr>
        <tr> 
          <td colspan="3" bgcolor="#F9FBF0">���������Ƽ�����<a name="5"></a></td>
        </tr>
        <tr> 
          <td height="53" colspan="3">&lt;a href=&quot;{dede:field name='phpurl'/}/recommend.php?arcID={dede:field 
            name=ID/}&quot;&gt;&lt;img src=&quot;{dede:field name='phpurl'/}/img/menuarrow.gif&quot; 
            width=&quot;16&quot; height=&quot;15&quot; border=&quot;0&quot;&gt;�Ƽ�&lt;/a&gt;</td>
        </tr>
        <tr> 
          <td colspan="3" bgcolor="#F9FBF0">������������ղ�<a name="6"></a></td>
        </tr>
        <tr> 
          <td height="53" colspan="3">&lt;a href=&quot;{dede:field name='phpurl'/}/stow.php?arcID={dede:field 
            name=ID/}&quot;&gt;&lt;img src=&quot;{dede:field name='phpurl'/}/img/file_move.gif&quot; 
            width=&quot;17&quot; height=&quot;18&quot; border=&quot;0&quot;&gt;�ղ�&lt;/a&gt;</td>
        </tr>
        <tr>
          <td colspan="3" bgcolor="#F9FBF0">������������<a name="7" id="7"></a></td>
        </tr>
        <tr> 
          <td height="40" colspan="3">&lt;a href=&quot;{dede:field name='phpurl'/}/feedback.php?arcID={dede:field 
            name=&quot;id&quot;/}&quot;&gt;��������&lt;/a&gt;</td>
        </tr>
      </table> </td>
</tr>
</table>
</body>
</html>