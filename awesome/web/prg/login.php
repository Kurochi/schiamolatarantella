<?php
require_once "../libs/session.php";
require_once "../libs/user.php";
require_once "../libs/ssl.php";
RequireSSL();

$session = Session::CheckSession();

if ($session == SessionStatus::User)
{
    header("Location: ../index.php");
    die();
}

$nomeUtente = $_POST["nomeUtente"];
$nomeUtente = trim($nomeUtente);
$password = $_POST["password"];
$lunghezzaNomeUtente = strlen($nomeUtente);
if ($lunghezzaNomeUtente < 3 || $lunghezzaNomeUtente > 16 || preg_match("/[^a-zA-Z0-9]/", $nomeUtente))
{
    die("Nome utente invalido.");
}

$loginResult = User::Login($nomeUtente, $password);
if ($loginResult instanceof User)
{
    Session::Init($loginResult);
    header("Location: ../index.php");
    die();
}
elseif (is_string($loginResult))
{
    header("Location: ../login.php?error=db&dbError=" . urlencode($loginResult));
    die();
}
else
{
    switch ($loginResult)
    {
        case LoginResult::NoUser:
            header("Location: ../login.php?error=wrongLogin");
            die();
            break;
        case LoginResult::WrongLogin:
            header("Location: ../login.php?error=wrongLogin");
            die();
            break;
        default:
            header("Location: ../login.php?error=error");
            die();
            break;
    }
}