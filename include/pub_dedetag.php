<?php 
/*----------------------------------------------
Copyright 2004-2006 by DedeCms.com itprato
Dede Tagģ�������ֿ V4.1 ��
����޸����ڣ�2006-7-4 PHP�汾Ҫ�󣺴��ڻ����php 4.1
---------------------------------------------*/
/****************************************
class DedeTag ��ǵ����ݽṹ����
function c____DedeTag(); 
**************************************/

class DedeTag
{
	var $IsReplace=FALSE; //����Ƿ��ѱ��������������ʹ��
	var $TagName=""; //�������
	var $InnerText=""; //���֮����ı�
	var $StartPos=0; //�����ʼλ��
	var $EndPos=0; //��ǽ���λ��
	var $CAttribute=""; //�����������,����class DedeAttribute
	var $TagValue=""; //��ǵ�ֵ
	var $TagID=0;
	
	//��ȡ��ǵ����ƺ�ֵ
	function GetName(){
		return strtolower($this->TagName);
	}
	function GetValue(){
		return $this->TagValue;
	}
	//����������Ա��������Ϊ�˼��ݾɰ�
	function GetTagName(){
		return strtolower($this->TagName);
	}
	function GetTagValue(){
		return $this->TagValue;
	}
  //��ȡ��ǵ�ָ������
	function IsAttribute($str){
       return $this->CAttribute->IsAttribute($str);
	}
	function GetAttribute($str){
    	return $this->CAttribute->GetAtt($str);
	}
	function GetAtt($str){
		return $this->CAttribute->GetAtt($str);
	}
	function GetInnerText(){
		return $this->InnerText;
	}
}

/**********************************************
//DedeTagParse Dede֯��ģ����
function c____DedeTagParse();
***********************************************/

class DedeTagParse
{
	var $NameSpace = 'dede'; //��ǵ����ֿռ�
	var $TagStartWord = '{'; //�����ʼ
	var $TagEndWord = '}'; //��ǽ���
	var $TagMaxLen = 64; //������Ƶ����ֵ
	var $CharToLow = TRUE; // TRUE��ʾ�����Ժͱ�����Ʋ����ִ�Сд
	//////////////////////////////////////////////////////
	var $IsCache = FALSE; //�Ƿ�ʹ�û���
	var $TempMkTime = 0;
	var $CacheFile = '';
	/////////////////////////////                       
	var $SourceString = '';//ģ���ַ���
	var $CTags = '';		 //��Ǽ���
	var $Count = -1;		 //$Tags��Ǹ���
	
	function __construct()
 	{
 		if(!isset($GLOBALS['cfg_dede_cache'])) $GLOBALS['cfg_dede_cache'] = '��';
 		if($GLOBALS['cfg_dede_cache']=='��') $this->IsCache = TRUE;
 		else $this->IsCache = FALSE;
 		$this->NameSpace = 'dede';
	  $this->TagStartWord = '{';
	  $this->TagEndWord = '}';
	  $this->TagMaxLen = 64;
	  $this->CharToLow = TRUE;
 		$this->SourceString = '';
 		$this->CTags = Array();
 		$this->Count = -1;
	  $this->TempMkTime = 0;
	  $this->CacheFile = '';
  }
  
