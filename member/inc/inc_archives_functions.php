<?php
require_once(dirname(__FILE__)."/../../include/pub_httpdown.php");
require_once(dirname(__FILE__)."/../../include/inc_photograph.php");
require_once(dirname(__FILE__)."/../../include/pub_dedetag.php");
require_once(dirname(__FILE__)."/../../include/pub_oxwindow.php");
require_once(dirname(__FILE__)."/../../include/inc_tag_functions.php");
require_once(dirname(__FILE__)."/../../include/inc_custom_fields.php");

//------------------------------
//获取一个远程图片
//------------------------------
function GetRemoteImage($url,$uid=0)
{
	global $title,$cfg_mb_rmdown,$cfg_photo_typenames,$cfg_ml;
	if($cfg_mb_rmdown=='N') return '';
	$cfg_uploaddir = $GLOBALS['cfg_user_dir'];
	$cfg_basedir = $GLOBALS['cfg_basedir'];
	$revalues = Array();
	$revalues[0] = '';
	$revalues[1] = '';
	$revalues[2] = '';
	$ok = false;
	$htd = new DedeHttpDown();
	$htd->OpenUrl($url);
	$sparr = $cfg_photo_typenames;
	if(!in_array($htd->GetHead("content-type"),$sparr)){
		return "";
	}else{
  	$imgUrl = $cfg_uploaddir."/".$cfg_ml->M_ID;
	  $imgPath = $cfg_basedir.$imgUrl;
	  CreateDir($imgUrl);
  	$itype = $htd->GetHead("content-type");
		if($itype=="image/gif") $itype = ".gif";
		else if($itype=="image/png") $itype = ".png";
		else if($itype=="image/wbmp") $itype = ".bmp";
		else $itype = ".jpg";
		$rndname = dd2char($cfg_ml->M_ID."0".strftime("%y%m%d%H%M%S",$nowtme)."0".mt_rand(1000,9999)).'-rm';
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
	  //保存用户上传的记录到数据库
	  if($title=='') $title = '用户保存的远程图片';
	  $addinfos[0] = $data[0];
	  $addinfos[1] = $data[1];
	  $addinfos[2] = filesize($rndtrueName);
	  SaveUploadInfo($title."(远程图片)",$fileurl,1,$addinfos);
  }
	$htd->Close();
	if($ok) return $revalues;
	else return '';
}
//------------------
//获得上传的图片
//------------------
function GetUpImage($litpic,$isdd=false,$exitErr=false,$iw=0,$ih=0,$iname='')
{
	global $cfg_ml,$cfg_ddimg_width,$cfg_ddimg_height;
	global $cfg_basedir,$cfg_user_dir,$title,$cfg_mb_upload_size,$cfg_photo_typenames;
	if($iw==0) $iw = $cfg_ddimg_width;
	if($ih==0) $ih = $cfg_ddimg_height;
	$ntime = $nowtme = mytime();
	if(!isset($_FILES[$litpic])) return "";
	if(is_uploaded_file($_FILES[$litpic]['tmp_name']))
	{
      //超过限定大小的文件不给上传
      if($_FILES[$litpic]['size'] > $cfg_mb_upload_size*1024){
      	@unlink($_FILES[$litpic]['tmp_name']);
      	return "";
      }
      $sparr = $cfg_photo_typenames;
      $_FILES[$litpic]['type'] = strtolower(trim($_FILES[$litpic]['type']));
      if(!in_array($_FILES[$litpic]['type'],$sparr)){
		    if($exitErr){
		    	ShowMsg("上传的缩略图片格式错误，请使用JPEG、GIF、PNG格式的其中一种！","-1");
		      exit();
		    }else{ return ""; }
	    }

      $savepath = $cfg_user_dir."/".$cfg_ml->M_ID;
      CreateDir($savepath);

      if($iname=='') $itname = dd2char($cfg_ml->M_ID."0".strftime("%y%m%d%H%M%S",$nowtme)."0".mt_rand(1000,9999)).'-lit';
      else $itname = $iname;

      $fullUrl = $savepath."/".$itname;

      //强制检测文件类型
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

	    //保存用户上传的记录到数据库
	    if($title==''){
	    	if($isdd) $title = '用户上传的图片';
	    	else $title = '用户上传的略略图';
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
//把上传的信息保存到数据库
//------------------------
function SaveUploadInfo($title,$filename,$medaitype=1,$addinfos='')
{
		global $dsql,$cfg_ml;
		if($filename=="") return "";
		if(!is_object($dsql)){ $dsql = new DedeSql(false); }
		if(!is_array($addinfos)){
			$addinfos[0] = 0; $addinfos[1] = 0; $addinfos[2] = 0;
		}
		$row = $dsql->GetOne("Select title,url From #@__uploads where url='$filename'; ");
		if(is_array($row) && count($row)>0){ return '';}
		$inquery = "
       INSERT INTO `#@__uploads`(title,url,mediatype,width,height,playtime,filesize,uptime,adminid,memberid)
       VALUES ('$title','$filename','1','".$addinfos[0]."','".$addinfos[1]."','0','".$addinfos[2]."','".mytime()."','0','".$cfg_ml->M_ID."');
    ";
    $dsql->SetQuery($inquery);
    $dsql->ExecuteNoneQuery();
}

//---------------
//检测频道ID
//---------------
function CheckChannel($typeid,$channelid)
{
	 global $dsql;
	 if($typeid==0) return false;
	 $query = "Select t.ispart,t.channeltype,t.issend,c.issend as cissend From `#@__arctype` t 
	            left join `#@__channeltype` c on c.ID=t.channeltype where t.ID='$typeid'
	          ";
	 $row = $dsql->GetOne($query,MYSQL_ASSOC);
	 if($row['cissend']!=1) $msg="模型不允许投稿";
	 else if($row['issend']!=1) $msg="栏目不允许投稿";
	 else if($row['ispart']!=0) $msg="非最终列表栏目";
	 else if($row['channeltype']!=$channelid) $msg="栏目不属于所选模型";
	 else $msg = '';
	 return $msg;
}
//-----------------------
//创建指定ID的文档
//-----------------------
function MakeArt($aid,$checkLike=false)
{
	include_once(dirname(__FILE__)."/../../include/inc_archives_view.php");
	$arc = new Archives($aid);
  $reurl = $arc->MakeHtml();
  return $reurl;
}
?>