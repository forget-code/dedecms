<!--
document.onreadystatechange = function(){
	if(document.readyState!="complete") return;
	else parentForm.attachEvent("onsubmit", GetContent);
}

function Load_MyEditor(){
	_MyEDoc = window.frames['_MyEditor'].document;
	_MyEDoc.designMode = "On";
	_MyEditor.focus();
}

function GetContent(){
	if(isediter==1) parentField.value=_MyEDoc.body.innerHTML;
	else parentField.value=document.form1.artbody.value;
	//return parentForm.onsubmit();
}

function GetParentValue(){
	if(_MyEDoc) _MyEDoc.body.innerHTML += parentField.value;
}

function SetContent(fvalue){
	if(isediter==1) _MyEDoc.body.innerHTML = fvalue;
	else document.form1.artbody.value = fvalue;
}

function Show_MyEditor(){
	var tedit = document.getElementById("textedit");
	var hedit = document.getElementById("htmledit");
	var mbar = document.getElementById("menubar");
	tedit.style.display = "none";
  hedit.style.display = "block";
  mbar.style.display = "block";
	_MyEDoc.body.innerHTML = document.form1.artbody.value;
	_MyEditor.focus();
	isediter = 1;
}

function ShowCode_MyEditor(){
	var tedit = document.getElementById("textedit");
  var hedit = document.getElementById("htmledit");
  var mbar = document.getElementById("menubar");
  tedit.style.display = "block";
  hedit.style.display = "none";
  mbar.style.display = "none";
  document.form1.artbody.value = _MyEDoc.body.innerHTML;
  document.form1.artbody.focus();
  isediter = 0;
}


//ִ����������
function doExecute(command,OptionSet)
{
	_MyEditor.focus();
	_MyEDoc.execCommand(command, true, OptionSet);
	_MyEditor.focus();
}
//ѡ��������ʽ
function doFontName(fn){
	_MyEditor.focus();
	_MyEDoc.execCommand('FontName', false, fn);
	_MyEditor.focus();
}
//ѡ�������С
function doFontSize(fs){
	_MyEditor.focus();
	_MyEDoc.execCommand('FontSize', false, fs);
	_MyEditor.focus();
}
//�����ض����ı�
function doInsertText(ntxt)
{
	_MyEditor.focus();
	_MyEDoc.selection.createRange().pasteHTML(ntxt);
	_MyEditor.focus();
}
//����<br>
function doInsertBr()
{
	doInsertText("<br>");
}
//���� nbsp
function doInsertBn()
{
	doInsertText("&nbsp;");
}
//�����ҳ��
function doInsertSplitPage()
{
	doInsertText("#p#��ҳ����#e#");
}
//���öԻ����������
function ShowMsgboxDo(wurl,dw,dh)
{
	_MyEditor.focus();
	var reValue = showModalDialog(wurl, false, 'scroll:no;dialogWidth:'+dw+'px;dialogHeight:'+dh+'px;status:0;');
	if (reValue!=undefined){
		_MyEDoc.selection.createRange().pasteHTML(reValue);
		_MyEditor.focus();
	}
	else{
		_MyEditor.focus();
		return false;
	}
}
//����ͼ��
function doInsertImage(){
	ShowMsgboxDo("image.php?"+Date(),460,420);
}
//����Flash
function doInsertFlash(){
	ShowMsgboxDo("flash.htm?"+Date(),365,150);
}
//����ͼ��
function doInsertImageUser(){
	ShowMsgboxDo("imageuser.php?"+Date(),460,420);
}
//����Flash
function doInsertFlashUser(){
	ShowMsgboxDo("flashuser.htm?"+Date(),365,150);
}
//�����ý���ļ�
function doInsertMedia(){
	ShowMsgboxDo("media.htm?"+Date(),365,180);
}
//ѡ����ɫ
function doFontColor(){
	_MyEditor.focus();
	var fcolor=showModalDialog("color.htm?"+Date(),false,"scroll:no;dialogWidth:300px;dialogHeight:280px;status:0;");
	_MyEDoc.execCommand('ForeColor',false,fcolor);
	_MyEditor.focus();
}
//������
function doInsertTable(){
	ShowMsgboxDo("table.htm?"+Date(),330,200);
}
//���븽��
function doInsertAddon(){
	ShowMsgboxDo("addon.php?"+Date(),450,120);
}
//��������
function doInsertQuote()
{
	var quoteString = "<table style='border-right: #cccccc 1px dotted; table-layout: fixed; border-top: #cccccc 1px dotted; border-left: #cccccc 1px dotted; border-bottom: #cccccc 1px dotted' cellspacing=0 cellpadding=6 width='95%' align=center border=0>\r\n";
  quoteString += "<tr><td style='word-wrap: break-word' bgcolor='#fdfddf'>\r\n<font color='#FF0000'>����Ϊ���õ����ݣ�</font><br>\r\n";
  quoteString += "</td></tr></table>\r\n";
  doInsertText(quoteString);
}
//�����������
function doInsertGroup()
{
  ShowMsgboxDo("group.htm?"+Date(),350,160);
}
//ճ����word�︴�Ƶ��ı�
function PasteWord()
{
  _MyEditor.focus();
  var whtml = showModalDialog('word.htm?'+Date(), false, 'scroll:yes;dialogWidth:520px;dialogHeight:240px;status:0;');
	if(whtml==undefined) return;
  whtml = whtml.replace(/<\/?SPAN[^>]*>/gi, "" );
	whtml = whtml.replace(/<(\w[^>]*) class=([^ |>]*)([^>]*)/gi, "<$1$3");
	whtml = whtml.replace(/<(\w[^>]*) style="([^"]*)"([^>]*)/gi, "<$1$3");
	whtml = whtml.replace(/<(\w[^>]*) lang=([^ |>]*)([^>]*)/gi, "<$1$3");
	whtml = whtml.replace(/<\\?\?xml[^>]*>/gi, "");
	whtml = whtml.replace(/<\/?\w+:[^>]*>/gi, "");
	whtml = whtml.replace(/<FONT face[^>]*>/gi, "");
	whtml = whtml.replace(/<\/FONT><\/FONT>/gi, "</FONT>");
	whtml = whtml.replace(/<P><\/FONT><\/P>/gi, "<BR/>");
	doInsertText(whtml);
	_MyEditor.focus();
}
//����ê���ǩ
function doInsertAnchor()
{
	_MyEditor.focus();
	var sAnchorName = window.prompt("������ê�����ƣ�","AnchorName");
	sAnchorName = "<a name='"+sAnchorName+"'></a>";
	_MyEDoc.selection.createRange().pasteHTML(sAnchorName);
	_MyEditor.focus();
}
-->