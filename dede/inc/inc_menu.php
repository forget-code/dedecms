<?php 
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
<m:top name='��ݲ˵�' display='block' c='9,' rank=''>
  <m:item name='��վ��Ŀ����' link='catalog_main.php' rank='t_List,t_AccList' target='main' />
  <m:item name='���е����б�' link='content_list.php' rank='a_List,a_AccList' target='main' />
  <m:item name='�ҷ������ĵ�' link='content_list.php?adminid=".$cuserLogin->getUserID()."' rank='a_List,a_AccList,a_MyList' target='main' />
  <m:item name='����˵��ĵ�' link='content_list.php?arcrank=-1' rank='a_Check,a_AccCheck' target='main' />
  <m:item name='��ԱͶ���ĵ�' link='content_list.php?ismember=1' rank='a_Check,a_AccCheck' target='main' />
  <m:item name='�ĵ����۹���' link='feedback_main.php' rank='sys_Feedback' target='main' />
  <m:item name='�������ݹ���' link='media_main.php' rank='sys_Upload,sys_MyUpload' target='main' />
</m:top>

<m:top name='Ƶ������' display='block' c='1,' rank=''>
  <m:item name='����ģ�͹���' link='mychannel_main.php' rank='c_List' target='main' />
  <m:item name='��վ��Ŀ����' link='catalog_main.php' rank='t_List,t_AccList' target='main' />
  <m:item name='�����б����' link='freelist_main.php' rank='c_FreeList' target='main' />
  <m:item name='��ҳ�ĵ�����' link='templets_one.php' rank='temp_One' target='main'/>
</m:top>

<m:top name='�ĵ�ά��' c='2,' display='block'>
  <m:item name='���е����б�' link='content_list.php' rank='a_List,a_AccList' target='main' />
  <m:item name='�ҷ������ĵ�' link='content_list.php?adminid=".$cuserLogin->getUserID()."' rank='a_List,a_AccList,a_MyList' target='main' />
  <m:item name='����˵��ĵ�' link='content_list.php?arcrank=-1' rank='a_Check,a_AccCheck' target='main' />
  <m:item name='��ԱͶ���ĵ�' link='content_list.php?ismember=1' rank='a_Check,a_AccCheck' target='main' />
  <m:item name='�ĵ����۹���' link='feedback_main.php' rank='sys_Feedback' target='main' />
  <m:item name='�������ݹ���' link='media_main.php' rank='sys_Upload,sys_MyUpload' target='main' />
  <m:item name='�ĵ���Ϣͳ��' link='content_tj.php' rank='sys_ArcTj' target='main' />
</m:top>

<m:top name='���ݷ���' c='9,' display='block' rank=''>
  <m:item name='������Ŀ�ṹ' link='catalog_menu.php' rank='' target='_self' />
  $addset
</m:top>

<m:top name='��������' c='2,' display='block'>
  <m:item name='�ĵ�����ά��' link='content_batch_up.php' rank='sys_ArcBatch' target='main' />
  <m:item name='�ĵ��ؼ���ά��' link='article_keywords_main.php' rank='sys_Keyword' target='main' />
  <m:item name='�����ؼ��ʴ���' link='search_keywords_main.php' rank='sys_Keyword' target='main' />
  <m:item name='�Զ�ժҪ|��ҳ' link='article_description_main.php' rank='sys_description' target='main' />
  <m:item name='��ȡ��������ͼ' link='makeminiature/makeminiature.php' rank='sys_ArcBatch' target='main' />
  <m:item name='�ظ��ĵ����' link='article_test_same.php' rank='sys_ArcBatch' target='main' />
  <m:item name='���ݿ������滻' link='sys_data_replace.php' rank='sys_ArcBatch' target='main' />
</m:top>

<m:top name='ר�����' display='block' c='6,' rank=''>
  <m:item name='������ר��' link='spec_add.php' rank='spec_New' target='main' />
  <m:item name='ר���б�' link='content_s_list.php' rank='spec_List' target='main' />
  <m:item name='����ר��HTML' link='makehtml_spec.php' rank='sys_MakeHtml' target='main' />
