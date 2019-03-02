<?
//////////////////////////////////////////////////
//Dede Tagģ�������ֿ V1.1 ��
//����޸����ڣ�2005-1-10
//PHP�汾Ҫ�󣺴���4.0
//���ļ�����:
//class DedeTag ��ǵ���������
//class DedeAttribute Dedeģ�������Լ��ϵ���������
//class DedeTagParse Dedeģ�������
//class DedeAttributeParse Dedeģ�������Է�����

//Dede��֯�λ�֮��
/////////////////////////////////////////////////

/**********************************************
class DedeTag ����Tag��ǵ����ݽṹ����
***********************************************/

class DedeTag
{
	var $IsReplace; //����Ƿ��ѱ��������������ʹ��
	var $TagName; //�������
	var $InnerText; //���֮����ı�
	var $StartPos; //�����ʼλ��
	var $EndPos; //��ǽ���λ��
	var $CAttribute; //�����������,����class DedeAttribute
	function DedeTag()
	{
		$this->IsReplace=FALSE;
		$this->TagName="";
		$this->InnerText="";
		$this->StartPos=0;
		$this->EndPos=0;
		$this->CAttribute=new DedeAttribute();
	}
	function GetTagName()
	{
		return strtolower($this->TagName);
	}
    //
    //���³�Ա��CAttribute��ͬ����Ա����һ��
    //
	function IsAttribute($str)
	{
       return $this->CAttribute->IsAttribute($str);
	}
	function GetAttribute($str)
	{
    	return $this->CAttribute->GetAtt($str);
	}
	function GetAtt($str)
	{
		return $this->CAttribute->GetAtt($str);
	}
}

/**********************************************
//DedeTagParse Dedeģ�������
//Dedeģ���Ǹ�ʽ��
<dede:tagname name="value">InnerText</dede>
<dede:tagname name="value"></dede>
<dede:tagname name="value"/>
//�﷨��XML�﷨��ͬ������֧�ֱ��Ƕ��
//dede��֯�����ݹ���ϵͳV2.0����ʹ�õ������ռ�
//�����������Լ��Ŀ���ʱʹ�ñ�������ռ䣬��������ģ��֮ǰ���ã�
DedeTagParse->SetNameSpace($namespace);������(����������)
//�����ռ����Ϊ��������HTML,��������ԭ��,����Ľ��������ܽ���ͬһ��ģ��Ķ�������ռ䡣
//�ٷ���ַ��www.dedecms.com
***********************************************/

class DedeTagParse
{
	var $SourceString = "";//ģ���ַ���
	var $SourceStringCopy  ="";//ģ���ַ���

	var $SourceLen=0;	 //ģ���ַ�������

	var $CTags="";		 //$Tags��Ǽ���
	var $CTagsCopy = "";

	var $Count=-1;		 //$Tags��Ǹ���

	var $NameSpace="dede"; //��ǵ������ռ�

	var $TagStartWord = "<"; //�����ʼ

	var $TagEndWord = ">"; //��ǽ���

