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
  $addset .= "  <m:item name='����".$row->typename."' link='".$row->addcon."?channelid=".$row->ID."' rank='' target='main' />\r\n";
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
<m:top name='Ƶ������' display='block' rank='t_List,t_AccList,c_List,temp_One'>
  <m:item name='��վ��Ŀ����' link='catalog_main.php' rank='t_List,t_AccList' target='main' />
  <m:item name='Ƶ��ģ�͹���' link='mychannel_main.php' rank='c_List' target='main' />
  <!--m:item name='�����б����' link='freelist_main.php' rank='temp_One' target='main' /-->
  <m:item name='��ҳ�ĵ�����' link='templets_one.php' rank='temp_One' target='main'/>
</m:top>

<m:top name='�ĵ�ά��' display='block'>
  <m:item name='���е����б�' link='content_list.php' rank='a_List,a_AccList' target='main' />
  <m:item name='�ҷ����ĵ���' link='content_list.php?adminid=".$cuserLogin->getUserID()."' rank='a_List,a_AccList,a_MyList' target='main' />
  <m:item name='����˵ĵ���' link='content_list.php?arcrank=-1' rank='a_Check,a_AccCheck' target='main' />
  <m:item name='���۹���' link='feedback_main.php' rank='sys_Feedback' target='main' />
  <m:item name='�ĵ�����ά��' link='content_batch_up.php' rank='sys_ArcBatch' target='main' />
  <m:item name='�ĵ��ؼ���ά��' link='article_keywords_main.php' rank='sys_Keyword' target='main' />
  <m:item name='�����ؼ��ʴ���' link='search_keywords_main.php' rank='sys_Keyword' target='main' />
  <m:item name='�Զ�ժҪ|��ҳ' link='article_description_main.php' rank='sys_Keyword' target='main' />
  <m:item name='�ĵ���Ϣͳ��' link='content_tj.php' rank='sys_ArcTj' target='main' />
</m:top>

<m:top name='���ݷ���' display='block' rank='a_New,a_AccNew'>
  $addset
</m:top>

<m:top name='Ƶ������' display='none' rank='sys_Att,sys_SoftConfig,sys_Source,sys_Writer,sys_StringMix'>
  <m:item name='�Զ����ĵ�����' link='content_att.php' rank='sys_Att' target='main' />
  <m:item name='���Ƶ������' link='soft_config.php' rank='sys_SoftConfig' target='main' />
  <m:item name='���ɼ�������' link='article_string_mix.php' rank='sys_StringMix' target='main' />
  <m:item name='��Դ����' link='article_source_edit.php' rank='sys_Source' target='main' />
  <m:item name='���߹���' link='article_writer_edit.php' rank='sys_Writer' target='main' />
</m:top>

<m:top name='ר�����' display='none' rank='spec_New,spec_List'>
  <m:item name='������ר��' link='spec_add.php' rank='spec_New' target='main' />
  <m:item name='ר���б�' link='content_s_list.php' rank='spec_List' target='main' />
  <m:item name='����ר��HTML' link='makehtml_spec.php' rank='sys_MakeHtml' target='main' />
</m:top>

<m:top name='HTML����' display='none' rank='sys_MakeHtml'>
  <m:item name='������ҳHTML' link='makehtml_homepage.php' rank='sys_MakeHtml' target='main' />
  <m:item name='������ĿHTML' link='makehtml_list.php' rank='sys_MakeHtml' target='main' />
  <m:item name='�����ĵ�HTML' link='makehtml_archives.php' rank='sys_MakeHtml' target='main' />
  <m:item name='������վ��ͼ' link='makehtml_map_guide.php' rank='sys_MakeHtml' target='main' />
  <m:item name='����RSS�ļ�' link='makehtml_rss.php' rank='sys_MakeHtml' target='main' />
  <m:item name='��ȡJS�ļ�' link='makehtml_js.php' rank='sys_MakeHtml' target='main' />
</m:top>

