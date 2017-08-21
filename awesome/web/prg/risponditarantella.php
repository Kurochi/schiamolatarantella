<?php
require_once "../libs/conn.php";
require_once "../libs/session.php";
require_once "../libs/user.php";
require_once "../libs/tarantella.php";

if (!isset($_POST["corpo"]) || !isset($_POST["id"]))
{
    die("richiestaIncompleta");
}

$corpo = substr(trim($_POST["corpo"]), 0, 500);
$corpo = nl2br(htmlspecialchars($corpo));

if (strlen(str_replace("\n", "", str_replace("\r", "", $corpo))) == 0)
{
    die("corpoVuoto");
}

$id = $_POST["id"];
if (($id = filter_var($id, FILTER_VALIDATE_INT)) === false)
{
    die("tarantellaInvalida");
}


$session = Session::CheckSession();
if ($session === SessionStatus::User)
{
    $userID = Session::GetUserID();

    $tarantella = Tarantella::GetByID($id);
    if (!($tarantella instanceof Tarantella) || $tarantella->GetDestinatario() != $userID)
    {
        die("tarantellaInvalida");
    }

    if ($tarantella->Rispondi($corpo) === true)
    {
        die("success");
    }
    else
    {
        die("impossibileRispondere");
    }
}
else
{
    die("nonLoggato");
}