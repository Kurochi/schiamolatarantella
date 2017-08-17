<?php
require_once "config.php";
function RequireSSL()
{
    global $debugMode;
    if ($debugMode)
    {
        return;
    }
    
    if($_SERVER["HTTPS"] != "on")
    {
        header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
        exit();
    }
}
