<!DOCTYPE HTML>

<html>

<head>
<title>SearchMe Results</title>
<link rel="stylesheet" type="text/css" href="searchme.css">
<link rel="stylesheet" tyfirefpe="text/css" href="pagination.css">
</head>

<body>
<header> <h1>Search Me</h1>
</header>
<?php
	require_once('Apache/Solr/Service.php');
	error_reporting(E_ALL);
	ini_set('display_errors', true);
		
	$filename = $_GET['name'];
	$start = $_GET['start'];
	$end = $_GET['end'];
	
	require_once 'arrayop.php';
	$docs = readData($filename);
	$numDocs = count($docs);
	$numPages = ceil($numDocs/10);
	
	for($index=$start; $index<=$end; $index++){
		$doc = $docs[$index];	
		echo "<div class=\"record\">";
		echo "<h3>$doc->title</h3>";
		echo "<p class=\"description\"> $doc->description </p>";
		echo" <div class=\"id\"> <a href=\" $doc->id\">$doc->id</a> </div>";
		echo "</div>";
	}
	//printing docs in given range
	/*if ($result->response->numFound > 0){
		foreach ( $result->response->docs as $doc ){
			echo "<div class=\"record\">";
				echo "<h3>$doc->title</h3>";
				$desc = summarize($doc->description);
				echo "<p class=\"description\"> $desc </p>";
				echo" <div class=\"id\"> <a href=\" $doc->id\">$doc->id</a> </div>";
			echo "</div>";
		}
	}*/
	//displaying paganition toolbar
	echo "<div class=\"pagination\">";
		for ($index = 1; $index<=$numPages; $index++){
			echo "<a href=\"#\" class=\"page\">" . $index . "</a>";
		}
	echo "</div>";
?>
</body>

</html>
