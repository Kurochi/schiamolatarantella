<?php
require_once "../libs/session.php";
require_once "../libs/user.php";
require_once "../libs/tarantella.php";

if (!isset($_POST["destinatario"]) || !isset($_POST["corpo"]) || !isset($_POST["anonimo"]))
{
    die("richiestaIncompleta");
}

$destinatario = $_POST["destinatario"];
$corpo = substr(trim($_POST["corpo"]), 0, 500);
$corpo = htmlspecialchars($corpo);
$anonimo = $_POST["anonimo"];

if (($destinatario = filter_var($destinatario, FILTER_VALIDATE_INT)) === false)
{
    die("nessunDestinatario");
}

if (($anonimo = filter_var($anonimo, FILTER_VALIDATE_INT)) === false)
{
    $anonimo = 0;
}
$anonimo = $anonimo > 0 ? 1 : 0;

$session = Session::CheckSession();
if ($session === SessionStatus::User)
{
    $userID = Session::GetUserID();
    if ($destinatario === $userID)
    {
        die("mittenteUgualeDestinatario");
    }

    $destinatario = User::GetByID($destinatario);
    if (!($destinatario instanceof User))
    {
        die("nessunDestinatario");
    }

    $destinatario = $destinatario->GetID();
    $tarantella = new Tarantella();
    $tarantella->SetDestinatario($destinatario);
    $tarantella->SetMittente($userID);
    $tarantella->SetCorpo($corpo);
    $tarantella->SetAnonimo($anonimo);

    if ($tarantella->Insert() !== true)
    {
        die("impossibileSchiareTarantella");
    }
    die("success");
}
else
{
    die("nonLoggato");
}