<?
require_once(dirname(__FILE__)."/inc_channel_unit.php");
require_once(dirname(__FILE__)."/inc_typelink.php");
/******************************************************
//Copyright 2004-2006 by DedeCms.com itprato
//�������;�����ڽ����ʹ���ȫ�����ʵ�ģ�壬��Ƶ�����棬��ҳ������ҳ���
******************************************************/
class PartView
{
	var $dsql;
	var $dtp;
	var $dtp2;
	var $TypeID;
	var $Fields;
	var $TypeLink;
	var $pvCopy;
	//-------------------------------
	//php5���캯��
	//-------------------------------
	function __construct($typeid=0)
 	{
 		$this->TypeID = $typeid;
 		$this->dsql = new DedeSql(false);
 		$this->dtp = new DedeTagParse();
 		$this->dtp->SetNameSpace("dede","{","}");
 		$this->dtp2 = new DedeTagParse();
 		$this->dtp2->SetNameSpace("field","[","]");
 		$this->TypeLink = new TypeLink($typeid);
 		if(is_array($this->TypeLink->TypeInfos)){
 			foreach($this->TypeLink->TypeInfos as $k=>$v){
 				if(ereg("[^0-9]",$k)) $this->Fields[$k] = $v;
 			}
 		}
 		//����һЩȫ�ֲ�����ֵ
 		foreach($GLOBALS['PubFields'] as $k=>$v) $this->Fields[$k] = $v;
  }
  //php4���캯��
 	//---------------------------
 	function PartView($typeid=0){
 		$this->__construct($typeid);
 	}
 	//����Ҫ������ģ��
 	//------------------------
 	function SetTemplet($temp,$stype="file")
 	{
 		if($stype=="string") $this->dtp->LoadSource($temp);
 		else $this->dtp->LoadTemplet($temp);
 		if($this->TypeID > 0){
 			$this->Fields['position'] = $this->TypeLink->GetPositionLink(true);
 			$this->Fields['title'] = $this->TypeLink->GetPositionLink(false);
 		}
 		$this->ParseTemplet();
 	}
 	//��ʾ����
 	//-----------------------
 	function Display(){
 		$this->dtp->Display();
 	}
 	//��ȡ����
 	//-----------------------
 	function GetResult(){
 		return $this->dtp->GetResult();
 	}
 	//������Ϊ�ļ�
 	//------------------------
 	function SaveToHtml($filename){
 		$this->dtp->SaveTo($filename);
 	}
 	//������ģ��
 	/*
 	function __ParseTemplet();
 	*/
 	//------------------------
 	function ParseTemplet()
 	{
 		if(!is_array($this->dtp->CTags)) return "";
 		foreach($this->dtp->CTags as $tagid=>$ctag)
 		{
 			$tagname = $ctag->GetName();
 			if($tagname=="field"){
 				//��� field ���ֵ
 				@$this->dtp->Assign($tagid,$this->Fields[$ctag->GetAtt('name')]);
 			}else if($tagname=="onetype"||$tagname=="type"){
 				//��õ�����Ŀ����
 				$this->dtp->Assign($tagid,$this->GetOneType($ctag->GetAtt('typeid'),$ctag->GetInnerText()));
 			}else if($tagname=="autochannel"){
 				//����Զ���Ŀ����
 				$this->dtp->Assign($tagid,
 				     $this->GetAutoChannel($ctag->GetAtt('partsort'),$ctag->GetInnerText(),$ctag->GetAtt('typeid'))
 				);
 			}else if($tagname=="arclist"||$tagname=="artlist"||$tagname=="likeart"||$tagname=="hotart"||
 			$tagname=="imglist"||$tagname=="imginfolist"||$tagname=="coolart"||$tagname=="specart"||$tagname=="autolist")
 			{  //�ض��������б�
 				  $autopartid = 0;
 				  $channelid = $ctag->GetAtt("channelid");
 				  if($tagname=="imglist"||$tagname=="imginfolist"){ $listtype = "image"; }
 				  else if($tagname=="specart"){ $channelid = -1; $listtype=""; }
 				  else if($tagname=="coolart"){ $listtype = "commend"; }
 				  else if($tagname=="autolist"){ $autopartid = $ctag->GetAtt('partsort'); }
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
 				  
 				  $typeid = trim($ctag->GetAtt("typeid"));
 				  if(empty($typeid)) $typeid = $this->TypeID;
 				  
 				  $this->dtp->Assign($tagid,
 				      $this->GetArcList($typeid,$ctag->GetAtt("row"),$ctag->GetAtt("col"),
 				        $titlelen,$infolen,$ctag->GetAtt("imgwidth"),$ctag->GetAtt("imgheight"),
 				        $ctag->GetAtt("type"),$orderby,$ctag->GetAtt("keyword"),$innertext,
                $ctag->GetAtt("tablewidth"),0,"",$channelid,$ctag->GetAtt("limit"),$ctag->GetAtt("att"),
                $ctag->GetAtt("orderway"),$ctag->GetAtt("subday"),$autopartid
             )
 				  );
 			}else if($tagname=="channelartlist"){
 				 //���Ƶ�����¼���Ŀ�б��ĵ��б�
 				 $this->dtp->Assign($tagid,
 				     $this->GetChannelList(trim($ctag->GetAtt('typeid')),$ctag->GetAtt('col'),$ctag->GetAtt('tablewidth'),$ctag->GetInnerText())
 				 );
 			}else if($tagname=="hotwords"){
 				 //���Źؼ���
 				 $this->dtp->Assign($tagid,
 				 GetHotKeywords($this->dsql,$ctag->GetAtt('num'),$ctag->GetAtt('subday'),$ctag->GetAtt('maxlength')));
 			}
 			else if($tagname=="channel"){
 				//�����Ŀ�����б�
 				if(trim($ctag->GetAtt('typeid'))=="" && $this->TypeID!=0){
 					$typeid = $this->TypeID;
 					$reid = $this->TypeLink->TypeInfos['reID'];
 				}
 				else{
 					$typeid = $ctag->GetAtt("typeid"); $reid=0;
 				}
 				$this->dtp->Assign($tagid,
 				   $this->TypeLink->GetChannelList($typeid,$reid,$ctag->GetAtt("row"),
 				   $ctag->GetAtt("type"),$ctag->GetInnerText(),
 				   $ctag->GetAtt("col"),$ctag->GetAtt("tablewidth"),
 				   $ctag->GetAtt("currentstyle"))
 				);
 			}else if($tagname=="mytag"){
 				//�Զ�����
 				$this->dtp->Assign($tagid,
 				   $this->GetMyTag($ctag->GetAtt("typeid"),$ctag->GetAtt("name"),$ctag->GetAtt("ismake"))
 				);
 			}else if($tagname=="myad"){
 				//������
 				$this->dtp->Assign($tagid,
 				  $this->GetMyAd($ctag->GetAtt("typeid"),$ctag->GetAtt("name"))
 				);
 			}else if($tagname=="vote"){
 				//ͶƱ
 				$this->dtp->Assign($tagid,
				   $this->GetVote(
				     $ctag->GetAtt("id"),$ctag->GetAtt("lineheight"),
             $ctag->GetAtt("tablewidth"),$ctag->GetAtt("titlebgcolor"),
             $ctag->GetAtt("titlebackground"),$ctag->GetAtt("tablebgcolor")
           )
			   );
 			}else if($tagname=="friendlink"||$tagname=="flink"){
 				//��������
 				$this->dtp->Assign($tagid,
 				  $this->GetFriendLink($ctag->GetAtt("type"),
 				    $ctag->GetAtt("row"),$ctag->GetAtt("col"),
 				    $ctag->GetAtt("titlelen"),$ctag->GetAtt("tablestyle"),
 				    $ctag->GetAtt("linktype")
 				  )
 				);
 			}else if($tagname=="mynews"){
 				//վ������
 				$this->dtp->Assign($tagid,
 				  $this->GetMyNews($ctag->GetAtt("row"),$ctag->GetAtt("titlelen"),$ctag->GetInnerText())
 				);
 			}else if($tagname=="loop"){
 				//���ݱ����
 				$this->dtp->Assign($tagid,
				  $this->GetTable($ctag->GetAtt("table"),
					  $ctag->GetAtt("row"),$ctag->GetAtt("sort"),
					  $ctag->GetAtt("if"),$ctag->GetInnerText()
					)
			  );
 			}
 		}//End Foreach
 	}
 	//���һ��ָ�����ĵ��б�
  //---------------------------------
  function GetArcList($typeid=0,$row=10,$col=1,$titlelen=30,$infolen=160,
  $imgwidth=120,$imgheight=90,$listtype="all",$orderby="default",$keyword="",$innertext="",
  $tablewidth="100",$arcid=0,$idlist="",$channelid=0,$limit="",$att=0,$order='desc',$subday=0,$autopartid=-1)
  {
     if(empty($autopartid)) $autopartid = -1;
     if(empty($typeid)) $typeid=$this->TypeID;
     if($autopartid!=-1){
       	$typeid = $this->GetAutoChannelID($autopartid,$typeid);
       	if($typeid==0) return "";
     }
     if(!isset($GLOBALS['__SpGetArcList'])) require_once(dirname(__FILE__)."/inc/inc_fun_SpGetArcList.php");
     return SpGetArcList($this->dsql,$typeid,$row,$col,$titlelen,$infolen,$imgwidth,$imgheight,$listtype,
            $orderby,$keyword,$innertext,$tablewidth,$arcid,$idlist,$channelid,$limit,$att,$order,$subday);
  }
  //GetChannelList($typeid=0,$col=2,$tablewidth=100,$innertext="")
  //���һ�������¼���Ŀ�ĵ��б���Ϣ�б�
  //---------------------------------
  function GetChannelList($typeid=0,$col=2,$tablewidth=100,$innertext=""){
  	if($typeid=="") $typeid=0;
  	if($typeid==0 && !empty($this->TypeID)) $typeid = $this->TypeID;
    if($col=="") $col=2;
    $tablewidth = str_replace("%","",$tablewidth);
		if($tablewidth=="") $tablewidth=100;
		if($col=="") $col = 1;
		$colWidth = ceil(100/$col); 
		$tablewidth = $tablewidth."%";
		$colWidth = $colWidth."%";
		if($innertext=="") $innertext = GetSysTemplets("part_channelartlist.htm");
    //������ID��������Ϣ
    //----------------------------
    $typeids = "";
    if($typeid==0){
    	$this->dsql->SetQuery("Select ID from #@__arctype where reID='0' And ispart<>2 And ishidden<>'1' order by sortrank asc");
    	$this->dsql->Execute();
    	while($row = $this->dsql->GetObject()){ $typeids[] = $row->ID; }
    }else{
    	if(!ereg(",",$typeid)){
    	    $this->dsql->SetQuery("Select ID from #@__arctype where reID='".$typeid."' And ispart<>2 And ishidden<>'1' order by sortrank asc");
    	    $this->dsql->Execute();
    	    while($row = $this->dsql->GetObject()){ $typeids[] = $row->ID; }
       }else{
    	    $ids = explode(",",$typeid); 
    	    foreach($ids as $id){
    		      $id = trim($id); if($id!=""){ $typeids[] = $id; }
    	    }
    	 }
    }
    if(!is_array($typeids)) return "";
    if(count($typeids)<1) return "";
    $nrow = count($typeids);
    $artlist = "";
    $dtp = new DedeTagParse();
 		$dtp->LoadSource($innertext);
    if($col>1){ $artlist = "<table width='$tablewidth' border='0' cellspacing='0' cellpadding='0'>\r\n"; }

    for($i=0;$i < $nrow;)
		{
       if($col>1) $artlist .= "<tr>\r\n";
       for($j=0;$j<$col;$j++)
			 {
         if($col>1) $artlist .= "	<td width='$colWidth' valign='top'>\r\n";
         if(isset($typeids[$i]))
         {
           foreach($dtp->CTags as $tid=>$ctag)
           {
         	   if($ctag->GetName()=="type"){
         	 	   $dtp->Assign($tid,$this->GetOneType($typeids[$i],$ctag->GetInnerText()));
         	   }
         	   else if($ctag->GetName()=="arclist"){
         	   	 $dtp->Assign($tid,$this->GetArcList($typeids[$i],$ctag->GetAtt('row'),
         	   	     $ctag->GetAtt('col'),$ctag->GetAtt('titlelen'),$ctag->GetAtt('infolen'),
                   $ctag->GetAtt('imgwidth'),$ctag->GetAtt('imgheight'),$ctag->GetAtt('type'),
                   $ctag->GetAtt('orderby'),$ctag->GetAtt('keyword'),$ctag->GetInnerText(),
                   $ctag->GetAtt('tablewidth'),$ctag->GetAtt('arcid'),$ctag->GetAtt('idlist'),
                   $ctag->GetAtt('channel'),$ctag->GetAtt('limit'),$ctag->GetAtt('att'),
                   $ctag->GetAtt('order'),$ctag->GetAtt('subday'))
               );
         	   }
           }
           $artlist .= $dtp->GetResult();
         }
         if($col>1) $artlist .= "	</td>\r\n";
         $i++;
       }//Loop Col
       if($col>1){ $artlist .= "	</tr>\r\n";}
     }//Loop Line
     if($col>1) $artlist .= "	</table>\r\n";
     return $artlist;
  }
  //��ȡ�Զ����ǵ�ֵ
  //---------------------------
  function GetMyTag($typeid=0,$tagname="",$ismake="no")
  {
  	if(trim($ismake)=="") $ismake = "no";
    $body = $this->GetMyTagT($typeid,$tagname,"#@__mytag");
  	//����
  	if($ismake=="yes"){
  		$this->pvCopy = new PartView($typeid);
  		$this->pvCopy->SetTemplet($body,"string");
  		$body = $this->pvCopy->GetResult();
  	}
  	return $body;
  }
  //��ȡ���ֵ
  //---------------------------
  function GetMyAd($typeid=0,$tagname=""){
  	return $this->GetMyTagT($typeid,$tagname,"#@__myad");
  }
  function GetMyTagT($typeid,$tagname,$tablename){
  	if($tagname=="") return "";
  	if(trim($typeid)=="") $typeid=0;
  	if($this->TypeID > 0 && $typeid==0) $typeid = $this->TypeID;
  	$row = "";
    $pids = Array();
    if($typeid > 0) $pids = GetParentIDS($typeid,$this->dsql);
  	$idsql = " typeid='0' ";
  	foreach($pids as $v){ $idsql .= " Or typeid='$v' "; }
    $row = $this->dsql->GetOne(" Select * From $tablename where tagname like '$tagname' And ($idsql) order by typeid desc ");
  	if(!is_array($row)){ return ""; }
  	else{
  		$nowtime = mytime();
  		if($row['timeset']==1 && ($nowtime<$row['starttime'] || $nowtime>$row['endtime']) )
  		{ $body = $row['expbody']; }
  		else{ $body = $row['normbody']; }
  	}
  	return $body;
  }
  //��ȡվ��������Ϣ
  //--------------------------
  function GetMyNews($row=1,$titlelen=30,$innertext=""){
  	if($row=="") $row=1;
  	if($titlelen=="") $titlelen=30;
  	if($innertext=="") $innertext = GetSysTemplets("mynews.htm");
  	if($this->TypeID > 0){
  		$topid = SpGetTopID($this->dsql,$this->TypeID);
  		$idsql = " where typeid='$topid' ";
  	}else{
  		$idsql = "";
  	}
  	$this->dsql->SetQuery("Select * from #@__mynews $idsql order by senddate desc limit 0,$row");
  	$this->dsql->Execute();
  	$ctp = new DedeTagParse();
		$ctp->SetNameSpace("field","[","]");
		$ctp->LoadSource($innertext);
		$revalue = "";
		while($row = $this->dsql->GetArray())
		{
		  foreach($ctp->CTags as $tagid=>$ctag){
		    @$ctp->Assign($tagid,$row[$ctag->GetName()]);
		  }
		  $revalue .= $ctp->GetResult();
		}
		return $revalue;
  }
  //���һ����Ŀ��������Ϣ
  //------------------------------
  function GetOneType($typeid,$innertext=""){
  	$row = $this->dsql->GetOne("Select ID,typedir,isdefault,defaultname,ispart,namerule2,typename,moresite,siterefer,siteurl,sitepath From #@__arctype where ID='$typeid'");
  	if(!is_array($row)) return "";
  	if(trim($innertext)=="") $innertext = GetSysTemplets("part_type_list.htm");
  	$dtp = new DedeTagParse();
 		$dtp->SetNameSpace("field","[","]");
 		$dtp->LoadSource($innertext);
 		if(!is_array($dtp->CTags)){ unset($dtp); return ""; }
 		else{
 			$row['typelink'] = GetTypeUrl($row['ID'],MfTypedir($row['typedir']),$row['isdefault'],
 			                    $row['defaultname'],$row['ispart'],$row['namerule2'],$row['siteurl']);
 			foreach($dtp->CTags as $tagid=>$ctag){
 				if(isset($row[$ctag->GetName()])){ $dtp->Assign($tagid,$row[$ctag->GetName()]); }
 			}
 			$revalue = $dtp->GetResult();
 			unset($dtp);
 			return $revalue;
 		}
  }
  //----------------------------------------
	//�������������
	//----------------------------------------
	function GetTable($tablename="",$row=6,$sort="",$ifcase="",$InnerText=""){
		$InnerText = trim($InnerText);
		if($tablename==""||$InnerText=="") return "";
		$row = AttDef($row,6);
		if($sort!="") $sort = " order by $sort desc ";
		if($ifcase!="") $ifcase=" where $ifcase ";
		$revalue="";
		$this->dsql->SetQuery("Select * From $tablename $ifcase $sort limit 0,$row");
		$this->dsql->Execute();
		$ctp = new DedeTagParse();
		$ctp->SetNameSpace("field","[","]");
		$ctp->LoadSource($InnerText);
		while($row = $this->dsql->GetArray())
    {
		  foreach($ctp->CTags as $tagid=>$ctag){
		    if(!empty($row[$ctag->GetName()]))
		    { $ctp->Assign($tagid,$row[$ctag->GetName()]); }
		  }
		  $revalue .= $ctp->GetResult();
		}
		return $revalue;
	}
	//���һ��ͶƱ
	//-------------------------
	function GetVote($id=0,$lineheight=24,$tablewidth="100%",$titlebgcolor="#EDEDE2",$titlebackgroup="",$tablebg="#FFFFFF"){
		if($id=="") $id=0;
		if($id==0){
			$row = $this->dsql->GetOne("select aid From #@__vote order by aid desc limit 0,1");
			if(!isset($row['aid'])) return "";
			else $id=$row['aid'];
		}
		require_once(dirname(__FILE__)."/inc_vote.php");
		$vt = new DedeVote($id);
		$vt->Close();
		return $vt->GetVoteForm($lineheight,$tablewidth,$titlebgcolor,$titlebackgroup,$tablebg);
	}
	//��ȡ���������б�
	//------------------------
	function GetFriendLink($type="",$row="",$col="",$titlelen="",$tablestyle="",$linktype=1){
		$type = AttDef($type,"textall");
		$row = AttDef($row,4);
		$col = AttDef($col,6);
		if($linktype=="") $linktype = 1;
		$titlelen = AttDef($titlelen,24);
		$tablestyle = AttDef($tablestyle," width='100%' border='0' cellspacing='1' cellpadding='1' ");
		$tdwidth = round(100/$col)."%";
		$totalrow = $row*$col;
		
		$wsql = " where ischeck >= '$linktype' ";
		if($type=="image") $wsql .= " And logo<>'' ";
		else if($type=="text") $wsql .= " And logo='' ";
		else $wsql .= "";
		
		$equery = "Select * from #@__flink $wsql order by sortrank asc limit 0,$totalrow";

		$this->dsql->SetQuery($equery);
		$this->dsql->Execute();
		$revalue = "<table $tablestyle>";
		for($i=1;$i<=$row;$i++)
		{
			$revalue.="<tr bgcolor='#FFFFFF' height='20'>\r\n";
			for($j=1;$j<=$col;$j++)
			{
				if($dbrow=$this->dsql->GetObject())
				{
					if($type=="text"||$type=="textall")
					   $link = "&nbsp;<a href='".$dbrow->url."' target='_blank'>".cn_substr($dbrow->webname,$titlelen)."</a>";
					else if($type=="image")
					   $link = "&nbsp;<a href='".$dbrow->url."' target='_blank'><img src='".$dbrow->logo."' width='88' height='31' border='0'></a>";
					else{
						if($dbrow->logo=="")
						   $link = "&nbsp;<a href='".$dbrow->url."' target='_blank'>".cn_substr($dbrow->webname,$titlelen)."</a>";
						else
						   $link = "&nbsp;<a href='".$dbrow->url."' target='_blank'><img src='".$dbrow->logo."' width='88' height='31' border='0'></a>";
					}
					$revalue.="<td width='$tdwidth'>$link</td>\r\n";
				}
				else{
					$revalue.="<td></td>\r\n";
				}
			}
			$revalue.="</tr>\r\n";
		}
		$revalue .= "</table>";
		return $revalue;
	}
	//������˳����һ���¼�������Ϣ
	function GetAutoChannel($sortid,$innertext,$topid="-1"){
		if($topid=="-1" || $topid=="") $topid = $this->TypeID;
		$typeid = $this->GetAutoChannelID($sortid,$topid);
		if($typeid==0) return "";
		if(trim($innertext)=="") $innertext = GetSysTemplets("part_autochannel.htm");
		return $this->GetOneType($typeid,$innertext);
  }
  function GetAutoChannelID($sortid,$topid){
		if(empty($sortid)) $sortid = 1;
		$getstart = $sortid - 1;
		$row = $this->dsql->GetOne("Select ID,typename From #@__arctype where reid='{$topid}' And ispart<2 And ishidden<>'1' order by sortrank asc limit $getstart,1");
		if(!is_array($row)) return 0;
		else return $row['ID'];
  }
 	//---------------------------
 	//�ر���ռ�õ���Դ
 	//---------------------------
 	function Close(){
 		$this->dsql->Close();
 		if(is_object($this->TypeLink)) $this->TypeLink->Close();
 	}
}//End Class
//----------------------
//��ȡһ����Ŀ�Ķ�����ĿID
//----------------------
function SpGetTopID($dsql,$tid){
  $row = $dsql->GetOne("Select ID,reID From #@__arctype where ID='$tid'");
  if($row['reID']==0) return $ID;
  else SpGetTopID($row['reID']);
}
?>