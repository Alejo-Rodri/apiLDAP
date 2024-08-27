<?php
include 'Services.php';

$options = array('uri' => 'urn:ApiService');
$server = new SoapServer("http://localhost/apiphp/api_service.wsdl", $options);

$server->setClass("Services");
$server->handle();
?>