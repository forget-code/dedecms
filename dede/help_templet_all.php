<?
require_once(dirname(__FILE__)."/config.php");
?>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
<title>ģ�����ο�--ͨ��ģ����</title>
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
    <td height="19" background="img/tbg.gif"><b>ģ�����ο�--ͨ��ģ����</b></td>
</tr>
<tr>
<td bgcolor="#FFFFFF" valign="top">
<table width="98%" border="0" cellspacing="2">
        <tr> 
          <td colspan="3">����ͨ��ģ��������������ģ�壬�����ܻ���Ϊ��ͬ���������ڵ�ģ��ҳ������һ���Ĳ�ͬ���壬����㻹���˽�DedeCmsģ��Ļ����ṹ�������Ķ�һ�£� 
            <a href="help_templet.php#2"><u>ģ���ǲο� -&gt; DedeCmsģ�������淶</u></a> 
            ��һ�¡�</td>
        </tr>
        <tr>
          <td colspan="3" bgcolor="#F9FBF0"><strong>���������</strong></td>
        </tr>
        <tr> 
          <td colspan="3" bgcolor="#FFFFFF"> ��<strong>��</strong><font color="#990000">1������������</font>��ָĳЩ���Ե�Ĭ��ֵ�ڲ�ͬ��ģ���л�ı�ı�������typeid���ڰ��ģ���У�Ĭ��ֵΪ0����ʾ���з��ࣻ�����б����Ŀ����ģ���У�Ĭ��ֵΪ�����Ŀ�ģɣģ����ĵ�����Ĭ��ֵ������ĵ�������Ŀ����Ŀ�ɣġ�</td>
        </tr>
        <tr> 
          <td colspan="3" bgcolor="#F9FBF0"><strong>�����幦�ܻ�ȡͨ�ñ�ǵĴ��룺</strong></td>
        </tr>
        <tr> 
          <td colspan="3">����<a href="#1"><u>�����ĵ��б�</u></a> <a href="#2"><u>����ͼƬ�б�</u></a> 
            <a href="#3"><u>�Ƽ��ĵ��б�</u></a> <a href="#4"><u>�����ĵ��б�</u></a> <a href="#5"><u>����ר���б�</u></a> 
            <a href="#6"><u>��Ŀ�б�</u></a> <a href="#7"><u>�Զ�����</u></a> <a href="#8"><u>ϵͳ����</u></a> 
            <a href="#9"><u>����һ���ļ�</u></a> </td>
        </tr>
        <tr> 
          <td colspan="3" bgcolor="#F9FBF0">����<strong>�����ĵ��б�</strong><a name="1"></a></td>
        </tr>
        <tr> 
          <td colspan="3"> 
            <table width="96%" border="0" cellspacing="2" cellpadding="2">
              <form name="form1" action="tag_test_action.php" target="_blank" method="post">
                <input type="hidden" name="dopost" value="make">
                <tr> 
                  <td width="430">ʹ�ñ�ǣ�arclist<a href="help_templet.php#31" target="_blank"><u>[�ο�]</u></a>�����룺</td>
                  <td width="156" align="center"> <input type="submit" name="Submit" value="Ԥ��" class="np" style="width:60px"></td>
                </tr>
                <tr>
                  <td colspan="2"><textarea name="partcode" style='width:100%' rows="6" id="partcode">{dede:arclist typeid='' titlelen='28' row='10' col='1'}
