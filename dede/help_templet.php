<?
require_once(dirname(__FILE__)."/config.php");
$dsql = new DedeSql(false);
$dsql->SetQuery("Select nid,typename From #@__channeltype");
$dsql->Execute();
$nids = "";
while($row = $dsql->GetObject())
{
  $nids .= "({$row->typename}=&gt;{$row->nid}) ";
}
$dsql->Close();
?>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
<title>��վģ����˵��</title>
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
<td height="19" background="img/tbg.gif">&nbsp;<b>֯�����ݹ���ϵͳģ�����ο�</b></td>
</tr>
<tr>
<td height="94" bgcolor="#FFFFFF" valign="top">
<table width="98%" border="0" cellspacing="2">
<tr>
<td height="30" colspan="3" align="right"><input type="button" name="Submit" value=" �鿴ģ��Ŀ¼ " onClick="location='file_manage_main.php?activepath=<?=$cfg_templets_dir?>';"></td>
</tr>
<tr> 
<td height="30" colspan="3">
  <a href="#1"><u>�����������</u></a>
��<a href="#2"><u>ģ����ƹ淶</u></a>
��<a href="#3"><u>����ο�</u></a><br/>
            ��ǲο��� <a href="#31"><u>arclist(artlist,likeart,hotart,imglist,imginfolist,coolart,specart)</u></a> 
            &nbsp;<a href="#32"><u>field</u></a> &nbsp;<a href="#33"><u>channel</u></a> 
            &nbsp;<a href="#34"><u>mytag</u></a> &nbsp;<a href="#35"><u>vote</u></a> 
            &nbsp;<a href="#36"><u>friendlink</u></a> &nbsp;<a href="#37"><u>mynews</u></a> 
            &nbsp;<a href="#38"><u>loop</u></a> &nbsp;<a href="#39"><u>channelartlist</u></a> 
            &nbsp;<a href="#310"><u>page</u></a> &nbsp;<a href="#311"><u>list</u></a> 
            &nbsp;<a href="#312"><u>pagelist</u></a> <a href="#313"><u>pagebreak</u></a> 
            <a href="#314"><u>fieldlist</u></a> </td>
</tr>
<tr> 
<td colspan="3" valign="top"> <hr size="1" style="color:#888888">
<strong><font color="#990000"> һ��֯��ģ������������</font></strong> <a name="1"></a> 
<p> ���˽�DedeCms��ģ�����֮ǰ���˽�һ��֯��ģ�������֪ʶ�Ƿǳ�������ġ�֯��ģ��������һ��ʹ��XML���ֿռ���ʽ��ģ���������ʹ��֯�ν���������ģ������ô��ǿ������ɵ��ƶ���ǵ����ԣ��о��Ͼ�������HTMLһ����ʹģ�����ʮ��ֱ�����°��֯��ģ�����治����ʵ��ģ��Ľ������ܷ���ģ�������ı�ǡ�</p>
<p>1��֯��ģ������Ĵ�����ʽ�����¼�����ʽ��<br/>
{dede:������� ����='ֵ'/}<br/>
{dede:������� ����='ֵ'}{/dede:�������}<br/>
{dede:������� ����='ֵ'}�Զ�����ʽģ��(InnerText){/dede:�������}</p>
<p>��ʾ��<br/>
����{dede:������� ����='ֵ'}{/dede:�������}������ʽ�ı�ǣ���2.1���У���ʾ����ֻ��Ҫ�á�{/dede}������<br/>
V3����Ҫ�ϸ��á�{/dede:�������}��������ᱨ��</p>
<p>2��֯��ģ�����������ж��ϵͳ��ǣ���Щϵͳ������κγ��϶�����ֱ��ʹ�õġ�</p>
<p>(1) global ��ǣ���ʾ��ȡһ���ⲿ�������������ݿ�����֮�⣬�ܵ���ϵͳ���κ����ò�������ʽΪ��<br/>
{dede:global name='��������'}{/dede:global}<br/>
��<br/>
{dede:global name='��������' /}</p>
<p>���б������Ʋ��ܼ� $ ���ţ������ $cfg_cmspath ��Ӧ��д�� {dede:global name='cfg_cmspath' 
/} ��</p>
<p>(2) foreach �������һ�����飬��ʽΪ��<br/>
{dede:foreach array='��������'}[field:key/] [field:value/]{/dede:foreach}</p>
<p>(3) include ����һ���ļ�����ʽΪ��<br/>
{dede:include file='�ļ�����' /}<br/>
���ļ�������·��Ϊ˳��Ϊ������·����include�ļ��У�CMS��װĿ¼��CMS��ģ��Ŀ¼</p>
            <p>3��֯�α���������κα����ʹ�ú����Եõ���ֵ���д�����ʽΪ��<br/>
              {dede:������� ����='ֵ' function='youfunction(&quot;����һ&quot;,&quot;������&quot;,&quot;@me&quot;)'/}<br/>
              ���� @me ���ڱ�ʾ��ǰ��ǵ�ֵ��������������ĺ��������Ƿ���ڣ����磺<br/>
              {dede:field name='pubdate' function='strftime(&quot;%Y-%m-%d %H:%M:%S&quot;,&quot;@me&quot;)' 
              /}<br>
              <br>
              4��֯�α���������޵ı����չ��<br>
              ��ʽΪ��<br>
              {dede:tagname runphp='yes'}<br>
              $aaa = @me;<br>
              @me = &quot;123456&quot;;<br>
              {/dede:tagname} <br>
              @me ��ʾ�����Ǳ����ֵ����˱���ڱ���ǲ���ʹ��<strong><font color="#990000">echo</font></strong>֮������ģ�ֻ�ܰ����з���ֵ���ݸ�@me��<br>
              �������ڳ������ռ���˵ײ�ģ��InnerText�����ݣ�������̵ı��ֻ��ʹ��Ĭ�ϵ�InnerText�� </p>
