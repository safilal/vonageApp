<?php
namespace vonage;

error_reporting(E_ALL);
require __DIR__ . '/vendor/autoload.php';
require ('core/connections/config.php');
require ('core/connections/createSession.php');
require ('core/connections/vonageMonitor.php');
require('core/scripts/config.php');
require('core/scripts/displayResponse.php');


//require 'autoloader.php';

$session = new createSession(VRESTAPI, VUSERNAME, VPASSWORD);
$listener = new monitorVonage($session);

/**
 * Create a form class to prompt user for phone extension
 * $extension = $_POST['extension'];
 */
//phpinfo();
//print_r(ini_get('soap.wsdl_cache_dir'));
//die;
$extension = '830'; // $_GET['830'];
$response = $listener->checkStatus($extension);
$displayer = new displayResponse($response);
$displayer->display();