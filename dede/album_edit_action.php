<?
require_once(dirname(__FILE__)."/config.php");
CheckPurview('a_Edit,a_AccEdit,a_MyEdit');
require_once(dirname(__FILE__)."/../include/inc_photograph.php");
require_once(dirname(__FILE__)."/../include/pub_oxwindow.php");
require_once(dirname(__FILE__)."/inc/inc_archives_functions.php");

if(!isset($iscommend)) $iscommend = 0;
if(!isset($isjump)) $isjump = 0;
if(!isset($isbold)) $isbold = 0;
if(!isset($isrm)) $isrm = 0;

if($typeid==0){
	ShowMsg("��ָ���ĵ�����Ŀ��","-1");
	exit();
}
if(empty($channelid)){
	ShowMsg("�ĵ�Ϊ��ָ�������ͣ������㷢�����ݵı��Ƿ�Ϸ���","-1");
	exit();
}
if(!CheckChannel($typeid,$channelid) || !CheckChannel($typeid2,$channelid)){
	ShowMsg("����ѡ�����Ŀ�뵱ǰģ�Ͳ��������ѡ���ɫ��ѡ�","-1");
	exit();
}
if(!TestPurview('a_Edit')) {
	if(TestPurview('a_AccEdit')) CheckCatalog($typeid,"�Բ�����û�в�����Ŀ {$typeid} ���ĵ�Ȩ�ޣ�");
	else CheckArcAdmin($ID,$cuserLogin->getUserID());
}

//�Ա�������ݽ��д���
//--------------------------------
$iscommend = $iscommend + $isbold;

$pubdate = GetMkTime($pubdate);
$sortrank = AddDay($senddate,$sortup);

if($ishtml==0) $ismake = -1;
else $ismake = 0;

$shorttitle = cn_substr($shorttitle,36);
$color =  cn_substr($color,10);
$source = cn_substr($source,50);
$description = cn_substr($description,250);
if($keywords!="") $keywords = trim(cn_substr($keywords,60))." ";
if(!TestPurview('a_Check,a_AccCheck,a_MyCheck')){ $arcrank = -1; }

//�����ϴ�������ͼ
if(empty($ddisremote)) $ddisremote = 0;
$litpic = GetDDImage('none',$picname,$ddisremote);


//�������ݿ��SQL���
//----------------------------------
$inQuery = "
update #@__archives set
typeid='$typeid',
typeid2='$typeid2',
sortrank='$sortrank',
iscommend='$iscommend',
ismake='$ismake',
arcrank='$arcrank',
money='$money',
title='$title',
color='$color',
source='$source',
litpic='$litpic',
pubdate='$pubdate',
description='$description',
keywords='$keywords',
shorttitle='$shorttitle',
arcatt='$arcatt'
where ID='$ID'; ";

