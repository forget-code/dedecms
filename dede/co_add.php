<?php 
require_once(dirname(__FILE__)."/config.php");
CheckPurview('co_AddNote');
require_once(dirname(__FILE__)."/../include/inc_typelink.php");
if(empty($action)) $action = "";
if(empty($exrule)) $exrule = "";

if($action=="select"){
	require_once(dirname(__FILE__)."/co_sel_exrule.php");
	exit();
}

if($exrule==""){
	ShowMsg("����ѡ��һ���������","co_sel_exrule.php");
	exit();
}

require_once(dirname(__FILE__)."/../include/pub_dedetag.php");
$dsql = new DedeSql(false);
$row = $dsql->GetOne("Select * From #@__co_exrule where aid='$exrule'");
$dsql->Close();
$ruleset = $row['ruleset'];
$dtp = new DedeTagParse();
$dtp->LoadString($ruleset);
$noteid = 0;
if(is_array($dtp->CTags))
{
	foreach($dtp->CTags as $ctag){
		if($ctag->GetName()=='field') $noteid++;
		if($ctag->GetName()=='note') $noteinfos = $ctag;
	}
}
else
{
	ShowMsg("�ù��򲻺Ϸ����޷��������ɲɼ�����!","-1");
	$dsql->Close();
	exit();
}

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<script language='javascript' src='main.js'></script>
<script language='javascript'>
function ShowHide(objname)
{
   var obj = document.getElementById(objname);
   if(obj.style.display=="none") obj.style.display = "block";
	 else obj.style.display="none";
}

function ShowItem(objname)
{
 	var obj = document.getElementById(objname);
 	obj.style.display = "block";
}

</script>
<title>�����ɼ��ڵ�</title>
<link href="base.css" rel="stylesheet" type="text/css">
</head>
<body background='img/allbg.gif' leftmargin='8' topmargin='8'>
<form name="form1" method="post" action="co_add_action.php">
<input type='hidden' name='exrule' value='<?php echo $exrule?>'>
  <table width="98%" border="0" cellpadding="2" cellspacing="1" bgcolor="#98CAEF" align="center" style="margin-bottom:6px">
    <tr> 
      <td height="20" background='img/tbg.gif'><table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr> 
            <td width="47%" height="18"><b>�������ɼ��ڵ㣺</b></td>
            <td width="53%" align="right">
			<input type="button" name="b11" value="�ڵ����"  class='nbt' style="width:80" onClick="location.href='co_main.php';"> 
			&nbsp;
			<input type="button" name="b12" value="�ڵ����"  class='nbt' style="width:80" onClick="location.href='co_url.php';">
            &nbsp;
			</td>
          </tr>
        </table> </td>
    </tr>
</table>
  <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" id="head1">
    <tr> 
      <td colspan="2"> <table border="0" cellpadding="0" cellspacing="0">
          <tr> 
            <td width="84" height="24" align="center" background="img/itemnote1.gif">&nbsp;��ַ��ȡ</td>
            <td width="84" align="center" background="img/itemnote2.gif"><a href="#" onClick="ShowItem2()"><u>���ݹ���</u></a>&nbsp;</td>
          </tr>
        </table></td>
    </tr>
  </table>
  <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" id="head2" style="display:none">
    <tr> 
      <td colspan="2"> <table height="24" border="0" cellpadding="0" cellspacing="0">
          <tr> 
            <td width="84" align="center" background="img/itemnote2.gif"><a href="#" onClick="ShowItem1()"><u>��ַ��ȡ</u></a>&nbsp;</td>
            <td width="84" align="center" background="img/itemnote1.gif">���ݹ���</td>
          </tr>
        </table></td>
    </tr>
  </table>
  <table width="98%" border="0" cellpadding="3" cellspacing="1" bgcolor="#98CAEF" align="center" style="margin-bottom:6px" id="needset"">
    <tr> 
      <td bgcolor="#F2F6E5"> <table width="400" border="0" cellspacing="0" cellpadding="0">
          <tr class="top" onClick="ShowHide('sitem');" style="cursor:hand"> 
            <td width="26" align="center"><img src="img/file_tt.gif" width="7" height="8"></td>
            <td width="374">�ڵ������Ϣ<a name="d1"></a></td>
          </tr>
        </table></td>
    </tr>
    <tr id="sitem" style="display:block"> 
      <td bgcolor="#FFFFFF">
