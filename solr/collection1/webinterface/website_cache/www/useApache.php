<?php
        error_reporting(E_ALL);
        ini_set('display_errors', true);

        require_once('Apache/Solr/Service.php');
        $solr = new Apache_Solr_Service('localhost','8983','/solr/');

?>
