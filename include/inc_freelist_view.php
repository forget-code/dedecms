<?
require_once(dirname(__FILE__)."/inc_arcpart_view.php");
/******************************************************
//Copyright 2004-2006 by DedeCms.com itprato
//�������;�Ƕ��ض������б�����HTML
******************************************************/
@set_time_limit(0);
class FreeList
{
	var $dsql;
	var $dtp;
	var $TypeID;
	var $TypeLink;
	var $PageNo;
	var $TotalPage;
	var $TotalResult;
	var $PageSize;
	var $ChannelUnit;
	var $Fields;
	var $PartView;
	var $FLInfos;
	var $ListObj;
	//-------------------------------
	//php5���캯��
	//-------------------------------
	function __construct($fid)
 	{
 		$this->FreeID = $fid;
 		$this->TypeLink = new TypeLink(0);
 		$this->dsql = new DedeSql(false);
 		$this->FLInfos = $this->dsql->GetOne("Select * From #@__freelist where aid='$fid' ");
 		$liststr = $this->FLInfos['listtag'];
 		//���������ﱣ����б�������Ϣ
 		$ndtp = new DedeTagParse();
 		$ndtp->SetNameSpace("dede","{","}");
 		$ndtp->LoadString($liststr);
 		$this->ListObj = $ndtp->GetTag('list');
 		$this->PageSize = $this->ListObj->GetAtt('pagesize');
 		if(empty($this->PageSize)) $this->PageSize = 30;
 		//ȫ��ģ�������
 		$this->dtp = new DedeTagParse();
 		$this->dtp->SetNameSpace("dede","{","}");
 
 		//����һЩȫ�ֲ�����ֵ
 		$this->Fields['aid'] = $this->FLInfos['aid'];
 		$this->Fields['title'] = $this->FLInfos['title'];
 		$this->Fields['position'] = $this->FLInfos['title'];
 		$this->Fields['keywords'] = $this->FLInfos['keyword'];
 		$this->Fields['description'] = $this->FLInfos['description'];
 		$channelid = $this->ListObj->GetAtt('channel');
 		if(!empty($channelid)){
 		   $this->Fields['channeltype'] = $channelid;
 		   $this->ChannelUnit = new ChannelUnit($channelid); 
 	  }else{
 	  	 $this->Fields['channeltype'] = 0;
 	  }
 		foreach($GLOBALS['PubFields'] as $k=>$v) $this->Fields[$k] = $v;
 		
 		$this->PartView = new PartView();
 		
 		$this->CountRecord();

  }
  //php4���캯��
 	//---------------------------
 	function ListView($fid){
 		$this->__construct($fid);
 	}
 	//---------------------------
 	//�ر������Դ
 	//---------------------------
 	function Close()
 	{
 		$this->dsql->Close();
 		$this->TypeLink->Close();
 		$this->PartView->Close();
 		if(is_object($this->ChannelUnit)) $this->ChannelUnit->Close();
 	}
 	//------------------
 	//ͳ���б���ļ�¼
 	//------------------
 	function CountRecord()
 	{
 		global $cfg_list_son;
 		//ͳ�����ݿ��¼
 		$this->TotalResult = -1;
 		if(isset($GLOBALS['TotalResult'])) $this->TotalResult = $GLOBALS['TotalResult'];
 		if(isset($GLOBALS['PageNo'])) $this->PageNo = $GLOBALS['PageNo'];
 		else $this->PageNo = 1;
 		
 		//�Ѿ����ܼ�¼��ֵ
 		if($this->TotalResult==-1)
 		{
 		  $addSql  = " arcrank > -1 ";
 		
 		  $typeid = $this->ListObj->GetAtt('typeid');
 		  $subday = $this->ListObj->GetAtt('subday');
 		  $listtype = $this->ListObj->GetAtt('type');
 		  $att = $this->ListObj->GetAtt('att');
 		  $channelid = $this->ListObj->GetAtt('channel');
 		  if(empty($channelid)) $channelid = 0;
 		  
 		  //�Ƿ�ָ����Ŀ����
 		  if(!empty($typeid)){
 		  	if($cfg_list_son=='��') $addSql .= " And (typeid='$typeid' or typeid2='$typeid') ";
 		    else $addSql .= " And (".$this->TypeLink->GetSunID($typeid,"#@__archives",$this->Fields['channeltype'])." Or #@__archives.typeid2='$typeid') ";
 		  }
 		  //�Զ�����������
 		  if($att!="") $orwhere .= "And arcatt='$att' ";
		
		  //�ĵ���Ƶ��ģ��
		  if($channelid>0 && !eregi("spec",$listtype)) $addSql .= " And channel = '$channelid' ";
		
		  //�Ƽ��ĵ� ������ͼ  ר���ĵ�
		  if(eregi("commend",$listtype)) $addSql .= " And iscommend > 10  ";
		  if(eregi("image",$listtype)) $addSql .= " And litpic <> ''  ";
		  if(eregi("spec",$listtype) || $channelid==-1) $addSql .= " And channel = -1  ";
 		  
 		  if(!empty($subday)){
 		  	 $starttime = time() - $subday;
 		  	 $addSql .= " And senddate > $starttime  ";
 		  }
 		  
 		  $keyword = $this->ListObj->GetAtt('keyword');
 		  if(!empty($keyword)) $addSql .= " And CONCAT(title,keywords) REGEXP '$keyword' ";
 		  
 		  $cquery = "Select count(*) as dd From #@__archives where $addSql";
 			$row = $this->dsql->GetOne($cquery);
 			if(is_array($row)) $this->TotalResult = $row['dd'];
 			else $this->TotalResult = 0;
 		}
    $this->TotalPage = ceil($this->TotalResult/$this->PageSize);
 	}
 	//----------------------------
 	//����ģ��
 	//--------------------------
 	function LoadTemplet(){
 		$tmpdir = $GLOBALS['cfg_basedir'].$GLOBALS['cfg_templets_dir'];
 		$tempfile = str_replace("{style}",$GLOBALS['cfg_df_style'],$this->FLInfos['templet']);
 		$tempfile = $tmpdir."/".$tempfile;
 		if(!file_exists($tempfile)){
 	  	 $tempfile = $tmpdir."/".$GLOBALS['cfg_df_style']."/list_free.htm";
 	  }
 		$this->dtp->LoadTemplate($tempfile);
 	}
 	//------------------
 	//�б���HTML
 	//------------------
 	function MakeHtml($startpage=1,$makepagesize=0)
 	{
 		$this->LoadTemplet();
 		$murl = "";
 		if(empty($startpage)) $startpage = 1;
 		$this->ParseTempletsFirst();
 		$totalpage = ceil($this->TotalResult/$this->PageSize);
 		if($totalpage==0) $totalpage = 1;
 		if($makepagesize>0) $endpage = $startpage+$makepagesize;
 		else $endpage = ($totalpage+1);
 		if($endpage>($totalpage+1)) $endpage = $totalpage;
 		$firstFile = '';
 		
 		for($this->PageNo=$startpage;$this->PageNo<$endpage;$this->PageNo++)
 		{
 		  $this->ParseDMFields($this->PageNo,1);
 	    //�ļ���
 	    $makeFile = $this->GetMakeFileRule();
 	    if(!ereg("^/",$makeFile)) $makeFile = "/".$makeFile;
 	    $makeFile = str_replace('{page}',$this->PageNo,$makeFile);
 	    $murl = $makeFile;
 	    $makeFile = $GLOBALS['cfg_basedir'].$makeFile;
 	    $makeFile = ereg_replace("/{1,}","/",$makeFile);
 	    if($this->PageNo==1) $firstFile = $makeFile;
 	    //�����ļ�
 	    $this->dtp->SaveTo($makeFile);
 	    echo "�ɹ�������<a href='$murl' target='_blank'>".ereg_replace("/{1,}","/",$murl)."</a><br/>";
 	  }
 	  if($this->FLInfos['nodefault']==0)
 	  {
 	  	  $murl = '/'.str_replace('{cmspath}',$GLOBALS['cfg_cmspath'],$this->FLInfos['listdir']);
 	  	  $murl .= '/'.$this->FLInfos['defaultpage'];
 	  	  $indexfile = $GLOBALS['cfg_basedir'].$murl;
 	  	  $murl = ereg_replace("/{1,}","/",$murl);
 	  	  echo "���ƣ�$firstFile Ϊ ".$this->FLInfos['defaultpage']." <br/>";
 	  	  copy($firstFile,$indexfile);
 	  }
 		$this->Close();
 		return $murl;
 	}
 	//------------------
 	//��ʾ�б�
 	//------------------
 	function Display()
 	{
 		$this->LoadTemplet();
 		$this->ParseTempletsFirst();
 		$this->ParseDMFields($this->PageNo,0);
 	  $this->Close();
 		$this->dtp->Display();
 	}
 	//------------------
 	//��ʾ����ģ��ҳ��
 	//------------------
 	function DisplayPartTemplets()
 	{
 		$nmfa = 0;
 		$tmpdir = $GLOBALS['cfg_basedir'].$GLOBALS['cfg_templets_dir'];
 		if($this->Fields['ispart']==1){
 			$tempfile = str_replace("{tid}",$this->FreeID,$this->Fields['tempindex']);
 		  $tempfile = str_replace("{cid}",$this->ChannelUnit->ChannelInfos['nid'],$tempfile);
 			$tempfile = $tmpdir."/".$tempfile;
 			if(!file_exists($tempfile)){
 	  	  $tempfile = $tmpdir."/".$GLOBALS['cfg_df_style']."/index_default.htm";
 	    }
 			$this->PartView->SetTemplet($tempfile);
 		}else if($this->Fields['ispart']==2){
 			$tempfile = str_replace("{tid}",$this->FreeID,$this->Fields['tempone']);
 		  $tempfile = str_replace("{cid}",$this->ChannelUnit->ChannelInfos['nid'],$tempfile);
 			if(is_file($tmpdir."/".$tempfile)) $this->PartView->SetTemplet($tmpdir."/".$tempfile);
 			else{ $this->PartView->SetTemplet("����û��ʹ��ģ��ĵ���ҳ��","string"); $nmfa = 1; }
 		}
	  CreateDir($this->Fields['typedir']);
 		$makeUrl = $this->GetMakeFileRule($this->Fields['ID'],"index",$this->Fields['typedir'],$this->Fields['defaultname'],$this->Fields['namerule2']);
 		$makeFile = $this->GetTruePath().$makeUrl;
	  if($nmfa==0) $this->PartView->Display();
 		else{
 			if(!file_exists($makeFile)) $this->PartView->Display();
 			else include($makeFile);
 		}
	  $this->Close();
 	}
 	//--------------------------------
 	//����ģ�壬�Թ̶��ı�ǽ��г�ʼ��ֵ
 	//--------------------------------
 	function ParseTempletsFirst()
 	{
 	  //����ģ��
 		//-------------------------
 		if(is_array($this->dtp->CTags))
 		{
 		 foreach($this->dtp->CTags as $tagid=>$ctag){
 			 $tagname = $ctag->GetName();
 			 if($tagname=="field"){ //����ָ���ֶ�
 					if(isset($this->Fields[$ctag->GetAtt('name')]))
 					  $this->dtp->Assign($tagid,$this->Fields[$ctag->GetAtt('name')]);
 					else
 					  $this->dtp->Assign($tagid,"");
 			 }
 			 else if($tagname=="onetype"||$tagname=="type"){
 				 $typeid = $ctag->GetAtt('typeid');
 				 if(empty($typeid)) $typeid = 0;
 				 $this->dtp->Assign($tagid,
 				   $this->PartView->GetOneType($typeid,$ctag->GetInnerText())
 				 );
 			 }else if($tagname=="channel"){ //�¼�Ƶ���б�
 				  $typeid = $ctag->GetAtt("typeid");
 				  $reid=0;
 				  $this->dtp->Assign($tagid,
 				      $this->TypeLink->GetChannelList(
 				          $typeid,$reid,$ctag->GetAtt("row"),
 				          $ctag->GetAtt("type"),$ctag->GetInnerText(),
 				          $ctag->GetAtt("col"),$ctag->GetAtt("tablewidth"),
 				          $ctag->GetAtt("currentstyle")
 				      )
 				  );
 			 }
 			 //���Źؼ���
 			 else if($tagname=="hotwords"){
 				 $this->dtp->Assign($tagid,
 				 GetHotKeywords($this->dsql,$ctag->GetAtt('num'),$ctag->GetAtt('subday'),$ctag->GetAtt('maxlength')));
 			 }
 			 //�Զ�����
 			 else if($tagname=="mytag"){
 				 $this->dtp->Assign($tagid,
 				   $this->PartView->GetMyTag($this->FreeID,$ctag->GetAtt("name"),$ctag->GetAtt("ismake"))
 				 );
 			 }
 			 //������
 			 else if($tagname=="myad"){
 				 $this->dtp->Assign($tagid,
 				   $this->PartView->GetMyAd($this->FreeID,$ctag->GetAtt("name"))
 				 );
 			 }
 			 //Ƶ���¼���Ŀ�ĵ��б�
 			 else if($tagname=="channelartlist"){
 				 //���ID
 				 $typeid = trim( $ctag->GetAtt('typeid') );
 				 $this->dtp->Assign($tagid,
 				     $this->PartView->GetChannelList($typeid,$ctag->GetAtt('col'),$ctag->GetAtt('tablewidth'),$ctag->GetInnerText())
 				 );
 			 }
 			 //ͶƱ
 			 else if($tagname=="vote"){
 				 $this->dtp->Assign($tagid,
				    $this->PartView->GetVote(
				      $ctag->GetAtt("id"),$ctag->GetAtt("lineheight"),
              $ctag->GetAtt("tablewidth"),$ctag->GetAtt("titlebgcolor"),
              $ctag->GetAtt("titlebackground"),$ctag->GetAtt("tablebgcolor")
            )
			   );
 			 }
 			 //��������
 			 //------------------
 			 else if($tagname=="friendlink"||$tagname=="flink")
 			 {
 				 $this->dtp->Assign($tagid,
 				    $this->PartView->GetFriendLink(
 				     $ctag->GetAtt("type"),$ctag->GetAtt("row"),$ctag->GetAtt("col"),
 				     $ctag->GetAtt("titlelen"),$ctag->GetAtt("tablestyle")
 				   )
 				 );
 			 }
 			 //վ������
 			 //---------------------
 			 else if($tagname=="mynews")
 			 {
 				 $this->dtp->Assign($tagid,
 				   $this->PartView->GetMyNews(
 				    $ctag->GetAtt("row"),$ctag->GetAtt("titlelen"),$ctag->GetInnerText()
 				   )
 				 );
 			 }
 			 //������̳����
 			 //----------------
 			 else if($tagname=="loop")
 			 {
 				 $this->dtp->Assign($tagid,
				   $this->PartView->GetTable(
					   $ctag->GetAtt("table"),$ctag->GetAtt("row"),
					   $ctag->GetAtt("sort"),$ctag->GetAtt("if"),$ctag->GetInnerText()
					 )
			   );
 			 }
 			 else if($tagname=="arclist"||$tagname=="artlist"||$tagname=="likeart"||$tagname=="hotart"
 			 ||$tagname=="imglist"||$tagname=="imginfolist"||$tagname=="coolart"||$tagname=="specart")
 			 { 
 			 	  //�ض��������б�
 				  $channelid = $ctag->GetAtt("channelid");
 				  if($tagname=="imglist"||$tagname=="imginfolist"){ $listtype = "image"; }
 				  else if($tagname=="specart"){ $channelid = -1; $listtype=""; }
 				  else if($tagname=="coolart"){ $listtype = "commend"; }
 				  else{ $listtype = $ctag->GetAtt('type'); }
 				  
 				  //����Ӧ�ı��ʹ�ò�ͬ��Ĭ��innertext
 				  if(trim($ctag->GetInnerText())!="") $innertext = $ctag->GetInnerText();
 				  else if($tagname=="imglist") $innertext = GetSysTemplets("part_imglist.htm");
 				  else if($tagname=="imginfolist") $innertext = GetSysTemplets("part_imginfolist.htm");
 				  else $innertext = GetSysTemplets("part_arclist.htm");
 				  
 				  if($tagname=="hotart") $orderby = "click";
 				  else $orderby = $ctag->GetAtt('orderby');
 				  
 				  //����titlelength
 				  if($ctag->GetAtt('titlelength')!="") $titlelen = $ctag->GetAtt('titlelength');
 				  else $titlelen = $ctag->GetAtt('titlelen');
 				
 				  //����infolength
 				  if($ctag->GetAtt('infolength')!="") $infolen = $ctag->GetAtt('infolength');
 				  else $infolen = $ctag->GetAtt('infolen');
 				  
 				  $typeid = trim($ctag->GetAtt("typeid"));
 				  
 				  $this->dtp->Assign($tagid,
 				      $this->PartView->GetArcList(
 				         $typeid,$ctag->GetAtt("row"),
 				         $ctag->GetAtt("col"),$titlelen,$infolen,
 				         $ctag->GetAtt("imgwidth"),$ctag->GetAtt("imgheight"),
 				         $listtype,$orderby,$ctag->GetAtt("keyword"),
 				         $innertext,$ctag->GetAtt("tablewidth"),
 				         0,"",$channelid,$ctag->GetAtt("limit"),
 				         $ctag->GetAtt("att"),$ctag->GetAtt("orderway"),
 				         $ctag->GetAtt("subday"),-1,$ctag->GetAtt("ismember")
 				      )
 				  );
 			  }
 			}//����ģ��ѭ��
 		}
 	}
 	//--------------------------------
 	//����ģ�壬��������ı䶯���и�ֵ
 	//--------------------------------
 	function ParseDMFields($PageNo,$ismake=1)
 	{
 		foreach($this->dtp->CTags as $tagid=>$ctag){
 			if($ctag->GetName()=="freelist"){
 				$limitstart = ($this->PageNo-1) * $this->PageSize;
 				$this->dtp->Assign($tagid,$this->GetList($limitstart,$ismake));
 			}
 			else if($ctag->GetName()=="pagelist"){
 				$list_len = trim($ctag->GetAtt("listsize"));
 				$ctag->GetAtt("listitem")=="" ? $listitem="info,index,pre,pageno,next,end,option" : $listitem=$ctag->GetAtt("listitem");
 				if($list_len=="") $list_len = 3;
 				if($ismake==0) $this->dtp->Assign($tagid,$this->GetPageListDM($list_len,$listitem));
 				else $this->dtp->Assign($tagid,$this->GetPageListST($list_len,$listitem));
 			}
 			else if($ctag->GetName()=="pageno"){
 				 $this->dtp->Assign($tagid,$PageNo);
 		  }
 	  }
  }
 	//----------------
 	//���Ҫ�������ļ����ƹ���
 	//----------------
 	function GetMakeFileRule()
  {
	  $okfile = '';
	  $namerule = $this->FLInfos['namerule'];
	  $listdir = $this->FLInfos['listdir'];
	  $listdir = str_replace('{cmspath}',$GLOBALS['cfg_cmspath'],$listdir);
	  $okfile = str_replace('{listid}',$this->FLInfos['aid'],$namerule);
	  $okfile = str_replace('{listdir}',$listdir,$okfile);
	  $okfile = str_replace("\\","/",$okfile);
	  $mdir = ereg_replace("/([^/]*)$","",$okfile);
	  if(!ereg("/",$mdir) && ereg("\.",$mdir)){
	  	 return $okfile;
	  }else{
	  	 CreateDir($mdir,'','');
	     return $okfile;
	  }
  }
 	//----------------------------------
  //���һ�����е��ĵ��б�
  //---------------------------------
  function GetList($limitstart,$ismake=1)
  {
    global $cfg_list_son;

		$col = $this->ListObj->GetAtt('col');
    if(empty($col)) $col = 1;
    $titlelen = $this->ListObj->GetAtt('titlelen');
    $infolen = $this->ListObj->GetAtt('infolen');
    $imgwidth = $this->ListObj->GetAtt('imgwidth');
    $imgheight = $this->ListObj->GetAtt('imgheight');
    $titlelen = AttDef($titlelen,60);
    $infolen = AttDef($infolen,250);
    $imgwidth = AttDef($imgwidth,80);
    $imgheight = AttDef($imgheight,80);
    $innertext = trim($this->ListObj->GetInnerText());
		if(empty($innertext)) $innertext = GetSysTemplets("list_fulllist.htm");
		
		$tablewidth=100;
		if($col=="") $col=1;
		$colWidth = ceil(100/$col); 
		$tablewidth = $tablewidth."%";
		$colWidth = $colWidth."%";
		
		//����ͬ����趨SQL����
		$orwhere = " arc.arcrank > -1 ";
		
		$typeid = $this->ListObj->GetAtt('typeid');
 		$subday = $this->ListObj->GetAtt('subday');
 		$listtype = $this->ListObj->GetAtt('type');
 		$att = $this->ListObj->GetAtt('att');
 		$channelid = $this->ListObj->GetAtt('channel');
 		if(empty($channelid)) $channelid = 0;
 		  
 		//�Ƿ�ָ����Ŀ����
 		if(!empty($typeid)){
 		  	if($cfg_list_son=='��') $orwhere .= " And (arc.typeid='$typeid' or arc.typeid2='$typeid') ";
 		    else $orwhere .= " And (".$this->TypeLink->GetSunID($typeid,"arc",$this->Fields['channeltype'])." Or arc.typeid2='$typeid') ";
 		}
 		//�Զ�����������
 		if($att!="") $orwhere .= "And arc.att='$att' ";
		
		//�ĵ���Ƶ��ģ��
		if($channelid>0 && !eregi("spec",$listtype)) $orwhere .= " And arc.channel = '$channelid' ";
		
		//�Ƽ��ĵ� ������ͼ  ר���ĵ�
		if(eregi("commend",$listtype)) $orwhere .= " And arc.iscommend > 10  ";
		if(eregi("image",$listtype)) $orwhere .= " And arc.litpic <> ''  ";
		if(eregi("spec",$listtype) || $channelid==-1) $orwhere .= " And arc.channel = -1  ";
 		  
 		if(!empty($subday)){
 		  $starttime = time() - $subday;
 		  $orwhere .= " And arc.senddate > $starttime  ";
 		}
 		  
 		$keyword = $this->ListObj->GetAtt('keyword');
 		if(!empty($keyword)) $orwhere .= " And CONCAT(arc.title,arc.keywords) REGEXP '$keyword' ";
		
		$orderby = $this->ListObj->GetAtt('orderby');
		$orderWay = $this->ListObj->GetAtt('orderway');
		//����ʽ
		$ordersql = "";
		if($orderby=="senddate") $ordersql=" order by arc.senddate $orderWay";
		else if($orderby=="pubdate") $ordersql=" order by arc.pubdate $orderWay";
    else if($orderby=="id") $ordersql="  order by arc.ID $orderWay";
    else if($orderby=="hot"||$orderby=="click") $ordersql = " order by arc.click $orderWay";
		else if($orderby=="lastpost") $ordersql = "  order by arc.lastpost $orderWay";
    else if($orderby=="postnum") $ordersql = "  order by arc.postnum $orderWay";
    else if($orderby=="rand") $ordersql = "  order by rand()";
		else $ordersql=" order by arc.sortrank $orderWay";
		
		//��ø��ӱ�������Ϣ
		//-----------------------------
		$addField = "";
		$addJoin = "";
		if(is_object($this->ChannelUnit)){
		  $addtable  = $this->ChannelUnit->ChannelInfos['addtable'];
		  if($addtable!=""){
			  $addJoin = " left join $addtable on arc.ID = ".$addtable.".aid ";
			  $addField = "";
			  $fields = explode(",",$this->ChannelUnit->ChannelInfos['listadd']);
			  foreach($fields as $k=>$v){ $nfields[$v] = $k; }
			  foreach($this->ChannelUnit->ChannelFields as $k=>$arr){
				  if(isset($nfields[$k])){
				     if($arr['rename']!="") $addField .= ",".$addtable.".".$k." as ".$arr['rename'];
				     else $addField .= ",".$addtable.".".$k;
				  }
			 }
		  }
		}
		//
		//----------------------------
		$query = "Select arc.ID,arc.title,arc.iscommend,arc.color,
		arc.typeid,arc.ismake,arc.money,arc.description,arc.shorttitle,
		arc.memberid,arc.writer,arc.postnum,arc.lastpost,
		arc.pubdate,arc.senddate,arc.arcrank,arc.click,arc.litpic,
		tp.typedir,tp.typename,tp.isdefault,tp.defaultname,
		tp.namerule,tp.namerule2,tp.ispart,tp.moresite,tp.siteurl 
		$addField
		from #@__archives arc 
		left join #@__arctype tp on arc.typeid=tp.ID
		$addJoin
		where $orwhere $ordersql limit $limitstart,".$this->PageSize;
		$this->dsql->SetQuery($query);
		$this->dsql->Execute("al");
    $artlist = "";
    if($col>1) $artlist = "<table width='$tablewidth' border='0' cellspacing='0' cellpadding='0'>\r\n";
    $indtp = new DedeTagParse();
 		$indtp->SetNameSpace("field","[","]");
    $indtp->LoadSource($innertext);
    $GLOBALS['autoindex'] = 0;
    for($i=0;$i<$this->PageSize;$i++)
		{
       if($col>1) $artlist .= "<tr>\r\n";
       for($j=0;$j<$col;$j++)
			 {
         if($col>1) $artlist .= "<td width='$colWidth'>\r\n";
         if($row = $this->dsql->GetArray("al"))
         {
           $GLOBALS['autoindex']++;
           //����һЩ�����ֶ�                        
           $row['id'] =  $row['ID'];
           $row['arcurl'] = $this->GetArcUrl($row['id'],$row['typeid'],$row['senddate'],$row['title'],$row['ismake'],$row['arcrank'],$row['namerule'],$row['typedir'],$row['money']);                             
           $row['typeurl'] = $this->GetListUrl($row['typeid'],$row['typedir'],$row['isdefault'],$row['defaultname'],$row['ispart'],$row['namerule2'],"abc");
          
           if($ismake==0 && $GLOBALS['cfg_multi_site']=='��'){
           	 if($row["siteurl"]=="") $row["siteurl"] = $GLOBALS['cfg_mainsite'];
           	 if(!eregi("^http://",$row['picname'])){
           	 	  $row['litpic'] = $row['siteurl'].$row['litpic'];
           	 	  $row['picname'] = $row['litpic'];
           	 }
           }
           
           $row['description'] = cnw_left($row['description'],$infolen);
           if($row['litpic']=="") $row['litpic'] = $GLOBALS['cfg_plus_dir']."/img/dfpic.gif";
           $row['picname'] = $row['litpic']; 
           $row['info'] = $row['description'];
           $row['filename'] = $row['arcurl'];
           $row['stime'] = GetDateMK($row['pubdate']);
           $row['textlink'] = "<a href='".$row['filename']."' title='".str_replace("'","",$row['title'])."'>".$row['title']."</a>";
           $row['typelink'] = "<a href='".$row['typeurl']."'>[".$row['typename']."]</a>";
           $row['imglink'] = "<a href='".$row['filename']."'><img src='".$row['picname']."' border='0' width='$imgwidth' height='$imgheight' alt='".str_replace("'","",$row['title'])."'></a>";
           $row['image'] = "<img src='".$row['picname']."' border='0' width='$imgwidth' height='$imgheight' alt='".str_replace("'","",$row['title'])."'>";
           $row['phpurl'] = $GLOBALS['cfg_plus_dir'];
           $row['plusurl'] = $GLOBALS['cfg_plus_dir'];
 		       $row['templeturl'] = $GLOBALS['cfg_templets_dir'];
 		       $row['memberurl'] = $GLOBALS['cfg_member_dir'];
 		       $row['title'] = cn_substr($row['title'],$titlelen);
           if($row['color']!="") $row['title'] = "<font color='".$row['color']."'>".$row['title']."</font>";
           if($row['iscommend']==5||$row['iscommend']==16) $row['title'] = "<b>".$row['title']."</b>";
           //���븽�ӱ��������
           if(is_object($this->ChannelUnit)){
              foreach($row as $k=>$v){
 		  	         if(ereg("[A-Z]",$k)) $row[strtolower($k)] = $v;
 		          }
              foreach($this->ChannelUnit->ChannelFields as $k=>$arr){
 		  	         if(isset($row[$k])) $row[$k] = $this->ChannelUnit->MakeField($k,$row[$k]);
 		  	      }
 		  	   }
           //---------------------------
           //����������¼
           //-------------------------
           if(is_array($indtp->CTags)){
       	      foreach($indtp->CTags as $k=>$ctag){
       		 	    $_f = $ctag->GetName();
       		 	    if(isset($row[$_f])) $indtp->Assign($k,$row[$_f]);
       		 	    else $indtp->Assign($k,"");
       	     }
           }
           $artlist .= $indtp->GetResult();
         }//if hasRow
         else{
         	 $artlist .= "";
         }
         if($col>1) $artlist .= "	</td>\r\n";
       }//Loop Col
       if($col>1) $i += $col - 1;
       if($col>1) $artlist .= "	</tr>\r\n";
     }//Loop Line
     if($col>1) $artlist .= "</table>\r\n";
     $this->dsql->FreeResult("al");
     return $artlist;
  }
  //---------------------------------
  //��ȡ��̬�ķ�ҳ�б�
  //---------------------------------
	function GetPageListST($list_len,$listitem="info,index,end,pre,next,pageno")
	{
		$prepage="";
		$nextpage="";
		$prepagenum = $this->PageNo-1;
		$nextpagenum = $this->PageNo+1;
		if($list_len==""||ereg("[^0-9]",$list_len)) $list_len=3;
		$totalpage = ceil($this->TotalResult/$this->PageSize);
		if($totalpage<=1 && $this->TotalResult>0) return "��1ҳ/".$this->TotalResult."����¼"; 
		if($this->TotalResult == 0) return "��0ҳ/".$this->TotalResult."����¼"; 
		$maininfo = " ��{$totalpage}ҳ/".$this->TotalResult."����¼ ";
		$purl = $this->GetCurUrl();
		
		$tnamerule = $this->GetMakeFileRule();
		$tnamerule = ereg_replace('^(.*)/','',$tnamerule);
		//�����һҳ����ҳ������
		if($this->PageNo != 1){
			$prepage.="<a href='".str_replace("{page}",$prepagenum,$tnamerule)."'>��һҳ</a>\r\n";
			$indexpage="<a href='".str_replace("{page}",1,$tnamerule)."'>��ҳ</a>\r\n";
		}else{ $indexpage="��ҳ\r\n"; }	
		//��һҳ,δҳ������
		if($this->PageNo!=$totalpage && $totalpage>1){
			$nextpage.="<a href='".str_replace("{page}",$nextpagenum,$tnamerule)."'>��һҳ</a>\r\n";
			$endpage="<a href='".str_replace("{page}",$totalpage,$tnamerule)."'>ĩҳ</a>\r\n";
		}else{
			$endpage="ĩҳ\r\n";
		}
		//option����
		$optionlen = strlen($totalpage);
		$optionlen = $optionlen*20+18;
		$optionlist = "<select name='sldd' style='width:$optionlen' onchange='location.href=this.options[this.selectedIndex].value;'>\r\n";
		for($mjj=1;$mjj<=$totalpage;$mjj++){
			if($mjj==$this->PageNo) $optionlist .= "<option value='".str_replace("{page}",$mjj,$tnamerule)."' selected>$mjj</option>\r\n";
		  else $optionlist .= "<option value='".str_replace("{page}",$mjj,$tnamerule)."'>$mjj</option>\r\n";
		}
		$optionlist .= "</select>";
		//�����������
		$listdd="";
		$total_list = $list_len * 2 + 1;
		if($this->PageNo >= $total_list) {
      $j = $this->PageNo-$list_len;
      $total_list = $this->PageNo+$list_len;
      if($total_list>$totalpage) $total_list=$totalpage;
		}	
		else{ 
   		$j=1;
   		if($total_list>$totalpage) $total_list=$totalpage;
		}
		for($j;$j<=$total_list;$j++){
   		if($j==$this->PageNo) $listdd.= "$j\r\n";
   		else $listdd.="<a href='".str_replace("{page}",$j,$tnamerule)."'>[".$j."]</a>\r\n";
		}
		$plist = "";
		if(eregi('info',$listitem)) $plist .= $maininfo.' ';
		if(eregi('index',$listitem)) $plist .= $indexpage.' ';
		if(eregi('pre',$listitem)) $plist .= $prepage.' ';
		if(eregi('pageno',$listitem)) $plist .= $listdd.' ';
		if(eregi('next',$listitem)) $plist .= $nextpage.' ';
		if(eregi('end',$listitem)) $plist .= $endpage.' ';
		if(eregi('option',$listitem)) $plist .= $optionlist;
		return $plist;
	}
  //---------------------------------
  //��ȡ��̬�ķ�ҳ�б�
  //---------------------------------
	function GetPageListDM($list_len,$listitem="index,end,pre,next,pageno")
	{
		$prepage="";
		$nextpage="";
		$prepagenum = $this->PageNo-1;
		$nextpagenum = $this->PageNo+1;
		if($list_len==""||ereg("[^0-9]",$list_len)) $list_len=3;
		$totalpage = ceil($this->TotalResult/$this->PageSize);
		if($totalpage<=1 && $this->TotalResult>0) return "��1ҳ/".$this->TotalResult."����¼"; 
		if($this->TotalResult == 0) return "��0ҳ/".$this->TotalResult."����¼";
		$maininfo = "<td style='padding-right:6px'>��{$totalpage}ҳ/".$this->TotalResult."����¼</td>";
		
		$purl = $this->GetCurUrl();
		$geturl = "lid=".$this->FreeID."&TotalResult=".$this->TotalResult."&";
		$hidenform = "<input type='hidden' name='lid' value='".$this->FreeID."'>\r\n";
		$hidenform .= "<input type='hidden' name='TotalResult' value='".$this->TotalResult."'>\r\n";
		
		$purl .= "?".$geturl;
		
		//�����һҳ����һҳ������
		if($this->PageNo != 1){
			$prepage.="<td width='50'><a href='".$purl."PageNo=$prepagenum'>��һҳ</a></td>\r\n";
			$indexpage="<td width='30'><a href='".$purl."PageNo=1'>��ҳ</a></td>\r\n";
		}
		else{
			$indexpage="<td width='30'>��ҳ</td>\r\n";
		}	
		
		if($this->PageNo!=$totalpage && $totalpage>1){
			$nextpage.="<td width='50'><a href='".$purl."PageNo=$nextpagenum'>��һҳ</a></td>\r\n";
			$endpage="<td width='30'><a href='".$purl."PageNo=$totalpage'>ĩҳ</a></td>\r\n";
		}
		else{
			$endpage="<td width='30'>ĩҳ</td>\r\n";
		}
		//�����������
		$listdd="";
		$total_list = $list_len * 2 + 1;
		if($this->PageNo >= $total_list) {
    		$j = $this->PageNo-$list_len;
    		$total_list = $this->PageNo+$list_len;
    		if($total_list>$totalpage) $total_list=$totalpage;
		}else{ 
   			$j=1;
   			if($total_list>$totalpage) $total_list=$totalpage;
		}
		for($j;$j<=$total_list;$j++){
   		if($j==$this->PageNo) $listdd.= "<td>$j&nbsp;</td>\r\n";
   		else $listdd.="<td><a href='".$purl."PageNo=$j'>[".$j."]</a>&nbsp;</td>\r\n";
		}
		$plist  =  "<table border='0' cellpadding='0' cellspacing='0'>\r\n";
		$plist .= "<tr align='center' style='font-size:10pt'>\r\n";
		$plist .= "<form name='pagelist' action='".$this->GetCurUrl()."'>$hidenform";
		$plist .= $maininfo.$indexpage.$prepage.$listdd.$nextpage.$endpage;
		if($totalpage>$total_list){
			$plist.="<td width='36'><input type='text' name='PageNo' style='width:30;height:18' value='".$this->PageNo."'></td>\r\n";
			$plist.="<td width='30'><input type='submit' name='plistgo' value='GO' style='width:24;height:18;font-size:9pt'></td>\r\n";
		}
		$plist .= "</form>\r\n</tr>\r\n</table>\r\n";
		return $plist;
	}
 	//--------------------------
 	//���һ��ָ����Ƶ��������
 	//--------------------------
 	function GetListUrl($typeid,$typedir,$isdefault,$defaultname,$ispart,$namerule2,$siteurl=""){
  	return GetTypeUrl($typeid,MfTypedir($typedir),$isdefault,$defaultname,$ispart,$namerule2,$siteurl);
  }
 	//--------------------------
 	//���һ��ָ������������
 	//--------------------------
 	function GetArcUrl($aid,$typeid,$timetag,$title,$ismake=0,$rank=0,$namerule="",$artdir="",$money=0){
  	return GetFileUrl($aid,$typeid,$timetag,$title,$ismake,$rank,$namerule,$artdir,$money);
  }
  //---------------
  //��õ�ǰ��ҳ���ļ���url
  //----------------
  function GetCurUrl()
	{
		if(!empty($_SERVER["REQUEST_URI"])){
			$nowurl = $_SERVER["REQUEST_URI"];
			$nowurls = explode("?",$nowurl);
			$nowurl = $nowurls[0];
		}else{ $nowurl = $_SERVER["PHP_SELF"]; }
		return $nowurl;
	}
}//End Class
?>