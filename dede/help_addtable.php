<?
require_once(dirname(__FILE__)."/config.php");
?>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
<title>���ӱ����˵��</title>
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
    <td height="19" background="img/tbg.gif">&nbsp;<b>֯�����ݹ���ϵͳ�Զ���ģ�͸����ֶεĶ���</b></td>
</tr>
<tr>
    <td bgcolor="#FFFFFF" valign="top"> 
      <table width="98%" border="0" cellspacing="2">
        <tr> 
          <td colspan="3" valign="top" style="line-height:160%"> <strong><font color="#990000"> 
            ������<br>
            </font></strong> DedeCmsʹ��ͨ�ò�������ģ�͵ķ�ʽ������Ƶ�����ݵĲ��죬ͨ�ò���������dede_archives���У���������Ƶ������ͨ�ò���ʵ�ʻ�������һ�µģ���ͬ��Ƶ��֮��ͨ�����ӱ�ʵ�����ݵĲ��컯�����Ҫ���һ���Զ���ģ�ͣ��ͱ����Ƚ���һ�����ӱ��ڸ��ӱ��У��������ֶ��Ǳ���ģ�һ�� 
            aid ��INT �ǵ������͵��������� ������������������ֶΣ� ��һ���� typeid ��INT���ͣ�����ʾ��������Ŀ������ɾ����Ŀʱ���������ӱ�����ݣ����������ֶ����ݣ�������Ƶ��ģ���ж��壬ÿ���ֶ���һ����������ʾ������������£�<br> 
            <hr>
            <p><strong><font color="#990000"> </font></strong>���ò�����ʽ��<br>
              <font color="#660000">&lt;field:�ֶ����� itemname=&quot;����ʾ����&quot; 
              type=&quot;����&quot; isnull=&quot;&quot; default=&quot;&quot; rename=&quot;&quot; 
              function=&quot;��������('@me')&quot; maxlength=&quot;&quot; &gt;<br>
              <font color="#FF0000">����ʽ��������������ֶ����ƣ�</font><br>
              &lt;/field:�ֶ�����&gt;</font><br>
              �������£�<br>
              <strong>һ��type �Ǳ�������ԣ����������������У�</strong><br>
              <font color="#990000">1��type=&quot;int&quot;</font>���������ͣ�<br>
              &nbsp;��<font color="#990000">type=&quot;float&quot;</font>��С�����ͣ� 
              <br>
              <font color="#990000">2��type=&quot;datetime&quot;</font>���������ͣ����������ݿ���Ϊlinuxʱ��أ�����ʱ��Ҫ��function�������ǣ�{dede:field 
              name='' function=&quot;date('format',@me)&quot;/}�� <br>
              <font color="#990000">3��type=&quot;text&quot;</font>�������ı��������ݣ� <br>
              &nbsp;��<font color="#990000">type=&quot;multitext&quot;</font>�������ı��� 
              <br>
              <font color="#990000">4��type=&quot;htmltext&quot;</font>��HTML�ı����ݣ������ʱ��ʹ�ÿ��ӻ��༭����������Ϊtext���ͣ�<br>
              <font color="#990000">5��type=&quot;img&quot;</font>��ͼƬ���ϣ���һ�ַ���һ������ͼƬ�����ӡ�<br>
              <font color="#990000">6��type=&quot;addon&quot;</font>���������ϣ�һ�ִ������������������ĵ������ӡ�<font color="#333333"><br>
              </font><font color="#990000">7</font><font color="#990000">��type=&quot;media&quot;</font>����ý���ļ���<font color="#333333"> 
              <br>
              </font><strong>����isnull �Ǳ��������<br>
              </strong>��ʾ�ֶ��Ƿ�����Ϊ�գ��� true(����) �� false�������� ��ʾ<br>
              <strong>����default �ǿ�ѡ�����ԣ���ʾ�ֶε�Ĭ��ֵ��<br>
              </strong><strong>�ġ�rename �ǿ�ѡ�����ԣ���ʾ�ֶ��������������г�ͻʱ�������������ƣ���ϵͳģ����Ч����<br>
              </strong><strong>�塢function �ǿ�ѡ������<br>
              </strong>function����ĺ���ͳһ�����ڣ���CMSĿ¼/include/inc_channel_unit_functions.php���ļ��ڡ�<br>
              ��ʾʵ�ʷ��ص�ֵ��ִ�����������ķ���ֵ��<br>
              �磺&lt;field:rank type='number' function=&quot;GetRank('@me')&quot;&gt;&lt;/field:rank&gt;<br>
              ��ʾִ���� GetRank($rank) �󷵻ص�ֵ�������� rank ����<br>
              <strong>����maxlength �ǿ�ѡ���ԣ���ʾ�ֶε�����ֽڳ��ȡ�<br>
              </strong><strong>�ߡ�itemname ������ʾ����<br>
              �ˡ�page='split' �ֶ������Ƿ��ҳ��ʾ�����ҽ���һ��text���͵��ֶ�ʹ�ã���������˸����������#p#��ǣ�ϵͳ���Զ������ҳ��ʾ��<br>
              </strong><strong>�š�InnerText ����<br>
              </strong>���ϵͳû��ָ��Ƶ�������ݷ����ͱ༭ҳ�棬��ʹ���Զ����ɵı�������һЩ����������������InnerText�����������<br>
              ���������ϣ��text������input����������select���û�ѡ����ô��Ӧ���Լ����ж��塣</p>
            </td>
        </tr>
      </table> 
    </td>
</tr>
</table>
</body>
</html>