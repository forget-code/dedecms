<?
require_once(dirname(__FILE__)."/config.php");
?>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
<title>ģ�����ο�--����ģ����</title>
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
    <td height="19" background="img/tbg.gif"><b>ģ�����ο�--����ģ����</b></td>
</tr>
<tr>
<td bgcolor="#FFFFFF" valign="top">
<table width="98%" border="0" cellspacing="2">
        <tr> 
          <td>��������ģ�����ǽ��ʺ�����Ŀ�������վ��ҳ�������û��Զ���ĵ�������ҳ��ʹ�õı�ǩ��һ������վ���ʵĲ�����á�</td>
        </tr>
        <tr> 
          <td bgcolor="#F9FBF0"><strong>�����幦�ܻ�ȡͨ�ñ�ǵĴ��룺</strong></td>
        </tr>
        <tr> 
          <td>����<a href="#1">ͶƱ����</a> <a href="#2">��������</a> <a href="#3">վ������</a> 
            <a href="#4">��̳��չ���</a></td>
        </tr>
        <tr> 
          <td bgcolor="#F9FBF0">����<strong>ͶƱ����</strong><a name="1"></a></td>
        </tr>
        <tr> 
          <td>����ͶƱ����ʹ�õı��Ϊvote������ֱ����<a href="vote_main.php"><u><font color="#990000"><strong>ͶƱ����</strong></font></u></a>��ҳ���ȡ�����ϵͳ���ɵı�HTML����Ҫ�Ƿ����û����Լ�����ʽ���ģ��� 
          </td>
        </tr>
        <tr>
          <td bgcolor="#F9FBF0">����<strong>��������</strong><a name="2"></a></td>
        </tr>
        <tr> 
          <td bgcolor="#FFFFFF">����ʹ�ñ�ǣ�friendlink �� flink [<a href="help_templet.php#36"><u>�ο�</u></a>]<br />
          	�����������������ʾ������˹�������Ϊ����ҳ�������ӣ��������ֻ��ʾ����Ϊ����ҳ�������ӣ������ linktype=2 ����
          	</td>
        </tr>
        <tr> 
          <td> <table width="96%" border="0" cellspacing="2" cellpadding="2">
              <form name="form1" action="tag_test_action.php" target="_blank" method="post">
                <input type="hidden" name="dopost" value="make">
                <tr> 
                  <td width="430">��������ʽ��ʾ������˺�����ӣ�</td>
                  <td width="156" align="center"><input type="submit" name="Submit" value="Ԥ��" class="np" style="width:60px"></td>
                </tr>
                <tr> 
                  <td colspan="2"> <textarea name="partcode" style='width:100%' rows="4" id="partcode">{dede:flink type='textall' row='4' col='6' titlelen='16'
 tablestyle='width=100% border=0 cellspacing=1 cellpadding=1'/}</textarea> 
                  </td>
                </tr>
              </form>
            </table> <table width="96%" border="0" cellspacing="2" cellpadding="2">
              <form name="form1" action="tag_test_action.php" target="_blank" method="post">
                <input type="hidden" name="dopost" value="make">
                <tr> 
                  <td width="430">��ͼ�Ļ�����ʽ��ʾ������˺�����ӣ�</td>
                  <td width="156" align="center"><input type="submit" name="Submit" value="Ԥ��" class="np" style="width:60px"></td>
                </tr>
                <tr> 
                  <td colspan="2"> <textarea name="partcode" style='width:100%' rows="4" id="partcode">{dede:flink type='textimage' row='4' col='6' titlelen='16'
 tablestyle='width=100% border=0 cellspacing=1 cellpadding=1'/}</textarea> 
                  </td>
                </tr>
              </form>
            </table>
            <table width="96%" border="0" cellspacing="2" cellpadding="2">
              <form name="form1" action="tag_test_action.php" target="_blank" method="post">
                <input type="hidden" name="dopost" value="make">
                <tr> 
                  <td width="430">����ʾ����Logo����˺�����ӣ�</td>
                  <td width="156" align="center"><input type="submit" name="Submit" value="Ԥ��" class="np" style="width:60px"></td>
                </tr>
                <tr> 
                  <td colspan="2"> <textarea name="partcode" style='width:100%' rows="4" id="partcode">{dede:flink type='text' row='4' col='6' titlelen='16'
 tablestyle='width=100% border=0 cellspacing=1 cellpadding=1'/}</textarea> 
                  </td>
                </tr>
              </form>
            </table> <table width="96%" border="0" cellspacing="2" cellpadding="2">
              <form name="form1" action="tag_test_action.php" target="_blank" method="post">
                <input type="hidden" name="dopost" value="make">
                <tr> 
                  <td width="430">����ʾ��Logo����˺�����ӣ�</td>
                  <td width="156" align="center"><input type="submit" name="Submit" value="Ԥ��" class="np" style="width:60px"></td>
                </tr>
                <tr> 
                  <td colspan="2"> <textarea name="partcode" style='width:100%' rows="4" id="partcode">{dede:flink type='image' row='4' col='6' titlelen='16'
 tablestyle='width=100% border=0 cellspacing=1 cellpadding=1'/}</textarea> 
                  </td>
                </tr>
              </form>
            </table></td>
        </tr>
        <tr> 
          <td bgcolor="#F9FBF0">����<strong>վ������</strong><a name="3"></a></td>
        </tr>
        <tr> 
          <td> <table width='96%' border="0" cellspacing="2" cellpadding="2">
              <form name="form1" action="tag_test_action.php" target="_blank" method="post">
                <input type="hidden" name="dopost" value="make">
                <tr> 
                  <td width="430">ʹ�ñ�ǣ� {dede:mynews row='����' titlelen='���ⳤ��'}Innertext{/dede:mynews}��Innertext֧�ֵ��ֶ�Ϊ��[field:title 
                    /],[field:writer /],[field:senddate /](ʱ��),[field:body /]�� 
                  </td>
                  <td width="156" align="center"><input type="submit" name="Submit" value="Ԥ��" class="np" style="width:60px"></td>
                </tr>
                <tr> 
                  <td colspan="2"> <textarea name="partcode" style='width:100%' rows="4" id="partcode">{dede:mynews row='1' titlelen='24'}
[field:title/]([field:writer/]|[field:senddate function='GetDate("@me")'/])
<hr size=1>
[field:body /]
{/dede:mynews}</textarea></td>
                </tr>
              </form>
            </table></td>
        </tr>
        <tr> 
          <td bgcolor="#F9FBF0">����<strong>��̳��չ���</strong><a name="4"></a></td>
        </tr>
        <tr> 
          <td>������ο���ز��&gt;&gt;</td>
        </tr>
      </table> </td>
</tr>
</table>
</body>
</html>