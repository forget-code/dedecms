<?
require("config.php");
class GuestBook
{
	var $nowPage=1;
	var $totalResult=0;
	var $pageSize=10;
	var $con;
	function GuestBook($pages,$npage,$totalrs)
	{
		if($npage==0) $npage=1;
		$this->nowPage = $npage;
		$this->totalResult = $totalrs;
		$this->pageSize = $pages;
		$this->con = connectMySql();
	}
	function GetTotal()
	{
		if($this->totalResult==0)
		{
			$rs = mysql_query("select count(ID) as dd from dede_guestbook where ischeck=1",$this->con);
			$row = mysql_fetch_array($rs);
			$this->totalResult = $row["dd"];
		}
		return $this->totalResult;
	}
	//������ҳ��
	function getTotalPage()
	{
		return ceil($this->GetTotal()/$this->pageSize);
	}
	//����mysql��ҳ��ѯʱ�� limit ����
	function getLimit()
	{
		if($this->nowPage==""||$this->nowPage==0) $this->nowPage=1;
		$limit_start = ($this->nowPage-1)*$this->pageSize;
		return " limit ".$limit_start.",".$this->pageSize." ";
	}	
	//��ҳ�б��������------------------------------------
 	//$get_var ҳ������
 	//$total_record �ܼ�¼��
 	//$page_size ÿҳ��¼��  (��ѡ,Ĭ��Ϊ20)
 	//$list_len �б���     (��ѡ��Ĭ��Ϊ5,ʵ�ʳ���Ϊ $list_len*2+1)
 	//����get_page_list("inc_page_list.php",323,7,5);
	//////////////////////////////////////////////////////
	function getPageList($get_var,$list_len=5)
	{
    	$totalrecord = $this->GetTotal();
    	if($totalrecord!=0)
    	{
			if(!ereg("\?",$get_var)) $get_var.="?tag=0";
			if($this->nowPage==""||$this->nowPage==0) $this->nowPage=1;
			$totalpage=$this->getTotalPage();
			$prepage = $this->nowPage-1;
			$nextpage = $this->nowPage+1;
			echo "��".$this->GetTotal()."����¼ ".$this->nowPage."/".$totalpage."ҳ ";
			if($prepage>0)
			{
				echo "<a href='".$get_var."&totalrecord=".$totalrecord."&page=1'>��ҳ</a>\r\n";
				echo "<a href='".$get_var."&totalrecord=".$totalrecord."&page=".$prepage."'>��һҳ</a>\r\n";
			}
			$total_list = $list_len * 2 + 1;
        	if($this->nowPage >= $total_list) 
        	{
        		$i=$this->nowPage-$list_len;
        		$total_list=$this->nowPage+$list_len;
        		if($total_list>$totalpage) $total_list=$totalpage;
        	}	
        	else
        	{ 
        		$i=1;
        		if($total_list>$totalpage) $total_list=$totalpage;
       	 	}
        	for($i;$i<=$total_list;$i++)
        	{
        		if($i==$this->nowPage) echo "$i ";
        		else echo "<a href='".$get_var."&totalrecord=".$totalrecord."&page=".$i."'>[".$i."]</a>\r\n";
        	}
        	if($nextpage<=$totalpage)
        	{
				echo "<a href='".$get_var."&page=".$nextpage."&totalrecord=".$totalrecord."'>��һҳ</a>\r\n";
				echo "<a href='".$get_var."&totalrecord=".$totalrecord."&page=".$totalpage."'>δҳ</a>\r\n";
			}
   		}
   		else
   		{
   			echo "û�κμ�¼��";
   		}
	}
	//�����������
	function printResult()
	{
		if($this->GetTotal()>0)
		{
			$rs = mysql_query("select * from dede_guestbook where ischeck=1 order by ID desc".$this->getLimit(),$this->con);
			while($row=mysql_fetch_object($rs))
			{
				$msg = "
				<table width='760' border='0' cellpadding='3' cellspacing='1' bgcolor='#E6D85A'>
  <tr>
    <td width='160' rowspan='3' valign='top' bgcolor='#FFFFFF'>
    <table border='0' cellPadding='4' cellSpacing='0' width='100%'>
      <tr>
        <td align=center width='17%'><img src='images/".$row->face.".gif' border=0></td>
      </tr>
    </table>
      <P> 
     &nbsp;������".$row->uname."<br>
	 &nbsp;���ԣ�".$row->ip."<br>
	 &nbsp;QQ��".$row->qq."<br>
	</P></td>
    <td width='600' bgcolor='#FFFFFF'><img height='16' src='images/time.gif' width='16'> ����ʱ��: ".$row->dtime." </td>
  </tr>
  <tr>
    <td height='100' bgcolor='#FFFFFF'>
    ".$row->msg."
    </td>
  </tr>
  <tr>
    <td bgcolor='#FFFFFF'>
    <a href='mailto:".$row->email."'><img src='images/mail.gif' border=0 width='16' height='16'>[�ʼ�]</a> 
    <a href='http://".$row->homepage."' target='_blank'><img src='images/home.gif' border=0 width='16' height='16'>[��ҳ]</a>  
    <a href='edit.php?ID=".$row->ID."'><img src='images/quote.gif' border=0 height=16 width=16>[�ظ�/�༭]</a>  
    <a href='edit.php?ID=".$row->ID."&job=del'><img src='images/del.gif' border=0 height=16 width=16>[ɾ��]</a> 
    </td>
  </tr>
</table>
<table width='760'><td height='2'></td></table>
				";
				echo $msg;
			}
		}
	}
}
?>