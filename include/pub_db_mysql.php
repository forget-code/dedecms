<?
//���������ǰ,�����趨��Щ�ⲿ����
//$cfg_dbhost="";
//$cfg_dbname="";
//$cfg_dbuser="";
//$cfg_dbpwd="";
//ǰ׺����
//$cfg_dbprefix="";
$cfg_db_language = "gbk";
class DedeSql
{
	var $linkID;
	var $dbHost;
	var $dbUser;
	var $dbPwd;
	var $dbName;
	var $dbPrefix;
	var $result;
	var $queryString;
	var $parameters;
	//
	//���ⲿ����ı�����ʼ�࣬���������ݿ�
	//
	function __construct($pconnect=false)
 	{
 		if($this->linkID==0) $this->Init($pconnect);
  }
	
	function DedeSql($pconnect=false)
	{
		if($this->linkID==0) $this->Init($pconnect);
	}
	
	function Init($pconnect=false)
	{
		$this->linkID = 0;
		$this->queryString = "";
		$this->parameters = Array();
		$this->dbHost = $GLOBALS["cfg_dbhost"];
		$this->dbUser = $GLOBALS["cfg_dbuser"];
		$this->dbPwd = $GLOBALS["cfg_dbpwd"];
		$this->dbName = $GLOBALS["cfg_dbname"];
		$this->dbPrefix = $GLOBALS["cfg_dbprefix"];
		$this->result["me"] = 0;
		$this->Open($pconnect);
	}
	//
	//��ָ��������ʼ���ݿ���Ϣ
	//
	function SetSource($host,$username,$pwd,$dbname,$dbprefix="dede_")
	{
		$this->dbHost = $host;
		$this->dbUser = $username;
		$this->dbPwd = $pwd;
		$this->dbName = $dbname;
		$this->dbPrefix = $dbprefix;
		$this->result["me"] = 0;
	}
	function SelectDB($dbname)
	{
		mysql_select_db($dbname);
	}
	//
	//����SQL��Ĳ���
	//
	function SetParameter($key,$value)
	{
		$this->parameters[$key]=$value;
	}
	//
	//�������ݿ�
	//
	function Open($pconnect=true)
	{
		//�������ݿ�
		if($pconnect){ $this->linkID = @mysql_pconnect($this->dbHost,$this->dbUser,$this->dbPwd); }
		else{ $this->linkID = @mysql_connect($this->dbHost,$this->dbUser,$this->dbPwd); }
		//������󣬳ɹ�������ѡ�����ݿ�
		if(!$this->linkID){
			$this->DisplayError("Connect Database Server False!");
			return false;
		}
		else{ @mysql_select_db($this->dbName); }
		mysql_query("SET NAMES '".$GLOBALS['cfg_db_language']."';",$this->linkID);
		return true;
	}
	//
	//��ô�������
	//
	function GetError()
	{
		$str = ereg_replace("'|\"","`",mysql_error());
		return $str;
	}
	//
	//�ر����ݿ�
	//
	function Close()
	{
		@mysql_close($this->linkID);
		$this->FreeResultAll();
	}
	//
	//�ر�ָ�������ݿ�����
	//
	function CloseLink($dblink)
	{
		@mysql_close($dblink);
	}
	//
	//ִ��һ�������ؽ����SQL��䣬��update,delete,insert��
	//
	function ExecuteNoneQuery()
	{
		if(is_array($this->parameters)){
			foreach($this->parameters as $key=>$value){
				$this->queryString = str_replace("@".$key,"'$value'",$this->queryString);
			}
		}
		return mysql_query($this->queryString,$this->linkID);
	}
	function ExecNoneQuery()
	{
		return $this->ExecuteNoneQuery();
	}
	//
	//ִ��һ�������ؽ����SQL��䣬��SELECT��SHOW��
	//
	function Execute($id="me")
	{
		$this->result[$id] = @mysql_query($this->queryString,$this->linkID);
		
		if(!$this->result[$id]){
			$this->DisplayError(mysql_error()." - Execute Query False! <font color='red'>".$this->queryString."</font>");
		}
	}
	function Query($id="me")
	{
		$this->Execute($id);
	}
	//
	//ִ��һ��SQL���,����ǰһ����¼�������һ����¼
	//
	function GetOne($sql="")
	{
		if($sql!=""){ 
		  if(!eregi("limit",$sql)) $this->SetQuery(eregi_replace("[,;]$","",trim($sql))." limit 0,1;");
		  else $this->SetQuery($sql);
		}
		$this->Execute("one");
		$arr = $this->GetArray("one");
		if(!is_array($arr)) return("");
		else { @mysql_free_result($this->result["one"]); return($arr);}
		
	}
	//
	//ִ��һ�������κα����йص�SQL���,Create��
	//
	function ExecuteSafeQuery($sql,$id="me")
	{
		$this->result[$id] = @mysql_query($sql,$this->linkID);
	}
	//
	//���ص�ǰ��һ����¼�����α�������һ��¼
	//
	function GetArray($id="me")
	{
		if($this->result[$id]==0) return false;
		else return mysql_fetch_array($this->result[$id]);
	}
	function GetObject($id="me")
	{
		if($this->result[$id]==0) return false;
		else return mysql_fetch_object($this->result[$id]);
	}
	//
	//����Ƿ����ĳ���ݱ�
	//
	function IsTable($tbname)
	{
		$this->result = mysql_list_tables($this->dbName,$this->linkID);
		while ($row = mysql_fetch_array($this->result)){
			if($row[0]==$tbname)
			{
				mysql_freeresult($this->result);
				return true;
			}
		}
		mysql_freeresult($this->result);
		return false;
	}
	//
	//���MySql�İ汾��
	//
	function GetVersion()
	{
		$rs = mysql_query("SELECT VERSION();",$conn);
    $row = mysql_fetch_array($rs);
    $mysql_version = $row[0];
    mysql_free_result($rs);
    return $mysql_version;
	}
	//
	//��ȡ�ض������Ϣ
	//
	function GetTableFields($tbname,$id="me")
	{
		$this->result[$id] = mysql_list_fields($this->dbName,$tbname,$this->linkID);
	}
	//
	//��ȡ�ֶ���ϸ��Ϣ
	//
	function GetFieldObject($id="me")
	{
		return mysql_fetch_field($this->result[$id]);
	}
	//
	//��ò�ѯ���ܼ�¼��
	//
	function GetTotalRow($id="me")
	{
		if($this->result[$id]==0) return -1;
		else return mysql_num_rows($this->result[$id]);
	}
	//
	//��ȡ��һ��INSERT����������ID 
	//
	function GetLastID()
	{
		//��� AUTO_INCREMENT ���е������� BIGINT���� mysql_insert_id() ���ص�ֵ������ȷ��
		//������ SQL ��ѯ���� MySQL �ڲ��� SQL ���� LAST_INSERT_ID() ������� 
		//$rs = mysql_query("Select LAST_INSERT_ID() as lid",$this->linkID);
		//$row = mysql_fetch_array($rs);
		//return $row["lid"];
		return mysql_insert_id($this->linkID);
	}
	//
	//�ͷż�¼��ռ�õ���Դ
	//
	function FreeResult($id="me")
	{
		@mysql_free_result($this->result[$id]);
	}
	function FreeResultAll()
	{
		if(!is_array($this->result)) return "";
		foreach($this->result as $kk => $vv){
			if($vv) @mysql_free_result($vv);
		}
	}
	//
	//����SQL��䣬���Զ���SQL������#@__�滻Ϊ$this->dbPrefix(�������ļ���Ϊ$cfg_dbprefix)
	//
	function SetQuery($sql)
	{
		$prefix="#@__";
		$sql = trim($sql);
		$inQuote = false;
		$escaped = false;
		$quoteChar = '';
		$n = strlen($sql);
		$np = strlen($prefix);
		$restr = '';
		for($j=0; $j < $n; $j++)
		{
			$c = $sql{$j};
			$test = substr($sql, $j, $np);
			if(!$inQuote)
			{
				if ($c == '"' || $c == "'") {
					$inQuote = true;
					$escaped = false;
					$quoteChar = $c;
				}
			}
			else
			{
				if ($c == $quoteChar && !$escaped) {
					$inQuote = false;
				} else if ($c == "\\" && !$escaped) {
					$escaped = true;
				} else {
					$escaped = false;
				}
			}
			if ($test == $prefix && !$inQuote)
			{
			    $restr .= $this->dbPrefix;
			    $j += $np-1;
			}
			else
			{
				$restr .= $c;
			}
		}
		$this->queryString = $restr;
	}
	function SetSql($sql)
	{
		$this->SetQuery($sql);
	}
	//
	//��ʾ�������Ӵ�����Ϣ
	//
	function DisplayError($msg)
	{
		echo "<html>\r\n";
		echo "<head>\r\n";
		echo "<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>\r\n";
		echo "<title>DedeCms Error Track</title>\r\n";
		echo "</head>\r\n";
		echo "<body>\r\n<p style='line-helght:150%;font-size:10pt'>\r\n";
		echo $msg;
		echo "<br/><br/>";
		echo "</p>\r\n</body>\r\n";
		echo "</html>";
		//exit();
	}
}
?>