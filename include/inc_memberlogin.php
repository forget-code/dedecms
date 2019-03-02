<?php 
require_once(dirname(__FILE__)."/config_base.php");

//����û��ϴ��ռ�
function GetUserSpace($uid,$dsql){
	$row = $dsql->GetOne("select sum(filesize) as fs From #@__uploads where memberID='$uid'; ");
	return $row['fs'];
}

function CheckUserSpace($uid){
	global $cfg_mb_max;
	$dsql = new DedeSql(false);
	$hasuse = GetUserSpace($uid,$dsql);
	$maxSize = $cfg_mb_max * 1024 * 1024;
	if($hasuse >= $maxSize){
		 $dsql->Close();
		 ShowMsg('��Ŀռ��������������ϴ����ļ���','-1');
		 exit();
	}
}

//����û��ĸ�������
function CheckAddonType($aname){
	global $cfg_mb_mediatype;
	if(empty($cfg_mb_mediatype)){
		$cfg_mb_mediatype = "jpg|gif|png|swf|mpg|mp3|rm|rmvb|wmv|asf|wma|zip|rar|doc|xsl|ppt|wps";
	}
	$anames = explode('.',$aname);
	$atype = $anames[count($anames)-1];
	if(count($anames)==1) return false;
	else{
		$atype = strtolower($atype);
		$cfg_mb_mediatypes = explode('|',trim($cfg_mb_mediatype));
		if(in_array($atype,$cfg_mb_mediatypes)) return true;
		else return false;
	}
}

//��ȡʡ����Ϣ
function GetProvince($pid,$dsql){
	global $dsql;
	if($pid<=0) return "δ֪";
	else{
		$row = $dsql->GetOne("Select name From #@__area where eid='$pid';");
		return $row['name'];
	}
}

//------------------------
//��վ��Ա��¼��
//------------------------
class MemberLogin
{
	var $M_ID;
	var $M_LoginID;
	var $M_Type;
	var $M_Money;
	var $M_UserName;
	var $M_MySafeID;
	var $M_LoginTime;
	var $M_KeepTime;
	var $M_UserPwd;
	var $M_UpTime;
 	var $M_ExpTime;
 	var $M_HasDay;
	//php5���캯��
	function __construct($kptime = 0)
 	{
 		if(empty($kptime)) $this->M_KeepTime = 3600 * 24 * 15;
 		else $this->M_KeepTime = $kptime;
 		$this->M_ID = $this->GetNum(GetCookie("DedeUserID"));
 		$this->M_LoginTime = GetCookie("DedeLoginTime");
 		if(empty($this->M_LoginTime)) $this->M_LoginTime = time();
 		if(empty($this->M_ID)){
 			$this->ResetUser();
 		}else{
 		  $this->M_ID = ereg_replace("[^0-9]","",$this->M_ID);
 		  $dsql = new DedeSql(false);
 		  $row = $dsql->GetOne("Select ID,userid,pwd,uname,membertype,money,uptime,exptime From #@__member where ID='{$this->M_ID}' ");
 		  if(is_array($row)) $dsql->ExecuteNoneQuery("update #@__member set logintime='".mytime()."' where ID='".$row['ID']."';");
 		  $dsql->Close();
 		  if(is_array($row)){
 		    $this->M_LoginID = $row['userid'];
 		    $this->M_UserPwd = $row['pwd'];
 		    $this->M_Type = $row['membertype'];
 		    $this->M_Money = $row['money'];
 		    $this->M_UserName = $row['uname'];
 		    $this->M_UpTime = $row['uptime'];
 		    $this->M_ExpTime = $row['exptime'];
 		    $this->M_HasDay = 0;
 		    if($this->M_UpTime>0){
 		    	$nowtime = time();
 		    	$mhasDay = $this->M_ExpTime - ceil(($nowtime - $this->M_UpTime)/3600/24) + 1;
 		    	$this->M_HasDay = $mhasDay;
 		    }
 		  }else{
 		  	$this->ResetUser();
 		  }
 	  }
  }
  function MemberLogin($kptime = 0){
  	$this->__construct($kptime);
  }
  //�˳�cookie�ĻỰ
  function ExitCookie(){
  	$this->ResetUser();
  }
  //��֤�û��Ƿ��Ѿ���¼
  function IsLogin(){
  	if($this->M_ID > 0) return true;
  	else return false;
  }
  //�����û���Ϣ
  function ResetUser(){
  	$this->M_ID = 0;
 		$this->M_LoginID = "";
 		$this->M_Type = -1;
 		$this->M_Money = 0;
 		$this->M_UserName = "";
 		$this->M_LoginTime = 0;
 		$this->M_UpTime = 0;
 		$this->M_ExpTime = 0;
 		$this->M_HasDay = 0;
 		DropCookie("DedeUserID");
 		DropCookie("DedeLoginTime");
  }
  //��ȡ����ֵ
  function GetNum($fnum){
	  $fnum = ereg_replace("[^0-9\.]","",$fnum);
	  return $fnum;
  }
  //�û���¼
  function CheckUser($loginuser,$loginpwd){
 		$loginuser = ereg_replace("[;%'\\\?\*\$]","",$loginuser);
 		$dsql = new DedeSql(false);
 		$row = $dsql->GetOne("Select ID,pwd From #@__member where userid='$loginuser' ");
 		$dsql->Close();
 		if(is_array($row)) //�û�����
 		{
 		    //�������
 		   if($row['pwd'] != $loginpwd){ return -1; }
 		   else{ //�ɹ���¼
 		   	 $this->PutLoginInfo($row['ID']);
 		     return 1;
 		   }
 	  }else{ //�û�������
 	  	return 0;
 	  }
  }
  //�����û�cookie
  function PutLoginInfo($uid){
  	$this->M_ID = $uid;
 		$this->M_LoginTime = mytime();
 		PutCookie("DedeUserID",$uid,$this->M_KeepTime);
 		PutCookie("DedeLoginTime",$this->M_LoginTime,$this->M_KeepTime);
  }
  //��û�ԱĿǰ��״̬
  function GetSta($dsql)
  {
  	$sta = "";
  	if($this->M_Type==0) $sta .= "��Ŀǰ������ǣ�δ��˻�Ա ";
  	else{
  		$row = $dsql->GetOne("Select membername From #@__arcrank where rank='".$this->M_Type."'");
  		$sta .= "��Ŀǰ������ǣ�".$row['membername'];
  		if($this->M_Type>10){
  			$sta .= " ʣ������: ".$this->M_HasDay."  �� ";
  		}
  	}
  	$sta .= " ��Ŀǰӵ�н�ң�".$this->M_Money." ����";
  	return $sta;
  }
}
?>