��<a href='[field:arcurl/]'>[field:title/]</a><br>
{/dede:arclist}</textarea></td>
                </tr>
                <tr> 
                  <td colspan="2"><strong>arclist�ײ�ģ�����(����[field:name/])��</strong><br>
                    id,title,iscommend,color,typeid,ismake,description(ͬ info),pubdate,senddate,<br>
                    arcrank,click,litpic(ͬ picname),typedir,typename,arcurl(ͬ 
                    filename),typeurl,<br>
                    stime(pubdate ��&quot;0000-00-00&quot;��ʽ),textlink,typelink,imglink,image</td>
                </tr>
              </form>
            </table></td>
        </tr>
        <tr> 
          <td colspan="3" bgcolor="#F9FBF0">����<strong>����ͼƬ�б�</strong><a name="2"></a></td>
        </tr>
        <tr> 
          <td colspan="3">
		  <table width="96%" border="0" cellspacing="2" cellpadding="2">
              <form name="form1" action="tag_test_action.php" target="_blank" method="post">
                <input type="hidden" name="dopost" value="make">
                <tr> 
                  <td width="430">ʹ�ñ�ǣ�arclist<a href="help_templet.php#31" target="_blank"><u>[�ο�]</u></a>�����룺</td>
                  <td width="156" align="center">&nbsp;</td>
                </tr>
                <tr> 
                  <td colspan="2">{dede:arclist typeid='0' titlelen='24' row='2' 
                    col='4' imgwidth='120' imgheight='90'}<br>
                    &lt;table width='120' border='0' align=&quot;center&quot; 
                    cellpadding='2' cellspacing='1' bgcolor='#E6EAE3'&gt;<br>
                    &lt;tr align='center'&gt;<br>
                    &lt;td bgcolor='#FFFFFF'&gt;[field:imglink/]&lt;/td&gt;<br>
                    &lt;/tr&gt;<br>
                    &lt;tr align='center'&gt; <br>
                    &lt;td height='20' bgcolor=&quot;#F8FCEF&quot;&gt;[field:textlink/]&lt;/td&gt;<br>
                    &lt;/tr&gt;<br>
                    &lt;/table&gt;<br>
                    {/dede:arclist} </td>
                </tr>
              </form>
            </table>
			</td>
        </tr>
        <tr> 
          <td colspan="3" bgcolor="#F9FBF0">����<strong>�Ƽ��ĵ��б�</strong><a name="3"></a></td>
        </tr>
        <tr> 
          <td colspan="3">
		  <table width='96%' border="0" cellspacing="2" cellpadding="2">
              <form name="form1" action="tag_test_action.php" target="_blank" method="post">
                <input type="hidden" name="dopost" value="make">
                <tr> 
                  <td width="430">ʹ�ñ�ǣ�arclist<a href="help_templet.php#31" target="_blank"><u>[�ο�]</u></a>�����룺</td>
                  <td width="156" align="center"><input type="submit" name="Submit" value="Ԥ��" class="np" style="width:60px"></td>
                </tr>
                <tr> 
                  <td colspan="2"> <textarea name="partcode" style='width:100%' rows="4" id="partcode">{dede:arclist typeid='' type='commend' titlelen='28' row='10' col='1'}
��<a href='[field:arcurl/]'>[field:title/]</a><br>
{/dede:arclist}</textarea></td>
                </tr>
              </form>
            </table></td>
        </tr>
        <tr> 
          <td colspan="3" bgcolor="#F9FBF0">����<strong>�����ĵ��б�</strong><a name="4"></a></td>
        </tr>
        <tr> 
          <td colspan="3"><table width='96%' border="0" cellspacing="2" cellpadding="2">
              <form name="form1" action="tag_test_action.php" target="_blank" method="post">
                <input type="hidden" name="dopost" value="make">
                <tr> 
                  <td width="430">ʹ�ñ�ǣ�arclist<a href="help_templet.php#31" target="_blank"><u>[�ο�]</u></a>�����룺</td>
                  <td width="156" align="center"><input type="submit" name="Submit" value="Ԥ��" class="np" style="width:60px"></td>
                </tr>
                <tr> 
                  <td colspan="2"> <textarea name="partcode" style='width:100%' rows="4" id="partcode">{dede:arclist typeid='' orderby='click' titlelen='28' row='10' col='1'}
��<a href='[field:arcurl/]'>[field:title/]</a><br>
{/dede:arclist}</textarea></td>
                </tr>
              </form>
            </table></td>
        </tr>
        <tr> 
          <td colspan="3" bgcolor="#F9FBF0">����<strong>����ר���б�</strong><a name="5"></a></td>
        </tr>
        <tr> 
          <td colspan="3"><table width='96%' border="0" cellspacing="2" cellpadding="2">
              <form name="form1" action="tag_test_action.php" target="_blank" method="post">
                <input type="hidden" name="dopost" value="make">
                <tr> 
                  <td width="430">ʹ�ñ�ǣ�arclist<a href="help_templet.php#31" target="_blank"><u>[�ο�]</u></a>�����룺</td>
                  <td width="156" align="center"><input type="submit" name="Submit" value="Ԥ��" class="np" style="width:60px"></td>
                </tr>
                <tr> 
                  <td colspan="2"> <textarea name="partcode" style='width:100%' rows="4" id="partcode">{dede:specart typeid='' titlelen='28' row='10' col='1'}
