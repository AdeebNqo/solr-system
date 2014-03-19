<?php
	

	require('/Solarium/Autoloader.php');
	Solarium_Autoloader::register();

	ini_set('display_errors',1);
	ini_set('display_startup_errors',1);
	error_reporting(-1);

	$config = array(
		'host' => '127.0.01',
		'port' => 8983,
		'path' => '/solr',
		'core' => 'collection1',
	 );
	$client = new Solarium_Client($config)
?>
