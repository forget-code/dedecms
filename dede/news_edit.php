<?
require_once("config.php");
require_once("inc_typelink.php");
$ID = ereg_replace("[^0-9]","",$artID);
$conn = connectMySql();
$rs = mysql_query("Select dede_art.*,dede_arttype.typename,dede_arttype.channeltype from dede_art left join dede_arttype on dede_art.typeid=dede_arttype.ID where dede_art.ID=$ID",$conn);
$row = mysql_fetch_object($rs);
if($row->spec > 0) header("location:news_spec_edit.php?ID=".$row->spec);
?>
<html>
<head>
<meta http-equiv="Content-Language" content="zh-cn">
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>Html�༭��</title>
<link href="htmledit/base.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
var doc;
var winsize;
//��ҳ����ʱ�����������-------
function LoadEditor()
{
	doc=document.frames.Editor.document;
	doc.designMode = "On";
	Editor.focus();
	if(document.all)
	{
		document.all.menuBar.style.width=(screen.width-200)+"px";
		document.all.Editor.style.width=(screen.width-200)+"px";
		document.all.myView.style.width=screen.width-200;
		document.all.artbody.style.width=(screen.width-200)+"px";
		winsize=0;
	}
}
function resideEditor()
{
	if(winsize==0){
		document.all.menuBar.style.width=(screen.width-80)+"px";
		document.all.Editor.style.width=(screen.width-80)+"px";
		document.all.myView.style.width=screen.width-80;
		document.all.artbody.style.width=(screen.width-80)+"px";
		winsize=1;
	}
	else
	{
		document.all.menuBar.style.width=(screen.width-220)+"px";
		document.all.Editor.style.width=(screen.width-220)+"px";
		document.all.myView.style.width=screen.width-220;
		document.all.artbody.style.width=(screen.width-220)+"px";
		winsize=0;
	}
}
function ShowEditor()
{
	document.all.myView.style.visibility="visible";
	doc.body.innerHTML = document.form1.artbody.value;  
	document.all.myCode.style.visibility="hidden";  
	//Editor.focus();
}
function ShowCodeEditor()
{
	document.all.myView.style.visibility="hidden";
    document.all.myCode.style.visibility="visible";
    document.form1.artbody.value = doc.body.innerHTML;
    //document.form1.artbody.focus();
}
function ClearContent()
{
	document.form1.artbody.value = "";
	doc.body.innerHTML = "";
}
function doFontName(fn){
	doc.execCommand('FontName', false, fn);
	Editor.focus();
}
function doFontSize(fs){
	doc.execCommand('FontSize', false, fs);
	Editor.focus();
}
function doFontColor(){
	var fcolor=showModalDialog("htmledit/color.htm",false,"dialogWidth:300px;dialogHeight:280px;status:0;");
	doc.execCommand('ForeColor',false,fcolor);
	Editor.focus();
}
function doInsertTable(){
	var dotable=showModalDialog("htmledit/table.htm",false,"dialogWidth:330px;dialogHeight:170px;status:0;");
	if (dotable!=undefined){
		doc.selection.createRange().pasteHTML(dotable);
	}
	else
	{
		return false;
	}
	Editor.focus();
}
function doInsertBr()
{
	doc.selection.createRange().pasteHTML("<br>");
	Editor.focus();
}
function doInsertBn()
{
	doc.selection.createRange().pasteHTML("&nbsp;");
	Editor.focus();
}
function doInsertImage(){
	window.open("htmledit/image.php", 'imagein', 'scrollbars=no,resizable=no,width=440,height=380,left=100, top=50,screenX=0,screenY=0');
}
function doInsertFlash(){
	var dotable=showModalDialog("htmledit/flash.htm",false,"dialogWidth:330px;dialogHeight:150px;status:0;");
	if (dotable!=undefined){
		doc.selection.createRange().pasteHTML(dotable);
	}
	else
	{
		return false;
	}
	Editor.focus();
}

function doInsertSoft(){
	window.open("make_softlink.php?artID=<?=$ID?>",'softin','scrollbars=no,resizable=no,width=410,height=240,left=100, top=100,screenX=0,screenY=0');
}

