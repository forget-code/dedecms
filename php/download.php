<?
require("config.php");
//����ļ�����Ϊ������ص�һ���ӿ�,
//����תַ�ͽ���base64������,��û�����κ�����
if(!isset($artID)) echo "���ӵ�ַ���Ϸ�!";
else if(!isset($goto)) echo "�����޷��ҵ�ָ�������";
else
{
	$goto = base64_decode($goto);
	$goto = substr($goto,9);
	header("location:$goto");
}
?>