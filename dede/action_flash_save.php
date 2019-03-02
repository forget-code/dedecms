<?
require_once(dirname(__FILE__)."/config.php");
require_once(dirname(__FILE__)."/../include/inc_photograph.php");
require_once(dirname(__FILE__)."/../include/pub_oxwindow.php");
require_once(dirname(__FILE__)."/inc/inc_archives_functions.php");

if(!isset($iscommend)) $iscommend = 0;
if(!isset($ispic)) $ispic = 0;
if(!isset($isbold)) $isbold = 0;
if(!isset($seltypeid)) $seltypeid = 0;
if(empty($rmflash)) $rmflash="";

if(empty($channelid)){
	ShowMsg("�ĵ�Ϊ��ָ�������ͣ���������������ʱ�Ƿ�Ϸ���","-1");
	exit();
}

//�Ա�������ݽ��д���
//--------------------------------
$iscommend = $iscommend + $isbold;

$pubdate = GetMkTime($pubdate);
$senddate = time();
$sortrank = AddDay($senddate,$sortup);

if($ishtml==0) $ismake = -1;
else $ismake = 0;

if($typeid==0 && $seltypeid>0) $typeid = $seltypeid;

if($typeid==""||$typeid==0)
{
	ShowMsg('��������Ŀ����ѡ��','-1');
	exit();
}

$title = cn_substr($title,60);
$color =  cn_substr($color,10);
$writer =  cn_substr($writer,30);
$source = cn_substr($source,50);
$description = cn_substr($description,250);
if($keywords!="") $keywords = trim(cn_substr($keywords,50)." ");
if($cuserLogin->getUserRank() < 5){ $arcrank = -1; }

//�����ϴ�������ͼ
//ͼƬ�ļ������ķ�ʽΪ"/������/ƴ�����׵ĺ�6���ַ�+��ĿID+˳��ID+'.jpg'"
//���˳��������һǧ���Ż��п��ܳ����ظ�
//------------------------------------------
if(is_uploaded_file($litpic))
{
  $istype = 0;
  $sparr = Array("image/pjpeg","image/jpeg","image/gif","image/png");
  $litpic_type = strtolower(trim($litpic_type));
  if(!in_array($litpic_type,$sparr)){
		ShowMsg("�ϴ���ͼƬ��ʽ������ʹ��JPEG��GIF��PNG��ʽ������һ�֣�","-1");
		exit();
	}
  $savepath = $ddcfg_image_dir."/".str_replace("-","",GetDateMk($pubdate));
  CreateDir($savepath);
  $rname = GetPinyin($title,1,0);
  $rndname = substr($rname,strlen($rname)-6,6).$typeid;
  $fullUrl = $savepath."/".$rndname;
  $spdd = 1;
  while(true){
  	if(!file_exists($cfg_basedir.$fullUrl."-".$spdd.".jpg")||$spdd>1000) break;
  	$spdd++;
  }
  $fullUrl = $fullUrl."-".$spdd.".jpg";
  move_uploaded_file($litpic,$cfg_basedir.$fullUrl);
	@unlink($litpic);
	$litpic = $fullUrl;
	ImageResize($cfg_basedir.$fullUrl,$cfg_ddimg_width,$cfg_ddimg_height);
	$litpic = $fullUrl;
}
else{
	if(!empty($picname)) $litpic = $picname;
}

$adminID = $cuserLogin->getUserID();

$filesize = $filesize.$unit;
$playtime = "$tm �� $ts ��"; 
$width  = GetAlabNum($width);
$height = GetAlabNum($height);
//$flashurl = "";

//����Զ�̵�Flash
//------------------
if(empty($downremote)) $downremote = 0;

