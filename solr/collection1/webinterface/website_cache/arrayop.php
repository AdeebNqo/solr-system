<?php

	function saveData($arr, $filename){
		$string_data = serialize($arr);
		$ret = file_put_contents($filename, $string_data);
		return $ret;
	}
	function readData($filename){
		$string_data = file_get_contents($filename);
		$array = unserialize($string_data);
		return $array;
	}
?>
