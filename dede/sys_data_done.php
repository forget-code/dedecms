<?
require_once(dirname(__FILE__)."/config.php");
CheckPurview('sys_Data');
if(empty($dopost)) $dopost="";
$bkdir = dirname(__FILE__)."/".$cfg_backup_dir;
@ob_start();
@set_time_limit(0);

function PutInfo($msg1,$msg2)
{
	$msginfo = "
<html>\n<head>
<meta http-equiv='Content-Type' content='text/html; charset=gb2312' />
<title>DEDECMS ��ʾ��Ϣ</title>
<base target='_self'/>\n</head>\n<body leftmargin='0' topmargin='0'>\n<center>
<br/>
<div style='width:400px;padding-top:4px;height:24;font-size:10pt;border-left:1px solid #cccccc;border-top:1px solid #cccccc;border-right:1px solid #cccccc;background-color:#DBEEBD;'>DEDECMS ��ʾ��Ϣ��</div>
<div style='width:400px;height:100;font-size:10pt;border:1px solid #cccccc;background-color:#F4FAEB'>
<span style='line-height:160%'><br/>{$msg1}</span>
<br/><br/></div>\r\n{$msg2}";
 echo $msginfo."</center>\n</body>\n</html>";
}

function RpLine($str){
	$str = str_replace("\r","\\r",$str);
	$str = str_replace("\n","\\n",$str);
	return $str;
}