    //
    //
    //
    function ResetSource()
    {
    	$this->SourceString = $this->SourceStringCopy;
		$this->CTags = $this->CTagsCopy;
    }
	//
	//���ָ�����Ƶ�Tag��ID(����ж��ͬ����Tag,��ȡû�б�ȡ��Ϊ���ݵĵ�һ��Tag)
	//
	function GetTagID($str)
	{
		if($this->CTags=="") return -1;
		$str = strtolower($str);
		foreach($this->CTags as $ID=>$CTag)
		{
			if($CTag->TagName==$str && $CTag->IsReplace==FALSE)
			{
				return $ID;
				break;
			}
		}
		return -1;
	}
	//
	//���ָ�����Ƶ�Tag(����ж��ͬ����Tag,��ȡû�б�ȡ��Ϊ���ݵĵ�һ��Tag)
	//
	function GetTag($str)
	{
		if($this->CTags=="") return "";
		$str = strtolower($str);
		foreach($this->CTags as $ID=>$CTag)
		{
			if($CTag->TagName==$str && $CTag->IsReplace==FALSE)
			{
				return $CTag;
				break;
			}
		}
		return "";
	}
	//
	//��ָ����Tagȡ��Ϊָ�����ַ���
	//
	function ReplaceTag($tagid,$str)
	{
		 $slen = strlen($str);
		 $rlen = 0;
		 $moveLen = 0;
         //�쳣���
         if($tagid==-1) return FALSE;
		 if(!isset($this->CTags[$tagid])) return FALSE;
		 if($this->CTags[$tagid]->IsReplace) return FALSE;
         /////////////////////////////////////////////////
		 $rlen = $this->CTags[$tagid]->EndPos - $this->CTags[$tagid]->StartPos;
		 $moveLen = $slen-$rlen;
		 $this->SourceString = &substr_replace($this->SourceString,$str,$this->CTags[$tagid]->StartPos,$rlen);
		 $this->CTags[$tagid]->IsReplace=TRUE;
		 $this->SourceLen+=$moveLen;
		 for($i=0;$i<=$this->Count;$i++)
		 {
		 	if($i!=$tagid)
		 	{
		 		if($this->CTags[$i]->StartPos > $this->CTags[$tagid]->EndPos)
		 		{
		 			$this->CTags[$i]->StartPos+=$moveLen;
		 			$this->CTags[$i]->EndPos+=$moveLen;
		 		}
		 	}
		 }
         return TRUE;
	}
	//
	//��þ���������ģ���ַ���
	//
	function GetResult()
	{
		return $this->SourceString;
	}
	//
	//�Ѿ���������ģ�屣��Ϊ�����ļ�
	//
	function SaveTo($filename)
	{
		$fp = @fopen($filename,"w") or die("DedeTag�������޷������ļ���$filename");
		fwrite($fp,$this->SourceString);
		fclose($fp);
	}
	//
	//���ñ�ǵ������ռ䣬Ĭ��Ϊdede
	//
	function SetNameSpace($str)
	{
		$this->NameSpace = strtolower($str);
	}
	//
	//���ó�Ա�������ڴ�ģ��ǰ������������������ⱻ׷��ʹ�ã�
	//
	function SetDefault()
	{
		$this->SourceString="";
		$this->SourceLen=0;
		$this->CTag= new DedeTag();
		$this->Count=-1;
	}
	//
	//��ģ���ļ�
	//
	function LoadTemplate($filename)
	{
		$this->SetDefault();
		$fp = @fopen($filename,"r") or die("DedeTag�������޷���ȡ�ļ���$filename");
		while($line = fgets($fp,1024))
			$this->SourceString .= $line;
		fclose($fp);
		$this->SourceLen=strlen($this->SourceString);
		$this->ParseSource();
	}
	//
	//����ģ���ַ�����ע�⣺���������õ��ã�
	//
	function LoadSource($str)
	{
		$this->SetDefault();
		$this->SourceString = $str;
		$this->SourceLen=strlen($this->SourceString);
		$this->ParseSource();
	}
	//
	//���Tag������
	//
	function GetCount()
	{
		return $this->Count+1;
	}
	//
	//���Ľ�����������˽�г�Ա
	//
	function ParseSource()
	{
		$d = "";
		$startPos = 0;
		$endTagPos1 = 0;
		$endTagPos2 = 0;
		$endPos = 0;
		$tag = "";
		$TagStartWord = $this->TagStartWord;
		$TagEndWord = $this->TagEndWord;
		$nLen = strlen($this->NameSpace);
		if($this->SourceString=="") return;
		////��SourceString����һ������
		$this->SourceStringCopy = $this->SourceString;
		$CDAttribute = new DedeAttributeParse();
		$atFirst = 0;
		for($i=0;$i<$this->SourceLen;$i++)
		{
			$startPos = 0;
			$endTagPos1 = 0;
			$endTagPos2 = 0;
			$endPos = 0;
			$tag = "";
			$att = "";
			//Ѱ�ұ��
			$startPos = strpos($this->SourceString,$TagStartWord.$this->NameSpace,$i);
			//������һ���ַ�ΪTagStartWord�����
			if($i==0)
			{
				if($this->SourceString[0]==$TagStartWord)
				{
					$startPos=TRUE;
					$atFirst=1;
				}
			}
			//����Ҳ����κα�ǣ��˳�ѭ��
			if($startPos==FALSE) break;
			else
			{
				if($startPos==1) $i=1;
				else $i=$startPos+1;
				//�������/NameSpace��������/EndTag����
				//������߼����ײ���bug�������ּ��ģʽҲ���˷�
				//�������
				//1���Ƕ�ε�����һģ��ʱ��ResetSource()�ָ�ԭ���������ı�Ǻ�Դģ��
				//2���ɿ�������������ȼ�� endtag Ȼ��ȷ��ǰһ���Ƿ�Ϊ /  �ķ���,�������Ա��ⲻ��Ԥ���Ĳ���
				$endTagPos1 = strpos($this->SourceString,"/".$TagEndWord,$i);
				$endTagPos2 = strpos($this->SourceString,$TagStartWord."/".$this->NameSpace,$i);
				if($endTagPos1==FALSE) $endTagPos1=0;
				if($endTagPos2==FALSE) $endTagPos2=0;
				if(($endTagPos2<$endTagPos1&&$endTagPos2!=0)||$endTagPos1==0)
					$endPos = strpos($this->SourceString,$TagEndWord,$endTagPos2)+1;
				else
					$endPos=$endTagPos1+2;
				if($startPos==1)
				{
					$startPos = $startPos-1;
				}
			}
	        //�����⵽�ı��
			if($endPos-$startPos>$nLen+4)
			{
				$tag = substr($this->SourceString,$startPos,$endPos-$startPos);
				$i=$endPos;
				$endPost = 0;
				$endPost = strpos($tag,"/".$TagEndWord,0);
				if($endPost==FALSE) $endPost = strpos($tag,$TagEndWord,0);
				$att = substr($tag,$nLen+2,$endPost-$nLen-2);
				if($att!=FALSE)
				{
					if(ereg("[$TagEndWord$TagStartWord]",$att)) continue;
					$CDAttribute->SetSource($att);
					if($CDAttribute->CAttribute->GetTagName()!="")
					{
						$this->Count++;
						$CDTag = new DedeTag();
						$CDTag->TagName = $CDAttribute->CAttribute->GetTagName();
						$CDTag->InnerText = $this->GetInnerText($tag);
						$CDTag->StartPos = $startPos;
						$CDTag->EndPos = $endPos;
						$CDTag->CAttribute = $CDAttribute->CAttribute;
						$CDTag->IsReplace = FALSE;
					    $this->CTags[$this->Count] = $CDTag;
					}
					
				}//����$att!=FALSE
				
			}//���������⵽�ı��
			
		}//��������ģ���ļ�
		//��CTags����һ������
		$this->CTagsCopy = $this->CTags;
	}
	//
	//GetInnerText����˽�г�Ա
	//
	function GetInnerText(&$str)
	{
		$startPos = 0;
		$endPos = 0;
		$innertext = "";
		if(ereg("/".$this->TagEndWord,$str)) return "";
		else
		{
			$startPos = strpos($str,$this->TagEndWord,0);
			$endPos = strpos($str,$this->TagStartWord."/".$this->NameSpace,$startPos);
			$innertext = substr($str,$startPos+1,$endPos-$startPos-1);
			if($innertext==FALSE) return "";
			else return $innertext;
		}
	}
}

