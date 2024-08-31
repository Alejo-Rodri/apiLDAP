<?php
require 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();


$wsdl = $_ENV['SOAP_WSDL'];

$client = new SoapClient($wsdl);

try {
    //$response = $client->createEntry("Jesus", "jesus de nazareth", "x", "jesus@cristo.com", "dios");
    //$response = $client->updatePassword("okComputer", "keepBreathing");
    $response = $client->authenticate("Jesus", "dios");
    //$response = $client->readEntry("okComputer");
    //echo "Estado: " . $response['status'] . "\n";
    //echo "Atributos del usuario:\n";
    var_dump($response);
} catch (SoapFault $fault) {
    echo "Error: " . $fault->getMessage() . "\n";
}
?>