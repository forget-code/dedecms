<?
if (!empty($_GET))   { foreach($_GET AS $key => $value) $$key = $value; }
if (!empty($_POST))  { foreach($_POST AS $key => $value) $$key = $value; }
if (!empty($_COOKIE)){ foreach($_COOKIE AS $key => $value) $$key = $value; }
if (!empty($_FILES)) {
  foreach($_FILES AS $name => $value)
  {
     $$name = $value['tmp_name'];
     foreach($value AS $namen => $valuen){
       ${$name.'_'.$namen} = $value[$namen];
     }
  }
}
//$file1 ��ʱ�ļ���
//$file1_name ԭʼ�ļ���
//$file1_type �ļ�����
//$file1_tmp_name ��ʱ�ļ����� $file1 ��ͬ
//$file1_error �ļ�����
//$file1_size �ļ���С
?>