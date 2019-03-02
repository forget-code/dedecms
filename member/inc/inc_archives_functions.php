<?
if(!isset($registerGlobals)){ require_once(dirname(__FILE__)."/../../include/config_base.php"); }
require_once(dirname(__FILE__)."/../../include/pub_httpdown.php");
require_once(dirname(__FILE__)."/../../include/inc_archives_view.php");
require_once(dirname(__FILE__)."/../../include/inc_photograph.php");
//------------------------------
//��ȡһ��Զ��ͼƬ
//------------------------------
function GetRemoteImage($url,$uid=0)
{
	global $title,$cfg_mb_rmdown;
	if($cfg_mb_rmdown=='��') return '';
	$cfg_uploaddir = $GLOBALS['cfg_user_dir'];
	$cfg_basedir = $GLOBALS['cfg_basedir'];
	$revalues = Array();
	$revalues[0] = '';
	$revalues[1] = '';
	$revalues[2] = '';
	$ok = false;
	$htd = new DedeHttpDown();
	$htd->OpenUrl($url);
	$sparr = Array("image/pjpeg","image/jpeg","image/gif","image/png","image/x-png","image/wbmp");
	if(!in_array($htd->GetHead("content-type"),$sparr)){
		return "";
	}else{  	
  	$imgUrl = $cfg_uploaddir."/".strftime("%y%m",mytime());
	  $imgPath = $cfg_basedir.$imgUrl;
	  CreateDir($imgUrl);
  	$itype = $htd->GetHead("content-type");
		if($itype=="image/gif") $itype = ".gif";
		else if($itype=="image/png") $itype = ".png";
		else if($itype=="image/wbmp") $itype = ".bmp";
		else $itype = ".jpg";
		$rndname = dd2char($uid."_".strftime("%d%H%M%S",mytime()).mt_rand(1000,9999));
		$rndtrueName = $imgPath."/".$rndname.$itype;
		$fileurl = $imgUrl."/".$rndname.$itype;
  	$ok = $htd->SaveToBin($rndtrueName);
  	if($ok){
  	  $info = "";
  	  $data = GetImageSize($rndtrueName,$info);
  	  $revalues[0] = $fileurl;
	    $revalues[1] = $data[0];
	    $revalues[2] = $data[1];
	  }
	  @WaterImg($rndtrueName,'down');
	  //�����û��ϴ��ļ�¼�����ݿ�
	  if($title=='') $title = '�û������Զ��ͼƬ';
	  $addinfos[0] = $data[0];
	  $addinfos[1] = $data[1];
	  $addinfos[2] = filesize($rndtrueName);
	  SaveUploadInfo($title."(Զ��ͼƬ)",$fileurl,1,$addinfos);
  }
	$htd->Close();
	if($ok) return $revalues;
	else return '';
}
//------------------
//����ϴ���ͼƬ
//------------------
function GetUpImage($litpic,$isdd=false,$exitErr=false,$iw=0,$ih=0,$iname='')
{
	global $cfg_ml,$cfg_ddimg_width,$cfg_ddimg_height;
	global $cfg_basedir,$cfg_user_dir,$title,$cfg_mb_upload_size;
	if($iw==0) $iw = $cfg_ddimg_width;
	if($ih==0) $ih = $cfg_ddimg_height;
	$ntime = mytime();
	if(!isset($_FILES[$litpic])) return "";
	if(is_uploaded_file($_FILES[$litpic]['tmp_name']))
	{
      //�����޶���С���ļ������ϴ�
      if($_FILES[$litpic]['size'] > $cfg_mb_upload_size*1024){
      	@unlink($_FILES[$litpic]['tmp_name']);
      	return "";
      }
      $sparr = Array("image/pjpeg","image/jpeg","image/gif","image/png");
      $_FILES[$litpic]['type'] = strtolower(trim($_FILES[$litpic]['type']));
      if(!in_array($_FILES[$litpic]['type'],$sparr)){
		    if($exitErr){
		    	ShowMsg("�ϴ�������ͼƬ��ʽ������ʹ��JPEG��GIF��PNG��ʽ������һ�֣�","-1");
		      exit();
		    }else{ return ""; }
	    }
      if($iname=='') $savepath = $cfg_user_dir."/".$cfg_ml->M_ID."/".strftime("%y%m",$ntime);
      else $savepath = $cfg_user_dir."/".$cfg_ml->M_ID;
      CreateDir($savepath);
      
      if($iname=='') $itname = dd2char(strftime("%d%H%M%S",$ntime).$cfg_ml->M_ID.mt_rand(1000,9999));
      else $itname = $iname;
      
      $fullUrl = $savepath."/".$itname;
     
      if($iname==''){
        if(strtolower($_FILES[$litpic]['type'])=="image/gif") $fullUrl = $fullUrl.".gif";
        else if(strtolower($_FILES[$litpic]['type'])=="image/png") $fullUrl = $fullUrl.".png";
        else $fullUrl = $fullUrl.".jpg";
      }else{
      	$fullUrl = $fullUrl.'.jpg';
      }
      
      @move_uploaded_file($_FILES[$litpic]['tmp_name'],$cfg_basedir.$fullUrl);
	    $litpic = $fullUrl;
	    
	    if($isdd) @ImageResize($cfg_basedir.$fullUrl,$iw,$ih);
	    else @WaterImg($cfg_basedir.$fullUrl,'up');
	    
	    //�����û��ϴ��ļ�¼�����ݿ�
	    if($title==''){
	    	if($isdd) $title = '�û��ϴ���ͼƬ';
	    	else $title = '�û��ϴ�������ͼ';
	    }
	    $info = "";
	    $datas[0] = 0;
	    $datas[1] = 0;
	    $datas = GetImageSize($cfg_basedir.$fullUrl,$info);
	    $addinfos[0] = $datas[0];
	    $addinfos[1] = $datas[1];
	    $addinfos[2] = filesize($cfg_basedir.$fullUrl);
	    SaveUploadInfo($title,$fullUrl,1,$addinfos);
	    
	    return $litpic;
  }else{
  	 return "";
  }
}
//-----------------------
//���ϴ�����Ϣ���浽���ݿ�
//------------------------
function SaveUploadInfo($title,$filename,$medaitype=1,$addinfos='')
{
		global $dsql,$cfg_ml;
		if($filename=="") return "";
		$isopenSql = false;
		if(!is_object($dsql)){
			$dsql = new DedeSql(false);
			$isopenSql = true;
		}
		if(!is_array($addinfos)){
			$addinfos[0] = 0; $addinfos[1] = 0; $addinfos[2] = 0;
		}
		$row = $dsql->GetOne("Select title,url From #@__uploads where url='$filename'; ");
		if(is_array($row) && count($row)>0){
			if($isopenSql) $dsql->Close();
			return "";
		}
		$inquery = "
       INSERT INTO #@__uploads(title,url,mediatype,width,height,playtime,filesize,uptime,adminid,memberid) 
       VALUES ('$title','$filename','1','".$addinfos[0]."','".$addinfos[1]."','0','".$addinfos[2]."','".mytime()."','0','".$cfg_ml->M_ID."');
    ";
    $dsql->SetQuery($inquery);
    $dsql->ExecuteNoneQuery();
    if($isopenSql) $dsql->Close();
}
//---------------
//���Ƶ��ID
//---------------
function CheckChannel($typeid,$channelid)
{
	 if($typeid==0) return false;
	 $dsql = new DedeSql(false);
	 $rowc = $dsql->GetOne("Select issend From #@__channeltype  where ID='$channelid'; ");	  
	 $row = $dsql->GetOne("Select ispart,channeltype,issend From #@__arctype where ID='$typeid' ");
	 $dsql->Close();
	 if($rowc['issend']!=1 || $row['ispart']!=0 
	 || $row['channeltype']!=$channelid || $row['issend']!=1){
	 	 return false;
	 }else {
	 	 return true;
	 }
}
//-----------------------
//����ָ��ID���ĵ�
//-----------------------
function MakeArt($aid,$checkLike=false)
{
	$arc = new Archives($aid);
  $reurl = $arc->MakeHtml();
  $arc->dsql = new DedeSql(false);
  $preRow = $arc->dsql->GetOne("Select ID From #@__archives where ID<$aid order by ID desc");
  $nextRow = $arc->dsql->GetOne("Select ID From #@__archives where ID>$aid order by ID asc");
  $arc->Close();
  if(is_array($preRow)){
  	$arc = new Archives($preRow['ID']);
    $arc->MakeHtml();
    $arc->Close();
  }
  if(is_array($nextRow)){
  	$arc = new Archives($nextRow['ID']);
    $arc->MakeHtml();
    $arc->Close();
  }
  return $reurl;
}
?>