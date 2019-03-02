<?php 
/*------------------------
DedeCms���߲ɼ�����V2
���ߣ�IT����ͼ  
����ʱ�� 2006��9�� ������ʱ�� 2007-1-17
-----------------------*/
require_once(dirname(__FILE__)."/pub_httpdown.php");
require_once(dirname(__FILE__)."/pub_dedetag.php");
require_once(dirname(__FILE__)."/pub_db_mysql.php");
require_once(dirname(__FILE__)."/pub_charset.php");
require_once(dirname(__FILE__)."/pub_collection_functions.php"); //�ɼ���չ����
require_once(dirname(__FILE__)."/inc_photograph.php");
require_once(dirname(__FILE__)."/pub_dedehtml2.php");
@set_time_limit(0);
class DedeCollection
{
	var $Item = array(); //�ɼ��ڵ�Ļ���������Ϣ
	var $List = array(); //�ɼ��ڵ����Դ�б�����Ϣ
	var $Art = array();  //�ɼ��ڵ�����´�����Ϣ
	var $ArtNote = array(); //���²ɼ����ֶ���Ϣ
	var $dsql = "";
	var $NoteId = "";
	var $CDedeHtml = "";
	var $CHttpDown = "";
	var $MediaCount = 0;
	var $tmpUnitValue = "";
	var $tmpLinks = array();
	var $tmpHtml = "";
	var $breImage = "";
	//-------------------------------
	//����php5���캯��
	//-------------------------------
	function __construct(){
 		 $this->dsql = new DedeSql(false);
		 $this->CHttpDown = new DedeHttpDown();
		 $this->CDedeHtml = new DedeHtml2();
  }
	function DedeCollection(){
		 $this->__construct();
	}
	function Init(){
		//�������Ժ���
	}
	//������Դ
	//---------------------------
	function Close(){
		 $this->dsql->Close();
		 unset($this->Item);
	   unset($this->List);
	   unset($this->Art);
	   unset($this->ArtNote);
	   unset($this->tmpLinks);
	   unset($this->dsql);
	   unset($this->CDedeHtml);
	   unset($this->CHttpDown);
	   unset($this->tmpUnitValue);
	   unset($this->tmpHtml);
	}
	//-------------------------------
	//�����ݿ�������ĳ���ڵ�
	//-------------------------------
	function LoadNote($nid)
	{
		$this->NoteId = $nid;
		$this->dsql->SetSql("Select * from #@__conote where nid='$nid'");
		$this->dsql->Execute();
		$row = $this->dsql->Getarray();
		$this->LoadConfig($row["noteinfo"]);
		$this->dsql->FreeResult();
	}
	//-------------------------------
	//�����ݿ�������ĳ���ڵ�
	//-------------------------------
	function LoadFromDB($nid)
	{
		$this->NoteId = $nid;
		$this->dsql->SetSql("Select * from #@__conote where nid='$nid'");
		$this->dsql->Execute();
		$row = $this->dsql->GetArray();
		$this->LoadConfig($row["noteinfo"]);
		$this->dsql->FreeResult();
	}
	//----------------------------
	//�����ڵ��������Ϣ
	//----------------------------
	function LoadConfig($configString)
	{
		$dtp = new DedeTagParse();
		$dtp->SetNameSpace("dede","{","}");
		$dtp2 = new DedeTagParse();
		$dtp2->SetNameSpace("dede","{","}");
		$dtp3 = new DedeTagParse();
		$dtp3->SetNameSpace("dede","{","}");
		$dtp->LoadString($configString);
		for($i=0;$i<=$dtp->Count;$i++)
		{
			$ctag = $dtp->CTags[$i];
			//item ����
			//�ڵ������Ϣ
			if($ctag->GetName()=="item")
			{
				$this->Item["name"] = $ctag->GetAtt("name");
				$this->Item["typeid"] = $ctag->GetAtt("typeid");
				$this->Item["imgurl"] = $ctag->GetAtt("imgurl");
				$this->Item["imgdir"] = $ctag->GetAtt("imgdir");
				$this->Item["language"] = $ctag->GetAtt("language");
				$this->Item["matchtype"] = $ctag->GetAtt("matchtype");
				$this->Item["isref"] = $ctag->GetAtt("isref");
				$this->Item["refurl"] = $ctag->GetAtt("refurl");
				$this->Item["exptime"] = $ctag->GetAtt("exptime"); 
				if($this->Item["matchtype"]=="") $this->Item["matchtype"]="string";
				//����ͼƬ����Ŀ¼
				$updir = dirname(__FILE__)."/".$this->Item["imgdir"]."/";
				$updir = str_replace("\\","/",$updir);
				$updir = preg_replace("/\/{1,}/","/",$updir);
				if(!is_dir($updir)) MkdirAll($updir,777);
			}
			//list ����
			//Ҫ�ɼ����б�ҳ����Ϣ
			else if($ctag->GetName()=="list")
			{
				$this->List["varstart"]= $ctag->GetAtt("varstart");
				$this->List["varend"] = $ctag->GetAtt("varend");
				$this->List["source"] = $ctag->GetAtt("source");
				$this->List["sourcetype"] = $ctag->GetAtt("sourcetype");
				$dtp2->LoadString($ctag->GetInnerText());
				for($j=0;$j<=$dtp2->Count;$j++)
				{
					$ctag2 = $dtp2->CTags[$j];
					$tname = $ctag2->GetName();
					if($tname=="need"){
						$this->List["need"] = trim($ctag2->GetInnerText());
					}else if($tname=="cannot"){
						$this->List["cannot"] = trim($ctag2->GetInnerText());
					}
					else if($tname=="linkarea"){
						$this->List["linkarea"] = trim($ctag2->GetInnerText());
				  }else if($tname=="url")
					{
						$gurl = trim($ctag2->GetAtt("value"));
						//�ֹ�ָ���б���ַ
						if($this->List["source"]=="app")
						{
							$turl = trim($ctag2->GetInnerText());
							$turls = explode("\n",$turl);
							$l_tj = 0;
							foreach($turls as $turl){
								$turl = trim($turl);
								if($turl=="") continue;
								if(!eregi("^http://",$turl)) $turl = "http://".$turl;
								$this->List["url"][$l_tj] = $turl;
								$l_tj++;
							}
						}
						//�÷�ҳ������������ַ
						else
						{	
							if(eregi("var:��ҳ",trim($ctag2->GetAtt("value")))){
								if($this->List["varstart"]=="") $this->List["varstart"]=1;
								if($this->List["varend"]=="") $this->List["varend"]=10;
								$l_tj = 0;
								for($l_em = $this->List["varstart"];$l_em<=$this->List["varend"];$l_em++){
										$this->List["url"][$l_tj] = str_replace("[var:��ҳ]",$l_em,$gurl);
										$l_tj++;
								}
							}//if set var
							else{
								$this->List["url"][0] = $gurl;
							}
						}
					}
				}//End inner Loop1
			}
			//art ����
			//Ҫ�ɼ�������ҳ����Ϣ
			else if($ctag->GetName()=="art")
			{
				$dtp2->LoadString($ctag->GetInnerText());
				for($j=0;$j<=$dtp2->Count;$j++)
				{
					$ctag2 = $dtp2->CTags[$j];
					//����Ҫ�ɼ����ֶε���Ϣ������ʽ
					if($ctag2->GetName()=="note"){
						$field = $ctag2->GetAtt('field');
						if($field == "") continue;
						$this->ArtNote[$field]["value"] = $ctag2->GetAtt('value');
						$this->ArtNote[$field]["isunit"] = $ctag2->GetAtt('isunit');
						$this->ArtNote[$field]["isdown"] = $ctag2->GetAtt('isdown');
						$dtp3->LoadString($ctag2->GetInnerText());
						for($k=0;$k<=$dtp3->Count;$k++)
						{
							$ctag3 = $dtp3->CTags[$k];
							if($ctag3->GetName()=="trim"){
								$this->ArtNote[$field]["trim"][] = $ctag3->GetInnerText();
							}
							else if($ctag3->GetName()=="match"){
								$this->ArtNote[$field]["match"] = $ctag3->GetInnerText();
							}
							else if($ctag3->GetName()=="function"){
								$this->ArtNote[$field]["function"] = $ctag3->GetInnerText();
							}
						}
					}
					else if($ctag2->GetName()=="sppage"){
						$this->ArtNote["sppage"] = $ctag2->GetInnerText();
						$this->ArtNote["sptype"] = $ctag2->GetAtt('sptype');
					}
				}//End inner Loop2
			}
		}//End Loop
		$dtp->Clear();
		$dtp2->Clear();
	}
	//-----------------------------
	//��������һ����ַ��������
	//-----------------------------
	function DownUrl($aid,$dourl)
	{
		$this->tmpLinks = array();
	  $this->tmpUnitValue = "";
	  $this->tmpHtml = "";
	  $this->breImage = "";
		$GLOBALS['RfUrl'] = $dourl;
		$html = $this->DownOnePage($dourl);
		$this->tmpHtml = $html;
		//����Ƿ��з�ҳ�ֶΣ���Ԥ�ȴ���
		if(!empty($this->ArtNote["sppage"])){
		  $noteid = "";
		  foreach($this->ArtNote as $k=>$sarr){
			  if($sarr["isunit"]==1){ $noteid = $k; break;}
		  }
		  $this->GetSpPage($dourl,$noteid,$html);
		}
		//�����������ݣ�������
		$body = addslashes($this->GetPageFields($dourl,true));
		$query = "Update #@__courl set dtime='".mytime()."',result='$body',isdown='1' where aid='$aid'";
		$this->dsql->SetSql($query);
		if(!$this->dsql->ExecuteNoneQuery()){
			echo $this->dsql->GetError();
		}
		unset($body);
		unset($query);
		unset($html);
	}
	//------------------------
	//��ȡ��ҳ���������
	//------------------------
	function GetSpPage($dourl,$noteid,&$html,$step=0){
		 $sarr = $this->ArtNote[$noteid];
		 $linkareaHtml = $this->GetHtmlArea("[var:��ҳ����]",$this->ArtNote["sppage"],$html);
		 if($linkareaHtml==""){
		 	  if($this->tmpUnitValue=="") $this->tmpUnitValue .= $this->GetHtmlArea("[var:����]",$sarr["match"],$html);
		 	  else $this->tmpUnitValue .= "#p#������#e#".$this->GetHtmlArea("[var:����]",$sarr["match"],$html);
		    return;
		 }
		 //�����ķ�ҳ�б�
		 if($this->ArtNote["sptype"]=="full"||$this->ArtNote["sptype"]==""){
		 	  $this->tmpUnitValue .= $this->GetHtmlArea("[var:����]",$sarr["match"],$html);
		 	  $this->CDedeHtml->GetLinkType = "link";
				$this->CDedeHtml->SetSource($linkareaHtml,$dourl,false);
				foreach($this->CDedeHtml->Links as $k=>$t){
					$k = $this->CDedeHtml->FillUrl($k);
					if($k==$dourl) continue;
					$nhtml = $this->DownOnePage($k);
					if($nhtml!=""){ 
						$this->tmpUnitValue .= "#p#������#e#".$this->GetHtmlArea("[var:����]",$sarr["match"],$nhtml);
					}
			  }
		 }
		 //����ҳ��ʽ�������ķ�ҳ�б�
		 else{
		 	  if($step>50) return;
		 	  if($step==0) $this->tmpUnitValue .= "#e#".$this->GetHtmlArea("[var:����]",$sarr["match"],$html);
		 	  $this->CDedeHtml->GetLinkType = "link";
				$this->CDedeHtml->SetSource($linkareaHtml,$dourl,false);
				$hasLink = false;
				foreach($this->CDedeHtml->Links as $k=>$t){
					$k = $this->CDedeHtml->FillUrl($k);
					if(in_array($k,$this->tmpLinks)) continue;
					else{
						$nhtml = $this->DownOnePage($k);
					  if($nhtml!=""){ 
						  $this->tmpUnitValue .= "#p#������#e#".$this->GetHtmlArea("[var:����]",$sarr["match"],$nhtml);
					  }
					  $hasLink = true;
					  $this->tmpLinks[] = $k;
					  $dourl = $k;
					  $step++;
					}
			  }
			  if($hasLink) $this->GetSpPage($dourl,$noteid,$nhtml,$step);
		 } 
	}
	//-----------------------
	//��ȡ�ض������HTML
	//-----------------------
	function GetHtmlArea($sptag,&$areaRule,&$html){
	  //��������ʽ��ģʽƥ��
	  if($this->Item["matchtype"]=="regex"){
	     $areaRule = str_replace("/","\\/",$areaRule);
	     $areaRules = explode($sptag,$areaRule);
	     $arr = array();
	     if($html==""||$areaRules[0]==""){ return ""; }
       preg_match("/".$areaRules[0]."(.*)".$areaRules[1]."/isU",$html,$arr);
       if(!empty($arr[1])){ return trim($arr[1]); }
       else{ return ""; }
	  //���ַ���ģʽƥ��
	  }else{
	  	 $areaRules = explode($sptag,$areaRule);
	  	 if($html==""||$areaRules[0]==""){ return ""; }
	  	 $posstart = @strpos($html,$areaRules[0]);
	  	 if($posstart===false){ return ""; }
	  	 $posend = strpos($html,$areaRules[1],$posstart);
	  	 if($posend > $posstart && $posend!==false){
	  	 	 return substr($html,$posstart+strlen($areaRules[0]),$posend-$posstart-strlen($areaRules[0]));
	  	 }else{
	  	 	 return "";
	  	 }
	  }
	}
	//--------------------------
	//����ָ����ַ
	//--------------------------
	function DownOnePage($dourl){
		$this->CHttpDown->OpenUrl($dourl);
		$html = $this->CHttpDown->GetHtml();
		$this->CHttpDown->Close();
		$this->ChangeCode($html);
		return $html;
	}
	//---------------------
	//�����ض���Դ��������Ϊָ���ļ�
	//---------------------
	function DownMedia($dourl,$mtype='img'){
		//����Ƿ��Ѿ����ش��ļ�
		$isError = false;
		$errfile = $GLOBALS['cfg_phpurl'].'/img/etag.gif';
		$row = $this->dsql->GetOne("Select nurl from #@__co_mediaurl where rurl like '$dourl'");
		$wi = false;
		if(!empty($row['nurl'])){
			$filename = $row['nurl'];
			return $filename;
		}else{
		   //��������ڣ����ظ��ļ�
		   $filename = $this->GetRndName($dourl,$mtype);
		   if(!ereg("^/",$filename)) $filename = "/".$filename;
		   
		   //������ģʽ
		   if($this->Item["isref"]=='yes' && $this->Item["refurl"]!=''){
		      if($this->Item["exptime"]=='') $this->Item["exptime"] = 10;
		      $rs = DownImageKeep($dourl,$this->Item["refurl"],$GLOBALS['cfg_basedir'].$filename,"",0,$this->Item["exptime"]);
		      if($rs){
		         $inquery = "INSERT INTO #@__co_mediaurl(nid,rurl,nurl) VALUES ('".$this->NoteId."', '".addslashes($dourl)."', '".addslashes($filename)."');";
		         $this->dsql->ExecuteNoneQuery($inquery);
		      }else{
		      	$inquery = "INSERT INTO #@__co_mediaurl(nid,rurl,nurl) VALUES ('".$this->NoteId."', '".addslashes($dourl)."', '".addslashes($errfile)."');";
		        $this->dsql->ExecuteNoneQuery($inquery);
		      	$isError = true;
		      }
		      if($mtype=='img'){ $wi = true; }
	     //����ģʽ
	     }else{
		      $this->CHttpDown->OpenUrl($dourl);
		      $this->CHttpDown->SaveToBin($GLOBALS['cfg_basedir'].$filename);
		      $inquery = "INSERT INTO #@__co_mediaurl(nid,rurl,nurl) VALUES ('".$this->NoteId."', '".addslashes($dourl)."', '".addslashes($filename)."');";
		      $this->dsql->ExecuteNoneQuery($inquery);
		      if($mtype=='img'){ $wi = true; }
	        $this->CHttpDown->Close();
	     }
	  }
	  //��������ͼ
	  if($mtype=='img' && $this->breImage=='' && !$isError){
	  	$this->breImage = $filename;
	  	if(!eregi("^http://",$this->breImage) && file_exists($GLOBALS['cfg_basedir'].$filename)){
	  		$filenames = explode('/',$filename);
	  		$filenamed = $filenames[count($filenames)-1];
	  		$nfilename = "lit_".$filenamed;
	  		$nfilename = str_replace($filenamed,$nfilename,$filename);
	  		if(file_exists($GLOBALS['cfg_basedir'].$nfilename)){
	  			$this->breImage = $nfilename;
	  	  }else if(copy($GLOBALS['cfg_basedir'].$filename,$GLOBALS['cfg_basedir'].$nfilename)){
	  			ImageResize($GLOBALS['cfg_basedir'].$nfilename,$GLOBALS['cfg_ddimg_width'],$GLOBALS['cfg_ddimg_height']);
	  			$this->breImage = $nfilename;
	  		}
	    }
	  }
	  if($wi && !$isError) @WaterImg($GLOBALS['cfg_basedir'].$filename,'up');
		if(!$isError) return $filename;
		else return $errfile;
	}
	//------------------------------
	//�������ý����������
	//------------------------------
	function GetRndName($url,$v)
	{
		$this->MediaCount++;
		$mnum = $this->MediaCount;
		$timedir = strftime("%y%m%d",mytime());
		//���·��
		$fullurl = preg_replace("/\/{1,}/","/",$this->Item["imgurl"]."/");
		if(!is_dir($GLOBALS['cfg_basedir']."/$fullurl")) MkdirAll($GLOBALS['cfg_basedir']."/$fullurl",777);
		$fullurl = $fullurl.$timedir."/";
		if(!is_dir($GLOBALS['cfg_basedir']."/$fullurl")) MkdirAll($GLOBALS['cfg_basedir']."/$fullurl",777);
		//�ļ�����
		$timename = str_replace(".","",ExecTime());
		$threadnum = 0;
		if(isset($_GET["threadnum"])) $threadnum = $_GET["threadnum"];
		$filename = $timename.$threadnum.$mnum.mt_rand(1000,9999);
		//���ʺϵ�����תΪ��ĸ
		$filename = dd2char($filename);
		//������չ��
		$urls = explode(".",$url);
		if($v=="img"){
			$shortname = ".jpg";
			if(eregi("\.gif\?(.*)$",$url) || eregi("\.gif$",$url)) $shortname = ".gif";
			else if(eregi("\.png\?(.*)$",$url) || eregi("\.png$",$url)) $shortname = ".png";
		}
		else if($v=="embed") $shortname = ".swf";
		else $shortname = "";
		//-----------------------------------------
		$fullname = $fullurl.$filename.$shortname;
		return preg_replace("/\/{1,}/","/",$fullname);
	}
	//------------------------------------------------
	//���������ҳ���ݻ�ȡ���򣬴�һ��HTML�ļ��л�ȡ����
	//-------------------------------------------------
	function GetPageFields($dourl,$needDown)
	{
		if($this->tmpHtml == "") return "";
		$artitem = "";
		$isPutUnit = false;
		$tmpLtKeys = array();
		foreach($this->ArtNote as $k=>$sarr)
		{
			 //���ܳ�����������
			 if($k=="sppage"||$k=="sptype") continue;
			 if(!is_array($sarr)) continue;
		   //����Ĺ����ûƥ��ѡ��
		   if($sarr['match']==''||trim($sarr['match'])=='[var:����]'
		   ||$sarr['value']!='[var:����]'){
		     if($sarr['value']!='[var:����]') $v = $sarr['value'];
		     else $v = "";
		   }
		   else //��ƥ������
		   {
		      //�ֶ�ҳ������
		      if($this->tmpUnitValue!="" && !$isPutUnit && $sarr["isunit"]==1){ 
					    $v = $this->tmpUnitValue;
					    $isPutUnit = true;
			    //��������
			    }else{
			        $v = $this->GetHtmlArea("[var:����]",$sarr["match"],$this->tmpHtml);
			    }
		      //�������ݹ���
			    if(isset($sarr["trim"]) && $v!=""){
				     foreach($sarr["trim"] as $nv){
					      if($nv=="") continue;
					      $nv = str_replace("/","\\/",$nv);
					      $v = preg_replace("/$nv/isU","",$v);
				     }
			    }
			    //�Ƿ�����Զ����Դ
			    if($needDown){
			    	if($sarr["isdown"] == '1'){ $v = $this->DownMedias($v,$dourl); }
			    }
			    else{
			    	if($sarr["isdown"] == '1') $v = $this->MediasReplace($v,$dourl);
			    }
			}
			//�û����ж����ݽ��д���Ľӿ�
			if($sarr["function"]!=""){
				 if(!eregi('@litpic',$sarr["function"])){
				 	  $v = $this->RunPHP($v,$sarr["function"]);
				 	  $artitem .= "{dede:field name='$k'}$v{/dede:field}\r\n";
				 }else{
				   $tmpLtKeys[$k]['v'] = $v;
				   $tmpLtKeys[$k]['f'] = $sarr["function"];
				 }
			}else{
			   $artitem .= "{dede:field name='$k'}$v{/dede:field}\r\n";
			}
	  }//End Foreach
	  //���������ͼ��������Ŀ
	  foreach($tmpLtKeys as $k=>$sarr){
	  	$v = $this->RunPHP($sarr['v'],$sarr['f']);
			$artitem .= "{dede:field name='$k'}$v{/dede:field}\r\n";
	  }
		return $artitem;
	}
	//----------------------------------
	//�������������Դ
	//----------------------------------
	function DownMedias(&$html,$url)
	{
		$this->CDedeHtml->GetLinkType = "media";
		$this->CDedeHtml->SetSource($html,$url,false);
		//����img������ͼƬ
		foreach($this->CDedeHtml->Medias as $k=>$v){
			$furl = $this->CDedeHtml->FillUrl($k);
			if($v=="embed" && !eregi("\.(swf)\?(.*)$",$k)&& !eregi("\.(swf)$",$k)){ continue; }
			$okurl = $this->DownMedia($furl,$v);
			$html = str_replace($k,$okurl,$html);
		}
		//���س��������ͼƬ
		foreach($this->CDedeHtml->Links as $v=>$k){
			 if(eregi("\.(jpg|gif|png)\?(.*)$",$v) || eregi("\.(jpg|gif|png)$",$v)){ $m = "img"; }
			 else if(eregi("\.(swf)\?(.*)$",$v) || eregi("\.(swf)$",$v)){ $m = "embed"; }
			 else continue;
			 $furl = $this->CDedeHtml->FillUrl($v);
			 $okurl = $this->DownMedia($furl,$m);
			 $html = str_replace($v,$okurl,$html);
		}
		return $html;
	}
	//---------------------------------
	//���滻���������ԴΪ������ַ
	//----------------------------------
	function MediasReplace(&$html,$dourl)
	{
		$this->CDedeHtml->GetLinkType = "media";
		$this->CDedeHtml->SetSource($html,$dourl,false);
		foreach($this->CDedeHtml->Medias as $k=>$v)
		{
			$k = trim($k);
			if(!eregi("^http://",$k)){
				$okurl = $this->CDedeHtml->FillUrl($k);
				$html = str_replace($k,$okurl,$html);
			}
		}
		return $html;
	}
	//---------------------
	//�����б�
	//---------------------
	function TestList()
	{
		if(isset($this->List["url"][0])) $dourl = $this->List["url"][0];
		else{
				echo "������ָ���б����ַ����!\r\n";
	  		return ;
		}
		if($this->List["sourcetype"]=="archives")
		{
			echo "������ָ����Դ����Ϊ�ĵ���ԭʼURL��\r\n";
			$i=0;
			$v = "";
			foreach($this->List["url"] as $v){
				echo $v."\r\n"; $i++; if($i>9) break;
			}
			return $v;
		}
		$dhtml = new DedeHtml2();
		$html = $this->DownOnePage($dourl);
		if($html==""){
			echo "��ȡ���е�һ����ַ�� $dourl ʱʧ�ܣ�\r\n";
			return ;
		}
		if(trim($this->List["linkarea"])!=""&&trim($this->List["linkarea"])!="[var:����]"){
			$html = $this->GetHtmlArea("[var:����]",$this->List["linkarea"],$html);
		}
		
		$dhtml->GetLinkType = "link";
		$dhtml->SetSource($html,$dourl,false);
		
		$testpage = "";
		$TestPage = "";
		
		if(is_array($dhtml->Links))
		{
			echo "��ָ�������� $dourl ���ֵ���ַ��\r\n";
			echo $this->List["need"];
			foreach($dhtml->Links as $k=>$v)
			{
				$k =  $dhtml->FillUrl($k);
				if($this->List["need"]!="")
				{
					if(eregi($this->List["need"],$k))
					{
						if($this->List["cannot"]==""
						||!eregi($this->List["cannot"],$k)){
							echo "$k - ".$v."\r\n";
							$TestPage = $k;
						}
					}//eg1
				}else{
					echo "$k - ".$v."\r\n";
					$TestPage = $k;
				}
			}//foreach
		}else{
			echo "������ҳ��HTMLʱʧ�ܣ�\r\n";
			return ;
		}
		return $TestPage;
	}
	//�������¹���
	function TestArt($dourl)
	{
		if($dourl==""){
			 echo "û�еݽ����Ե���ַ��";
			 exit();
		}
		$this->tmpHtml = $this->DownOnePage($dourl);
		echo $this->GetPageFields($dourl,false);
	}
	//--------------------------------
	//�ɼ�������ַ
	//--------------------------------
	function GetSourceUrl($downall=0,$glstart=0,$pagesize=10)
	{
		if($downall==1 && $glstart==0){
		  $this->dsql->ExecuteNoneQuery("Delete From #@__courl where nid='".$this->NoteId."'");
		  $this->dsql->ExecuteNoneQuery("Delete From #@__co_listenurl where nid='".$this->NoteId."'");
		}
		if($this->List["sourcetype"]=="archives")
		{
			echo "������ָ����Դ����Ϊ�ĵ���ԭʼURL��<br/>������...<br/>\r\n";
			foreach($this->List["url"] as $v)
			{
				if($downall==0){
					$lrow = $this->dsql->GetOne("Select * From #@__co_listenurl where url like '".addslashes($v)."'");
	        if(is_array($lrow)) continue;
				}
				$inquery = "INSERT INTO #@__courl(nid,title,url,dtime,isdown,result) 
         VALUES ('".$this->NoteId."','�û��ֹ�ָ������ַ','$v','".mytime()."','0','');";
				$this->dsql->ExecuteNoneQuery($inquery);
			}
			echo "���������ַ�Ĵ���<br/>\r\n";
			return 0;
		}
		$tmplink = array();
		$arrStart = 0;
		$moviePostion = 0;
		$endpos = $glstart + $pagesize; 
		$totallen = count($this->List["url"]);
		foreach($this->List["url"] as $k=>$v)
		{
			$moviePostion++;
		 if($moviePostion > $endpos) break;
	   if($moviePostion > $glstart)
	   {
			  $html = $this->DownOnePage($v);
			
			  if(trim($this->List["linkarea"])!=""&&trim($this->List["linkarea"])!="[var:����]"){
			     $html = $this->GetHtmlArea("[var:����]",$this->List["linkarea"],$html);
		    }
		  
			  $this->CDedeHtml->GetLinkType = "link";
			  $this->CDedeHtml->SetSource($html,$v,false);
		  
		    foreach($this->CDedeHtml->Links as $k=>$v)
		    {
		  	  $k = $this->CDedeHtml->FillUrl($k);
		  	  if($this->List["need"]!=""){
					  if(eregi($this->List["need"],$k)){
						  if($this->List["cannot"]==""){	
							  $tmplink[$arrStart][0] = $this->CDedeHtml->FillUrl($k);
							  $tmplink[$arrStart][1] = $v; 
							  $arrStart++;
						  }
						  else if(!eregi($this->List["cannot"],$k)){
							  $tmplink[$arrStart][0] = $this->CDedeHtml->FillUrl($k);
							  $tmplink[$arrStart][1] = $v; 
							  $arrStart++;
						  }
					  }
				  }else{
					  $tmplink[$arrStart][0] = $this->CDedeHtml->FillUrl($k);
					  $tmplink[$arrStart][1] = $v; 
					  $arrStart++;
				  }
		    }
		    $this->CDedeHtml->Clear();
		  }//��λ����
		}//foreach
		krsort($tmplink);
		$unum = count($tmplink);
		if($unum>0){
		  //echo "��ɱ���������ַץȡ�����ҵ���{$unum} ����¼!<br/>\r\n";
		  $this->dsql->ExecuteNoneQuery();
		  foreach($tmplink as $v)
			{
				$k = addslashes($v[0]);
				$v = addslashes($v[1]);
				if($downall==0){
					$lrow = $this->dsql->GetOne("Select * From #@__co_listenurl where url like '$v' ");
	        if(is_array($lrow)) continue;
				}
				if($v=="") $v="�ޱ��⣬������ͼƬ����";
				$inquery = "
				INSERT INTO #@__courl(nid,title,url,dtime,isdown,result) 
         VALUES ('".$this->NoteId."','$v','$k','".mytime()."','0','');
				";
				$this->dsql->ExecuteNoneQuery($inquery);
			}
			if($endpos >= $totallen) return 0;
			else return ($totallen-$endpos);
	  }
	  else{
	  	echo "��ָ������û�ҵ��κ����ӣ�";
	  	return -1;
	  }
	  return -1;
	}
	//---------------------------------
	//����չ��������ɼ�����ԭʼ����
	//-------------------------------
	function RunPHP($fvalue,$phpcode)
	{
		$DedeMeValue = $fvalue;
		$phpcode = preg_replace("/'@me'|\"@me\"|@me/isU",'$DedeMeValue',$phpcode);
		if(eregi('@body',$phpcode)){
			$DedeBodyValue = $this->tmpHtml;
			$phpcode = preg_replace("/'@body'|\"@body\"|@body/isU",'$DedeBodyValue',$phpcode);
		}
		if(eregi('@litpic',$phpcode)){
			$DedeLitPicValue = $this->breImage;
			$phpcode = preg_replace("/'@litpic'|\"@litpic\"|@litpic/isU",'$DedeLitPicValue',$phpcode);
		}
		@eval($phpcode.";");
		return $DedeMeValue;
	}
	//-----------------------
	//����ת��
	//-----------------------
	function ChangeCode(&$str)
	{
		if($this->Item["language"]=="utf-8") $str = utf82gb($str);
		if($this->Item["language"]=="big5") $str = big52gb($str);
	}
}
?>