<table width="98%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="18%" height="24">�ڵ����ƣ�</td>
            <td width="32%"><input name="notename" type="text" id="notename" style="width:200"></td>
            <td width="18%">ҳ����룺</td>
            <td width="32%"> <input type="radio" name="language" class="np" value="gb2312" checked>
              GB2312 
              <input type="radio" name="language" class="np" value="utf-8">
              UTF8 
              <input type="radio" name="language" class="np" value="big5">
              BIG5 </td>
          </tr>
          <tr> 
            <td height="24">ͼƬ�����ַ�� </td>
            <td> 
              <?php 
		$aburl = "";
		$curl = GetCurUrl();
		$curls = explode("/",$curl);
		for($i=0;$i<count($curls)-2;$i++){
			if($i!=0) $aburl .= "/".$curls[$i];
		}
		$aburl .= "/upimg";
          ?>
              <input name="imgurl" type="text" id="imgurl" style="width:200" value="<?php echo $aburl?>"></td>
            <td>����·����</td>
            <td><input name="imgdir" type="text" id="imgdir2" style="width:150" value="../upimg"></td>
          </tr>
          <tr> 
            <td height="24">����ƥ��ģʽ��</td>
            <td colspan="3"> <input type="radio" class="np" name="matchtype" value="regex">
              ������ʽ 
              <input name="matchtype" class="np" type="radio" value="string" checked>
              �ַ��� </td>
          </tr>
          <tr bgcolor="#F0F2EE"> 
            <td height="24" colspan="4">����ѡ����ڿ���������ģʽ�����趨�����Ŀ����վû�з��������ܣ��벻Ҫ����������ή�Ͳɼ��ٶȡ�</td>
          </tr>
          <tr> 
            <td height="24">������ģʽ��</td>
            <td><input name="isref" type="radio" class="np" value="no" checked>
              ������ 
              <input name="isref" type="radio" class="np" value="yes">
              ����</td>
            <td>��Դ���س�ʱʱ�䣺</td>
            <td><input name="exptime" type="text" id="exptime" value="10" size="8">
              ��</td>
          </tr>
          <tr> 
            <td height="24">������ַ��</td>
            <td colspan="3"><input name="refurl" type="text" id="refurl" size="30">
              ��һ��ΪĿ����վ����һ������ҳ����ַ�����http://��</td>
          </tr>
        </table>
      </td>
    </tr>
    <tr> 
      <td bgcolor="#F2F6E5"> <table width="400" border="0" cellspacing="0" cellpadding="0">
          <tr class="top" onClick="ShowHide('slist');" style="cursor:hand"> 
            <td width="26" align="center"><img src="img/file_tt.gif" width="7" height="8"></td>
            <td width="374">�ɼ��б��ȡ����</td>
          </tr>
        </table></td>
    </tr>
    <tr id="slist" style="display:block"> 
      <td height="76" bgcolor="#FFFFFF"><table width="98%" border="0" cellspacing="0" cellpadding="0">
          
          <tr>
            <td height="24">��Դ��ַ��ȡ��ʽ��</td>
            <td colspan="2"><input name="source" type="radio" id="radio" value="var" class="np" checked>
�����ض����е���ַ
  <input name="source" type="radio" id="source" value="app" class="np"> 
  ���Լ��ֹ�ָ����Щ��ַ</td>
          </tr>
          
          <tr>
            <td height="24">��Դ��ַ���ԣ�</td>
            <td colspan="2"><input name="sourcetype" type="radio" class="np" value="list" checked>
����������ַ���б���ַ
  <input type="radio" name="sourcetype" class="np" value="archives">
������ַ</td>
          </tr>
          <tr> 
            <td width="18%" height="24">��Դ��ַ��</td>
            <td colspan="2"><input name="sourceurl" type="text" id="sourceurl" style="width:70%" value="http://">            </td>
          </tr>
          <tr> 
            <td height="24">&nbsp;</td>
            <td colspan="2">���ڱȽϹ���ֶ�ҳ���б���ַ���� http://abc.com/list.php?page=[var:��ҳ] 
              ����ʽ��Ȼ��ָ��&quot;��ҳ������ʼֵ&quot;��</td>
          </tr>
          <tr>
            <td height="24" colspan="3" bgcolor="#FBFDF2"><strong>�����Դ��ַ���б���ַ����ָ����������������ַ��ȡ��������ԣ�</strong></td>
          </tr>
          <tr>
            <td height="24">��ҳ������ʼֵ��</td>
            <td colspan="2"><input name="varstart" type="text" id="varstart2" size="15">
������������ֵ��
  <input name="varend" type="text" id="varend2" size="15">
