<?
require("config.php");
?>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
<title>��վģ��</title>
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
          <td height="30" colspan="3" align="right"> 
            <input type="button" name="Submit" value=" �鿴ģ��Ŀ¼ " onClick="window.open('file_view.php?activepath=<?=$mod_dir?>');">          </td>
        </tr>
        <tr> 
          <td colspan="3"><hr size="1" style="color:#888888">
            <b>֯�����ݹ���ϵͳģ�����V2.0����˵����</b><br>            
            1��֯�����ݹ���ϵͳV2.0���ϰ汾��ģ�������XML���ֿռ�ķ��ʹ��˫��ģ�弼���������Ƚ���ҳ����������˼�룬��ͬ�������Ҳ��ʮ�ֳ�ǰ�ġ�<br>
            2�����ڿ��ǵ�ģ��Ĵ���ɼ��ԣ�ϵͳ�� &quot;{&quot;��&quot;}&quot; ����������ģ���ǣ�����㲻ϲ�����ַ�񣬿�����config_base.php�и���Ϊ�������ţ��磺&quot;&lt;&quot;��&quot;&gt;&quot; �� &quot;[&quot;��&quot;]&quot;(ע�⣺���������˷���Ϊ&quot;[&quot;��&quot;]&quot;�����ܻᵼ�±��� loop ��ǲ�����)��<br>
            3��Dedeģ��Ĵ�����XML�����ֿռ���ʽ���﷨����ͬ�ģ���������Ƕ��(����loop���������Ƕ�ף���ʹ�õ��ǲ�ͬ����ʽ)��<br> 
            һ���ʽΪ�� <br>
{dede:tagname attribute=&quot;value&quot;/}<br>
            {dede:tagname attribute=&quot;value&quot;}{/dede}<br>
{dede:tagname attribute=&quot;value&quot;}innertext{/dede}            <br>
dede���Ǳ�ʾ��ϵͳ�����ֿռ䣬�����Ĵ�����Է���Ľ�HTML��ǻ�CSS������ֿ�����<br>
<span class="style2"><b>tagname �� ���� �� ����ֵ �ǲ��ִ�Сд�ġ�</b></span><br>
4��2.0���ϵİ�󲿷�ģ����֧�ֶ���ģ�鼼��������Ĭ��ģ����ڡ�ģ��Ŀ¼/�Ͳ�ģ�塱�У������Ҫ�Զ�����Щ�Ͳ�ģ�壬һ�㲻Ҫ���ġ�ģ��Ŀ¼/�Ͳ�ģ�塱����ļ���ֻҪֱ�Ӱ�ģ���ַ�������innertext��λ�ü��ɣ��Ͳ��ģ��ֱ���� ~����~ ��ӳ��ͬ���ı�����<br>
����<br>
{dede:list type=&quot;small&quot;}<br>
&lt;table border='0' width='100%'&gt;<br>
&lt;tr height='24'&gt;<br>
&lt;td width='2%'&gt;&lt;img src='/dedeimages/file.gif' width='18' height='17'&gt;&lt;/td&gt;<br>
&lt;td width='83%'&gt;~fulltitle~&lt;font color='#8F8C89'&gt;(~stime~)&lt;/font&gt;&lt;/td&gt;<br>
&lt;td width='15%'&gt;���:~click~&lt;/td&gt;&lt;/tr&gt;<br>
&lt;tr&gt;&lt;td height='2' colspan='3' background='/dedeimages/writerbg.gif'&gt;&lt;/td&gt;&lt;/tr&gt;<br>
&lt;/table&gt;<br>
{/dede}<br>
            5�������ݹ���ϵͳ�Ľ���������Ϊ<span class="style2">����ģ�������</span>��<span class="style2">�б�ģ�������</span>��<span class="style2">���ģ�������</span>��<span class="style2">ר��ģ�������</span>����������ԭ����Щ�������Ƿ���ģ�����㲻��������ģ����ʹ���б�ģ��Ͱ��ģ��ı�ǣ���֮Ҳ����ͬ�ĵ�����Ȼ��Щ���������ͬ�����ڲ�ͬ��ģ������ܵõ��Ļ��ǲ�ͬ�����ݡ�<br>
            <span style="font-size:10pt; font-weight: bold;">��ο�ָ����ģ���ǣ�[<a href="#art"><u>����ģ����</u></a>] 
            [<a href="#list"><u>�б�ģ����</u></a>] [<a href="#part"><u>���ģ����</u></a>]</span> 
            <strong>[<a href="#spec"><u>ר��ģ�������</u></a>]</strong> <br>
            <hr size="1">
            <img src="img/arttag.gif" width="184" height="38"><a name="art"></a><br>
              <span class="style6">������ģ���</strong></u>��ѡ�Ĳ������Ϊ��</span></font> <br>
              1��<span class="style4">{dede:field name=&quot;value&quot;/}</span> ���һ��ָ�����ֶΡ�<br>
              value����Ϊ��ֵ��title��stime��source��body��click��writer��id ��position(���³���)<br>
              �Ƿ�֧�ֶ���ģ�壺��֧��<br>
              2��<span class="style5">{dede:likeart titlelength=&quot;24&quot; line=&quot;10&quot;}{/dede}</span><br>
            ��;�����������������б�<br>
            ���ԣ�titlelength ���ⳤ��  line ������� ֧��innertext  <br>
            Ĭ������Ϊ��<br>
            {dede:likeart titlelength=&quot;24&quot; line=&quot;6&quot;}��&lt;a href='~filename~'&gt;~title~&lt;/a&gt;&lt;br&gt;{/dede}            <br>
            coolart��hotartͬ �����ʹ��Ĭ�����ԣ���ǿɼ�Ϊ��{dede:likeart/}<br>
            �Ƿ�֧�ֶ���ģ�壺֧��<br>
            InnerText֧�ֵ��ֶΣ�
            filename��title��stime��ID<br>
            3��<span class="style5">{dede:coolart titlelength=&quot;24&quot; line=&quot;6&quot;}{/dede}</span><br>