function doSubmit()
{
	if(document.all.myCode.style.visibility=="hidden")
		document.form1.artbody.value = doc.body.innerHTML;
	if(document.form1.title.value=="")
	{
   		document.form1.title.focus();
   		alert("���±��ⲻ��Ϊ�գ�");
   		return false;
	}
	if(document.form1.typeid.value=="0")
	{
   		document.form1.typeid.focus();
   		alert("���±���ѡ��һ�����࣡");
   		return false;
	}
	if(document.form1.artbody.value=="")
	{
   		alert("�������ݲ���Ϊ�գ�");
   		return false;
	}
	document.form1.submit();
}
</script>
</head>
<body bgcolor="#FAFCF1" leftmargin="20" topmargin="0" onResize="resideEditor();">
<table width="600" border="0" cellspacing="0" cellpadding="0">
  <form name="form1" method="post" action="news_edit_ok.php">
  <input type="hidden" name="ishtml" value="1">
  <input type="hidden" name="artID" value="<?=$ID?>">
    <tr> 
      <td height="120" valign="top"> 
        <!--������HTML�༭���޹�-->
        <table width="600" border="0" cellpadding="0" cellspacing="0">
          <tr> 
            <td height="2"></td>
          </tr>
          <tr> 
            <td height="22"> <table width="100%" border="0" cellspacing="0" cellpadding="0" height="22">
                <tr> 
                  <td width="5%" align="center" valign="bottom"><img src="htmledit/img/addnews.gif">&nbsp;</td>
                  <td width="60%"><strong>�༭����</strong> (���ҳ������: #p# �ɽ����·ֶ�ҳ��ʾ) </td>
                  <td width="35%"></td>
                </tr>
              </table></td>
          </tr>
          <tr bgcolor="#cccccc"> 
            <td height="1"></td>
          </tr>
          <tr bgcolor="#ffffff"> 
            <td height="1"></td>
          </tr>
          <tr> 
            <td height="2"></td>
          </tr>
          <tr> 
            <td height="95" valign="top"> <table width="99%" border="0" align="right" cellpadding="0" cellspacing="0">
                <tr> 
                  <td width="12%" height="22" nowrap>���±��⣺</td>
                  <td width="38%"><input name="title" type="text" id="title" size="28" value="<?=$row->title?>"></td>
                  <td width="12%" nowrap>����ѡ�</td>
                  <td width="38%"> <input type="checkbox" name="isdd[]" id="isdd" value="1"<?if($row->isdd==1) echo " checked";?>>
                    ͼƬ&nbsp; <input type="checkbox" name="redtitle[]" id="redtitle" value="1"<?if($row->redtitle==1) echo " checked";?>>
                    �Ƽ� </td>
                </tr>
                <tr> 
                  <td height="22">������Դ��</td>
                  <td colspan="3"><input name="source" type="text" id="source" size="20" value="<?=$row->source?>"> 
                    �������ߣ� <input name="writer" type="text" id="writer" size="12" value="<?=$row->writer?>">
                    ����ʱ�䣺 
                    <input name="stime" type="text" id="stime" size="12" value="<?=$row->stime?>"></td>
                </tr>
                <tr> 
                  <td height="22">�������</td>
                  <td colspan="3"> 
				  <select name="typeid" id="typeide">
                      <?
    					echo "<option value='".$row->typeid."' selected>".$row->typename."</option>\r\n";
    					$ut = new TypeLink();
						$ut->GetOptionArray(0,0,1);
					?>
                    </select> &nbsp; �������£� 
                    <select name="rank" id="rank">
                      <?
                      $rs2 = mysql_query("Select * From dede_membertype where rank=".$row->rank,$conn);
                      $row2=mysql_fetch_object($rs2);
                      echo "<option value=\"".$row2->rank."\">".$row2->membername."</option>\n";
					  if($cuserLogin->getUserType()==10||$cuserLogin->getUserType()==5)
					  {
                      		$rs2 = mysql_query("Select * From dede_membertype where rank!=".$row->rank,$conn);
                      		while($row2=mysql_fetch_object($rs2))
                      		{
                      			echo "<option value=\"".$row2->rank."\">".$row2->membername."</option>\n";
                      		}
					  }
                      ?>
                    </select> &nbsp;&nbsp; <input name="button" type="button" class="coolbg" style="width:80;height:22;font-size:10pt;line-height:130%" onClick="doSubmit();" value="��������"> 
                  </td>
                </tr>
                <tr> 
                  <td height="60">���¼�����</td>
                  <td colspan="3"><textarea name="shortmsg" cols="60" rows="3" id="shortmsg"> <?=$row->msg?> </textarea></td>
                </tr>
                <tr> 
             		<td height="22">����ѡ�</td>
             		<td colspan="3">
             		<?if($isUrlOpen) echo "<input type='checkbox' name='saveremoteimg' value='1'>Զ��ͼƬ���ػ�  ";?>
             		</td>
           		</tr>
              </table></td>
          </tr>
        </table>
        <!--������Ϣ���ݽ���-->
      </td>
    </tr>
    <tr> 
      <td>
	  <table width="600" border="0" cellpadding="0" cellspacing="0" bgcolor="#E0FAAF" id="menuBar">
          <tr bgcolor="#cccccc"> 
            <td height="1" colspan="21"></td>
          </tr>
          <tr bgcolor="#ffffff"> 
            <td height="1" colspan="21"></td>
          </tr>
          <tr> 
            <td width="24" height="24"><a href="javascript:;" onClick="doSubmit();"><img src="htmledit/img/save.gif" alt="����" width="22" height="22" border="0"></a></td>
            <td width="22"><img src="htmledit/img/sp.gif" width="22" height="22"></td>
            <td width="24"><a href="javascript:;" onClick="doc.execCommand('undo');"><img src="htmledit/img/redo.gif" alt="����" width="22" height="22" border="0"></a></td>
            <td width="24"><a href="javascript:;" onClick="doc.execCommand('redo');"><img src="htmledit/img/undo.gif" alt="����" width="22" height="22" border="0"></a></td>
            <td width="24"><img src="htmledit/img/sp.gif" width="22" height="22"></td>
            <td width="24"><a href="javascript:;" onClick="doInsertImage();"><img src="htmledit/img/img.gif" alt="����ͼƬ" width="22" height="22" border="0"></a></td>
            <td width="24"><a href="javascript:;" onClick="doInsertFlash();"><img src="htmledit/img/swf.gif" alt="flash" width="22" height="22" border="0"></a></td>
            <td width="24"><a href="javascript:;" onClick="doInsertTable();"><img src="htmledit/img/table.gif" alt="������" width="22" height="22" border="0"></a></td>
            <td width="24"><a href="javascript:;" onClick="doc.execCommand('CreateLink');"><img src="htmledit/img/link.gif" alt="������" width="22" height="22" border="0"></a></td>
            <td width="24"><img src="htmledit/img/sp.gif" width="22" height="22"></td>
            <td width="24"><a href="javascript:;" onClick="doFontColor();"><img src="htmledit/img/color.gif" alt="������ɫ" width="22" height="22" border="0"></a></td>
            <td width="22">&nbsp;</td>
            <td colspan="9"> 
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
                  <td width="14%">���壺</td>
                  <td width="35%"> <select name="selectFont" id="selectFont" style="height:18px" onChange="doFontName(this[this.selectedIndex].value);this.selectedIndex=0;">
                      <option value="0">--Ĭ��--</option>
                      <option value="����">����</option>
                      <option value="����">����</option>
                      <option value="����_GB2312">����_GB2312</option>
                      <option value="Arial">Arial</option>
                      <option value="Arial Black">Arial Black</option>
                    </select></td>
                  <td width="17%">����С��</td>
                  <td width="34%"> <select name="selectSize" id="selectSize" style="height:18px" onChange="doFontSize(this[this.selectedIndex].value);this.selectedIndex=0;">
                      <option value="0">Ĭ��</option>
                      <option value="1">1 (8��)</option>
                      <option value="2">2 (10��)</option>
                      <option value="3">3 (12��)</option>
                      <option value="4">4 (14��)</option>
                      <option value="5">5 (18��)</option>
                      <option value="6">6 (24��)</option>
                      <option value="7">7 (36��)</option>
                    </select></td>
                </tr>
              </table>
			  </td>
          </tr>
          <tr bgcolor="#cccccc"> 
            <td height="1" colspan="22"></td>
          </tr>
          <tr bgcolor="#ffffff"> 
            <td height="1" colspan="22"></td>
          </tr>
          <tr> 
            <td height="24"><a href="javascript:;" onClick="doc.execCommand('JustifyLeft');"><img src="htmledit/img/left.gif" alt="�����" width="22" height="22" border="0"></a></td>
            <td><a href="javascript:;" onClick="doc.execCommand('JustifyCenter');"><img src="htmledit/img/center.gif" alt="����" width="22" height="22" border="0"></a></td>
            <td><a href="javascript:;" onClick="doc.execCommand('JustifyRight');"><img src="htmledit/img/right.gif" alt="�Ҷ���" width="22" height="22" border="0"></a></td>
            <td><img src="htmledit/img/sp.gif" width="22" height="22"></td>
            <td><a href="javascript:;" onClick="doc.execCommand('Underline');"><img src="htmledit/img/u.gif" alt="�»���" width="22" height="22" border="0"></a></td>
            <td><a href="javascript:;" onClick="doc.execCommand('Bold');"><img src="htmledit/img/b.gif" alt="�Ӵ�" width="22" height="22" border="0"></a></td>
            <td><a href="javascript:;" onClick="doc.execCommand('Italic');"><img src="htmledit/img/i.gif" width="22" height="22" border="0"></a></td>
            <td><img src="htmledit/img/sp.gif" width="22" height="22"></td>
            <td><a href="javascript:;" onClick="doInsertBn();"><img src="htmledit/img/nbsp.gif" alt="�ո�" width="22" height="22" border="0"></a></td>
            <td><a href="javascript:;" onClick="doInsertBr();"><img src="htmledit/img/br.gif" alt="����" width="22" height="22" border="0"></a></td>
            <td><a href="javascript:;" onClick="doc.execCommand('InsertHorizontalRule');"><img src="htmledit/img/hr.gif" alt="����" width="22" height="22" border="0"></a></td>
            <td><img src="htmledit/img/sp.gif" width="22" height="22"></td>
            <td width="6">&nbsp;</td>
            <td width="29"><a href="javascript:;" onClick="doc.execCommand('Copy');"><img src="htmledit/img/copy.gif" alt="����" width="22" height="22" border="0"></a></td>
            <td width="26"><a href="javascript:;" onClick="doc.execCommand('Paste');"><img src="htmledit/img/par.gif" alt="ճ��" width="22" height="22" border="0"></a></td>
            <td width="26"><input name="modeCheck" type="radio" value="1" onClick="ShowEditor();"></td>
            <td width="48">���ӻ�</td>
            <td width="22"><input type="radio" name="modeCheck" value="0" onClick="ShowCodeEditor();" checked></td>
            <td width="58">�༭Դ��</td> 
    <td width="120" align="center"><a href="javascript:;" onClick="doInsertSoft();">�������������</a></td>
          </tr>
		  <tr bgcolor="#cccccc"> 
            <td height="1" colspan="22"></td>
          </tr>
          <tr bgcolor="#ffffff"> 
            <td height="1" colspan="22"></td>
          </tr>
        </table>
        </td>
    </tr>
    <tr> 
      <td height="1" colspan="19"></td>
    </tr>
    <tr> 
      <td height="1" colspan="19"></td>
    </tr>
    <tr> 
      <td height="278" valign="top"> 
        <!--����Ϊ�༭������-->
        <div id="myView" style="position:absolute; left:20px; top:244px; width:620px; height:378px;visibility:hidden"> 
          <iframe id="Editor" marginwidth="1" scrolling="yes" style="height:377px;width:620px;background-color:white;"></iframe>
        </DIV>
        <div id="myCode" style="position:absolute; left:20px; top:243px; width:596px; height:378px"> 
          <textarea name="artbody" cols="65" rows="23" id="artbody" style="width:600px;height:377px;"> <?=$row->body?> </textarea>
        </DIV>
        <script language="JavaScript">
        LoadEditor();
        </script> 
        <!--//�༭������//����-->
      </td>
    </tr>
  </form>
</table>
</body>

</html>
