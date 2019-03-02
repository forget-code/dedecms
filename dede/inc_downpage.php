<?
/*=======================================
//֯��Http������
//��ע��������
1�����ʹ�á�Init($url)����ʼ���࣬������� StartHttpGet() ��ʼHTTP�Ự��
���ֱ����OpenUrl($url)��ʼ�����á�
2�����Ҫ�����ҳ���ı���ͬʱ���HTML�����ȵ��� HttpGetText()�ٵ���HttpGetHtml()��
����ȵ���HttpGetHtml()�����޷������ҳ�ı���
=======================================*/
class DedeDownPage
{
	var $m_url = "";
	var $m_hosturl = "";
	var $m_scheme = "http";
	var $m_host = "";
	var $m_port = "80";
	var $m_user = "";
	var $m_pass = "";
	var $m_path = "/";
	var $m_query = "";
	var $m_fp = "";
	var $m_errstr = "";
	var $m_httphead = "" ;
	var $m_html="";
	var $m_text="";
	//
	//��ʼ��ϵͳ
	//
	function Init($url)
	{
		$urls = "";
		$urls = @parse_url($url);
	    if($urls!="")
	    {
		  $this->m_host = $urls["host"];
		  if(!empty($urls["scheme"])) $this->m_scheme = $urls["scheme"];
		  $this->m_url = $this->m_scheme."://";
		  if(!empty($urls["user"])){
			$this->m_user = $urls["user"];
			$this->m_url .= $this->m_user.":";
		  }
		  if(!empty($urls["pass"])){
			$this->m_pass = $urls["pass"];
			$this->m_url .= $this->m_pass."@";
		  }
		  $this->m_url .= $this->m_host;
		  if(!empty($urls["port"])){
			$this->m_port = $urls["port"];
			if($this->m_port!="80") $this->m_url .= ":".$this->m_port;
		  }
		  if(!empty($urls["path"])) $this->m_path = $urls["path"];
		  $this->m_hosturl = $this->m_path;
		  $this->m_url .= $this->m_path;
		  if(!empty($urls["query"]))
		  {
			$this->m_query = $urls["query"];
			$this->m_hosturl .= "?".$this->m_query;
			$this->m_url .= "?".$this->m_query;
		  }
		}
	}
	//
	//��ָ����ַ
	//
	function OpenUrl($url)
	{
		$this->m_url = "";
		$this->m_hosturl = "";
		$this->m_scheme = "http";
		$this->m_host = "";
		$this->m_port = "80";
		$this->m_user = "";
		$this->m_pass = "";
		$this->m_path = "/";
		$this->m_query = "";
		$this->m_errstr = "";
		$this->m_httphead = "" ;
		$this->m_html = "";
		$this->m_text = "";
		$this->Close();
		$this->Init($url);
		$this->StartHttpGet();
	}
	//
	//�б���Get�������͵�ͷ��Ӧ�����Ƿ���ȷ
	//
	function IsGetOK()
	{
		if(ereg("^2",$this->GetHead("http-state"))&&$this->GetHead("content-length")!="")
			return true;
		else
			return false;
	}
	function IsText()
	{
		if(ereg("^2",$this->GetHead("http-state"))&&
		$this->GetHead("content-length")!=""&&
		eregi("^text",$this->GetHead("content-type")))
			return true;
		else
			return false;
	}
	//
	//��HttpЭ�������ļ�
	//
	function HttpBinDown($savefilename)
	{
		if(!$this->IsGetOK()) return false;
		if(!$this->m_fp||@feof($this->m_fp)) return "";
		$fp = fopen($savefilename,"w") or die("д���ļ� $savefilename ʧ�ܣ�");
		while(!feof($this->m_fp))
		{
			@fwrite($fp,fread($this->m_fp,1024));
		}
		@fclose($this->m_fp);
		return true;
	}
	//
	//��HttpЭ����һ����ҳ������
	//
	function HttpGetHtml()
	{
		if(!$this->IsGetOK()) return "";
		if($this->m_html!="") return $this->m_html;
		if(!$this->m_fp) return "";
		while(!feof($this->m_fp))
		{
			$this->m_html .= fread($this->m_fp,1024*10);
		}
		@fclose($this->m_fp);
		return $this->m_html;
	}
	//
	//��HttpЭ������ҳ���ı�����
	//
	function HttpGetText()
	{
		if(!$this->IsGetOK()||@feof($this->m_fp)) return "";
		$ptext = "";
		$comment = 0;
		$this->m_html = "";
		$linepos = 0;
		while(!feof($this->m_fp))
		{
			$line = fgets($this->m_fp,1024);
			if($comment==0){
				if(eregi("<script",$line)&&!eregi("</script",$line)) $comment = 1;
				else if(eregi("<style",$line)&&!eregi("</style",$line)) $comment = 2;
				else if(eregi("<iframe",$line)&&!ereg("</iframe",$line)) $comment = 3;
				else if(ereg("<!--",$line)&&!ereg("-->",$line)) $comment = 4;
				else
				{
					//$line= @strip_tags($line);
					//$ptext .= ereg_replace("��| {2,}|&nbsp;{2,}"," ",trim($line));
					$this->m_html .= $line;
				}
			}
			else
			{
				if(eregi("</script|</style|</iframe|-->",$line)) $comment = 0;
			}
			$linepos++;
			if($linepos>3000) break;
		}
		@fclose($this->m_fp);
		return $this->GetHtmlText($this->m_html);
	}
	//
	//��ȡHTML�ļ����Text
	//
	function GetHtmlText($html)
	{
		$msg = "";
		$msgs = split(">",$html);
		$mc = count($msgs);
		if($mc>1){
			for($i=0;$i<$mc;$i++){
				$lines = split("<",$msgs[$i]);
				$line = ereg_replace("	|��|��|[!\'\"=/&;\.-]{1,}|nbsp","",$lines[0]);
				$line = trim(ereg_replace(" {2,}"," ",$line));
				if(strlen($line)>8) $msg .= $line;
			}
		}
		else{
			$msg = ereg_replace("	|��|[!0-9a-zA-Z\'\"=/&;<\.:-]{1,}","",$msg);
		}
		return $msg;
	}
	//
	//��ʼHTTP�Ự
	//
	function StartHttpGet()
	{
		if(!$this->OpenHost()) return false;
		fputs($this->m_fp,"GET ".$this->m_url." HTTP/1.1\r\n");
		fputs($this->m_fp,"Host: ".$this->m_host."\r\n");
		fputs($this->m_fp,"Accept: */*\r\n");
		fputs($this->m_fp,"User-Agent: DedeSpider/2.0\r\n");
		fputs($this->m_fp,"\r\n");
		$httpstas = fgets($this->m_fp,1024);
		$httpstas = split(" ",$httpstas);
		$this->m_httphead["http-edition"] = trim($httpstas[0]);
		$this->m_httphead["http-state"] = trim($httpstas[1]);
		$this->m_httphead["http-describe"] = "";
		for($i=2;$i<count($httpstas);$i++)
		{
			$this->m_httphead["http-describe"] .= " ".trim($httpstas[$i]);
		}
		while(!feof($this->m_fp))
		{
			$line = trim(fgets($this->m_fp,1024));
			if($line == "") break;
			if(ereg(":",$line))
			{
				$lines = split(":",$line);
				$this->m_httphead[strtolower(trim($lines[0]))] = trim($lines[1]);
			}
		}
	}
	//
	//���һ��Httpͷ��ֵ
	//
	function GetHead($headname)
	{
		$headname = strtolower($headname);
		if(isset($this->m_httphead[$headname]))
			return $this->m_httphead[$headname];
		else
			return "";
	}
	//
	//������
	//
	function OpenHost()
	{
		if($this->m_host=="") return false;
		$this->m_fp = @fsockopen($this->m_host, $this->m_port, $errno, $errstr);
		if(!$this->m_fp)
		{
			$this->m_errstr = $errstr;
			return false;
		}
		else
			return true;
	}
	//
	//�ر�����
	//
	function Close()
	{
		@fclose($this->m_fp);
	}
}
?>