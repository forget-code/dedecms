<?
require_once(dirname(__FILE__)."/config.php");
$itemconfig = "
{dede:comments}
{!-- �ڵ������Ϣ --}
{/dede:comments}

{dede:item name=\\'$notename\\' typeid=\\'$typeid\\'
  imgurl=\\'$imgurl\\' imgdir=\\'$imgdir\\' language=\\'$language\\'}
{/dede:item}

{dede:comments}
{!-- �ɼ��б��ȡ���� --}
{/dede:comments}

{dede:list source=\\'$source\\' sourcetype=\\'$sourcetype\\' 
           varstart=\\'$varstart\\' varend=\\'$varend\\'}	
  {dede:url value=\\'$sourceurl\\'}
  $sourceurls
  {/dede:url}	
  {dede:need}$need{/dede:need}
  {dede:cannot}$cannot{/dede:cannot}
{/dede:list}

{dede:comments}
{!-- ��ҳ���ݻ�ȡ���� --}
{/dede:comments}

{dede:art sptype=\\'$sptype\\'}
{dede:sppage}$sppage{/dede:sppage}";	

for($i=1;$i<=20;$i++)
{
	if(!empty(${"field".$i}))
	{
		if(!isset($GLOBALS["value".$i])) $GLOBALS["value".$i] = "";
		else $GLOBALS["value".$i] = trim($GLOBALS["value".$i]);
		if(!isset($GLOBALS["match".$i])) $GLOBALS["match".$i] = "";
		
		//����ֶ�ֵΪ�ջ��ֶ�ֵΪ��������ƥ������Ϊ�գ���������ֶ�
		if($GLOBALS["value".$i]==""
		   ||($GLOBALS["value".$i]=="[var:����]"&&$GLOBALS["match".$i]==""))
		{ continue; }
		
		if(!isset($GLOBALS["isunit".$i])) $GLOBALS["isunit".$i] = "";
		if(!isset($GLOBALS["isdown".$i])) $GLOBALS["isdown".$i] = "";
		if(!isset($GLOBALS["trim".$i])) $GLOBALS["trim".$i] = "";
		$trimstr = $GLOBALS["trim".$i];
		if($trimstr!=""&&!eregi("{dede:trim",$trimstr)){
			$trimstr = "    {dede:trim}$trimstr{/dede:trim}\r\n";
		}
		else{
			$trimstr = str_replace("{dede:trim","    {dede:trim",$trimstr); 
		}
	$itemconfig .= "
  
  {dede:note field=\\'".${"field".$i}."\\' value=\\'".$GLOBALS["value".$i]."\\'
   isunit=\\'".$GLOBALS["isunit".$i]."\\' isdown=\\'".$GLOBALS["isdown".$i]."\\'}
    
    {dede:match}".$GLOBALS["match".$i]."{/dede:match}
    $trimstr
    
  {/dede:note}";
 }
}
$itemconfig .= "
{/dede:art}
";
$inQuery = "
INSERT INTO #@__conote(typeid,gathername,language,lasttime,savetime,noteinfo) 
VALUES('$typeid', '$notename', '$language', '0','".time()."', '$itemconfig');
";
$dsql = new DedeSql(false);
$dsql->SetSql($inQuery);
if($dsql->ExecuteNoneQuery())
{
	$dsql->Close();
	ShowMsg("�ɹ�����һ���ڵ�!","co_main.php");
	exit();
}
else
{
	$dsql->Close();
	ShowMsg("���ӽڵ�ʧ��,����ԭ��!","-1");
	exit();
}
?>