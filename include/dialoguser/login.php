<?
require_once(dirname(__FILE__)."/../config_base.php");
require_once(dirname(__FILE__)."/../include/inc_memberlogin.php");
if(empty($dopost)) $dopost="";
//--------------------------------
//��¼���
//--------------------------------
if($dopost=="login")
{
 	 $svali = GetCookie("dd_ckstr");
   if(strtolower($vdcode)!=$svali && $svali!=""){
  	 ShowMsg("��֤�����","-1");
  	 exit();
   }
   if(ereg("[ '\"\*\?\%]","",$userid)||ereg("[ '\"\*\?\%]","",$pwd)){
   	 ShowMsg("�û��������벻�Ϸ���","-1",0,2000);
  	 exit();
   }
   if($userid==""||$pwd==""){
   	 ShowMsg("�û��������벻��Ϊ�գ�","-1",0,2000);
  	 exit();
   }
   //����ʺ�
   $rs = $cfg_ml->CheckUser($userid,$pwd);
   if($rs==0) {
   	 ShowMsg("�û��������ڣ�","-1",0,2000);
  	 exit();
   }
   else if($rs==-1){
   	 ShowMsg("�������","-1",0,2000);
  	 exit();
   }
   else{
   	 $dsql = new DedeSql(false);
   	 $dsql->SetQuery("update #@__member set logintime='".mytime()."',loginip='".GetIP()."' where ID='".$cfg_ml->M_ID."'");
   	 $dsql->ExecuteNoneQuery();
   	 $dsql->Close();
   	 if(!empty($gotopage)){
		     ShowMsg("�ɹ���¼������ת��...",$gotopage);
		     exit();
		  }else{
		     ShowMsg("�ɹ���¼����رձ����ں���һ���´��ڣ�","javascript:;");
		     exit();
		 }
  	 exit();
   }
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>֯�����ݹ���ϵͳ DedeCms V3</title>
<link href="base.css" rel="stylesheet" type="text/css">
</head>
<body style='MARGIN: 0px' bgColor='#ffffff' leftMargin='0' topMargin='0' scroll='no'>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#111111" style="BORDER-COLLAPSE: collapse">
  <tr> 
    <td width="100%" height="64" background="img/indextitlebg.gif"><img src="img/indextitle.gif" width="250" height="64"> 
    </td>
  </tr>
  <tr> 
    <td width="100%" height="20">��</td>
  </tr>
  <tr> 
    <td width="100%" height="20" valign="bottom">
    	<table width="540" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td align="right" style="FONT-SIZE: 2pt">&nbsp;</td>
        </tr>
        <tr> 
          <td><IMG height=14 src="img/book1.gif" width=20>&nbsp; �û���¼</td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td width="100%" height="1" background="img/sp_bg.gif"></td>
  </tr>
  <tr> 
    <td width="100%" height="2"></td>
  </tr>
  <tr> 
    <td width="100%" height="136" valign="top">
    	<form name="form1" method="post" action="login.php">
        <input type="hidden" name="gotopage" value="<?if(!empty($gotopage)) echo $gotopage;?>">
        <input type="hidden" name="dopost" value="login">
        <table width="540" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td colspan="2" height="4"></td>
          </tr>
          <tr> 
            <td width="156" height="30" align="center"> �û�����</td>
            <td width="384"> <input type="text" name="userid" style="width:150;height:20"> 
            </td>
          </tr>
          <tr> 
            <td height="30" align="center"> �ܡ��룺 </td>
            <td> <input type="password" name="pwd" style="width:150;height:20"> 
            </td>
          </tr>
          <tr> 
            <td height="30" align="center"> ��֤�룺 </td>
            <td> <table width="90%"  border="0" cellspacing="0" cellpadding="0">
                <tr> 
                  <td width="25%"><input type="text" name="vdcode" style="width:80;height:20"></td>
                  <td width="75%"><img src='../vdimgck.php' width='50' height='20'></td>
                </tr>
              </table></td>
          </tr>
          <tr> 
            <td height="50" colspan="2" align="center">
            	<input type="submit" name="sm1" value="��¼" style="background-color:#BAE171;border:1px solid #666666" onClick="this.form.submit();"> 
              &nbsp;
              <input type="button" name="sm2" value="Power by DedeCms" onClick="window.open('http://www.dedecms.com');" style="background-color:#FFFFFF;border:1px solid #DDDDDD;color:#DDDDDD"> 
              &nbsp;
              </td>
          </tr>
        </table>
      </form></td>
  </tr>
  <tr> 
    <td width="100%" height="2" valign="top"></td>
  </tr>
</table>
</body>
</html>
