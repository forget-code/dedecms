<?php 
require_once(dirname(__FILE__)."/config.php");
CheckPurview('co_EditNote');
require_once(dirname(__FILE__)."/../include/pub_dedetag.php");
require_once(dirname(__FILE__)."/../include/inc_typelink.php");
if($nid=="") 
{
	ShowMsg("������Ч!","-1");	
	exit();
}
$dsql = new DedeSql(false);
$rowFirst = $dsql->GetOne("Select * from #@__conote where nid='$nid'");
$notename = $rowFirst['gathername'];
$notes = $rowFirst['noteinfo'];
$exrule = $rowFirst['typeid'];
$dsql->FreeResult();
$dtp = new DedeTagParse();
$dtp->SetNameSpace("dede","{","}");
$dtp2 = new DedeTagParse();
$dtp2->SetNameSpace("dede","{","}");
$dtp3 = new DedeTagParse();
$dtp3->SetNameSpace("dede","{","}");
$dtp->LoadString($notes);
foreach($dtp->CTags as $tid => $ctag)
{
	if($ctag->GetName()=="item")
	{
		$imgurl = $ctag->GetAtt("imgurl");
		$imgdir = $ctag->GetAtt("imgdir");
		$language = $ctag->GetAtt("language");
		$matchtype = $ctag->GetAtt("matchtype");
		$refurl = $ctag->GetAtt("refurl");
		$isref = $ctag->GetAtt("isref");
		$exptime = $ctag->GetAtt("exptime");
	}
	else if($ctag->GetName()=="list")
	{
		$sunnote = $ctag->GetInnerText();
		$dtp2->LoadString($sunnote);
		$source = $ctag->GetAtt('source');
		$sourcetype = $ctag->GetAtt('sourcetype');
		$varstart = $ctag->GetAtt('varstart');
		$varend = $ctag->GetAtt('varend');
		$urlTag = $dtp2->GetTagByName('url');
		$needTag = $dtp2->GetTagByName('need');
		$cannotTag = $dtp2->GetTagByName('cannot');
		$linkareaTag = $dtp2->GetTagByName('linkarea');
	}
	else if($ctag->GetName()=="art")
	{
		$sunnote = $ctag->GetInnerText();
		$dtp3->LoadString($sunnote);
		$sppageTag = $dtp3->GetTagByName('sppage');
  }
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�޸Ĳɼ��ڵ�</title>
<link href="base.css" rel="stylesheet" type="text/css">
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
</head>
<body background='img/allbg.gif' leftmargin='8' topmargin='8'>
<form name="form1" method="post" action="co_edit_action.php">
 <input type='hidden' name='exrule' value='<?php echo $exrule?>'>
  <input type='hidden' name='nid' value='<?php echo $nid?>'>
  <table width="98%" border="0" cellpadding="2" cellspacing="1" bgcolor="#98CAEF" align="center" style="margin-bottom:6px">
    <tr> 
      <td height="20" background='img/tbg.gif'><table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr> 
            <td width="47%" height="18"><b>�����Ĳɼ��ڵ㣺</b></td>
            <td width="53%" align="right"> <input type="button" name="b11" value="�ڵ����"  class='nbt' style="width:80" onClick="location.href='co_main.php';"> 
              &nbsp; <input type="button" name="b122" value="�ڵ����"  class='nbt' style="width:80" onClick="location.href='co_url.php';"> 
              &nbsp; </td>
          </tr>
        </table></td>
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
  <table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#98CAEF" id="needset" style="margin-bottom:6px">
    <tr> 
      <td bgcolor="#F2F6E5">
      	<table width="400" border="0" cellspacing="0" cellpadding="0">
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
            <td width="16%" height="24">�ڵ����ƣ�</td>
            <td width="26%"><input name="notename" type="text" id="notename" value="<?php echo $notename?>" style="width:150"></td>
            <td width="17%">ҳ����룺</td>
            <td width="41%"> <input type="radio" name="language" class="np" value="gb2312"<?php if($language=='gb2312') echo " checked";?>>
              GB2312 
              <input type="radio" name="language" class="np" value="utf-8"<?php if($language=='utf-8') echo " checked";?>>
              UTF8 
              <input type="radio" name="language" class="np" value="big5"<?php if($language=='big5') echo " checked";?>>
              BIG5 </td>
          </tr>
          <tr> 
            <td height="24">ͼƬ�����ַ�� </td>
            <td><input name="imgurl" type="text" id="imgurl" style="width:150" value="<?php echo $imgurl?>"></td>
            <td>����·����</td>
            <td><input name="imgdir" type="text" id="imgdir2" style="width:150" value="<?php echo $imgdir?>"></td>
          </tr>
          <tr> 
            <td height="24">����ƥ��ģʽ�� </td>
            <td><input type="radio" name="matchtype" class="np" value="regex"<?php if($matchtype=="regex") echo " checked";?>>
              ������ʽ 
              <input name="matchtype" type="radio" class="np" value="string"<?php if($matchtype=="string"||$matchtype=="") echo " checked";?>>
              �ַ��� </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr bgcolor="#F0F2EE"> 
            <td height="24" colspan="4">����ѡ����ڿ���������ģʽ�����趨�����Ŀ����վû�з��������ܣ��벻Ҫ����������ή�Ͳɼ��ٶȡ�</td>
          </tr>
          <tr> 
            <td height="24">������ģʽ��</td>
            <td><input name="isref" type="radio" class="np" value="no"<?php if($isref=="no"||$isref=="") echo " checked";?>>
              ������ 
              <input name="isref" type="radio" class="np" value="yes"<?php if($isref=="yes") echo " checked";?>>
              ����</td>
            <td>��Դ���س�ʱʱ�䣺</td>
            <td><input name="exptime" type="text" id="exptime" value="<?php echo $exptime?>" size="8">
              ��</td>
          </tr>
          <tr> 
            <td height="24">������ַ��</td>
            <td colspan="3"><input name="refurl" type="text" id="refurl" size="45" value="<?php echo $refurl?>">
              �����http://��</td>
          </tr>
        </table>
      </td>
    </tr>
    <tr> 
      <td bgcolor="#F2F6E5">
      	<table width="400" border="0" cellspacing="0" cellpadding="0">
          <tr class="top" onClick="ShowHide('slist');" style="cursor:hand"> 
            <td width="26" align="center"><img src="img/file_tt.gif" width="7" height="8"></td>
            <td width="374">�ɼ��б��ȡ����</td>
          </tr>
        </table>
      </td>
    </tr>
    <tr id="slist" style="display:block"> 
      <td height="76" bgcolor="#FFFFFF">
      	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
		  <td height="24">��Դ��ַ��ȡ��ʽ��</td>
            <td colspan="2">
            	<input name="source" type="radio" id="radio" value="var" onClick="ShowHide('surls');" class="np"<?php if($source=="var") echo " checked";?>>
�����ض����е���ַ
  <input name="source" type="radio" id="source" value="app" class="np" onClick="ShowHide('surls');"<?php if($source=="app") echo " checked";?>> 
  ���Լ��ֹ�ָ����Щ��ַ
            </td>
          </tr>
          <tr>
            <td height="24">��Դ��ַ���ԣ�</td>
            <td colspan="2">
            	<input name="sourcetype" type="radio" class="np" value="list"<?php if($sourcetype=="list"||$sourcetype=="") echo " checked";?>>
              ����������ַ���б���ַ 
              <input type="radio" name="sourcetype" class="np" value="archives"<?php if($sourcetype=="archives") echo " checked";?>>
              ������ַ
              </td>
          </tr>
          <tr> 
            <td width="18%" height="24">��Դ��ַ��</td>
            <td colspan="2">
            	<input name="sourceurl" type="text" id="sourceurl" style="width:500" value="<?php echo $urlTag->GetAtt('value')?>">               </td>
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
            <td colspan="2">
            	<input name="varstart" type="text" id="varstart" size="15" value="<?php echo $varstart?>">
              ��������ֵ�� 
              <input name="varend" type="text" id="varend" size="15" value="<?php echo $varend?>">
              ��ʾ [var:��ҳ] �ķ�Χ��
           </td>
          </tr>
          <tr> 
            <td height="24">������ַ�������</td>
            <td colspan="2">
            	<input name="need" type="text" id="need" size="15" value="<?php echo $needTag->GetInnerText()?>">
              ����ַ���ܰ����� 
              <input name="cannot" type="text" id="cannot" size="15" value="<?php echo $cannotTag->GetInnerText()?>">
              ��(����)
             </td>
          </tr>
          <?php 
			$l1 = '';
			$l2 = '';
			$linkarea = $linkareaTag->GetInnerText();
			if(!empty($linkarea)){
			    $linkareas = explode('[var:����]',$linkarea);
				$l1 = $linkareas[0];
				if(!empty($linkareas[1])) $l2 = $linkareas[1];
			}
			?>
          <tr> 
            <td height="100">
            	�����������<br>��������������ʽ�޷���ȷ�����Ҫ����ַ�������ô�ѡ�<br> 
            </td>
            <td width="42%">
			     ��ʼHTML��<br>
			       <textarea name="linkareas" style="width:90%" rows="5" id="linkareas"><?php echo $l1; ?></textarea> 
			      </td>
            <td width="40%">
			      ����HTML��<br>
			     <textarea name="linkareae" style="width:90%" rows="5" id="linkareae"><?php echo $l2; ?></textarea>			</td>
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
    <textarea name="sourceurls" id="sourceurls" style="width:95%;height:100"><?php echo $urlTag->GetInnerText()?></textarea>
   </td>
		  </tr>
        </table>
		</td>
    </tr>
	</table>
  <table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#98CAEF" id="adset" style="display:none">
    <tr> 
      <td bgcolor="#F2F6E5"> <table width="400" border="0" cellspacing="0" cellpadding="0">
          <tr class="top" onClick="ShowHide('sart');" style="cursor:hand"> 
            <td width="26" align="center"><img src="img/file_tt.gif" width="7" height="8"></td>
            <td width="374">��ҳ���ݻ�ȡ����<a name="d2"></a></td>
          </tr>
        </table></td>
    </tr>
    <tr id="sart" style="display:block"> 
      <td height="113" valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:6px">
          <tr> 
            <td height="24" colspan="3">�����Ե�ҳ��ַ�� 
              <input name="testurl" type="text" id="testurl2" value="http://" size="50">
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
            <td colspan="2"> <input name="sptype" type="radio" class="np" value="none"<?php if($sppageTag->GetAtt('sptype')==""||$sppageTag->GetInnerText()=="") echo " checked"?>>
              ����ҳ 
              <input name="sptype" type="radio" value="full" class="np"<?php if($sppageTag->GetAtt('sptype')=="full") echo " checked"?>>
              ȫ���г��ķ�ҳ�б� 
              <input type="radio" name="sptype" class="np" value="next"<?php if($sppageTag->GetAtt('sptype')=="next") echo " checked"?>>
              ����ҳ��ʽ�������ķ�ҳ�б�</td>
          </tr>
          <tr> 
            <td width="18%" height="60">��ҳ��������ƥ�����<br/>
              �ĵ��ֶ�ҳʱ����ѡ����</td>
            <td> 
              <?php 
			$l1 = '';
			$l2 = '';
			$sppage = $sppageTag->GetInnerText();
			if(!empty($sppage)){
			    $sppages = explode('[var:��ҳ����]',$sppage);
				$l1 = $sppages[0];
				if(!empty($sppages[1])) $l2 = $sppages[1];
			}
			?>
              ��ҳ��������ʼHTML�� <br> <textarea name="sppages" rows="3" id="textarea3" style="width:90%"><?php echo $l1?></textarea> 
            </td>
            <td width="48%"> ��ҳ�����������HTML�� <br> <textarea name="sppagee" rows="3" id="textarea4" style="width:90%"><?php echo $l2?></textarea> 
            </td>
          </tr>
        </table>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:6px">
          <tr> 
            <td width="98%" height="26" colspan="3" background="img/menubg.gif" bgcolor="#66CCFF">��<strong>�������ֶ��б�</strong></td>
          </tr>
        </table>
        <?php 
          $s=0;
          //$dtp->LoadString($notes);
          foreach($dtp3->CTags as $k => $ctag)
          {
          	if($ctag->GetName()=='note')
          	{
          		$s++;
          		$dtp->LoadString($ctag->GetInnerText());
          		$smatch = "";
          		$sfunction = "";
          		$strim = "";
          		$sfield = $ctag->GetAtt('field');
          		$svalue = $ctag->GetAtt('value');
              $sisunit = $ctag->GetAtt('isunit');
              $sisdown = $ctag->GetAtt('isdown');
              $comment = $ctag->GetAtt('comment');
          		foreach($dtp->CTags as $n => $ntag)
          		{
          			$tname = $ntag->GetName();
          			if($tname=='match') $smatch = $ntag->GetInnerText();
          			else if($tname=='function') $sfunction = $ntag->GetInnerText();
          			else if($tname=='trim') $strim .= "{dede:trim}".$ntag->GetInnerText()."{/dede:trim}\r\n";
          		}
          ?>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr bgcolor="#EBEFD1"> 
            <td width="18%" height="24"> &nbsp; 
			 <?php 
			 if($smatch!=""){ $fcolor=" style='color:red' "; $tstyle=""; }
			 else{ $fcolor=""; $tstyle=" style='display:none' "; }
			 ?>
			 <a href="javascript:ShowHide('fieldlist<?php echo $s?>');"<?php echo $fcolor?>><b>��<u><?php echo $comment?></u></b></a>
			  <input type="hidden" name="comment<?php echo $s?>" id="comment<?php echo $s?>2" value="<?php echo $comment?>"> 
            </td>
            <td width="28%"> <input name="field<?php echo $s?>" type="text" id="field<?php echo $s?>2" value="<?php echo $sfield?>" size="22"></td>
            <td width="14%" align="right">�ֶ�ֵ��</td>
            <td width="40%"> <input name="value<?php echo $s?>" type="text" id="value<?php echo $s?>2" value="<?php echo $svalue?>" size="25"> 
            </td>
          </tr>
          <tr> 
            <td colspan="4">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" id="fieldlist<?php echo $s?>"<?php echo $tstyle?>>
                <tr> 
                  <td width="18%" height="80">ƥ������</td>
                  <td height="20"> 
                    <?php 
				  $mm1 = '';
				  $mm2 = '';
				  if(!empty($smatch)){
				     $smatchs = explode('[var:����]',$smatch);
					 $mm1 = $smatchs[0];
					 if(!empty($smatchs[1])) $mm2 = $smatchs[1];
				  }
				  ?>
                    ��ʼ���ظ�HTML��<br> <textarea name="matchs<?php echo $s?>" rows="4" id="matchs<?php echo $s?>" style="width:90%"><?php echo $mm1?></textarea> 
                  </td>
                  <td height="20"> ��β���ظ�HTML��<br> <textarea name="matche<?php echo $s?>" rows="4" id="matche<?php echo $s?>" style="width:90%"><?php echo $mm2?></textarea> 
                  </td>
                </tr>
                <tr> 
                  <td height="63">���˹���</td>
                  <td height="63"> <textarea name="trim<?php echo $s?>" cols="20" rows="3" id="textarea6" style="width:90%"><?php echo $strim?></textarea> 
                  </td>
                  <td height="63"> <input name="isunit<?php echo $s?>" type="checkbox" id="isunit<?php echo $s?>2" value="1" class="np"<?php if($sisunit=='1') echo " checked";?>>
                    ��ҳ�����ֶΣ�������ֻ����һ�ĸ������ֶΣ�<br/> <input name="isdown<?php echo $s?>" type="checkbox" id="isdown<?php echo $s?>2" value="1" class="np"<?php if($sisdown=='1') echo " checked";?>>
                    �����ֶ���Ķ�ý����Դ </td>
                </tr>
                <tr> 
                  <td width="18%" height="60">�Զ��崦��ӿڣ�</td>
                  <td width="42%" height="20"><textarea name="function<?php echo $s?>" cols="20" rows="3" id="textarea7" style="width:90%"><?php echo $sfunction?></textarea> 
                  </td>
                  <td width="40%" height="20"> ���������ı���<br>
                    @body ��ʾԭʼ��ҳ @litpic ����ͼ<br>
                    @me ��ʾ��ǰ���ֵ�����ս�� </td>
                </tr>
              </table></td>
          </tr>
        </table>
        <?php   } } ?>
      </td>
    </tr>
	<tr> 
      <td height="52" align="center" bgcolor="#FFFFFF"> 
        <input type="submit" name="b12" value="����ڵ�" class="coolbg" style="width:80">
      </td>
    </tr>
    <tr> 
      <td height="24" bgcolor="#EBF9D9">&nbsp; </td>
    </tr>
</table>
</form>
</body>
</html>