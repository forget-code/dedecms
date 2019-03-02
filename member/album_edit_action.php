<?php 
require_once(dirname(__FILE__)."/config.php");
CheckRank(0,0);

if($cfg_mb_album=='��'){
	ShowMsg("�Բ���ϵͳ������ͼ���Ĺ��ܣ�����޷�ʹ�ã�","-1");
	exit();
}

require_once(dirname(__FILE__)."/../include/inc_photograph.php");
require_once(dirname(__FILE__)."/../include/pub_oxwindow.php");
require_once(dirname(__FILE__)."/inc/inc_archives_functions.php");

$typeid = ereg_replace("[^0-9]","",$typeid);
$channelid = 2;
$ID = ereg_replace("[^0-9]","",$ID);

if($typeid==0){
	ShowMsg("��ָ���ĵ���������Ŀ��","-1");
	exit();
}

if(!CheckChannel($typeid,$channelid)){
	ShowMsg("����ѡ�����Ŀ�뵱ǰģ�Ͳ��������֧��Ͷ�壬��ѡ���ɫ��ѡ�","-1");
	exit();
}

CheckUserSpace($cfg_ml->M_ID);

$dsql = new DedeSql(false);

//����û��Ƿ���Ȩ�޲�����ƪ�ĵ�
//--------------------------------

$row = $dsql->GetOne("Select arcrank From #@__archives where memberID='".$cfg_ml->M_ID."' And ID='$ID'");
if(!is_array($row)){
   $dsql->Close();
   ShowMsg("��ûȨ�޸������ͼ����","-1");
   exit();
}

$cInfos = $dsql->GetOne("Select arcsta From #@__channeltype  where ID='2'; ");
if($cInfos['arcsta']==0){
	$ismake = 0;
	$arcrank = 0;
}
else if($cInfos['arcsta']==1){
	$ismake = -1;
	$arcrank = 0;
}
else{
	$ismake = 0;
	$arcrank = -1;
}

$title = ClearHtml($title);
$writer =  cn_substr(trim(ClearHtml($writer)),30);
$source = cn_substr(trim(ClearHtml($source)),50);
$description = cn_substr(trim(ClearHtml($description)),250);
if($keywords!=""){
	$keywords = ereg_replace("[,;]"," ",trim(ClearHtml($keywords)));
	$keywords = trim(cn_substr($keywords,60))." ";
}
$userip = GetIP();

//�����ϴ�������ͼ
if(!empty($litpic)){
	$litpic = GetUpImage('litpic',true,true);
	$litpic = " litpic='$litpic', ";
}else{
	$litpic = "";
}

$memberID = $cfg_ml->M_ID;

//�������ݿ��SQL���
//----------------------------------
$inQuery = "
update #@__archives set
ismake='$ismake',arcrank='$arcrank',typeid='$typeid',title='$title',source='$source',
$litpic
description='$description',keywords='$keywords',mtype='$mtype',userip='$userip'
where ID='$ID' And memberID='$memberID';
";
$dsql->SetQuery($inQuery);
if(!$dsql->ExecuteNoneQuery()){
	$dsql->Close();
	ShowMsg("�����ݱ��浽���ݿ�archives��ʱ�������飡","-1");
	exit();
}

//-------------------------------
//���¸��ӱ�
//------------------------------

//����������ָ����ͼƬ
$pagestyle = 2;

$imgurls = "{dede:pagestyle maxwidth='$maxwidth' ddmaxwidth='' row='0' col='0' value='$pagestyle'/}\r\n";
for($i=1;$i<=120;$i++){
	if(isset(${'imgurl'.$i})|| 
	(isset($_FILES['imgfile'.$i]['tmp_name']) && is_uploaded_file($_FILES['imgfile'.$i]['tmp_name']))){
		$iinfo = str_replace("'","`",stripslashes(${'imgmsg'.$i}));
		//���ϴ�ͼƬ
		if(!is_uploaded_file($_FILES['imgfile'.$i]['tmp_name'])){
		    $iurl = ${'imgurl'.$i};
		    if(trim($iurl)=="") continue;
		    $iurl = trim(str_replace($cfg_basehost,"",$iurl));
		    if((eregi("^http://",$iurl) && !eregi($cfg_basehost,$iurl)) && $isUrlOpen && $iurl!="http://")
		    //Զ��ͼƬ
		    {
			    $reimgs = "";
			    if($isUrlOpen){
				     $reimgs = GetRemoteImage($iurl,$cfg_ml->M_ID);
			       if(is_array($reimgs)){ $imgurls .= "{dede:img text='$iinfo' width='".$reimgs[1]."' height='".$reimgs[2]."'} ".$reimgs[0]." {/dede:img}\r\n"; }
			       else{ echo "���أ�".$iurl." ʧ�ܣ�����ͼƬ�з��ɼ����ܻ�httpͷ����ȷ��<br />\r\n"; }
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
			 $oldiurl = ${'imgurl'.$i};
			 $oldimgfile = $cfg_basedir.$oldiurl;
			 if(file_exists($oldimgfile)){
			 	  $oldiurl = ereg_replace("[^0-9a-zA-Z\._-]","",$oldiurl);
			 	  $dsql->ExecuteNoneQuery("Delete From #@__uploads where url='$oldiurl' And memberid='".$cfg_ml->M_ID."';");
			 }
			 $iurl = GetUpImage('imgfile'.$i,false,false);
			 if($iurl!=''){
				    $imgfile = $cfg_basedir.$iurl;
				    $info = "";
				    $imginfos = GetImageSize($imgfile,$info);
				    $imgurls .= "{dede:img text='$iinfo' width='".$imginfos[0]."' height='".$imginfos[1]."'} $iurl {/dede:img}\r\n";
			 }
	  }
	}//����ͼƬ������
}//ѭ������
$imgurls = addslashes($imgurls);
CloseFtp();

//���¸��ӱ�
//----------------------------------
$query = "
update #@__addonimages set 
typeid = '$typeid',
maxwidth = '$maxwidth',
imgurls = '$imgurls'
where aid='$ID';
";
$dsql->SetQuery($query);
if(!$dsql->ExecuteNoneQuery()){
	$dsql->Close();
	ShowMsg("�����ݱ��浽���ݿ⸽�ӱ� addonimages ʱ��������ԭ��","-1");
	exit();
}
$dsql->Close();

$artUrl = MakeArt($ID);

//---------------------------------
//���سɹ���Ϣ
//----------------------------------

$msg = "
��ѡ����ĺ���������
<a href='album_add.php?cid=$typeid'><u>����������ͼ��</u></a>
&nbsp;&nbsp;
<a href='album_edit.php?aid=$ID'><u>����ͼ��</u></a>
&nbsp;&nbsp;
<a href='$artUrl' target='_blank'><u>Ԥ��ͼ��</u></a>
&nbsp;&nbsp;
<a href='content_list.php?channelid=2'><u>�ѷ���ͼ������</u></a>
&nbsp;&nbsp;
<a href='index.php'><u>��Ա��ҳ</u></a>
";

$wintitle = "�ɹ�����һ��ͼ����";
$wecome_info = "�ĵ�����::����ͼ��";
$win = new OxWindow();
$win->AddTitle("�ɹ�����һ��ͼ����");
$win->AddMsgItem($msg);
$winform = $win->GetWindow("hand","&nbsp;",false);
$win->Display();
?>