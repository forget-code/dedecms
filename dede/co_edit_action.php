<?
require_once(dirname(__FILE__)."/config.php");
CheckPurview('co_EditNote');
$itemconfig = "
{!-- �ڵ������Ϣ --}

{dede:item name=\\'$notename\\'
	imgurl=\\'$imgurl\\' imgdir=\\'$imgdir\\' language=\\'$language\\'
	isref=\\'$isref\\' refurl=\\'$refurl\\' exptime=\\'$exptime\\'
	typeid=\\'$exrule\\' macthtype=\\'$macthtype\\'}
{/dede:item}

{!-- �ɼ��б��ȡ���� --}

{dede:list source=\\'$source\\' sourcetype=\\'$sourcetype\\' 
           varstart=\\'$varstart\\' varend=\\'$varend\\'}
  {dede:url value=\\'$sourceurl\\'}$sourceurls{/dede:url}	
  {dede:need}$need{/dede:need}
  {dede:cannot}$cannot{/dede:cannot}
  {dede:linkarea}$linkarea{/dede:linkarea}
{/dede:list}

{!-- ��ҳ���ݻ�ȡ���� --}

{dede:art}
{dede:sppage sptype=\\'$sptype\\'}$sppage{/dede:sppage}";	

for($i=1;$i<=50;$i++)
{
	if(!empty(${"field".$i}))
	{
		if(!isset($GLOBALS["value".$i])) $GLOBALS["value".$i] = "";
		else $GLOBALS["value".$i] = trim($GLOBALS["value".$i]);
		if(!isset($GLOBALS["match".$i])) $GLOBALS["match".$i] = "";
		
		if(!isset($GLOBALS["comment".$i])) $GLOBALS["comment".$i] = "";	
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
  
  {dede:note field=\\'".${"field".$i}."\\' value=\\'".$GLOBALS["value".$i]."\\' comment=\\'".$GLOBALS["comment".$i]."\\' 
   isunit=\\'".$GLOBALS["isunit".$i]."\\' isdown=\\'".$GLOBALS["isdown".$i]."\\'}
    
    {dede:match}".$GLOBALS["match".$i]."{/dede:match}
    $trimstr
    {dede:function}".$GLOBALS["function".$i]."{/dede:function}
    
  {/dede:note}";
 }
}
$itemconfig .= "
{/dede:art}
";

$inQuery = "
Update #@__conote set gathername='$notename',language='$language',noteinfo='$itemconfig' 
Where nid='$nid';
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
	ShowMsg("���Ľڵ�ʧ��,����ԭ��!","-1");
	exit();
}
?>