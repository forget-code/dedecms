<!--
function DedeAjax(WiteOKFunc){ //WiteOKFunc Ϊ�첽״̬������ 

//xmlhttp��xmldom����
this.xhttp = null;
this.xdom = null;

//post��get�������ݵļ�ֵ��
this.keys = Array();
this.values = Array();
this.keyCount = -1;

//http����ͷ
this.rkeys = Array();
this.rvalues = Array();
this.rkeyCount = -1;

//��ʼ��xmlhttp
if(window.XMLHttpRequest){//IE7, Mozilla ,Firefox ����������øö���
     this.xhttp = new XMLHttpRequest();
}else if(window.ActiveXObject){//IE6��IE5
     try { this.xhttp = new ActiveXObject("Msxml2.XMLHTTP");} catch (e) { }
     if (this.xhttp == null) try { this.xhttp = new ActiveXObject("Microsoft.XMLHTTP");} catch (e) { }
}
this.xhttp.onreadystatechange = WiteOKFunc;
//rs: responseBody��responseStream��responseXml��responseText

//����Ϊ��Ա����
//--------------------------------

//��ʼ��xmldom
this.InitXDom = function(){
  var obj = null;
  if (typeof(DOMParser) != "undefined") { // Gecko��Mozilla��Firefox
    var parser = new DOMParser();
    obj = parser.parseFromString(xmlText, "text/xml");
  } else { // IE
    try { obj = new ActiveXObject("MSXML2.DOMDocument");} catch (e) { }
    if (obj == null) try { obj = new ActiveXObject("Microsoft.XMLDOM"); } catch (e) { }
  }
  this.xdom = obj;
};

//����һ��POST��GET��ֵ
this.AddSendKey = function(skey,svalue){
	this.keyCount++;
	this.keys[this.keyCount] = skey;
	this.values[this.keyCount] = escape(svalue);
};

//����һ��Http����ͷ
this.AddHttpHead = function(skey,svalue){
	this.rkeyCount++;
	this.rkeys[this.rkeyCount] = skey;
	this.rvalues[this.rkeyCount] = svalue;
};

//�����ǰ����Ĺ�ϣ�����
this.ClearSet = function(){
	this.keyCount = -1;
	this.keys = Array();
	this.values = Array();
	this.rkeyCount = -1;
	this.rkeys = Array();
	this.rvalues = Array();
};

//��Post��ʽ��������
this.SendPost = function(purl,ptype){
	var pdata = "";
	var httphead = "";
	var i=0;
	this.state = 0;
	this.xhttp.open("POST", purl, true); 
	
	if(this.rkeyCount!=-1){ //�����û������趨������ͷ
  	for(;i<=this.rkeyCount;i++){
  		this.xhttp.setRequestHeader(this.rkeys[i],this.rvalues[i]); 
  	}
  }
��if(ptype=="text") this.xhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
��
  if(this.keyCount!=-1){ //post����
  	for(;i<=this.keyCount;i++){
  		if(pdata=="") pdata = this.keys[i]+'='+this.values[i];
  		else pdata += "&"+this.keys[i]+'='+this.values[i];
  	}
  }
  this.xhttp.send(pdata);
};

} // End Class DedeAjax
-->