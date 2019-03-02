<?php 
if(!isset($cfg_registerGlobals)){ require_once(dirname(__FILE__)."/../../include/config_base.php"); }
//获得是否推荐的表述
//---------------------------------
function IsCommendArchives($iscommend)
{
  if($iscommend==5) return "加粗";
  else if($iscommend==11) return "推荐";
  else if($iscommend==16) return "推荐加粗";
  else return "无";
}
//获得推荐的标题
//---------------------------------
function GetCommendTitle($title,$iscommend)
{
	if($iscommend==5) return "<b>$title</b>";
  else if($iscommend==11) return "$title<font color='red'>(推荐)</font>";
  else if($iscommend==16) return "<b>$title<font color='red'>(推荐)</font></b>";
  else return "$title";
}
//更换颜色
//--------------------
$GLOBALS['RndTrunID'] = 1;
function GetColor($color1,$color2)
{
	$GLOBALS['RndTrunID']++;
	if($GLOBALS['RndTrunID']%2==0) return $color1;
	else return $color2;
}

//检查图片是否存在
//-----------------------
function CheckPic($picname)
{
	if($picname!="") return $picname;
	else return "img/dfpic.gif";
}
//判断内容是否生成HTML
//-----------------------
function IsHtmlArchives($ismake)
{
	if($ismake==1) return "已生成";
	else if($ismake==-1) return "仅动态";
	else return "<font color='red'>未生成</font>";
}
//获得内容的限定级别名称
//-------------------------
function GetRankName($arcrank)
{
	global $arcArray;
	if(!is_array($arcArray)){
		$dsql = new DedeSql(false);
		$dsql->SetQuery("Select * from #@__arcrank");
		$dsql->Execute();
		while($row = $dsql->GetObject()){ $arcArray[$row->rank]=$row->membername; }
		$dsql->Close();
	}
	if(isset($arcArray[$arcrank])) return $arcArray[$arcrank];
	else return "不限";
}
//判断内容是否为图片文章
//----------------------
function IsPicArchives($picname)
{
	if($picname!="") return "<font color='red'>(图)</font>";
	else return "";
}
?>