<p><font color="#990000"><strong>����DedeCms ģ�������淶<a name="2"></a></strong></font></p>
            <p>����DedeCmsϵͳ��ģ���Ƿǹ̶��ģ��û��������½���Ŀʱ��������ѡ����Ŀģ�壬�ٷ����ṩ�������Ĭ��ģ�壬��������ϵͳģ�͵ĸ���ģ�壬DedeCms֧���Զ���Ƶ��ģ�ͣ��û��Զ�����Ƶ��ģ�ͺ���Ҫ����ģ�����һ���µ�ģ�塣<br>
              <strong>һ�������ƺ�ʹ��ģ�壬����Ҫ������漸�����</strong><br>
              <font color="#330000">1����飨���棩ģ�壺</font><br>
              ����ָ��վ��ҳ��Ƚ���Ҫ����Ŀ����ʹ�õ�ģ�壬һ���á�index_ʶ��ID.htm�����������⣬�û���������ĵ���ҳ����Զ����ǣ�Ҳ��ѡ�Ƿ�֧�ְ��ģ���ǣ����֧�֣�ϵͳ���ð��ģ��������ȥ�������������ݻ������ض����ļ���<br>
              <font color="#330000">2���б�ģ�壺</font><br>
              ����ָ��վĳ����Ŀ�����������б��ģ�壬һ���� ��list_ʶ��ID.htm�� ������<br>
              <font color="#330000">3������ģ�壺</font><br>
              ������ʾ�ĵ��鿴ҳ��ģ�壬һ���� ��article_ʶ��ID.htm�� ������<br>
              <font color="#330000">4������ģ�壺</font><br>
              ����һ��ϵͳ���������ģ���У���ҳģ�塢����ģ�塢�ңӣӡ��ʣӱ��빦��ģ��ȣ������û�Ҳ�����Զ���һ��ģ�崴��Ϊ�����ļ���<br>
              <strong>���� ������Ϊ�˹淶�����֯�ιٷ�����ʹ��ͳһ�ķ�ʽ������ģ�壬�������£�</strong><br>
              <font color="#330000">1��ģ�屣��λ�ã�</font><br>
              ����ģ��Ŀ¼����cmspath/templets/��ʽ���ƣ�Ӣ�ģ�Ĭ��Ϊdefault������systemΪϵͳ�ײ�ģ�壬plusΪ���ʹ�õ�ģ�壩/���幦��ģ���ļ���<br>
              ����<font color="#CC0000">���ģ��λ�ã��� 
              <?=$cfg_templets_dir."/{�������}/����ģ���ļ�"?>
              ����</font><a href="catalog_do.php?dopost=viewTemplet"><u><font color="#6600FF">��������ģ��Ŀ¼</font></u></a><br>
              <font color="#330000">2�� ģ���ļ������淶��</font><br>
              ������index_<font color="#990000">ʶ��ID</font>.htm������ʾ��飨��Ŀ���棩ģ�壻<br>
              ������list_<font color="#990000">ʶ��ID</font>.htm������ʾ��Ŀ�б�ģ�壻<br>
              ������article_<font color="#990000">ʶ��ID</font>.htm������ʾ���ݲ鿴ҳ���ĵ�ģ�壬����ר��鿴ҳ����<br>
              ������search.htm�� ��������б�ģ�壻 <br>
              ������index.htm�� ��ҳģ�壻 <br>
              <font color="#990000"><strong>ע�⣺</strong></font><font color="#990000"><br>
              ���ϵͳ��������Ƶ����[ʶ��ID]�ֱ�Ϊ�� 
              <?=$nids?>
              </font><br>
              ����list_image.htm ��ʾ�Ǿ�����������ΪͼƬ������ĿĬ���б�ģ�塣</p>
