<?php 
require_once(dirname(__FILE__)."/config.php");
CheckPurview('sys_Data');
if(empty($action)) $action = '';

/*-------------------------------
//�г����ݿ������ֶ�
function __getfields()
--------------------------------*/
if($action=='getfields'){
	header("Pragma:no-cache\r\n");
  header("Cache-Control:no-cache\r\n");
  header("Expires:0\r\n");
	header("Content-Type: text/html; charset=gb2312");
	$dsql = new DedeSql(false);
	if(!$dsql->linkID){
		echo "<font color='red'>��������Դ�����ݿ�ʧ�ܣ�</font><br>";
		echo $qbutton;
		exit();
	}
	$dsql->GetTableFields($exptable);
	echo "<div style='border:1px solid #ababab;background-color:#FEFFF0;margin-top:6px;padding:3px;line-height:160%'>";
	echo "��(".$exptable.")���е��ֶΣ�<br>";
	while($row = $dsql->GetFieldObject()){
		echo "<a href=\"javascript:pf('{$row->name}')\"><u>".$row->name."</u></a>\r\n";
	}
	echo "</div>";
	$dsql->Close();
	exit();
}
/*-------------------------------
//�����û����ã���ջ�Ա����
function __Apply()
--------------------------------*/
else if($action=='apply'){
	if(empty($validate)) $validate=="";
  else $validate = strtolower($validate);
  $svali = GetCkVdValue();
  if($validate=="" || $validate!=$svali){
	  ShowMsg("��ȫȷ���벻��ȷ!","javascript:;");
	  exit();
  }
  /*
  action = apply 
quickfield = title 
exptable = dede_addonspec 
rpfield = 
rptype = replace 
rpstring = r 
tostring = s 
  */
  if($quickfield=='title'){
  	$exptable = '#@__archives';
  	$rpfield = 'title';
  }
  else if($quickfield=='body'){
  	$exptable = '#@__addonarticle';
  	$rpfield = 'body';
  }
  if($exptable==''||$rpfield==''){
  	ShowMsg("��ָ�����ݱ���ֶΣ�","javascript:;");
    exit();
  }
  if($rpstring==''){
  	ShowMsg("��ָ�����滻���ݣ�","javascript:;");
    exit();
  }
  $dsql = new DedeSql(false);
  
  if($rptype=='replace'){
  	if(!empty($condition)) $condition = " where $condition ";
    else $condition = "";
  	$rs = $dsql->ExecuteNoneQuery("Update $exptable set $rpfield=Replace($rpfield,'$rpstring','$tostring') $condition ");
    $dsql->Close();
    if($rs) ShowMsg("�ɹ���������滻��","javascript:;");
    else ShowMsg("�����滻ʧ�ܣ�","javascript:;");
    exit();
  }else{
  	if(!empty($condition)) $condition = " And $condition ";
    else $condition = "";
  	$rpstring = stripslashes($rpstring);
  	$rpstring2 = str_replace("\\","\\\\",$rpstring);
  	$rpstring2 = str_replace("'","\\'",$rpstring2);
  	$dsql->SetQuery("Select $keyfield,$rpfield From $exptable where $rpfield REGEXP '$rpstring2'  $condition ");
  	$dsql->Execute();
  	$tt = $dsql->GetTotalRow();
  	if($tt==0){
  		 $dsql->Close();
       ShowMsg("������ָ���������Ҳ����κζ�����","javascript:;");
       exit();
  	}
  	$oo = 0;
  	while($row = $dsql->GetArray()){
  		$kid = $row[$keyfield];
  		$rpf = eregi_replace($rpstring,$tostring,$row[$rpfield]);
  		$rs = $dsql->ExecuteNoneQuery("Update $exptable set $rpfield='$rpf' where $keyfield='$kid' ");
  		if($rs) $oo++;
  	}
  	ShowMsg("���ҵ� $tt ����¼���ɹ��滻�� $oo ����","javascript:;");
    exit();
  }
}

?>