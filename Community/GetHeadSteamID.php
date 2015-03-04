<?php
header("Content-type: application/json;charset=utf-8");
header("Cache-Control: no-cache, must-revalidate");
$rootdir="D:\\wwwroot2\\";
include($rootdir.'sql.php');
$steamuid=$_GET['steamuid'];
if ($steamuid==""){
	echo '{"success":0,"info":"Lack of Get Method.0"}';//捕抓异常
	exit;
}

if (gmp_cmp ("76561197960265728", $steamuid) == 1 )
{$steamuid= gmp_add ( "76561197960265728" ,  $steamuid );
$steamuid= gmp_strval ($steamuid);}
$xmlback=vpost('http://steamcommunity.com/profiles/'.$steamuid.'/?xml=1&l=schinese',NULL,NULL,NULL,NULL,TRUE);
//xml_parse_into_struct
//unset ($p ,$xmlback );
//echo $xmlback;
$p  =  xml_parser_create ();
xml_parse_into_struct ( $p ,  $xmlback ,  $vals ,  $index );
xml_parser_free ( $p );
//print_r($vals);
foreach ($vals as $var1){
	//steamID
	if ($var1['tag']=="STEAMID"){
		$steamID=$var1['value'];
		break 1;
	}
};
$res_out['success']=1;
$res_out['steamID']=$steamID;
$res_out['ipos']=$_GET['ipos'];
echo json_encode($res_out);
exit;
?>