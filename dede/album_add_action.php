<?
require_once(dirname(__FILE__)."/config.php");
CheckPurview('a_New,a_AccNew');
require_once(dirname(__FILE__)."/../include/inc_photograph.php");
require_once(dirname(__FILE__)."/../include/pub_oxwindow.php");
require_once(dirname(__FILE__)."/inc/inc_archives_functions.php");

if(!isset($iscommend)) $iscommend = 0;
if(!isset($isjump)) $isjump = 0;
if(!isset($isbold)) $isbold = 0;
if(!isset($isrm)) $isrm = 0;
if(!isset($ddisfirst)) $ddisfirst = 0;
if(!isset($ddisremote)) $ddisremote = 0;

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
if(!TestPurview('a_New')) {
	CheckCatalog($typeid,"�Բ�����û�в�����Ŀ {$typeid} ��Ȩ�ޣ�");
	if($typeid2!=0) CheckCatalog($typeid2,"�Բ�����û�в�����Ŀ {$typeid2} ��Ȩ�ޣ�");
}
//�Ա�������ݽ��д���
//--------------------------------
$iscommend = $iscommend + $isbold;

$pubdate = GetMkTime($pubdate);
$senddate = time();
$sortrank = AddDay($senddate,$sortup);

if($ishtml==0) $ismake = -1;
else $ismake = 0;

$shorttitle = cn_substr($shorttitle,36);
$color =  cn_substr($color,10);
$writer =  "";
$source = cn_substr($source,50);
$description = cn_substr($description,250);
if($keywords!="") $keywords = trim(cn_substr($keywords,60))." ";
if(!TestPurview('a_Check,a_AccCheck,a_MyCheck')){ $arcrank = -1; }

//�����ϴ�������ͼ
$litpic = GetDDImage('litpic',$picname,$ddisremote);

//ʹ�õ�һ��ͼ��Ϊ����ͼ
if($ddisfirst==1 && $litpic==""){
	if(isset($imgurl1)){
		 $litpic = GetDDImage('ddfirst',$imgurl1,$isrm);
	}
}

$adminID = $cuserLogin->getUserID();

//������������
//----------------------------------
$inQuery = "INSERT INTO #@__archives(
typeid,typeid2,sortrank,iscommend,ismake,channel,
arcrank,click,money,title,shorttitle,color,writer,source,litpic,
pubdate,senddate,arcatt,adminID,memberID,description,keywords) 
VALUES ('$typeid','$typeid2','$sortrank','$iscommend','$ismake','$channelid',
'$arcrank','0','$money','$title','$shorttitle','$color','$writer','$source','$litpic',
'$pubdate','$senddate','$arcatt','$adminID','0','$description','$keywords');";
$dsql = new DedeSql();
$dsql->SetQuery($inQuery);
if(!$dsql->ExecuteNoneQuery()){
	$dsql->Close();
	ShowMsg("�����ݱ��浽���ݿ�archives��ʱ�������飡","-1");
	exit();
}
$arcID = $dsql->GetLastID();
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
//���븽�ӱ�
//----------------------------------
$query = "
INSERT INTO #@__addonimages(aid,typeid,pagestyle,maxwidth,imgurls,row,col,isrm,ddmaxwidth) Values('$arcID','$typeid','$pagestyle','$maxwidth','$imgurls','$row','$col','$isrm','$ddmaxwidth');
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
<a href='archives_do.php?aid=".$arcID."&dopost=editArchives'><u>����ͼ��</u></a>
&nbsp;&nbsp;
<a href='$artUrl' target='_blank'><u>Ԥ���ĵ�</u></a>
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