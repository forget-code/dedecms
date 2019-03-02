<?php 
//class TypeUnit
//�������Ҫ�Ƿ�װƵ������ʱ��һЩ���Ӳ��� 
//--------------------------------
require_once(dirname(__FILE__)."/config_base.php");
class TypeUnit
{
	var $dsql;
	var $artDir;
	var $baseDir;
	var $idCounter;
	var $idArrary;
	var $shortName;
	
	//-------------
	//php5���캯��
	//-------------
	function __construct()
 	{
		$this->idCounter = 0;
		$this->artDir = $GLOBALS['cfg_cmspath'].$GLOBALS['cfg_arcdir'];
		$this->baseDir = $GLOBALS['cfg_basedir'];
		$this->shortName = $GLOBALS['art_shortname'];
		$this->idArrary = "";
		$this->dsql = 0;
  }
	function TypeUnit()
	{
		$this->__construct();
	}
	//------------------
	//������
	//------------------
	function Close()
	{
		if(is_object($this->dsql)){ $this->dsql->Close(); @$this->dsql=0; }
		$this->idArrary = "";
		$this->idCounter = 0;
	}
	//
	//----�������з���,����Ŀ����ҳ(list_type)��ʹ��----------
	//
	function ListAllType($channel=0,$nowdir=0)
	{
		if($this->dsql==0){ $this->dsql = new DedeSql(); }
		
		if($channel>0)
		{	$this->dsql->SetQuery("Select ID,typedir,typename,ispart From #@__arctype where ID='$channel'");}
		else
		{	$this->dsql->SetQuery("Select ID,typedir,typename,ispart From #@__arctype where reID=0 order by sortrank"); }
		$this->dsql->Execute(0);
		
		$lastID = GetCookie('lastCidMenu');
		
		while($row=$this->dsql->GetObject(0))
		{	 
			$typeDir = $row->typedir;
			$typeName = $row->typename;
			$ispart = $row->ispart;
			$ID = $row->ID;
			
			if($ispart==2){
				continue;
			}
			
			//��ͨ�б�
			if($ispart==0) $smenu = " oncontextmenu=\"CommonMenu(this,$ID,'".urlencode($typeName)."')\"";
			//�������Ƶ��
			else if($ispart==1) $smenu = " oncontextmenu=\"CommonMenuPart(this,$ID,'".urlencode($typeName)."')\"";
			//����ҳ��
			else if($ispart==2) $smenu = " oncontextmenu=\"SingleMenu(this,$ID,'".urlencode($typeName)."')\"";
			
			echo "<dl class='topcc'>\r\n";
			echo "  <dd class='dlf'><img style='cursor:hand' onClick=\"LoadSuns('suns{$ID}',{$ID});\" src='img/tree_explode.gif' width='11' height='11'></dd>\r\n";
			echo "  <dd class='dlr'><a href='catalog_do.php?cid=".$ID."&dopost=listArchives'{$smenu}>".$typeName."</a></dd>\r\n";
			echo "</dl>\r\n";
			echo "<div id='suns".$ID."' class='sunct'>";
			if($channel==$ID || $lastID==$ID || ($nowdir==-1 && $channel>0) ){
				 $this->LogicListAllSunType($ID,"��");
			}
			echo "</div>\r\n";
		}
	}
	//�������Ŀ�ĵݹ����
	function LogicListAllSunType($ID,$step)
	{
		$fid = $ID;
		$this->dsql->SetQuery("Select ID,reID,typedir,typename,ispart From #@__arctype where reID='".$ID."' order by sortrank");
		$this->dsql->Execute($fid);
		if($this->dsql->GetTotalRow($fid)>0)
		{
		  while($row=$this->dsql->GetObject($fid))
		  {
			  $typeDir = $row->typedir;
			  $typeName = $row->typename;
			  $reID = $row->reID;
			  $ID = $row->ID;
			  $ispart = $row->ispart;
			  if($step=="��") $stepdd = 2;
			  else $stepdd = 3;
			  
			  //if($ispart==2) continue;
			  
			  //��ͨ�б�
			  if($ispart==0){
			  	$smenu = " oncontextmenu=\"CommonMenu(this,$ID,'".urlencode($typeName)."')\"";
			  	$timg = " <img src='img/tree_list.gif'> ";
			  }
			  //�������Ƶ��
			  else if($ispart==1){
			  	$timg = " <img src='img/tree_part.gif'> ";
			  	$smenu = " oncontextmenu=\"CommonMenuPart(this,$ID,'".urlencode($typeName)."')\"";
			  }
			  //����ҳ��
			  else if($ispart==2){
			  	$timg = " <img src='img/tree_page.gif'> ";
			  	$smenu = " oncontextmenu=\"SingleMenu(this,$ID,'".urlencode($typeName)."')\"";
			  }
			  
			  echo "  <table class='sunlist'>\r\n";
			  echo "   <tr>\r\n";
			  echo "     <td>".$step.$timg."<a href='catalog_do.php?cid=".$ID."&dopost=listArchives'{$smenu}>".$typeName."</a></td>\r\n";
			  echo "   </tr>\r\n";
			  echo "  </table>\r\n";
			  
			  $this->LogicListAllSunType($ID,$step."��");
		  }
		}
	}
	//------------------------------------------------------
	//-----������ĳ��Ŀ��ص��¼�Ŀ¼����ĿID�б�(ɾ����Ŀ������ʱ����)
	//------------------------------------------------------
	function GetSunTypes($ID,$channel=0)
	{
		if($this->dsql==0) $this->dsql = new DedeSql(false);
		$this->idArray[$this->idCounter]=$ID;
		$this->idCounter++;
		$fid = $ID;
	  if($channel!=0) $csql = " And channeltype=$channel ";
	  else $csql = "";
		$this->dsql->SetQuery("Select ID From #@__arctype where reID=$ID $csql");
		$this->dsql->Execute("gs".$fid);
    //if($this->dsql->GetTotalRow("gs".$fid)!=0)
		//{
		while($row=$this->dsql->GetObject("gs".$fid)){
			$nid = $row->ID;
			$this->GetSunTypes($nid,$channel);
		}
		//}
		return $this->idArray;
	}
	//----------------------------------------------------------------------------
	//���ĳID���¼�ID(��������)��SQL��䡰($tb.typeid=id1 or $tb.typeid=id2...)��
	//----------------------------------------------------------------------------
	function GetSunID($ID,$tb="#@__archives",$channel=0)
	{
		$this->sunID = "";
		if($this->dsql==0) $this->dsql = new DedeSql(false);
		$this->idCounter = 0;
		$this->idArray = "";
		$this->GetSunTypes($ID,$channel);
		$this->dsql->Close();
		$this->dsql = 0;
		$rquery = "";
		for($i=0;$i<$this->idCounter;$i++)
		{
			if($i!=0) $rquery .= " Or ".$tb.".typeid='".$this->idArray[$i]."' ";
			else      $rquery .= "    ".$tb.".typeid='".$this->idArray[$i]."' ";
		}
		reset($this->idArray);
		$this->idCounter = 0;
		return " (".$rquery.") ";
	}
}
?>