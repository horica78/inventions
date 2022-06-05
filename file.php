<?php
set_time_limit(0);
ini_set('memory_limit','5096M');
function my_count($arr){
	return is_countable($arr)?count($arr):0;
}
class file_list{
	var $list = array();
	function dirr($path){
		$arr_dirt = scandir($path);
		$j=0;
		for($i=0;$i<my_count($arr_dirt);$i++){
			if($arr_dirt[$i] != "." && $arr_dirt[$i] != ".."){
				if(is_dir($path.DIRECTORY_SEPARATOR.$arr_dirt[$i])){
					$this->dirr($path.DIRECTORY_SEPARATOR.$arr_dirt[$i]);
				}
				else{
					$arr_dir[$j++] = $path.DIRECTORY_SEPARATOR.$arr_dirt[$i];
					$this->list[] = $path.DIRECTORY_SEPARATOR.$arr_dirt[$i];
	//
				}
			}
			else{
				$arr_dir[$j++] = $path.DIRECTORY_SEPARATOR.$arr_dirt[$i];//comment if you want only the files
				$this->list[] = $path.DIRECTORY_SEPARATOR.$arr_dirt[$i];
			}
		}
		return $this->list;
	}
}
function dirr($path,&$list){
	$arr_dirt = scandir($path);
	for($i=0;$i<my_count($arr_dirt);$i++){
		if($arr_dirt[$i] != "." && $arr_dirt[$i] != ".."){
			if(is_dir($path.DIRECTORY_SEPARATOR.$arr_dirt[$i])){
				dirr($path.DIRECTORY_SEPARATOR.$arr_dirt[$i],$list);
			}
			else{
				$list[] = $path.DIRECTORY_SEPARATOR.$arr_dirt[$i];
//
			}
		}
		else{
			$list[] = $path.DIRECTORY_SEPARATOR.$arr_dirt[$i];
		}
	}
	return $list;
}
function dirr2($path,$list){
	if(is_null($list)){
		$list = array();
	}
	else{
		$list1 = $list;
	}
	$arr_dirt = scandir($path);
	for($i=0;$i<my_count($arr_dirt);$i++){
		if($arr_dirt[$i] == "." || $arr_dirt[$i] == ".."){
			$list1[] = $path.DIRECTORY_SEPARATOR.$arr_dirt[$i];
		}
		else{
			if(is_dir($path.DIRECTORY_SEPARATOR.$arr_dirt[$i])){
				$list1 = array_merge($list1,dirr2($path.DIRECTORY_SEPARATOR.$arr_dirt[$i],$list));
			}
			else{
				$list1[] = $path.DIRECTORY_SEPARATOR.$arr_dirt[$i];
			}
		}
	}
	return $list1;
}
//$arr_dir = dirr("/srv/httpd/htdocs/joomla/webmin-1.610");
//$arr_dir = dirr("C:/php");
//echo "<pre>".print_r($arr_dir,1)."</pre>";
echo "<br>Directory listing for C:\php in 3 ways is : ";
$obj = new file_list();
echo "<pre>".print_r($obj->dirr("C:\php"),1)."</pre>";
$arr_list = array();
echo "<pre>".print_r(dirr("C:\php",$arr_list),1)."</pre>";
$list = dirr2("C:\php",null);
echo "<pre>".print_r($list,1)."</pre>";
?>