<?
//���ڰ�ȫģʽ��PHP,���ļ�����ע���ⲿ����
//����ļ���Ӧ���ڡ�? ?��������κεط������κ��ַ�,���򲿷ֳ�������Գ���
//��GET�����ֽ�Ϊ�ⲿ����
if (!empty($_GET))
{
    foreach($_GET AS $key => $value)
    {
    	$$key = $value;
    }
}
//��POST�����ֽ�Ϊ�ⲿ����
if (!empty($_POST))
{
    foreach($_POST AS $key => $value)
    {
    	$$key = $value;
    }
}
//��cookie�����ֽ�Ϊ�ⲿ����
if (!empty($_COOKIE))
{
    foreach($_COOKIE AS $key => $value)
    {
    	$$key = $value;
    }
}
//��FILES�����ֽ�Ϊ�ⲿ����
//FILES�����ֽ�����ⲿ����Ϊ(����ͻ��˵��ϴ�������Ϊfile1)
//$file1 ��ʱ�ļ���
//$file1_name ԭʼ�ļ���
//$file1_type �ļ�����
//$file1_tmp_name ��ʱ�ļ����� $file1 ��ͬ
//$file1_error �ļ�����
//$file1_size �ļ���С
if (!empty($_FILES)) {
    foreach($_FILES AS $name => $value)
    {
        $$name = $value['tmp_name'];
        foreach($value AS $namen => $valuen)
        {
        	${$name.'_'.$namen} = $value[$namen];
        }
    }
}
?>