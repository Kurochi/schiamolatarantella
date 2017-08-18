<?php
require "../libs/passwordstrength.php";

$response = ["valid" => true, "message" => ""];
if (isset($_POST["password"]))
{
    $password = $_POST["password"];
    if(strlen($password) < 8)
    {
        $response["valid"] = false;
        $response["message"] = "La password deve essere lunga almeno 8 caratteri";
    }
    elseif (PasswordStrength($password) < 18)
    {
        $response["valid"] = false;
        $response["message"] = "La password è troppo debole. Si consiglia di mescolare maiuscole, minuscole, numeri, e simboli.";
    }
}

echo json_encode($response);