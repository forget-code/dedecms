<?
require_once(dirname(__FILE__)."/config.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>֯�����ݹ���ϵͳ <?=$cfg_version?></title>
<style>
body {
scrollbar-base-color:#C0D586;
scrollbar-arrow-color:#FFFFFF;
scrollbar-shadow-color:DEEFC6
}
</style>
</head>
<frameset rows="55,*" cols="*" frameborder="no" border="0" framespacing="0">
  <frame src="index_top.php" name="topFrame" scrolling="no">
  <frameset cols="152,*" name="btFrame" frameborder="NO" border="0" framespacing="0">
    <frame src="index_menu.php" name="menu" scrolling="yes">
    <frame src="index_body.php" name="main" scrolling="yes">
  </frameset>
</frameset>
<noframes>
	<body>����������֧�ֿ�ܣ�</body>
</noframes>
</html>
