<?
require_once(dirname(__FILE__)."/config.php");
require_once(dirname(__FILE__)."/../include/inc_photograph.php");
require_once(dirname(__FILE__)."/../include/pub_oxwindow.php");
require_once(dirname(__FILE__)."/inc/inc_archives_functions.php");
require_once(dirname(__FILE__)."/inc/inc_archives_all.php");

if(!isset($iscommend)) $iscommend = 0;
if(!isset($isbold)) $isbold = 0;
if(!isset($autokey)) $autokey = 0;
if(!isset($remote)) $remote = 0;
if(!isset($dellink)) $dellink = 0;
if(!isset($seltypeid)) $seltypeid = 0;

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
$keywords = cn_substr($keywords,60);
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
if(empty($litpic)) $litpic = "";

if($keywords!="") $keywords = trim(cn_substr($keywords,56))." ";
$adminID = $cuserLogin->getUserID();

//�������ݿ��SQL���
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
$arcID = $dsql->GetLastID();

//----------------------------------
//���������ӱ�����
//----------------------------------
if(empty($dede_addtablename)) $dede_addtablename = "";
if(empty($dede_addonfields)) $dede_addonfields = "";
$addonfields = explode(";",$dede_addonfields);
$inadd_f = "";
$inadd_v = "";
foreach($addonfields as $v)
{
	if($v=="") continue;
	$vs = explode(",",$v);
	if($vs[1]=="htmltext")
	{
		${$vs[0]} = stripslashes(${$vs[0]});
    if($isUrlOpen && $remote==1){
	    ${$vs[0]} = GetCurContent(${$vs[0]});
    }
    //ȥ�������е�վ������
    //------------------------------------
    if($dellink==1){
	    ${$vs[0]} = preg_replace("/(<a[ \t\r\n]{1,}href=[\"']{0,}http:\/\/[^\/]([^>]*)>)|(<\/a>)/isU","",${$vs[0]});
    }
    ${$vs[0]} = addslashes(${$vs[0]});
	}
	else
	{
		${$vs[0]} = GetFieldValue(${$vs[0]},$vs[1]);
	}
	$inadd_f .= ",".$vs[0];
	$inadd_v .= ",'".${$vs[0]}."'";
}

if($dede_addtablename!="" && $addonfields!="")
{
  $dsql->SetQuery("INSERT INTO ".$dede_addtablename."(aid,typeid".$inadd_f.") Values('$arcID','$typeid'".$inadd_v.")");
  if(!$dsql->ExecuteNoneQuery()){
	  $dsql->SetQuery("Delete From #@__archives where ID='$arcID'");
	  $dsql->ExecuteNoneQuery();
	  $dsql->Close();
	  echo "INSERT INTO ".$dede_addtablename."(aid,typeid".$inadd_f.") Values('$arcID','$typeid'".$inadd_v.")";
	  //ShowMsg("�����ݱ��浽���ݿ⸽�ӱ� ".$dede_addtablename." ʱ��������ԭ��","-1");
	  exit();
  }
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
<a href='article_add.php?cid=$typeid'><u>���������ĵ�</u></a>
&nbsp;&nbsp;
<a href='$artUrl' target='_blank'><u>�鿴�ĵ�</u></a>
&nbsp;&nbsp;
<a href='catalog_do.php?cid=$typeid&dopost=listArchives'><u>�ѷ����ĵ�����</u></a>
&nbsp;&nbsp;
<a href='catalog_main.php'><u>��վ��Ŀ����</u></a>
";

$wintitle = "�ɹ������ĵ���";
$wecome_info = "���¹���::�����ĵ�";
$win = new OxWindow();
$win->AddTitle("�ɹ������ĵ���");
$win->AddMsgItem($msg);
$winform = $win->GetWindow("hand","&nbsp;",false);
$win->Display();
?>