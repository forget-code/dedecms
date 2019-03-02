<?
//class SiteMap
//--------------------------------
require_once(dirname(__FILE__)."/../include/config_base.php");
require_once(dirname(__FILE__)."/../include/inc_channel_unit_functions.php");
class SiteMap
{
	var $dsql;
	var $artDir;
	var $baseDir;
	//-------------
	//php5���캯��
	//-------------
	function __construct()
 	{
		$this->idCounter = 0;
		$this->artDir = $GLOBALS['cfg_arcdir'];
		$this->baseDir = $GLOBALS['cfg_basedir'];
		$this->idArrary = "";
		$this->dsql = new DedeSql(false);
  }
	function SiteMap()
	{
		$this->__construct();
	}
	//------------------
	//������
	//------------------
	function Close()
	{
		@$this->dsql->Close();
	}
	//---------------------------
	//��ȡ��վ��ͼ
	//$maptype = "site" �� "rss"
	//---------------------------
	function GetSiteMap($maptype="site")
	{
		$mapString = "";
		if($maptype=="rss") $this->dsql->SetQuery("Select ID,typedir,isdefault,defaultname,typename,ispart,namerule2 From #@__arctype where reID=0 And ispart<>2 order by sortrank");
		else $this->dsql->SetQuery("Select ID,typedir,isdefault,defaultname,typename,ispart,namerule2 From #@__arctype where reID=0 order by sortrank");
		$this->dsql->Execute(0);
		$mapString .= "<table width='100%' border='0' cellpadding='2' cellspacing='1' bgcolor='#CEDD9B'>\r\n";
		while($row=$this->dsql->GetObject(0))
		{	 
			if($maptype=="site") $typelink = GetTypeUrl($row->ID,$row->typedir,$row->isdefault,$row->defaultname,$row->ispart,$row->namerule2);
			else $typelink = $GLOBALS['cfg_extend_dir']."/rss/".$row->ID.".xml";
			$mapString .= "<tr><td width='17%' align='center' bgcolor='#FAFEF1'>";
      $mapString .= "<a href='$typelink'><b>".$row->typename."</b></a>";
      $mapString .= "</td><td width='83%' bgcolor='#FFFFFF'>";
			$mapString .= $this->LogicListAllSunType($row->ID,$maptype);
			$mapString .= "</td></tr>";
		}
		$mapString .= "</table>\r\n";
		return $mapString;
	}
	//�������Ŀ�ĵݹ����
	function LogicListAllSunType($ID,$maptype)
	{
		$fid = $ID;
		$mapString = "";
		if($maptype=="rss") $this->dsql->SetQuery("Select ID,typedir,isdefault,defaultname,typename,ispart,namerule2 From #@__arctype where reID='".$ID."' And ispart<>2 order by sortrank");
		else $this->dsql->SetQuery("Select ID,typedir,isdefault,defaultname,typename,ispart,namerule2 From #@__arctype where reID='".$ID."' order by sortrank");
		$this->dsql->Execute($fid);
		while($row=$this->dsql->GetObject($fid))
		{
			 if($maptype=="site") $typelink = GetTypeUrl($row->ID,$row->typedir,$row->isdefault,$row->defaultname,$row->ispart,$row->namerule2);
			 else $typelink = $GLOBALS['cfg_extend_dir']."/rss/".$row->ID.".xml";
			 $mapString .= "<a href='$typelink'>".$row->typename."</a> &nbsp;";
			 $mapString .= $this->LogicListAllSunType($row->ID,$maptype);
		}
		return $mapString;
	}
}
?>