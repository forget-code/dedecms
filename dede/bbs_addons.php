<?
require("config.php");
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
    <td height="250" colspan="2" bgcolor="#FFFFFF"><table width="90%"  border="0" align="center" cellpadding="2" cellspacing="2">
      <tr>
        <td colspan="2">��������PHP��̳���෱�࣬֯��ƽ̨�����ܻ��ܴ���˼һһ������Щ���������汾ͨ��ֱ�Ӳ������ģ����Loop���ṩ��ֱ�ӵ�����Щ��̳��������Ĵ��룬��ֻҪ����Щ�����븴�Ƶ���ҳģ�����ģ���м���ʹ��(��̳��Dedecms������ͬһ���ݿ�)��<br>
          ����Loop�����DedeCmsδ���汾��Ϊ�ṹԤ���ı�ǩ����V2.X�汾�汾�У��������µĻ�����Ϣ���������ݻ����һ�����ʹ�ö�̬�б����ܻ�Ƚϵͣ���δ���汾�лὫ���µĻ�����Ϣ��ʵ�����ݷ��룬��������ģ���У������ͨ��loop�������������������������ǿϵͳ������Ժ��������ϵͳ�����ܣ����Ҷ���ͼƬ��Flash����Ӱ���������ϢҲ�������룬����������DedeCms��3.0�汾��<br>
          �����ڴ˲�������һ���⼸����̳��Discuz�Ľṹ��Phpwind�Ľṹ���˵���������ų�˭����˭�Ŀ��ܣ������߶��ǱȽ�����ģ�����VBB����о��е���ң�PHPBB������Զ��Թ��ڼ򵥣������Ŵ�Ҷ�֪��Ӧ��ѡ��������̳���ˣ���DedeCms���Ժ�汾�У����ų��Դ���̳�Ŀ����ԡ�</td>
      </tr>
	  <form name="mycode1" action="make_part_test.php" target="_blank" method="post">
      <tr>
        <td bgcolor="#F3F3F3">Discuz��̳��          </td>
        <td align="right" bgcolor="#F3F3F3"><input name="b1" type="submit" id="b1" value=" Ԥ�� "></td>
      </tr>
      <tr>
        <td colspan="2"><textarea name="testcode" style="width:600" rows="8" id="testcode">��̳�������⣺<br>
{dede:loop table="cdb_threads" sort="tid" row="10"}
<a href="/dz/viewthread.php?tid=[loop:field name='tid'/]">
��[loop:field name="subject" function="substr" parameter="0,30"/]
([loop:field name="lastpost" function="date" parameter="m-d H:M"/])
</a>
<br>
{/dede}</textarea></td>
      </tr>
	  </form>
	  <form name="mycode2" action="make_part_test.php" target="_blank" method="post">
      <tr>
        <td bgcolor="#F3F3F3">PHPWIND��̳�� </td>
        <td align="right" bgcolor="#F3F3F3"><input name="b2" type="submit" id="b2" value=" Ԥ�� "></td>
      </tr>
      <tr>
        <td colspan="2"><textarea name="testcode" style="width:600" rows="8" id="testcode">��̳�������⣺<br>
{dede:loop table="pw_threads" sort="tid" row="10"}
<a href='/phpwind/read.php?tid=[loop:field name="tid"/]'>
��[loop:field name="subject" function="substr" parameter="0,30"/]
([loop:field name="lastpost" function="date" parameter="m-d H:M"/])
</a>
<br>
{/dede}</textarea></td>
      </tr>
	   </form>
	  <form name="mycode2" action="make_part_test.php" target="_blank" method="post">
      <tr>
        <td bgcolor="#F3F3F3">VBB��̳�� </td>
        <td align="right" bgcolor="#F3F3F3"><input name="b3" type="submit" id="b3" value=" Ԥ�� "></td>
      </tr>
      <tr>
        <td colspan="2"><textarea name="testcode" style="width:600" rows="8" id="testcode">��̳�������ۣ�<br>
{dede:loop table="thread" sort="threadid" row="10"}
<a href='/vbb/showthread.php?threadid=[loop:field name="threadid"/]'>
��[loop:field name="title" function="substr" parameter="0,30"/]
([loop:field name="lastpost" function="date" parameter="m-d H:M"/])
</a>
<br>
{/dede}</textarea></td>
      </tr>
	   </form>
	  <form name="mycode2" action="make_part_test.php" target="_blank" method="post">
      <tr>
        <td bgcolor="#F3F3F3">PHPBB��̳�� </td>
        <td align="right" bgcolor="#F3F3F3"><input name="b4" type="submit" id="b4" value=" Ԥ�� "></td>
      </tr>
      <tr>
        <td colspan="2"><b>
          <textarea name="testcode" style="width:600" rows="7" id="testcode">{dede:loop table="phpbb_topics" sort="topic_id" row="10"}
<a href='/phpbb/viewtopic.php?t=[loop:field name="topic_id"/]'>
��[loop:field name="topic_title" function="substr" parameter="0,30"/]
</a>
([loop:field name="topic_time" function="date" parameter="m-d H:M"/])
<br>
{/dede}</textarea>
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