��;�����������ͬ������µ��Ƽ��������б�            <br>
���ԣ�titlelength ���ⳤ�� line ������� ֧��innertext<br>
�Ƿ�֧�ֶ���ģ�壺֧��<br>
InnerText֧�ֵ��ֶΣ� filename��title��stime��ID<br>
4��<span class="style5">{dede:hotart titlelength=&quot;24&quot; line=&quot;6&quot;}{/dede}</span> <br>
��;�����������ͬ������µ��ȵ�������б�<br>
���ԣ�titlelength ���ⳤ�� line ������� ֧��innertext<br>
�Ƿ�֧�ֶ���ģ�壺֧��<br>
            InnerText֧�ֵ��ֶΣ� filename��title��stime��ID            
            <br>
            5��<span class="style5">{dede:channel type=&quot;&quot;}{/dede}</span><br>
��;����������Ŀ��<br>
���ԣ�type ���ͣ�ֵö��Ϊ�� sun �¼����࣬top ����Ƶ���б�self ͬ������<br>
֧��innertext<br>
InnerText֧�ֵ��ֶΣ� typelink��typename            <hr size="1">
            <font color="#FF0000"><u><strong><img src="img/listtag.gif" width="184" height="38"><a name="list"></a><br>
            �������б��</strong></u><strong>��ѡ������룺<br>
            </strong></font>�б�ģ����붨��{dede:page pagesize=&quot;ҳ���С&quot;/}��ǣ����û�ж��壬����ÿҳ20����¼��ҳ�������ϣ����ĳ��Ŀ�б���ҳ��һ����鴦�����ڡ�Ƶ������-&gt;���ģ�塱ѡ����ĿΪ�Զ����飬���Ѱ��ģ����뱣�浽���ݿ⡣<br> 
            1��<span class="style5">{dede:page pagesize=&quot;20&quot;/}</span><br>
            ��;������ҳ��Ĵ�С������б�Ϊ����ͼƬչ���������ǽ���Ч��<br>
            2��<span class="style5">{dede:field name=&quot;value&quot;/}</span><br>
            ��;�����һ����һ������ֶΡ�<br>
            ���ԣ�name �ֶ����ƣ�ֵΪ�� title��position<br>
            3��<span class="style5">{dede:coolart titlelength=&quot;24&quot; line=&quot;10&quot;}{/dede}</span><br>
