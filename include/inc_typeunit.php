<?
//ԭ��������ļ���ȫ�������Ѿ�ת�Ƶ� inc_typeunit2.php
//Ŀǰ�����Ľ��ǻ�ȡ�¼�Ŀ¼ID�ĺ���
//--------------------------------
require_once(dirname(__FILE__)."/../include/config_base.php");
$idArrary = "";
//------------------------------------------------------
//-----������ĳ��Ŀ��ص��¼�Ŀ¼����ĿID�б�(ɾ����Ŀ������ʱ����)
//------------------------------------------------------
function TypeGetSunTypes($ID,$dsql,$channel=0)
{
		if($ID!=0) $GLOBALS['idArray'][$ID] = $ID;
		$fid = $ID;
	  if($channel!=0) $csql = " And channeltype=$channel ";
	  else $csql = "";
		$dsql->SetQuery("Select ID From #@__arctype where reID=$ID $csql");
		$dsql->Execute("gs".$fid);
		while($row=$dsql->GetObject("gs".$fid)){
			TypeGetSunTypes($row->ID,$dsql,$channel);
		}
		return $GLOBALS['idArray'];
}
//----------------------------------------------------------------------------
//���ĳID���¼�ID(��������)��SQL��䡰($tb.typeid=id1 or $tb.typeid=id2...)��
//----------------------------------------------------------------------------
function TypeGetSunID($ID,$dsql,$tb="#@__archives",$channel=0)
{
		$GLOBALS['idArray'] = "";
		TypeGetSunTypes($ID,$dsql,$channel);
		$rquery = "";
		foreach($GLOBALS['idArray'] as $k=>$v){
			if($tb!="")
			{
			  if($rquery!="") $rquery .= " Or ".$tb.".typeid='$k' ";
			  else      $rquery .= "    ".$tb.".typeid='$k' ";
		  }
		  else
		  {
		  	if($rquery!="") $rquery .= " Or typeid='$k' ";
			  else      $rquery .= "    typeid='$k' ";
		  }
		}
		return " (".$rquery.") ";
}
?>