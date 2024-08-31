<?php
include 'Services.php';

$options = array('uri' => 'urn:ApiService');
$server = new SoapServer($_ENV['SOAP_WSDL'], $options);

$server->setClass("Services");
$server->handle();
?>