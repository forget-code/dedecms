<?
require_once(dirname(__FILE__)."/../include/config_base.php");
session_start();
//�������ڼ�����Ա��¼״��
//���ڱ��࿪��session��cookie֧�֣�����������ʱ������������ļ�δ���κ����֮ǰ��
//ʹ��cookie����Ự����һ���ķ��գ������֪������ζ��ʲô������keepUser()�йر�cookie��¼��ѡ�
//-----------����ʹ��˵��-------------------------------
//�����û���¼��
//checkUser(username,userpwd);
//���� 1 ��ʾ�ɹ������� -1 ��ʾ�û�������ȷ��-2 ��ʾ�������

//�����û��Ự״̬��
//keepUser(keeptype,keeptime);
//keeptypeΪ session��cookie��keeptime��λΪ���ӣ�����cookie��Ч
//��ȷ���� 1��ʧ�ܷ��� -1

//����������

//getUserType(); ��ȡ�û�����
//��ϵͳֻ֧�ֳ�������Ա 10��Ƶ���ܱ� 5 ����Ϣ�ɱ� 2 ����Ȩ��
//ʧ�ܷ��� -1

//getUserID(); ��ȡ�û�ID
//��ȷ�򷵻��û�ID��ʧ�ܷ��� -1

//exitUser(); ע���Ự
//------------------------------------------------------
class userLogin
{
	var $userName = "";
	var $userPwd = "";
	var $userID = "";
	var $userType = "";
	var $userChannel = "";
	var $keepUserIDTag = "";
	var $keepUserTypeTag = "";
	var $keepUserChannelTag = "";
	var $keepUserNameTag = "";
	//php5���캯��
	function __construct()
 	{
 		$this->keepUserIDTag="dede_admin_id";
	  $this->keepUserTypeTag="dede_admin_type";
	  $this->keepUserChannelTag="dede_admin_channel";
	  $this->keepUserNameTag="dede_admin_name";
	  
 		if(isset($_SESSION[$this->keepUserIDTag])&&
 		isset($_SESSION[$this->keepUserTypeTag])&&
 		isset($_SESSION[$this->keepUserChannelTag])&&
 		isset($_SESSION[$this->keepUserNameTag]))
		{
			$this->userID=$_SESSION[$this->keepUserIDTag];
			$this->userType=$_SESSION[$this->keepUserTypeTag];
			$this->userChannel=$_SESSION[$this->keepUserChannelTag];
			$this->userName=$_SESSION[$this->keepUserNameTag];
	  }
	  
  }
	function userLogin()
	{
		$this->__construct();
	}
	//�����û��Ƿ���ȷ
	function checkUser($username,$userpwd)
	{
		//ֻ�����û�����������0-9,a-z,A-Z,'@','_','.','-'��Щ�ַ�
		$this->userName = ereg_replace("[^0-9a-zA-Z_@\!\.-]","",$username);
		$this->userPwd = ereg_replace("[^0-9a-zA-Z_@\!\.-]","",$userpwd);
		$pwd = md5($this->userPwd);
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
			$dsql->SetQuery("update #@__admin set loginip='$loginip',logintime='".strftime("%Y-%m-%d %H:%M:%S",time())."' where ID=".$row->ID);
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
		$this->userType = "";
		$this->userID = "";
		$this->userChannel = "";
	}
	//-----------------------------
	//����û�����Ƶ����ֵ
	//-----------------------------
	function getUserChannel()
	{
		if($this->userChannel!="") return $this->userChannel;
		else return -1;
	}
	//����û���Ȩ��ֵ
	function getUserType()
	{
		if($this->userType!="") return $this->userType;
		else return -1;
	}
	function getUserRank()
	{
		return $this->getUserType();
	}
	//����û���ID
	function getUserID()
	{
		if($this->userID!="") return $this->userID;
		else return -1;
	}
	//����û��ı���
	function getUserName()
	{
		if($this->userName!="") return $this->userName;
		else return -1;
	}
}
?>