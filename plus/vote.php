<?
require(dirname(__FILE__)."/../include/inc_vote.php");
if(empty($dopost)) $dopost = "";
if(empty($aid)) $aid="";
$aid = ereg_replace("[^0-9]","",$aid);
if($aid=="")
{
	ShowMsg("ûָ��ͶƱ��Ŀ��ID��","-1");
	exit();
}
$vo = new DedeVote($aid);
$rsmsg = "";
if($dopost=="send")
{
  if(!empty($voteitem)){
  	$rsmsg = "<br>&nbsp;�㷽�ŵ�ͶƱ״̬��".$vo->SaveVote($voteitem)."<br>";
  }
}
$vo->Close(); //����������ر������ݿ� $vo�ǻ������õ� 

             
$voname = $vo->VoteInfos['votename'];
$totalcount = $vo->VoteInfos['totalcount'];
$starttime = GetDateMk($vo->VoteInfos['starttime']);
$endtime = GetDateMk($vo->VoteInfos['endtime']);
$votelist = $vo->GetVoteResult("98%",30,"30%"); 

//��ʾģ��(��PHP�ļ�)
include_once($cfg_basedir.$cfg_templets_dir."/plus/vote.htm"); 

?>