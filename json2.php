<?php
error_reporting(E_ERROR | E_PARSE);
$arr[0][0] = '1';
$arr[0][1] = 'Alba';
$arr[1][0] = '2';
$arr[1][1] = 'Banat';
$arr[2][0] = '3';
$arr[2][1] = 'Boston';
$arr[3][0] = '4';
$arr[3][1] = 'Boston';
$arr[4][0] = '5';
$arr[4][1] = 'Boston';
$arr[5][0] = '6';
$arr[5][1] = 'Dej';
$arr[6][0] = '7';
$arr[6][1] = 'Baia Mare';
$arr[7][0] = '8';
$arr[7][1] = 'BostonBostonBostonBostonBostonBoston';
$arr[8][0] = '8';
$arr[8][1] = "Bos'ton";
$arr[9][0] = '8';
$arr[9][1] = 'Colorado';
$arr[10][0] = '8';
$arr[10][1] = 'Fonta';
$arr[11][0] = '8';
$arr[11][1] = 'redmond';
$arr[12][0] = '8';
$arr[12][1] = 'Boston';
$arr[13][0] = '8';
$arr[13][1] = 'Boston';


$arr_search = array();
for($i=0;$i<count($arr);$i++){
	if(strpos(strtoupper($arr[$i][1]),strtoupper($_REQUEST['val'])) !== false){
		$arr_eu[$i][0] = $arr[$i][0];
		$arr_eu[$i][1] = htmlspecialchars($arr[$i][1],ENT_QUOTES);//strtoupper(str_replace(strtolower($_REQUEST['val']),"#".strtolower($_REQUEST['val'])."|",strtolower($arr[$i][1])));
		array_push($arr_search,$arr_eu[$i]);
	}
}
echo json_encode($arr_search);
?>