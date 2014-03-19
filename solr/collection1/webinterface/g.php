<?php
	function facetsearch($query,$fields){
		//bool $all = false;//tittle
		//bool $year = false;
		//$facetAll = "&facet=true&facet.field=title";

				
	
		//fields to facet
		$param = array();

		$i = 0;
		foreach($fields as $field){
			$param[i] => $field;
		}		

		//-----------------------
		$additionalParameters = array(
		   'fq' => 'thesis query',
		   'facet' => 'true',
		   // notice I use an array for a muti-valued parameter
		   'facet.field' => for(i=0; i<param.length; i++)
		   {
			 additionalParameters[i] => $param[i];
		   }
		);
		$results = solr->search($query,$additionalParameters);
		return $results;
		

	}
?>
