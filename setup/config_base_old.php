<?
/*-----------------------------------------
// DedeCms �������ļ�
// �������Ҫ�Ķ�ĳЩѡ����ȱ��ݱ��ļ�
-----------------------------------------*/

require_once(dirname(__FILE__)."/config_start.php");

//վ�����ַ
$cfg_basehost = "~baseurl~";

//DedeCms��װĿ¼
$cfg_cmspath = "~basepath~";

//վ���Ŀ¼
$ndir = str_replace("\\","/",dirname(__FILE__));
$cfg_basedir = eregi_replace($cfg_cmspath."/include[/]{0,1}$","",$ndir);

//���ݿ�������Ϣ
$cfg_dbname = "~dbname~";
$cfg_dbhost = "~dbhost~";
$cfg_dbuser = "~dbuser~";
$cfg_dbpwd = "~dbpwd~";
$cfg_dbprefix = "~dbprefix~";

//cookie������
$cfg_cookie_encode = "EWT237827fdfsFSDA";

//��ҳ��ҳ���Ӻ�����
$cfg_indexurl = "~indexurl~";
$cfg_indexname = "��ҳ";

//��վ���ƣ�RSS�б���,�������������Ϊ��վ������
$cfg_webname = "~cfg_webname~"; 

//ͳ����Ա��Email,��վ�뷢���йصĳ���������Email
$cfg_adminemail = "~email~";

//DedeCms �汾��Ϣ

$cfg_powerby = "<a href='http://www.dedecms.com' target='_blank'>Power by DedeCms ֯�����ݹ���ϵͳ</a>";

$cfg_version = "3.0_final"; //�벻Ҫɾ���������ϵͳ�޷���ȷ��������©����������Ϣ

//�ĵ�Ĭ�ϱ���·��
//����û�й��������Ҳ�ᱣ�������Ŀ¼
//---------------------------------------------------
$cfg_arcdir = $cfg_cmspath."/html";

//ģ��Ĵ��Ŀ¼
$cfg_templets_dir = $cfg_cmspath."/templets";

//ͼƬ�������Ĭ��·��
$cfg_medias_dir = $cfg_cmspath."/upimg";

//���Ŀ¼�����Ŀ¼�����ڴ�ż�������ͶƱ�����۵ȳ���ı�Ҫ��̬����
$cfg_plus_dir = $cfg_cmspath."/plus";

//��չĿ¼������RSS����վ��ͼ��RSS��ͼ��JS�ļ�����չ����
//Ϊ�˲�Ū̫��ϵͳĿ¼,����Щ�������ŵ� $cfg_plus_dir ��
$cfg_extend_dir = $cfg_plus_dir;

//��ԱĿ¼
$cfg_member_dir = $cfg_cmspath."/member";

//���ݱ���Ŀ¼
$cfg_backup_dir = $cfg_plus_dir."/~bakdir~";

//�ϴ�����ͨͼƬ��·��,���鰴Ĭ��
$cfg_image_dir = $cfg_medias_dir."/allimg";

//�ϴ�������ͼ
$ddcfg_image_dir = $cfg_medias_dir."/litimg";
//����ͼ�Ĵ�С����
$cfg_ddimg_width = 200;
$cfg_ddimg_height = 150;
//ͼ��Ĭ����ʾͼƬ�Ĵ�С
$cfg_album_width = 600;

//ר���б�Ĵ��·��
$cfg_special = $cfg_cmspath."/special";

//�û�Ͷ��ͼƬ���Ŀ¼
$cfg_user_dir = $cfg_medias_dir."/userup";

//�ϴ������Ŀ¼
$cfg_soft_dir = $cfg_medias_dir."/soft";

//�ϴ��Ķ�ý���ļ�Ŀ¼
$cfg_other_medias = $cfg_medias_dir."/media";

//�ļ�ѡ������������ļ�����
$cfg_imgtype = "jpg|gif|png";

$cfg_softtype = "exe|zip|gz|rar|iso";

$cfg_mediatype = "swf|mpg|dat|avi|mp3|rm|rmvb|wmv|asf|vob|wma|wav|mid|mov";

//���Ŀ¼�������ȷ������Ŀ¼���Ѿ���������������������
require_once(dirname(__FILE__)."/config_makenewdir.php");

//����ѡ�
//-------------------------------

$cfg_specnote = 6; //ר������ڵ���

$art_shortname = ".html"; //Ĭ����չ���������������򲻺���չ����ʱ�����

//�ĵ���Ĭ����������
$cfg_df_namerule = "{Y}/{M}{D}/{aid}.html";

//��Ŀλ�õļ������,��Ŀ>>��Ŀ��>>��Ŀ��
$cfg_list_symbol = " &gt; ";

//�½�Ŀ¼��Ȩ��
//�����ʹ�ñ�����ԣ����̲���֤������˳����Linux��Unixϵͳ����
$cfg_dir_purview = 0777;

require_once(dirname(__FILE__)."/pub_db_mysql.php");
require_once(dirname(__FILE__)."/inc_functions.php");

?>