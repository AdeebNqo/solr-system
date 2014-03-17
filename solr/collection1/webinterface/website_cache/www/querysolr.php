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
</header>
<?php 
	
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
		foreach ($queries as $query){
			$result = $solr->search($query, $offset, $limit);
			//check if there are any results
			if ($result->response->numFound > 0){
				
				foreach ( $result->response->docs as $doc ){
					echo "<div class=\"record\">";
						echo "<h3>$doc->title</h3>";
						echo "<p class=\"description\"> $doc->description </p>";
						echo" <div class=\"id\"> <a href=\" $doc->id\">$doc->id</a> </div>"; 
					
					echo "</div>";
        			}  
		echo "</div>"; 
        			
			}
		}
	}
?>
</body>
</html>

