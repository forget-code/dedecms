<?
require_once("config_base.php");
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
	var $userName="";
	var $userPwd="";
	var $userID="";
	var $userType="";
	var $userChannel="";
	var $userMd5="";
	var $keepUserIDTag="dede_admin_id";
	var $keepUserTypeTag="dede_admin_type";
	var $keepUserChannelTag="dede_admin_channel";
	var $keepUserNameTag="dede_admin_name";
	var $safeMd5 = "d877f7sa8f7rbg8b7n";
	var $keepSafeMD5 = "dede_md5";
	function userLogin()
	{
		if
		(isset($_COOKIE[$this->keepSafeMD5])&&isset($_COOKIE[$this->keepUserIDTag])&&isset($_COOKIE[$this->keepUserTypeTag])&&isset($_COOKIE[$this->keepUserChannelTag])&&isset($_COOKIE[$this->keepUserNameTag]))
		{
			$this->userID=$_COOKIE[$this->keepUserIDTag];
			$this->userType=$_COOKIE[$this->keepUserTypeTag];
			$this->userChannel=$_COOKIE[$this->keepUserChannelTag];
			$this->userName=$_COOKIE[$this->keepUserNameTag];
			if($_COOKIE[$this->keepSafeMD5]!=md5($this->safeMd5.$this->userID.$this->userName))
			{echo "MD5 ��ݰ�ȫ��֤�����<a href='login.php'>�����µ�¼</a>";exit();}
	    }
	}
	//�����û��Ƿ���ȷ
	function checkUser($username,$userpwd)
	{
		//ֻ�����û�����������0-9,a-z,A-Z,'@','_','.','-'��Щ�ַ�
		$this->userName = ereg_replace("[^0-9a-zA-Z_@\!\.-]","",$username);
		$this->userPwd = ereg_replace("[^0-9a-zA-Z_@\!\.-]","",$userpwd);
		$conn = connectMySql();
		$pwd = md5($this->userPwd);
		$rs = mysql_query("Select * From dede_admin where userid like '".$this->userName."' limit 0,1",$conn);
		$row = mysql_fetch_object($rs);
		if(!isset($row->pwd))
		{
			return -1;
		}
		else if($pwd!=$row->pwd)
		{
			return -2;
		}
		else
		{
			if(isset($_SERVER["REMOTE_ADDR"]))	$loginip = $_SERVER["REMOTE_ADDR"];
			else $loginip="PHP���ô���";
			$this->userID = $row->ID;
			$this->userType = $row->usertype;
			$this->userChannel = $row->typeid;
			$this->userName = $row->uname;
			$this->userMd5 = md5($this->safeMd5.$this->userID.$this->userName);
			$squery = "update dede_admin set loginip='$loginip',logintime='".strftime("%Y-%m-%d %H:%M:%S",time())."' where ID=".$row->ID;
			mysql_query($squery,$conn);
			return 1;
		}
	}
	//�����û��ĻỰ״̬
	//�ɹ����� 1 ��ʧ�ܷ��� -1
	function keepUser()
	{
		if($this->userID!=""&&$this->userType!="")
		{
			setcookie($this->keepUserIDTag,$this->userID,time()+72000,"/");
			setcookie($this->keepUserTypeTag,$this->userType,time()+72000,"/");
			setcookie($this->keepUserChannelTag,$this->userChannel,time()+72000,"/");
			setcookie($this->keepUserNameTag,$this->userName,time()+72000,"/");
			setcookie($this->keepSafeMD5,$this->userMd5,time()+72000,"/");
			return 1;
		}
		else
			return -1;
	}
	//�����û��ĻỰ״̬
	function exitUser()
	{
		setcookie($this->keepUserIDTag,"",time()-72000,"/");
		setcookie($this->keepUserTypeTag,"",time()-72000,"/");
		setcookie($this->keepUserChannelTag,"",time()-72000,"/");
		setcookie($this->keepUserNameTag,"",time()-72000,"/");
		setcookie($this->keepSafeMD5,"",time()-72000,"/");
		$this->userType = "";
		$this->userID = "";
		$this->userChannel = "";
	}
	//����û���Ȩ��ֵ
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