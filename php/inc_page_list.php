<?
/*----��ҳ�б��������------------------------------------
 $get_var ҳ������
 $total_record �ܼ�¼��
 $page_size ÿҳ��¼��  (��ѡ,Ĭ��Ϊ20)
 $list_len �б���     (��ѡ��Ĭ��Ϊ5,ʵ�ʳ���Ϊ $list_len*2+1)
 ����get_page_list("inc_page_list.php",323,7,5);
---------------------------------------------------------*/
function get_page_list($get_var,$total_record,$page_size=20,$list_len=5)
{
    global $page;
    if($total_record!=0){
	if(!ereg("\?",$get_var)) $get_var.="?tag=0";
	if($page=="") $page=1;
	if($total_record%$page_size!=0)
	$total_page=ceil($total_record/$page_size);
	else
	$total_page=$total_record/$page_size;
	$prepage = $page-1;
	$nextpage = $page+1;
	echo "��".$total_record."����¼ ".$page."/".$total_page."ҳ ";
	if($prepage>0){
		echo "<a href='".$get_var."&total_record=".$total_record."'>��ҳ</a>\r\n";
		echo "<a href='".$get_var."&total_record=".$total_record."&page=".$prepage."'>��һҳ</a>\r\n";
	}
	$total_list = $list_len * 2 + 1;
        if($page>=$total_list) 
        {
        	$i=$page-$list_len;
        	$total_list=$page+$list_len;
        	if($total_list>$total_page) $total_list=$total_page;
        }	
        else
        { 
        	$i=1;
        	if($total_list>$total_page) $total_list=$total_page;
        }
        for($i;$i<=$total_list;$i++)
        {
        	if($i==$page) echo "$i ";
        	else echo "<a href='".$get_var."&total_record=".$total_record."&page=".$i."'>[".$i."]</a>\r\n";
        }
        if($nextpage<=$total_page){
		echo "<a href='".$get_var."&page=".$nextpage."&total_record=".$total_record."'>��һҳ</a>\r\n";
		echo "<a href='".$get_var."&total_record=".$total_record."&page=".$total_page."'>δҳ</a>\r\n";
	}
   }
   else
   {
   	echo "û�κμ�¼��";
   }
	
}
/*-----------------------������ҳ��--------------------------*/
function get_total_page($total_record,$page_size)
{
	return ceil($total_record/$page_size);
}
/*---------------get_limit������mysql��ҳ��ѯʱ�� limit ����-----*/
function get_limit($page_size)
{
	global $page;
	if($page=="") $page=1;
	$limit_start = ($page-1)*$page_size;
	return " limit ".$limit_start.",".$page_size." ";
}
?>