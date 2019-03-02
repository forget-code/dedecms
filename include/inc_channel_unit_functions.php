<?php 
//------------------------------------------------
//���ļ��������漰�ĵ����б��ȡ����������ļ�
//------------------------------------------------
//����һЩ���ñ���
$PubFields['phpurl'] = $cfg_mainsite.$cfg_plus_dir;
$PubFields['indexurl'] = $cfg_mainsite.$cfg_indexurl;
$PubFields['templeturl'] = $cfg_mainsite.$cfg_templets_dir;
$PubFields['memberurl'] = $cfg_mainsite.$cfg_member_dir;
$PubFields['specurl'] = $cfg_mainsite.$cfg_special;
$PubFields['indexname'] = $cfg_indexname;
$PubFields['powerby'] = $cfg_powerby;
$PubFields['webname'] = $cfg_webname;
//----------------------------------
//���Ǳ�ʾ�����Flash�ĵȼ�
//----------------------------------
function GetRankStar($rank)
{
	$nstar = "";
	for($i=1;$i<=$rank;$i++){
		$nstar .= "��";
	}
	for($i;$i<=5;$i++){
		$nstar .= "��";
	}
	return $nstar;
}
//-----------------------------
//���������ַ
//----------------------------
function GetFileUrl(
          $aid,$typeid,$timetag,$title,$ismake=0,$rank=0,
          $namerule="",$artdir="",$money=0,$aburl=false,$siteurl="")
{
	if($rank!=0||$ismake==-1||$typeid==0||$money>0) //��̬����
	{ return $GLOBALS['cfg_plus_dir']."/view.php?aid=$aid";}
	else
	{
		$articleRule = $namerule;
		$articleDir = MfTypedir($artdir);
		if($namerule=="") $articleRule = $GLOBALS['cfg_df_namerule'];
		if($artdir=="") $articleDir  = $GLOBALS['cfg_cmspath'].$GLOBALS['cfg_arcdir'];
		$dtime = GetDateMk($timetag);
		$articleRule = strtolower($articleRule);
		list($y,$m,$d) = explode("-",$dtime);
		
		$articleRule = str_replace("{typedir}",$articleDir,$articleRule);
		$articleRule = str_replace("{y}",$y,$articleRule);
		$articleRule = str_replace("{m}",$m,$articleRule);
		$articleRule = str_replace("{d}",$d,$articleRule);
		$articleRule = str_replace("{timestamp}",$timetag,$articleRule);
		$articleRule = str_replace("{aid}",$aid,$articleRule);
		$articleRule = str_replace("{cc}",dd2char($m.$d.$aid.$y),$articleRule);
		if(ereg('{p',$articleRule)){
		  $articleRule = str_replace("{pinyin}",GetPinyin($title)."_".$aid,$articleRule);
		  $articleRule = str_replace("{py}",GetPinyin($title,1)."_".$aid,$articleRule);
		}
		
		$articleUrl = "/".ereg_replace("^/","",$articleRule);
		
		//�Ƿ�ǿ��ʹ�þ�����ַ
		if($aburl && $GLOBALS['cfg_multi_site']=='��'){
			if($siteurl=="") $siteurl = $GLOBALS["cfg_basehost"];
			$articleUrl = $siteurl.$articleUrl;
		}
		
		return $articleUrl;
	}
}
//������ļ���ַ
//���������Զ�����Ŀ¼
function GetFileNewName(
         $aid,$typeid,$timetag,$title,$ismake=0,$rank=0,
         $namerule="",$artdir="",$money=0,$siterefer="",
         $sitepath="",$moresite="",$siteurl="")
{
	if($rank!=0||$ismake==-1||$typeid==0||$money>0){ //��̬����
		return $GLOBALS['cfg_plus_dir']."/view.php?aid=$aid";
	}
	else
	{
		 $articleUrl = GetFileUrl(
		               $aid,$typeid,$timetag,$title,$ismake,$rank,
		               $namerule,$artdir,$money);
		 $slen = strlen($articleUrl)-1;
		 for($i=$slen;$i>=0;$i--){
		  if($articleUrl[$i]=="/"){ $subpos = $i; break; }
		 }
		 $okdir = substr($articleUrl,0,$subpos);
		 CreateDir($okdir,$siterefer,$sitepath);
	}
	return $articleUrl;
}
//--------------------------
//���ָ����Ŀ��URL����
//����ʹ�÷����ļ��͵���ҳ��������ǿ��ʹ��Ĭ��ҳ����
//-------------------------
function GetTypeUrl($typeid,$typedir,$isdefault,$defaultname,$ispart,$namerule2,$siteurl="")
{
	$typedir = eregi_replace("\{cmspath\}",$GLOBALS['cfg_cmspath'],$typedir);
	if($isdefault==-1)
	{ $reurl = $GLOBALS["cfg_plus_dir"]."/list.php?tid=".$typeid; }
	else if($ispart>0)
	{ $reurl = "$typedir/".$defaultname; }
	else{
		if($isdefault==0){
			$reurl = $typedir."/".str_replace("{page}","1",$namerule2);
			$reurl = str_replace("{tid}",$typeid,$reurl); 
			$reurl = str_replace("{typedir}",$typedir,$reurl); 
		}
		else $reurl = "$typedir/".$defaultname;
	}
	$reurl = ereg_replace("/{1,}","/",$reurl);
	
	if($GLOBALS['cfg_multi_site']=='��'){
		if($siteurl=="") $siteurl = $GLOBALS["cfg_basehost"];
		if($siteurl!="abc") $reurl = $siteurl.$reurl;
	}
	
	return $reurl;
}

