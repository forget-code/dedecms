<?
require_once(dirname(__FILE__)."/config.php");
require_once(dirname(__FILE__)."/../include/inc_photograph.php");
require_once(dirname(__FILE__)."/../include/pub_oxwindow.php");
require_once(dirname(__FILE__)."/inc/inc_archives_functions.php");

if(!isset($iscommend)) $iscommend = 0;
if(!isset($ispic)) $ispic = 0;
if(!isset($isbold)) $isbold = 0;
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
$writer =  "";
$source = cn_substr($source,50);
$description = cn_substr($description,250);
if($keywords!="") $keywords = trim(cn_substr($keywords,60))." ";
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
  @move_uploaded_file($litpic,$cfg_basedir.$fullUrl);
	@unlink($litpic);
	$litpic = $fullUrl;
	ImageResize($cfg_basedir.$fullUrl,$cfg_ddimg_width,$cfg_ddimg_height);
	$litpic = $fullUrl;
}
else{
	if(!empty($picname)) $litpic = $picname;
}
if(empty($litpic)) $litpic = "";

$adminID = $cuserLogin->getUserID();

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

//����������ָ����ͼƬ
//------------------------------
$imgurls = "{dede:pagestyle maxwidth='$maxwidth' value='$pagestyle'/}\r\n";
for($i=1;$i<=40;$i++){
	if(isset(${'imgurl'.$i})){
		$iurl = stripslashes(${'imgurl'.$i});
		if(trim($iurl)=="") continue;
		$iinfo = stripslashes(${'imgmsg'.$i});
		$iurl = trim(str_replace($cfg_basehost,"",$iurl));
		if(eregi("^http://",$iurl) && $isUrlOpen) //����Զ��ͼƬ
		{
			$reimgs = "";
			if($isUrlOpen)
			{
				$reimgs = GetRemoteImage($iurl,$adminID);
			  if(is_array($reimgs)){
				  $imgurls .= "{dede:img text='$iinfo' width='".$reimgs[1]."' height='".$reimgs[2]."'} ".$reimgs[0]." {/dede:img}\r\n";
			  }
		  }
		  else
		  {
		  	$imgurl = "{dede:img text='' width='' height=''} ".$iurl." {/dede:img}\r\n";
		  }
		}
		else if($iurl!="")  //վ��ͼƬ
		{
			$imgfile = $cfg_basedir.$iurl;
			if(is_file($imgfile)){
				$info = "";
				$imginfos = GetImageSize($imgfile,$info);
				$imgurls .= "{dede:img text='$iinfo' width='".$imginfos[0]."' height='".$imginfos[1]."'} $iurl {/dede:img}\r\n";
			}
		}
	}
}
$imgurls = addslashes($imgurls);
//���븽�ӱ�
//----------------------------------
$arcID = $dsql->GetLastID();
$query = "
INSERT INTO #@__addonimages(aid,typeid,pagestyle,maxwidth,imgurls) Values('$arcID','$typeid','$pagestyle','$maxwidth','$imgurls');
";
$dsql->SetQuery($query);
if(!$dsql->ExecuteNoneQuery()){
	$dsql->SetQuery("Delete From #@__archives where ID='$arcID'");
	$dsql->ExecuteNoneQuery();
	$dsql->Close();
	ShowMsg("�����ݱ��浽���ݿ⸽�ӱ� addonimages ʱ��������ԭ��","-1");
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
<a href='album_add.php?cid=$typeid'><u>��������ͼƬ</u></a>
&nbsp;&nbsp;
<a href='$artUrl' target='_blank'><u>�鿴�ĵ�</u></a>
&nbsp;&nbsp;
<a href='catalog_do.php?cid=$typeid&dopost=listArchives'><u>�ѷ���ͼƬ����</u></a>
&nbsp;&nbsp;
<a href='catalog_main.php'><u>��վ��Ŀ����</u></a>
";

$wintitle = "�ɹ�����һ��ͼ����";
$wecome_info = "���¹���::����ͼ��";
$win = new OxWindow();
$win->AddTitle("�ɹ�����һ��ͼ����");
$win->AddMsgItem($msg);
$winform = $win->GetWindow("hand","&nbsp;",false);
$win->Display();
?>