/**********************************************
//class DedeAttribute Dedeģ�������Լ���
**********************************************/
//���Ե���������
class DedeAttribute
{
       var $Count = -1;
       var $Items = ""; //����Ԫ�صļ���
       //
       //���ĳ������
       //
       function GetAtt($str)
       {
       		$str = strtolower(trim($str));
       		if($str=="") return "";
       		if(isset($this->Items[$str])) return $this->Items[$str];
            else return "";
       }
       //ͬ��
       function GetAttribute($str)
       {
       		return $this->GetAtt($str);
       }
       //
       //�ж������Ƿ����
       //
       function IsAttribute($str)
       {
       		if(!empty($this->Items[$str])) return true;
            else return false;
       }
       //
       //��ñ������
       //
       function GetTagName()
       {
         return $this->GetAtt("tagname");
       }
       //
       // ������Ը���
       //
       function GetCount()
	   {
			return $this->Count+1;
	   }
}
//
//���Խ�����
//
class DedeAttributeParse
{
	var $SourceString = "";
	var $SourceMaxSize = 1024;
	var $CAttribute = ""; //���Ե�����������
	//////�������Խ�����Դ�ַ���////////////////////////
	function SetSource($str="")
	{
        $this->CAttribute = new DedeAttribute();
		//////////////////////
		$strLen = 0;
		$this->SourceString = trim(ereg_replace("[ \t\r\n]{1,}"," ",$str));
		$strLen = strlen($this->SourceString);
		if($strLen>0&&$strLen<=$this->SourceMaxSize)
		{
			//����Դ�ַ��ǿպͲ���������޶�ֵʱ�Ž�������
			$this->parSource();
		}
	}
	//////��������(˽�г�Ա������SetSource����)/////////////////
	function ParSource()
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
			if($d==' ')
			{
				$this->CAttribute->Count++;
				$this->CAttribute->Items["tagname"]=strtolower(trim($tmpvalue));
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
			$this->CAttribute->Items["tagname"]=strtolower(trim($tmpvalue));
		}
		//����ַ�����������ֵ������Դ�ַ���,����ø�����
		if(!$notAttribute){
		for($i;$i<$strLen;$i++)
		{
			$d = substr($this->SourceString,$i,1);
			if($startdd==-1)
			{
				if($d!="=")	$tmpatt .= $d;
				else
				{
					$tmpatt = strtolower(trim($tmpatt));
					$startdd=0;
				}
			}
			else if($startdd==0)
			{
				switch($d)
				{
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
				if($d==$ddtag)
				{
					$this->CAttribute->Count++;
                    $this->CAttribute->Items[$tmpatt]=strtolower(trim($tmpvalue));
					$tmpatt = "";
					$tmpvalue = "";
					$startdd=-1;
				}
				else
					$tmpvalue.=$d;
			}
		}
		if($tmpatt!="")
		{
			$this->CAttribute->Count++;
			$this->CAttribute->Items[$tmpatt]=strtolower(trim($tmpvalue));
		}
		//������Խ���
	}//for
	}//has Attribute
}
?>