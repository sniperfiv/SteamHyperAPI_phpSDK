<?php
header("Content-type: image/jpeg");
header("Cache-Control: no-cache, must-revalidate");
$rootdir="D:\\wwwroot2\\";
include($rootdir.'sql.php');
$steamuid=$_GET['steamuid'];
if ($steamuid==""){
	header("Content-type: application/json;charset=utf-8");
	header("Cache-Control: no-cache, must-revalidate");
	echo '{"success":0,"info":"Lack of Get Method.0"}';//捕抓异常
	exit;
}
$xmlback=vpost('http://steamcommunity.com/profiles/'.$steamuid.'/?xml=1&l=schinese',NULL,NULL,NULL,NULL,TRUE);
//xml_parse_into_struct
//unset ($p ,$xmlback );
//echo $xmlback;
$p  =  xml_parser_create ();
xml_parse_into_struct ( $p ,  $xmlback ,  $vals ,  $index );
xml_parser_free ( $p );
//print_r($vals);
foreach ($vals as $var1){
	if ($var1['tag']=="AVATARFULL"){
		$url=$var1['value'];
		break 1;
	}

};
echo vpost ($url);
exit;
?>