<?php
 
    $dbHost = "127.0.0.1";
    $dbPort = null;
    $dbDatabase = "ngulir_app";
    $dbUsername = "ngulir_app";
    $dbPassword = "Behrooz1Dante@G";
    
    for ($x = 0;$x <= 3;$x++)
    { 
        $OK = true;
        try
        {
            $database = new Medoo\Medoo(["type" => "mysql", "host" => $dbHost, "database" => $dbDatabase, "port" => $dbPort, "username" => $dbUsername, "password" => $dbPassword, "charset" => "utf8mb4", "collation" => "utf8mb4_general_ci"]);
        }
        catch(Exception $e)
        {
            error_log($e);
            $OK = false; 
        }
        if ($OK)
        {
            break;
        }
    }
    
?>