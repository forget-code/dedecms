<?
require_once(dirname(__FILE__)."/config.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>������̳���</title>
<style type="text/css">
<!--
body {
	background-image: url(img/allbg.gif);
}
-->
</style>
<link href="base.css" rel="stylesheet" type="text/css">
</head>
<body topmargin="8">
<table width="98%"  border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#666666">
  <tr>
    <td width="100%" height="24" colspan="2" background="img/tbg.gif">
      <b>����̳��չ�����</b>    </td>
  </tr>
  <tr>
    <td height="250" colspan="2" bgcolor="#FFFFFF">
    	<table width="90%"  border="0" align="center" cellpadding="2" cellspacing="2">
      <tr>
        <td colspan="2">
        ���µĴ����ṩ�ڷ���ģ���е�����̳��������������.
        </td>
      </tr>
	  <form name="mycode1" action="action_tag_test.php" target="_blank" method="post">
      <tr>
        <td bgcolor="#F3F3F3">Discuz��̳��          </td>
        <td align="right" bgcolor="#F3F3F3"><input name="b1" type="submit" id="b1" value=" Ԥ�� "></td>
      </tr>
      <tr>
        <td colspan="2">
<textarea name="partcode" style="width:600" rows="8" id="partcode">��̳�������⣺<br/>
{dede:loop table="cdb_threads" sort="tid" row="10"}
<a href="/dz/viewthread.php?tid=[field:tid /]">
��[field:subject function="cn_substr('@me',30)" /]([field:lastpost function="date('m-d H:M','@me')" /])
</a>
<br/>
{/dede:loop}</textarea>
    </td>
      </tr>
	  </form>
	  <form name="mycode2" action="action_tag_test.php" target="_blank" method="post">
      <tr>
        <td bgcolor="#F3F3F3">PHPWIND��̳�� </td>
        <td align="right" bgcolor="#F3F3F3"><input name="b2" type="submit" id="b2" value=" Ԥ�� "></td>
      </tr>
      <tr>
        <td colspan="2">
        	<textarea name="partcode" style="width:600" rows="8" id="partcode">��̳�������⣺<br/>
{dede:loop table="pw_threads" sort="tid" row="10"}
<a href='/phpwind/read.php?tid=[field:tid /]'>
��[field:subject function="cn_substr('@me',30)" /]([field:lastpost function="date('m-d H:M','@me')" /])
</a>
<br/>
{/dede:loop}</textarea>
</td>
      </tr>
	   </form>
	  <form name="mycode2" action="action_tag_test.php" target="_blank" method="post">
      <tr>
        <td bgcolor="#F3F3F3">VBB��̳�� </td>
        <td align="right" bgcolor="#F3F3F3"><input name="b3" type="submit" id="b3" value=" Ԥ�� "></td>
      </tr>
      <tr>
        <td colspan="2"><textarea name="partcode" style="width:600" rows="8" id="partcode">��̳�������ۣ�<br/>
{dede:loop table="thread" sort="threadid" row="10"}
<a href='/vbb/showthread.php?threadid=[loop:field name="threadid"/]'>
��[field:title function="cn_substr('@me',30)" /]([field:lastpost function="date('m-d H:M','@me')" /])
</a>
<br/>
{/dede:loop}</textarea></td>
      </tr>
	   </form>
	  <form name="mycode2" action="action_tag_test.php" target="_blank" method="post">
      <tr>
        <td bgcolor="#F3F3F3">PHPBB��̳�� </td>
        <td align="right" bgcolor="#F3F3F3"><input name="b4" type="submit" id="b4" value=" Ԥ�� "></td>
      </tr>
      <tr>
        <td colspan="2"><b>
          <textarea name="partcode" style="width:600" rows="7" id="partcode">��̳�������ۣ�<br/>
{dede:loop table="phpbb_topics" sort="topic_id" row="10"}
<a href='/phpbb/viewtopic.php?t=[loop:field name="topic_id"/]'>
��[field:topic_title" function="cn_substr('@me',30)" /]
</a>
([field:topic_time" function="date('m-d H:M','@me')" /])
<br/>
{/dede:loop}</textarea>
        </b></td>
      </tr>
	  </form>
      <tr>
        <td colspan="2">&nbsp;</td>
        </tr>
    </table>
    
    </td>
  </tr>
</table>
</body>
</html>