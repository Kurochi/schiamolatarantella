<?php
require_once "../libs/conn.php";
require_once "../libs/session.php";
require_once "../libs/user.php";
require_once "../libs/tarantella.php";

if (!isset($_POST["destinatario"]) || !isset($_POST["corpo"]) || !isset($_POST["anonimo"]))
{
    die("richiestaIncompleta");
}

$destinatario = $_POST["destinatario"];
$corpo = substr(trim($_POST["corpo"]), 0, 500);
$corpo = nl2br(htmlspecialchars($corpo));

if (strlen(str_replace("\n", "", str_replace("\r", "", $corpo))) == 0)
{
    die("corpoVuoto");
}

$anonimo = $_POST["anonimo"];

if (($anonimo = filter_var($anonimo, FILTER_VALIDATE_INT)) === false)
{
    die("opzioneAnonimoInvalida");
}
$anonimo = $anonimo > 0 ? 1 : 0;

$session = Session::CheckSession();
if ($session === SessionStatus::User)
{
    $uniqID = Session::GetUniqID();
    if ($destinatario === $uniqID)
    {
        die("mittenteUgualeDestinatario");
    }

    $destinatario = User::GetByUniqID($destinatario);
    if (!($destinatario instanceof User))
    {
        die("nessunDestinatario");
    }

    $conn->autocommit(false);

    $idDestinatario = $destinatario->GetID();
    $tarantella = new Tarantella();
    $tarantella->SetDestinatario($idDestinatario);
    $tarantella->SetMittente(Session::GetUserID());
    $tarantella->SetCorpo($corpo);
    $tarantella->SetAnonimo($anonimo);

    if (Session::$User->AggiornaUltimaSchiata() !== true || !is_int($tarantella->Insert()))
    {
        die("impossibileSchiareTarantella");
    }

    if ($conn->commit())
    {
        die("success");
    }
    else
    {
        die("impossibileSchiareTarantella");
    }
}
else
{
    die("nonLoggato");
}