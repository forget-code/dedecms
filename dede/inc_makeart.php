<?
require_once("inc_typelink.php");
require_once("inc_dedetag.php");
//--------��ҳ�����������´���------------------------------------------
class makeArt
{
	var $artFileName="";
	var $makeType="";
	var $typeLink="";
	var $makePart="";
	var $con="";
	var $artDir="";
	function makeArt($mtype=1)
	{
		global $art_dir;
		$this->makeType = $mtype;
		//���ѡ��1����makeArtDone($ID)�����ļ��������ļ���
		//�������makeArtDone($ID)����Ч��ֻ�ܵ���makeArtView($ID)
		$this->typeLink = new TypeLink();
		$this->con = connectMySql();
		$this->artDir = $art_dir;
	}
	//
	//���������class modPage ���ͬ������
	//
	function GetFullName($hname="Ĭ��ģ��",$typename="����",$channeltype="1")
	{
		global $base_dir;
		global $mod_dir;
		return $base_dir.$mod_dir."/$hname/".$channeltype."/".$typename.".htm";
	}
	function makeArtDone($ID)
	{
		global $art_shortname;
		global $base_dir;
		global $mod_dir;
		global $art_dir;
		global $tag_start_char;
		global $tag_end_char;
		if($this->makeType!=1)
		{
			$this->makeArtView($ID,0);
			return "";
		}
		if($this->makeType!=1) return "";
		$rs=mysql_query("Select dede_art.*,dede_arttype.typedir,dede_arttype.channeltype,dede_arttype.modname From dede_art left join dede_arttype on dede_art.typeid=dede_arttype.ID where dede_art.ID=$ID",$this->con);
		$row = mysql_fetch_object($rs);
		$rank = $row->rank;
		$this->typeLink->SetTypeID($row->typeid);
		//ֻ�в��ֵȼ����ҳ���ר����ܴ���ΪHTMLҳ��
		if($rank!=0) return "";
		if($row->spec > 0)
		{
			//ʵ���Ϲ����б��в������ר�����£�������Ļ��
			//ר������
			//$mk = new MakeSpec();
			//$makeok = $mk->MakeMode($row->spec);
			return "";
		}
		$modfile = $this->GetFullName($row->modname,"����",$row->channeltype);
		if(!file_exists($modfile)) $modfile = $this->GetFullName("Ĭ��ģ��","����",$row->channeltype);
		$ctp = new DedeTagParse();
		$ctp->TagStartWord = $tag_start_char;
		$ctp->TagEndWord = $tag_end_char;
		$ctp->LoadTemplate($modfile);
		//{dede:field name='name'/}��ӳ�����
		//�����´����� field �Ŀ�ѡֵΪ��title,stime,source,body,click,id,position
		$title = $row->title;
		$stime = $row->stime;
		$source = $row->source;
		$body = $row->body;
		$click = $row->click;
		$writer = $row->writer;
		$id = $row->ID;
		$msg = $row->msg;
		$position = $this->typeLink->getTypeLink();
		/////////////////////////
		$filename = $this->typeLink->getFileNewName($row->ID,$row->typedir,$row->stime,$rank);
		$this->artFileName = $filename.$art_shortname;
		$bodys = split("#p#",$body);
		$bdd = count($bodys); 
		if($bdd==1)
		{
			$fullfilename = $base_dir.$filename.$art_shortname;
			for($TagID=0;$TagID<=$ctp->Count;$TagID++)
			{
				if($ctp->CTags[$TagID]->TagName=="field"&&$ctp->CTags[$TagID]->IsReplace==FALSE)
				{
					if($ctp->CTags[$TagID]->IsAttribute("name"))
							if(isset(${$ctp->CTags[$TagID]->GetAtt("name")})&&$ctp->CTags[$TagID]->GetAtt("name")!="")
								$ctp->ReplaceTag($TagID,${$ctp->CTags[$TagID]->GetAtt("name")});
				}
				else
					$this->replaceTag($ctp,$ctp->CTags[$TagID],$row,$TagID);
			}
			$ctp->SaveTo($fullfilename);
			unset($ctp);
		}
		else
		{
			$ntitle = $title;
			$ctp = new DedeTagParse();
			$ctp->TagStartWord = $tag_start_char;
			$ctp->TagEndWord = $tag_end_char;
			$ctp->LoadTemplate($modfile);
			for($r=0;$r<$bdd;$r++)
			{
				$ctp->ResetSource();
				if($r==0) $fullfilename = $base_dir.$filename.$art_shortname;
				else $fullfilename = $base_dir.$filename."_".$r.$art_shortname;
				$body = $bodys[$r];
				$body .= "<br><table align='center'><tr><td bgcolor='#EBEBE4'>&nbsp;&nbsp;".$this->getPage($bdd,$r,$id)."&nbsp;&nbsp;</td></tr></table>\r\n";
				$np = $r+1;
				$title = $ntitle."(".$np.")";
				////////////////////////////
				for($TagID=0;$TagID<=$ctp->Count;$TagID++)
				{
					if($ctp->CTags[$TagID]->TagName=="field"&&$ctp->CTags[$TagID]->IsReplace==FALSE)
					{
						if($ctp->CTags[$TagID]->IsAttribute("name"))
							if(isset(${$ctp->CTags[$TagID]->GetAtt("name")})&&$ctp->CTags[$TagID]->GetAtt("name")!="")
								$ctp->ReplaceTag($TagID,${$ctp->CTags[$TagID]->GetAtt("name")});
					}
					else
						$this->replaceTag($ctp,$ctp->CTags[$TagID],$row,$TagID);
				}
				$ctp->SaveTo($fullfilename);
		  }//��ҳѭ��
		  unset($ctp);
	  }//�ж��Ƿ��ҳ
	  mysql_query("Update dede_art set ismake=1 where ID=$id",$this->con);
	  return $this->artFileName;
	}
	//
	//--�������·�ҳ�б�---------
	//
	function getPage($allPage,$nowPage,$aid)
	{
		global $art_shortname;	
		$PageList = "��".$allPage."ҳ: ";
		$nPage = $nowPage-1;
		$lPage = $nowPage+1;
		$kaid = $aid;
		$aid = $aid."_";
		if($nPage==0) $PageList.="<a href='$kaid$art_shortname'>��һҳ</a> ";
		else if($nPage!=-1) $PageList.="<a href='$aid$nPage$art_shortname'>��һҳ</a> ";
		for($i=0;$i<$allPage;$i++)
		{
			if($i==0)
			{
			if($nowPage!=$i) $PageList.="<a href='$kaid$art_shortname'>[1]</a> ";
			else $PageList.="1 ";
			}
			else
			{
			$n = $i+1;
			if($nowPage!=$i) $PageList.="<a href='$aid$i$art_shortname'>[".$n."]</a> ";
			else $PageList.="$n ";
			}
		}
		if($lPage!=$allPage) $PageList.="<a href='$aid$lPage$art_shortname'>��һҳ</a> ";
		return $PageList;
	}
	//
	/////////////��̬�鿴������ʽ//////////
	//
	function makeArtView($ID,$pageNo=0)
	{
		global $art_shortname;
		global $base_dir;
		global $mod_dir;
		global $tag_start_char;
		global $tag_end_char;
		$rs=mysql_query("Select dede_art.*,dede_arttype.typedir,dede_arttype.channeltype,dede_arttype.modname From dede_art left join dede_arttype on dede_art.typeid=dede_arttype.ID where dede_art.ID=$ID",$this->con);
		$row = mysql_fetch_object($rs);
		$this->typeLink->SetTypeID($row->typeid);
		$rank = $row->rank;//�ȼ����ƴ���Body
		$modfile = $this->GetFullName($row->modname,"����",$row->channeltype);
		if(!file_exists($modfile)) $modfile = $this->GetFullName("Ĭ��ģ��","����",$row->channeltype);
		$ctp = new DedeTagParse();
		$ctp->TagStartWord = $tag_start_char;
		$ctp->TagEndWord = $tag_end_char;
		$ctp->LoadTemplate($modfile);
		//{dede:art field='name'/}��ӳ�����
		//���磺{dede:art field='title'/} ����������ֵΪ��$title
		//�������´����� field �Ŀ�ѡֵΪ��title,stime,source,body,click,id,position
		$title = $row->title;
		$stime = $row->stime;
		$source = $row->source;
		$body = $row->body;
		$click = $row->click;
		$writer = $row->writer;
		$id = $row->ID;
		$msg = $row->msg;
		$position = $this->typeLink->getTypeLink();
		/////////////////////////
		$filename = $this->typeLink->getFileNewName($row->ID,$row->typedir,$row->stime,$rank);
		$this->artFileName = $filename.$art_shortname;
		$bodys = split("#p#",$body);
		$bdd = count($bodys); 
		if($bdd==1)
		{
			$fullfilename = $base_dir.$filename.$art_shortname;
			for($TagID=0;$TagID<=$ctp->Count;$TagID++)
			{
				if($ctp->CTags[$TagID]->TagName=="field"&&$ctp->CTags[$TagID]->IsReplace==FALSE)
				{
					if($ctp->CTags[$TagID]->IsAttribute("name"))
							if(isset(${$ctp->CTags[$TagID]->GetAtt("name")})&&$ctp->CTags[$TagID]->GetAtt("name")!="")
								$ctp->ReplaceTag($TagID,${$ctp->CTags[$TagID]->GetAtt("name")});
				}
				else
					$this->replaceTag($ctp,$ctp->CTags[$TagID],$row,$TagID);
			}
			return $ctp->GetResult();
			unset($ctp);
		}
		else
		{
			$ntitle = $title;
			$ctp = new DedeTagParse();
			$ctp->TagStartWord = $tag_start_char;
			$ctp->TagEndWord = $tag_end_char;
			$ctp->LoadTemplate($modfile);
			$body = $bodys[$pageNo];
			$body .= "<br><table align='center'><tr><td bgcolor='#EBEBE4'>&nbsp;&nbsp;".$this->getPageView($bdd,$pageNo,$id)."&nbsp;&nbsp;</td></tr></table>\r\n";
			$np = $pageNo+1;
			$title = $ntitle."(".$np.")";
			////////////////////////////
			for($TagID=0;$TagID<=$ctp->Count;$TagID++)
			{
				if($ctp->CTags[$TagID]->TagName=="field"&&$ctp->CTags[$TagID]->IsReplace==FALSE)
				{
					if($ctp->CTags[$TagID]->IsAttribute("name"))
						if(isset(${$ctp->CTags[$TagID]->GetAtt("name")})&&$ctp->CTags[$TagID]->GetAtt("name")!="")
							$ctp->ReplaceTag($TagID,${$ctp->CTags[$TagID]->GetAtt("name")});
				}
				else
					$this->replaceTag($ctp,$ctp->CTags[$TagID],$row,$TagID);
			}
		  return $ctp->GetResult();
		  unset($ctp);
	  }//�ж��Ƿ��ҳ
	}
	//
	//--�������·�ҳ�б�,��̬ҳ��---------
	//
	function getPageView($allPage,$nowPage,$aid)
	{	
		$PageList = "��".$allPage."ҳ: ";
		$nPage = $nowPage-1;
		$lPage = $nowPage+1;
		if($nPage==0) $PageList.="<a href='viewart.php?ID=$aid'>��һҳ</a> ";
		else $PageList.="<a href='viewart.php?ID=$aid&page=$nPage'>��һҳ</a> ";
		for($i=0;$i<$allPage;$i++)
		{
			if($i==0)
			{
			if($nowPage!=$i) $PageList.="<a href='viewart.php?ID=$aid'>[1]</a> ";
			else $PageList.="1 ";
			}
			else
			{
			$n = $i+1;
			if($nowPage!=$i) $PageList.="<a href='viewart.php?ID=$aid&page=$i'>[".$n."]</a> ";
			else $PageList.="$n ";
			}
		}
		if($lPage!=$allPage) $PageList.="<a href='viewart.php?ID=$aid&page=$lPage'>��һҳ</a> ";
		return $PageList;
	}
	//
	//������������б�
	//
	function getLikeList($typeid=0,$artID=0,$likeID="",$titlelen=24,$line=6,$modstr="")
	{
		if($titlelen=="") $titlelen=24;
		if($line=="") $line=6;
		$likeList = "";
		$modstr = trim($modstr);
		if($modstr=="") $modstr="��<a href='~filename~'>~title~</a><br>\r\n";
		$mods = split("~",$modstr);
		$m = count($mods);
		if($likeID!="")
		{
			$ids = split("`",$likeID);
			$j = count($ids);
			$idsql = "(";
			for($i=0;$i<$j;$i++)
			{
				if($ids[$i]!=$ID)
					if($i<$j-1) $idsql .= " dede_art.ID=".$ids[$i]." Or";
			}
			$idsql = ereg_replace(" Or$","",$idsql).")";
			$idsql = " And ($idsql)";
	    }
	    else
	    {
	     	$idsql = " And ".$this->typeLink->getSunID($typeid);
	    }
	    $squery = "select dede_art.ID,dede_art.rank,dede_art.title,dede_art.picname,dede_art.stime,dede_arttype.typedir from dede_art left join dede_arttype on dede_art.typeid=dede_arttype.ID where dede_art.rank>=0 And dede_art.ID<$artID $idsql order by dede_art.ID desc limit 0,$line";
		$rs = mysql_query($squery,$this->con);
		while($row = mysql_fetch_object($rs))
		{
			$filename = $this->typeLink->GetFileName($row->ID,$row->typedir,$row->stime,$row->rank);
			$row->title = cn_substr($row->title,$titlelen);
			if($modstr=="") $likeList.="��<a href='".$filename."'>$title</a><br>\r\n";
			else
			{
				for($i=0;$i<$m;$i++)
				{
					if($i%2==1) 
					{
						if(isset($row->$mods[$i])) $likeList.=$row->$mods[$i];
						else if($mods[$i]=="filename") $likeList.=$filename;
					}
					else $likeList.=$mods[$i];
				}
			}	
		}
		return $likeList;
	}
	//
    //���һ�����������б�
    //
    function GetArtList($typeid=0,$artid=0,$row=10,$titlelen=30,$ordertype="new",$keyword="",$innertext="")
    {
   		global $imgview_dir;
   		global $art_shortname;
   		if($typeid=="") $typeid=0;
		if($row=="") $row=10;
		if($titlelen=="") $titlelen=30;
		if($artid=="") $artid=0;
		
		if($ordertype=="") $ordertype="new";
		else $ordertype=strtolower($ordertype);
		
		$keyword = trim($keyword);
		if($innertext=="") $innertext="��<a href='~filename~'>~title~</a><br>";
        $bodys = split("~",$innertext);
		$dsnum = count($bodys);
        ///////////////////////////////////
		//����ͬ�������SQL����������ʽ
		$orwhere = "";
		$ordersql = "";
		if($ordertype=="hot") $ordersql="order by dede_art.click desc";
        else if($ordertype=="commend") $ordersql="And dede_art.redtitle>0 order by dede_art.ID desc";
		else $ordersql="order by dede_art.ID desc";
		//���ID
		if($typeid!=0) $orwhere .= "And ".$this->typeLink->GetSunID($typeid);
		//�ؼ���
		if($keyword!="") $orwhere .= " And dede_art.title like '%".$keyword."%' ";
		//////////////
		$query = "Select dede_art.ID,dede_art.title,dede_art.stime,dede_art.rank,dede_art.typeid,dede_art.click,dede_art.picname,dede_arttype.typedir,dede_arttype.typename,dede_arttype.isdefault from dede_art left join dede_arttype on dede_art.typeid=dede_arttype.ID where dede_art.rank>=0 And dede_art.ID<>$artid $orwhere $ordersql limit 0,$row";
		$rs = mysql_query($query,$this->con);
        $artlist = "";
        while($drow=mysql_fetch_object($rs))
        {
            $ID=$drow->ID;
            if($drow->isdefault=="1")
				$typelink = "<a href='".$this->artDir."/".$drow->typedir."'>".$drow->typename."</a>";
			else if($drow->isdefault=="1")
				$typelink = "<a href=".$GLOBALS["art_php_dir"]."'/list.php?id=".$drow->typeid."'>".$drow->typename."</a>";
			else
				$typelink = "<a href='".$this->artDir."/".$drow->typedir."/list_".$drow->typeid."_1'".$art_shortname.">".$drow->typename."</a>";
            $title = cn_substr($drow->title,$titlelen);
            $filename=$this->typeLink->GetFileName($ID,$drow->typedir,$drow->stime,$drow->rank);
            $textlink="<a href='$filename'>$title</a>\r\n";
            $stime = $drow->stime;
            $click = $drow->click;
            $picname = $drow->picname;
            if($picname=="") $picname=$imgview_dir."/defdd.gif";
            for($m=0;$m<$dsnum;$m++)
				if($m%2==1){if(isset(${$bodys[$m]})) $artlist.=${$bodys[$m]};}
				else $artlist.=$bodys[$m];
        }
        return $artlist;
    }
    //
    //�滻ָ����ģ����
    //
	function replaceTag(&$ctp,&$CDTag,&$row,$CDTagID)
	{
		if($CDTag->TagName=="likeart")
		{
			$ctp->ReplaceTag(
				$CDTagID,
				$this->getLikeList(
					$row->typeid,
					$row->ID,
					$row->likeid,
					$CDTag->GetAtt("titlelength"),
					$CDTag->GetAtt("line"),
					$CDTag->InnerText)
			);
		}
		if($CDTag->TagName=="hotart")
		{
			$ctp->ReplaceTag(
				$CDTagID,
				$this->GetArtList(
					$row->typeid,
					$row->ID,
					$CDTag->GetAtt("line"),
					$CDTag->GetAtt("titlelength"),
					"hot",
					"",
					$CDTag->InnerText)
			);
		}
		if($CDTag->TagName=="coolart")
		{
			$ctp->ReplaceTag(
				$CDTagID,
				$this->GetArtList(
					$row->typeid,
					$row->ID,
					$CDTag->GetAtt("line"),
					$CDTag->GetAtt("titlelength"),
					"commend",
					"",
					$CDTag->InnerText)
			);
		}
		if($CDTag->TagName=="channel")
		{
			$ctp->ReplaceTag(
				$CDTagID,
				$this->typeLink->GetChannel($CDTag->GetAtt("type"),$CDTag->InnerText)
			);
		}
	}
}
?>