��;�������������Ƽ��������б� <br>
���ԣ�titlelength ���ⳤ�� line ������� ֧��innertext<br>
�Ƿ�֧�ֶ���ģ�壺֧��<br>
InnerText֧�ֵ��ֶΣ� filename��title��stime��ID<br>
4��<span class="style5">{dede:hotart titlelength=&quot;24&quot; line=&quot;10&quot;}{/dede}</span> <br>
��;�������������ȵ�������б�<br>
���ԣ�titlelength ���ⳤ�� line ������� ֧��innertext<br>
�Ƿ�֧�ֶ���ģ�壺֧��<br>
InnerText֧�ֵ��ֶΣ� filename��title��stime��ID<br>
            5��<span class="style5">{dede:channel type=&quot;&quot;}{/dede}</span><br>
            ��;����������Ŀ��<br>
            ���ԣ�type ���ͣ�ֵö��Ϊ�� sun �¼����࣬top ����Ƶ���б�self ͬ������<br>            
            ֧��innertext<br>
            InnerText֧�ֵ��ֶΣ� typelink��typename<br>
            6��<span class="style5">{dede:list type=&quot;&quot;}{/dede}</span>            <br>
            ��ʾ�б����ݵ�����<br>
            ���ԣ�type �б����ͣ�type��ֵö��Ϊ��full��small��imglist��multiimglist��soft��pagelist<br>
            type������û��Ĭ��ֵ�ģ�����ָ���б�����<br>
            [1]��typeΪ��full��small ʱ<br> 
            type=full ��ʾ�����⡢������Ϣ�������б�           <br>
            type=small ��ʾֻ������������б�<br>
            ֧�����ԣ�<br>
            titleLength ���ⳤ�ȣ�
            Ĭ��Ϊ50<br>
            infolength             ���ݼ�鳤�ȣ�Ĭ��Ϊ��300<br>
            ֧�ֵ�Innertext����ģ��ֵ--fulltitle��title��filename��click��member��shortinfo��stime            <br> 
            [2]��typeΪ��imglist��soft ʱ<br>
            ��ͼƬ����ͨ�����б�            <br>
            ֧�����ԣ�<br>
            titleLength ���ⳤ�ȣ�Ĭ��Ϊ50<br>
            infolength ���ݼ�鳤�ȣ�Ĭ��Ϊ��300<br>
            imgwidth ����ͼ���<br>
            imgheight ����ͼ�߶�<br>            
            ֧�ֵ�Innertext����ģ��ֵ--fulltitle��title��filename��click��member��shortinfo��stime<br>
            [3]��typeΪ��            multiimglist ʱ<br>
            ����ͼƬ��ʽ�������б�            <br>
            ֧�����ԣ�<br>
titleLength ���ⳤ�ȣ�Ĭ��Ϊ50��<br>
infolength ���ݼ�鳤�ȣ�Ĭ��Ϊ��300��<br>
imgwidth ����ͼ���<br>
imgheight ����ͼ�߶�<br>
row ͼƬ����<br>
col ͼƬ����<br>
hastitle �Ƿ���ʾ�������ӣ�yes �� no<br>
{dede:page pagesize=&quot;ҳ���С&quot;/} ҳ���СӦ�õ��� row * col ��ֵ��������ܳ��� <br>            
֧�ֵ�Innertext����ģ��ֵ--ID��title��filename��stime��click��img<br>
[5]��typeΪ��pagelist
��ʾ��ҳ�б�������size���Զ����б��ȣ�ʵ�ʳ���Ϊsize*2+1���綨���б�Ϊ<br>
{dede:page type=&quot;pagelist&quot; size=&quot;3&quot;/}�б����ʽΪ��<br>
            <span class="style7">��һҳ [1][2][3][4][5][6][7] ��һҳ</span><br>
            7��<span class="style5">{dede:rss/}</span><br>
            ��;�������Ŀ��Rss���ӣ�����ֻ����һ��������ַ�����������س����ӣ��������ģ���ļ�����&nbsp;<br>
            &lt;a href=&quot;<span class="style5">{dede:rss/}</span>&quot;&gt;RSS&lt;/a&gt;������ʵ�ֳ����ӡ�<br>
            ��֧��InnerText<br>
            <hr size="1">            <p><img src="img/parttag.gif" width="184" height="38"><a name="part"></a><br>
              <font color="#FF0000"><u><strong>�����ģ���</strong></u><strong>��ѡ������룺<br>
              </strong></font>ģ������������Ŀɶ��ƴ��룬һ��������֯��վ��ҳ�����Ŀ��Ƶ������ҳ�����ڹ�����Ը��ӣ�һ���н϶������ֵ���������б������ʹ���κ����ԣ�ϵͳ�����һ��Ĭ��ֵ�����¾��г����ǵ�Ĭ��ֵ��ʵ��Ӧ���У���Щ���ǿ�ѡ�ģ����Ҫʹ����Щ���ģ����룬���뽫��&quot;<a href="web_type_web.php"><u>���ģ�����</u></a>&quot;ʹ����Щģ�壬����汾���ڻ�ȡ�������ӵȷ��棬����һ���汾������hotlist��commendlist���ܱ�ǣ���ʵ����ֻҪ��imglist��artlist��sort�����������Ϊ 
              hot �� commend ��������ʵ�������Ĺ��ܣ��������ʵ�ʹ�ö���ģ�壬ԶԶ�������汾��<br>
              1��<font color="#0000FF">{dede:imglist typeid=0 row=1 col=4 imgwidth=100 
              imgheight=100 tablewidth=&quot;100%&quot; sort=&quot;new&quot; titlelength=20}{/dede}</font><br>
              ��;����ʾһ��ͼƬ�б�<br>
              ���Լ����壺<br>
              [1]typeid ���ID��Ϊ���û���������ʱ��ʾ�������<br>
              [2]row ͼƬ���� col ͼƬ����<br>
              [3]imgwidth ͼƬ��� imgheight ͼƬ�߶�<br>
              [4]sort ����ʽ Ĭ��Ϊ new �������·���������ǰ�棬��ѡ��Ϊ�� hot �ѵ�����ߵ�������ǰ�� commend ���µ��Ƽ�����<br>
              [5]titlelength �������ֵĳ��ȣ�����*2��<br>
              [6]infolength ���¼��ĳ��� <br>
              [7]tablewidth �������Ĵ�С��Ĭ��Ϊ 100%������ѡ������Ի���Դ�С<br>
              �Ƿ�֧�ֶ���ģ�壺֧��<br>
              Ĭ�ϵ�InnerText��<br>
              <font color="#CC00FF">&lt;table width='98%' border='0' cellspacing='2' 
              cellpadding='0'&gt;<br>
