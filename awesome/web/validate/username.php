<?php
require "../libs/conn.php";
require "../libs/user.php";

$response = ["valid" => true, "message" => ""];
if (isset($_POST["nomeUtente"]))
{
    $username = $_POST["nomeUtente"];
    if (strlen($username) >= 3 && strlen($username) <= 16)
    {
        $userResult = User::GetByUsername($username);
        if ($userResult instanceof User)
        {
            $response["valid"] = false;
            $response["message"] = "Il nome utente è già in uso.";
        }
        elseif (is_string($userResult))
        {
            $response["valid"] = false;
            $response["message"] = "Impossibile verificare la disponibilità del nome utente.";
        }
        elseif (preg_match("/[^a-zA-Z0-9]/", $username))
        {
            $response["valid"] = false;
            $response["message"] = "Il nome utente può solo contenere lettere o numeri.";
        }
    }
    else
    {
        $response["valid"] = false;
        $response["message"] = "Il nome utente deve essere lungo tra i 3 e i 16 caratteri.";
    }
}
echo json_encode($response);