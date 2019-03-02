<?php 
//��������Ĭ��ֵ
//--------------------------------
function AttDef($oldvar,$nv){
 	if(empty($oldvar)) return $nv;
 	else return $oldvar;
}
//��ȡһ���ĵ��б�
//--------------------------------
function SpGetArcList($dsql,$typeid=0,$row=10,$col=1,$titlelen=30,$infolen=160,
  $imgwidth=120,$imgheight=90,$listtype="all",$orderby="default",$keyword="",$innertext="",
  $tablewidth="100",$arcid=0,$idlist="",$channelid=0,$limit="",$att=0,$order="desc",$subday=0)
  {
		global $PubFields;
		$row = AttDef($row,10);
		$titlelen = AttDef($titlelen,30);
		$infolen = AttDef($infolen,160);
		$imgwidth = AttDef($imgwidth,120);
		$imgheight = AttDef($imgheight,120);
		$listtype = AttDef($listtype,"all");
    $arcid = AttDef($arcid,0);
    $channelid = AttDef($channelid,0);
    $orderby = AttDef($orderby,"default");
    $orderWay = AttDef($order,"desc");
    $subday = AttDef($subday,0);
    $line = $row;
		$orderby=strtolower($orderby);
		$tablewidth = str_replace("%","",$tablewidth);
		if($tablewidth=="") $tablewidth=100;
		if($col=="") $col = 1;
		$colWidth = ceil(100/$col); 
		$tablewidth = $tablewidth."%";
		$colWidth = $colWidth."%";
		$keyword = trim($keyword);
		$innertext = trim($innertext);
		if($innertext=="") $innertext = GetSysTemplets("part_arclist.htm");
		//����ͬ����趨SQL���� ����ʽ
		$orwhere = " arc.arcrank > -1 ";
		//ʱ������(���ڵ�������������¡���������֮��)
		if($subday>0){
			 $limitday = mytime() - ($oneday * 24 * 3600);
			 $orwhere .= " And arc.senddate > $limitday ";
		}
		//�ĵ����Զ�������
		if($att!="") $orwhere .= "And arcatt='$att' ";
		//�ĵ���Ƶ��ģ��
		if($channelid>0 && !eregi("spec",$listtype)) $orwhere .= " And arc.channel = '$channelid' ";
		//�Ƿ�Ϊ�Ƽ��ĵ�
		if(eregi("commend",$listtype)) $orwhere .= " And arc.iscommend > 10  ";
		//�Ƿ�Ϊ������ͼͼƬ�ĵ�
		if(eregi("image",$listtype)) $orwhere .= " And arc.litpic <> ''  ";
		//�Ƿ�Ϊר���ĵ�
		if(eregi("spec",$listtype) || $channelid==-1) $orwhere .= " And arc.channel = -1  ";
    //�Ƿ�ָ�����ID
		if($arcid!=0) $orwhere .= " And arc.ID<>'$arcid' ";
		
		//�ĵ�����ķ�ʽ
		$ordersql = "";
		if($orderby=="hot"||$orderby=="click") $ordersql = " order by arc.click $orderWay";
		else if($orderby=="pubdate") $ordersq = " order by arc.pubdate $orderWay";
		else if($orderby=="sortrank") $ordersq = " order by arc.sortrank $orderWay";
    else if($orderby=="id") $ordersql = "  order by arc.ID $orderWay";
    else if($orderby=="near") $ordersql = " order by ABS(arc.ID - ".$arcid.")";
    else if($orderby=="lastpost") $ordersql = "  order by arc.lastpost $orderWay";
    else if($orderby=="postnum") $ordersql = "  order by arc.postnum $orderWay";
		else $ordersql=" order by arc.senddate $orderWay";
		
		//���ID������������� "," �ֿ�,����ָ���ض���Ŀ
		//------------------------------
		if($typeid!=0)
		{
		  $reids = explode(",",$typeid);
		  $ridnum = count($reids);
		  if($ridnum>1){
			  $tpsql = "";
		    for($i=0;$i<$ridnum;$i++){
				  if($tpsql=="") $tpsql .= " And (".TypeGetSunID($reids[$i],$dsql,'arc');
				  else $tpsql .= " Or ".TypeGetSunID($reids[$i],$dsql,'arc');
		    }
		    $tpsql .= ") ";
		    $orwhere .= $tpsql;
		    unset($tpsql);
		  }
		  else{
			  $orwhere .= " And ".TypeGetSunID($typeid,$dsql,'arc');
		  }
		  unset($reids);
	  }
		//ָ�����ĵ�ID�б�
		//----------------------------------
		if($idlist!="")
		{
			$reids = explode(",",$idlist);
		  $ridnum = count($reids);
		  $idlistSql = "";
		  for($i=0;$i<$ridnum;$i++){
				if($idlistSql=="") $idlistSql .= " And ( arc.ID='".$reids[$i]."' ";
				else $idlistSql .= " Or arc.ID='".$reids[$i]."' ";
		  }
		  $idlistSql .= ") ";
		  $orwhere .= $idlistSql;
		  unset($idlistSql);
		  unset($reids);
		  $row = $ridnum;
		}
		//�ؼ�������
		if($keyword!="")
		{
		  $keywords = explode(",",$keyword);
		  $ridnum = count($keywords);
		  $orwhere .= " And (arc.keywords like '%".trim($keywords[0])." %' ";
		  for($i=1;$i<$ridnum;$i++){
			  if($keywords[$i]!="") $orwhere .= " Or arc.keywords like '%".trim($keywords[$i])." %' ";
		  }
		  $orwhere .= ")";
		  unset($keywords);
	  }
	  $limit = trim(eregi_replace("limit","",$limit));
	  if($limit!="") $limitsql = " limit $limit ";
	  else $limitsql = " limit 0,$line ";
		//////////////
		$query = "Select arc.ID,arc.title,arc.iscommend,arc.color,arc.typeid,arc.ismake,
		arc.description,arc.pubdate,arc.senddate,arc.arcrank,arc.click,arc.money,
		arc.litpic,tp.typedir,tp.typename,tp.isdefault,
		tp.defaultname,tp.namerule,tp.namerule2,tp.ispart,tp.moresite,tp.siteurl
		from #@__archives arc left join #@__arctype tp on arc.typeid=tp.ID
		where $orwhere $ordersql $limitsql";
		 
		$dsql->SetQuery($query);
		$dsql->Execute("al");
    $artlist = "";
    if($col>1) $artlist = "<table width='$tablewidth' border='0' cellspacing='0' cellpadding='0'>\r\n";
    $dtp2 = new DedeTagParse();
    $dtp2->SetNameSpace("field","[","]");
    $dtp2->LoadString($innertext);
    $GLOBALS['autoindex'] = 0;
    for($i=0;$i<$line;$i++)
		{
       if($col>1) $artlist .= "<tr>\r\n";
       for($j=0;$j<$col;$j++)
			 {
         if($col>1) $artlist .= "	<td width='$colWidth'>\r\n";
         if($row = $dsql->GetArray("al"))
         {
           //����һЩ�����ֶ�
           $row['description'] = cn_substr($row['description'],$infolen);
           $row['id'] =  $row['ID'];
           
           if($row['litpic']=="") $row['litpic'] = $PubFields['templeturl']."/img/default.gif";
           $row['picname'] = $row['litpic'];
           $row['arcurl'] = GetFileUrl($row['id'],$row['typeid'],$row['senddate'],
                            $row['title'],$row['ismake'],$row['arcrank'],$row['namerule'],
                            $row['typedir'],$row['money'],true,$row['siteurl']);
           $row['typeurl'] = GetTypeUrl($row['typeid'],MfTypedir($row['typedir']),$row['isdefault'],$row['defaultname'],$row['ispart'],$row['namerule2'],$row['siteurl']);

           $row['info'] = $row['description'];
           $row['filename'] = $row['arcurl'];
           $row['stime'] = GetDateMK($row['pubdate']);
           $row['typelink'] = "<a href='".$row['typeurl']."'>".$row['typename']."</a>";
           $row['image'] = "<img src='".$row['picname']."' border='0' width='$imgwidth' height='$imgheight' alt='".ereg_replace("['><]","",$row['title'])."'>";
           $row['imglink'] = "<a href='".$row['filename']."'>".$row['image']."</a>";
           $row['title'] = cn_substr($row['title'],$titlelen);
           $row['textlink'] = "<a href='".$row['filename']."'>".$row['title']."</a>";
           
           if($row['color']!="") $row['title'] = "<font color='".$row['color']."'>".$row['title']."</font>";
           if($row['iscommend']==5||$row['iscommend']==16) $row['title'] = "<b>".$row['title']."</b>";
           
           $row['phpurl'] = $PubFields['phpurl'];
 		       $row['templeturl'] = $PubFields['templeturl'];
           if(is_array($dtp2->CTags)){
       	      foreach($dtp2->CTags as $k=>$ctag){
       		 	    if(isset($row[$ctag->GetName()])) $dtp2->Assign($k,$row[$ctag->GetName()]);
       		 	    else $dtp2->Assign($k,"");
       	      }
       	      $GLOBALS['autoindex']++;
           }
           $artlist .= $dtp2->GetResult()."\r\n";
         }//if hasRow
         else{
         	 $artlist .= "";
         }
         if($col>1) $artlist .= "	</td>\r\n";
       }//Loop Col
       if($col>1) $i += $col - 1;
       if($col>1) $artlist .= "	</tr>\r\n";
     }//Loop Line
     if($col>1) $artlist .= "	</table>\r\n";
     $dsql->FreeResult("al");
     return $artlist;
}
?>