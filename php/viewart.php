<?
require_once("config.php");
require_once("../dede/inc_makeart.php");
if(isset($artID)) $ID=$artID;
if(!isset($ID))
{
	echo "ָ�������²����ڣ�";
	exit;
}
//����ԱȨ��
$conn = connectMySql();
$rs = mysql_query("select dede_art.title,dede_art.msg,dede_art.rank,dede_membertype.membername from dede_art left join dede_membertype on dede_art.rank=dede_membertype.rank where dede_art.ID=$ID",$conn);
$row = mysql_fetch_array($rs);
$sta = CheckUser($row["rank"]);
//����û�ûȨ��
if($sta==0)
{
$body = "";
$body .= "��Ҫ�鿴��������:".$row["title"];
$body .= "<br>���¼�飺".$row["msg"]."<br><br>��ƪ������ <font color='red'>".$row["membername"];
$body .= "</font> ���£����Ȩ�޲��㣬�޷��鿴��<br>";
$body .= "������Ѿ�����Ϊ�������Ļ�Ա��";
$body .= "����������<a href='/member/login.php'><u>��¼</u></a>";
$body .= "<br><br><a href='javascript:history.go(-1);'><u>����˷�����һҳ</u></a>";
echo $body;
exit();
}
//////////////����������ص�����///////////
if(!isset($page)) $page=0;
$mr = new makeArt();
echo $mr->makeArtView($ID,$page);
?>