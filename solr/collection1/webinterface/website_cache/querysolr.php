<html>

<head>
<title>SearchMe Results</title>
<link rel="stylesheet" type="text/css" href="searchme.css">
</head>
<body>
<header>
	<h1>Search Me</h1>
	<form action="querysolr.php" method="post">
        	<input type="text" name="searchquery">
  	 </form>

	<head>
	
	<link rel="stylesheet" type="text/css" href="pagination.css">
	</head>
</header>
<?php 
	error_reporting(E_ALL);
        ini_set('display_errors', true);

	require_once 'arrayop.php';

	//method for summarizing description
	function summarize($text){
		$len = strlen($text);
		if ($len<=600){
			return $text;
		}
		else{
			$text = substr($text,0,600);
			return $text . '...';
		}
	}

	
	error_reporting(E_ALL);
	ini_set('display_errors', true);

	require_once('useApache.php');
	
	$userquery = $_POST['searchquery'];
	if (!$solr->ping()){
		echo 'solr not responding...';
		exit;
	}
	else{
		$offset = 0;
		$limit = 10;
		
		$userquery = '*'.$userquery.'*';
		$creator = 'creator:'.$userquery;
		$title= 'title:'.$userquery;
		$subject='subject:'.$userquery;
		$description = 'description:'.$userquery;
		$dateX ='date:'.$userquery;
		$language = 'language:'.$userquery;
		$relation = 'relation:'.$userquery;
		$queries = array(
			$creator,
			$title,
			$relation,
			$subject,
			$description,
			$dateX,
			$language
		);
		echo "<div id=\"results\">";
		$docs = array(); //array to store all docs from query

		foreach ($queries as $query){
			if ($query==$description){
				$param = array(
					'hl'=>'true',
					'hl.fl'=>'description'
				);
				$result = $solr->search($query, $offset, $limit, $param);
				//var_dump(get_object_vars($result->response));
			}
			else{
				$result = $solr->search($query, $offset, $limit);
			}
			if ($result->response->numFound > 0){
				foreach ( $result->response->docs as $doc ){
					array_push($docs,$doc);
				}
			}
		}
		//storing the array in a flat file
		$numDocs = count($docs);
		$name = 'cache/'.uniqid();
		$output = saveData($docs,$name);
		echo 'docs saved!';
		if ($output!=FALSE){
	
			if ($numDocs<=10){
				header('Location: /results.php?name='.$name.'&start=1&end='.$numDocs);
			}
			else{
				//setup page to display certain ranges of docs
				header('Location: /results.php?name='.$name.'&start=1&end=10');
			}
		}
		else{
			echo "err";
		}
		
		//check if there are any results
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
	}
?>
</body>
</html>

