<?
require(dirname(__FILE__)."/config.php");
require(dirname(__FILE__)."/../include/inc_photograph.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>DedeCms Home</title>
<link rel="stylesheet" type="text/css" href="base.css">
<base target="_self">
</head>
<body leftmargin="8" topmargin='8'>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#111111" style="BORDER-COLLAPSE: collapse">
  <tr> 
    <td width="100%" height="20" valign="top">
    	<table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td height="30">
          	<IMG height=14 src="img/book1.gif" width=20>
          	 &nbsp;��ӭʹ���й���ǿ��Ŀ�Դ��վ���ݹ�����Ŀ 
            -- <?=$cfg_softname?>�� 
           </td>
        </tr>
      </table>
      </td>
  </tr>
  <tr> 
    <td width="100%" height="1" background="img/sp_bg.gif"></td>
  </tr>
  <tr> 
    <td width="100%" height="4"></td>
  </tr>
  <tr> 
    <td width="100%" height="20">
	<table width="100%"  border="0" cellpadding="4" cellspacing="1" bgcolor="#CBD8AC">
        <tr>
          <td colspan="2" background="img/wbg.gif" bgcolor="#EEF4EA"><font color="#666600"><b><?=$cfg_soft_enname?> ������Ϣ</b></font></td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td height="63" colspan="2">
          <table width="100%"  border="0" cellspacing="1" cellpadding="1">
              <form name="uploadspider" action="upload_spider.php" method="post">
                <tr> 
                  <td width="15%" align="center"><img src="img/ico_spider.gif" width="90" height="70"></td>
                  <td><?=GetNewInfo()?></td>
                </tr>
              </form>
            </table>
          </td>
        </tr>
      </table>
	  <br/>
	  <table width="100%"  border="0" cellpadding="4" cellspacing="1" bgcolor="#CBD8AC">
        <tr> 
          <td colspan="2" background="img/wbg.gif" bgcolor="#EEF4EA"><font color="#666600"><b>��ݹ���</b></font></td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td height="30" colspan="2" align="center" valign="bottom"><table width="100%" border="0" cellspacing="1" cellpadding="1">
              <tr>
                <td width="15%" height="31" align="center">
                	<img src="img/qc.gif" width="90" height="30">
                </td>
                <td width="85%" valign="bottom">
                	<img src="img/manage1.gif" width="17" height="14">
                	<a href="sys_info.php"><u>����ϵͳ����</u></a>
                	
                	<img src="img/part-index.gif" width="16" height="16">
                	<a href="makehtml_homepage.php"><u>������ҳHTML</u></a>
                	
                	<img src="img/part-list.gif" width="16" height="16">
                	<a href="makehtml_list.php"><u>����ָ����Ŀ��HTML</u></a>
                	
                	<img src="img/addnews.gif" width="16" height="16">
                	<a href="content_list.php"><u>�ĵ��б�</u></a>
                	
                	<img src="img/menuarrow.gif" width="16" height="15">
                	<a href="feedback_main.php"><u>���۹���</u></a>
                	
                	<img src="img/manage1.gif" width="17" height="14">
                	<a href="catalog_main.php"><u>���ݷ���</u></a>
                </td>
              </tr>
            </table></td>
        </tr>
      </table>
	<br/>
	<table width="100%"  border="0" cellpadding="4" cellspacing="1" bgcolor="#CBD8AC">
        <tr bgcolor="#EEF4EA"> 
          <td colspan="2" background="img/wbg.gif"><font color="#666600"><b>ϵͳ������Ϣ</b></font></td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td width="25%" bgcolor="#FFFFFF">��ļ���</td>
          <td width="75%" bgcolor="#FFFFFF"> 
            <?
        if($cuserLogin->getUserType()==10) echo "�ܹ���Ա";
        else if($cuserLogin->getUserType()==5) echo "Ƶ���ܱ�";
        else echo "��Ϣ�ɼ�Ա����������Ա";
        ?>
          </td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td rowspan="5">PHP����ժҪ��</td>
          <td> PHP�汾�� 
            <?=@phpversion();?>
            &nbsp;
            GD�汾�� 
           <?=@gdversion()?>
           </td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td>
          	�Ƿ�ȫģʽ��<font color='red'><?=($isSafeMode ? 'On' : 'Off')?></font>
          	<?
          	if($isSafeMode) echo "<br>����<font color='blue'>�������ϵͳ�԰�ȫģʽ���У�Ϊ��ȷ����������ԣ���һ�ν��뱾ϵͳʱ����ġ�<a href='sys_info.php'><u>����ϵͳ����</u></a>�����FTPѡ���ѡ����FTP��ʽ����Ŀ¼����ɺ�<a href='testenv.php' style='color:red'><u>����˽���һ��DedeCmsĿ¼Ȩ�޼��&gt;&gt;</u></a></font>";
          	else echo "��<a href='testenv.php' style='color:blue'><u>������һ�ν��뱾ϵͳ���������˽���һ��DedeCmsĿ¼Ȩ�޼��&gt;&gt;</u></a></font>";
          	?>
          </td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td>Register_Globals��<font color='red'> 
            <?=ini_get("register_globals") ? 'On' : 'Off'?>
            </font> &nbsp; Magic_Quotes_Gpc��<font color='red'> 
            <?=ini_get("magic_quotes_gpc") ? 'On' : 'Off'?>
            </font></td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td>֧���ϴ�������ļ��� 
            <?=ini_get("post_max_size")?>
          </td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td>�Ƿ������Զ�����ӣ� 
            <?=ini_get("allow_url_fopen") ? '֧��' : '��֧��'?>
          </td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td>ϵͳժҪ��</td>
          <td> ����������
		  <?
		  $dsql = new DedeSql(false);
		  $row = $dsql->GetOne("Select count(ID) as cc From #@__archives");
		  $dsql->Close();
		  echo $row['cc'];
		  ?>
		  </td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td>����汾��Ϣ��</td>
          <td>
          	�汾���ƣ�<?=$cfg_soft_enname?>
          	&nbsp;
          	�汾�ţ�<?=$cfg_version?>
          </td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td width="25%">�����Ŷӣ�</td>
          <td width="75%"><?=$cfg_soft_devteam?></td>
        </tr>
      </table>
	<br/>
	<table width="100%"  border="0" cellpadding="4" cellspacing="1" bgcolor="#CBD8AC">
        <tr bgcolor="#EEF4EA"> 
          <td colspan="2" background="img/wbg.gif"><b><font color="#666600">ʹ�ð���</font></b></td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td height="43">�ٷ���̳��</td>
          <td><a href="http://bbs.dedecms.com/" target="_blank"><u>http://bbs.dedecms.com</u></a></td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td width="25%" height="43">DedeCmsģ���ǲο���</td>
          <td width="75%"> <a href="help_templet.php#1"><u>�����������</u></a> ��<a href="help_templet.php#2"><u>ģ����ƹ淶</u></a> 
            ��<a href="help_templet.php#3"><u>����ο�</u></a><br/>
            ��ǲο��� <a href="help_templet.php#31"><u>arclist(artlist,likeart,hotart,imglist,imginfolist,coolart,specart)</u></a> 
            &nbsp;<a href="help_templet.php#32"><u>field</u></a> &nbsp;<a href="help_templet.php#33"><u>channel</u></a> 
            &nbsp;<a href="help_templet.php#34"><u>mytag</u></a> &nbsp;<a href="help_templet.php#35"><u>vote</u></a> 
            &nbsp;<a href="help_templet.php#36"><u>friendlink</u></a> &nbsp;<a href="help_templet.php#37"><u>mynews</u></a> 
            &nbsp;<a href="help_templet.php#38"><u>loop</u></a> &nbsp;<a href="help_templet.php#39"><u>channelartlist</u></a> 
            &nbsp;<a href="help_templet.php#310"><u>page</u></a> &nbsp;<a href="help_templet.php#311"><u>list</u></a> 
            &nbsp;<a href="help_templet.php#312"><u>pagelist</u></a> </td>
        </tr>
      </table>
      </td>
  </tr>
  <tr> 
    <td width="100%" height="2" valign="top"></td>
  </tr>
</table>
<p align="center">
<?=$cfg_powerby?>
<br/><br/>
</p>
</body>

</html>