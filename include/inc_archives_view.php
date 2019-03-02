<?
require_once(dirname(__FILE__)."/../include/config_base.php");
require_once(dirname(__FILE__)."/../include/pub_db_mysql.php");
require_once(dirname(__FILE__)."/../include/inc_channel_unit.php");
require_once(dirname(__FILE__)."/../include/pub_dedetag.php");
require_once(dirname(__FILE__)."/../include/inc_typelink.php");
require_once(dirname(__FILE__)."/../include/inc_arcpart_view.php");
/******************************************************
//Copyright 2004-2006 by DedeCms.com itprato
//�������;����������ĵ�����ĵ�����HTML
//������ݵĴ���˳���ǣ�
//���캯��[��ʼ��(����ĵ���ص�fieldֵ)]->
//private  ParseFixedValues()[���channel��likeart��hotart�ȹ̶�ֵ�ı�ǵ�ֵ] ->
//private  ParseFields($pageNo,$ismake=1)[��ģ�����field��ǽ��д����������ҳ������]->
//private  ParseNotFields($tid,$ismake)[��ģ�����������ǽ��д���]->
//public MakeHtml()[����HTML] �� public Display()[��ʾ����]->
//public Close()[������Դ]
//ʹ��ʾ����
//$ac = new Archives(5);
//$ac->Display();
//$ac->Close();
******************************************************/
@set_time_limit(0);
class Archives
{
	var $TypeLink;
	var $ChannelUnit;
	var $dsql;
	var $ArcInfos;
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
	//-------------------------------
	//php5���캯��
	//-------------------------------
	function __construct($aid)
 	{
 		$this->IsError = false;
 		$this->dsql = new DedeSql(false);
 		$this->ArcID = $aid;
 		$query = "
 		Select #@__archives.*,#@__arctype.reID,#@__arctype.typedir from #@__archives 
 		left join #@__arctype on #@__arctype.ID=#@__archives.typeid 
 		where #@__archives.ID='$aid'
 		";
 		$row = $this->dsql->GetOne($query);
 		
 		if(!is_array($row)){ $this->IsError = true; return ""; }
 		
 		foreach($row as $k=>$v){
 			if(!ereg("[^0-9]",$k)) continue;
 			else $this->ArcInfos[$k] = $v;
 		}
 		
 		if($this->ArcInfos['channel']==0) $this->ArcInfos['channel']=1;
 		
 		$this->ChannelUnit = new ChannelUnit($this->ArcInfos['channel'],$aid);
 		$this->TypeLink = new TypeLink($this->ArcInfos['typeid']);
 		$this->dtp = new DedeTagParse();
 		$this->SplitPageField = $this->ChannelUnit->SplitPageField;
 		$this->SplitFields = "";
 		$this->TotalPage = 1;
 		$this->NameFirst = "";
 		$this->ShortName = "html";
 		$this->FixedValues = "";
 		$this->TempSource = "";
 		$this->PartView = new PartView($this->ArcInfos['typeid']);
 		if(empty($GLOBALS["pageno"])) $this->NowPage = 1;
 		else $this->NowPage = $GLOBALS["pageno"];
 		//������ֶ����ݴ���
 		//-------------------------------------
 		$this->ArcInfos['aid'] = $aid;
 		$this->ArcInfos['id'] = $aid;
 		$this->ArcInfos['phpurl'] = $GLOBALS['cfg_plus_dir'];
 		$this->ArcInfos['indexurl'] = $GLOBALS['cfg_indexurl']."/";
 		$this->ArcInfos['indexurl'] = ereg_replace("/{1,}","/",$this->ArcInfos['indexurl']);
 		$this->ArcInfos['indexname'] = $GLOBALS['cfg_indexname'];
 		$this->ArcInfos['templeturl'] = $GLOBALS['cfg_templets_dir'];
 		$this->ArcInfos['memberurl'] = $GLOBALS['cfg_member_dir'];
 		$this->ArcInfos['position'] = $this->TypeLink->GetPositionLink(true);
 		$this->ArcInfos['powerby'] = $GLOBALS['cfg_powerby'];
 		$this->ArcInfos['specurl'] = $GLOBALS['cfg_special'];
 		$this->ArcInfos['webname'] = $GLOBALS["cfg_webname"];
 		
 		if($this->ArcInfos['litpic']=="") $this->ArcInfos['litpic'] = $this->ArcInfos["phpurl"]."/img/dfpic.gif";
 		
 		//��ȡ���ӱ���Ϣ�����Ѹ��ӱ�����Ͼ������봦����뵽$this->ArcInfos�У��Է�����
 		//ģ������ {dede:field name='fieldname' /} ���ͳһ����
 		
 		if($this->ChannelUnit->ChannelInfos["addtable"]!=""){
 		  $row = $this->dsql->GetOne("select * from ".trim($this->ChannelUnit->ChannelInfos["addtable"])." where aid=$aid ");
 		  foreach($row as $k=>$v){
 		  	if(ereg("[A-Z]",$k)) $row[strtolower($k)] = $v;
 		  }
 		  foreach($this->ChannelUnit->ChannelFields as $k=>$arr)
 		  {
 		  	if(isset($row[$k])){
 		  		if($arr["rename"]!="") $nk = $arr["rename"];
 		  		else $nk = $k;
 		  		$this->ArcInfos[$nk] = $this->ChannelUnit->MakeField($k,$row[$k]);
 		  	} 
 		  }//End foreach
 		}
 		//��ɸ��ӱ���Ϣ��ȡ
 		unset($row);
 		
 		//����Ҫ��ҳ��ʾ���ֶ�
 		//---------------------------
 		if($this->SplitPageField!="" && isset($this->ArcInfos[$this->SplitPageField])){
 			$this->SplitFields = explode("#p#",$this->ArcInfos[$this->SplitPageField]);
 			$this->TotalPage = count($this->SplitFields);
 		}
 		//$this->ParseFixedValues();
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
  	global $cfg_basedir;
  	if($this->IsError) return "";
  	//����Ҫ�������ļ�����
  	//------------------------------------------------------
  	$filename = $this->TypeLink->GetFileNewName(
  	  $this->ArcID,$this->ArcInfos["typeid"],$this->ArcInfos["senddate"],
  	  $this->ArcInfos["title"],$this->ArcInfos["ismake"],
  	  $this->ArcInfos["arcrank"],"","",$this->ArcInfos["money"]
  	);
  	$filenames  = explode(".",$filename);
  	$this->ShortName = $filenames[count($filenames)-1];
  	if($this->ShortName=="") $this->ShortName = "html";
  	$fileFirst = eregi_replace("\.".$this->ShortName."$","",$filename);
  	$filenames  = explode("/",$filename);
  	$this->NameFirst = eregi_replace("\.".$this->ShortName."$","",$filenames[count($filenames)-1]);
  	if($this->NameFirst=="") $this->NameFirst = $this->arcID;
  	
  	//���������ò�����HTML������ֱ�ӷ�����ַ
  	//------------------------------------------------
  	if($this->ArcInfos['ismake']==-1||$this->ArcInfos['arcrank']!=0||
  	   $this->ArcInfos['typeid']==0||$this->ArcInfos['money']>0)
  	{
  		$this->Close();
  		return $filename;
  	}
  	
  	//ѭ������HTML�ļ�
  	//-------------------------------------------------
  	for($i=1;$i<=$this->TotalPage;$i++)
  	{
  	  if($i>1){ $truefilename = $cfg_basedir.$fileFirst."_".$i.".".$this->ShortName; }
  	  else{ $truefilename = $cfg_basedir.$filename; }
  	  $this->ParseDMFields($i,1);
  	  $this->dtp->SaveTo($truefilename);
    }
    $this->dsql->SetQuery("Update #@__archives set ismake=1 where ID='".$this->ArcID."'");
    $this->dsql->ExecuteNoneQuery();
    $this->Close();
  	return $filename;
  }
  //----------------------------
  //���ָ����ֵ���ֶ�
  //----------------------------
  function GetField($fname)
  {
  	if(isset($this->ArcInfos[$fname])) return $this->ArcInfos[$fname];
  	else return "";
  }
  //-----------------------------
  //���ģ���ļ�λ��
  //-----------------------------
  function GetTempletFile()
  {
 	  global $cfg_basedir,$cfg_templets_dir;
 	  $filetag = $this->TypeLink->TypeInfos["temparticle"];
 	  $cid = $this->ChannelUnit->ChannelInfos["nid"];
 	  $tid = $this->ArcInfos["typeid"];
 	  $filetag = str_replace("{cid}",$cid,$filetag);
 	  $filetag = str_replace("{tid}",$tid,$filetag);
 	  $tmpfile = $cfg_basedir.$cfg_templets_dir."/".$filetag;
 	  if(!file_exists($tmpfile)){
 	  	$tmpfile = $cfg_basedir.$cfg_templets_dir."/default/article_default.htm";
 	  }
 	  return $tmpfile;
  }
  //----------------------------
 	//��̬������
 	//----------------------------
 	function display()
 	{
 		if($this->IsError) return "";
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
 			foreach($this->dtp->CTags as $i=>$ctag){
 				$tagname = $ctag->GetName();
 				if($tagname=="arclist"||$tagname=="artlist"||$tagname=="likeart"||$tagname=="hotart"
 			  ||$tagname=="imglist"||$tagname=="imginfolist"||$tagname=="coolart"||$tagname=="specart")
 			  { 
 			  	$listtype = $ctag->GetAtt('type');
 			  	//�ض��������б�
 				  $channelid = $ctag->GetAtt("channelid");
 				  if($tagname=="imglist"||$tagname=="imginfolist"){ $listtype = "image"; }
 				  else if($tagname=="specart"){ $channelid = -1; }
 				  else if($tagname=="coolart"){ $listtype = "commend"; }
 				  else{ $listtype = $ctag->GetAtt('type'); }
 				   
 				  if($tagname=="likeart") $keywords = str_replace(" ",",",trim($this->ArcInfos['keywords']));
 				  else $keywords = $ctag->GetAtt('keyword');
 				  
 				  //����
 				  if($tagname=="hotart") $orderby = "click";
 				  else $orderby = $ctag->GetAtt('orderby');
 				  
 				  //����Ӧ�ı��ʹ�ò�ͬ��Ĭ��innertext
 				  if(trim($ctag->GetInnerText())!="") $innertext = $ctag->GetInnerText();
 				  else if($tagname=="imglist"){
 				  	$innertext = GetSysTemplets("part_imglist.htm");
 				  	$listtype = 'image';
 				  }
 				  else if($tagname=="imginfolist"){
 				  	$innertext = GetSysTemplets("part_imginfolist.htm");
 				  	$listtype = 'image';
 				  }
 				  else $innertext = GetSysTemplets("part_arclist.htm");
 				  
 				  //����titlelength
 				  if($ctag->GetAtt('titlelength')!="") $titlelen = $ctag->GetAtt('titlelength');
 				  else $titlelen = $ctag->GetAtt('titlelen');
 				
 				  //����infolength
 				  if($ctag->GetAtt('infolength')!="") $infolen = $ctag->GetAtt('infolength');
 				  else $infolen = $ctag->GetAtt('infolen');
 				    
 				  //��������
 				  if(trim($ctag->GetAtt('typeid'))==""){
 				    if($this->ArcInfos['reID']!=0 && $tagname=="likeart") $gid = $this->ArcInfos['reID'];
 					  else{
 					    $gid = $this->ArcInfos['typeid'];
 					    if($this->ArcInfos['typeid2']!=0) $gid = $gid.",".$this->ArcInfos['typeid2'];
 					  }
 					}else{ $gid = trim( $ctag->GetAtt('typeid') ); }
 						
 				  $this->dtp->Assign($i,
 				       $this->PartView->GetArcList(
 				         $gid,
 				         $ctag->GetAtt("row"),
 				         $ctag->GetAtt("col"),
 				         $titlelen,
 				         $infolen,
 				         $ctag->GetAtt("imgwidth"),
 				         $ctag->GetAtt("imgheight"),
 				         $listtype,
 				         $orderby,
 				         $keywords,
 				         $innertext,
 				         $ctag->GetAtt("tablewidth"),
 				         $this->ArcID,
 				         "",
 				         $channelid,
 				         $ctag->GetAtt("limit")
 				        )
 				  );
 			  }
 			  //�Զ�����
 			  //-----------------------
 			  else if($ctag->GetName()=="mytag")
 			  {
 				  $this->dtp->Assign($i,$this->PartView->GetMyTag(
 				        $this->ArcInfos['typeid'],
 				        $ctag->GetAtt("name"),
 				        $ctag->GetAtt("ismake")
 				     )
 				  );
 			  }
 				else if($ctag->GetName()=="channel")
 				{
 					if($ctag->GetAtt("line")!="") $nrow = trim($ctag->GetAtt("line"));
 					else $nrow = trim($ctag->GetAtt("row"));
 				  
 				  if($nrow=="") $nrow = 8;
 			
 					$this->dtp->Assign($i,$this->TypeLink->GetChannelList(
 					  $this->ArcInfos['typeid'],
 					  $this->ArcInfos['reID'],
 					  $nrow,
 					  $ctag->GetAtt("type"),
 					  $ctag->GetInnerText()
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
 		  isset($this->ArcInfos[$this->SplitPageField]))
 		{
 			$this->ArcInfos[$this->SplitPageField] = $this->SplitFields[$pageNo - 1];
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
               	 @$this->ArcInfos[$k] = GetDateTimeMk($this->ArcInfos[$k]);
               }
               foreach($dtp2->CTags as $tid=>$ctag)
               {
               	 if($ctag->GetName()=='name') $dtp2->Assign($tid,$fname);
               	 else if($ctag->GetName()=='value') @$dtp2->Assign($tid,$this->ArcInfos[$k]);
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
 		@$this->FixedValues = "";
 		@$this->ArcInfos = "";
 		@$this->dsql->Close();
 		@$this->ChannelUnit->Close();
 		@$this->TypeLink->Close();
 		@$this->PartView->Close();
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
}//End Archives
?>