<p><font color="#990000"><strong>������Ҫ��ǲο�<a name="3"></a></strong></font></p>
<p><strong>1��arclist ���</strong><a name="31"></a></p>
<p>��������DedeCms��õ�һ����ǣ����� hotart��coolart��likeart��artlist��imglist��imginfolist��specart 
��Щ��Ƕ�����������������Ĳ�ͬ������������ġ�</p>
<p>���ã���ȡһ��ָ�����ĵ��б�</p>
<p>���÷�Χ������ģ�塢�б�ģ�塢�ĵ�ģ��</p>
<p>(1)�����﷨��</p>
<p>{dede:arclist<br/>
typeid='' row='' col='' titlelen='' <br/>
infolen='' imgwidth='' imgheight='' listtype='' orderby='' keyword=''}</p>
<p>�Զ�����ʽģ��(InnerText)</p>
<p>{/dede:arclist}</p>
<p>����ǵ�ͬ��artlist��imglist��imginfolist��ǣ�������artlist����ȫ��ͬ�ģ���imglist��imginfolist����Ĭ�ϵĵײ�ģ�岻ͬ��</p>
<p><br/>
(2)���Բο���</p>
            <p>[1] typeid='' ��ʾ��ĿID�����б�ģ��͵���ģ����һ�㲻��Ҫָ�����ڷ���ģ����������&quot;,&quot;�ֿ���ʾ�����Ŀ��<br/>
              [2] row='' ��ʾ�����ĵ������������col����ʹ�ã��ս��������row * col��<br/>
              [3] col='' ��ʾ�ֶ�������ʾ��Ĭ��Ϊ���У���<br/>
              [4] titlelen='' ��ʾ���ⳤ�ȣ�<br/>
              [5] infolen='' ��ʾ���ݼ�鳤�ȣ�<br/>
              [6] imgwidth='' ��ʾ����ͼ��ȣ�<br/>
              [7] imgheight='' ��ʾ����ͼ�߶ȣ�<br/>
              [8] type='' ��ʾ�������ͣ�����Ĭ��ֵ��type='all'ʱΪ��ͨ�ĵ�<br>
              �� type='commend'ʱ����ʾ�Ƽ��ĵ�����ͬ��<br>
              �� type='image'ʱ����ʾ���뺬������ͼƬ���ĵ�<br>
              [9] orderby='' ��ʾ����ʽ��Ĭ��ֵ�� senddate ������ʱ�����С� <br>
              �� orderby='hot' �� orderby='click' ��ʾ�����������<br>
              �� orderby='pubdate' ������ʱ�����У�����ǰ̨������ĵ�ʱ��ֵ��<br>
              �� orderby='sortrank' �����µ������򼶱������������ʹ���ö�������ʹ��������ԣ�<br>
              �� orderby='id' ������ID����<br>
              [10] keyword='' ��ʾ����ָ���ؼ��ֵ��ĵ��б�����ؼ�����&quot;,&quot;�ֿ�<br>
              [11] channelid='����' ��ʾ�ض���Ƶ�����ͣ����õ�Ƶ����ר��(-1)������(1)��ͼ��(2)��Flash(4)�����(3)<br>
              [12] limit='��ʼ,����' ��ʾ�޶��ļ�¼��Χ��row���Ա������&quot;���� - ��ʼ&quot;��mysql��limit�������0��ʼ�ģ��� 
              ��limit 0,5����ʾ����ȡǰ��ʼ�¼����limit 5,5����ʾ�ɵ���ʼ�¼��ȡ����ʼ�¼��</p>
