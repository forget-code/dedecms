<?
require("../config.php");
?>
<HTML>
<HEAD>
<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
<base target='main'>
<style>
td { font-size: 9pt; color: #FFFFFF;}
a:link { font-size: 9pt; color: #FFFFFF; text-decoration: none }
a:visited{ font-size: 9pt; color: #FFFFFF; text-decoration: none }
a:hover {color: red;background-color:yellow}
</style>
<script language="javascript">
<!--
var now_show,line_height,folderHeight,folderNum;
//�˵��߶�
line_height = 22;
//ָ��Ŀ¼��
folderWidth = 110;
//Ŀ¼���ݣ��������ļ��л�ȡ
folder1=new Array(
"item-0-2.gif",
"1-type.gif",
"<a href='../list_type.php'>��վƵ������</a>",
"1-mode.gif",
"<a href='../web_type_web.php'>���ģ�����</a>",
"1-allmode.gif",
"<a href='../file_view.php?activepath=<?=$mod_dir?>'>ͨ��ģ�����</a>",
"1-home-app.gif",
"<a href='../add_home_page.php'>��ҳ������</a>",
"1-help-book.gif",
"<a href='../web_mode.php'>ģ�����ο�</a>"
);
folder2=new Array(
"item-5-2.gif",
"1-type.gif",
"<a href='../list_news.php'>�ۺ�����</a>",
"1-news-member.gif",
"<a href='../list_news_member.php'>�������</a>",
"1-spec.gif",
"<a href='../list_news_spec.php'>ר�����</a>",
"1-member.gif",
"<a href='../list_user.php'>��Ա����</a>",
"1-pinglun.gif",
"<a href='../list_feedback.php'>���۹���</a>"
);
folder3=new Array(
"item-1-2.gif",
"1-news.gif",
"<a href='../add_news_view.php'>��ͨ���·���</a>",
"1-news-sp.gif",
"<a href='../add_news_spec.php'>ר�ⴴ����</a>",
"1-pic-add.gif",
"<a href='../add_news_pic.php'>ͼ��������</a>",
"1-soft-add.gif",
"<a href='../add_news_soft.php'>���������</a>",
"1-flash.gif",
"<a href='../add_news_flash.php'>Flash��</a>"
);
folder4=new Array(
"item-4-2.gif",
"1-supply.gif",
"<a href='../add_my_news.php'>վ�����ŷ���</a>",
"1-link.gif",
"<a href='../add_friendlink.php'>�������ӹ���</a>",
"1-supply.gif",
"<a href='<?=$art_php_dir?>/guestbook/index.php'>���Բ�����</a>",
"1-vote.gif",
"<a href='../add_vote.php'>ͶƱ����</a>",
"1-news-manage.gif",
"<a href='../add_news_url.php'>��Ϣ�ɱ�</a>"
);
folder5=new Array(
"item-6-2.gif",
"1-news.gif",
"<a href='../file_view.php'>�ļ������</a>",
"1-pic-add.gif",
"<a href='../file_pic.php'>ͼƬ�����</a>");
folder6=new Array(
"item-3-2.gif",
"1-link.gif",
"<a href='../sys_domysql.php'>mysql����</a>",
"1-type.gif",
"<a href='../sys_back_data.php'>���ݱ���</a>");
folder7=new Array(
"item-7-2.gif",
"1-member.gif",
"<a href='../sys_manager.php'>����Ա�ʺ�</a>",
"1-userrank.gif",
"<a href='../sys_membertype.php'>��Ա�������</a>",
"1-dede.gif",
"<a href='../blank.php'>ϵͳ�Լ����</a>",
"1-dede.gif",
"<a href='../sys_info.php'>ϵͳ��װ����</a>",
"1-sys-exit.gif",
"<a href='../exit.php' target='_parent'>�˳�ϵͳ</a>"
);
folderNum = 7;
/*---------------����Ϊʵ�ֲ���-----------------------------*/
//��ʼ���˵�
function showlayer(show_pos)
{
var contect_start,contect_end,i,j
var now_top,folderNow,folderLength;
now_top = 0;
contect_start="<table width='111' border='0' cellpadding='0' cellspacing='0'><tr><td align='center'><table width='103' border='0'>";
contect_end = "</table></td></tr></table></div>";
///////////////////////////////////////////////////////
for(i=1;i<=folderNum;i++)
{
      forderNow = eval("folder"+i);
      folderLength = forderNow.length;
      document.write("<div id='title"+ i +"' style='position:absolute;top:"+ now_top +";width:"+ folderWidth +";height:"+ line_height +"'><img src='"+ forderNow[0] +"' width='"+ folderWidth +"' onclick='changelayer("+ i +")' style='cursor:hand'></div>");    
      now_top = now_top + 22;
      if(show_pos==i)
      {
      now_show = show_pos;
      document.write("<div id='content"+ i +"' style='position:absolute;top:"+ now_top +";width:"+ folderWidth +";height:"+ line_height*((folderLength-1)/2) +"'>");
      document.write(contect_start);
      for(j=1;j<=folderLength-1;j++)
      {
          document.write("<tr><td width='18' align='center'><img src='"+ forderNow[j] +"' width='18' height='18'></td><td width='75'>"+ forderNow[j+1] +"</td></tr>");
          now_top = now_top + 22;
          j = j+1;
      }
      document.write(contect_end);
      }
      else
      {
       document.write("<div id='content"+ i +"' style='position:absolute;visibility:hidden;top:"+ now_top +";width:"+ folderWidth +";height:"+ line_height*((folderLength-1)/2) +"'>");
      document.write(contect_start);
      for(j=1;j<=folderLength-1;j++)
      {
          document.write("<tr><td width='18' align='center'><img src='"+ forderNow[j] +"' width='18' height='18'></td><td width='75'>"+ forderNow[j+1] +"</td></tr>");
          now_top = now_top + 0;
          j = j+1;
      }
      document.write(contect_end);
      }     
}
}
//������Ŀ
function changelayer(show_pos)
{
   var arrNow,contentNow,contentNew,titleNow,i,top_now;
   arrNow = eval("folder"+show_pos);
   top_now = 0;
   if(show_pos!=now_show)
   {
          if(document.all)
          {
               contentNow = eval("content"+now_show);
               contentNew = eval("content"+show_pos);
               contentNow.style.visibility='hidden';
               if(show_pos>now_show)
               {
                   contentNew.style.visibility='visible';
                   for(i=1;i<=show_pos;i++)
                   {
                      titleNow = eval("title"+i);
                      titleNow.style.pixelTop = top_now;
                      top_now = top_now + line_height;         
                   }
                   contentNew.style.pixelTop = top_now;
                   top_now = top_now + ((arrNow.length-1)/2)*line_height;
                   for(i=show_pos+1;i<=folderNum;i++)
                   {
                      titleNow = eval("title"+i);
                      titleNow.style.pixelTop = top_now;
                      top_now = top_now + line_height;         
                   }
                   now_show = show_pos;
               }
               else
               {
                   top_now = show_pos * line_height;
                   contentNew.style.visibility='visible';
                   contentNew.style.pixelTop = top_now;
                   top_now = top_now + ((arrNow.length-1)/2)*line_height;
                   for(i=show_pos+1;i<=folderNum;i++)
                   {
                      titleNow = eval("title"+i);
                      titleNow.style.pixelTop = top_now;
                      top_now = top_now + line_height;         
                   }
                   now_show = show_pos;
               }
                                              
          }
   }
}
-->
</script>
</HEAD>
<BODY background='../img/bulebg.gif' leftmargin='0' topmargin='0'>
<script language="javascript">
//Ĭ����ʾ�Ĳ˵�
now_show = 2;
showlayer(now_show);
</script>
</BODY>
</HTML>
