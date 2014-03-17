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
		$limit = 5;
		$queries = array(
			'creator: Role of sefD and sefR in the biogenesis of Salmonella enterica serovar Enteritidis SEF14 fimbriae',
			'title: MF radar observations of tides and planetary waves',
			'relation: SUA'
		);
		
		foreach ($queries as $query){
			$result = $solr->search($query, $offset, $limit);
			echo $result->getRawResponse();
		}
		//$results = $solr->search('name:'.$userquery,0,20);
		//echo 'hello world';
	}
?>