<p>(3)�ײ�ģ�����</p>
<p>ID(ͬ id),title,iscommend,color,typeid,ismake,description(ͬ info),<br/>
pubdate,senddate,arcrank,click,litpic(ͬ picname),typedir,typename,<br/>
arcurl(ͬ filename),typeurl,stime(pubdate ��&quot;0000-00-00&quot;��ʽ),<br/>
textlink,typelink,imglink,image</p>
<p>���У�<br/>
textlink = &lt;a href='arcurl'&gt;title&lt;/a&gt;<br/>
typelink = &lt;a href='typeurl'&gt;typename&lt;/a&gt;<br/>
imglink = &lt;a href='arcurl'&gt;&lt;img src='picname' border='0' 
width='imgwidth' height='imgheight'&gt;&lt;/a&gt;<br/>
image = &lt;img src='picname' border='0' width='imgwidth' height='imgheight'&gt;</p>
<p>�������÷�����[field:varname /]</p>
<p>�磺<br/>
{dede:arclist infolen='100'}<br/>
[field:textlink /]<br/>
&lt;br&gt;<br/>
[field:info /]<br/>
&lt;br&gt;<br/>
{/dede:arclist}</p>
<p><strong>2��field ���</strong><a name="32"></a></p>
<p>���������ڻ�ȡ�ض���Ŀ������ֶ�ֵ�����õĻ�������ֵ</p>
<p>���÷�Χ������ģ�塢�б�ģ�塢�ĵ�ģ��</p>
<p>(1)�����﷨</p>
<p>{dede:field name=''/}</p>
<p>(2) name ���Ե�ֵ��</p>
<p>���ģ�壺phpurl,indexurl,indexname,templeturl,memberurl,powerby,webname,specurl</p>
<p>�б�ģ�壺position,title,phpurl,templeturl,memberurl,powerby,indexurl,indexname,specurl,��Ŀ��dede_arctype�������ֶ�<br/>
���� position Ϊ ����Ŀһ &gt; ��Ŀ���� ������ʽ�����ӣ�title��Ϊ������ʽ�ı���</p>
<p>�ĵ�ģ�壺position,phpurl,templeturl,memberurl,powerby,indexurl,indexname,specurl,id(ͬ 
ID,aid),����dede_archives��͸��ӱ�������ֶΡ�</p>
<p><br/>
<strong>3��channel ���</strong><a name="33"></a></p>
<p>���ڻ�ȡ��Ŀ�б�</p>
<p>���÷�Χ������ģ�塢�б�ģ�塢�ĵ�ģ��</p>
<p>(1)�����﷨<br/>
{dede:channel row='' type=''}<br/>
�Զ�����ʽģ��(InnerText)<br/>
{/dede:channel}</p>
<p>(2)����</p>
            <p>[1] row='����' ��ʾ��ȡ��¼��������ͨ����ĳ����Ŀ̫���ʱ��ʹ�ã�Ĭ���� 8��</p>