��<a href='[field:arcurl/]'>[field:title/]</a><br>
{/dede:specart}</textarea></td>
                </tr>
              </form>
            </table></td>
        </tr>
        <tr> 
          <td colspan="3" bgcolor="#F9FBF0">����<strong>��Ŀ�б�</strong><a name="6"></a></td>
        </tr>
        <tr> 
          <td colspan="3"><table width='96%' border="0" cellspacing="2" cellpadding="2">
              <form name="form1" action="tag_test_action.php" target="_blank" method="post">
                <input type="hidden" name="dopost" value="make">
                <tr> 
                  <td width="430">ʹ�ñ�ǣ�channel[�ο�]�����룺</td>
                  <td width="156" align="center"><input type="submit" name="Submit" value="Ԥ��" class="np" style="width:60px"></td>
                </tr>
                <tr> 
                  <td colspan="2"> <textarea name="partcode" style='width:100%' rows="4" id="partcode">{dede:channel type='top'}
<a href="[field:typelink/]">[field:typename/]</a> 
{/dede:channel}</textarea></td>
                </tr>
              </form>
            </table></td>
        </tr>
        <tr> 
          <td colspan="3" bgcolor="#F9FBF0">����<strong>�Զ�����</strong><a name="7"></a></td>
        </tr>
        <tr> 
          <td colspan="3"><table width='96%' border="0" cellspacing="2" cellpadding="2">
              <form name="form1" action="tag_test_action.php" target="_blank" method="post">
                <input type="hidden" name="dopost" value="make">
                <tr> 
                  <td width="430">ʹ�ñ�ǣ�mytag[�ο�]�����룺</td>
                  <td width="156" align="center"><input type="submit" name="Submit" value="Ԥ��" class="np" style="width:60px"></td>
                </tr>
                <tr> 
                  <td colspan="2"> <textarea name="partcode" style='width:100%' rows="4" id="partcode">{dede:mytag typeid='' name='�������' ismake='0'/}</textarea></td>
                </tr>
              </form>
            </table></td>
        </tr>
        <tr> 
          <td colspan="3" bgcolor="#F9FBF0">����<strong>ϵͳ����</strong><a name="8"></a></td>
        </tr>
        <tr> 
          <td colspan="3"><table width='96%' border="0" cellspacing="2" cellpadding="2">
              <form name="form1" action="tag_test_action.php" target="_blank" method="post">
                <input type="hidden" name="dopost" value="make">
                <tr> 
                  <td width="430">ʹ�ñ�ǣ�global�����룺</td>
                  <td width="156" align="center"><input type="submit" name="Submit" value="Ԥ��" class="np" style="width:60px"></td>
                </tr>
                <tr>
                  <td colspan="2"><textarea name="partcode" style='width:100%' rows="4" id="partcode">{dede:global name='������'/}</textarea></td>
                </tr>
                <tr> 
                  <td colspan="2">���ñ�����cfg_webname(��վ����)��cfg_cmspath(CMS��װĿ¼)��cfg_templeturl(ģ����ַ)��cfg_phpurl(�����ַ)</td>
                </tr>
              </form>
            </table></td>
        </tr>
        <tr> 
          <td colspan="3" bgcolor="#F9FBF0">����<strong>����һ���ļ�</strong><a name="9"></a></td>
        </tr>
        <tr> 
          <td colspan="3">
		  <table width='96%' border="0" cellspacing="2" cellpadding="2">
              <form name="form1" action="tag_test_action.php" target="_blank" method="post">
                <input type="hidden" name="dopost" value="make">
                <tr> 
                  <td width="430">ʹ�ñ�ǣ�include�����룺(file �ļ��� ismake �Ƿ����ģ���ǣ���������� 
                    ismake='yes')</td>
                  <td width="156" align="center"><input type="submit" name="Submit" value="Ԥ��" class="np" style="width:60px"></td>
                </tr>
                <tr> 
                  <td colspan="2"> <textarea name="partcode" style='width:100%' rows="4" id="partcode">{dede:include file='�ļ���' ismake=''/}</textarea></td>
                </tr>
              </form>
            </table></td>
        </tr>
      </table> </td>
</tr>
</table>
</body>
</html>