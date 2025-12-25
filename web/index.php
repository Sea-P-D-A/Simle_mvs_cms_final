<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//echo "DEBUG: Starting...<br>";

try {
    echo "DEBUG: Loading web_autoload.php<br>";
    require_once('web_autoload.php');
    
 //   echo "DEBUG: Loading configs<br>";
    $config = require(__DIR__ . '/../application/config/web.php');
    $localConfig = require(__DIR__ . '/../application/config/web-local.php');
    
 //   echo "DEBUG: Configs loaded<br>";
    require_once("../application/bootstrap.php");
    
 //   echo "DEBUG: Running app<br>";
    \ItForFree\SimpleMVC\Application::get()
        ->setConfiguration($config)
        ->run();
        
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "<br>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
