<?php 
require_once(dirname(__FILE__)."/config.php");
@set_time_limit(0);
CheckPurview('sys_ArcBatch');
if(empty($dopost)) $dopost = '';
if($dopost=='analyse'){
	$dsql = new DedeSql(false);
	$dsql->SetQuery("Select count(title) as dd,title From #@__archives group by title order by dd desc limit 0,$pagesize");
	$dsql->Execute();
	$allarc = 0;
	require_once(dirname(__FILE__)."/templets/article_test_same.htm");
	$dsql->Close();
	exit();
}else if($dopost=='delsel'){
	require_once(dirname(__FILE__)."/../include/inc_typelink.php");
	require_once(dirname(__FILE__)."/inc/inc_batchup.php");
	if(empty($titles)){
		header("Content-Type: text/html; charset=gb2312");
		echo "û��ָ��ɾ�����ĵ���";
		exit();
	}
	$titless = split('`',$titles);
	$dsql = new DedeSql(false);
	if($deltype=='delnew') $orderby = " order by ID desc ";
	else $orderby = " order by ID asc ";
	$totalarc = 0;
	foreach($titless as $title){
		 $title = trim($title);
		 if($title=='') $q1 = "Select * From #@__archives where title='' $orderby ";
		 else{
		 	  $title = addslashes(urldecode($title));
		 	  $q1 = "Select ID,title From #@__archives where title='$title' $orderby ";
		 }
		 $dsql->SetQuery($q1);
		 $dsql->Execute();
		 $rownum = $dsql->GetTotalRow();
		 if($rownum<2) continue;
		 $i = 1;
		 while($row = $dsql->GetObject()){
		 	 $i++;
		 	 $naid = $row->ID;
		 	 $ntitle = $row->title;
		 	 if($i > $rownum){ continue; }
		 	 $totalarc++;
		 	 DelArc($naid);
		 }
	}
	$dsql->Close();
	ShowMsg("һ��ɾ����[{$totalarc}]ƪ�ظ����ĵ���","article_test_same.php?dopost=analyse&deltype=$deltype&pagesize=$pagesize");
	exit();
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�ظ��ĵ����</title>
<link href="base.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin='8' topmargin='8'>
<table width="98%" border="0" cellpadding="3" cellspacing="1" bgcolor="#98CAEF" align="center">
  <form action="article_test_same.php?" name="form1" target="stafrm">
    <input type='hidden' name='dopost' value='analyse'>
    <tr> 
      <td height="20" background='img/tbg.gif'> <table width="98%" border="0" cellpadding="0" cellspacing="0">
          <tr> 
            <td width="30%" height="18"><strong>�ظ��ĵ���⣺</strong></td>
            <td width="70%" align="right">&nbsp;</td>
          </tr>
        </table></td>
    </tr>
    <tr>
      <td height="31" bgcolor="#F8FBFB" align="center">
	  <table width="98%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="20%" height="30">ɾ��ѡ�</td>
            <td> <input name="deltype" type="radio" class="np" value="delnew" checked>
              ������ɵ�һ�� 
              <input type="radio" name="deltype" value="delold" class="np">
              �������µ�һ��</td>
          </tr>
          <tr> 
            <td height="30">ÿ���г���¼��</td>
            <td><input name="pagesize" type="text" id="pagesize" value="100" size="10">
              ��</td>
          </tr>
        </table>
		</td>
    </tr>
    <tr> 
      <td height="31" bgcolor="#F8FBFB" align="center"> <input type="submit" name="Submit" value="���������ظ����ĵ�" class="nbt"> 
      </td>
    </tr>
  </form>
  <tr bgcolor="#E5F9FF"> 
    <td height="20"> <table width="100%">
        <tr> 
          <td width="74%"><strong>�����</strong></td>
          <td width="26%" align="right"> <script language='javascript'>
            	function ResizeDiv(obj,ty)
            	{
            		if(ty=="+") document.all[obj].style.pixelHeight += 50;
            		else if(document.all[obj].style.pixelHeight>80) document.all[obj].style.pixelHeight = document.all[obj].style.pixelHeight - 50;
            	}
            	</script>
            [<a href='#' onClick="ResizeDiv('mdv','+');">����</a>] [<a href='#' onClick="ResizeDiv('mdv','-');">��С</a>] 
          </td>
        </tr>
      </table></td>
  </tr>
  <tr bgcolor="#FFFFFF"> 
    <td id="mtd"> <div id='mdv' style='width:100%;height:100;'> 
        <iframe name="stafrm" frameborder="0" id="stafrm" width="100%" height="100%"></iframe>
      </div>
      <script language="JavaScript">
	  document.all.mdv.style.pixelHeight = screen.height - 420;
	  </script> </td>
  </tr>
</table>
</body>
</html>
