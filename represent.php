<?php
error_reporting(E_ERROR | E_PARSE);
?>
<style>
ul {
 list-style-type: disc;
 list-style-position: inside;
}
</style>
<?php
if(!function_exists('php_to_eval')){
	function php_to_eval($array, $base) {
		$js = '';
		if(is_array($array)){
			foreach ($array as $key=>$val) {
				if (is_array($val)) {
					$js .= php_to_eval($val, $base.(is_numeric($key) ? '['.$key.']' : "['".addslashes($key)."']"));
				} else {
					$js .= $base;
					$js .= is_numeric($key) ? '['.$key.']' : "['".addslashes($key)."']";
					$js .= ' = ';
					//$js .= is_numeric($val) ? ''.$val.'' : "'".addslashes($val)."'";
					$js .= "'".htmlspecialchars($val,ENT_QUOTES)."'";
					$js .= ";<br>";
				}
			}
		}
		return $js;
	}
}
function RecursiveCategories($array) {
	echo "\n<ul>\n";
	foreach ($array as $key => $vals) {
		if($vals != 0){
			echo "<li style='border-top:1px solid black;border-right:1px solid black;width:30px;margin-bottom:10px;'>".$key;
			//echo "<li>".$key;
			if (is_array($vals)) {
				RecursiveCategories($vals);
			}
			else{
				echo "\n<ul>\n";
				echo "<li style='border:1px solid black;width:30px;margin-bottom:10px;'>".$vals."</li>";
				echo "</ul>\n";
			}
			echo "</li>\n";
		}
	}
	echo "</ul>\n";
}
$a[23][45][10] = 5;
$a[24][46][1] = 2;
$a[23][46][2] = 7;
echo "<br>The representation of a multi dimensional array is : ";
RecursiveCategories($a);
echo php_to_eval($a,'\$a');
?>