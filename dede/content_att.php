<?php 
require_once(dirname(__FILE__)."/config.php");
if(empty($dopost)) $dopost = "";
CheckPurview('sys_Att');
$dsql = new DedeSql(false);
//�������
//--------------------
if($dopost=="save")
{
   $startID = 1;
   $endID = $idend;
   for(;$startID<=$endID;$startID++)
   {
   	  $query = "";
   	  $att = ${"att_".$startID};
   	  $attname = ${"attname_".$startID};
   	  if(isset(${"check_".$startID})){
   	  	$query = "update #@__arcatt set attname='$attname' where att='$att'";
   	  }
   	  else{
   	  	$query = "Delete From #@__arcatt where att='$att'";
   	  }
   	  if($query!=""){
   	  	$dsql->SetQuery($query);
   	  	$dsql->ExecuteNoneQuery();
   	  } 
   }
   if(isset($check_new))
   {
   	 if($att_new>0 && $attname_new!=""){
   	 	 $dsql->SetQuery("Insert Into #@__arcatt(att,attname) Values('{$att_new}','{$attname_new}')");
   	   $dsql->ExecuteNoneQuery();
   	 }
   }
   echo "<script> alert('�ɹ������Զ��ĵ������Ա�'); </script>";
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�Զ������Թ���</title>
<link href="base.css" rel="stylesheet" type="text/css">
</head>
<body background='img/allbg.gif' leftmargin='8' topmargin='8'>
<table width="98%" border="0" cellpadding="3" cellspacing="1" bgcolor="#98CAEF" align="center">
  <form name="form1" action="content_att.php" method="post">
    <input type="hidden" name="dopost" value="save">
    <tr> 
      <td height="28" colspan="3" background='img/tbg.gif'>
      	<strong>�ĵ��Զ������Թ���</strong>
      </td>
    </tr>
    <tr> 
      <td height="34" colspan="3" bgcolor="#FFFFFF">
    ����<b>�Զ������Ե������ʹ��˵����</b><br>
    �����������İ汾�У���վ��ҳ��Ƶ���������ƣ���ֻ�ܵ������� arclist ��ǰ�ĳ��Ŀ���»��ض�����ʽ���ĵ���ѡ��Ķ������������������ںܴ�Ĳ��㣬���磬��ϣ��������ĵط���ʾ����Ҫ���ĵ����������İ汾�����޷������ģ���ʹ���Զ�������֮��ֻҪ��arclist ��Ǽ��� att='ID' �����ԣ�Ȼ���ڷ�����ʱ����ʺϵ��ĵ�ѡ��ר�ŵ����ԣ���ôʹ��arclist�ĵط��ͻᰴ�����Ը��ʾָ�����ĵ���<br>
����<b>ע�����</b>�� att='' ʱ��ϵͳ����������ĵ���������ɰ���ݵ�ԭ�򣩣�������������ҳ��ʹ����att���ԣ���ô��ͨ�ĵ���arclistҲӦ�ü���att='0'�����ԣ���ֹ����ҳ���ظ�����ĳЩ���µ����ӡ�
      </td>
    </tr>
    <tr bgcolor="#FDFEE9" align="center" > 
      <td width="20%" height="24">ID</td>
      <td width="50%">��������</td>
      <td width="30%">����</td>
    </tr>
	<?php 
	$dsql->SetQuery("Select * From #@__arcatt");
	$dsql->Execute();
	$k=0;
	while($row = $dsql->GetObject())
	{
	  $k++;
	?>
	<input type="hidden" name="att_<?php echo $k?>" value="<?php echo $row->att?>">
    <tr align="center" bgcolor="#FFFFFF"> 
    <td height="24">
    	<?php echo $row->att?>
	  </td>
    <td height="24">
	  <input name="attname_<?php echo $k?>" value="<?php echo $row->attname?>"  type="text" id="attname_<?php echo $k?>" size="30">
	  </td>
      <td>
	  <input name="check_<?php echo $k?>" type="checkbox" id="check_<?php echo $k?>" class="np" value="1" checked>
       ����ʹ��
	 </td>
    </tr>
	<?php 
	}
	?>
	<input type="hidden" name="idend" value="<?php echo $k?>">
    <tr bgcolor="#F8FCF1"> 
      <td height="24" colspan="3" valign="top"><strong>����һ���������ͣ�</strong></td>
    </tr>
    <tr> 
      <td height="24" align="center" valign="top" bgcolor="#FFFFFF">
	  <input name="att_new" type="text" id="att_new" size="10">
	  </td>
      <td height="24" align="center" valign="top" bgcolor="#FFFFFF">
	  <input name="attname_new" type="text" id="attname_new" size="30">
	  </td>
      <td align="center" bgcolor="#FFFFFF">
      	<input name="check_new" type="checkbox" id="check_new" class="np" value="1" checked>
        ����������
     </td>
    </tr>
    <tr> 
      <td height="24" colspan="3" bgcolor="#F8FCF1">&nbsp;</td>
    </tr>
    <tr> 
      <td height="34" colspan="3" align="center" bgcolor="#CCEDFD">
      	<input name="imageField" type="image" src="img/button_ok.gif" width="60" height="22" border="0"></td>
    </tr>
  </form>
</table>
<?php 
$dsql->Close();
?>
</body>
</html>
