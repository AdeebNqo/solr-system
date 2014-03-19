<?php
	function facetsearch($query,$fields,$fq){
		//fields to facet
		$param = array();
		//all facet fields
		$additionalParameters = array(
		   'fq' => $fq,
		   'facet' => 'true'
		);
		foreach($fields as $field){
			$param['facet.field'] => $field;
		}
		$results = solr->search($query,-1,-1,$additionalParameters);
		return $results;
	}
?>