<p>[2] type = top,sun,self</p>
<p>type='top' ��ʾ������Ŀ<br/>
type='sun' ��ʾ�¼���Ŀ<br/>
type='self' ��ʾͬ����Ŀ</p>
<p>���к��������Ա������б�ģ����ʹ�á�</p>
<p>(3)�ײ�ģ�����</p>
<p>ID,typename,typedir,typelink(�������ʾ��Ŀ����ַ)</p>
<p>����<br/>
{dede:channel type='top'}<br/>
&lt;a href='[field:typelink /]'&gt;[field:typename/]&lt;/a&gt; <br/>
{/dede:channel}</p>
<p><strong>4��mytag ���</strong><a name="34"></a></p>
<p>���ڻ�ȡ�Զ����ǵ�����</p>
<p>���÷�Χ������ģ�塢�б�ģ�塢�ĵ�ģ��</p>
<p>(1)�����﷨</p>
<p>{dede:mytag typeid='' name='' ismake='' /}</p>
<p>(2)����</p>
<p>[1] typeid = '����' ��ʾ��ĿID��Ĭ��Ϊ 0����û���趨����Ŀû�ж���������Ƶı�ǣ��ᰴ����������ʽ�������������ϲ��Ҹ���Ŀ 
-&gt; ͨ�ñ�ǣ�typeid=0����ͬ����ǡ���</p>
<p>[2] name = '' ������ơ�</p>
<p>[3] ismake = yes|no Ĭ��Ϊ no ��ʾmytag������ݲ�������������ģ��ı�ǣ�yes���ʾ������ݺ�����������ģ���ǡ�</p>
<p><strong>5��vote ���<a name="35"></a></strong></p>
<p>���ڻ�ȡһ��ͶƱ��</p>
<p>���÷�Χ������ģ��</p>
<p>(1) �����﷨<br/>
{dede:vote id='ͶƱID' lineheight='22'<br/>
tablewidth='100%' titlebgcolor='#EDEDE2'<br/>
titlebackground='' tablebgcolor='#FFFFFF'}<br/>
{/dede:vote}</p>
<p><br/>
<strong>6��friendlink ��ǣ���ͬ flink<a name="36"></a></strong></p>
<p>���ڻ�ȡ��������</p>
<p>���÷�Χ������ģ��</p>
<p>(1)�����﷨</p>
            <p>{dede:flink type='' row='' col='' titlelen='' tablestyle=''}{/dede:flink}<br>
              ����ע�⣺<br>
              [1]type���������ͣ�ֵ��<br>
              a. textall ȫ����������ʾ<br>
              b. textimage ���ֺ�ͼ�û������<br>
              c. text ����ʾ����Logo������<br>
              d. image ����ʾ��Logo������<br>
              -------------------------------------<br>
              [2]row����ʾ�����У�Ĭ��Ϊ4��<br>
              [3]col����ʾ�����У�Ĭ��Ϊ6��<br>
              [4]titlelen��վ�����ֵĳ���<br>
              [5]tablestyle�� ��ʾ &lt;table <font color="#990000">���������</font>&gt;</p>
<p><strong>7��mynews ���<a name="37"></a></strong></p>
<p>���ڻ�ȡվ������</p>
<p>���÷�Χ������ģ��</p>
<p>(1) �����﷨</p>
<p>{dede:mynews row='����' titlelen='���ⳤ��'}Innertext{/dede:mynews}</p>
<p>Innertext֧�ֵ��ֶ�Ϊ��[field:title /],[field:writer /],[field:senddate 
/](ʱ��),[field:body /]</p>
<p><strong>8��loop ���<a name="38"></a></strong></p>
            <p>���ڵ������������ݣ�һ�����ڵ�����̳����֮��Ĳ����������<a href="bbs_addons.php"><font color="#990000"><u>��̳��չ���</u></font></a>��</p>