����ʾ [var:��ҳ] �ķ�Χ�� </td>
          </tr>
          <tr> 
            <td height="24">������ַ�������</td>
            <td colspan="2"><input name="need" type="text" id="cannot" size="15">
              ����ַ���ܰ����� 
              <input name="cannot" type="text" id="cannot" size="15">
              ��(����)</td>
          </tr>
          <tr> 
            <td height="100">�����������<br>
              ��������������ʽ�޷���ȷ�����Ҫ����ַ�������ô�ѡ�<br>            </td>
            <td width="42%">
			��ʼHTML��<br>
			<textarea name="linkareas" style="width:90%" rows="5" id="linkareas"></textarea>            </td>
            <td width="40%">
			����HTML��<br>
			<textarea name="linkareae" style="width:90%" rows="5" id="linkareae"></textarea>			</td>
          </tr>
          
          <tr>
            <td height="24" colspan="3" bgcolor="#FBFDF2"><strong>��������ֹ�ָ��Ҫ�ɼ�����ַ����˹�����ַ�⣬����������ַ����������ָ����</strong></td>
          </tr>
          <tr>
            <td height="110" valign="top"><strong>�ֹ�ָ����ַ��</strong><a href="javascript:ShowHide('handurlhelp');"><img src="img/help.gif " width="16" height="16" border="0"></a><br>
              (ÿ��һ����ַ��<br>
              ��֧��ʹ�ñ���)</td>
            <td colspan="2">
			<span id='handurlhelp' style='display:none;background-color:#efefef'>
			���ڲ��ݷ��Ϲ��򣬲��ݲ����Ϲ������ַ�����԰Ѳ����Ϲ���ķ������������<br>
http://xx.com/aaa/index.html<br>
http://xx.com/aaa/list_2.html<br>
http://xx.com/aaa/list_3.html...<br>
��������ַ��������ñ���ָ�� list_[var:��ҳ].html��<br>
Ȼ��� 
            http://xx.com/aaa/index.html(����ַ������ҳ����) ��д�����档			</span>
<textarea name="sourceurls" id="sourceurls" style="width:95%;height:100"></textarea></td>
          </tr>
          
          <!--
		  //��ʱ��ʱ����ɴ���
		  tr align="center"> 
            <td height="49" colspan="3"><input name="test1" type="button" class="nbt" id="test1" value="�����б��ȡ����">            </td>
          </tr-->
        </table></td>
    </tr>
