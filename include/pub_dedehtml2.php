<?
/*******************************
//֯��HTML������V1.1 PHP��
//www.dedecms.com
function c____DedeHtml2();
���������ڲɼ�������DedeHtml�๦�ܲ�����ͬ
********************************/
class DedeHtml2
{
	var $CAtt;
	var $SourceHtml;
	var $Title;
	var $Medias;
	var $MediaInfos;
	var $Links;
	var $CharSet;
	var $BaseUrl;
	var $BaseUrlPath;
	var $HomeUrl;
	var $IsHead;
	var $ImgHeight;
	var $ImgWidth;
	var $GetLinkType;
	//-------------------------
	//���캯��
	//-------------------------
	function __construct()
 	{
 		$this->CAtt = "";
 		$this->SourceHtml = "";
 		$this->Title = "";
 		$this->Medias = Array();
 		$this->MediaInfos = Array();
 		$this->Links = Array();
    $this->CharSet = "";
    $this->BaseUrl = "";
    $this->BaseUrlPath = "";
    $this->HomeUrl = "";
    $this->IsHead = false;
    $this->ImgHeight = 30;
    $this->ImgWidth = 50;
    $this->GetLinkType = "all";
  }
  function DedeHtml2()
 	{
 		$this->__construct();
  }
	//����HTML�����ݺ���Դ��ַ
	//gethead ��ָ�Ƿ�Ҫ����htmlͷ
	//����Ǿֲ�HTML,���������Ϊfalse,�����޷�������ҳ
	function SetSource(&$html,$url="",$gethead=false)
	{
		$this->__construct();
		if($gethead) $this->IsHead = false;
		else $this->IsHead = true;
		$this->CAtt = new DedeAttribute2();
		$url = trim($url);
		$this->SourceHtml = $html;
		$this->BaseUrl = $url;
		//�ж��ĵ�����ڵ�ǰ��·��
		$urls = @parse_url($url);
		$this->HomeUrl = $urls["host"];
		$this->BaseUrlPath = $this->HomeUrl.$urls["path"];
		$this->BaseUrlPath = preg_replace("/\/([^\/]*)\.(.*)$/","/",$this->BaseUrlPath);
		$this->BaseUrlPath = preg_replace("/\/$/","",$this->BaseUrlPath);
		if($html!="") $this->Analyser();
	}
	//-----------------------
	//����HTML
	//-----------------------
	function Analyser()
	{
		$cAtt = new DedeAttribute2();
		$cAtt->IsTagName = false;
		$c = "";
		$i = 0;
		$startPos = 0;
		$endPos = 0;
		$wt = 0;
		$ht = 0;
		$scriptdd = 0;
		$attStr = "";
		$tmpValue = "";
		$tmpValue2 = "";
		$tagName = "";
		$hashead = 0;
		$slen = strlen($this->SourceHtml);
		
		if($this->GetLinkType=="link")
		{ $needTag = "a|meta|title|/head|body"; }
		else if($this->GetLinkType=="media")
		{ $needTag = "img|embed|a"; $this->IsHead = true; }
		else
		{ $needTag = "img|embed|a|meta|title|/head|body"; }
		
		for(;$i < $slen; $i++)
		{
			$c = $this->SourceHtml[$i];
			if($c=="<")
			{
				//�������һ�������ڲɼ������ģʽ
				$tagName = "";
				$j = 0;
				for($i=$i+1; $i < $slen; $i++){
					if($j>10) break;
					$j++;
					if(!ereg("[ <>\r\n\t]",$this->SourceHtml[$i]))
					{ $tagName .= $this->SourceHtml[$i]; }
					else{ break; }
				}
				$tagName = strtolower($tagName);
				if($tagName=="!--"){
					$endPos = strpos($this->SourceHtml,"-->",$i);
					if($endPos!==false) $i=$endPos+3;
					continue;
				}
				if(ereg($needTag,$tagName)){
					$startPos = $i;
					$endPos = strpos($this->SourceHtml,">",$i+1);
					if($endPos===false) break;
					$attStr = substr($this->SourceHtml,$i+1,$endPos-$startPos-1);
					$cAtt->SetSource($attStr);
				}else{
					continue;
				}
				//���HTMLͷ��Ϣ
				if(!$this->IsHead)
				{
					if($tagName=="meta"){
					  //����name����
					  $tmpValue = strtolower($cAtt->GetAtt("http-equiv"));
					  if($tmpValue=="content-type"){
							  $this->CharSet = strtolower($cAtt->GetAtt("charset"));
						}
				  } //End meta ����
				  else if($tagName=="title"){
						$this->Title = $this->GetInnerText($i,"title");
						$i += strlen($this->Title)+12;
					}
				  else if($tagName=="/head"||$tagName=="body"){
				  	$this->IsHead = true;
				  	$i = $i+5;
					}
			  }
			  else
			  {
					//С�ͷ���������
					//ֻ���������Ķ�ý����Դ���ӣ�����ȡtext
					if($tagName=="img"){ //��ȡͼƬ�е���ַ
						$this->InsertMedia($cAtt->GetAtt("src"),"img"); 
					}
					else if($tagName=="embed"){ //���Flash������ý�������
						$rurl = $this->InsertMedia($cAtt->GetAtt("src"),"embed");
						if($rurl != ""){
						  $this->MediaInfos[$rurl][0] = $cAtt->GetAtt("width");
						  $this->MediaInfos[$rurl][1] = $cAtt->GetAtt("height");
						}
					}
					else if($tagName=="a"){ //���Flash������ý�������
						$this->InsertLink($cAtt->GetAtt("href"),$this->GetInnerText($i,"a"));
					}
				}//��������body������
			}//End if char
		}//End for
		if($this->Title=="") $this->Title = $this->BaseUrl;
	}
	//
	//������Դ
	//
	function Clear()
	{
		$this->CAtt = "";
		$this->SourceHtml = "";
		$this->Title = "";
		$this->Links = "";
		$this->Medias = "";
		$this->BaseUrl = "";
		$this->BaseUrlPath = "";
	}
	//
	//����ý������
	//
	function InsertMedia($url,$mtype)
	{
		if( ereg("^(javascript:|#|'|\")",$url) ) return "";
		if($url=="") return "";
		$this->Medias[$url]=$mtype;
		return $url;
	}
	function InsertLink($url,$atitle)
	{
		if( ereg("^(javascript:|#|'|\")",$url) ) return "";
		if($url=="") return "";
		$this->Links[$url]=$atitle;
		return $url;
	}
	//
	//����content-type�е��ַ�����
	//
	function ParCharSet($att)
	{
		$startdd=0;
		$taglen=0;
		$startdd = strpos($att,"=");
		if($startdd===false) return "";
		else
		{
			$taglen = strlen($att)-$startdd-1;
			if($taglen<=0) return "";
			return trim(substr($att,$startdd+1,$taglen));
		}
	}
	//
	//����refresh�е���ַ
	//
	function ParRefresh($att)
	{
		return $this->ParCharSet($att);
	}
	//
	//��ȫ�����ַ
	//
	function FillUrl($surl)
  {
    $i = 0;
    $dstr = "";
    $pstr = "";
    $okurl = "";
    $pathStep = 0;
    $surl = trim($surl);
    if($surl=="") return "";
    $pos = strpos($surl,"#");
    if($pos>0) $surl = substr($surl,0,$pos);
    if($surl[0]=="/"){
    	$okurl = "http://".$this->HomeUrl."/".$surl;
    }
    else if($surl[0]==".")
    {
      if(strlen($surl)<=2) return "";
      else if($surl[0]=="/")
      {
      	$okurl = "http://".$this->BaseUrlPath."/".substr($surl,2,strlen($surl)-2);
    	}
      else{
        $urls = explode("/",$surl);
        foreach($urls as $u){
          if($u=="..") $pathStep++;
          else if($i<count($urls)-1) $dstr .= $urls[$i]."/";
          else $dstr .= $urls[$i];
          $i++;
        }
        $urls = explode("/",$this->BaseUrlPath);
        if(count($urls) <= $pathStep)
        	return "";
        else{
          $pstr = "http://";
          for($i=0;$i<count($urls)-$pathStep;$i++)
          { $pstr .= $urls[$i]."/"; }
          $okurl = $pstr.$dstr;
        }   		
      }
    }
    else
    {
      if(strlen($surl)<7)
        $okurl = "http://".$this->BaseUrlPath."/".$surl;
      else if(strtolower(substr($surl,0,7))=="http://")
        $okurl = $surl;
      else
        $okurl = "http://".$this->BaseUrlPath."/".$surl;
    }
    $okurl = eregi_replace("^(http://)","",$okurl);
    $okurl = eregi_replace("/{1,}","/",$okurl);
    return "http://".$okurl;
  }
  //
	//��ú���һ�����֮����ı�����
	//
	function GetInnerText($pos,$tagname)
	{
		$startPos=0;
		$endPos=0;
		$textLen=0;
		$str="";
		$startPos = strpos($this->SourceHtml,'>',$pos);
		if($tagname=="title")
			$endPos = strpos($this->SourceHtml,'<',$startPos);
		else{
			$endPos = strpos($this->SourceHtml,'</a',$startPos);
			if($endPos===false) $endPos = strpos($this->SourceHtml,'</A',$startPos);
		}
		if($endPos>$startPos){
			$textLen = $endPos-$startPos;
			$str = substr($this->SourceHtml,$startPos+1,$textLen-1);
		}
		if($tagname=="title")
			return trim($str);
		else{
			$str = eregi_replace("</(.*)$","",$str);
			$str = eregi_replace("^(.*)>","",$str);
			return trim($str);
		}
	}
}//End class
/*******************************
//���Խ�����
function c____DedeAttribute2();
********************************/
class DedeAttribute2
{
	var $SourceString = "";
	var $SourceMaxSize = 1024;
	var $CharToLow = FALSE;  //����ֵ�Ƿ񲻷ִ�Сд(������ͳһΪСд)
	var $IsTagName = TRUE; //�Ƿ�����������
	var $Count = -1;
  var $Items = ""; //����Ԫ�صļ���
  //�������Խ�����Դ�ַ���
	function SetSource($str="")
	{
		$this->Count = -1;
  	$this->Items = "";
		$strLen = 0;
		$this->SourceString = trim(preg_replace("/[ \t\r\n]{1,}/"," ",$str));
		$strLen = strlen($this->SourceString);
		$this->SourceString .= " "; //����һ���ո��β,�Է��㴦��û�����Եı��
		if($strLen>0&&$strLen<=$this->SourceMaxSize){
			$this->PrivateAttParse();
		}
	}
  //���ĳ������
  function GetAtt($str){
    if($str=="") return "";
    $str = strtolower($str);
    if(isset($this->Items[$str])) return $this->Items[$str];
    else return "";
  }
  //�ж������Ƿ����
  function IsAtt($str){
    if($str=="") return false;
    $str = strtolower($str);
    if(isset($this->Items[$str])) return true;
    else return false;
  }
  //��ñ������
  function GetTagName(){
     return $this->GetAtt("tagname");
  }
  // ������Ը���
  function GetCount(){
      return $this->Count+1;
	}
	//��������(����SetSource����)
	function PrivateAttParse()
	{
		$d = "";
		$tmpatt="";
		$tmpvalue="";
		$startdd=-1;
		$ddtag="";
		$strLen = strlen($this->SourceString);
		$j = 0;
		//�����ǻ�ñ�ǵ�����
		if($this->IsTagName)
		{
			//���������ע�⣬���ٽ�����������ݣ�ֱ�ӷ���
			if(isset($this->SourceString[2]))
			{
				if($this->SourceString[0].$this->SourceString[1].$this->SourceString[2]=="!--")
				{ $this->Items["tagname"] = "!--"; return ;}
			}
			//
			for($i=0;$i<$strLen;$i++){
				$d = $this->SourceString[$i];
				$j++;
				if(ereg("[ '\"\r\n\t]",$d)){
					$this->Count++;
					$this->Items["tagname"]=strtolower(trim($tmpvalue));
					$tmpvalue = ""; break;
				}
				else
				{	$tmpvalue .= $d;}
			}
			if($j>0) $j = $j-1;
	  }
		//����Դ�ַ�������ø�����
		for($i=$j;$i<$strLen;$i++)
		{
			$d = $this->SourceString[$i];
			//������Եļ�
			if($startdd==-1){
				if($d!="=")	$tmpatt .= $d;
				else{
					$tmpatt = strtolower(trim($tmpatt));
					$startdd=0;
				}
			}
			//�������ֵ����ʲô��Χ�ģ�����ʹ�� '' "" ��հ�
			else if($startdd==0){
				switch($d){
					case ' ':
						continue;
						break;
					case '\'':
						$ddtag='\'';
						$startdd=1;
						break;
					case '"':
						$ddtag='"';
						$startdd=1;
						break;
					default:
						$tmpvalue.=$d;
						$ddtag=' ';
						$startdd=1;
						break;
				}
			}
			//������Ե�ֵ
			else if($startdd==1)
			{
				if($d==$ddtag){
					$this->Count++;
          if($this->CharToLow) $this->Items[$tmpatt] = strtolower(trim($tmpvalue));
					else $this->Items[$tmpatt] = trim($tmpvalue);
					$tmpatt = "";
					$tmpvalue = "";
					$startdd=-1;
				}
				else
					$tmpvalue.=$d;
			}
	  }//End for
	  //����û��ֵ������(������ڽ�β����Ч)�磺"input type=radio name=t1 value=aaa checked"
	  if($tmpatt!="")
	  { $this->Items[$tmpatt] = "";}
 }//End Function PrivateAttParse

}//End Class DedeAttribute2

?>