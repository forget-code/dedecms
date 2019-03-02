<?php
require_once(dirname(__FILE__)."/config.php");
CheckRank(0,0);
require_once(DEDEINC."/dedetag.class.php");
require_once(DEDEINC."/customfields.func.php");
require_once(DEDEMEMBER."/inc/inc_catalog_options.php");
require_once(DEDEMEMBER."/inc/inc_archives_functions.php");
$channelid = isset($channelid) && is_numeric($channelid) ? $channelid : 1;
$aid = isset($aid) && is_numeric($aid) ? $aid : 0;
$mtypesid = isset($mtypesid) && is_numeric($mtypesid) ? $mtypesid : 0;

/*-------------
function _ShowForm(){  }
--------------*/
if(empty($dopost))
{
	//读取归档信息
  $arcQuery = "Select ch.*,arc.* From `#@__arctiny` arc
    left join `#@__channeltype` ch on ch.id=arc.channel where arc.id='$aid' ";
	$cInfos = $dsql->GetOne($arcQuery);
	if(!is_array($cInfos))
	{
		ShowMsg("读取文档信息出错!","-1");
		exit();
	}
	$addRow = $dsql->GetOne("Select * From `{$cInfos['addtable']}` where aid='$aid'; ");
	if($addRow['mid']!=$cfg_ml->M_ID)
	{
		ShowMsg("对不起，你没权限操作此文档！","-1");
		exit();
	}
	$addRow['id'] = $addRow['aid'];
	include(DEDEMEMBER."/templets/archives_sg_edit.htm");
	exit();
}

/*------------------------------
function _SaveArticle(){  }
------------------------------*/
else if($dopost=='save')
{
	require_once(DEDEINC."/image.func.php");
	require_once(DEDEINC."/oxwindow.class.php");

	$flag = '';
	$typeid = isset($typeid) && is_numeric($typeid) ? $typeid : 0;
	$userip = GetIP();
	$ckhash = md5($aid.$cfg_cookie_encode);
	if($ckhash!=$idhash)
	{
		ShowMsg('校对码错误，你没权限修改此文档或操作不合法！','-1');
		exit();
	}

	if($typeid==0)
	{
		ShowMsg('请指定文档隶属的栏目！','-1');
		exit();
	}
	$query = "Select tp.ispart,tp.channeltype,tp.issend,ch.issend as cissend,ch.sendrank,ch.arcsta,ch.addtable,ch.usertype
         From `#@__arctype` tp left join `#@__channeltype` ch on ch.id=tp.channeltype where tp.id='$typeid' ";
	$cInfos = $dsql->GetOne($query);
	$addtable = $cInfos['addtable'];

	//检测栏目是否有投稿权限
	if($cInfos['issend']!=1 || $cInfos['ispart']!=0|| $cInfos['channeltype']!=$channelid || $cInfos['cissend']!=1)
	{
		ShowMsg("你所选择的栏目不支持投稿！","-1");
		exit();
	}

	//文档的默认状态
	if($cInfos['arcsta']==0)
	{
		$arcrank = 0;
	}
	else if($cInfos['arcsta']==1)
	{
		$arcrank = 0;
	}
	else
	{
		$arcrank = -1;
	}

	//对保存的内容进行处理
	$title = cn_substrR(HtmlReplace($title,1),$cfg_title_maxlen);
	$mid = $cfg_ml->M_ID;

	//处理上传的缩略图
	$litpic = MemberUploads('litpic',$oldlitpic,$mid,'image','',$cfg_ddimg_width,$cfg_ddimg_height,false);
	if($litpic!='')
	{
		SaveUploadInfo($title,$litpic,1);
	}
	else
	{
		$litpic =$oldlitpic;
	}

	//分析处理附加表数据
	$inadd_f = '';
	if(!empty($dede_addonfields))
	{
		$addonfields = explode(';',$dede_addonfields);
		if(is_array($addonfields))
		{
			foreach($addonfields as $v)
			{
				if($v=='')
				{
					continue;
				}
				$vs = explode(',',$v);
				if(!isset(${$vs[0]}))
				{
					${$vs[0]} = '';
				}

				//自动摘要和远程图片本地化
				if($vs[1]=='htmltext'||$vs[1]=='textdata')
				{
					${$vs[0]} = AnalyseHtmlBody(${$vs[0]},$description,$vs[1]);
				}

				${$vs[0]} = GetFieldValueA(${$vs[0]},$vs[1],$aid);

				$inadd_f .= ',`'.$vs[0]."` ='".${$vs[0]}."' ";
			}
		}
	}

	if($addtable!='')
	{
		$upQuery = "Update `$addtable` set `title`='$title',`typeid`='$typeid',`arcrank`='$arcrank',litpic='$litpic',userip='$userip'{$inadd_f} where aid='$aid' ";
		if(!$dsql->ExecuteNoneQuery($upQuery))
		{
			ShowMsg("更新附加表 `$addtable`  时出错，请联系管理员！","javascript:;");
			exit();
		}
		$dsql->ExecuteNoneQuery("Update `#@__member_archives` set mtypeid = '$mtypesid' WHERE id = '$aid'");
	}
	
	UpIndexKey($aid,0,$typeid,$sortrank,'');
	
	$artUrl = MakeArt($aid,true);
	
	if($artUrl=='')
	{
		$artUrl = $cfg_phpurl."/view.php?aid=$aid";
	}

	//返回成功信息
	$msg = "　　请选择你的后续操作：
		<a href='archives_sg_add.php?cid=$typeid'><u>发布新内容</u></a>
		&nbsp;&nbsp;
		<a href='archives_do.php?channelid=$channelid&aid=".$aid."&dopost=edit'><u>查看更改</u></a>
		&nbsp;&nbsp;
		<a href='$artUrl' target='_blank'><u>查看内容</u></a>
		&nbsp;&nbsp;
		<a href='content_sg_list.php?channelid=$channelid'><u>管理内容</u></a>
		";
	$wintitle = "成功更改内容！";
	$wecome_info = "内容管理::更改内容";
	$win = new OxWindow();
	$win->AddTitle("成功更改内容：");
	$win->AddMsgItem($msg);
	$winform = $win->GetWindow("hand","&nbsp;",false);
	$win->Display();
}
?>