//ħ�����������ڻ�ȡ�����ɱ��ֵ
//------------------------
function MagicVar($v1,$v2)
{
  if($GLOBALS['autoindex']%2==0) return $v1;
  else return $v2;
}

//��ȡ�ϼ�ID�б�
$pTypeArrays = Array();
function GetParentIDS($tid,$dsql)
{
	$GLOBALS['pTypeArrays'][] = $tid;
	$dbrow = $dsql->GetOne("Select ID,reID From #@__arctype where ID='$tid' ");
	if(!is_array($dbrow) || $dbrow['reID']==0){
		return $GLOBALS['pTypeArrays'];
	}else{
		return GetParentIDS($dbrow['reID'],$dsql);
  }
}
$idArrary = "";
// ������ĳ��Ŀ��ص��¼�Ŀ¼����ĿID�б�(ɾ����Ŀ������ʱ����)
function TypeGetSunTypes($ID,$dsql,$channel=0)
{
		if($ID!=0) $GLOBALS['idArray'][$ID] = $ID;
		$fid = $ID;
	  if($channel!=0) $csql = " And channeltype=$channel ";
	  else $csql = "";
		$dsql->SetQuery("Select ID From #@__arctype where reID=$ID $csql");
		$dsql->Execute("gs".$fid);
		while($row=$dsql->GetObject("gs".$fid)){
			TypeGetSunTypes($row->ID,$dsql,$channel);
		}
		return $GLOBALS['idArray'];
}
//���ĳID���¼�ID(��������)��SQL��䡰($tb.typeid=id1 or $tb.typeid=id2...)��
function TypeGetSunID($ID,$dsql,$tb="#@__archives",$channel=0)
{
		$GLOBALS['idArray'] = "";
		TypeGetSunTypes($ID,$dsql,$channel);
		$rquery = "";
		foreach($GLOBALS['idArray'] as $k=>$v){
			if($tb!="")
			{
			  if($rquery!="") $rquery .= " Or ".$tb.".typeid='$k' ";
			  else      $rquery .= "    ".$tb.".typeid='$k' ";
		  }
		  else
		  {
		  	if($rquery!="") $rquery .= " Or typeid='$k' ";
			  else      $rquery .= "    typeid='$k' ";
		  }
		}
		return " (".$rquery.") ";
}
//��ĿĿ¼����
function MfTypedir($typedir)
{
  $typedir = eregi_replace("{cmspath}",$GLOBALS['cfg_cmspath'],$typedir);
  $typedir = ereg_replace("/{1,}","/",$typedir);
  return $typedir;
}
//ģ��Ŀ¼����
function MfTemplet($tmpdir)
{
  $tmpdir = eregi_replace("{style}",$GLOBALS['cfg_df_style'],$tmpdir);
  $tmpdir = ereg_replace("/{1,}","/",$tmpdir);
  return $tmpdir;
}
//��ȡ��վ���������Źؼ���
function GetHotKeywords($dsql,$num=8,$nday=365,$klen=16,$orderby='count'){
	global $cfg_phpurl;
	$nowtime = mytime();
	$num = ereg_replace("[^0-9]","",$num);
	$nday = ereg_replace("[^0-9]","",$nday);
	$klen = ereg_replace("[^0-9]","",$klen);
	if(empty($nday)) $nday = 365;
	if(empty($num)) $num = 6;
	if(empty($klen)) $klen = 16;
	$klen = $klen+1;
	$mintime = $nowtime - ($nday * 24 * 3600);
	if(empty($orderby)) $orderby = 'count';
	$dsql->SetQuery("Select keyword From #@__search_keywords where lasttime>$mintime And length(keyword)<$klen order by $orderby desc limit 0,$num");
  $dsql->Execute('hw');
  $hotword = "";
  while($row=$dsql->GetArray('hw')){
 		 $hotword .= "��<a href='".$cfg_phpurl."/search.php?keyword=".urlencode($row['keyword'])."&searchtype=titlekeyword' target='_self'><u>".$row['keyword']."</u></a> ";
 	}
 	return $hotword;
}
//
function FormatScript($atme){
	if($atme=="&nbsp;") return "";
	else return $atme;
}
//------------------------------
//��������б����ַ
//------------------------------
function GetFreeListUrl($lid,$namerule,$listdir,$defaultpage,$nodefault){
	$listdir = str_replace('{cmspath}',$GLOBALS['cfg_cmspath'],$listdir);
	if($nodefault==1){
	  $okfile = str_replace('{page}','1',$namerule);
	  $okfile = str_replace('{listid}',$lid,$okfile);
	  $okfile = str_replace('{listdir}',$listdir,$okfile);
  }else{
  	$okfile = $listdir.'/'.$defaultpage;
  }
	$okfile = str_replace("\\","/",$okfile);
	$trueFile = $GLOBALS['cfg_basedir'].$okfile; 
	if(!file_exists($trueFile)){
		 $okfile = $GLOBALS['cfg_phpurl']."/freelist.php?lid=$lid";
	}
	return $okfile;
}
//----------
//�ж�ͼƬ������
function CkLitImageView($imgsrc,$imgwidth){
	$imgsrc = trim($imgsrc);
	if(!empty($imgsrc) && eregi('^http',$imgsrc)){
		 $imgsrc = $cfg_mainsite.$imgsrc;
	}
	if(!empty($imgsrc) && !eregi("img/dfpic\.gif",$imgsrc)){
		return "<img src='".$imgsrc."' width=80 align=left>";
	}
	return "";
}
//----------
//ʹ�þ�����ַ
function Gmapurl($gurl){
	if(!eregi("http://",$gurl)) return $GLOBALS['cfg_basehost'].$gurl;
	else return $gurl;
}
?>