</m:top>

<m:top name='HTML����' display='block' rank='' c='3,'>
  <m:item name='������ҳHTML' link='makehtml_homepage.php' rank='sys_MakeHtml' target='main' />
  <m:item name='������ĿHTML' link='makehtml_list.php' rank='sys_MakeHtml' target='main' />
  <m:item name='�����ĵ�HTML' link='makehtml_archives.php' rank='sys_MakeHtml' target='main' />
  <m:item name='������վ��ͼ' link='makehtml_map_guide.php' rank='sys_MakeHtml' target='main' />
  <m:item name='����RSS�ļ�' link='makehtml_rss.php' rank='sys_MakeHtml' target='main' />
  <m:item name='��ȡJS�ļ�' link='makehtml_js.php' rank='sys_MakeHtml' target='main' />
  <m:item name='����ר���б�' link='makehtml_spec.php' rank='sys_MakeHtml' target='main' />
  <m:item name='���������б�' link='makehtml_freelist.php' rank='sys_MakeHtml' target='main' />
</m:top>

<m:top name='�ɼ�����' display='block' rank='' c='6,'>
  <m:item name='���ݹ���ģ��' link='co_export_rule.php' rank='co_NewRule' target='main' />
  <m:item name='�ɼ��ڵ����' link='co_main.php' rank='co_ListNote' target='main' />
  <m:item name='���������ݹ���' link='co_url.php' rank='co_ViewNote' target='main' />
  <m:item name='������������' link='javascript:;' tmp='co_data_export_out.php' rank='co_GetOut' target='main'/>
</m:top>

<m:top name='�������' c='5,' display='block'>
  <m:item name='���������' link='plus_main.php' rank='10' target='main' />
  $plusset
</m:top>

<m:top name='ģ�����' display='block' c='4,' rank=''>
  <m:item name='���ܱ����' link='mytag_tag_guide.php' rank='temp_Other' target='main'/>
  <m:item name='�Զ������' link='mytag_main.php' rank='temp_MyTag' target='main'/>
  <m:item name='ȫ�ֱ�ǲ���' link='tag_test.php' rank='temp_Test' target='main'/>
  <m:item name='���ģ��Ŀ¼' link='catalog_do.php?dopost=viewTemplet' rank='temp_All' target='main'/>
</m:top>

<m:top name='ģ���ǲο�' display='block' c='4,' rank=''>
  <m:item name='ͨ��ģ����' link='help_templet_all.php' rank='' target='main'/>
  <m:item name='����ģ����' link='help_templet_index.php' rank='' target='main'/>
  <m:item name='�б�ģ����' link='help_templet_list.php' rank='' target='main'/>
  <m:item name='�ĵ�ģ����' link='help_templet_view.php' rank='' target='main'/>
  <m:item name='����ģ����' link='help_templet_other.php' rank='' target='main'/>
  <m:item name='�����ϸ����' link='templets_menu.php' rank='' target='_self' />
</m:top>

<m:top name='��Ա����' c='6,' display='block'>
  <m:item name='ע���Ա�б�' link='member_main.php' rank='member_List' target='main' />
  <m:item name='��Ա��������' link='member_rank.php' rank='member_Type' target='main' />
  <m:item name='��Ա��Ʒ����' link='member_type.php' rank='member_Type' target='main' />
  <m:item name='�㿨��Ʒ����' link='member_card_type.php' rank='member_Card' target='main' />
  <m:item name='�㿨ҵ���¼' link='member_card.php' rank='member_Operations' target='main' />
  <m:item name='��Աҵ���¼' link='member_operations.php' rank='member_Operations' target='main' />
  <m:item name='���ݵ�����ת��' link='member_data.php' rank='member_Data' target='main' />
  <m:item name='�������ͱ任' link='member_password.php' rank='member_Data' target='main' />
</m:top>

