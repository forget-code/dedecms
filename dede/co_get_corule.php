<?php 
require(dirname(__FILE__)."/config.php");
CheckPurview('co_AddNote');
if(empty($job)) $job="";
if($job=="")
{
     require_once(dirname(__FILE__)."/../include/pub_oxwindow.php");
     $wintitle = "����ɼ�����";
	   $wecome_info = "<a href='co_main.php'><u>�ɼ������</u></a>::����ɼ�����";
	   $win = new OxWindow();
	   $win->Init("co_get_corule.php","js/blank.js","POST");
	   $win->AddHidden("job","yes");
	   $win->AddTitle("��������������Ҫ������ı����ã�");
	   $win->AddMsgItem("<textarea name='notes' style='width:100%;height:300'></textarea>");
	   $winform = $win->GetWindow("ok");
	   $win->Display();
     exit();
}
else
{
   	  CheckPurview('co_AddNote');
   	  require_once(dirname(__FILE__)."/../include/pub_dedetag.php");
   	  $dtp = new DedeTagParse();
   	  $dbnotes = $notes;
   	  $notes = stripslashes($notes);
      $dtp->LoadString($notes);
   	  if(!is_array($dtp->CTags))
      {
	      ShowMsg("�ù��򲻺Ϸ����޷�����!","-1");
	      $dsql->Close();
	      exit();
      }
      $ctag = $dtp->GetTagByName("item");
	    $query = "
	        INSERT INTO #@__conote(typeid,gathername,language,lasttime,savetime,noteinfo) 
          VALUES('".$ctag->GetAtt('typeid')."', '".$ctag->GetAtt('name')."',
          '".$ctag->GetAtt('language')."', '0','".mytime()."', '".$dbnotes."');
	    ";
	    $dsql = new DedeSql(false);
	    $rs = $dsql->ExecuteNoneQuery($query);
	    $dsql->Close();
	    ShowMsg("�ɹ�����һ������!","co_main.php");
	    exit();
}
?>