<?php 
require_once(dirname(__FILE__)."/config.php");
require_once(dirname(__FILE__)."/../include/inc_photograph.php");
require_once(dirname(__FILE__)."/../include/pub_oxwindow.php");
require_once(dirname(__FILE__)."/inc/inc_archives_functions.php");

if(!isset($iscommend)) $iscommend = 0;
if(!isset($isbold)) $isbold = 0;

if(empty($channelid)){
	ShowMsg("�ĵ�Ϊ��ָ�������ͣ���������������ʱ�Ƿ�Ϸ���","-1");
	exit();
}

//�Ա�������ݽ��д���
//--------------------------------
$iscommend = $iscommend + $isbold;

$pubdate = GetMkTime($pubdate);
$senddate = mytime();
$sortrank = AddDay($senddate,$sortup);

if($ishtml==0) $ismake = -1;
else $ismake = 0;

$title = cn_substr($title,80);
$shorttitle = cn_substr($shorttitle,36);
$color =  cn_substr($color,10);
$writer =  cn_substr($writer,30);
$source = cn_substr($source,50);
$description = cn_substr($description,250);
if($keywords!="") $keywords = trim(cn_substr($keywords,60))." ";
if($cuserLogin->getUserRank() < 5){ $arcrank = -1; }

//�����ϴ�������ͼ
if(empty($ddisremote)) $ddisremote = 0;
$litpic = GetDDImage('litpic',$picname,$ddisremote);

$adminID = $cuserLogin->getUserID();

//������������

//----------------------------------
$inQuery = "INSERT INTO #@__archives(
typeid,typeid2,sortrank,iscommend,ismake,channel,
arcrank,click,title,shorttitle,color,writer,source,litpic,
pubdate,senddate,arcatt,adminID,memberID,description,keywords,templet) 
VALUES ('$typeid','$typeid2','$sortrank','$iscommend','$ismake','$channelid',
'$arcrank','0','$title','$shorttitle','$color','$writer','$source','$litpic',
'$pubdate','$senddate','$arcatt','$adminID','0','$description','$keywords','$templet');";
$dsql = new DedeSql();
$dsql->SetQuery($inQuery);
if(!$dsql->ExecuteNoneQuery()){
	$dsql->Close();
	ShowMsg("�����ݱ��浽���ݿ�archives��ʱ�������飡","-1");
	exit();
}

//ר��ڵ��б�
//--------------------------------
$arcids = "";
$notelist = "";
for($i=1;$i<=$cfg_specnote;$i++)
{
	if(!empty(${'notename'.$i}))
	{
		$notename = str_replace("'","",trim(${'notename'.$i}));
		$arcid = trim(${'arcid'.$i});
		$col = trim(${'col'.$i});
		$imgwidth = trim(${'imgwidth'.$i});
		$imgheight = trim(${'imgheight'.$i});
		$titlelen = trim(${'titlelen'.$i});
		$infolen = trim(${'infolen'.$i});
		$listtmp = trim(${'listtmp'.$i});
		
		$noteid = trim(${'noteid'.$i});
		$isauto = trim(${'isauto'.$i});
		$keywords = str_replace("'","",trim(${'keywords'.$i}));
		$typeid = trim(${'typeid'.$i});
		if(!empty(${'rownum'.$i})) $rownum = trim(${'rownum'.$i});
		else $rownum = 0;

		$arcid = ereg_replace("[^0-9,]","",$arcid);
		$ids = explode(",",$arcid);
		$okids = "";
		if(is_array($ids)){
		foreach($ids as $mid)
		{
			$mid = trim($mid);
			if($mid=="") continue;
			if(!isset($arcids[$mid])){
				if($okids=="") $okids .= $mid;
				else $okids .= ",".$mid; 
				$arcids[$mid] = 1;
			}
		}}
		$notelist .= "{dede:specnote imgheight=\\'$imgheight\\' imgwidth=\\'$imgwidth\\' 
infolen=\\'$infolen\\' titlelen=\\'$titlelen\\' col=\\'$col\\' idlist=\\'$okids\\' 
name=\\'$notename\\' noteid=\\'$noteid\\' isauto=\'$isauto\' rownum=\\'$rownum\\' 
keywords=\\'$keywords\\' typeid=\\'$typeid\\'}
	$listtmp
{/dede:specnote}\r\n";
	}
}

//���븽�ӱ�
//----------------------------------
$arcID = $dsql->GetLastID();

$inQuery = "INSERT INTO #@__addonspec(aid,typeid,note) VALUES ('$arcID','$typeid','$notelist');";

$dsql->SetQuery($inQuery);
if(!$dsql->ExecuteNoneQuery()){
	$dsql->SetQuery("Delete From #@__archives where ID='$arcID'");
	$dsql->ExecuteNoneQuery();
	$dsql->Close();
	ShowMsg("�����ݱ��浽���ݿ⸽�ӱ� addonspec ʱ��������ԭ��","-1");
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
<a href='spec_add.php?cid=$typeid'><u>������ר��</u></a>
&nbsp;&nbsp;
<a href='$artUrl' target='_blank'><u>�鿴ר��</u></a>
&nbsp;&nbsp;
<a href='content_s_list.php'><u>�ѷ���ר�����</u></a>
";

$wintitle = "�ɹ�����ר�⣡";
$wecome_info = "���¹���::����ר��";
$win = new OxWindow();
$win->AddTitle("�ɹ�����ר�⣺");
$win->AddMsgItem($msg);
$winform = $win->GetWindow("hand","&nbsp;",false);
$win->Display();
?>