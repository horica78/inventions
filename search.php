<?php
set_time_limit(0);
function my_count($arr){
	return is_countable($arr)?count($arr):0;
}
function getFilesWith($folder, $searchFor, $extension = 'php') {

    if($folder) {
        $foundArray = array();
        // GRAB ALL FILENAMES WITH SUPPLIED EXTENSION
        foreach(glob($folder . sprintf("*.%s", $extension)) as $file) {
            $contents = file_get_contents($file);

            if(stripos($contents, $searchFor) !== false) {
                $foundArray[] = $file;
            }
        }

        if(my_count($foundArray)) {
            return $foundArray;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

//$matched_files = getFilesWith('C:/apache/htdocs/proj', 'Worker');
function search_in_dir( $dir, $str )
{
    $files = glob( "{$dir}/*.php" );
	$files2 = glob( "{$dir}/*.js" );
	$files = array_merge($files,$files2);
    foreach( $files as $k => $file )
    {
        $source = file_get_contents( $file );
        if( stripos( $source, $str ) === false )
        {
            unset( $files[$k] );
        }
    }
    return array_filter( $files );
}
function search_in_dir2($path,&$list,$str){
	$arr_dirt = scandir($path);
	$j=0;
	for($i=0;$i<my_count($arr_dirt);$i++){
		if($arr_dirt[$i] != "." && $arr_dirt[$i] != ".."){
			if(is_dir($path.DIRECTORY_SEPARATOR.$arr_dirt[$i])){
				search_in_dir2($path.DIRECTORY_SEPARATOR.$arr_dirt[$i],$list,$str);
			}
			else{
				if(fnmatch("*.js", $arr_dirt[$i]) || fnmatch("*.php", $arr_dirt[$i])  || fnmatch("*.css", $arr_dirt[$i]) || fnmatch("*.html", $arr_dirt[$i]) || fnmatch("*.java", $arr_dirt[$i])){
					$source = file_get_contents( $path.DIRECTORY_SEPARATOR.$arr_dirt[$i] );
					if(stripos($source, $str) !== false ){
						$list[] = $path.DIRECTORY_SEPARATOR.$arr_dirt[$i];
					}
				}
			}
		}
	}
	return $list;
}
function search_in_dir3($path,&$list,$str){
	$path = str_replace("/",DIRECTORY_SEPARATOR,$path);
	$files = search_in_dir2( $path,$list,$str );
	return $files;
}
function matches_in_file($file,$searchfor){
	$contents = file($file);
	$pattern = preg_quote($searchfor, '/');
	$pattern = "/^(?i).*$pattern.*\$/m";
	for($l=0;$l<my_count($contents);$l++){
		if (preg_match_all($pattern, $contents[$l], $matches,PREG_OFFSET_CAPTURE)) {
			for($i=0;$i<my_count($matches);$i++){
				for($j=0;$j<my_count($matches[$i]);$j++){
					echo "\n----------------------line : ".$l."---offset : ".stripos($contents[$l],$searchfor)."---occurence : ".trim($matches[$i][$j][0]);
				}
			}
		}
	}
}
$list = array();
//and example to access the script "http://localhost/inventions/search.php?q=simplexml_load_string&dir=d:/work"
echo "<br>Rsults of the search in depth with this example of accessing in address bar of the browser 'https://localhost/inventions/search.php?q=simplexml_load_string&dir=d:/work' : ";
$files = search_in_dir3( $_REQUEST['dir'],$list,$_REQUEST['q'] );
header('Content-Type: text/plain');
//var_dump($files);
/*$fn = <<<'CODE'
function is_ssl() {
	if ( isset($_SERVER['HTTPS']) ) {
		if ( 'on' == strtolower($_SERVER['HTTPS']) )
			return true;
		if ( '1' == $_SERVER['HTTPS'] )
			return true;
	} elseif ( isset($_SERVER['SERVER_PORT']) && ( '443' == $_SERVER['SERVER_PORT'] ) ) {
		return true;
	}
	return false;
}
CODE;*/
for($i=0;$i<my_count($files);$i++){
	echo "\n".$files[$i];
	/*$sf = file_get_contents($files[$i]);
	$sf = str_replace($fn,"\n",$sf);
	file_put_contents($files[$i],$sf);*/
	matches_in_file($files[$i],$_REQUEST['q']);
}
?>
