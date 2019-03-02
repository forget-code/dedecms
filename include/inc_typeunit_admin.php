<?
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
	function __construct(){
		$this->idCounter = 0;
		$this->artDir = $GLOBALS['cfg_cmspath'].$GLOBALS['cfg_arcdir'];
		$this->baseDir = $GLOBALS['cfg_basedir'];
		$this->shortName = $GLOBALS['art_shortname'];
		$this->idArrary = "";
		$this->dsql = 0;
  }
	function TypeUnit(){
		$this->__construct();
	}
	//------------------
	//������
	//------------------
	function Close(){
		if($this->dsql){ $this->dsql->Close(); @$this->dsql=0; }
		$this->idArrary = "";
		$this->idCounter = 0;
	}
	//------------------------------
	function GetTotalArc($tid){
		$row = $this->dsql->GetOne("Select count(ID) as dd From #@__archives where typeid='$tid'");
		return $row['dd'];
	}
	//
	//----�������з���,����Ŀ����ҳ(list_type)��ʹ��----------
	//
	function ListAllType($channel=0,$nowdir=0)
	{
		if($this->dsql==0){ $this->dsql = new DedeSql(); }
		
		$this->dsql->SetQuery("Select ID,typedir,typename,ispart,sortrank,ishidden From #@__arctype where reID=0 order by sortrank");
		$this->dsql->Execute(0);
		
		while($row=$this->dsql->GetObject(0))
		{	 
			$typeDir = $row->typedir;
			$typeName = $row->typename;
			$ispart = $row->ispart;
			$ID = $row->ID;
			$rank = $row->sortrank;
			if($row->ishidden=='1') $nss = "<font color='red'>[��]</font>";
			else  $nss = "";
			echo "<table width='100%' border='0' cellspacing='0' cellpadding='2'>\r\n";
			if($channel==0||$channel==$ID)
			{
			  //��ͨ�б�
			  if($ispart==0)
			  {
			     echo "  <tr bgcolor='#F5F5F5'>\r\n";
			     echo "  <td width='2%' class='bline'><img style='cursor:hand' onClick=\"LoadSuns('suns".$ID."',$ID);\" src='img/dedeexplode.gif' width='11' height='11'></td>\r\n";
			     echo "  <td class='bline'><table width='98%' border='0' cellspacing='0' cellpadding='0'><tr><td width='50%'><input class='np' type='checkbox' name='tids[]' value='{$ID}'><a href='catalog_do.php?cid=".$ID."&dopost=listArchives' oncontextmenu=\"CommonMenu(this,$ID,'".urlencode($typeName)."')\">{$nss}".$typeName."[ID:".$ID."]</a>(�ĵ���".$this->GetTotalArc($ID).")";
			     echo "    </td><td align='right'>";
			     echo "<a href='{$GLOBALS['cfg_plus_dir']}/list.php?tid={$ID}' target='_blank'>Ԥ��</a>";
			     echo "|<a href='catalog_do.php?cid={$ID}&dopost=listArchives'>����</a>";
			     echo "|<a href='catalog_add.php?ID={$ID}'>��������</a>";
			     echo "|<a href='catalog_edit.php?ID={$ID}'>����</a>";
			     echo "|<a href='catalog_move.php?job=movelist&typeid={$ID}'>�ƶ�</a>";
			     echo "|<a href='catalog_del.php?ID={$ID}&typeoldname=".urlencode($typeName)."'>ɾ��</a>";
			     echo "&nbsp; <input type='text' name='sortrank{$ID}' value='{$rank}' style='width:25;height:16'></td></tr></table></td></tr>\r\n";
			  }
			  //�������Ƶ��
			  else if($ispart==1)
			  {
			     echo "  <tr bgcolor='#F5F5F5'>\r\n";
			     echo "  <td width='2%' class='bline'><img style='cursor:hand' onClick=\"LoadSuns('suns".$ID."',$ID);\" src='img/dedeexplode.gif' width='11' height='11'></td>\r\n";
			     echo "  <td class='bline'><table width='98%' border='0' cellspacing='0' cellpadding='0'><tr><td width='50%'><input class='np' type='checkbox' name='tids[]' value='{$ID}'><a href='catalog_do.php?cid=".$ID."&dopost=listArchives' oncontextmenu=\"CommonMenuPart(this,$ID,'".urlencode($typeName)."')\">{$nss}".$typeName."[ID:".$ID."]</a>";
			     echo "    </td><td align='right'>";
			     echo "<a href='{$GLOBALS['cfg_plus_dir']}/list.php?tid={$ID}' target='_blank'>Ԥ��</a>";
			     echo "|<a href='catalog_do.php?cid={$ID}&dopost=listArchives'>����</a>";
			     echo "|<a href='catalog_add.php?ID={$ID}'>��������</a>";
			     echo "|<a href='catalog_edit.php?ID={$ID}'>����</a>";
			     echo "|<a href='catalog_move.php?job=movelist&typeid={$ID}'>�ƶ�</a>";
			     echo "|<a href='catalog_del.php?ID={$ID}&typeoldname=".urlencode($typeName)."'>ɾ��</a>";
			    echo "&nbsp; <input type='text' name='sortrank{$ID}' value='{$rank}' style='width:25;height:16'></td></tr></table></td></tr>\r\n";
			  }
			  //����ҳ��
			  else if($ispart==2)
			  {
				  echo "  <tr height='24' bgcolor='#F5F5F5'>\r\n";
			    echo "  <td width='2%' class='bline2'><img style='cursor:hand' onClick=\"LoadSuns('suns".$ID."',$ID);\" src='img/dedeexplode.gif' width='11' height='11'></td>\r\n";
			    echo "  <td class='bline2'><table width='98%' border='0' cellspacing='0' cellpadding='0'><tr><td width='50%'><input class='np' type='checkbox' name='tids[]' value='{$ID}'><a href='catalog_edit.php?ID=".$ID."' oncontextmenu=\"SingleMenu(this,$ID,'".urlencode($typeName)."')\">{$nss}".$typeName."[ID:".$ID."]</a>";
			    echo "    </td><td align='right'>";
			    echo "<a href='catalog_do.php?cid={$ID}&dopost=viewSgPage' target='_blank'>Ԥ��</a>";
			    echo "|<a href='catalog_do.php?cid={$ID}&dopost=editSgPage'>ҳ��</a>";
			    echo "|<a href='catalog_do.php?cid={$ID}&dopost=editSgTemplet'>����ģ��</a>";
			    echo "|<a href='catalog_edit.php?ID={$ID}'>����</a>";
			    echo "|<a href='catalog_move.php?job=movelist&typeid={$ID}'>�ƶ�</a>";
			    echo "|<a href='catalog_del.php?ID={$ID}&typeoldname=".urlencode($typeName)."'>ɾ��</a>";
			    echo "&nbsp; <input type='text' name='sortrank{$ID}' value='{$rank}' style='width:25;height:16'></td></tr></table></td></tr>\r\n";
			  }
		  }
		  else
		  {
		  	//��ͨ�б�
			  if($ispart==0)
			  {
			     echo "  <tr bgcolor='#F5F5F5'>\r\n";
			     echo "  <td width='2%' class='bline'><img src='img/dedeexplode2.gif' width='11' height='11'></td>\r\n";
			     echo "  <td class='bline'><table width='98%' border='0' cellspacing='0' cellpadding='0'><tr><td width='50%'><a href='catalog_do.php?cid=".$ID."&dopost=listArchives'>{$nss}".$typeName."[ID:".$ID."]</a>(�ĵ���".$this->GetTotalArc($ID).")";
			     echo "    </td><td align='right'>";
			     echo "<a href='{$GLOBALS['cfg_plus_dir']}/list.php?tid={$ID}' target='_blank'>Ԥ��</a>";
			     echo "|<a href='catalog_do.php?cid={$ID}&dopost=listArchives'>����</a>";
			     echo "&nbsp; </td></tr></table></td></tr>\r\n";
			  }
			  //�������Ƶ��
			  else if($ispart==1)
			  {
			     echo "  <tr bgcolor='#F5F5F5'>\r\n";
			     echo "  <td width='2%' class='bline'><img src='img/dedeexplode2.gif' width='11' height='11'></td>\r\n";
			     echo "  <td class='bline'><table width='98%' border='0' cellspacing='0' cellpadding='0'><tr><td width='50%'><a href='catalog_do.php?cid=".$ID."&dopost=listArchives'>{$nss}".$typeName."[ID:".$ID."]</a>";
			     echo "    </td><td align='right'>";
			     echo "<a href='{$GLOBALS['cfg_plus_dir']}/list.php?tid={$ID}' target='_blank'>Ԥ��</a>";
			     echo "|<a href='catalog_do.php?cid={$ID}&dopost=listArchives'>����</a>";
			    echo "&nbsp; </td></tr></table></td></tr>\r\n";
			  }
			  //����ҳ��
			  else if($ispart==2)
			  {
				  echo "  <tr height='24' bgcolor='#F5F5F5'>\r\n";
			    echo "  <td width='2%' class='bline2'><img src='img/dedeexplode2.gif' width='11' height='11'></td>\r\n";
			    echo "  <td class='bline2'><table width='98%' border='0' cellspacing='0' cellpadding='0'><tr><td width='50%'><a href='catalog_edit.php?ID=".$ID."'>{$nss}".$typeName."[ID:".$ID."]</a>";
			    echo "    </td><td align='right'>";
			    echo "<a href='catalog_do.php?cid={$ID}&dopost=viewSgPage' target='_blank'>Ԥ��</a>";
			    echo "|<a href='catalog_do.php?cid={$ID}&dopost=editSgPage'>ҳ��</a>";
			    echo "|<a href='catalog_do.php?cid={$ID}&dopost=editSgTemplet'>����ģ��</a>";
			    echo "&nbsp; </td></tr></table></td></tr>\r\n";
			  }
		  }
			echo "  <tr><td colspan='2' id='suns".$ID."'>";
			$lastID = GetCookie('lastCid');
			if($channel==$ID || $lastID==$ID)
			{
				echo "    <table width='100%' border='0' cellspacing='0' cellpadding='0'>\r\n";	
				$this->LogicListAllSunType($ID,"��");
				echo "    </table>\r\n";
			}
			echo "</td></tr>\r\n</table>\r\n";
			
		}
	}
	//�������Ŀ�ĵݹ����
	function LogicListAllSunType($ID,$step)
	{
		$fid = $ID;
		$this->dsql->SetQuery("Select ID,reID,typedir,typename,ispart,sortrank,ishidden From #@__arctype where reID='".$ID."' order by sortrank");
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
			  $rank = $row->sortrank;
			  if($row->ishidden=='1') $nss = "<font color='red'>[��]</font>";
			  else  $nss = "";
			  //��ͨ�б�
			  if($ispart==0)
			  {
			     echo "<tr height='24' oncontextmenu=\"CommonMenu(this,$ID,'".urlencode($typeName)."')\">\r\n";
			     echo "<td class='nbline'>";
			     echo "<table width='98%' border='0' cellspacing='0' cellpadding='0'>";
			     echo "<tr onMouseMove=\"javascript:this.bgColor='#EAEAEA';\" onMouseOut=\"javascript:this.bgColor='#FFFFFF';\"><td width='50%'>";
			     echo "<input class='np' type='checkbox' name='tids[]' value='{$ID}'><a href='catalog_do.php?cid=".$ID."&dopost=listArchives'>$step ��{$nss}".$typeName."[ID:".$ID."]</a>(�ĵ���".$this->GetTotalArc($ID).")";
			     echo "</td><td align='right'>";
			     echo "<a href='{$GLOBALS['cfg_plus_dir']}/list.php?tid={$ID}' target='_blank'>Ԥ��</a>";
			     echo "|<a href='catalog_do.php?cid={$ID}&dopost=listArchives'>����</a>";
			     echo "|<a href='catalog_add.php?ID={$ID}'>��������</a>";
			     echo "|<a href='catalog_edit.php?ID={$ID}'>����</a>";
			     echo "|<a href='catalog_move.php?job=movelist&typeid={$ID}'>�ƶ�</a>";
			     echo "|<a href='catalog_del.php?ID={$ID}&typeoldname=".urlencode($typeName)."'>ɾ��</a>";
			     echo "&nbsp; <input type='text' name='sortrank{$ID}' value='{$rank}' style='width:25;height:16'></td></tr></table></td></tr>\r\n";
			  }
			  //����Ƶ��
			  else if($ispart==1)
			  {
			     echo " <tr height='24' oncontextmenu=\"CommonMenu(this,$ID,'".urlencode($typeName)."')\">\r\n";
			     echo "<td class='nbline'><table width='98%' border='0' cellspacing='0' cellpadding='0'><tr onMouseMove=\"javascript:this.bgColor='#EAEAEA';\" onMouseOut=\"javascript:this.bgColor='#FFFFFF';\"><td width='50%'>";
			     echo "<input class='np' type='checkbox' name='tids[]' value='{$ID}'><a href='catalog_do.php?cid=".$ID."&dopost=listArchives'>$step ��{$nss}".$typeName."[ID:".$ID."]</a>";
			     echo "</td><td align='right'>";
			     echo "<a href='{$GLOBALS['cfg_plus_dir']}/list.php?tid={$ID}' target='_blank'>Ԥ��</a>";
			     echo "|<a href='catalog_do.php?cid={$ID}&dopost=listArchives'>����</a>";
			     echo "|<a href='catalog_add.php?ID={$ID}'>��������</a>";
			     echo "|<a href='catalog_edit.php?ID={$ID}'>����</a>";
			     echo "|<a href='catalog_move.php?job=movelist&typeid={$ID}'>�ƶ�</a>";
			     echo "|<a href='catalog_del.php?ID={$ID}&typeoldname=".urlencode($typeName)."'>ɾ��</a>";
			     echo "&nbsp; <input type='text' name='sortrank{$ID}' value='{$rank}' style='width:25;height:16'></td></tr></table></td></tr>\r\n";
			  }
			  //����ҳ��
			  else if($ispart==2)
			  {
				   echo "<tr height='24' oncontextmenu=\"SingleMenu(this,$ID,'".urlencode($typeName)."')\">\r\n";
			     echo "<td class='bline2'><table width='98%' border='0' cellspacing='0' cellpadding='0'>";
			     echo "<tr onMouseMove=\"javascript:this.bgColor='#EAEAEA';\" onMouseOut=\"javascript:this.bgColor='#FFFFFF';\"><td width='50%'>";
			     echo "<input class='np' type='checkbox' name='tids[]' value='{$ID}'><a href='catalog_do.php?cid=".$ID."&dopost=listArchives'>$step ��{$nss}".$typeName."[ID:".$ID."]</a>";
			     echo "</td><td align='right'>";
			     echo "<a href='catalog_do.php?cid={$ID}&dopost=viewSgPage' target='_blank'>Ԥ��</a>";
			     echo "|<a href='catalog_do.php?cid={$ID}&dopost=editSgPage'>ҳ��</a>";
			     echo "|<a href='catalog_do.php?cid={$ID}&dopost=editSgTemplet'>����ģ��</a>";
			     echo "|<a href='catalog_edit.php?ID={$ID}'>����</a>";
			     echo "|<a href='catalog_move.php?job=movelist&typeid={$ID}'>�ƶ�</a>";
			     echo "|<a href='catalog_del.php?ID={$ID}&typeoldname=".urlencode($typeName)."'>ɾ��</a>";
			     echo "&nbsp; <input type='text' name='sortrank{$ID}' value='{$rank}' style='width:25;height:16'></td></tr></table></td></tr>\r\n";
			  }
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
	//----------------------------------------
	//ɾ����Ŀ
	//----------------------------------------
	function DelType($ID,$isDelFile)
	{
		$this->idCounter = 0;
		$this->idArray = "";
		$this->GetSunTypes($ID);
		
		$query = "
		Select #@__arctype.*,#@__channeltype.typename as ctypename,
		#@__channeltype.addtable 
		From #@__arctype left join #@__channeltype 
		on #@__channeltype.ID=#@__arctype.channeltype 
		where #@__arctype.ID='$ID'
		";
		$typeinfos = $this->dsql->GetOne($query);
		$topinfos = $this->dsql->GetOne("Select moresite,siterefer,sitepath,siteurl From #@__arctype where ID='".$typeinfos['topID']."'");
		
		if(!is_array($typeinfos)) return false;
		$indir = $typeinfos['typedir'];
		$addtable = $typeinfos['addtable'];
		$ispart = $typeinfos['ispart'];
		$defaultname = $typeinfos['defaultname'];
		
		//ɾ�����ݿ������ؼ�¼
		foreach($this->idArray as $id){
			$myrow = $this->dsql->GetOne("Select * From #@__arctype where ID='$id'");
			if($myrow['topID']>0)
			{
				$mytoprow = $this->dsql->GetOne("Select moresite,siterefer,sitepath,siteurl From #@__arctype where ID='".$myrow['topID']."'");
				foreach($mytoprow as $k=>$v){
	  		   if(!ereg("[0-9]",$k)) $myrow[$k] = $v;
	  	  }
			}
			//ɾ��Ŀ¼��Ŀ¼��������ļ� ### ��ֹ�˴˹���
			//ɾ������ҳ��
		  if($myrow['ispart']==2 && $myrow['typedir']==""){
			  if( is_file($this->baseDir."/".$myrow['defaultname']) )
			  { @unlink($this->baseDir."/".$myrow['defaultname']); }
		  }
			//ɾ�����ݿ���Ϣ
			$this->dsql->SetQuery("Delete From #@__arctype where ID='$id'");
			$this->dsql->ExecuteNoneQuery();
			$this->dsql->SetQuery("Delete From #@__archives where typeid='$id'");
			$this->dsql->ExecuteNoneQuery();
			$this->dsql->SetQuery("update #@__archives set typeid2=0 where typeid2='$id'");
			$this->dsql->ExecuteNoneQuery();
			$this->dsql->SetQuery("Delete From #@__spec where typeid='$id'");
			$this->dsql->ExecuteNoneQuery();
			$this->dsql->SetQuery("Delete From #@__feedback where typeid='$id'");
			$this->dsql->ExecuteNoneQuery();
      if($addtable!=""){
        $this->dsql->SetQuery("Delete From $addtable where typeid='$id'");
			  $this->dsql->ExecuteNoneQuery();
		  }
		}
		
		//ɾ��Ŀ¼��Ŀ¼��������ļ� ### ��ֹ�˴˹���
		
		//ɾ������ҳ��
		if($ispart==2 && $indir==""){
			if( is_file($this->baseDir."/".$defaultname) ) @unlink($this->baseDir."/".$defaultname);
		}
		
		@reset($this->idArray);
		$this->idCounter = 0;
		
		return true;
	}
	//---------------------------
	//---- ɾ��ָ��Ŀ¼�������ļ�
	//---------------------------
	function RmDirFile($indir)
	{
   		if(!file_exists($indir)) return;
   		$dh = dir($indir);
   		while($file = $dh->read()) {
      	if($file == "." || $file == "..") continue;
      	else if(is_file("$indir/$file")) @unlink("$indir/$file");
     	 	else{
         		$this->RmDirFile("$indir/$file");
      	}
      	if(is_dir("$indir/$file")){
         	@rmdir("$indir/$file");
      	}
   		}
   		$dh->close();
   		return(1);
	}
}
?>