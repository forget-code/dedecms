<?php 
require_once(dirname(__FILE__)."/config.php");
@set_time_limit(1800);


if(empty($dopost)) $dopost = "";
if(empty($reset)) $reset = "";

//�û�Action
if($dopost=="yes"){
  if($reset=='yes'){
  	$dsql = new DedeSql(false);
  	$dsql->ExecuteNoneQuery("Update #@__archives set templet='' where channel<>-1");
  	$dsql->Close();
  	echo "��ɻ�ԭ���� Action has finish";
  }else{
		$dsql = new DedeSql(false);
		
		if($autotype=='empty'){
			$addquery = " And templet='' ";
		}else if($autotype=='hand'){
			if(!empty($startid)) $addquery .= " And ID>=$startid ";
			if(!empty($endid)) $addquery .= " And ID<=$endid ";
		}else{
			$addquery = "";
		}
		$okquery = "Select ID From #@__archives where channel='$channeltype' $addquery ";
		$dsql->SetQuery($okquery);
		$dsql->Execute();
		while($row = $dsql->GetArray()){
			$temparticleok = addslashes(str_replace('{rand}',mt_rand($rndstart,$rndend),$temparticle));
			$dsql->ExecuteNoneQuery("Update #@__archives set templet='$temparticleok' where ID='{$row['ID']}' ");
		}
		
  	$dsql->Close();
  	echo "��ɴ���";
	}
	exit();
}
//��ȡ����ģ������
$dsql = new DedeSql(false);
$dsql->SetQuery("select * from #@__channeltype where ID>-1 And isshow=1 order by ID");
$dsql->Execute();
while($row=$dsql->GetObject()){
  $channelArray[$row->ID]['typename'] = $row->typename;
  $channelArray[$row->ID]['nid'] = $row->nid;
}
$dsql->Close();
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>���ģ����ɼ����</title>
<link href="base.css" rel="stylesheet" type="text/css">
<script language="javascript">
var channelArray = new Array();
<?php     
$i = 0;
foreach($channelArray as $k=>$arr){
   echo "channelArray[$k] = \"{$arr['nid']}\";\r\n";
}
?>

function SelectTemplets(fname){
   var posLeft = window.event.clientY-200;
   var posTop = window.event.clientX-300;
   window.open("../include/dialog/select_templets.php?f="+fname, "poptempWin", "scrollbars=yes,resizable=yes,statebar=no,width=600,height=400,left="+posLeft+", top="+posTop);
}
    
function ParTemplet(obj)
{
  var sevvalue = channelArray[obj.value];
  var temparticle = document.getElementsByName('temparticle');
  temparticle[0].value = "{style}/article_"+sevvalue+"_{rand}.htm";
}

function CheckPathSet()
{
	var surl = document.getElementById("siteurl");
	var sreid = document.getElementById("reID");
	var mysel = document.getElementById("truepath3");
	if(surl.value!=""){
		if(sreid.value=="0" || sreid.value==""){
			mysel.checked = true;
		}
	}
}

</script>
</head>
<body background='img/allbg.gif' leftmargin='8' topmargin='8'>
<table width="98%" border="0" cellpadding="3" cellspacing="1" bgcolor="#98CAEF" align="center">
  <form action="rnd_templets_main.php" name="form2" target="stafrm">
  <input type="hidden" name="dopost" value="yes">
  <input type="hidden" name="reset" value="yes">
  </form>
  <form action="rnd_templets_main.php" name="form1" target="stafrm">
  <input type="hidden" name="dopost" value="yes">
  <tr> 
    <td height="20" background='img/tbg.gif'> <table width="98%" border="0" cellpadding="0" cellspacing="0">
        <tr> 
            <td width="30%" height="18"><strong>���ģ����ɼ������</strong></td>
          <td width="70%" align="right">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
  <tr>
      <td height="33" bgcolor="#FFFFFF">����ʹ�������ģ����ɼ������ԭ����Ŀ�������ģ�������Ч��������������ڴ����ѷ������ĵ���ģ�塣</td>
  </tr>
  <tr> 
    <td height="48" bgcolor="#FFFFFF"><table width="90%" border="0" cellpadding="2" cellspacing="2">
          <tr> 
            <td width="17%">Ƶ��ģ�ͣ� </td>
            <td width="83%"><select name="channeltype" id="channeltype" style="width:200px" onChange="ParTemplet(this)">
                <?php     
            foreach($channelArray as $k=>$arr)
            {
            	if($k==1) echo "    <option value='{$k}' selected>{$arr['typename']}|{$arr['nid']}</option>\r\n";
               else  echo "    <option value='{$k}'>{$arr['typename']}|{$arr['nid']}</option>\r\n";
            }
            ?>
              </select> </td>
          </tr>
          <tr> 
            <td>ģ�����ƣ�</td>
            <td>
            	<input name="temparticle" type="text" value="{style}/article_article_{rand}.htm" style="width:300"> 
              <input type="button" name="set4" value="���..." style="width:60" onClick="SelectTemplets('form1.temparticle');" class='nbt'>
             </td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td>������ֹ�ָ��ģ�壬��ô��Ҫ��������{rand}��������������</td>
          </tr>
          <tr> 
            <td>�����ţ�</td>
            <td><input name="rndstart" type="text" id="rndstart" value="1" size="8">
              �� 
              <input name="rndend" type="text" id="rndend" value="5" size="8"></td>
          </tr>
          <tr>
            <td>�Զ����£�</td>
            <td>
<input name="autotype" type="radio" class="np" value="empty" checked>
              ֻ����ûָ��ģ����ĵ�
              <input type="radio" class="np" name="autotype" value="all">
              ����ȫ�� 
              <input type="radio" class="np" name="autotype" value="hand">
              �ֹ�ָ��ID</td>
          </tr>
          <tr> 
            <td>��ʼID��</td>
            <td> 
              <input name="startid" type="text" id="startid" size="8">
              ����ID��
              <input name="endid" type="text" id="endid" size="8"></td>
          </tr>
        </table></td>
  </tr>
  <tr> 
    <td height="31" bgcolor="#F8FBFB" align="center">
	<input type="submit" name="Submit" value="��ʼ�������ģ��" class="np">
	&nbsp;
    <input type="button" name="Submit2" value="�ָ�Ĭ��ģ��" class="np" onClick="document.form2.submit()">
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
    <td id="mtd">
    	<div id='mdv' style='width:100%;height:100;'> 
        <iframe name="stafrm" frameborder="0" id="stafrm" width="100%" height="100%"></iframe>
      </div>
      <script language="JavaScript">
	    document.all.mdv.style.pixelHeight = screen.height - 420;
	    </script>
	   </td>
  </tr>
</table>
</body>
</html>