  function DedeTagParse(){
  	$this->__construct();
  }
	//���ñ�ǵ������ռ䣬Ĭ��Ϊdede
	function SetNameSpace($str,$s="{",$e="}"){
		$this->NameSpace = strtolower($str);
		$this->TagStartWord = $s;
		$this->TagEndWord = $e;
	}
	//���ó�Ա������Clear
	function SetDefault(){
		$this->SourceString = '';
		$this->CTags = '';
		$this->Count=-1;
	}
	function GetCount(){
		return $this->Count+1;
  }
	function Clear(){
		$this->SetDefault();
	}
	//���ģ�建��
	function LoadCache($filename)
	{
		if(!$this->IsCache) return false;
		$cdir = dirname($filename);
		$ckfile = str_replace($cdir,'',$filename).'.cache';
		$ckfullfile = $cdir.''.$ckfile;
		$ckfullfile_t = $cdir.''.$ckfile.'.t';
		$this->CacheFile = $ckfullfile;
		$this->TempMkTime = filemtime($filename);
		if(!file_exists($ckfullfile)||!file_exists($ckfullfile_t)) return false;
		//���ģ��������ʱ��
		$fp = fopen($ckfullfile_t,'r');
		$time_info = trim(fgets($fp,64));
		fclose($fp);
		if($time_info != $this->TempMkTime){ return false; }
		//���뻺������
		include($this->CacheFile);
		//�ѻ����������ݶ�����
		if(isset($z) && is_array($z)){
			foreach($z as $k=>$v){
				$this->Count++;
				$ctag = new DedeTAg();
				$ctag->CAttribute = new DedeAttribute();
				$ctag->IsReplace = FALSE;
				$ctag->TagName = $v[0];
				$ctag->InnerText = $v[1];
				$ctag->StartPos = $v[2];
				$ctag->EndPos = $v[3];
				$ctag->TagValue = '';
				$ctag->TagID = $k;
				if(isset($v[4]) && is_array($v[4])){
					$i = 0;
					foreach($v[4] as $k=>$v){
						$ctag->CAttribute->Count++;
						$ctag->CAttribute->Items[$k]=$v;
					}
				}
				$this->CTags[$this->Count] = $ctag;
			}
		}
		else{//ģ��û�л�������
			$this->CTags = '';
	    $this->Count = -1;
		}
		return true;
	}
	//д�뻺��
	function SaveCache()
	{
		$fp = fopen($this->CacheFile.'.t',"w");
		fwrite($fp,$this->TempMkTime."\n");
		fclose($fp);
		$fp = fopen($this->CacheFile,"w");
		flock($fp,3);
		fwrite($fp,'<'.'?php'."\r\n");
		if(is_array($this->CTags)){
			foreach($this->CTags as $tid=>$ctag){
				$arrayValue = 'Array("'.$ctag->TagName.'",';
				$arrayValue .= '"'.str_replace('$','\$',str_replace("\r","\\r",str_replace("\n","\\n",str_replace('"','\"',$ctag->InnerText)))).'"';
				$arrayValue .= ",{$ctag->StartPos},{$ctag->EndPos});";
				fwrite($fp,"\$z[$tid]={$arrayValue}\n");
				if(is_array($ctag->CAttribute->Items)){
					foreach($ctag->CAttribute->Items as $k=>$v){
						$k = trim(str_replace("'","",$k));
						if($k=="") continue;
						if($k!='tagname') fwrite($fp,"\$z[$tid][4]['$k']=\"".str_replace('$','\$',str_replace("\"","\\\"",$v))."\";\n");
					}
				}
			}
		}
		fwrite($fp,"\n".'?'.'>');
		fclose($fp);
	}
	//����ģ���ļ�
	function LoadTemplate($filename){
		$this->SetDefault();
		$fp = @fopen($filename,"r") or die("DedeTag Engine Load Template \"$filename\" False��");
		while($line = fgets($fp,1024))
			$this->SourceString .= $line;
		fclose($fp);
		if($this->LoadCache($filename)) return;
		else $this->ParseTemplet();
	}
	function LoadTemplet($filename){
		$this->LoadTemplate($filename);
	}
	function LoadFile($filename){
		$this->LoadTemplate($filename);
	}
	//����ģ���ַ���
	function LoadSource($str){
		$this->SetDefault();
		$this->SourceString = $str;
		$this->IsCache = FALSE;
		$this->ParseTemplet();
	}
	function LoadString($str){
		$this->LoadSource($str);
	}
	//���ָ�����Ƶ�Tag��ID(����ж��ͬ����Tag,��ȡû�б�ȡ��Ϊ���ݵĵ�һ��Tag)
	function GetTagID($str){
		if($this->Count==-1) return -1;
		if($this->CharToLow) $str=strtolower($str);
		foreach($this->CTags as $ID=>$CTag){
			if($CTag->TagName==$str && !$CTag->IsReplace){
				return $ID;
				break;
			}
		}
		return -1;
	}
	//���ָ�����Ƶ�CTag������(����ж��ͬ����Tag,��ȡû�б��������ݵĵ�һ��Tag)
	function GetTag($str){
		if($this->Count==-1) return "";
		if($this->CharToLow) $str=strtolower($str);
		foreach($this->CTags as $ID=>$CTag){
			if($CTag->TagName==$str && !$CTag->IsReplace){
				return $CTag;
				break;
			}
		}
		return "";
	}
	function GetTagByName($str)
	{ return $this->GetTag($str); }
	//���ָ��ID��CTag������
	function GetTagByID($ID){
		if(isset($this->CTags[$ID])) return $this->CTags[$ID];
	  else return "";
	}
	//
	//����ָ��ID�ı�ǵ�ֵ
	//
	function Assign($tagid,$str)
	{
		if(isset($this->CTags[$tagid]))
		{
			$this->CTags[$tagid]->IsReplace = TRUE;
			if( $this->CTags[$tagid]->GetAtt("function")!="" ){
				$this->CTags[$tagid]->TagValue = $this->EvalFunc(
					$str,
					$this->CTags[$tagid]->GetAtt("function") 
				);
			}
			else 
		  { $this->CTags[$tagid]->TagValue = $str; }
		}
	}
	//����ָ�����Ƶı�ǵ�ֵ�������ǰ������ԣ��벻Ҫ�ô˺���
	function AssignName($tagname,$str)
	{
		foreach($this->CTags as $ID=>$CTag){
			if($CTag->TagName==$tagname) $this->Assign($ID,$str);
		}
	}
	//����������
	function AssignSysTag()
	{
		for($i=0;$i<=$this->Count;$i++)
		{
		  $CTag = $this->CTags[$i];
		  //��ȡһ���ⲿ����
		  if( $CTag->TagName == "global" ){
				 $this->CTags[$i]->IsReplace = TRUE;
				 $this->CTags[$i]->TagValue = $this->GetGlobals($CTag->GetAtt("name"));
				 if( $this->CTags[$i]->GetAtt("function")!="" ){
					$this->CTags[$i]->TagValue = $this->EvalFunc(
						$this->CTags[$i]->TagValue,$this->CTags[$i]->GetAtt("function") 
					);
				}
		  }
		  //���뾲̬�ļ�
			else if( $CTag->TagName == "include" ){
				$this->CTags[$i]->IsReplace = TRUE;
				$this->CTags[$i]->TagValue = $this->IncludeFile($CTag->GetAtt("file"),$CTag->GetAtt("ismake"));
			}
			//ѭ��һ����ͨ����
			else if( $CTag->TagName == "foreach" )
			{
				$rstr = "";
				$arr = $this->CTags[$i]->GetAtt("array");
				if(isset($GLOBALS[$arr]))
				{
					foreach($GLOBALS[$arr] as $k=>$v){
						$istr = "";
						$istr .= str_replace("[field:key/]",$k,$this->CTags[$i]->InnerText);
						$rstr .= str_replace("[field:value/]",$v,$istr);
					}
				}
				$this->CTags[$i]->IsReplace = TRUE;
				$this->CTags[$i]->TagValue = $rstr;
			}
			//����PHP�ӿ�
		  if( $CTag->GetAtt("runphp") == "yes" )
		  {
			  $DedeMeValue = "";
			  if($CTag->GetAtt("source")=='value')
			  { $runphp = $this->CTags[$i]->TagValue; }
			  else{
			  	$DedeMeValue = $this->CTags[$i]->TagValue;
			  	$runphp = $CTag->GetInnerText();
			  }
			  $runphp = eregi_replace("'@me'|\"@me\"|@me",'$DedeMeValue',$runphp);
			  eval($runphp.";");
			  $this->CTags[$i]->IsReplace = TRUE;
			  $this->CTags[$i]->TagValue = $DedeMeValue;
	    }
    }
	}
	//�ѷ���ģ�������һ���ַ�����
	//���滻û�������ֵ
	function GetResultNP()
	{
		$ResultString = "";
		if($this->Count==-1){
			return $this->SourceString;
		}
		$this->AssignSysTag();
		$nextTagEnd = 0;
		$strok = "";
		for($i=0;$i<=$this->Count;$i++){
			if($this->CTags[$i]->GetValue()!=""){
			  if($this->CTags[$i]->GetValue()=='#@Delete@#') $this->CTags[$i]->TagValue = "";
			  $ResultString .= substr($this->SourceString,$nextTagEnd,$this->CTags[$i]->StartPos-$nextTagEnd);
			  $ResultString .= $this->CTags[$i]->GetValue();
			  $nextTagEnd = $this->CTags[$i]->EndPos;
		  }
		}
		$slen = strlen($this->SourceString);
		if($slen>$nextTagEnd){
		   $ResultString .= substr($this->SourceString,$nextTagEnd,$slen-$nextTagEnd);
	  }
		return $ResultString;
	}
	//�ѷ���ģ�������һ���ַ�����,������
	function GetResult()
	{
		$ResultString = "";
		if($this->Count==-1){
			return $this->SourceString;
		}
		$this->AssignSysTag();
		$nextTagEnd = 0;
		$strok = "";
		for($i=0;$i<=$this->Count;$i++){
			$ResultString .= substr($this->SourceString,$nextTagEnd,$this->CTags[$i]->StartPos-$nextTagEnd);
			$ResultString .= $this->CTags[$i]->GetValue();
			$nextTagEnd = $this->CTags[$i]->EndPos;
		}
		$slen = strlen($this->SourceString);
		if($slen>$nextTagEnd){
		   $ResultString .= substr($this->SourceString,$nextTagEnd,$slen-$nextTagEnd);
	  }
		return $ResultString;
	}
	//ֱ���������ģ��
	function Display()
	{
		echo $this->GetResult();
	}
	//�ѷ���ģ�����Ϊ�ļ�
	function SaveTo($filename)
	{
		$fp = @fopen($filename,"w") or die("DedeTag Engine Create File False��$filename");
		fwrite($fp,$this->GetResult());
		fclose($fp);
	}
	//����ģ��
	function ParseTemplet()
	{
		$TagStartWord = $this->TagStartWord;
		$TagEndWord = $this->TagEndWord;
		$sPos = 0; $ePos = 0;
		$FullTagStartWord =  $TagStartWord.$this->NameSpace.":";
		$sTagEndWord =  $TagStartWord."/".$this->NameSpace.":";
		$eTagEndWord = "/".$TagEndWord;
		$tsLen = strlen($FullTagStartWord);
		$sourceLen=strlen($this->SourceString);
		if( $sourceLen <= ($tsLen + 3) ) return;
		$cAtt = new DedeAttributeParse();
		$cAtt->CharToLow = $this->CharToLow;
		//����ģ���ַ�������ȡ��Ǽ���������Ϣ
		for($i=0;$i<$sourceLen;$i++)
		{
			$tTagName = "";
			$sPos = strpos($this->SourceString,$FullTagStartWord,$i);
			$isTag = $sPos;
			if($i==0){
				$headerTag = substr($this->SourceString,0,strlen($FullTagStartWord));
				if($headerTag==$FullTagStartWord){ $isTag=TRUE; $sPos=0; }
			}
			if($isTag===FALSE) break;
 			if($sPos > ($sourceLen-$tsLen-3) ) break;
			
			for($j=($sPos+$tsLen);$j<($sPos+$tsLen+$this->TagMaxLen);$j++)
			{
				if($j>($sourceLen-1)) break;
				else if(ereg("[ \t\r\n]",$this->SourceString[$j])
					||$this->SourceString[$j] == $this->TagEndWord) break;
				else $tTagName .= $this->SourceString[$j];
			}
			if(strtolower($tTagName)=="comments")
			{
				$endPos = strpos($this->SourceString,$sTagEndWord ."comments",$i);
				if($endPos!==false) $i=$endPos+strlen($sTagEndWord)+8;
				continue;
			}
			$i = $sPos+$tsLen;
			$sPos = $i;
			$fullTagEndWord = $sTagEndWord.$tTagName;
			$endTagPos1 = strpos($this->SourceString,$eTagEndWord,$i);
			$endTagPos2 = strpos($this->SourceString,$fullTagEndWord,$i);
			$newStartPos = strpos($this->SourceString,$FullTagStartWord,$i);
			if($endTagPos1===FALSE) $endTagPos1=0;
			if($endTagPos2===FALSE) $endTagPos2=0;
			if($newStartPos===FALSE) $newStartPos=0;
			//�ж��ú��ֱ����Ϊ����
			if($endTagPos1>0 && 
			  ($endTagPos1 < $newStartPos || $newStartPos==0) && 
			  ($endTagPos1 < $endTagPos2 || $endTagPos2==0 ))
			{
				$ePos = $endTagPos1;
				$i = $ePos + 2;
			}
			else if($endTagPos2>0){
				$ePos = $endTagPos2;
				$i = $ePos + strlen($fullTagEndWord)+1;
			}
			else{
				echo "Parse error the tag ".($this->GetCount()+1)." $tTagName' is incorrect !<br/>";
			}
			//�������ҵ��ı��λ�õ���Ϣ
			$attStr = "";
			$innerText = "";
			$startInner = 0;
			for($j=$sPos;$j < $ePos;$j++)
			{
				if($startInner==0 && $this->SourceString[$j]==$TagEndWord)
				{ $startInner=1; continue; }
				if($startInner==0) $attStr .= $this->SourceString[$j];
				else $innerText .= $this->SourceString[$j];
			}
			$cAtt->SetSource($attStr);
			if($cAtt->CAttribute->GetTagName()!="")
			{
				$this->Count++;
				$CDTag = new DedeTag();
				$CDTag->TagName = $cAtt->CAttribute->GetTagName();
				$CDTag->StartPos = $sPos - $tsLen;
				$CDTag->EndPos = $i;
				$CDTag->CAttribute = $cAtt->CAttribute;
				$CDTag->IsReplace = FALSE;
				$CDTag->TagID = $this->Count;
				$CDTag->InnerText = $innerText;
				$this->CTags[$this->Count] = $CDTag;
				//���庯����ִ��PHP���
				if( $CDTag->TagName == "define"){
				  @eval($CDTag->InnerText);
			  }
			}	
		}//��������ģ���ַ���
		if($this->IsCache) $this->SaveCache();
	}
	//����ĳ�ֶεĺ���
	function EvalFunc($fieldvalue,$functionname)
	{
		$DedeFieldValue = $fieldvalue;
		$functionname = str_replace("{\"","[\"",$functionname);
		$functionname = str_replace("\"}","\"]",$functionname);
		$functionname = eregi_replace("'@me'|\"@me\"|@me",'$DedeFieldValue',$functionname);
		$functionname = "\$DedeFieldValue = ".$functionname;
		eval($functionname.";");
		if(empty($DedeFieldValue)) return "";
		else return $DedeFieldValue;
	}
	//���һ���ⲿ����
	function GetGlobals($varname)
	{
		$varname = trim($varname);
		//��ֹ��ģ���ļ���ȡ���ݿ�����
		if($varname=="dbuserpwd"||$varname=="cfg_dbpwd") return "";
		//�������
		if(isset($GLOBALS[$varname])) return $GLOBALS[$varname];
		else return "";
	}
	//�����ļ�
	function IncludeFile($filename,$ismake='no')
	{
		global $cfg_df_style;
		$restr = "";
		if(file_exists($filename)){ $okfile = $filename; }
		else if( file_exists(dirname(__FILE__)."/".$filename) ){ $okfile = dirname(__FILE__)."/".$filename; }
		else if( file_exists(dirname(__FILE__)."/../".$filename) ){ $okfile = dirname(__FILE__)."/../".$filename; }
		else if( file_exists(dirname(__FILE__)."/../templets/".$filename) ){ $okfile = dirname(__FILE__)."/../templets/".$filename; }
		else if( file_exists(dirname(__FILE__)."/../templets/".$cfg_df_style."/".$filename) ){ $okfile = dirname(__FILE__)."/../templets/".$cfg_df_style."/".$filename; }
		else{ return "�޷������λ���ҵ��� $filename"; }
		//����
  	if($ismake=="yes"){
  		require_once(dirname(__FILE__)."/inc_arcpart_view.php");
  		$pvCopy = new PartView();
  		$pvCopy->SetTemplet($okfile,"file");
  		$restr = $pvCopy->GetResult();
    }else{
  	  $fp = @fopen($okfile,"r");
		  while($line=fgets($fp,1024)) $restr.=$line;
		  fclose($fp);
	  }
		return $restr;
	}
}

