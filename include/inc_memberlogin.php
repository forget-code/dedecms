<?
//------------------------
//��վ��Ա��¼��
//------------------------
class MemberLogin
{
	var $M_ID;
	var $M_LoginID;
	var $M_Type;
	var $M_UType;
	var $M_Money;
	var $M_UserName;
	var $M_MySafeID;
	var $M_LoginTime;
	var $SafeCode;
	//-------------------------------
	//php5���캯��
	//-------------------------------
	function __construct()
 	{
 		$this->SafeCode = $GLOBALS['cfg_cookie_encode'];
 		$this->M_ID = $this->GetNum($this->GetCookie("Dede_UserID"));
 		$this->M_LoginID = $this->GetCookie("Dede_UserLoginID");
 		$this->M_Type = $this->GetNum($this->GetCookie("Dede_UserType"));
 		$this->M_UType = $this->GetCookie("Dede_UserUType");
 		$this->M_Money = $this->GetNum($this->GetCookie("Dede_UserMoney"));
 		$this->M_UserName = $this->GetCookie("Dede_UserName");
 		$this->M_LoginTime = $this->GetCookie("Dede_LoginTime");
 		$this->M_MySafeID = $this->GetCookie("Dede_SafeID");
 		if($this->M_MySafeID != $this->GetSafeID() 
 		         || $this->M_ID=="" || $this->M_ID==0)
 		{
 			$this->ResetUser();
 		}
  }
  function MemberLogin()
  {
  	$this->__construct();
  }
  //---------------------
  //�˳�cookie�ĻỰ
  //---------------------
  function ExitCookie()
  {
  	setcookie("Dede_UserID","",time()-36000,"/");
  	setcookie("Dede_SafeID","",time()-36000,"/");
  }
  //--------------------
  //��֤�û��Ƿ��Ѿ���¼
  //--------------------
  function IsLogin()
  {
  	if($this->M_ID > 0) return true;
  	else return false;
  }
  //--------------------
  //����û���ȫ��֤ID
  //--------------------
  function GetSafeID()
  {
  	$safecode = md5($this->SafeCode.$this->M_ID.$this->M_Type.$this->M_Money.$this->M_LoginTime);
  	return $safecode;
  }
  //--------------------
  //�����û���ȫ��֤ID
  //--------------------
  function SetSafeID()
  {
  	$safecode = $this->GetSafeID();
  	$this->M_MySafeID = $safecode;
  	$this->PutCookie("Dede_SafeID",$safecode);
  }
  //���һ��cookieֵ
  function GetCookie($key)
  {
	  if(!isset($_COOKIE[$key])) return "";
	  else return $_COOKIE[$key];
  }
  //---------------------
  //�����û���Ϣ
  //---------------------
  function ResetUser()
  {
  	$this->M_ID = 0;
 		$this->M_LoginID = "";
 		$this->M_Type = 0;
 		$this->M_UType = 0;
 		$this->M_Money = 0;
 		$this->M_UserName = "";
 		$this->M_LoginTime = 0;
  }
  //---------------------
  //��ȡ����ֵ
  //---------------------
  function GetNum($fnum)
  {
	  $fnum = ereg_replace("[^0-9\.]","",$fnum);
	  return $fnum;
  }
  //------------------------------
  //�û���¼
  //------------------------------
  function CheckUser($loginuser,$loginpwd)
  {
 		$dsql = new DedeSql(false);
 		$dsql->SetQuery("Select ID,pwd,uname,membertype,uptype,money From #@__member where userid='$loginuser'");
 		$dsql->Execute();
 		if($dsql->GetTotalRow()>0) //�û�����
 		{
 		   $row = $dsql->GetObject();
 		   if($row->pwd != $loginpwd){ //�������
 		     $dsql->Close();
 		     return -1;
 		   }
 		   else  //�ɹ���¼
 		   {
 		   	 $this->PutLoginInfo($row->ID,$loginuser,$row->membertype,$row->money,$row->uname,$row->uptype);
 		   	 $dsql->Close();
 		     return 1;
 		   }
 	  }
 	  else{ //�û�������
 	  	$dsql->Close();
 	  	return 0;
 	  }
  }
  //--------------------
  //�����û�cookie
  //--------------------
  function PutLoginInfo($uid,$lid,$mtype,$money,$uname,$utype)
  {
  	$this->M_ID = $uid;
 		$this->M_LoginID = $lid;
 		$this->M_Type = $mtype;
 		$this->M_UType = $utype;
 		$this->M_Money = $money;
 		$this->M_UserName = $uname;
 		$this->M_LoginTime = time();
 		$this->PutCookie("Dede_UserID",$uid);
 		$this->PutCookie("Dede_UserLoginID",$lid);
 		$this->PutCookie("Dede_UserType",$mtype);
 		$this->PutCookie("Dede_UserUType",$utype);
 		$this->PutCookie("Dede_UserMoney",$money);
 		$this->PutCookie("Dede_UserName",$uname);
 		$this->PutCookie("Dede_LoginTime",$this->M_LoginTime);
 		$this->SetSafeID();
  }
  //��Ĭ�ϲ�������һ��Cookie
  function PutCookie($key,$value)
  {
	  setcookie($key,$value,time()+3600,"/");
  }
  //---------------
  //��û�ԱĿǰ��״̬
  //----------------
  function GetSta()
  {
  	$sta = "";
  	$dsql = new DedeSql(false);
  	if($this->M_Type==0) $sta .= "��Ŀǰ������ǣ���ͨ��Ա";
  	else
  	{
  		$row = $dsql->GetOne("Select membername From #@__arcrank where rank='".$this->M_Type."'");
  		$sta .= "��Ŀǰ������ǣ�".$row['membername'];
  	}
  	if($this->M_UType>0)
  	{
  		$row = $dsql->GetOne("Select membername From #@__arcrank where rank='".$this->M_UType."'");
  	  $mname = $row['membername'];
  	  $sta .= " ������������Ϊ��$mname ";
  	}
  	$dsql->Close();
  	$sta .= " ��Ŀǰӵ�н�ң�".$this->M_Money." ����";
  	return $sta;
  }
}
?>