</table>

  <table width="98%" border="0" cellpadding="3" cellspacing="1" bgcolor="#98CAEF" align="center" id="adset" style="display:none">
    <tr> 
      <td bgcolor="#F2F6E5"><table width="400" border="0" cellspacing="0" cellpadding="0">
          <tr class="top" onClick="ShowHide('sart');" style="cursor:hand"> 
            <td width="26" align="center"><img src="img/file_tt.gif" width="7" height="8"></td>
            <td width="374">�ĵ����ݻ�ȡ����<a name="d2"></a></td>
          </tr>
        </table></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF">
	  <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:6px">
          <tr> 
            <td height="24" colspan="3">�����Ե�ҳ��ַ�� 
              <input name="testurl" type="text" id="testurl" value="http://" size="50">
              �������ڱ༭������ɺ���ԣ�����ʱ���᱾�ػ�Զ��ý�壩</td>
          </tr>
          <tr> 
            <td height="60" colspan="3"><strong>���ֶ�����˵����</strong><br/>
              ��������������ɼ�������Ϊ��ҳ�ĵ�����������body�ֶ�&quot;��ҳ�����ֶ�&quot;���ѡ��򹴡�<br/>
              �������������������ֶ�ֵʹ�õĲ���[var:����]������ָ��������ֵ���򵼳�ʱֱ��ʹ�ø�ֵ�����Ҳɼ�ʱ�����������Ŀ��<br>
              ���������˹�������ж����������{dede:teim}����һ{/dede:trim}����{dede:teim}�����{/dede:trim}...��ʾ</td>
          </tr>
          <tr bgcolor="#EBEFD1"> 
            <td height="24"><strong>���ĵ��Ƿ��ҳ��</strong></td>
            <td colspan="2"> <input name="sptype" type="radio" class="np" value="none" checked>
              ����ҳ 
              <input name="sptype" type="radio" value="full" class="np">
              ȫ���г��ķ�ҳ�б� 
              <input type="radio" name="sptype" class="np" value="next">
              ����ҳ��ʽ�������ķ�ҳ�б�</td>
          </tr>
          <tr> 
            <td width="18%" height="60">��ҳ��������ƥ�����<br/>
              �ĵ��ֶ�ҳʱ����ѡ����</td>
            <td> ��ҳ��������ʼHTML�� <br> <textarea name="sppages" rows="3" id="sppages" style="width:90%"></textarea> 
            </td>
            <td width="40%"> ��ҳ�����������HTML�� <br> <textarea name="sppagee" rows="3" id="textarea10" style="width:90%"></textarea> 
            </td>
          </tr>
        </table>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:6px">
          <tr> 
            <td width="98%" height="26" colspan="3" background="img/menubg.gif" bgcolor="#66CCFF">��<strong>�������ֶ��б�</strong>(һ�㡰�Զ��崦��ӿڡ����д��������ֶ�[��ɫ��]����Ҫ���)</td>
          </tr>
        </table>
        <?php 
          if(is_array($dtp->CTags))
          {
	          $s = 0;
	          foreach($dtp->CTags as $ctag)
	          {
		           if($ctag->GetName()=='field')
		           {
		             if($ctag->GetAtt('source')=='value') continue;
		             
		             $tagv = "[var:����]";
		             //if($ctag->GetAtt('source')=='function') 
		             //else $fnv = "";
		             $fnv = $ctag->GetInnerText();
		             
		             $cname = $ctag->GetAtt('name');
		             
		             if($ctag->GetAtt('intable')!="" 
		                  && $ctag->GetAtt('intable')!=$noteinfos->GetAtt('tablename') )
		             {
		             	  $cname = $ctag->GetAtt('intable').'.'.$cname;
		             }
		             $comment = $ctag->GetAtt('comment');
		             $s++;
          ?>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:6px">
          <tr bgcolor="#EBEFD1"> 
            <td width="18%" height="24" bgcolor="#EBEFD1"> &nbsp; 
			<?php 
			if($ctag->GetAtt('source')!='function'){ $fcolor=" style='color:red' "; $tstyle=""; }
			else{ $fcolor=""; $tstyle=" style='display:none' "; }
			?>
			<a href="javascript:ShowHide('fieldlist<?php echo $s; ?>');"<?php echo $fcolor?>><b>��<u><?php echo $comment?></u></b></a>
			<input type="hidden" name="comment<?php echo $s; ?>" id="comment<?php echo $s; ?>4" value="<?php echo $comment?>"> 
            </td>
            <td width="22%"> <input name="field<?php echo $s; ?>" type="text" id="field<?php echo $s; ?>4" value="<?php echo $cname?>" size="22"></td>
            <td width="20%" align="right">�ֶ�ֵ��</td>
            <td width="40%"> <input name="value<?php echo $s; ?>" type="text" id="value<?php echo $s; ?>4" value="<?php echo $tagv?>" size="25"> 
            </td>
          </tr>
          <tr> 
            <td colspan="4">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" id="fieldlist<?php echo $s; ?>"<?php echo $tstyle?>>
                <tr> 
                  <td height="80">ƥ�����ݣ�</td>
                  <td height="20">��ʼ���ظ�HTML��<br> <textarea name="matchs<?php echo $s; ?>" rows="4" id="textarea11" style="width:90%"></textarea> 
                  </td>
                  <td height="20">��β���ظ�HTML��<br> <textarea name="matche<?php echo $s; ?>" rows="4" id="textarea12" style="width:90%"></textarea> 
                  </td>
                </tr>
                <tr> 
                  <td height="63">���˹���</td>
                  <td height="63"> <textarea name="trim<?php echo $s; ?>" cols="20" rows="3" id="textarea13" style="width:90%"></textarea> 
                  </td>
                  <td height="63"> <input name="isunit<?php echo $s; ?>" type="checkbox" id="isunit<?php echo $s; ?>4" value="1" class="np">
                    ��ҳ�����ֶΣ�������ֻ����һ�ĸ������ֶΣ�<br/> <input name="isdown<?php echo $s; ?>" type="checkbox" id="isdown<?php echo $s; ?>4" value="1" class="np">
                    �����ֶ���Ķ�ý����Դ </td>
                </tr>
                <tr> 
                  <td width="18%" height="60">�Զ��崦��ӿڣ�</td>
                  <td width="42%" height="20"><textarea name="function<?php echo $s; ?>" cols="20" rows="3" id="textarea14" style="width:90%"><?php echo $fnv?></textarea> 
                  </td>
                  <td width="40%" height="20">���������ı���<br>
                    @body ��ʾԭʼ��ҳ @litpic ����ͼ<br>
                    @me ��ʾ��ǰ���ֵ�����ս��</td>
                </tr>
              </table></td>
          </tr>
        </table>
        <?php  } } } ?>
      </td>
    </tr>
    <tr> 
      <td height="50" align="center" bgcolor="#FFFFFF">
<!--input name="test122" type="button" class="nbt" id="test124" value="�������ݻ�ȡ����"-->
        ��
<input type="submit" name="b1222" value="����ڵ�" class="nbt" style="width:80"></td>
    </tr>
    <tr id="sart" style="display:block"> 
      <td valign="top" bgcolor="#FFFFFF"> </td>
    </tr>
  </table>
	</form>
</body>
</html>