<?
require_once(dirname(__FILE__)."/inc_arcpart_view.php");
require_once(dirname(__FILE__)."/inc_downclass.php");
require_once(dirname(__FILE__)."/inc_channel_unit.php");
/******************************************************
//Copyright 2004-2006 by DedeCms.com itprato
//�������;����������ĵ�����ĵ�����HTML
******************************************************/
@set_time_limit(0);
class Archives
{
	var $TypeLink;
	var $ChannelUnit;
	var $dsql;
	var $Fields;
	var $dtp;
	var $ArcID;
	var $SplitPageField;
	var $SplitFields;
	var $NowPage;
	var $TotalPage;
	var $NameFirst;
	var $ShortName;
	var $FixedValues;
	var $PartView;
	var $TempSource;
	var $IsError;
	var $SplitTitles;
	//-------------------------------
	//php5���캯��
	//-------------------------------
	function __construct($aid)
 	{
 		$t1 = ExecTime();
 		$this->IsError = false;
 		$this->dsql = new DedeSql(false);
 		$this->ArcID = $aid;
 		$query = "Select arc.*,tp.reID,tp.typedir from #@__archives arc 
 		left join #@__arctype tp on tp.ID=arc.typeid where arc.ID='$aid'";
 		$row = $this->dsql->GetOne($query);
 		
 		if(!is_array($row)){
 			$this->dsql->Close();
 			$this->IsError = true;
 			return;
 	  }
 		
 		foreach($row as $k=>$v){
 			if(!ereg("[^0-9]",$k)) continue;
 			else $this->Fields[$k] = $v;
 		}
 		
 		if($this->Fields['channel']==0) $this->Fields['channel']=1;
 		$this->ChannelUnit = new ChannelUnit($this->Fields['channel'],$aid);
 		
 		$this->TypeLink = new TypeLink($this->Fields['typeid']);
 		
 		if($row['redirecturl']!="") return;
 		
 		$this->dtp = new DedeTagParse();
 		$this->SplitPageField = $this->ChannelUnit->SplitPageField;
 		$this->SplitFields = "";
 		$this->TotalPage = 1;
 		$this->NameFirst = "";
 		$this->ShortName = "html";
 		$this->FixedValues = "";
 		$this->TempSource = "";
 		$this->PartView = new PartView($this->Fields['typeid']);
 		if(empty($GLOBALS["pageno"])) $this->NowPage = 1;
 		else $this->NowPage = $GLOBALS["pageno"];
 		//������ֶ����ݴ���
 		//-------------------------------------
 		$this->Fields['aid'] = $aid;
 		$this->Fields['id'] = $aid;
 		$this->Fields['position'] = $this->TypeLink->GetPositionLink(true);
 		//����һЩȫ�ֲ�����ֵ
 		foreach($GLOBALS['PubFields'] as $k=>$v) $this->Fields[$k] = $v;
 		if($this->Fields['litpic']=="") $this->Fields['litpic'] = $this->Fields["phpurl"]."/img/dfpic.gif";
 		
 		//��ȡ���ӱ���Ϣ�����Ѹ��ӱ�����Ͼ������봦����뵽$this->Fields�У��Է�����
 		//ģ������ {dede:field name='fieldname' /} ���ͳһ����
 		if($this->ChannelUnit->ChannelInfos["addtable"]!=""){
 		  $row = $this->dsql->GetOne("select * from ".trim($this->ChannelUnit->ChannelInfos["addtable"])." where aid=$aid ");
 		  if(is_array($row)) foreach($row as $k=>$v){ if(ereg("[A-Z]",$k)) $row[strtolower($k)] = $v; }
 		  foreach($this->ChannelUnit->ChannelFields as $k=>$arr)
 		  {
 		  	if(isset($row[$k])){
 		  		if($arr["rename"]!="") $nk = $arr["rename"];
 		  		else $nk = $k;
 		  		$this->Fields[$nk] = $this->ChannelUnit->MakeField($k,$row[$k]);
 		  		if($arr['type']=='htmltext' && $GLOBALS['cfg_keyword_replace']=='��'){
 		  			$this->Fields[$nk] = $this->ReplaceKeyword($this->Fields['keywords'],$this->Fields[$nk]);
 		  		}
 		  	} 
 		  }//End foreach
 		}
 		//��ɸ��ӱ���Ϣ��ȡ
 		unset($row);
 		//����Ҫ��ҳ��ʾ���ֶ�
 		//---------------------------
 		$this->SplitTitles = Array();
 		if($this->SplitPageField!="" && $GLOBALS['cfg_arcsptitle']='��' &&
 		 isset($this->Fields[$this->SplitPageField])){
 			$this->SplitFields = explode("#p#",$this->Fields[$this->SplitPageField]);
 			$i = 1;
 			foreach($this->SplitFields as $k=>$v){
 				$tmpv = cn_substr($v,50);
 				$pos = strpos($tmpv,'#e#');
 				if($pos>0){
 					$st = trim(cn_substr($tmpv,$pos));
 					if($st==""||$st=="������"||$st=="��ҳ����"){
 						$this->SplitFields[$k] = cn_substr($v,strlen($v),$pos+3);
 						continue;
 					}else{
 						$this->SplitFields[$k] = cn_substr($v,strlen($v),$pos+3);
 						$this->SplitTitles[$k] = $st;
 				  }
 				}else{ continue; }
 				$i++;
 			}
 			$this->TotalPage = count($this->SplitFields);
 		}
 		
 		$this->LoadTemplet();
 		$this->ParseTempletsFirst();
 	}
 	//php4���캯��
 	//---------------------------
 	function Archives($aid){
 		$this->__construct($aid);
 	}
 	//----------------------------
  //���ɾ�̬HTML
  //----------------------------
  function MakeHtml()
  {
  	if($this->IsError) return "";
  	//����Ҫ�������ļ�����
  	//------------------------------------------------------
  	$filename = $this->TypeLink->GetFileNewName(
  	  $this->ArcID,$this->Fields["typeid"],$this->Fields["senddate"],
  	  $this->Fields["title"],$this->Fields["ismake"],
  	  $this->Fields["arcrank"],"","",$this->Fields["money"],
  	  $this->TypeLink->TypeInfos['siterefer'],
  	  $this->TypeLink->TypeInfos['sitepath']
  	);
  	$filenames  = explode(".",$filename);
  	$this->ShortName = $filenames[count($filenames)-1];
  	if($this->ShortName=="") $this->ShortName = "html";
  	$fileFirst = eregi_replace("\.".$this->ShortName."$","",$filename);
  	$filenames  = explode("/",$filename);
  	$this->NameFirst = eregi_replace("\.".$this->ShortName."$","",$filenames[count($filenames)-1]);
  	if($this->NameFirst=="") $this->NameFirst = $this->arcID;
  	
  	//��õ�ǰ�ĵ���ȫ��
  	$filenameFull = GetFileUrl(
  	  $this->ArcID,$this->Fields["typeid"],$this->Fields["senddate"],
  	  $this->Fields["title"],$this->Fields["ismake"],
  	  $this->Fields["arcrank"],"","",$this->Fields["money"],
  	  true,
  	  $this->TypeLink->TypeInfos['siteurl']
  	);
  	if(!eregi('http://',$filenameFull)) $filenameFull = $GLOBALS['cfg_basehost'].$filenameFull;
  	$this->Fields['arcurl'] = $filenameFull;
  	$this->Fields['fullname'] = $this->Fields['arcurl'];
  	//���������ò�����HTML������ֱ�ӷ�����ַ
  	//------------------------------------------------
  	if($this->Fields['ismake']==-1||$this->Fields['arcrank']!=0||
  	   $this->Fields['typeid']==0||$this->Fields['money']>0)
  	{
  		$this->Close();
  		return $this->GetTrueUrl($filename);
  	}
  	//��ת��ַ
  	if($this->Fields['redirecturl']!="")
  	{
  		$truefilename = $this->GetTruePath().$fileFirst.".".$this->ShortName;
  		$pageHtml = "<html>\n<head>\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">\n<title>ת��".$this->Fields['title']."</title>\n";
  		$pageHtml .= "<meta http-equiv=\"refresh\" content=\"1;URL=".$this->Fields['redirecturl']."\">\n</head>\n<body>\n";
      $pageHtml .= "��������ת��".$this->Fields['title']."�����Ժ�...<br/><br/>\nת�����ݼ��:".$this->Fields['description']."\n</body>\n</html>\n";
  		$fp = @fopen($truefilename,"w") or die("Create File False��$filename");
		  fwrite($fp,$pageHtml);
		  fclose($fp);
  	}else{ //ѭ������HTML�ļ�
  	  for($i=1;$i<=$this->TotalPage;$i++){
  	     if($i>1){ $truefilename = $this->GetTruePath().$fileFirst."_".$i.".".$this->ShortName; }
  	     else{ $truefilename = $this->GetTruePath().$filename; }
  	     $this->ParseDMFields($i,1);
  	     $this->dtp->SaveTo($truefilename);
      }
    }
    $this->dsql->SetQuery("Update #@__archives set ismake=1 where ID='".$this->ArcID."'");
    $this->dsql->ExecuteNoneQuery();
    $this->Close();
  	return $this->GetTrueUrl($filename);
  }
  //----------------------------
 	//�����ʵ����·��
 	//----------------------------
 	function GetTrueUrl($nurl)
 	{
 		if($GLOBALS['cfg_multi_site']=='��' && !eregi('php\?',$nurl)){
 			if($this->TypeLink->TypeInfos['siteurl']=="") $nsite = $GLOBALS["cfg_mainsite"];
 			else $nsite = $this->TypeLink->TypeInfos['siteurl'];
 			$nurl = ereg_replace("/$","",$nsite).$nurl;
 		}
 		return $nurl;
 	}
 	//----------------------------
 	//���վ�����ʵ��·��
 	//----------------------------
 	function GetTruePath()
 	{
 		if($GLOBALS['cfg_multi_site']=='��'){
 		   if($this->TypeLink->TypeInfos['siterefer']==1) $truepath = ereg_replace("/{1,}","/",$GLOBALS["cfg_basedir"]."/".$this->TypeLink->TypeInfos['sitepath']);
	     else if($this->TypeLink->TypeInfos['siterefer']==2) $truepath = $this->TypeLink->TypeInfos['sitepath'];
	     else $truepath = $GLOBALS["cfg_basedir"];
	  }else{
	  	$truepath = $GLOBALS["cfg_basedir"];
	  }
	  return $truepath;
 	}
  //----------------------------
  //���ָ����ֵ���ֶ�
  //----------------------------
  function GetField($fname)
  {
  	if(isset($this->Fields[$fname])) return $this->Fields[$fname];
  	else return "";
  }
  //-----------------------------
  //���ģ���ļ�λ��
  //-----------------------------
  function GetTempletFile()
  {
 	  global $cfg_basedir,$cfg_templets_dir,$cfg_df_style;
 	  $cid = $this->ChannelUnit->ChannelInfos["nid"];
 	  if($this->Fields['templet']!=''){ $filetag = MfTemplet($this->Fields['templet']); }
 	  else{ $filetag = MfTemplet($this->TypeLink->TypeInfos["temparticle"]); }
 	  $tid = $this->Fields["typeid"];
 	  $filetag = str_replace("{cid}",$cid,$filetag);
 	  $filetag = str_replace("{tid}",$tid,$filetag);
 	  $tmpfile = $cfg_basedir.$cfg_templets_dir."/".$filetag;
 	  if($cid=='spec'){
 	  	if($this->Fields['templet']!=''){ $tmpfile = $cfg_basedir.$cfg_templets_dir."/".MfTemplet($this->Fields['templet']); }
 	  	else $tmpfile = $cfg_basedir.$cfg_templets_dir."/{$cfg_df_style}/article_spec.htm";
 	  }
 	  if(!file_exists($tmpfile)) $tmpfile = $cfg_basedir.$cfg_templets_dir."/{$cfg_df_style}/article_default.htm";
 	  return $tmpfile;
  }
  //----------------------------
 	//��̬������
 	//----------------------------
 	function display()
 	{
 		if($this->IsError){
 			$this->Close();
 			return "";
 		}
 		//��ת��ַ
  	if($this->Fields['redirecturl']!="")
  	{
  		$truefilename = $this->GetTruePath().$fileFirst.".".$this->ShortName;
  		$pageHtml = "<html>\n<head>\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">\n<title>ת��".$this->Fields['title']."</title>\n";
  		$pageHtml .= "<meta http-equiv=\"refresh\" content=\"1;URL=".$this->Fields['redirecturl']."\">\n</head>\n<body>\n";
      $pageHtml .= "��������ת��".$this->Fields['title']."�����Ժ�...<br/><br/>\nת�����ݼ��:\n".$this->Fields['description']."\n</body>\n</html>\n";
  		echo $pageHtml;
		  $this->Close();
		  exit();
  	}
 		$pageCount = $this->NowPage;
 		$this->ParseDMFields($pageCount,0);
 		$this->Close();
  	$this->dtp->display();
  	
 	}
 	//--------------
 	//����ģ��
 	//--------------
 	function LoadTemplet()
 	{
 		if($this->TempSource=="")
 		{
 			$tempfile = $this->GetTempletFile();
 		  if(!file_exists($tempfile)||!is_file($tempfile)){
 			  echo "ģ���ļ���'".$tempfile."' �����ڣ��޷������ĵ���";
 			  exit();
 		  }
 		  $this->dtp->LoadTemplate($tempfile);
 		  $this->TempSource = $this->dtp->SourceString;
 		}else{
 			$this->dtp->LoadSource($this->TempSource);
 		}
 	}
  //--------------------------------
 	//����ģ�壬�Թ̶��ı�ǽ��г�ʼ��ֵ
 	//--------------------------------
 	function ParseTempletsFirst()
 	{
 		if(is_array($this->dtp->CTags))
 		{
 			foreach($this->dtp->CTags as $tagid=>$ctag)
 			{
 				$tagname = $ctag->GetName();
 				
 				$typeid = $ctag->GetAtt('typeid');
 				if($typeid=="") $typeid = 0;
 				if($typeid==0) $typeid = $this->Fields['typeid'];
 				
 				if($tagname=="arclist"||$tagname=="artlist"||$tagname=="likeart"||$tagname=="hotart"
 			  ||$tagname=="imglist"||$tagname=="imginfolist"||$tagname=="coolart"||$tagname=="specart")
 			  { 
 			  	//�ض��������б�
 				  $channelid = $ctag->GetAtt("channelid");
 				  if($tagname=="imglist"||$tagname=="imginfolist"){ $listtype = "image"; }
 				  else if($tagname=="specart"){ $channelid = -1; $listtype=""; }
 				  else if($tagname=="coolart"){ $listtype = "commend"; }
 				  else{ $listtype = $ctag->GetAtt('type'); }
 				   
 				  if($tagname=="likeart") $keywords = ""; //str_replace(" ",",",trim($this->Fields['keywords']));
 				  else $keywords = $ctag->GetAtt('keyword');
 				  
 				  //����
 				  if($tagname=="hotart") $orderby = "click";
 				  else if($tagname=="likeart") $orderby = "near";
 				  else $orderby = $ctag->GetAtt('orderby');
 				  
 				  //����Ӧ�ı��ʹ�ò�ͬ��Ĭ��innertext
 				  if(trim($ctag->GetInnerText())!="") $tagidnnertext = $ctag->GetInnerText();
 				  else if($tagname=="imglist") $tagidnnertext = GetSysTemplets("part_imglist.htm");
 				  else if($tagname=="imginfolist") $tagidnnertext = GetSysTemplets("part_imginfolist.htm");
 				  else $tagidnnertext = GetSysTemplets("part_arclist.htm");
 				  
 				  //����titlelength
 				  if($ctag->GetAtt('titlelength')!="") $titlelen = $ctag->GetAtt('titlelength');
 				  else $titlelen = $ctag->GetAtt('titlelen');
 				
 				  //����infolength
 				  if($ctag->GetAtt('infolength')!="") $tagidnfolen = $ctag->GetAtt('infolength');
 				  else $tagidnfolen = $ctag->GetAtt('infolen');
 				    
 				  //��������
 					if($tagname!="likeart"){
 						$gid = $this->Fields['typeid'];
 					  if($this->Fields['typeid2']!=0) $gid = $gid.",".$this->Fields['typeid2'];
 					}else{
 						$gid = 0;
 					}
 					/*if($this->Fields['reID']!=0 && $tagname=="likeart") $gid = $this->Fields['reID'];
 					else{
 					  $gid = $this->Fields['typeid'];
 					  if($this->Fields['typeid2']!=0) $gid = $gid.",".$this->Fields['typeid2'];
 					}*/

 					$typeid = trim($ctag->GetAtt("typeid"));
 				  if(empty($typeid)) $typeid = $gid;
 					
 				  $this->dtp->Assign($tagid,
 				       $this->PartView->GetArcList(
 				         $typeid,
 				         $ctag->GetAtt("row"),
 				         $ctag->GetAtt("col"),
 				         $titlelen,
 				         $tagidnfolen,
 				         $ctag->GetAtt("imgwidth"),
 				         $ctag->GetAtt("imgheight"),
 				         $listtype,
 				         $orderby,
 				         $keywords,
 				         $tagidnnertext,
 				         $ctag->GetAtt("tablewidth"),
 				         $this->ArcID,
 				         "",
 				         $channelid,
 				         $ctag->GetAtt("limit"),
 				         $ctag->GetAtt("att")
 				        )
 				  );
 			  }
 			  //�Զ�����
 			  //-----------------------
 			  else if($ctag->GetName()=="mytag")
 			  {
 				  $this->dtp->Assign($tagid,$this->PartView->GetMyTag(
 				        $typeid,
 				        $ctag->GetAtt("name"),
 				        $ctag->GetAtt("ismake")
 				     )
 				  );
 			  }
 			  //���Źؼ���
 			  else if($tagname=="hotwords"){
 				  $this->dtp->Assign($tagid,
 				  GetHotKeywords($this->dsql,$ctag->GetAtt('num'),$ctag->GetAtt('subday'),$ctag->GetAtt('maxlength')));
 			  }
 			  //����ƪ����
 			  else if($tagname=="prenext"){
 			  	$this->dtp->Assign($tagid,$this->GetPreNext());
 			  }
 			  //��õ�����ĿĿ������
 			  //-----------------------------
 			  else if($tagname=="onetype"||$tagname=="typeinfo"){
 				  $this->dtp->Assign($tagid,$this->PartView->GetOneType($typeid,$ctag->GetInnerText()));
 			  }
 			  //�����
 			  //-----------------------
 			  else if($ctag->GetName()=="myad"){
 				  $this->dtp->Assign($tagid,$this->PartView->GetMyAd($typeid,$ctag->GetAtt("name")));
 			  }
 			  else if($tagname=="loop")
 			  {
 				  $this->dtp->Assign($tagid,
				    $this->PartView->GetTable(
					    $ctag->GetAtt("table"),
					    $ctag->GetAtt("row"),
					    $ctag->GetAtt("sort"),
					    $ctag->GetAtt("if"),
					    $ctag->GetInnerText()
					  )
			    );
 			  }
 				else if($ctag->GetName()=="channel")
 				{
 					if($ctag->GetAtt("line")!="") $nrow = trim($ctag->GetAtt("line"));
 					else $nrow = trim($ctag->GetAtt("row"));
 				  
 				  if($nrow=="") $nrow = 8;
 			
 					$this->dtp->Assign($tagid,$this->TypeLink->GetChannelList(
 					  $this->Fields['typeid'],
 					  $this->Fields['reID'],
 					  $nrow,
 					  $ctag->GetAtt("type"),
 					  $ctag->GetInnerText(),
 				    $ctag->GetAtt("col"),
 				    $ctag->GetAtt("tablewidth"),
 				    $ctag->GetAtt("currentstyle")
 					));
 				}//End �жϱ��
 		  }//End foreach
 		}//is_array
  }
 	//--------------------------------
 	//����ģ�壬��������ı䶯���и�ֵ
 	//--------------------------------
 	function ParseDMFields($pageNo,$ismake=1)
 	{
 		$this->NowPage = $pageNo;
 		if($this->SplitPageField!="" &&
 		  isset($this->Fields[$this->SplitPageField]))
 		{
 			$this->Fields[$this->SplitPageField] = $this->SplitFields[$pageNo - 1];
 		}
 		//-------------------------
 	  //����ģ��
 		//-------------------------
 		if(is_array($this->dtp->CTags))
 		{
 			foreach($this->dtp->CTags as $i=>$ctag){
 				 if($ctag->GetName()=="field"){
 					  $this->dtp->Assign($i,$this->GetField($ctag->GetAtt("name")));
 				 }
 				 else if($ctag->GetName()=="pagebreak"){
 			      if($ismake==0)
 			      { $this->dtp->Assign($i,$this->GetPagebreakDM($this->TotalPage,$this->NowPage,$this->ArcID)); }
 			      else
 			      { $this->dtp->Assign($i,$this->GetPagebreak($this->TotalPage,$this->NowPage,$this->ArcID)); }
 		     }
 		     else if($ctag->GetName()=="pagetitle"){
 			      if($ismake==0)
 			      { $this->dtp->Assign($i,$this->GetPageTitlesDM($ctag->GetAtt("style"),$pageNo)); }
 			      else
 			      { $this->dtp->Assign($i,$this->GetPageTitlesST($ctag->GetAtt("style"),$pageNo)); }
 		     }
 		     else if($ctag->GetName()=="fieldlist")
 		     {
 		     	 $innertext = trim($ctag->GetInnerText());
 		     	 if($innertext=="") $innertext = GetSysTemplets("tag_fieldlist.htm");
 		     	 $dtp2 = new DedeTagParse();
	         $dtp2->SetNameSpace("field","[","]");
 		     	 $dtp2->LoadSource($innertext);
           $oldSource = $dtp2->SourceString;
           $oldCtags = $dtp2->CTags;
           $res = "";
 		     	 if(is_array($this->ChannelUnit->ChannelFields) && is_array($dtp2->CTags))
 		     	 {
 		     	   foreach($this->ChannelUnit->ChannelFields as $k=>$v)
 		     	   {
 		     	 	   $dtp2->SourceString = $oldSource;
               $dtp2->CTags = $oldCtags;
               $fname = $v['itemname'];
               if($v['type']=="datetime"){
               	 @$this->Fields[$k] = GetDateTimeMk($this->Fields[$k]);
               }
               foreach($dtp2->CTags as $tid=>$ctag)
               {
               	 if($ctag->GetName()=='name') $dtp2->Assign($tid,$fname);
               	 else if($ctag->GetName()=='value') @$dtp2->Assign($tid,$this->Fields[$k]);
               }
               $res .= $dtp2->GetResult();
 		     	   }
 		     	 }
 		     	 $this->dtp->Assign($i,$res);
 		     
 		     }//end case
 		     
 			}//����ģ��ѭ��
 		}
 	}
 	//---------------------------
 	//�ر���ռ�õ���Դ
 	//---------------------------
 	function Close()
 	{
 		$this->FixedValues = "";
 		$this->Fields = "";
 		if(is_object($this->dsql)) $this->dsql->Close();
 		if(is_object($this->ChannelUnit)) $this->ChannelUnit->Close();
 		if(is_object($this->TypeLink)) $this->TypeLink->Close();
 		if(is_object($this->PartView)) $this->PartView->Close();
 	}
 	//--------------------------
 	//��ȡ��һƪ����һƪ����
 	//--------------------------
 	function GetPreNext()
 	{
 		$rs = "";
 		$aid = $this->ArcID;
 		$next = " #@__archives.ID>'$aid' order by #@__archives.ID asc ";
 		$pre = " #@__archives.ID<'$aid' order by #@__archives.ID desc ";
 		$query = "Select #@__archives.ID,#@__archives.title,
 		#@__archives.typeid,#@__archives.ismake,#@__archives.senddate,#@__archives.arcrank,#@__archives.money,
		#@__arctype.typedir,#@__arctype.typename,#@__arctype.namerule,#@__arctype.namerule2,#@__arctype.ispart,
		#@__arctype.moresite,#@__arctype.siteurl 
		from #@__archives left join #@__arctype on #@__archives.typeid=#@__arctype.ID
		where ";
		$nextRow = $this->dsql->GetOne($query.$next);
		$preRow = $this->dsql->GetOne($query.$pre);
		if(is_array($preRow)){
			 $mlink = GetFileUrl($preRow['ID'],$preRow['typeid'],$preRow['senddate'],$preRow['title'],$preRow['ismake'],$preRow['arcrank'],$preRow['namerule'],$preRow['typedir'],$preRow['money'],true,$preRow['siteurl']);
       $rs .= "��һƪ��<a href='$mlink'>{$preRow['title']}</a> ";
		}
		else{
			$rs .= "��һƪ��û���� ";
		}
		if(is_array($nextRow)){
			 $mlink = GetFileUrl($nextRow['ID'],$nextRow['typeid'],$nextRow['senddate'],$nextRow['title'],$nextRow['ismake'],$nextRow['arcrank'],$nextRow['namerule'],$nextRow['typedir'],$nextRow['money'],true,$nextRow['siteurl']);
       $rs .= " &nbsp; ��һƪ��<a href='$mlink'>{$nextRow['title']}</a> ";
		}
		else{
			$rs .= " &nbsp; ��һƪ��û���� ";
	  }
		return $rs;
  }
 	//------------------------
 	//��ö�̬ҳ���ҳ�б�
 	//------------------------
 	function GetPagebreakDM($totalPage,$nowPage,$aid)
	{	
		if($totalPage==1){ return ""; }
		$PageList = "��".$totalPage."ҳ: ";
		$nPage = $nowPage-1;
		$lPage = $nowPage+1;
		if($nowPage==1) $PageList.="��һҳ ";
		else{ 
		  if($nPage==1) $PageList.="<a href='view.php?aid=$aid'>��һҳ</a> ";
		  else $PageList.="<a href='view.php?aid=$aid&pageno=$nPage'>��һҳ</a> ";
		}
		for($i=1;$i<=$totalPage;$i++)
		{
			if($i==1){
			  if($nowPage!=1) $PageList.="<a href='view.php?aid=$aid'>[1]</a> ";
			  else $PageList.="1 ";
			}else{
			  $n = $i;
			  if($nowPage!=$i) $PageList.="<a href='view.php?aid=$aid&pageno=$i'>[".$n."]</a> ";
			  else $PageList.="$n ";
			}
		}
		if($lPage <= $totalPage) $PageList.="<a href='view.php?aid=$aid&pageno=$lPage'>��һҳ</a> ";
		else $PageList.= "��һҳ ";
		return $PageList;
	}
	//-------------------------
	//��þ�̬ҳ���ҳ�б�
	//-------------------------
	function GetPagebreak($totalPage,$nowPage,$aid)
	{
		if($totalPage==1){ return ""; }
		$PageList = "��".$totalPage."ҳ: ";
		$nPage = $nowPage-1;
		$lPage = $nowPage+1;
		if($nowPage==1) $PageList.="��һҳ ";
		else{ 
		  if($nPage==1) $PageList.="<a href='".$this->NameFirst.".".$this->ShortName."'>��һҳ</a> ";
		  else $PageList.="<a href='".$this->NameFirst."_".$nPage.".".$this->ShortName."'>��һҳ</a> ";
		}
		for($i=1;$i<=$totalPage;$i++)
		{
			if($i==1){
			  if($nowPage!=1) $PageList.="<a href='".$this->NameFirst.".".$this->ShortName."'>[1]</a> ";
			  else $PageList.="1 ";
			}else{
			  $n = $i;
			  if($nowPage!=$i) $PageList.="<a href='".$this->NameFirst."_".$i.".".$this->ShortName."'>[".$n."]</a> ";
			  else $PageList.="$n ";
			}
		}
		if($lPage <= $totalPage) $PageList.="<a href='".$this->NameFirst."_".$lPage.".".$this->ShortName."'>��һҳ</a> ";
		else $PageList.= "��һҳ ";
		return $PageList;
	}
	//-------------------------
	//��ö�̬ҳ��С����
	//-------------------------
	function GetPageTitlesDM($styleName,$pageNo)
	{
		if($this->TotalPage==1){ return ""; }
		if(count($this->SplitTitles)==0){ return ""; }
		$i=1;
		$aid = $this->ArcID;
		if($styleName=='link')
		{
			$revalue = "";
		  foreach($this->SplitTitles as $k=>$v){
			   if($i==1) $revalue .= "<a href='view.php?aid=$aid&pageno=$i'>$v</a> \r\n";
		     else{
		     	 if($pageNo==$i) $revalue .= " $v \r\n";
		     	 else $revalue .= "<a href='view.php?aid=$aid&pageno=$i'>$v</a> \r\n";
		     }
		     $i++;
		  }
	  }else
	  {
		  $revalue = "<select id='dedepagetitles' onchange='location.href=this.options[this.selectedIndex].value;'>\r\n";
			foreach($this->SplitTitles as $k=>$v){
			   if($i==1) $revalue .= "<option value='".$this->Fields['phpurl']."/view.php?aid=$aid&pageno=$i'>{$i}��{$v}</option>\r\n";
		     else{
		     	 if($pageNo==$i) $revalue .= "<option value='".$this->Fields['phpurl']."/view.php?aid=$aid&pageno=$i' selected>{$i}��{$v}</option>\r\n";
		     	 else $revalue .= "<option value='".$this->Fields['phpurl']."/view.php?aid=$aid&pageno=$i'>{$i}��{$v}</option>\r\n";
		     }
		     $i++;
		  }
		  $revalue .= "</select>\r\n";
	  }
		return $revalue;
	}
	//-------------------------
	//��þ�̬ҳ��С����
	//-------------------------
	function GetPageTitlesST($styleName,$pageNo)
	{
		if($this->TotalPage==1){ return ""; }
		if(count($this->SplitTitles)==0){ return ""; }
		$i=1;
		if($styleName=='link')
		{
			$revalue = "";
		  foreach($this->SplitTitles as $k=>$v){
			   if($i==1) $revalue .= "<a href='".$this->NameFirst.".".$this->ShortName."'>$v</a> \r\n";
		     else{
		     	  if($pageNo==$i) $revalue .= " $v \r\n";
		        else  $revalue .= "<a href='".$this->NameFirst."_".$i.".".$this->ShortName."'>$v</a> \r\n";
		     }
		     $i++;
		  }
	  }else
	  {
		  $revalue = "<select id='dedepagetitles' onchange='location.href=this.options[this.selectedIndex].value;'>\r\n";
			foreach($this->SplitTitles as $k=>$v){
			   if($i==1) $revalue .= "<option value='".$this->NameFirst.".".$this->ShortName."'>{$i}��{$v}</option>\r\n";
		     else{
		     	  if($pageNo==$i) $revalue .= "<option value='".$this->NameFirst."_".$i.".".$this->ShortName."' selected>{$i}��{$v}</option>\r\n";
		     	  else $revalue .= "<option value='".$this->NameFirst."_".$i.".".$this->ShortName."'>{$i}��{$v}</option>\r\n";
		     }
		     $i++;
		  }
		  $revalue .= "</select>\r\n";
	  }
		return $revalue;
	}
	//----------------------------
  //��ָ���ؼ����滻������
  //----------------------------
  function ReplaceKeyword($kw,&$body)
  {
  	global $cfg_cmspath;
  	$maxkey = 5;
  	$kws = explode(" ",trim($kw));
  	$i=0;
  	foreach($kws as $k){
  		$k = trim($k);
  		if($k!=""){
  			if($i > $maxkey) break;
  			$myrow = $this->dsql->GetOne("select * from #@__keywords where keyword='$k' And rpurl<>'' ");
  			if(is_array($myrow)){
  				 $ka = "<a href='{$myrow['rpurl']}'><u>$k</u></a>";
  			   $body = str_replace($k,$ka,$body);
  		  }
  			$i++;
  		}
  	}
  	return $body;
  }
}//End Archives
?>