<m:top name='�ɼ�����' display='none' rank='co_NewRule,co_ListNote,co_ViewNote,co_Switch,co_GetOut'>
  <m:item name='���ݹ���ģ��' link='co_export_rule.php' rank='co_NewRule' target='main' />
  <m:item name='�ɼ��ڵ����' link='co_main.php' rank='co_ListNote' target='main' />
  <m:item name='���������ݹ���' link='co_url.php' rank='co_ViewNote' target='main' />
  <m:item name='������������' link='javascript:;' tmp='co_data_export_out.php' rank='co_GetOut' target='main'/>
</m:top>

<m:top name='�������' display='none'>
  <m:item name='���������' link='plus_main.php' rank='10' target='main' />
  $plusset
</m:top>

<m:top name='�ļ��ϴ�����' display='none' rank='sys_Upload,sys_MyUpload,plus_�ļ�������'>
  <m:item name='�ϴ����ļ�' link='media_add.php' rank='' target='main' />
  <m:item name='�������ݹ���' link='media_main.php' rank='sys_Upload,sys_MyUpload' target='main' />
  <m:item name='�ļ�ʽ������' link='file_manage_main.php?activepath=".urlencode($cfg_medias_dir)."' rank='plus_�ļ�������' target='main' />
</m:top>

<m:top name='ģ�����' display='none' rank='temp_One,temp_Other,temp_MyTag,temp_test,temp_All'>
  <m:item name='���ܱ����' link='mytag_tag_guide.php' rank='temp_Other' target='main'/>
  <m:item name='�Զ������' link='mytag_main.php' rank='temp_MyTag' target='main'/>
  <m:item name='ȫ�ֱ�ǲ���' link='tag_test.php' rank='temp_Test' target='main'/>
  <m:item name='���ģ��Ŀ¼' link='catalog_do.php?dopost=viewTemplet' rank='temp_All' target='main'/>
</m:top>

<m:top name='��Ա����' display='none' rank='member_List,member_Type'>
  <m:item name='ע���Ա�б�' link='member_main.php' rank='member_List' target='main' />
  <m:item name='��ԱȨ�޹���' link='member_rank.php' rank='member_Type' target='main' />
  <m:item name='ͨ��֤����' linka='sys_passport.php' link='javascript:;' rank='sys_Edit' target='main' />
</m:top>

<m:top name='ϵͳ����' display='none' rank='sys_User,sys_Group,sys_Edit,sys_Log,sys_Data'>
  <m:item name='ϵͳ�û�����' link='sys_admin_user.php' rank='sys_User' target='main' />
  <m:item name='�û����趨' link='sys_group.php' rank='sys_Group' target='main' />
  <m:item name='�޸�ϵͳ����' link='sys_info.php' rank='sys_Edit' target='main' />
  <m:item name='ϵͳ��־����' link='log_list.php' rank='sys_Log' target='main' />
  <m:item name='ͼƬˮӡ����' link='sys_info_mark.php' rank='sys_Edit' target='main' />
  <m:item name='���ݿⱸ��/��ԭ' link='sys_data.php' rank='sys_Data' target='main' />
  <m:item name='SQL�����й���' link='sys_sql_query.php' rank='sys_Data' target='main' />
</m:top>

<m:top name='ϵͳ����' display='none'>
  <m:item name='ģ���Ƿ���' link='templets_menu.php' rank='' target='_self' />
  <m:item name='ģ�����ο�' link='help_templet.php' rank='' target='main' />
  <m:item name='�ٷ���̳' link='http://bbs.dedecms.com/' rank='' target='_blank' />
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
	if($ctag->GetName()=="top" 
	&& ($ctag->GetAtt('rank')=='' || TestPurview($ctag->GetAtt('rank')) )
	)
	{
		echo "<!-- Item ".($i+1)." Strat -->\r\n";
		$htmp = str_replace("~channelname~",$ctag->GetAtt("name"),$headTemplet);
		$htmp = str_replace("~display~",$ctag->GetAtt("display"),$htmp);
		$htmp = str_replace("~cc~",$i,$htmp);
		echo $htmp;
		$dtp2->LoadSource($ctag->InnerText);
		foreach($dtp2->CTags as $j=>$ctag2)
		{
			if($ctag2->GetName()=="item"
			&& ($ctag2->GetAtt('rank')=='' || TestPurview($ctag2->GetAtt('rank')) )
			)
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