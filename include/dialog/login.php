<?
require_once(dirname(__FILE__)."/../config_base.php");
require_once(dirname(__FILE__)."/../inc_userlogin.php");
if(empty($dopost)) $dopost="";
//--------------------------------
//��¼���
//--------------------------------
if($dopost=="login")
{
  if(empty($validate)) $validate=="";
  else $validate = strtolower($validate);
  
  if( empty($_SESSION["s_validate"]) ) $svali = "";
  else $svali = $_SESSION["s_validate"];
  
  if($validate=="" || $validate!=$svali){
	  ShowMsg("��֤�벻��ȷ!","");
  }else{
     $cuserLogin = new userLogin();
     if(!empty($userid)&&!empty($pwd))
     {
	      $res = $cuserLogin->checkUser($userid,$pwd);
	      //�ɹ���¼
	      if($res==1){
		       $cuserLogin->keepUser();
		       if(!empty($gotopage)){
		       	//header("location:$gotopage");
		       	ShowMsg("�ɹ���¼������ת����������ҳ��",$gotopage);
		       	exit();
		       }
		       else{
		       	ShowMsg("�ɹ���¼������ת����������ҳ��","index.php");
		       	//header("location:index.php");
		       	exit();
		       }
	      }
	      else if($res==-1){
		      ShowMsg("����û���������!","");
	      }
	      else{
		      ShowMsg("����������!","");
	      }
     }//<-���벻Ϊ��
     else{
	    ShowMsg("�û�������û��д����!","");
     }
     
  }//<-��֤�û�
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
                  <td width="25%"><input type="text" name="validate" style="width:80;height:20"></td>
                  <td width="75%"><img src='../validateimg.php' width='50' height='20'></td>
                </tr>
              </table></td>
          </tr>
          <tr> 
            <td height="50" colspan="2" align="center"> <input type="button" name="sm1" value="��¼" style="background-color:#BAE171;border:1px solid #666666" onClick="this.form.submit();"> 
              &nbsp; <input type="button" name="sm2" value="Power by DedeCms" onClick="window.open('http://www.dedecms.com');" style="background-color:#FFFFFF;border:1px solid #DDDDDD;color:#DDDDDD"> 
              &nbsp; </td>
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