$dsql = new DedeSql();
$dsql->SetQuery($inQuery);
if(!$dsql->ExecuteNoneQuery()){
	$dsql->Close();
	ShowMsg("�������ݿ�archives��ʱ�������飡","-1");
	exit();
}
$adminID = $cuserLogin->getUserID();
//����������ָ����ͼƬ
//------------------------------
$imgurls = "{dede:pagestyle maxwidth='$maxwidth' ddmaxwidth='$ddmaxwidth' row='$row' col='$col' value='$pagestyle'/}\r\n";
for($i=1;$i<=120;$i++){
	if(isset(${'imgurl'.$i})||(isset($_FILES['imgfile'.$i]['tmp_name']) && is_uploaded_file($_FILES['imgfile'.$i]['tmp_name']))){
		$iinfo = str_replace("'","`",stripslashes(${'imgmsg'.$i}));
		//���ϴ�ͼƬ
		if(!is_uploaded_file($_FILES['imgfile'.$i]['tmp_name'])){
		    $iurl = stripslashes(${'imgurl'.$i});
		    if(trim($iurl)=="") continue;
		    $iurl = trim(str_replace($cfg_basehost,"",$iurl));
		    if((eregi("^http://",$iurl) && !eregi($cfg_basehost,$iurl)) && $isUrlOpen)
		    //Զ��ͼƬ
		    {
			    $reimgs = "";
			    if($isUrlOpen && $isrm==1)
			    {
				     $reimgs = GetRemoteImage($iurl,$adminID);
			       if(is_array($reimgs)){
				        $imgurls .= "{dede:img text='$iinfo' width='".$reimgs[1]."' height='".$reimgs[2]."'} ".$reimgs[0]." {/dede:img}\r\n";
			       }else{
			       	  echo "���أ�".$iurl." ʧ�ܣ�����ͼƬ�з��ɼ����ܻ�httpͷ����ȷ��<br />\r\n";
			       }
		      }else{
		  	     $imgurls .= "{dede:img text='$iinfo' width='' height=''} ".$iurl." {/dede:img}\r\n";
		      }
		    //վ��ͼƬ
		    }else if($iurl!=""){
			    $imgfile = $cfg_basedir.$iurl;
			    if(is_file($imgfile)){
				      $info = "";
				      $imginfos = GetImageSize($imgfile,$info);
				      $imgurls .= "{dede:img text='$iinfo' width='".$imginfos[0]."' height='".$imginfos[1]."'} $iurl {/dede:img}\r\n";
			    }
		   }
	  //ֱ���ϴ���ͼƬ
	  }else{
			 $sparr = Array("image/pjpeg","image/jpeg","image/gif","image/png","image/x-png","image/wbmp");
			 if(!in_array($_FILES['imgfile'.$i]['type'],$sparr)){
			 	  continue;
			 }
			 $uptime = mytime();
			 $imgPath = $cfg_image_dir."/".strftime("%y%m%d",$uptime);
	  	 MkdirAll($cfg_basedir.$imgPath,777);
			 CloseFtp();
			 $filename = $imgPath."/".dd2char($cuserLogin->getUserID().strftime("%H%M%S",$uptime).mt_rand(100,999).$i);
			 $fs = explode(".",$_FILES['imgfile'.$i]['name']);
	     $filename = $filename.".".$fs[count($fs)-1];
			 @move_uploaded_file($_FILES['imgfile'.$i]['tmp_name'],$cfg_basedir.$filename);
			 @WaterImg($cfg_basedir.$filename,'up');
			 $imgfile = $cfg_basedir.$filename;
			 if(is_file($imgfile)){
				    $iurl = $filename;
				    $info = "";
				    $imginfos = GetImageSize($imgfile,$info);
				    $imgurls .= "{dede:img text='$iinfo' width='".$imginfos[0]."' height='".$imginfos[1]."'} $iurl {/dede:img}\r\n";
			      //�����ϴ���ͼƬ��Ϣ���浽ý���ĵ���������
			      $inquery = "
               INSERT INTO #@__uploads(title,url,mediatype,width,height,playtime,filesize,uptime,adminid,memberid) 
                VALUES ('$title".$i."','$filename','1','".$imginfos[0]."','".$imginfos[1]."','0','".filesize($imgfile)."','".mytime()."','$adminID','0');
             ";
            $dsql->SetQuery($inquery);
            $dsql->ExecuteNoneQuery();
			 }
	  }
	}//����ͼƬ������
}//ѭ������
$imgurls = addslashes($imgurls);
//���¼��븽�ӱ�
//----------------------------------
$DbRow = $dsql->GetOne("Select aid,typeid From #@__addonimages where aid='$ID'");
if(!is_array($DbRow))
{
    $query = "INSERT INTO #@__addonimages(aid,typeid,pagestyle,maxwidth,imgurls,row,col,isrm,ddmaxwidth)
            Values('$ID','$typeid','$pagestyle','$maxwidth','$imgurls','$row','$col','$isrm','$ddmaxwidth');";
    $dsql->SetQuery($query);
    if(!$dsql->ExecuteNoneQuery()){
	      $dsql->Close();
	      ShowMsg("�����ݱ��浽���ݿ⸽�ӱ� addonimages ʱ��������ԭ��","-1");
	      exit();
    }
}else{
	$query = "
  Update #@__addonimages
  set typeid='$typeid',
  pagestyle='$pagestyle',
  maxwidth = '$maxwidth',
  imgurls='$imgurls',
  row='$row',
  col='$col',
  isrm='$isrm'
  where aid='$ID';";
  $dsql->SetQuery($query);
  if(!$dsql->ExecuteNoneQuery()){
	    $dsql->Close();
	    ShowMsg("���¸��ӱ� addonimages ʱ��������ԭ��","-1");
	    exit();
  }
}

$dsql->Close();

//����HTML
//---------------------------------

$artUrl = MakeArt($ID,true);
if($artUrl=="") $artUrl = $cfg_plus_dir."/view.php?aid=$ID";

//---------------------------------
//���سɹ���Ϣ
//----------------------------------

$msg = "
������ѡ����ĺ���������
<a href='album_add.php?cid=$typeid'><u>��������ͼƬ</u></a>
&nbsp;&nbsp;
<a href='archives_do.php?aid=".$ID."&dopost=editArchives'><u>�鿴����</u></a>
&nbsp;&nbsp;
<a href='$artUrl' target='_blank'><u>Ԥ���ĵ�</u></a>
&nbsp;&nbsp;
<a href='catalog_do.php?cid=$typeid&dopost=listArchives'><u>�����ѷ���ͼƬ</u></a>
&nbsp;&nbsp;
<a href='catalog_main.php'><u>��վ��Ŀ����</u></a>
";

$wintitle = "�ɹ�����ͼ����";
$wecome_info = "���¹���::����ͼ��";
$win = new OxWindow();
$win->AddTitle("�ɹ�����һ��ͼ����");
$win->AddMsgItem($msg);
$winform = $win->GetWindow("hand","&nbsp;",false);
$win->Display();
?>