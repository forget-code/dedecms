<?
require_once(dirname(__FILE__)."/inc_arcpart_view.php");
/******************************************************
//Copyright 2004-2006 by DedeCms.com itprato
//�������;�������������ר���б���ר���б�����HTML
******************************************************/
@set_time_limit(0);
class SpecView
{
	var $dsql;
	var $dtp;
	var $dtp2;
	var $TypeID;
	var $TypeLink;
	var $PageNo;
	var $TotalPage;
	var $TotalResult;
	var $PageSize;
	var $ChannelUnit;
	var $ListType;
	var $TempInfos;
	var $Fields;
	var $PartView;
	var $StartTime;
	//-------------------------------
	//php5���캯��
	//-------------------------------
	function __construct($starttime=0)
 	{
 		$this->TypeID = 0;
 		$this->dsql = new DedeSql(false);
 		$this->dtp = new DedeTagParse();
 		$this->dtp->SetNameSpace("dede","{","}");
 		$this->dtp2 = new DedeTagParse();
 		$this->dtp2->SetNameSpace("field","[","]");
 		$this->TypeLink = new TypeLink(0);
 		$this->ChannelUnit = new ChannelUnit(-1);
 		//����һЩȫ�ֲ�����ֵ
 		foreach($GLOBALS['PubFields'] as $k=>$v) $this->Fields[$k] = $v;
 		
 		if($starttime==0) $this->StartTime = 0;
 		else{
 			$this->StartTime = GetMkTime($starttime);
 		}
 		
 		$this->PartView = new PartView();

 		$this->CountRecord();
 		$tempfile = $GLOBALS['cfg_basedir'].$GLOBALS['cfg_templets_dir']."/".$GLOBALS['cfg_df_style']."/list_spec.htm";
 		if(!file_exists($tempfile)||!is_file($tempfile)){
 			 echo "ģ���ļ���'".$tempfile."' �����ڣ��޷������ĵ���";
 			 exit();
 		 }
 		 $this->dtp->LoadTemplate($tempfile);
 		 $this->TempInfos['tags'] = $this->dtp->CTags;
 		 $this->TempInfos['source'] = $this->dtp->SourceString;
 		 $ctag = $this->dtp->GetTag("page");
 		 if(!is_object($ctag)) $this->PageSize = 20;
 		 else{
 		    if($ctag->GetAtt("pagesize")!="") $this->PageSize = $ctag->GetAtt("pagesize");
        else $this->PageSize = 20;
     }
     $this->TotalPage = ceil($this->TotalResult/$this->PageSize);
  }
  //php4���캯��
 	//---------------------------
 	function SpecView($starttime=0){
 		$this->__construct($starttime);
 	}
 	//---------------------------
 	//�ر������Դ
 	//---------------------------
 	function Close()
 	{
 		$this->dsql->Close();
 		$this->TypeLink->Close();
 		$this->ChannelUnit->Close();
 	}
 	//------------------
 	//ͳ���б���ļ�¼
 	//------------------
 	function CountRecord()
 	{
 		$this->TotalResult = -1;
 		
 		if(isset($GLOBALS['TotalResult'])) $this->TotalResult = $GLOBALS['TotalResult'];
 		
 		if(isset($GLOBALS['PageNo'])) $this->PageNo = $GLOBALS['PageNo'];
 		else $this->PageNo = 1;
 		
 		if($this->TotalResult==-1)
 		{
 		  if($this->StartTime>0) $timesql = " And #@__archives.senddate>'".$this->StartTime."'";
 		  else $timesql = "";
 			$row = $this->dsql->GetOne("Select count(*) as dd From #@__archives where #@__archives.arcrank > -1 And channel=-1 $timesql");
 			if(is_array($row)) $this->TotalResult = $row['dd'];
 			else $this->TotalResult = 0;
 		}
 	}
 	//------------------
 	//��ʾ�б�
 	//------------------
 	function Display()
 	{
 		if($this->TypeLink->TypeInfos['ispart']==1
 		   ||$this->TypeLink->TypeInfos['ispart']==2)
 		{
 			$this->DisplayPartTemplets();
 		}
 		$this->ParseTempletsFirst();
 		foreach($this->dtp->CTags as $tagid=>$ctag){
 			if($ctag->GetName()=="list"){
 				$limitstart = ($this->PageNo-1) * $this->PageSize;
 				$row = $this->PageSize;
 				if(trim($ctag->GetInnerText())==""){ $InnerText = GetSysTemplets("list_fulllist.htm"); }
 				else{ $InnerText = trim($ctag->GetInnerText()); }
 				$this->dtp->Assign($tagid,
 				      $this->GetArcList($limitstart,$row,
 				      $ctag->GetAtt("col"),
 				      $ctag->GetAtt("titlelen"),
 				      $ctag->GetAtt("infolen"),
 				      $ctag->GetAtt("imgwidth"),
 				      $ctag->GetAtt("imgheight"),
 				      $ctag->GetAtt("listtype"),
 				      $ctag->GetAtt("orderby"),
 				      $InnerText,
 				      $ctag->GetAtt("tablewidth"))
 				);
 			}
 			else if($ctag->GetName()=="pagelist"){
 				$list_len = trim($ctag->GetAtt("listsize"));
 				if($list_len=="") $list_len = 3;
 				$this->dtp->Assign($tagid,$this->GetPageListDM($list_len));
 			}
 	  }
 	  $this->Close();
 		$this->dtp->Display();
 	}
 	//------------------
 	//��ʼ�����б�
 	//------------------
 	function MakeHtml()
 	{
 		//�������̶�ֵ�ı�Ǹ�ֵ
 		$this->ParseTempletsFirst();
 		$totalpage = ceil($this->TotalResult/$this->PageSize);
 		if($totalpage==0) $totalpage = 1;
 		CreateDir($GLOBALS['cfg_special']);
 		$murl = "";
 		for($this->PageNo=1;$this->PageNo<=$totalpage;$this->PageNo++)
 		{
 		  foreach($this->dtp->CTags as $tagid=>$ctag){
 			  if($ctag->GetName()=="list"){
 				  $limitstart = ($this->PageNo-1) * $this->PageSize;
 				  $row = $this->PageSize;
 				  if(trim($ctag->GetInnerText())==""){ $InnerText = GetSysTemplets("spec_list.htm"); }
 				  else{ $InnerText = trim($ctag->GetInnerText()); }
 				  $this->dtp->Assign($tagid,
 				      $this->GetArcList($limitstart,$row,
 				      $ctag->GetAtt("col"),
 				      $ctag->GetAtt("titlelen"),
 				      $ctag->GetAtt("infolen"),
 				      $ctag->GetAtt("imgwidth"),
 				      $ctag->GetAtt("imgheight"),
 				      "spec",
 				      $ctag->GetAtt("orderby"),
 				      $InnerText,
 				      $ctag->GetAtt("tablewidth"))
 				  );
 			  }
 			  else if($ctag->GetName()=="pagelist"){
 				  $list_len = trim($ctag->GetAtt("listsize"));
 				  if($list_len=="") $list_len = 3;
 				  $this->dtp->Assign($tagid,$this->GetPageListST($list_len));
 			  }
 	    }//End foreach
 	    $makeFile = $GLOBALS['cfg_special']."/spec_".$this->PageNo.$GLOBALS['art_shortname'];
 	    $murl = $makeFile;
 	    $makeFile = $GLOBALS['cfg_basedir'].$makeFile;
 	    $this->dtp->SaveTo($makeFile);
 	    echo "�ɹ�������<a href='$murl' target='_blank'>$murl</a><br/>";
 	  }
 		$this->Close();
 		return $murl;
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
 			 if($tagname=="field") //����ָ���ֶ�
 			 {
 					if(isset($this->Fields[$ctag->GetAtt('name')]))
 					  $this->dtp->Assign($tagid,$this->Fields[$ctag->GetAtt('name')]);
 					else
 					  $this->dtp->Assign($tagid,"");
 			 }
 			 //�Զ�����
 			 //-----------------------
 			 else if($tagname=="mytag")
 			 {
 				  $this->dtp->Assign($tagid,$this->PartView->GetMyTag(
 				        $ctag->GetAtt("typeid"),
 				        $ctag->GetAtt("name"),
 				        $ctag->GetAtt("ismake")
 				     )
 				  );
 			 }
 			 else if($tagname=="onetype"||$tagname=="type")
 			 {
 				 $this->dtp->Assign($tagid,
 				   $this->GetOneType($ctag->GetAtt("typeid"),$ctag->GetInnerText())
 				 );
 			 }
 			 //�����
 			 //-----------------------
 			 else if($tagname=="myad")
 			 {
 				  $this->dtp->Assign($tagid,$this->PartView->GetMyAd(
 				        $ctag->GetAtt("typeid"),
 				        $ctag->GetAtt("name")
 				     )
 				  );
 			 }
 			 //���Źؼ���
 			 else if($tagname=="hotwords"){
 				 $this->dtp->Assign($tagid,
 				 GetHotKeywords($this->dsql,$ctag->GetAtt('num'),$ctag->GetAtt('subday'),$ctag->GetAtt('maxlength')));
 			 }
 			 else if($tagname=="channel")//�¼�Ƶ���б�
 			 {
 				  $this->dtp->Assign($tagid,
 				      $this->TypeLink->GetChannelList(
 				          $ctag->GetAtt("typeid"),
 				          0,
 				          $ctag->GetAtt("row"),
 				          $ctag->GetAtt("type"),
 				          $ctag->GetInnerText(),
 				          $ctag->GetAtt("col"),
 				          $ctag->GetAtt("tablewidth"),
 				          $ctag->GetAtt("currentstyle")
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
 				  
 				  //����
 				  if($ctag->GetAtt('sort')!="") $orderby = $ctag->GetAtt('sort');
 				  else if($tagname=="hotart") $orderby = "click";
 				  else $orderby = $ctag->GetAtt('orderby');
 				  
 				  //����Ӧ�ı��ʹ�ò�ͬ��Ĭ��innertext
 				  if(trim($ctag->GetInnerText())!="") $innertext = $ctag->GetInnerText();
 				  else if($tagname=="imglist") $innertext = GetSysTemplets("part_imglist.htm");
 				  else if($tagname=="imginfolist") $innertext = GetSysTemplets("part_imginfolist.htm");
 				  else $innertext = GetSysTemplets("part_arclist.htm");
 				  
 				  //����titlelength
 				  if($ctag->GetAtt('titlelength')!="") $titlelen = $ctag->GetAtt('titlelength');
 				  else $titlelen = $ctag->GetAtt('titlelen');
 				
 				  //����infolength
 				  if($ctag->GetAtt('infolength')!="") $infolen = $ctag->GetAtt('infolength');
 				  else $infolen = $ctag->GetAtt('infolen');
 				  
 				  $this->dtp->Assign($tagid,
 				      $this->PartView->GetArcList(
 				         $ctag->GetAtt("typeid"),
 				         $ctag->GetAtt("row"),
 				         $ctag->GetAtt("col"),
 				         $titlelen,
 				         $infolen,
 				         $ctag->GetAtt("imgwidth"),
 				         $ctag->GetAtt("imgheight"),
 				         $listtype,
 				         $orderby,
 				         $ctag->GetAtt("keyword"),
 				         $innertext,
 				         $ctag->GetAtt("tablewidth"),
 				         0,
 				         "",
 				         $channelid,
 				         $ctag->GetAtt("limit"),
 				         $ctag->GetAtt("att")
 				      )
 				  );
 			  }//End if tagname
 			}//����ģ��ѭ��
 		}
 	}
 	//----------------------------------
  //��ȡ�����б�
  //---------------------------------
  function GetArcList($limitstart=0,$row=10,$col=1,$titlelen=30,$infolen=250,
  $imgwidth=120,$imgheight=90,$listtype="all",$orderby="default",$innertext="",$tablewidth="100")
  {
    $typeid=$this->TypeID;
		if($row=="") $row = 10;
		if($limitstart=="") $limitstart = 0;
		if($titlelen=="") $titlelen = 30;
		if($infolen=="") $infolen = 250;
    if($imgwidth=="") $imgwidth = 120;
    if($imgheight=="") $imgheight = 120;
    if($listtype=="") $listtype = "all";
		if($orderby=="") $orderby="default";
		else $orderby=strtolower($orderby);
		$tablewidth = str_replace("%","",$tablewidth);
		if($tablewidth=="") $tablewidth=100;
		if($col=="") $col=1;
		$colWidth = ceil(100/$col); 
		$tablewidth = $tablewidth."%";
		$colWidth = $colWidth."%";
		$innertext = trim($innertext);
		if($innertext=="") $innertext = GetSysTemplets("spec_list.htm");
		//����ͬ����趨SQL����
		$orwhere = " #@__archives.arcrank > -1 And #@__archives.channel = -1 ";
		if($this->StartTime>0) $orwhere .= " And #@__archives.senddate>'".$this->StartTime."'";
		
		//����ʽ
		$ordersql = "";
		if($orderby=="senddate") $ordersql=" order by #@__archives.senddate desc";
		else if($orderby=="pubdate") $ordersql=" order by #@__archives.pubdate desc";
    else if($orderby=="id") $ordersql="  order by #@__archives.ID desc";
		else $ordersql=" order by #@__archives.sortrank desc";
		//
		//----------------------------
		$query = "Select #@__archives.ID,#@__archives.title,#@__archives.typeid,#@__archives.ismake,
		#@__archives.description,#@__archives.pubdate,#@__archives.senddate,#@__archives.arcrank,
		#@__archives.click,#@__archives.postnum,#@__archives.lastpost,
		#@__archives.litpic,#@__arctype.typedir,#@__arctype.typename,#@__arctype.isdefault,
		#@__arctype.defaultname,#@__arctype.namerule,#@__arctype.namerule2,#@__arctype.ispart,
		#@__arctype.moresite,#@__arctype.siteurl
		from #@__archives 
		left join #@__arctype on #@__archives.typeid=#@__arctype.ID
		where $orwhere $ordersql limit $limitstart,$row";
		$this->dsql->SetQuery($query);
		$this->dsql->Execute("al");
    $artlist = "";
    if($col>1) $artlist = "<table width='$tablewidth' border='0' cellspacing='0' cellpadding='0'>\r\n";
    $this->dtp2->LoadSource($innertext);
    for($i=0;$i<$row;$i++)
		{
       if($col>1) $artlist .= "<tr>\r\n";
       for($j=0;$j<$col;$j++)
			 {
         if($col>1) $artlist .= "<td width='$colWidth'>\r\n";
         if($row = $this->dsql->GetArray("al"))
         {
           //����һЩ�����ֶ�
           $row["description"] = cnw_left($row["description"],$infolen);
           $row["title"] = cnw_left($row["title"],$titlelen);
           $row["id"] =  $row["ID"];
           if($row["litpic"]=="") $row["litpic"] = $GLOBALS["cfg_plus_dir"]."/img/dfpic.gif";
           $row["picname"] = $row["litpic"];
           $row["arcurl"] = GetFileUrl($row["ID"],$row["typeid"],$row["senddate"],$row["title"],
                        $row["ismake"],$row["arcrank"],$row["namerule"],$row["typedir"],$row["money"],true,$row["siteurl"]);
           $row["typeurl"] = $this->GetListUrl($row["typeid"],$row["typedir"],$row["isdefault"],$row["defaultname"],$row["ispart"],$row["namerule2"],$row["siteurl"]);
           $row["info"] = $row["description"];
           $row["filename"] = $row["arcurl"];
           $row["stime"] = GetDateMK($row["pubdate"]);
           $row["textlink"] = "<a href='".$row["filename"]."'>".$row["title"]."</a>";
           $row["typelink"] = "[<a href='".$row["typeurl"]."'>".$row["typename"]."</a>]"; 
           $row["imglink"] = "<a href='".$row["filename"]."'><img src='".$row["picname"]."' border='0' width='$imgwidth' height='$imgheight'></a>";
           $row["image"] = "<img src='".$row["picname"]."' border='0' width='$imgwidth' height='$imgheight'>";
           $row["phpurl"] = $GLOBALS["cfg_plus_dir"];
 		       $row["templeturl"] = $GLOBALS["cfg_templets_dir"];
 		       $row["memberurl"] = $GLOBALS["cfg_member_dir"];
           //���븽�ӱ��������
           foreach($this->ChannelUnit->ChannelFields as $k=>$arr){
 		  	      if(isset($row[$k])) $row[$k] = $this->ChannelUnit->MakeField($k,$row[$k]);
 		  	   }
           //---------------------------
           if(is_array($this->dtp2->CTags)){
       	     foreach($this->dtp2->CTags as $k=>$ctag){
       		 	   if(isset($row[$ctag->GetName()])) $this->dtp2->Assign($k,$row[$ctag->GetName()]);
       		 	   else $this->dtp2->Assign($k,"");
       	    }
           }
           $artlist .= $this->dtp2->GetResult();
         }//if hasRow
         else{
         	 $artlist .= "";
         }
         if($col>1) $artlist .= "</td>\r\n";
       }//Loop Col
       if($col>1) $artlist .= "</tr>\r\n";
     }//Loop Line
     if($col>1) $artlist .= "</table>\r\n";
     $this->dsql->FreeResult("al");
     return $artlist;
  }
  //---------------------------------
  //��ȡ��̬�ķ�ҳ�б�
  //---------------------------------
	function GetPageListST($list_len)
	{
		$prepage="";
		$nextpage="";
		$prepagenum = $this->PageNo-1;
		$nextpagenum = $this->PageNo+1;
		if($list_len==""||ereg("[^0-9]",$list_len)) $list_len=3;
		$totalpage = ceil($this->TotalResult/$this->PageSize);
		if($totalpage<=1 && $this->TotalResult>0) return "��1ҳ/".$this->TotalResult."����¼"; 
		if($this->TotalResult == 0) return "��0ҳ/".$this->TotalResult."����¼"; 
		$purl = $this->GetCurUrl();
		
		$tnamerule = "spec_";
		
		//�����һҳ����һҳ������
		if($this->PageNo != 1){
			$prepage.="<a href='".$tnamerule."_$prepagenum".$GLOBALS['art_shortname']."'>��һҳ</a>\r\n";
			$indexpage="<a href='".$tnamerule."_1".$GLOBALS['art_shortname']."'>��ҳ</a>\r\n";
		}
		else{
			$indexpage="��ҳ\r\n";
		}	
		//
		if($this->PageNo!=$totalpage && $totalpage>1){
			$nextpage.="<a href='".$tnamerule."_$nextpagenum".$GLOBALS['art_shortname']."'>��һҳ</a>\r\n";
			$endpage="<a href='".$tnamerule."_$totalpage".$GLOBALS['art_shortname']."'>ĩҳ</a>\r\n";
		}
		else{
			$endpage="ĩҳ\r\n";
		}
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
		for($j;$j<=$total_list;$j++)
		{
   		if($j==$this->PageNo) $listdd.= "$j\r\n";
   		else $listdd.="".$tnamerule."_$j".$GLOBALS['art_shortname']."'>[".$j."]</a>\r\n";
		}
		$plist = $indexpage.$prepage.$listdd.$nextpage.$endpage;
		return $plist;
	}
  //---------------------------------
  //��ȡ��̬�ķ�ҳ�б�
  //---------------------------------
	function GetPageListDM($list_len)
	{
		$prepage="";
		$nextpage="";
		$prepagenum = $this->PageNo-1;
		$nextpagenum = $this->PageNo+1;
		if($list_len==""||ereg("[^0-9]",$list_len)) $list_len=3;
		$totalpage = ceil($this->TotalResult/$this->PageSize);
		if($totalpage<=1 && $this->TotalResult>0) return "��1ҳ/".$this->TotalResult."����¼"; 
		if($this->TotalResult == 0) return "��0ҳ/".$this->TotalResult."����¼"; 
		
		$purl = $this->GetCurUrl();
		$geturl = "typeid=".$this->TypeID."&TotalResult=".$this->TotalResult."&";
		$hidenform = "<input type='hidden' name='typeid' value='".$this->TypeID."'>\r\n";
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
		}	
		else{ 
   			$j=1;
   			if($total_list>$totalpage) $total_list=$totalpage;
		}
		for($j;$j<=$total_list;$j++)
		{
   		if($j==$this->PageNo) $listdd.= "<td>$j&nbsp;</td>\r\n";
   		else $listdd.="<td><a href='".$purl."PageNo=$j'>[".$j."]</a>&nbsp;</td>\r\n";
		}
		$plist  =  "<table border='0' cellpadding='0' cellspacing='0'>\r\n";
		$plist .= "<tr align='center' style='font-size:10pt'>\r\n";
		$plist .= "<form name='pagelist' action='".$this->GetCurUrl()."'>$hidenform";
		$plist .= $indexpage;
		$plist .= $prepage;
		$plist .= $listdd;
		$plist .= $nextpage;
		$plist .= $endpage;
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
 	function GetListUrl($typeid,$typedir,$isdefault,$defaultname,$ispart,$namerule2)
  {
  	return GetTypeUrl($typeid,MfTypedir($typedir),$isdefault,$defaultname,$ispart,$namerule2);
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
		}
		else
		{ $nowurl = $_SERVER["PHP_SELF"]; }
		return $nowurl;
	}
}//End Class
?>