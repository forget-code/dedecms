<?
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
<table width="98%" border="0" cellpadding="3" cellspacing="1" bgcolor="#666666" align="center">
  <form name="form1" method="post" action="co_add_action.php">
  	<input type='hidden' name='exrule' value='<?=$exrule?>'>
    <tr> 
      <td height="20" background='img/tbg.gif'> <table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr> 
            <td width="47%" height="18"><b>�����ɼ��ڵ㣺</b></td>
            <td width="53%" align="right"> <input type="button" name="b11" value="���ؽڵ����ҳ" class="np2" style="width:110" onClick="location.href='co_main.php';"> 
            </td>
          </tr>
        </table></td>
    </tr>
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
              <?
		$aburl = "";
		$curl = GetCurUrl();
		$curls = explode("/",$curl);
		for($i=0;$i<count($curls)-2;$i++){
			if($i!=0) $aburl .= "/".$curls[$i];
		}
		$aburl .= "/upimg";
          ?>
              <input name="imgurl" type="text" id="imgurl" style="width:200" value="<?=$aburl?>"></td>
            <td>����·����</td>
            <td><input name="imgdir" type="text" id="imgdir2" style="width:150" value="../upimg"></td>
          </tr>
          <tr> 
            <td height="24">����ƥ��ģʽ��</td>
            <td colspan="3"> <input type="radio" class="np" name="macthtype" value="regex">
              ������ʽ 
              <input name="macthtype" class="np" type="radio" value="string" checked>
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
            <td width="18%" height="24">��Դ��ַ��</td>
            <td><input name="sourceurl" type="text" id="sourceurl" style="width:500" value="http://"> 
            </td>
          </tr>
          <tr> 
            <td height="24">��Դ���ԣ�</td>
            <td> <input name="sourcetype" type="radio" class="np" value="list" checked>
              �����б���ַ 
              <input type="radio" name="sourcetype" class="np" value="archives">
              ������ַ�����������ֹ�ָ����ַ����r�� </td>
          </tr>
          <tr>
            <td height="24">��ҳ������ʼֵ��</td>
            <td><input name="varstart" type="text" id="varstart2" size="15">
              ������������ֵ�� 
              <input name="varend" type="text" id="varend2" size="15">
              ����ʾ [var:��ҳ] �ķ�Χ�� </td>
          </tr>
          <tr> 
            <td height="24">��Դ����</td>
            <td>
            	<input name="source" type="radio" id="radio" value="var" class="np" onClick="ShowHide('surls');" checked>
              ������ַ���� [var:��ҳ] ��ʾ���б����� 
              <input name="source" type="radio" id="source" value="app" class="np" onClick="ShowHide('surls');">
              �ֹ�ָ��(�б�/����)��ַ
             </td>
          </tr>
          <tr align="center" id="surls" style="display:none"> 
            <td height="143" colspan="2">
            	<table width="98%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
                  <td height="24">�ֹ�ָ����ַ����ÿ��һ����ַ���������ֹ�ָ����ַ��ʹ�ñ�����</td>
                </tr>
                <tr> 
                  <td align="center">
                  	<textarea name="sourceurls" id="sourceurls" style="width:100%;height:120"><?=$urlTag?></textarea> 
                  </td>
                </tr>
              </table></td>
          </tr>
          <tr> 
            <td height="24">������ַ�������</td>
            <td><input name="need" type="text" id="cannot" size="15">
              ����ַ���ܰ����� 
              <input name="cannot" type="text" id="cannot" size="15">
              ��(����)</td>
          </tr>
          <tr> 
            <td height="24">�����������<br>
              ������<br>
              [var:����]</td>
            <td> <textarea name="linkarea" cols="50" rows="5" id="linkarea">[var:����]</textarea> 
            </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td bgcolor="#F2F6E5"> <table width="400" border="0" cellspacing="0" cellpadding="0">
          <tr class="top" onClick="ShowHide('sart');" style="cursor:hand"> 
            <td width="26" align="center"><img src="img/file_tt.gif" width="7" height="8"></td>
            <td width="374">��ҳ���ݻ�ȡ����<a name="d2"></a></td>
          </tr>
        </table></td>
    </tr>
    <tr id="sart" style="display:block"> 
      <td height="113" valign="top" bgcolor="#FFFFFF"><table width="98%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="18%" height="60">��ҳƥ�����<br/>
              ���ñ�����<br/>
              [var:��ҳ����]</td>
            <td colspan="2"><textarea name="sppage" rows="3" id="sppage" style="width:90%"></textarea></td>
            <td width="48%"> <input name="sptype" type="radio" value="full" class="np" checked>
              ȫ���г��ķ�ҳ�б�<br/> <input type="radio" name="sptype" class="np" value="next">
              ����ҳ��ʽ�������ķ�ҳ�б�</td>
          </tr>
          <tr> 
            <td height="24" colspan="4"><strong> ���ֶ�����˵����</strong><br/>
              ������������ƥ����������У�����һ��Ϊ��<font color="#FF0000">��ʼ���ظ�HTML[var:����]��β���ظ�HTML</font>�������ݹ��˹������������ʽ��<br/>
              �������������������ֶ�ֵʹ�õĲ��Ǳ���������ָ��������ֵ���򵼳�ʱֱ��ʹ�ø�ֵ�����Ҳɼ�ʱ�����������Ŀ��<br>
              ���������˹�������ж����������{dede:teim}����һ{/dede:trim}����{dede:teim}�����{/dede:trim}...��ʾ</td>
          </tr>
          <?
          if(is_array($dtp->CTags))
          {
	          $s = 0;
	          foreach($dtp->CTags as $ctag)
	          {
		           if($ctag->GetName()=='field')
		           {
		             if($ctag->GetAtt('source')=='value') continue;
		             
		             $tagv = "[var:����]";
		             if($ctag->GetAtt('source')=='function') $fnv = $ctag->GetInnerText();
		             else $fnv = "";
		             
		             $cname = $ctag->GetAtt('name');
		             
		             if($ctag->GetAtt('intable')!="" 
		                  && $ctag->GetAtt('intable')!=$noteinfos->GetAtt('tablename') )
		             {
		             	  $cname = $ctag->GetAtt('intable').'.'.$cname;
		             }
		             $comment = $ctag->GetAtt('comment');
		             $s++;
          ?>
          <tr bgcolor="#EBEFD1"> 
            <td height="24">
            	&nbsp;
            <b><?=$comment?></b>
            <input type="hidden" name="comment<?=$s?>" id="comment<?=$s?>" value="<?=$comment?>">
            </td>
            <td width="23%"> <input name="field<?=$s?>" type="text" id="field<?=$s?>" value="<?=$cname?>" size="22"></td>
            <td width="11%">�ֶ�ֵ��</td>
            <td>
            	<input name="value<?=$s?>" type="text" id="value<?=$s?>" value="<?=$tagv?>" size="25">
            </td>
          </tr>
          <tr> 
            <td height="24" colspan="4">
            	<table width="98%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
                  <td width="18%" height="80">ƥ������</td>
                  <td height="20" colspan="2">
                  	<textarea name="match<?=$s?>" rows="4" id="match<?=$s?>" style="width:90%"></textarea>
                  </td>
                </tr>
                <tr> 
                  <td height="63">���˹���</td>
                  <td height="63"> <textarea name="trim<?=$s?>" cols="20" rows="3" id="trim<?=$s?>" style="width:90%"></textarea> 
                  </td>
                  <td height="63"> <input name="isunit<?=$s?>" type="checkbox" id="isunit<?=$s?>" value="1" class="np">
                    ��ҳ�����ֶΣ�������ֻ����һ�ĸ������ֶΣ�<br/> <input name="isdown<?=$s?>" type="checkbox" id="isdown<?=$s?>" value="1" class="np">
                    �����ֶ���Ķ�ý����Դ </td>
                </tr>
                <tr> 
                  <td width="18%" height="60">�Զ��崦��ӿڣ�</td>
                  <td width="42%" height="20"><textarea name="function<?=$s?>" cols="20" rows="3" id="function<?=$s?>" style="width:90%"><?=$fnv?></textarea> 
                  </td>
                  <td width="40%" height="20">���������ı���<br>
                    @body ��ʾԭʼ��ҳ @litpic ����ͼ<br>
                    @me ��ʾ��ǰ���ֵ�����ս��</td>
                </tr>
              </table>
              </td>
          </tr>
          <? } } } ?>
        </table></td>
    </tr>
	<tr> 
      <td height="52" align="center" bgcolor="#FFFFFF"> 
        <input type="submit" name="b12" value="����ڵ�" class="coolbg" style="width:80">
      </td>
    </tr>
    <tr> 
      <td height="24" bgcolor="#EBF9D9">&nbsp; </td>
    </tr>
  </form>
</table>
</body>
</html>