/**********************************************
//class DedeAttribute Dedeģ�������Լ���
function c____DedeAttribute();
**********************************************/
//���Ե���������
class DedeAttribute
{
     var $Count = -1;
     var $Items = ""; //����Ԫ�صļ���
     //���ĳ������
     function GetAtt($str){
       if($str=="") return "";
       if(isset($this->Items[$str])) return $this->Items[$str];
       else return "";
     }
     //ͬ��
     function GetAttribute($str){
       return $this->GetAtt($str);
     }
     //�ж������Ƿ����
     function IsAttribute($str){
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
}
/*******************************
//���Խ�����
function c____DedeAttributeParse();
********************************/
class DedeAttributeParse
{
	var $SourceString = "";
	var $SourceMaxSize = 1024;
	var $CAttribute = ""; //���Ե�����������
	var $CharToLow = TRUE;
	//////�������Խ�����Դ�ַ���////////////////////////
	function SetSource($str="")
	{
    $this->CAttribute = new DedeAttribute();
		//////////////////////
		$strLen = 0;
		$this->SourceString = trim(preg_replace("/[ \t\r\n]{1,}/"," ",$str));
		$strLen = strlen($this->SourceString);
		if($strLen>0&&$strLen<=$this->SourceMaxSize){
			$this->ParseAttribute();
		}
	}
	//////��������(˽�г�Ա������SetSource����)/////////////////
	function ParseAttribute()
	{
		$d = "";
		$tmpatt="";
		$tmpvalue="";
		$startdd=-1;
		$ddtag="";
		$notAttribute=true;
		$strLen = strlen($this->SourceString);
		// �����ǻ��Tag������,��������Ƿ���Ҫ
		// ���������������,���ڽ�������Tagʱ����
		// �����в�Ӧ�ô���tagname�������
		for($i=0;$i<$strLen;$i++)
		{
			$d = substr($this->SourceString,$i,1);
			if($d==' '){
				$this->CAttribute->Count++;
				if($this->CharToLow) $this->CAttribute->Items["tagname"]=strtolower(trim($tmpvalue));
				else $this->CAttribute->Items["tagname"]=trim($tmpvalue);
				$tmpvalue = "";
				$notAttribute = false;
				break;
			}
			else
				$tmpvalue .= $d;
		}
		//�����������б�����
		if($notAttribute)
		{
			$this->CAttribute->Count++;
			if($this->CharToLow) $this->CAttribute->Items["tagname"]=strtolower(trim($tmpvalue));
			else $this->CAttribute->Items["tagname"]=trim($tmpvalue);
		}
		//����ַ�����������ֵ������Դ�ַ���,����ø�����
		if(!$notAttribute){
		for($i;$i<$strLen;$i++)
		{
			$d = substr($this->SourceString,$i,1);
			if($startdd==-1){
				if($d!="=")	$tmpatt .= $d;
				else{
					if($this->CharToLow) $tmpatt = strtolower(trim($tmpatt));
					else $tmpatt = trim($tmpatt);
					$startdd=0;
				}
			}
			else if($startdd==0)
			{
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
			else if($startdd==1)
			{
				if($d==$ddtag){
					$this->CAttribute->Count++;
          $this->CAttribute->Items[$tmpatt] = trim($tmpvalue);//strtolower(trim($tmpvalue));
					$tmpatt = "";
					$tmpvalue = "";
					$startdd=-1;
				}
				else
					$tmpvalue.=$d;
			}
		}
		if($tmpatt!=""){
			$this->CAttribute->Count++;
			$this->CAttribute->Items[$tmpatt]=trim($tmpvalue);//strtolower(trim($tmpvalue));
		}
		//������Խ���
	}//for
	}//has Attribute
}
?>