&lt;tr&gt;<br>
&lt;td align='center'&gt;~imglink~&lt;/td&gt;<br>
&lt;/tr&gt;<br>
&lt;tr&gt;<br>
&lt;td align='center'&gt;~textlink~&lt;/td&gt;<br>
&lt;/tr&gt;<br>
&lt;/table&gt;</font><br>
              ֧�ֵĶ���ģ���ֶΣ�ID��title��filename��img��imglink(�����ӵ�ͼƬ)��textlink,info(���¼��)<br>
              2��<font color="#3300FF">{dede:artlist typeid=0 row=6 sort=&quot;new&quot; titlelength=10}{/dede}<br>
              </font>��;����ʾһ�������б�<br>
              ���Լ����壺<br>
              [1]typeid ���ID��Ϊ���û���������ʱ��ʾ�������<br>
              [2]row ���µ����� ��line���Ե�ͬ<br>
              [3]line ���µ����� ��row���Ե�ͬ<br>
              [4]sort ����ʽ Ĭ��Ϊ new �������·���������ǰ�棬��ѡ��Ϊ�� hot �ѵ�����ߵ�������ǰ�� commend ���µ��Ƽ�����<br>
              [5]titlelength �������ֵĳ��ȣ�����*2��<br>
              �Ƿ�֧�ֶ���ģ�壺֧��<br>
              Ĭ�ϵ�InnerText��<font color="#3300FF"> <br>
              <font color="#CC00FF">��&lt;a href=&quot;~filename~&quot;&gt;~title~&lt;/a&gt;&lt;br&gt;</font> 
              </font><br>
              ֧�ֵĶ���ģ���ֶΣ�ID��title��filename��stime��click��typelink(����������Ŀ����)��<br>
              textlink(���±������ӣ���&lt;a href='~filename~'&gt;~title~&lt;/a&gt;)<br>
              </font> 
              3��<font color="#3300FF">{dede:imginfolist typeid=0 row=3 col=1 infolength=30 
              imgwidth=60 imgheight=60 sort=hot titlelength=10 tablewidth='200'}{/dede}<br>
              </font> ��;������һ�д�����ͼ����Ϣ<br>
              ��������{dede:imglist/}��ͬһ���������ģ���ҪĬ�ϵĵͲ�ģ�岻ͬ�����������ʵ������Ժ͵Ͳ�ģ�壬��{dede:imglist}innertext{/dede}Ҳ�ܴﵽͬ����Ŀ�ġ�<br>
              ���Լ����壺<br>
              [1]typeid ���ID��Ϊ���û���������ʱ��ʾ�������<br>
              [2]row ͼ����Ϣ������<br>
              [3]col ͼ����Ϣ������<br>
              [4]imgwidth ͼƬ��� imgheight ͼƬ�߶�<br>
              [5]sort ����ʽ Ĭ��Ϊ new �������·���������ǰ�棬��ѡ��Ϊ�� hot �ѵ�����ߵ�������ǰ�� commend ���µ��Ƽ�����<br>
              [6]titlelength �������ֵĳ��ȣ�����*2�� <br>
              [7]infolength ���¼��ĳ���<br>
              [8]tablewidth �������Ĵ�С��Ĭ��Ϊ 100%������ѡ������Ի���Դ�С<br>
              �Ƿ�֧�ֶ���ģ�壺֧��<br>
              Ĭ�ϵ�InnerText��<br>
              <font color="#CC00FF">&lt;table width=&quot;100%&quot; border=&quot;0&quot; 
              cellspacing=&quot;2&quot; cellpadding=&quot;2&quot;&gt;<br>
