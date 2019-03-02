<?php 
require_once(dirname(__FILE__)."/pub_charset.php");
/*******************************
//HTML������
function c____DedeHtml();
********************************/
class DedeHtml
{
	var $SourceHtml = "";
	var $Title = "";
	var $IsJump = false;
	var $IsFrame = false;
	var $JumpUrl = "";
	var $BodyText = "";
	var $KeywordText = "";
	var $Links = "";
	var $LinkCount = 0;
	var $CharSet = "";
	var $BaseUrl = "";
	var $BaseUrlPath = "";
	var $HomeUrl = "";
	var $IsHead = false; //�Ƿ��Ѿ�����HTMLͷ<head></head>���ݣ�
	                     //����������HTMLͷ������SetSource֮ǰֱ�������ֵΪtrue
	var $IsParseText = true; //�Ƿ���Ҫ���HTML����ı�
	var $ImgWidth = 0;
	var $ImgHeight = 0;
	var $NotEncodeText = "";
	//����HTML�����ݺ���Դ��ַ
	function SetSource($html,$url="")
	{
		$this->CAtt = new DedeAttribute();
		$url = trim($url);
		$this->SourceHtml = $html;
		$this->BaseUrl = $url;
		//�ж��ĵ�����ڵ�ǰ��·��
		$urls = @parse_url($url);
		$this->HomeUrl = $urls["host"];
		if(isset($urls["path"])) $this->BaseUrlPath = $this->HomeUrl.$urls["path"];
		else $this->BaseUrlPath = $this->HomeUrl;
		$this->BaseUrlPath = preg_replace("/\/([^\/]*)\.(.*)$/","/",$this->BaseUrlPath);
		$this->BaseUrlPath = preg_replace("/\/$/","",$this->BaseUrlPath);
		if($html!="") $this->Analyser();
	}
	//
	//����HTML
	//
	function Analyser()
	{
		$cAtt = new DedeAttribute();
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
		for(;$i < $slen; $i++)
		{
			$c = $this->SourceHtml[$i];
			if($c=="<")
			{
				//���IsParseText==false��ʾ����ȡ��ҳ�Ķ�����Դ��ֻ��ȡ��ý����Ϣ
				//�������һ�������ڲɼ������ģʽ
				$tagName = "";
				$j = 0;
				for($i=$i+1; $i < $slen; $i++)
				{
					if($j>10) break;
					$j++;
					if(!ereg("[ <>\r\n\t]",$this->SourceHtml[$i])){
						$tagName .= $this->SourceHtml[$i];
					}
					else break;
				}
				$tagName = strtolower($tagName);
				if($tagName=="!--")
				{
					$endPos = strpos($this->SourceHtml,"-->",$i);
					if($endPos!==false) $i=$endPos+2;
					continue;
				}
				//��ģʽ��ֻ��ȡ��ý����Դ
				if(!$this->IsParseText)
				{
					$needTag = "img|embed";
					if(ereg($needTag,$tagName))
					{
						$startPos = $i;
						$endPos = strpos($this->SourceHtml,">",$i+1);
						if($endPos===false) break;
						$attStr = substr($this->SourceHtml,$i+1,$endPos-$startPos-1);
						$cAtt->SetSource($attStr);
					}
				}
				//����ģʽ����ȡ���и�����Ϣ
				else
				{
					$startPos = $i;
					$endPos = strpos($this->SourceHtml,">",$i+1);
					if($endPos===false) break;
					$attStr = substr($this->SourceHtml,$i+1,$endPos-$startPos-1);
					$cAtt->SetSource($attStr);
				}
				//���HTMLͷ��Ϣ
				if(!$this->IsHead && $this->IsParseText)
				{
				  if($tagName=="meta")
				  {
					  //����name����
					  $tmpValue = strtolower($cAtt->GetAtt("name"));
					  if($tmpValue=="keywords")
							  $this->BodyText .= trim($this->TrimSymbol($cAtt->GetAtt("content")))." ";
					  if($tmpValue=="description")
						{
								$this->BodyText .= trim($this->TrimSymbol($cAtt->GetAtt("content")))." ";
						}
					  //����http-equiv����
					  $tmpValue = strtolower($cAtt->GetAtt("http-equiv"));
					  if($tmpValue=="refresh")
					  {
						  $tmpValue2 = InsertUrl($this->ParRefresh($cAtt->GetAtt("content")),"meta");
						  if($tmpValue2!=""){
								  $this->IsJump = true;
								  $this->JumpUrl = $tmpValue2;
							 }
						}
					  if($tmpValue=="content-type")
						{
							 if($this->CharSet=="")
							 { $this->CharSet = strtolower($this->ParCharSet($cAtt->GetAtt("content"))); }
						}
				  } //End meta ����
				  else if($tagName=="title") //�����ҳ�ı���
					{
						$t_startPos = strpos($this->SourceHtml,'>',$i);
						$t_endPos = strpos($this->SourceHtml,'<',$t_startPos);
						if($t_endPos>$t_startPos){
						  $textLen = $t_endPos-$t_startPos;
						  $this->Title = substr($this->SourceHtml,$t_startPos+1,$textLen-1);
						}
						if($t_endPos > $i) $i = $t_endPos + 6;
					}
				  else if($tagName=="/head"||$tagName=="body")
				  {
				  	$this->IsHead = true;
				  	$i = $i+5;
					}
			  }
			  else
			  {
					//С�ͷ���������
					//ֻ���������Ķ�ý����Դ���ӣ�����ȡtext
					if($tagName=="img")//��ȡͼƬ�е���ַ
					{
						if($cAtt->GetAtt("alt")!="" && $this->IsParseText)
							{	$this->BodyText .= trim($this->TrimSymbol($cAtt->GetAtt("alt")))." "; }
						$wt = $cAtt->GetAtt("width");
						$ht = $cAtt->GetAtt("height");
						if(!ereg("[^0-9]",$wt)&&!ereg("[^0-9]",$ht)){
							if($wt >= $this->ImgWidth && $ht>= $this->ImgHeight){
								$this->InsertUrl($cAtt->GetAtt("src"),"images"); 
							}
						}
					}
					else if($tagName=="embed")//���Flash������ý�������
					{
						$wt = $cAtt->GetAtt("width");
						$ht = $cAtt->GetAtt("height");
						if(!ereg("[^0-9]",$wt)&&!ereg("[^0-9]",$ht))
						{ $this->InsertUrl($cAtt->GetAtt("src"),$cAtt->GetAtt("type")); }
					}
					//
					//������������ڻ�ȡHTML�����и�����Ϣ�������֩�����
					//
					if($this->IsParseText)
					{
						if($tagName=="a"||$tagName=="area")//��ó�����
							$this->InsertUrl($cAtt->GetAtt("href"),"hyperlink");
						else if($tagName=="frameset")//��������ҳ
							$this->IsFrame = true;
						else if($tagName=="frame"){
							$tmpValue = $this->InsertUrl($cAtt->GetAtt("src"),"frame");
							if($tmpValue!=""){
								$tmpValue2 = $cAtt->GetAtt("name");
								if(eregi("(main|body)",$tmpValue2)){
									$this->IsJump = true;
									$this->JumpUrl = $tmpValue;
								}
							}
						}
						else if(ereg("^(sc|st)",$tagName)){
							$scriptdd++;
						}
						else if(ereg("^(/sc|/st)",$tagName)){
							$scriptdd--;
						}
						////////////��ȡ��Ǽ���ı�//////////////
						if($scriptdd==0){
							$tmpValue = trim($this->GetInnerText($i));
							if($tmpValue!=""){
								if(strlen($this->KeywordText)<512){
								if($this->IsHot($tagName,$cAtt)){
									$this->KeywordText .= $tmpValue;
								}}
								$this->BodyText .= $tmpValue." ";
							}
						}
					}//IsParseText
				}//��������body������
			}//End if char
		}//End for
		
		//�Է����������ı����м򵥴���
		if($this->BodyText!="")
		{
			$this->BodyText = $this->TrimSymbol($this->BodyText);
			if($this->NotEncodeText!="") $this->BodyText = $this->TrimSymbol($this->NotEncodeText).$this->BodyText;
			$this->BodyText = preg_replace("/&#{0,1}([a-zA-Z0-9]{3,5})( {0,1})/"," ",$this->BodyText);
			$this->BodyText = preg_replace("/[ -]{1,}/"," ",$this->BodyText);
			$this->BodyText = preg_replace("/-{1,}/","-",$this->BodyText);
			$this->NotEncodeText = "";
		}	
			
		if($this->KeywordText!="")
		{
			$this->KeywordText = $this->TrimSymbol($this->KeywordText); 
			$this->KeywordText = preg_replace("/&#{0,1}([a-zA-Z0-9]{3,5})( {0,1})/"," ",$this->KeywordText);
			$this->KeywordText = preg_replace("/ {1,}/"," ",$this->KeywordText);
			$this->KeywordText = preg_replace("/-{1,}/","-",$this->KeywordText);
	  }
	  
		if($this->Title==""){
			$this->Title = $this->BaseUrl;
		}else{
			$this->Title = $this->TrimSymbol($this->Title);
			$this->Title = preg_replace("/&#{0,1}([a-zA-Z0-9]{3,5})( {0,1})/"," ",$this->Title);
			$this->Title = preg_replace("/ {1,}/"," ",$this->Title);
			$this->Title = preg_replace("/-{1,}/","-",$this->Title);
		}
	}
	//
	//������Դ
	//
	function Clear()
	{
		$this->SourceHtml = "";
		$this->Title = "";
		$this->IsJump = false;
		$this->IsFrame = false;
		$this->JumpUrl = "";
		$this->BodyText = "";
		$this->KeywordText = "";
		$this->Links = "";
		$this->LinkCount = 0;
		$this->CharSet = "";
		$this->BaseUrl = "";
		$this->BaseUrlPath = "";
		$this->HomeUrl = "";
		$this->NotEncodeText = "";
	}
	//
	//����URL��������ָ��������
	//
	function InsertUrl($url,$tagname)
	{
		$noUrl = true;
		if(trim($url)=="") return;
		if( ereg("^(javascript:|#|'|\")",$url) ) return "";
		if($url=="") return "";
		if($this->LinkCount>0)
		{
			foreach($this->Links as $k=>$v){
				if($url==$v){ $noUrl = false; break; }
			}
		}
		//����������������
		if($noUrl)
		{
			$this->Links[$this->LinkCount]=$url;
			$this->LinkCount++;
		}
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
	function GetInnerText($pos)
	{
		$startPos=0;
		$endPos=0;
		$textLen=0;
		$str="";
		$startPos = strpos($this->SourceHtml,'>',$pos);
		$endPos = strpos($this->SourceHtml,'<',$startPos);
		if($endPos>$startPos)
		{
			$textLen = $endPos-$startPos;
			$str = substr($this->SourceHtml,$startPos+1,$textLen-1);
		}
		return $str;
	}
	//
  //����������򵥸�������Ż�Ϊ�ո�
  //�����Ӣ�Ļ�ϵĴ�Ҳ�ᱻ�ֿ�
  //
  function TrimSymbol($str)
  {
    if(strtolower($this->CharSet)=="utf-8"){
    	$str = utf82gb($str);
    }
    else if(strtolower($this->CharSet)=="big5"){
    	$str = big52gb($str);
    }
    else if(!eregi("^gb",$this->CharSet)){
    	$this->NotEncodeText .= $str;
    	return "";
    }
    $str = trim($str);
    $slen = strlen($str);
    if($slen==0) return "";
    $okstr = "";
    for($i=0;$i<$slen;$i++){
      if(ord($str[$i]) < 0x81){
        //���ַ�ΪӢ���е��������
        if(ereg("[^0-9a-zA-Z@.%#:/\\&-]",$str[$i])){
          if($okstr!=""){ if( $okstr[strlen($okstr)-1]!=" " ) $okstr .= " "; }
        }
        //����ַ�Ϊ���������
        else{
          if(strlen($okstr)>1){
            if(ord($okstr[strlen($okstr)-2])>0x80) $okstr .= " ".$str[$i];
            else $okstr .= $str[$i];
          }
          else $okstr .= $str[$i];
        }
      }
      else
      {
        //�����һ���ַ�Ϊ�����ĺͷǿո����һ���ո�
        if(strlen($okstr)>1){
          if(ord($okstr[strlen($okstr)-2]) < 0x81 && $okstr[strlen($okstr)-1]!=" ")
          { $okstr .= " "; }
        }
        //��������ַ�
        if( isset($str[$i+1]) ){
          $c = $str[$i].$str[$i+1];
          $n = hexdec(bin2hex($c));
          if($n < 0xB0A1)
          {
              if($c=="��")
            {  $okstr .= " ��"; }
            else if($c=="��")
            {  $okstr .= "�� "; }
            else if($okstr[strlen($okstr)-1]!=" ")
            {  $okstr .= " ";  }
          }
          else{
            //F7 - FE ��GB2312���ս����
            if($n < 0xF8FF) $okstr .= $c;
          }
          $i++;
        }
        else{
          $okstr .= $str[$i];
        }
      }
    }//����ѭ��
    return $okstr;
  }
  //
	//ȷ�ϱ�Ǻ����Ƿ���ڸ��ȵ�ʵĿ�����
	//
	function IsHot($tag,$datt)
	{
		$hottag="b|strong|h1|h2|h3|h4|h5|h6";
		if($tag=="font"||$tag=="p"||$tag=="div"||$tag=="span")
				return $this->IsRed($datt);
		else
			  return ereg($hottag,$tag);
	}
	//
	//����Ƿ�ʹ�ú�ɫ��
	//
	function IsRed($datt)
	{
		$color = strtolower($datt->GetAtt("color"));
		if($color=="") return false;
		else
		{
			if($color=="red"||$color=="#ff0000"||$color=="ff0000") return true;
			else return false;
		}
	}
}//End class
/*******************************
//���Խ�����
function c____DedeAttribute();
********************************/
class DedeAttribute
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

}//End Class DedeAttribute
?>