/*��������
function __bak_data();
*/
if($dopost=="bak")
{
	if(empty($tablearr)){
		ShowMsg('��ûѡ���κα�','javascript:;');
		exit();
	}
  if(!is_dir($bkdir)){
  	MkdirAll($bkdir,777);
  	CloseFtp();
  }
	//��ʼ��ʹ�õ��ı���
	$tables = explode(',',$tablearr);
	if(empty($isstruct)) $isstruct = 0;
	if(empty($nowtable)) $nowtable = "";
	if(empty($startpos)) $startpos = 0;
	if(empty($fsize)) $fsize = 1024;
	$fsizeb = $fsize * 1024;
	
	
	//��һҳ�Ĳ���
	if($nowtable=="")
	{
	  $tmsg = "";
	  $dh = dir($bkdir);
	  while($filename=$dh->read()){
		   if(!ereg("txt$",$filename)) continue;
		   $filename = $bkdir."/$filename";
		   if(!is_dir($filename)) unlink($filename);
	  }
	  $dh->close();
	  $tmsg .= "�������Ŀ¼���������...<br>";
	  if($isstruct==1){
		    $bkfile = $bkdir."/tables_struct_".substr(md5(mytime().mt_rand(1000,5000)),0,16).".txt";
		    $dsql = new DedeSql(false);
		    $mysql_version = $dsql->GetVersion();
        $mysql_versions = explode(".",trim($mysql_version));
        $mysql_version = $mysql_versions[0].".".$mysql_versions[1];
		    $fp = fopen($bkfile,"w");
		    foreach($tables as $t){
		 	     fwrite($fp,"DROP TABLE IF EXISTS `$t`;\r\n\r\n");
		 	     $dsql->SetQuery("SHOW CREATE TABLE ".$dsql->dbName.".".$t);
		 	     $dsql->Execute();
		 	     $row = $dsql->GetArray();
		 	     
		 	     //�������ݿ�汾���ݱ�ṹ
		 	     $eng1 = "ENGINE=MyISAM DEFAULT CHARSET=".$cfg_db_language;
		 	     $eng2 = "ENGINE=MyISAM AUTO_INCREMENT=([0-9]{1,}) DEFAULT CHARSET=".$cfg_db_language;
		 	     if($datatype==4.0 && $mysql_version > 4.0){
		 	     	 $tableStruct = eregi_replace($eng1,"TYPE=MyISAM",$row[1]);
		 	     	 $tableStruct = eregi_replace($eng2,"TYPE=MyISAM",$row[1]);
		 	     }
		 	     else if($datatype==4.1 && $mysql_version < 4.1){
		 	     	 $tableStruct = eregi_replace("TYPE=MyISAM",$eng1,$row[1]);
		 	     }else{
		 	     	 $tableStruct = $row[1];
		 	     }
		 	     
           fwrite($fp,"".$tableStruct.";\r\n\r\n");
		    }
		    fclose($fp);
		    $dsql->Close();
		    $tmsg .= "�������ݱ�ṹ��Ϣ���...<br>";
	   }
	   $tmsg .= "<font color='red'>���ڽ������ݱ��ݵĳ�ʼ�����������Ժ�...</font>";
	   $doneForm = "<form name='formgo' method='post' action='sys_data_done.php?dopost=bak'>
<input type='hidden' name='isstruct' value='$isstruct'>
<input type='hidden' name='fsize' value='$fsize'>
<input type='hidden' name='tablearr' value='$tablearr'>
<input type='hidden' name='nowtable' value='".$tables[0]."'>
<input type='hidden' name='startpos' value='0'>
</form>
<script language='javascript'>function doSubmit(){ document.formgo.submit(); } setTimeout('doSubmit()',500);</script>\n";
	   PutInfo($tmsg,$doneForm);
	   exit();
  }else{ //ִ�з�ҳ����
	   $dsql = new DedeSql(false); 
	   $j = 0;
	   $fs = "";
	   $bakStr = "";
	   //����������ֶ���Ϣ
	   $dsql->GetTableFields($nowtable);
	   $intable = "INSERT INTO `$nowtable` VALUES(";
	   while($r = $dsql->GetFieldObject()){
	      $fs[$j] = trim($r->name); $j++;
	   }
	   $fsd = $j-1;
	   /*
	   $intable = "~sql:Insert Into $nowtable(";
	   while($r = $dsql->GetFieldObject()){
	      $fs[$j] = trim($r->name);
	      $intable .= $fs[$j].",";
	      $j++;
	   }
	   $fsd = $j-1;
	   $intable = ereg_replace(",$","",$intable).") Values(";
	   */
	   //��ȡ�������
	   $dsql->SetQuery("Select * From $nowtable");
	   $dsql->Execute();
	   $m = 0;
	   $bakfilename = "$bkdir/{$nowtable}_{$startpos}_".substr(md5(mytime().mt_rand(1000,5000)),0,16).".txt";
	   while($row2 = $dsql->GetArray())
	   {
		    if($m < $startpos){ $m++; continue; }
		    //��������Ƿ�ﵽ�涨��С
		    if(strlen($bakStr) > $fsizeb)
		    {
		      $fp = fopen($bakfilename,"w");
		      fwrite($fp,$bakStr);
		      fclose($fp);
		      $tmsg = "<font color='red'>��ɵ�{$m}����¼�ı��ݣ���������{$nowtable}...</font>";
	        $doneForm = "<form name='formgo' method='post' action='sys_data_done.php?dopost=bak'>
        <input type='hidden' name='isstruct' value='$isstruct'>
        <input type='hidden' name='fsize' value='$fsize'>
        <input type='hidden' name='tablearr' value='$tablearr'>
        <input type='hidden' name='nowtable' value='$nowtable'>
        <input type='hidden' name='startpos' value='$m'>
      </form><script language='javascript'>function doSubmit(){ document.formgo.submit(); } setTimeout('doSubmit()',500);</script>\n";
	        PutInfo($tmsg,$doneForm);
	        exit();
		    }
		    //�������
		    $line = $intable;
		    for($j=0;$j<=$fsd;$j++){
			    if($j < $fsd) $line .= "'".RpLine(addslashes($row2[$fs[$j]]))."',";
			    else $line .= "'".RpLine(addslashes($row2[$fs[$j]]))."');\r\n";
		    }
		    $m++;
		    $bakStr .= $line;
	   }
	   //������ݱȾ�����ֵС
	   if($bakStr!=""){
	     $fp = fopen($bakfilename,"w");
	     fwrite($fp,$bakStr);
	     fclose($fp);
	   }
	   for($i=0;$i<count($tables);$i++){
	   	  if($tables[$i]==$nowtable){
	   	  	if(isset($tables[$i+1])){
	   	  		 $nowtable = $tables[$i+1];
	   	  		 $startpos = 0;
	   	  		 break;
	   	  	}else{
	   	  		 $dsql->Close();
	   	  		 PutInfo("����������ݱ��ݣ�","");
	           exit();
	   	  	}
	   	  }
	   }
	   $tmsg = "<font color='red'>��ɵ�{$m}����¼�ı��ݣ���������{$nowtable}...</font>";
	   $doneForm = "<form name='formgo' method='post' action='sys_data_done.php?dopost=bak'>
        <input type='hidden' name='isstruct' value='$isstruct'>
        <input type='hidden' name='fsize' value='$fsize'>
        <input type='hidden' name='tablearr' value='$tablearr'>
        <input type='hidden' name='nowtable' value='$nowtable'>
        <input type='hidden' name='startpos' value='$startpos'>
      </form><script language='javascript'>function doSubmit(){ document.formgo.submit(); } setTimeout('doSubmit()',500);</script>\n";
	    PutInfo($tmsg,$doneForm);
	    exit();
	 }
	 //��ҳ���ݴ������
}
/* ��ԭ����
function __re_data();
*/
else if($dopost=="redat")
{
	if($bakfiles==""){
		ShowMsg('ûָ���κ�Ҫ��ԭ���ļ�!','javascript:;');
		exit();
	}
	$bakfilesTmp = $bakfiles;
	$bakfiles = explode(',',$bakfiles);
  if(empty($structfile)) $structfile = "";
  if(empty($delfile)) $delfile = 0;
  if(empty($startgo)) $startgo = 0;
  if($startgo==0 && $structfile!=""){
  		$tbdata = "";
  		$fp = fopen("$bkdir/$structfile",'r');
  		while(!feof($fp)){
  			$tbdata .= fgets($fp,1024);
  		}
  		fclose($fp);
  		$querys = explode(';',$tbdata);
  		$dsql = new DedeSql(false);
  		foreach($querys as $q) $dsql->ExecuteNoneQuery(trim($q).';');
  		$dsql->Close();
  		if($delfile==1) @unlink("$bkdir/$structfile");
  		$tmsg = "<font color='red'>������ݱ���Ϣ��ԭ��׼����ԭ����...</font>";
	    $doneForm = "<form name='formgo' method='post' action='sys_data_done.php?dopost=redat'>
        <input type='hidden' name='startgo' value='1'>
        <input type='hidden' name='delfile' value='$delfile'>
        <input type='hidden' name='bakfiles' value='$bakfilesTmp'>
      </form><script language='javascript'>function doSubmit(){ document.formgo.submit(); } setTimeout('doSubmit()',500);</script>\n";
	    PutInfo($tmsg,$doneForm);
	    exit();
  }
  else
  {
  	$nowfile = $bakfiles[0];
  	$bakfilesTmp = ereg_replace($nowfile."[,]{0,1}","",$bakfilesTmp);
  	$oknum=0;
  	if( filesize("$bkdir/$nowfile") > 0 ){
  	   $dsql = new DedeSql(false);
  	   $fp = fopen("$bkdir/$nowfile",'r');
  	   while(!feof($fp)){
  		    $line = trim(fgets($fp,512*1024));
  		    if($line=="") continue;
  		    $rs = $dsql->ExecuteNoneQuery($line);
  		    if($rs) $oknum++;
  	   }
  	   fclose($fp);
  	   $dsql->Close();
    }
  	if($delfile==1) @unlink("$bkdir/$nowfile");
  	if($bakfilesTmp==""){
  		ShowMsg('�ɹ���ԭ�����ļ�������!','javascript:;');
		  exit();
  	}
  	$tmsg = "�ɹ���ԭ{$nowfile}��{$oknum}����¼<br/><br/>����׼����ԭ��������...";
	    $doneForm = "<form name='formgo' method='post' action='sys_data_done.php?dopost=redat'>
        <input type='hidden' name='startgo' value='1'>
        <input type='hidden' name='delfile' value='$delfile'>
        <input type='hidden' name='bakfiles' value='$bakfilesTmp'>
      </form><script language='javascript'>function doSubmit(){ document.formgo.submit(); } setTimeout('doSubmit()',500);</script>\n";
	    PutInfo($tmsg,$doneForm);
	    exit();
  }
}
?>