<p><strong>9��channelartlist ���<a name="39"></a></strong></p>
<p>���ڻ�ȡƵ�����¼���Ŀ�������б�</p>
<p>���÷�Χ������ģ��</p>
<p>�﷨��</p>
<p>{dede:channelArtlist typeid=0 col=2 tablewidth='100%'}<br/>
&lt;table width=&quot;99%&quot; border=&quot;0&quot; cellpadding=&quot;3&quot; 
cellspacing=&quot;1&quot; bgcolor=&quot;#BFCFA9&quot;&gt;<br/>
&lt;tr&gt;<br/>
&lt;td bgcolor=&quot;#E6F2CC&quot;&gt;<br/>
{dede:type}<br/>
&lt;table border=&quot;0&quot; cellpadding=&quot;0&quot; cellspacing=&quot;0&quot; 
width=&quot;98%&quot;&gt;<br/>
&lt;tr&gt;<br/>
&lt;td width='10%' align=&quot;center&quot;&gt;&lt;img src='[field:global 
name='cfg_plus_dir'/]/img/channellist.gif' width='14' height='16'&gt;&lt;/td&gt;<br/>
&lt;td width='60%'&gt;<br/>
&lt;a href=&quot;[field:typelink /]&quot;&gt;[field:typename /]&lt;/a&gt;<br/>
&lt;/td&gt;<br/>
&lt;td width='30%' align='right'&gt;<br/>
&lt;a href=&quot;[field:typelink /]&quot;&gt;����...&lt;/a&gt;<br/>
&lt;/td&gt;<br/>
&lt;/tr&gt;<br/>
&lt;/table&gt;<br/>
{/dede:type}<br/>
&lt;/td&gt;<br/>
&lt;/tr&gt;<br/>
&lt;tr&gt;<br/>
&lt;td height=&quot;150&quot; valign=&quot;top&quot; bgcolor=&quot;#FFFFFF&quot;&gt;<br/>
{dede:arclist row=&quot;8&quot;}<br/>
��&lt;a href=&quot;[field:arcurl /]&quot;&gt;[field:title /]&lt;/a&gt;&lt;br&gt;<br/>
{/dede:arclist}<br/>
&lt;/td&gt;<br/>
&lt;/tr&gt;<br/>
&lt;/table&gt;<br/>
&lt;div style='font-size:2px'&gt;&amp;nbsp;&lt;/div&gt;<br/>
{/dede:channelArtlist}</p>
<p>channelArtlist ��Ψһһ������ֱ��Ƕ��������ǵı�ǣ�����������Ƕ��</p>
<p>{dede:type}{/dede:type} �� {dede:arclist}{/dede:arclist}</p>
<p>��ǡ�</p>
<p>(1) ����<br/>
typeid=0 Ƶ��ID,Ĭ�ϵ�����£�Ƕ�׵ı��ʹ�õ��������ĿID���¼���Ŀ������������ض�����Ŀ��������&quot;,&quot;�ֿ����ID��</p>
<p>col=2 �ֶ�����ʾ</p>
<p>tablewidth='100%' ��Χ���Ĵ�С</p>
<p><br/>
<strong>10��page ���<a name="310"></a></strong></p>
<p>��ʾ��ҳҳ��ĸ��Ӳ���</p>
<p>���÷�Χ���б�ģ��</p>
<p>�﷨��</p>
<p>{dede:page pagesize=&quot;ÿҳ�������&quot;/}</p>
<p><strong>11��list ���<a name="311"></a></strong></p>
<p>��ʾ�б�ģ����������б�</p>
<p>�﷨��</p>
            <p>{dede:list col='' titlelen='' <br/>
              infolen='' imgwidth='' imgheight='' orderby=''}{/dede:list}</p>
<p>�ײ�ģ�����</p>
<p>ID(ͬ id),title,iscommend,color,typeid,ismake,description(ͬ info),<br/>
pubdate,senddate,arcrank,click,litpic(ͬ picname),typedir,typename,<br/>
arcurl(ͬ filename),typeurl,stime(pubdate ��&quot;0000-00-00&quot;��ʽ),<br/>
textlink,typelink,imglink,image</p>
<p><strong>12��pagelist ���<a name="312"></a></strong></p>
<p>��ʾ��ҳҳ���б�</p>
<p>���÷�Χ���б�ģ��</p>
<p>�﷨��</p>
<p>{dede:pagelist listsize=&quot;3&quot;/}</p>
            <p>listsize ��ʾ [1][2][3] ��Щ��ĳ��� x 2 </p>
            <p><strong>13��pagebreak ���</strong><strong><a name="313" id="313"></a></strong><br>
              <br>
              ��;����ʾ�ĵ��ķ�ҳ�����б�<br>
              ���÷�Χ�����ĵ�ģ�塣 <br>
              �﷨��{dede:pagebreak /} <br>
              <br>
              <strong>14�� fieldlist ���<a name="314" id="314"></a><br>
              </strong>��;����ø��ӱ�������ֶ���Ϣ��<br>
              ���÷�Χ�����ĵ�ģ�塣 <br>
              �﷨��<br>
              {dede:fieldlist}<br>
              [field:name /] �� [field:value /] &lt;br&gt;<br>
              {/dede:fieldlist}</p>
            <p></p></td>
</tr>
<tr> 
<td colspan="3">&nbsp;</td>
</tr>
</table> </td>
</tr>
</table>
</body>
</html>