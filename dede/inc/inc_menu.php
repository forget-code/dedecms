<?
require_once(dirname(__FILE__)."/../../include/config_base.php");
require_once(dirname(__FILE__)."/../../include/pub_dedetag.php");
$dsql = new DedeSql(false);
//����ɷ���Ƶ��
$dsql->SetQuery("Select ID,typename,addcon From #@__channeltype where ID>0 And isshow=1 order by ID asc");
$dsql->Execute();
$addset = "";
while($row = $dsql->GetObject())
{
  $addset .= "  <m:item name='����".$row->typename."' link='".$row->addcon."?channelid=".$row->ID."' rank='1' target='main' />\r\n";
}
//������
$dsql->SetQuery("Select * From #@__plus where isshow=1 order by aid asc");
$dsql->Execute();
$plusset = "";
while($row = $dsql->GetObject())
{
  $plusset .= $row->menustring."\r\n";
}
$dsql->Close();
//////////////////////////
$menus = "
-----------------------------------------------
<m:top name='Ƶ������' display='block' rank='1'>
  <m:item name='��վ��Ŀ����' link='catalog_main.php' rank='1' target='main' />
  <m:item name='Ƶ��ģ�͹���' link='mychannel_main.php' rank='5' target='main' />
  <m:item name='�Զ�����' link='mytag_main.php' rank='5' target='main' />
  <m:item name='ȫ�ֱ�ǲ���' link='tag_test.php' rank='5' target='main' />
  <m:item name='����ҳ�����' link='templets_one.php' rank='5' target='main' />
  <m:item name='���ģ��Ŀ¼' link='catalog_do.php?dopost=viewTemplet' rank='5' target='main' />
</m:top>

<m:top name='�ĵ�ά��' display='block' rank='1'>
  <m:item name='��ͨ�����б�' link='content_list.php' rank='1' target='main' />
  <m:item name='ͼ�Ļ����б�' link='content_i_list.php' rank='1' target='main' />
  <m:item name='�ؼ���ά��' link='article_keywords_main.php' rank='5' target='main' />
  <m:item name='���۹���' link='feedback_main.php' rank='1' target='main' />
</m:top>

<m:top name='���ݷ���' display='block' rank='1'>
  $addset
</m:top>

<m:top name='HTML����' display='block' rank='5'>
  <m:item name='������ҳHTML' link='makehtml_homepage.php' rank='5' target='main' />
  <m:item name='������ĿHTML' link='makehtml_list.php' rank='5' target='main' />
  <m:item name='�����ĵ�HTML' link='makehtml_archives.php' rank='5' target='main' />
  <m:item name='������վ��ͼ' link='makehtml_map_guide.php' rank='5' target='main' />
  <m:item name='����RSS�ļ�' link='makehtml_rss.php' rank='5' target='main' />
  <m:item name='��ȡJS�ļ�' link='makehtml_js.php' rank='5' target='main' />
</m:top>

<m:top name='ר�����' display='none' rank='5'>
  <m:item name='������ר��' link='spec_add.php' rank='5' target='main' />
  <m:item name='ר���б�' link='content_s_list.php' rank='5' target='main' />
  <m:item name='����ר��HTML' link='makehtml_spec.php' rank='5' target='main' />
</m:top>

<m:top name='�ɼ�����' display='none' rank='5'>
  <m:item name='�ɼ��ڵ����' link='co_main.php' rank='5' target='main' />
  <!--m:item name='�����������' link='co_export_rule.php' rank='5' target='main' /-->
  <m:item name='���������ݹ���' link='co_url.php' rank='5' target='main' />
</m:top>

<m:top name='�������' display='none' rank='1'>
  <m:item name='���������' link='plus_main.php' rank='10' target='main' />
  $plusset
</m:top>

<m:top name='��Ա����' display='none' rank='5'>
  <!--m:item name='�ⲿϵͳ����' link='javascript:;' rank='5' target='main' /-->
  <m:item name='ע���Ա�б�' link='member_main.php' rank='5' target='main' />
  <m:item name='��ԱȨ�޹���' link='member_rank.php' rank='5' target='main' />
</m:top>

<m:top name='ϵͳ����' display='none' rank='10'>
  <m:item name='ϵͳ�ʺŹ���' link='sys_admin_user.php' rank='10' target='main' />
  <m:item name='���ݱ��ݻ�ԭ' link='sys_back_data.php' rank='10' target='main' />
</m:top>

<m:top name='ϵͳ����' display='none' rank='1'>
  <m:item name='ϵͳ��ҳ' link='index_body.php' rank='1' target='main' />
  <m:item name='ģ�����ο�' link='help_templet.php' rank='1' target='main' />
  <m:item name='֯�ιٷ���̳' link='http://bbs.dedecms.com/' rank='1' target='_blank' />
</m:top>

-----------------------------------------------
";
function GetMenus($userrank)
{
$headTemplet = "<table width='130' border='0' align='center' cellpadding='0' cellspacing='0'>
  <tr> 
    <td colspan='2' height='24' align='center' background='img/menu_top.gif' onClick='showHide(\"items~cc~\")' class='top'>~channelname~</td>
  </tr>
  <tr style='display:~display~' id='items~cc~'> 
    <td colspan='2' align='center'>
	<table width='130' border='0' cellspacing='0' cellpadding='0' bgcolor='#F4FBF4'>
";
$footTemplet = "	   </table>
    </td>
  </tr>
</table>
<table width='100%' border='0' cellspacing='0' cellpadding='0'>
<tr><td height='3'></td></tr>
</table>
";
$itemTemplet = "	  <tr> 
          <td align='center' class='tdline-left' width='20%'><img src='img/newitem.gif' width='7' height='10' alt=''/></td>
          <td class='tdline-right' width='80%'><a href='~link~' target='~target~'>~itemname~</a></td>
	  </tr>
";
/////////////////////////////////////////
global $menus;
$dtp = new DedeTagParse();
$dtp->SetNameSpace("m","<",">");
$dtp->LoadSource($menus);
$dtp2 = new DedeTagParse();
$dtp2->SetNameSpace("m","<",">");
foreach($dtp->CTags as $i=>$ctag)
{
	if($ctag->GetName()=="top" && $ctag->GetAtt("rank")<=$userrank)
	{
		echo "<!-- Item ".($i+1)." Strat -->\r\n";
		$htmp = str_replace("~channelname~",$ctag->GetAtt("name"),$headTemplet);
		$htmp = str_replace("~display~",$ctag->GetAtt("display"),$htmp);
		$htmp = str_replace("~cc~",$i,$htmp);
		echo $htmp;
		$dtp2->LoadSource($ctag->InnerText);
		foreach($dtp2->CTags as $j=>$ctag2)
		{
			if($ctag2->GetName()=="item" && $ctag2->GetAtt("rank")<=$userrank)
			{
				 $itemtmp = str_replace("~link~",$ctag2->GetAtt("link"),$itemTemplet);
				 $itemtmp = str_replace("~target~",$ctag2->GetAtt("target"),$itemtmp);
				 $itemtmp = str_replace("~n~",$i,$itemtmp);
				 $itemtmp = str_replace("~itemname~",$ctag2->GetAtt("name"),$itemtmp);
				 echo $itemtmp;
			}
		}
		echo $footTemplet;
		echo "<!-- Item ".($i+1)." End -->\r\n";
	}
}
}//End Function
?>