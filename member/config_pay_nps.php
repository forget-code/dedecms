<?php 
//nps ����֧���ӿ�

//�̻���
$cfg_merchant = "";
//�̻���Կ
$cfg_merpassword = "";

// ������������
function HexToStr($hex)
{
    $string="";
    for($i=0;$i<strlen($hex)-1;$i+=2){ $string.=chr(hexdec($hex[$i].$hex[$i+1])); }
    return $string;
} 

function StrToHex($string)
{
   $hex="";
   for($i=0;$i<strlen($string);$i++){ $hex.=dechex(ord($string[$i])); }
   $hex=strtoupper($hex);
   return $hex;
}

if(!isset($pagePos)) $pagePos = '';

//nps��Ϣ
$m_language	=	1;
$s_name		=	"�¿�";
$s_addr		=	"����";
$s_postcode	=	518000;
$s_tel		=	"0755-83791960";
$s_eml		=	"sway@nps.cn";
$r_name		=	"�´�";
$r_addr		=	"����";
$r_postcode	=	100080;
$r_tel		=	"010-81234567";
$r_eml		=	"service@nps.cn";
$m_status	= 	0;
$m_ocurrency    =	1;

//Post to nps
if($pagePos == 'post_to_pay'){

	$m_id		=	$cfg_merchant;
	$m_orderid	=	$buyid;
	$m_oamount	=	$price;
	$m_url		=	$cfg_basehost."/member/pay_back_nps.php";
	$m_ocomment	=	$cfg_ml->M_ID;
	$modate		=	GetDateTimeMk($mtime);
	

	//��֯������Ϣ
	$m_info = $m_id."|".$m_orderid."|".$m_oamount."|".$m_ocurrency."|".$m_url."|".$m_language;
	$s_info = $s_name."|".$s_addr."|".$s_postcode."|".$s_tel."|".$s_eml;
	$r_info = $r_name."|".$r_addr."|".$r_postcode."|".$r_tel."|".$r_eml."|".$m_ocomment."|".$m_status."|".$modate;

	$OrderInfo = $m_info."|".$s_info."|".$r_info;

	//������Ϣ��ת����HEX��Ȼ���ټ���
	$OrderInfo = StrToHex($OrderInfo);
	$digest = strtoupper(md5($OrderInfo.$cfg_merpassword));

}

?>