<m:top name='ϵͳ�ʺŹ���' c='7,' display='block' rank=''>
  <m:item name='ϵͳ�ʺŹ���' link='sys_admin_user.php' rank='sys_User' target='main' />
  <m:item name='�û����趨' link='sys_group.php' rank='sys_Group' target='main' />
</m:top>

<m:top name='ϵͳ����' c='7,' display='block' rank=''>
  <m:item name='ϵͳ��������' link='sys_info.php' rank='sys_Edit' target='main' />
  <m:item name='ͼƬˮӡ����' link='sys_info_mark.php' rank='sys_Edit' target='main' />
  <m:item name='ͨ��֤����' link='sys_passport.php' rank='sys_Passport' target='main' />
  <m:item name='ϵͳ��־����' link='log_list.php' rank='sys_Log' target='main' />
</m:top>

<m:top name='��������' c='9,' display='block' rank=''>
  <m:item name='ϵͳ�ʺŹ���' link='sys_admin_user.php' rank='sys_User' target='main' />
  <m:item name='ϵͳ��������' link='sys_info.php' rank='sys_Edit' target='main' />
  <m:item name='ͼƬˮӡ����' link='sys_info_mark.php' rank='sys_Edit' target='main' />
  <m:item name='ͨ��֤����' link='sys_passport.php' rank='sys_Passport' target='main' />
</m:top>

<m:top name='Ƶ������' c='7,1,2,' display='block' rank=''>
  <m:item name='�Զ����ĵ�����' link='content_att.php' rank='sys_Att' target='main' />
  <m:item name='���Ƶ������' link='soft_config.php' rank='sys_SoftConfig' target='main' />
  <m:item name='���ɼ�������' link='article_string_mix.php' rank='sys_StringMix' target='main' />
  <m:item name='��Դ����' link='article_source_edit.php' rank='sys_Source' target='main' />
  <m:item name='���߹���' link='article_writer_edit.php' rank='sys_Writer' target='main' />
</m:top>

<m:top name='���ݿ����' c='7,' display='block' rank=''>
  <m:item name='SQL����������' link='sys_sql_query.php' rank='sys_Data' target='main' />
  <m:item name='���ݿⱸ��' link='sys_data.php' rank='sys_Data' target='main' />
  <m:item name='���ݿ⻹ԭ' link='sys_data_revert.php' rank='sys_Data' target='main' />
</m:top>

<m:top name='ϵͳ����' c='7,4,9,' display='block'>
  <m:item name='ģ�����ο�' link='http://www.dedecms.com/archives/templethelp/help/index.htm' rank='' target='_blank' />
  <m:item name='�ٷ���̳' link='http://bbs.dedecms.com/' rank='' target='_blank' />
</m:top>

-----------------------------------------------
";
function GetMenus($userrank)
{
if(isset($_GET['c'])) $catalog = $_GET['c'];
else $catalog = 2;
global $menus;
$headTemplet = "
  <div onClick='showHide(\"items~cc~\")' class='topitem' align='left'> 
    <div class='topl'><img src='img/mtimg1.gif' width='21' height='24' border='0'></div>
    <div class='topr'>~channelname~</div>
  </div>
  <div style='clear:both'></div>
  <div style='display:~display~' id='items~cc~' class='itemsct'> 
";
$footTemplet = "  </div>";
$itemTemplet = "  <dl class='itemem'> 
    <dd class='tdl'><img src='img/newitem.gif' width='7' height='10' alt=''/></dd>
    <dd class='tdr'><a href='~link~' target='~target~'>~itemname~</a></dd>
  </dl>
";
/////////////////////////////////////////
$dtp = new DedeTagParse();
$dtp->SetNameSpace("m","<",">");
$dtp->LoadSource($menus);
$dtp2 = new DedeTagParse();
$dtp2->SetNameSpace("m","<",">");
foreach($dtp->CTags as $i=>$ctag)
{
	$lc = $ctag->GetAtt('c');
	if($ctag->GetName()=="top" 
	&& (ereg($catalog.',',$lc) || $catalog=='0') )
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