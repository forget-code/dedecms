<?
require("../dede/config_base.php");
/////////////////////////////////
if(empty($page)) $page="";
if($page!="login"&&$page!="reg")
{
	if(empty($_COOKIE["cookie_user"]))
	{
		echo "<script>//alert('��δ��¼���Ѿ���ʱ�������µ�¼!');\r\nlocation.href='login.php';</script>";
		exit();
	}
}
//---��û�Ա�ȼ�-----------
function getRank($conn,$rank)
{
	if($_COOKIE["cookie_isup"]=="0")
	{
	 $rs = mysql_query("select * From dede_membertype where rank=$rank",$conn);
	 $row = mysql_fetch_object($rs);
	 $member = $row->membername;
	 echo "<table width='80%'><form name='form1' action='sendrank.php' method='post'><tr></td>\r\n";
	 echo "��Ŀǰ�ļ����ǣ�".$member;
	 $rs = mysql_query("select * From dede_membertype where rank>$rank And rank>1",$conn);
	 if(mysql_num_rows($rs)>0)
	 {
		echo "����Ҫ������<select name='rank' style='font-size:9pt;height:18'>";
		while($row = mysql_fetch_object($rs))
		{
			echo "<option value='".$row->rank."'>".$row->membername."</option>\r\n";
		}
		echo "</select> &nbsp;";
		echo "<input type='submit' name='ss' value='ȷ������' style='font-size:9pt;height:22'>\r\n";
		echo "</td></tr></form></table>";
	 }
	}
	else
	{
		$rs = mysql_query("select * From dede_membertype where rank=".$_COOKIE["cookie_isup"],$conn);
	 	$row = mysql_fetch_object($rs);
	 	$member = $row->membername;
	 	echo "��Ŀǰ��״̬�ǣ���������������".$member;
	}
}
//�����������
function GetFileName($ID,$typedir,$stime,$rank=0)
{
	global $art_php_dir;
	global $art_dir;
	global $art_shortname;
	global $art_nametag;
	if($rank>0||$rank==-1) return $art_php_dir."/viewart.php?ID=$ID";
	if($art_nametag=="maketime")
	{
		$ds = split("-",$stime);
		return $art_dir."/".$ds[0]."/".$ds[1].$ds[2]."/".$ID.$art_shortname;			
	}
	else
	return $art_dir."/".$typedir."/".$ID.$art_shortname;
}
?>