<?
require_once(dirname(__FILE__)."/../include/config_base.php");
require_once(dirname(__FILE__)."/../include/inc_channel_unit_functions.php");
//-------------------------------------
//class TypeLink
//������µ�λ�ú����µ���Ŀλ�õ�
//����Logic��ͷ�ĳ�Ա,һ�����ڵ���,���������(�൱�ڱ�������Ա)
//-------------------------------------
class TypeLink
{
	var $typeDir;
	var $dsql;
	var $TypeID;
	var $baseDir;
	var $modDir;
	var $indexUrl;
	var $indexName;
	var $TypeInfos;
	var $SplitSymbol;
	var $valuePosition;
	var $valuePositionName;
	var $OptionArrayList;
	//���캯��///////
	//-------------
	//php5���캯��
	//-------------
	function __construct($typeid)
 	{
		$this->indexUrl = $GLOBALS['cfg_indexurl']."/";
		$this->indexUrl = ereg_replace("/{1,}","/",$this->indexUrl);
		$this->indexName = $GLOBALS['cfg_indexname'];
		$this->baseDir = $GLOBALS['cfg_basedir'];
		$this->modDir = $GLOBALS['cfg_templets_dir'];
		$this->SplitSymbol = $GLOBALS['cfg_list_symbol'];
		$this->dsql = new DedeSql(false);
		$this->TypeID = $typeid;
	  $this->valuePosition = "";
	  $this->valuePositionName = "";
	  $this->typeDir = "";
	  $this->OptionArrayList = "";
		//������Ŀ��Ϣ
		$query = "
		Select #@__arctype.*,#@__channeltype.typename as ctypename 
		From #@__arctype left join #@__channeltype 
		on #@__channeltype.ID=#@__arctype.channeltype 
		where #@__arctype.ID='$typeid'
		";
		if($typeid > 0){
		  $this->dsql->SetQuery($query);
		  $this->TypeInfos = $this->dsql->GetOne();
	  }
  }
	//����ʹ��Ĭ�Ϲ��캯�������
	//GetPositionLink()��������
	function TypeLink($typeid)
	{
		$this->__construct($typeid);
	}
	//-----------------------
	//�ر����ݿ����ӣ�������Դ
	//-----------------------
	function Close(){
		@$this->dsql->Close();
	}
	//------------------------
	//������ĿID
	//------------------------
	function SetTypeID($typeid){
		$this->TypeID = $typeid;
	  $this->valuePosition = "";
	  $this->valuePositionName = "";
	  $this->typeDir = "";
	  $this->OptionArrayList = "";
		//������Ŀ��Ϣ
		$query = "
		Select #@__arctype.*,#@__channeltype.typename as ctypename 
		From #@__arctype left join #@__channeltype 
		on #@__channeltype.ID=#@__arctype.channeltype 
		where #@__arctype.ID='$typeid'
		";
		$this->dsql->SetQuery($query);
		$this->TypeInfos = $this->dsql->GetOne();
	}
	//-----------------------
	//��������Ŀ��·��
	//-----------------------
	function GetTypeDir()
	{
		if(empty($this->TypeInfos['typedir'])) return $GLOBALS['cfg_arcdir'];
		else return $this->TypeInfos['typedir'];
	}
	//-----------------------------
	//���������ַ
	//----------------------------
	function GetFileUrl($aid,$typeid,$timetag,$title,$ismake=0,$rank=0,$namerule="",$artdir="",$money=0)
	{
		$articleRule = "";
		$articleDir = "";
		
		if($namerule!="") $articleRule = $namerule;
		else if(is_array($this->TypeInfos)) $articleRule = $this->TypeInfos['namerule'];
		
		if($artdir!="") $articleDir = $artdir;
		else if(is_array($this->TypeInfos)) $articleDir = $this->GetTypeDir();
		
		return GetFileUrl($aid,$typeid,$timetag,$title,$ismake,$rank,$articleRule,$articleDir,$money);
	}
	//������ļ���ַ
	//���������Զ�����Ŀ¼
	function GetFileNewName($aid,$typeid,$timetag,$title,$ismake=0,$rank=0,$namerule="",$artdir="",$money=0)
	{
		$articleRule = "";
		$articleDir = "";
		
		if($namerule!="") $articleRule = $namerule;
		else if(is_array($this->TypeInfos)) $articleRule = $this->TypeInfos['namerule'];
		
		if($artdir!="") $articleDir = $artdir;
		else if(is_array($this->TypeInfos)) $articleDir = $this->GetTypeDir();
		
		return GetFileNewName($aid,$typeid,$timetag,$title,$ismake,$rank,$articleRule,$articleDir,$money);
	}
	//----------------------------------------------
	//���ĳ��Ŀ�������б� �磺��Ŀһ>>��Ŀ��>> ��������ʽ
	//islink ��ʾ���ص��б��Ƿ������
	//----------------------------------------------
	function GetPositionLink($islink=true)
	{
		$indexpage = "<a href='".$this->indexUrl."'>".$this->indexName."</a>";
		if($this->valuePosition!="" && $islink){
			return $this->valuePosition;
		}
		else if($this->valuePositionName!="" && !$islink){
			return $this->valuePositionName;
		}
		else if($this->TypeID==0){
			if($islink) return $indexpage;
			else return "ûָ�����࣡";
		}
		else
		{
			if($islink)
			{
			  $this->valuePosition = $this->GetOneTypeLink($this->TypeInfos);
			  if($this->TypeInfos['reID']!=0){ //���õݹ��߼�
			  	$this->LogicGetPosition($this->TypeInfos['reID'],true);
			  }
			  $this->valuePosition = $indexpage.$this->SplitSymbol.$this->valuePosition;
			  return $this->valuePosition.$this->SplitSymbol;
		  }else{
		  	$this->valuePositionName = $this->TypeInfos['typename'];
			  if($this->TypeInfos['reID']!=0){ //���õݹ��߼�
			    $this->LogicGetPosition($this->TypeInfos['reID'],false);
			  }
			  return $this->valuePositionName;
		  }
		}
	}
	//��������б�
	function GetPositionName()
	{
		return $this->GetPositionLink(false);
	}
	//���ĳ��Ŀ�������б��ݹ��߼�����
	function LogicGetPosition($ID,$islink)
	{	
		$this->dsql->SetQuery("Select ID,reID,typename,typedir,isdefault,ispart,defaultname,namerule2 From #@__arctype where ID='".$ID."'");
		$tinfos = $this->dsql->GetOne();
		
		if($islink) $this->valuePosition = $this->GetOneTypeLink($tinfos).$this->SplitSymbol.$this->valuePosition; 
		else $this->valuePositionName = $tinfos['typename'].$this->SplitSymbol.$this->valuePositionName; 
		
		if($tinfos['reID']>0) $this->LogicGetPosition($tinfos['reID'],$islink);
		else return 0;
		
	}
	//-----------------------
	//���ĳ����Ŀ��������Ϣ
	//-----------------------
	function GetOneTypeLink($typeinfos)
	{
	  $typepage = $this->GetOneTypeUrl($typeinfos);
		$typelink = "<a href='".$typepage."'>".$typeinfos['typename']."</a>";
		return $typelink;
	}
	//---------------------
	//���ĳ���������URL
	//---------------------
	function GetOneTypeUrl($typeinfos)
	{
		return GetTypeUrl($typeinfos['ID'],$typeinfos['typedir'],$typeinfos['isdefault'],
		$typeinfos['defaultname'],$typeinfos['ispart'],$typeinfos['namerule2']);
	}
	//--------------------------------------------
	//���ĳID���¼�ID(��������)��SQL��䡰($tb.typeid=id1 or $tb.typeid=id2...)��
	//-------------------------------------------
	function GetSunID($typeid=-1,$tb="#@__archives",$channel=0)
	{
    require_once(dirname(__FILE__)."/inc_typeunit.php");
		$ids = TypeGetSunID($typeid,$this->dsql,$tb,$channel);
		return $ids;
	}
	//------------------------------
	//�������б�
	//hid ��ָĬ��ѡ����Ŀ��0 ��ʾ����ѡ����Ŀ���򡰲�����Ŀ��
	//oper ���û�����������Ŀ��0 ��ʾ������Ŀ
	//channeltype ��ָ��Ŀ���������ͣ�0 ��ʾ����Ƶ��
	//--------------------------------
	function GetOptionArray($hid=0,$oper=0,$channeltype=0,$usersg=0){
		return $this->GetOptionList($hid,$oper,$channeltype,$usersg);
  }
	function GetOptionList($hid=0,$oper=0,$channeltype=0,$usersg=0)
	{
    if(!$this->dsql) $this->dsql = new DedeSql();
    $this->OptionArrayList = "";
    if($hid>0){
    	$row = $this->dsql->GetOne("Select ID,typename From #@__arctype where ID='$hid'");
    	$this->OptionArrayList .= "<option value='".$row['ID']."' selected>".$row['typename']."</option>\r\n";
    }
    if($channeltype==0) $ctsql="";
    else $ctsql=" And channeltype='$channeltype' ";
    
    if($usersg==0) $usql = " ispart<>2 And ";
    else $usql = "";
    	
    if($oper!=0)
    { $query = "Select ID,typename From #@__arctype where $usql ID='$oper' $ctsql"; }
    else
    { $query = "Select ID,typename From #@__arctype where $usql reID=0 $ctsql order by sortrank asc"; }
      
    $this->dsql->SetQuery($query);
    $this->dsql->Execute();
    	
     while($row=$this->dsql->GetObject()){
        $this->OptionArrayList .= "<option value='".$row->ID."'>".$row->typename."</option>\r\n";
        $this->LogicGetOptionArray($row->ID,"��");
     }
     return $this->OptionArrayList; 
	}
	function LogicGetOptionArray($ID,$step)
	{
		$this->dsql->SetQuery("Select ID,typename From #@__arctype where reID='".$ID."' order by sortrank asc");
		$this->dsql->Execute($ID);
		while($row=$this->dsql->GetObject($ID)){
      $this->OptionArrayList .= "<option value='".$row->ID."'>$step".$row->typename."</option>\r\n";
      $this->LogicGetOptionArray($row->ID,$step."��");
    }
	}
	//----------------------------
	//����������ص���Ŀ��������Ӧ����ģ����{dede:channel}{/dede:channel}��
	//$typetype ��ֵΪ�� sun �¼����� self ͬ������ top ��������
	//-----------------------------
	function GetChannelList($typeid=0,$reID=0,$row=8,$typetype="sun",$innertext="",$col=1,$tablewidth=100)
	{
		if($typeid==0) $typeid = $this->TypeID;
		if($row=="") $row = 8;
		if($reID=="") $reID = 0;
		if($col=="") $col = 1;
		
		$tablewidth = str_replace("%","",$tablewidth);
		if($tablewidth=="") $tablewidth=100;
		if($col=="") $col = 1;
		$colWidth = ceil(100/$col); 
		$tablewidth = $tablewidth."%";
		$colWidth = $colWidth."%";
		
		if($typetype=="") $typetype="sun";
		if($innertext=="") $innertext = GetSysTemplets("channel_list.htm");
		
		$likeType = "";
		if($typetype=="top"){
		  $sql = "Select ID,typename,typedir,isdefault,ispart,defaultname,namerule2 
		  From #@__arctype where reID=0 order by sortrank asc limit 0,$row";
		}
		else if($typetype=="sun"){
		  $sql = "Select ID,typename,typedir,isdefault,ispart,defaultname,namerule2 
		  From #@__arctype where reID='$typeid' order by sortrank asc limit 0,$row";
		}
		else if($typetype=="self"){
			$sql = "Select ID,typename,typedir,isdefault,ispart,defaultname,namerule2 
			From #@__arctype where reID='$reID' And ID<>'$typeid' order by sortrank asc limit 0,$row";
		}
	  $dtp2 = new DedeTagParse();
	  $dtp2->SetNameSpace("field","[","]");
	  $dtp2->LoadSource($innertext);
    //$oldSource = $dtp2->SourceString;
    //$oldCtags = $dtp2->CTags;
    $this->dsql->SetQuery($sql);
	  $this->dsql->Execute();
	  $line = $row;
	  $GLOBALS['autoindex'] = 0;
	  if($col>1) $likeType = "<table width='$tablewidth' border='0' cellspacing='0' cellpadding='0'>\r\n";
		for($i=0;$i<$line;$i++)
		{
       if($col>1) $likeType .= "<tr>\r\n";
       for($j=0;$j<$col;$j++)
			 {
         if($col>1) $likeType .= "	<td width='$colWidth'>\r\n";
         if($row=$this->dsql->GetArray())
         {
         	 //$dtp2->SourceString = $oldSource;
           //$dtp2->CTags = $oldCtags;
			     $row['typelink'] = $this->GetOneTypeUrl($row);
			     if(is_array($dtp2->CTags)){
			     	 foreach($dtp2->CTags as $tagid=>$ctag)
			     	 { if(isset($row[$ctag->GetName()])) $dtp2->Assign($tagid,$row[$ctag->GetName()]); }
			     }
			     $likeType .= $dtp2->GetResult();
         }
         if($col>1) $likeType .= "	</td>\r\n";
         $GLOBALS['autoindex']++;
       }//Loop Col
       if($col>1) $i += $col - 1;
       if($col>1) $likeType .= "	</tr>\r\n";
    }//Loop for $i
		if($col>1) $likeType .= "	</table>\r\n";
    $this->dsql->FreeResult();
		return $likeType;
	}//GetChannel
	
}//End Class
?>