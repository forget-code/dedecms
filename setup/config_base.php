<?
/*************************************************
���ļ�����Ϣ�������û����и��ģ��������������и���
**************************************************/

//��ֹ�û��ύĳЩ�������
$ckvs = Array('_GET','_POST','_COOKIE','_FILES');
foreach($ckvs as $ckv){
    if(is_array($$ckv)){ 
    	foreach($$ckv AS $key => $value) 
    	   if(eregi("^cfg_|globals",$key)) unset(${$ckv}[$key]);
    }
}


require_once(dirname(__FILE__)."/config_hand.php");
if(!isset($needFilter)) $needFilter = false;
$registerGlobals = @ini_get("register_globals");
$isUrlOpen = @ini_get("allow_url_fopen");
$isMagic = @ini_get("magic_quotes_gpc");
$isSafeMode = @ini_get("safe_mode");

//���ϵͳ�Ƿ�ע���ⲿ����
if(!$isMagic) require_once(dirname(__FILE__)."/config_rglobals_magic.php");
else if(!$registerGlobals || $needFilter) require_once(dirname(__FILE__)."/config_rglobals.php");

unset($_ENV,$HTTP_ENV_VARS,$_REQUEST,$HTTP_POST_VARS,$HTTP_GET_VARS,$HTTP_POST_FILES,$HTTP_COOKIE_VARS);

//Session����·��
$sessSavePath = dirname(__FILE__)."/sessions/";
if(is_writeable($sessSavePath) && is_readable($sessSavePath)){ session_save_path($sessSavePath); }

//���ڽ���Ҫ�򵥣ӣѣ̲�����ҳ�棬���뱾�ļ�ǰ�Ѵ�$__ONLYDB��Ϊtrue���ɱ������벻��Ҫ���ļ�
if(!isset($__ONLYDB)) $__ONLYDB = false;

//վ���Ŀ¼
$ndir = str_replace("\\","/",dirname(__FILE__));
$cfg_basedir = eregi_replace($cfg_cmspath."/include[/]{0,1}$","",$ndir);
if($cfg_multi_site == '��') $cfg_mainsite = $cfg_basehost;
else  $cfg_mainsite = "";

//���ݿ�������Ϣ
$cfg_dbhost = '~dbhost~';
$cfg_dbname = '~dbname~';
$cfg_dbuser = '~dbuser~';
$cfg_dbpwd = '~dbpwd~';
$cfg_dbprefix = '~dbprefix~';
$cfg_db_language = '~dblang~';

//ģ��Ĵ��Ŀ¼
$cfg_templets_dir = $cfg_cmspath.'/templets';
$cfg_templeturl = $cfg_mainsite.$cfg_templets_dir;

//���Ŀ¼�����Ŀ¼�����ڴ�ż�������ͶƱ�����۵ȳ���ı�Ҫ��̬����
$cfg_plus_dir = $cfg_cmspath.'/plus';
$cfg_phpurl = $cfg_mainsite.$cfg_plus_dir;

//��ԱĿ¼
$cfg_member_dir = $cfg_cmspath.'/member';
$cfg_memberurl = $cfg_mainsite.$cfg_member_dir;

//��Ա���˿ռ�Ŀ¼#new
$cfg_space_dir = $cfg_cmspath.'/space';
$cfg_spaceurl = $cfg_basehost.$cfg_space_dir;

$cfg_medias_dir = $cfg_cmspath.$cfg_medias_dir;
//�ϴ�����ͨͼƬ��·��,���鰴Ĭ��
$cfg_image_dir = $cfg_medias_dir.'/allimg';
//�ϴ�������ͼ
$ddcfg_image_dir = $cfg_medias_dir.'/litimg';
//ר���б�Ĵ��·��
$cfg_special = $cfg_cmspath.'/special';
//�û�Ͷ��ͼƬ���Ŀ¼
$cfg_user_dir = $cfg_medias_dir.'/userup';
//�ϴ������Ŀ¼
$cfg_soft_dir = $cfg_medias_dir.'/soft';
//�ϴ��Ķ�ý���ļ�Ŀ¼
$cfg_other_medias = $cfg_medias_dir.'/media';

//���ժҪ��Ϣ��****�벻Ҫɾ������**** ����ϵͳ�޷���ȷ����ϵͳ©����������Ϣ
//-----------------------------
$cfg_softname = "֯�����ݹ���ϵͳ";
$cfg_soft_enname = "DedeCms OX";
$cfg_soft_devteam = "IT����ͼ";
$cfg_version = '3_1';

//Ĭ����չ���������������򲻺���չ����ʱ�����
$art_shortname = '.html';
//�ĵ���Ĭ����������
$cfg_df_namerule = '{typedir}/{Y}/{M}{D}/{aid}.html';
//�½�Ŀ¼��Ȩ�ޣ������ʹ�ñ�����ԣ����̲���֤������˳����Linux��Unixϵͳ����
$cfg_dir_purview = '0777';

//�������ݿ���ͳ��ú���
require_once(dirname(__FILE__).'/pub_db_mysql.php');
require_once(dirname(__FILE__).'/config_passport.php');

if($cfg_pp_need=='��'){
	$cfg_pp_login = $cfg_cmspath.'/member/login.php';
  $cfg_pp_exit = $cfg_cmspath.'/member/index_do.php?fmdo=login&dopost=exit';
  $cfg_pp_reg = $cfg_cmspath.'/member/index_do.php?fmdo=user&dopost=regnew';
}

if(!$__ONLYDB){
	require_once(dirname(__FILE__).'/inc_functions.php');
}

?>