<?
require_once(dirname(__FILE__)."/config.php");
?>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
<title>ģ�����ο�--�б�ģ����</title>
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
    <td height="19" background="img/tbg.gif"><b>ģ�����ο�--�б�ģ����</b></td>
</tr>
<tr>
<td bgcolor="#FFFFFF" valign="top">
<table width="98%" border="0" cellspacing="2">
        <tr> 
          <td colspan="3">�����б�ģ����ָ��ʾ�����ĵ���ҳ�б����ʽģ�塣</td>
        </tr>
        <tr> 
          <td colspan="3" bgcolor="#F9FBF0"><strong>1�������б��С<a name="1"></a></strong></td>
        </tr>
        <tr> 
          <td height="29" colspan="3" bgcolor="#FFFFFF">{dede:page pagesize='ÿҳ�������'/}</td>
        </tr>
        <tr> 
          <td colspan="3" bgcolor="#F9FBF0"><strong>2����ҳ�ĵ��б�<a name="2"></a></strong></td>
        </tr>
        <tr> 
          <td colspan="3"> <table width="96%" border="0" cellspacing="2" cellpadding="2">
              <form name="form1" action="action_tag_test.php" target="_blank" method="post">
                <input type="hidden" name="dopost" value="make">
                <tr> 
                  <td width="430">ʹ�ñ�ǣ�list<a href="help_templet.php#311" target="_blank"><u>[�ο�]</u></a>�����룺</td>
                  <td width="156" align="center">&nbsp; </td>
                </tr>
                <tr> 
                  <td colspan="2">{dede:list col='' titlelen='' <br/>
                    infolen='' imgwidth='' imgheight='' orderby=''}{/dede:list}</td>
                </tr>
                <tr> 
                  <td colspan="2"><strong>list�̶��ײ�ģ�����(����[field:name/])��</strong><br>
                    id,title,iscommend,color,typeid,ismake,description(ͬ info),pubdate,senddate,<br>
                    arcrank,click,litpic(ͬ picname),typedir,typename,arcurl(ͬ 
                    filename),typeurl,<br>
                    stime(pubdate ��&quot;0000-00-00&quot;��ʽ),textlink,typelink,imglink,image<br> 
                    <strong>�䶯�ĵײ������</strong> <br>
                    list�������ʹ�ø��ӱ�����κ��ֶ���Ϊ�ײ����������Ҫ��Ƶ��ģ�������á�</td>
                </tr>
              </form>
            </table></td>
        </tr>
        <tr> 
          <td colspan="3" bgcolor="#F9FBF0"><strong>3�������ҳ�������<a name="3"></a></strong></td>
        </tr>
        <tr> 
          <td height="110" colspan="3">��ʾ[1][2][3]�����ķ�ҳ�������ӡ�<br>
            {dede:pagelist listsize='3'/} <br>
            listsize ��ʾ�������ֵĳ���/2����listsize=3��ʾ<font color="#660000"> '��һҳ [1][2][3][4][5][6][7] 
            ��һҳ' </font>��������ʽ��</td>
        </tr>
      </table> </td>
</tr>
</table>
</body>
</html>