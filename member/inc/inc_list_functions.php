<?
if(!isset($registerGlobals)){ require_once(dirname(__FILE__)."/../../include/config_base.php"); }
//����Ƿ��Ƽ��ı���
//---------------------------------
function IsCommendArchives($iscommend)
{
  if($iscommend==5) return "�Ӵ�";
  else if($iscommend==11) return "�Ƽ�";
  else if($iscommend==16) return "�Ƽ��Ӵ�";
  else return "��";
}
//����Ƽ��ı���
//---------------------------------
function GetCommendTitle($title,$iscommend)
{
	if($iscommend==5) return "<b>$title</b>";
  else if($iscommend==11) return "$title<font color='red'>(�Ƽ�)</font>";
  else if($iscommend==16) return "<b>$title<font color='red'>(�Ƽ�)</font></b>";
  else return "$title";
}
//������ɫ
//--------------------
$GLOBALS['RndTrunID'] = 1;
function GetColor($color1,$color2)
{
	$GLOBALS['RndTrunID']++;
	if($GLOBALS['RndTrunID']%2==0) return $color1;
	else return $color2;
}

//���ͼƬ�Ƿ����
//-----------------------
function CheckPic($picname)
{
	if($picname!="") return $picname;
	else return "img/dfpic.gif";
}
//�ж������Ƿ�����HTML
//-----------------------
function IsHtmlArchives($ismake)
{
	if($ismake==1) return "������";
	else if($ismake==-1) return "����̬";
	else return "<font color='red'>δ����</font>";
}
//������ݵ��޶���������
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
	else return "����";
}
//�ж������Ƿ�ΪͼƬ����
//----------------------
function IsPicArchives($picname)
{
	if($picname!="") return "<font color='red'>(ͼ)</font>";
	else return "";
}
?>
