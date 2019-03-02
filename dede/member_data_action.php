<?php 
require_once(dirname(__FILE__)."/config.php");
CheckPurview('member_Data');
if(empty($action)) $action = '';

/*-------------------------------
//�г����ݿ���ı�
function __gettables()
--------------------------------*/
if($action=='gettables'){
	header("Pragma:no-cache\r\n");
  header("Cache-Control:no-cache\r\n");
  header("Expires:0\r\n");
	header("Content-Type: text/html; charset=gb2312");
	$qbutton = "<input type='button' name='seldbtable' value='ѡ�����ݱ�' class='nbt' onclick='SelectedTable()'>\r\n";
	if($dbptype==2 && $dbname==""){
		echo "<font color='red'>��ûָ�����ݿ����ƣ�</font><br>";
		echo $qbutton;
		exit();
	}
	if($dbptype==3 
	&& (empty($dbhost) || empty($dbname) || empty($dbuser)))
	{
		echo "<font color='red'>��ѡ���ˡ�ָ���µĵ�¼��Ϣ����������д���������ݿ��¼ѡ�</font><br>";
		echo $qbutton;
		exit();
	}
	if($dbptype==1){
		$dsql = new DedeSql(false);
	}
	else if($dbptype==2){
		 $dsql = new DedeSql(false,false);
		 $dsql->SetSource($cfg_dbhost,$cfg_dbuser,$cfg_dbpwd,$dbname,'');
		 $dsql->Open(false);
	}
	else if($dbptype==3){
		$dsql = new DedeSql(false,false);
		$dsql->SetSource($dbhost,$dbuser,$dbpwd,$dbname,'');
		$dsql->Open(false);
	}
	if(!$dsql->linkID){
		echo "<font color='red'>�������ݿ�ʧ�ܣ�</font><br>";
		echo $qbutton;
		exit();
	}
	$dsql->SetQuery("Show Tables");
  $dsql->Execute('t');
  if($dsql->GetError()!=""){
  	echo "<font color='red'>�Ҳ�������ָ�������ݿ⣡ $dbname</font><br>";
		echo $qbutton;
  }
  echo "<select name='exptable' id='exptable' size='10' style='width:60%' onchange='ShowFields()'>\r\n";
  while($row = $dsql->GetArray('t')){
	  echo "<option value='{$row[0]}'>{$row[0]}</option>\r\n";
  }
  echo "</select>\r\n";
	$dsql->Close();
	exit();
}
/*-------------------------------
//�г����ݿ������ֶ�
function __getfields()
--------------------------------*/
if($action=='getfields'){
	header("Pragma:no-cache\r\n");
  header("Cache-Control:no-cache\r\n");
  header("Expires:0\r\n");
	header("Content-Type: text/html; charset=gb2312");
	if($dbptype==1){
		$dsql = new DedeSql(false);
	}
	else if($dbptype==2){
		 $dsql = new DedeSql(false,false);
		 $dsql->SetSource($cfg_dbhost,$cfg_dbuser,$cfg_dbpwd,$dbname,'');
		 $dsql->Open(false);
	}
	else if($dbptype==3){
		$dsql = new DedeSql(false,false);
		$dsql->SetSource($dbhost,$dbuser,$dbpwd,$dbname,'');
		$dsql->Open(false);
	}
	if(!$dsql->linkID){
		echo "<font color='red'>��������Դ�����ݿ�ʧ�ܣ�</font><br>";
		echo $qbutton;
		exit();
	}
	$dsql->GetTableFields($exptable);
	echo "<div style='border:1px solid #ababab;background-color:#FEFFF0;margin-top:6px;padding:3px;line-height:160%'>";
	echo "��(".$exptable.")���е��ֶΣ�<br>";
	while($row = $dsql->GetFieldObject()){
		echo $row->name." ";
	}
	echo "</div>";
	$dsql->Close();
	exit();
}
/*-------------------------------
//�����û����ã���ջ�Ա����
function __saveSetting()
--------------------------------*/
else if($action=='savesetting'){
	if(empty($validate)) $validate=="";
  else $validate = strtolower($validate);
  $svali = GetCkVdValue();
  if($validate=="" || $validate!=$svali){
	  ShowMsg("��ȫȷ���벻��ȷ!","javascript:;");
	  exit();
  }
  if(empty($userfield) || empty($pwdfield)){
  	ShowMsg("�û����������ֶα���ָ����","javascript:;");
  	exit();
  }
  $configfile = dirname(__FILE__)."/../include/config_hand.php";
  $configfile_bak = dirname(__FILE__)."/../include/config_hand_bak.php";
  $dsql = new DedeSql(false);
  $dsql->ExecuteNoneQuery("Update #@__sysconfig set value='$oldtype' where varname='cfg_pwdtype' ");
  $dsql->ExecuteNoneQuery("Update #@__sysconfig set value='$oldmd5len' where varname='cfg_md5len' ");
  $dsql->ExecuteNoneQuery("Update #@__sysconfig set value='$oldsign' where varname='cfg_ddsign' ");
  $dsql->SetQuery("Select varname,value From #@__sysconfig order by aid asc");
  $dsql->Execute();
  copy($configfile,$configfile_bak) or die("��������{$configfile}ʱʧ�ܣ�����Ȩ��");
	$fp = fopen($configfile,'w') or die("��������{$configfile}ʱʧ�ܣ�����Ȩ��");
	flock($fp,3);
	fwrite($fp,"<"."?php\r\n");
  while($row = $dsql->GetArray()){
  	fwrite($fp,"\${$row['varname']} = '".str_replace("'","\\'",$row['value'])."';\r\n");
  }
  fwrite($fp,"?".">");
  fclose($fp);
  $dsql->ExecuteNoneQuery("Delete From #@__member ");
  $dsql->ExecuteNoneQuery("Delete From #@__member_arctype ");
  $dsql->ExecuteNoneQuery("Delete From #@__member_flink ");
  $dsql->ExecuteNoneQuery("Delete From #@__member_guestbook ");
  $dsql->ExecuteNoneQuery("Delete From #@__memberstow ");
  $dsql->Close();
  $nurl = GetCurUrl();
  $nurl = str_replace("savesetting","converdata",$nurl);
  ShowMsg("������ݱ��棬����ձ�ϵͳ�Ļ�Ա���ݣ����ڿ�ʼ�������ݣ�",$nurl);
  exit();
}
/*-------------------------------
//�����û����ã�ת����Ա����
function __ConverData()
--------------------------------*/
else if($action=='converdata'){
	set_time_limit(0);
	if(empty($tgmd5len)) $tgmd5len = 32;
	if($tgmd5len < $cfg_md5len && $tgtype=='md5'){
		ShowMsg("�޷��Ӷ̵�MD5����ת��Ϊ���������룡","javascript:;");
		exit();
	}
	$oldchar = $cfg_db_language;
	$cfg_db_language = $dbchar;
	if($dbptype==1){
		$dsql = new DedeSql(false);
	}
	else if($dbptype==2){
		 $dsql = new DedeSql(false,false);
		 $dsql->SetSource($cfg_dbhost,$cfg_dbuser,$cfg_dbpwd,$dbname,'');
		 $dsql->Open(false);
	}
	else if($dbptype==3){
		$dsql = new DedeSql(false,false);
		$dsql->SetSource($dbhost,$dbuser,$dbpwd,$dbname,'');
		$dsql->Open(false);
	}
	if(!$dsql->linkID){
		ShowMsg("��������Դ�����ݿ�ʧ�ܣ�","javascript:;");
		exit();
	}
	$fieldsql = '';
	$fieldsql = "$userfield,$pwdfield";
	if($emailfield!='') $fieldsql .= ",$emailfield";
	if($unamefield!='') $fieldsql .= ",$unamefield";
	if($sexfield!='') $fieldsql .= ",$sexfield";
	$dsql->SetQuery("Select $fieldsql From $exptable ");
	$dsql->Execute();
	
	$cfg_db_language = $oldchar;
	$dsql2 = new DedeSql(false);
	
	$c = 0;
	
	while($row = $dsql->GetArray()){
		$userid = addslashes($row[$userfield]);
		if($tgtype=='none') $pwd = GetEncodePwd($row[$pwdfield]);
		else if($tgtype=='md5'){
			if($cfg_md5len < $tgmd5len) $pwd = substr($row[$pwdfield],0,$cfg_md5len);
			else $pwd = $row[$pwdfield];
		}else if($tgtype=='md5m16'){
			$pwd = $row[$pwdfield];
		}
		$pwd = addslashes($pwd);
		
		if(empty($unamefield)) $uname = $userid;
		else $uname = addslashes($row[$unamefield]);
		
		if(empty($emailfield)) $email = '';
		else $email = addslashes($row[$emailfield]);
		
		if(empty($sexfield)) $sex = '';
		else{
			$sex = $row[$sexfield];
			if($sex==$sexman) $sex = '��';
			else if($sex==$sexwoman) $sex = 'Ů';
			else $sex = '';
		}
		
		$ntime = time();
		$inQuery = "
 	 INSERT INTO #@__member(userid,pwd,uname,sex,birthday,membertype,money,
 	 weight,height,job,province,city,myinfo,tel,oicq,email,homepage,
 	 jointime,joinip,logintime,loginip,showaddr,address) 
   VALUES ('$userid','$pwd','$uname','$sex','0000-00-00','10','0',
   '0','0','','0','0','','','','$email','','$ntime','$loginip','$ntime','','0','');";
   
   $rs = $dsql2->ExecuteNoneQuery($inQuery);
   if($rs) $c++;
   
	}
	$dsql->Close();
	$dsql2->Close();
	ShowMsg("�ɹ����� ".$c." �����ݣ�","javascript:;");
	exit();
}

?>