&lt;tr&gt; <br>
&lt;td width=&quot;30%&quot; rowspan=&quot;2&quot; align=&quot;center&quot;&gt;~imglink~&lt;/td&gt;<br>
&lt;td width=&quot;70%&quot;&gt;&lt;a href='~filename~'&gt;~title~&lt;/a&gt;&lt;/td&gt;<br>
&lt;/tr&gt;<br>
&lt;tr&gt; <br>
&lt;td&gt;~info~&lt;/td&gt;<br>
&lt;/tr&gt;<br>
&lt;/table&gt;</font> <br>
              ֧�ֵĶ���ģ���ֶΣ�ID��title��filename��img��imglink(�����ӵ�ͼƬ)��textlink,info(���¼��)<br>
              4��<font color="#3300FF">{dede:vote name=&quot;&quot;}{/dede}</font><br>
            ��;������һ��ͶƱ�õı���name�Ǵ���ͶƱʱ���õ�����<br>
            ���ԣ�<br>
            name: ͶƱ�����ƣ����룩<br>
            lineheight: ͶƱ��Ŀ���и�<br>
            tablewidth: ͶƱ�������Ĵ�С<br>
            titlebgcolor: ͶƱ����ı�����ɫ<br>
            titlebackground: ͶƱ����ı���ͼƬ<br>
            5��<font color="#3300FF">{dede:link row=3 col=6 type=&quot;text&quot; 
            titlelength=&quot;24&quot;}{/dede}</font> <br>
              ��;�������������ӵı��<br>
            ���ԣ�<br>
            type: ��ѡΪ��text��img ����imgΪ��׼�ģ�88*31��ʽ�� <br>
            row: ����<br>
            col: �б�<br>
            titlelen: ���ⳤ�ȣ�Ĭ��Ϊ 24 �� 12������<br>
            tablestyle: ����HTML���� <br>
            6��<font color="#3300FF">{dede:channel typeid=0}{/dede}</font> <br>
            ��;�����һ��Ƶ�������б�<br>
            ���ԣ� <br>
            typeid: Ϊ0ʱ��ʾ����Ƶ���б�����Ϊ�����Ŀ���¼������б�<br>
            ֧�֣�InnerText<br>
            ����ģ���ֶΣ�typelink typename <br>
            7��<font color="#3300FF">{dede:channelArtlist typeid=0 bgcolor='' background=''}{/dede}</font> <br>
            ��;�����ڻ�ȡĳ��Ŀ���¼���Ŀ��ָ�������������б������� artlist ���������ԣ����Ƕ������¼������ԣ�<br>
            col ���� <br>
            bgcolor ��Ŀ����ı�����ɫ<br>
            background ��Ŀ����ı���ͼƬ<br>
            titleheight ��Ŀ������и�<br>
            titleimg ��Ŀ�����ͼƬ��Ĭ�ϵ�����£�����Ϊ����ţ���Ϊ�����ڲ����ʺϷ�ͼƬ��<br>
            tablewidth ��Ŀ�б��Ŀ�ȣ�һ�����ʱ�������ã�<br>
            ����            <br>
            {dede:channelArtlist typeid=0 col=2 row=6 bgcolor=#A09D74 background='/php/modpage/img/2-mbg2.gif' titleheight='22' titleimg='/php/modpage/img/file.gif'


 tablewidth='98%'

/} <br>
            ��Щ���ӵ����������ڶ�����Ŀ��������ʽ��<br>
              ���������б����ʽ�������Ժ�artlist�����ȫ��ͬ����ο�{dede:artlist/}��ǡ�            <br>
            8��<font color="#3300FF">{dede:webinfo name=''/} <br>
            </font>��;�����һ��ϵͳ���ò�����<br>
            Ŀǰ֧�֣�webname��baseurl��adminemail��powerby<br>
            9��<font color="#3300FF">{dede:mynews row='����'}{/dede}</font><br>
