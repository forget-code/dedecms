<?
@ob_start();
@set_time_limit(3600);
require_once(dirname(__FILE__)."/config.php");
CheckPurview('sys_Keyword');

echo "���ڶ�ȡ�ؼ������ݿ�...<br/>\r\n";
flush();

$ws = "";
$wserr = "";
$wsnew = "";

$dsql = new DedeSql(false);
$dsql->SetQuery("Select * from #@__keywords");
$dsql->Execute();
while($row = $dsql->GetObject())
{
	if($row->sta==1)
		$ws[$row->keyword] = 1;
	else
		$wserr[$row->keyword] = 1;
}

echo "��ɹؼ������ݿ�����룡<br/>\r\n";
flush();

echo "��ȡ�������ݿ⣬���Խ��õĹؼ��ֺ����ֽ��д���...<br/>\r\n";
flush();

$dsql->SetQuery("Select ID,keywords from #@__archives");
$dsql->Execute();
while($row = $dsql->GetObject())
{
	$keywords = explode(" ",trim($row->keywords));
	$nerr = false;
	$mykey = "";
	if(is_array($keywords))
	{
		foreach($keywords as $v){
			$v = trim($v);
			if($v=="") continue;
			if(isset($ws[$v])) $mykey .= $v." ";
			else if(isset($wsnew[$v])){
				$mykey .= $v." ";
				$wsnew[$v]++;
			}
			else if(isset($wserr[$v])) $nerr = true;
			else{
				$mykey .= $v." ";
				$wsnew[$v] = 1;
			}
		}
		//����ؼ������н��õĹؼ��֣���������µĹؼ���
		if($nerr)
		{
			$dsql->SetQuery("update #@__archives set keywords='".addslashes($mykey)."' where ID='".$row->ID."' ");
			$dsql->ExecuteNoneQuery();
		}
	}
}
echo "��ɵ������ݿ�Ĵ���<br/>\r\n";
flush();
if(is_array($wsnew))
{
  echo "�Թؼ��ֽ�������...<br/>\r\n";
  flush();
  arsort($wsnew);
  echo "�ѹؼ��ֱ��浽���ݿ�...<br/>\r\n";
  flush();
  foreach($wsnew as $k=>$v)
  {
	  if(strlen($k)>20) continue;
	  $dsql->SetQuery("Insert Into #@__keywords(keyword,rank,sta,rpurl) Values('".addslashes($k)."','$v','1','')");
	  $dsql->Execute();
  }
  echo "��ɹؼ��ֵĵ��룡<br/>\r\n";
  flush();
  sleep(1);
}
else
{
	echo "û�����κ��µĹؼ��֣�<br/>\r\n";
  flush();
  sleep(1);
}
$dsql->Close();
ShowMsg("������в���������ת���ؼ����б�ҳ��","article_keywords_main.php");
?>