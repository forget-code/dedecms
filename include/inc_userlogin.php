<?php 
require_once(dirname(__FILE__)."/config_base.php");
session_start();

//�����û��Ƿ���Ȩʹ��ĳ����
function TestPurview($n)
{
	$rs = false;
	$purview = $GLOBALS['cuserLogin']->getPurview();
  
  if(eregi('admin_AllowAll',$purview)) return true;
  if($n=="") return true;
  
  if(!isset($GLOBALS['groupRanks'])) $GLOBALS['groupRanks'] = explode(' ',$purview);
	$ns = explode(',',$n);
	foreach($ns as $n){ //ֻҪ�ҵ�һ��ƥ���Ȩ�ޣ�������Ϊ�û���Ȩ���ʴ�ҳ��
	  if($n=="") continue;
	  if(in_array($n,$GLOBALS['groupRanks'])){ $rs = true; break; }
  }
  return $rs;
}

function CheckPurview($n)
{
  if(!TestPurview($n)){
  	ShowMsg("�Բ�����û��Ȩ��ִ�д˲�����<br/><br/><a href='javascript:history.go(-1);'>����˷�����һҳ&gt;&gt;</a>",'javascript:;');
  	exit();
  }
}

//�Ƿ�ûȨ������(��������Ա)
function TestAdmin(){
	$purview = $GLOBALS['cuserLogin']->getPurview();
  if(eregi('admin_AllowAll',$purview)) return true;
  else return false;
}

$DedeUserCatalogs = Array();
//����û���Ȩ��������ĿID
function GetMyCatalogs($dsql,$cid)
{
	$GLOBALS['DedeUserCatalogs'][] = $cid;
	$dsql->SetQuery("Select ID From #@__arctype where reID='$cid'");
	$dsql->Execute($cid);
	while($row = $dsql->GetObject($cid)){
		GetMyCatalogs($dsql,$row->ID);
	}
}
function MyCatalogs(){
	if(count($GLOBALS['DedeUserCatalogs'])==0){
		$dsql = new DedeSql(false);
		GetMyCatalogs($dsql,$GLOBALS['cuserLogin']->getUserChannel());
		$dsql->Close();
	}
	return $GLOBALS['DedeUserCatalogs'];
}

//����û��Ƿ���Ȩ�޲���ĳ��Ŀ
function CheckCatalog($cid,$msg){
	if($GLOBALS['cuserLogin']->getUserChannel()=="0"||TestAdmin()) return true;
	if(!in_array($cid,MyCatalogs())){
		ShowMsg(" $msg <br/><br/><a href='javascript:history.go(-1);'>����˷�����һҳ&gt;&gt;</a>",'javascript:;');
  	exit();
	}
  return true;
}


//��¼��
class userLogin
{
	var $userName = "";
	var $userPwd = "";
	var $userID = "";
	var $userType = "";
	var $userChannel = "";
	var $userPurview = "";
	var $keepUserIDTag = "dede_admin_id";
	var $keepUserTypeTag = "dede_admin_type";
	var $keepUserChannelTag = "dede_admin_channel";
	var $keepUserNameTag = "dede_admin_name";
	var $keepUserPurviewTag = "dede_admin_purview";
	//php5���캯��
	function __construct()
 	{
 		if(isset($_SESSION[$this->keepUserIDTag])){
			$this->userID=$_SESSION[$this->keepUserIDTag];
			$this->userType=$_SESSION[$this->keepUserTypeTag];
			$this->userChannel=$_SESSION[$this->keepUserChannelTag];
			$this->userName=$_SESSION[$this->keepUserNameTag];
			$this->userPurview=$_SESSION[$this->keepUserPurviewTag];
	  }
  }
	function userLogin(){
		$this->__construct();
	}
	//�����û��Ƿ���ȷ
	function checkUser($username,$userpwd)
	{
		//ֻ�����û�����������0-9,a-z,A-Z,'@','_','.','-'��Щ�ַ�
		$this->userName = ereg_replace("[^0-9a-zA-Z_@\!\.-]","",$username);
		$this->userPwd = ereg_replace("[^0-9a-zA-Z_@\!\.-]","",$userpwd);
		$pwd = substr(md5($this->userPwd),0,24);
		$dsql = new DedeSql(false);
		$dsql->SetQuery("Select * From #@__admin where userid like '".$this->userName."' limit 0,1");
		$dsql->Execute();
		$row = $dsql->GetObject();
		if(!isset($row->pwd)){
			$dsql->Close();
			return -1;
		}
		else if($pwd!=$row->pwd){
			$dsql->Close();
			return -2;
		}
		else{
			$loginip = GetIP();
			$this->userID = $row->ID;
			$this->userType = $row->usertype;
			$this->userChannel = $row->typeid;
			$this->userName = $row->uname;
			$groupSet = $dsql->GetOne("Select * From #@__admintype where rank='".$row->usertype."'");
			$this->userPurview = $groupSet['purviews'];
			$dsql->SetQuery("update #@__admin set loginip='$loginip',logintime='".strftime("%Y-%m-%d %H:%M:%S",mytime())."' where ID='".$row->ID."'");
			$dsql->ExecuteNoneQuery();
			$dsql->Close();
			return 1;
		}
	}
	//�����û��ĻỰ״̬
	//�ɹ����� 1 ��ʧ�ܷ��� -1
	function keepUser()
	{
		if($this->userID!=""&&$this->userType!="")
		{
			session_register($this->keepUserIDTag);
			$_SESSION[$this->keepUserIDTag] = $this->userID;
			
			session_register($this->keepUserTypeTag);
			$_SESSION[$this->keepUserTypeTag] = $this->userType;
			
			session_register($this->keepUserChannelTag);
			$_SESSION[$this->keepUserChannelTag] = $this->userChannel;
			
			session_register($this->keepUserNameTag);
			$_SESSION[$this->keepUserNameTag] = $this->userName;
			
			session_register($this->keepUserPurviewTag);
			$_SESSION[$this->keepUserPurviewTag] = $this->userPurview;
			
			return 1;
		}
		else
			return -1;
	}
	//�����û��ĻỰ״̬
	function exitUser()
	{
		@session_unregister($this->keepUserIDTag);
		@session_unregister($this->keepUserTypeTag);
		@session_unregister($this->keepUserChannelTag);
		@session_unregister($this->keepUserNameTag);
		@session_unregister($this->keepUserPurviewTag);
		session_destroy();
	}
	//-----------------------------
	//����û�����Ƶ����ֵ
	//-----------------------------
	function getUserChannel(){
		if($this->userChannel!="") return $this->userChannel;
		else return -1;
	}
	//����û���Ȩ��ֵ
	function getUserType(){
		if($this->userType!="") return $this->userType;
		else return -1;
	}
	function getUserRank(){
		return $this->getUserType();
	}
	//����û���ID
	function getUserID(){
		if($this->userID!="") return $this->userID;
		else return -1;
	}
	//����û��ı���
	function getUserName(){
		if($this->userName!="") return $this->userName;
		else return -1;
	}
	//�û�Ȩ�ޱ�
	function getPurview(){
		return $this->userPurview;
	}
}
?>