վ�����Ż�ȡ��Innertext֧�ֵ��ֶ�Ϊ��title,writer,senddate(ʱ��),msg ��<br>
10��<font color="#3300FF">{dede:field name=''/}</font><br>
��ȡĳ��Ŀ����Ϣ��������Ŀ�������Ч��<br>
11��<font color="#3300FF">{dede:extern name=''/}</font><br>
���ϵͳ������ <br>
12��<font color="#3300FF">{dede:loop table=&quot;����&quot; sort=&quot;����&quot; row=&quot;����&quot; if=&quot;����&quot;}{/dede}<br>
</font>��ȡһ�������ֶΣ���һ��ʮ�����ı�ǣ�Ϊ�����汾�Ĳ�������ӿڱ�ǣ�����������ԣ���Innertext��ʹ�õĲ��ǲ�������Ϊ�ֶΣ�����һ��XML��ǣ���ʽ���£�<br>
&lt;loop:field name='�ֶ���' function='���ڴ���ĺ���' parameter='��������(��&quot;,&quot;�ֿ�)'/&gt;<br> 
����<br>
{dede:loop table=&quot;dede_art&quot; sort=&quot;click&quot;}<br>
&lt;loop:field name='title' function='substr' parameter='1,20'/&gt;&lt;br&gt;<br>
{/dede}</p>
            <hr size="1">
            <font color="#FF0000"><u><strong><img src="img/spectag.gif" width="184" height="38"><a name="spec" id="spec"></a></strong></u></font> 
            <br>
            <font color="#FF0000"><u><strong>��ר��ģ���</strong></u><strong>��ѡ������룺</strong></font> 
            <br>
            ר��Ĺ��ܺ���һ��û��ʲô�䶯��Ψ���Ǵ�����ĸı䡣<br>
            1��<span class="style4">{dede:field name=&quot;value&quot;/}</span> 
            ���һ��ָ�����ֶΡ�<br>
            value����Ϊ��ֵ��title��specimg(ר��ͼƬ������)��specmsg(ר����)��click��id ��position(���³���)<br>
            �Ƿ�֧�ֶ���ģ�壺��֧��<br>
            2��<span class="style5">{dede:speclist titlelength=&quot;24&quot;}{/dede}</span><br>
            ר�������б�<br>
            �Ƿ�֧�ֶ���ģ�壺֧��<br>
            InnerText֧�ֵ��ֶΣ� filename��title��stime��ID <br>
            3��<span class="style5">{dede:speclike titlelength=&quot;24&quot;}{/dede}</span><br>
            ר����������б�<br>
            �Ƿ�֧�ֶ���ģ�壺֧��<br>
            InnerText֧�ֵ��ֶΣ� filename��title��stime��ID <br>
            4��<span class="style5">{dede:coolart titlelength=&quot;24&quot; line=&quot;6&quot;}{/dede}</span><br>
            ��;�����������ͬ������µ��Ƽ��������б� <br>
            ���ԣ�titlelength ���ⳤ�� line ������� ֧��innertext<br>
            �Ƿ�֧�ֶ���ģ�壺֧��<br>
            InnerText֧�ֵ��ֶΣ� filename��title��stime��ID<br>
            5��<span class="style5">{dede:hotart titlelength=&quot;24&quot; line=&quot;6&quot;}{/dede}</span> 
            <br>
            ��;�����������ͬ������µ��ȵ�������б�<br>
            ���ԣ�titlelength ���ⳤ�� line ������� ֧��innertext<br>
            �Ƿ�֧�ֶ���ģ�壺֧��<br>
            InnerText֧�ֵ��ֶΣ� filename��title��stime��ID <br>
            6��<span class="style5">{dede:channel type=&quot;&quot;}{/dede}</span><br>
��;����������Ŀ��<br>
���ԣ�type ���ͣ�ֵö��Ϊ�� sun �¼����࣬top ����Ƶ���б�self ͬ������<br>
֧��innertext<br>
InnerText֧�ֵ��ֶΣ� typelink��typename</td>
        </tr>
        <tr>
          <td colspan="3">&nbsp;</td>
        </tr>
      </table> </td>
</tr>
</table>
</body>
</html>