//ֱ�Ӵ�Զ��ճ��
if(eregi("embed",$remoteflash)){
	$remoteflash = stripslashes($remoteflash);
	require_once(dirname(__FILE__)."/../include/pub_dedehtml2.php");
	$dml = new DedeHtml2();
	$dml->GetLinkType = "media";
	$dml->SetSource($remoteflash,"",false);
	$marr = $dml->Medias;
	$rmfalsh = "";
	if(!is_array($marr)) $rmfalsh = "";
	else{
		if(count($marr)==1)
		{
			foreach($marr as $k=>$v){
			  $rmfalsh = $k;
			  break;
		  }
		}
		else
		{
			foreach($marr as $k=>$v){
			  $rmfalsh = $k;
			  if(GetAlabNum($dml->MediaInfos[$rmfalsh][0])>300&&
			  GetAlabNum($dml->MediaInfos[$rmfalsh][1])>250)
			  { break; }
		  }
		}
		$width  = GetAlabNum($dml->MediaInfos[$rmfalsh][0]);
		$height = GetAlabNum($dml->MediaInfos[$rmfalsh][1]);
	} 
	$dml->Clear();
	if($isUrlOpen && $downremote==1) $rmflash = GetRemoteFlash($rmfalsh,$adminID);
}
//Flash Url ΪԶ�̵�ַ
else if(eregi("^http://",$flashurl) 
  && !eregi($cfg_basehost,$flashurl) && $downremote==1)
{
	if($isUrlOpen) $rmflash = GetRemoteFlash($flashurl,$adminID);
}

if($width==0)  $width  = "500";
if($height==0) $height = "350";
if($rmflash!="") $flashurl = $rmflash;

if($flashurl==""){
	ShowMsg("Flash��ַ����ȷ����Զ�̲ɼ�����","-1");
	exit();
}

//������������
//----------------------------------
$inQuery = "INSERT INTO #@__archives(
typeid,typeid2,sortrank,iscommend,ismake,channel,
arcrank,click,money,title,color,writer,source,litpic,
pubdate,senddate,adminID,memberID,description,keywords) 
VALUES ('$typeid','$typeid2','$sortrank','$iscommend','$ismake','$channelid',
'$arcrank','0','$money','$title','$color','$writer','$source','$litpic',
'$pubdate','$senddate','$adminID','0','$description',' $keywords ');";
$dsql = new DedeSql();
$dsql->SetQuery($inQuery);
if(!$dsql->ExecuteNoneQuery()){
	$dsql->Close();
	ShowMsg("�����ݱ��浽���ݿ�archives��ʱ�������飡","-1");
	exit();
}

//���븽�ӱ�
//----------------------------------
$arcID = $dsql->GetLastID();
$query = "
INSERT INTO #@__addonflash(aid,typeid,filesize,playtime,flashtype,flashrank,width,height,flashurl) 
VALUES ('$arcID','$typeid','$filesize','$playtime','$flashtype','$flashrank','$width','$height','$flashurl');
";

$dsql->SetQuery($query);
if(!$dsql->ExecuteNoneQuery()){
	$dsql->SetQuery("Delete From #@__archives where ID='$arcID'");
	$dsql->ExecuteNoneQuery();
	$dsql->Close();
	ShowMsg("�����ݱ��浽���ݿ⸽�ӱ� addonflash ʱ��������ԭ��","-1");
	exit();
}
$dsql->Close();

//����HTML
//---------------------------------

$artUrl = MakeArt($arcID,true);
if($artUrl=="") $artUrl = $cfg_plus_dir."/view.php?aid=$arcID";

//---------------------------------
//���سɹ���Ϣ
//----------------------------------

$msg = "
������ѡ����ĺ���������
<a href='flash_add.php?cid=$typeid'><u>��������Flash��Ʒ</u></a>
&nbsp;&nbsp;
<a href='$artUrl' target='_blank'><u>�鿴�ĵ�</u></a>
&nbsp;&nbsp;
<a href='catalog_do.php?cid=$typeid&dopost=listArchives'><u>�ѷ���Flash����</u></a>
&nbsp;&nbsp;
<a href='catalog_main.php'><u>��վ��Ŀ����</u></a>
";

$wintitle = "�ɹ�����һ��Flash��Ʒ��";
$wecome_info = "���¹���::����Flash";
$win = new OxWindow();
$win->AddTitle("�ɹ�������Ʒ��");
$win->AddMsgItem($msg);
$winform = $win->GetWindow("hand","&nbsp;",false);
$win->Display();
?>