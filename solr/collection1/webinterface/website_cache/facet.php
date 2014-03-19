<?php
	function facetsearch($query,$fields){
		$results = solr->search();
		return $results;
	}
?>
