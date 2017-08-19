<?php
require_once "../libs/session.php";
require_once "../libs/user.php";
require_once "../libs/securimage/securimage.php";
require_once "../libs/passwordstrength.php";

$session = Session::CheckSession();

if ($session == SessionStatus::User)
{
    header("Location: ../index.php");
    die();
}

if (!isset($_POST["captcha_code"]) || !isset($_POST["nomeUtente"]) || !isset($_POST["password"]) || !isset($_POST["confermaPassword"]))
{
    header("Location: ../registrati.php");
    die();
}

$nomeUtente = $_POST["nomeUtente"];
$nomeUtente = trim($nomeUtente);
$password = $_POST["password"];
$confermaPassword = $_POST["confermaPassword"];
$captcha_code = $_POST["captcha_code"];
$nome = $_POST["nome"] ?? "";
$nome = trim($nome);
$cognome = $_POST["cognome"] ?? "";
$cognome = trim($cognome);

if (empty($nome) || empty($cognome))
{
    $nome = "";
    $cognome = "";
}

$securimage = new Securimage();
if (!$securimage->check($captcha_code))
{
    header("Location: ../registrati.php?captchaError=1");
    die();
}

if (!preg_match("/^([A-Za-z\s]*)$/", $nome))
{
    die("Nome invalido.");
}

if (!preg_match("/^([A-Za-z\s]*)$/", $cognome))
{
    die("Nome invalido.");
}

$lunghezzaNomeUtente = strlen($nomeUtente);
if ($lunghezzaNomeUtente < 3 || $lunghezzaNomeUtente > 16 || preg_match("/[^a-zA-Z0-9]/", $nomeUtente))
{
    die("Nome utente invalido.");
}

$userResult = User::GetByUsername($nomeUtente);
if ($userResult instanceof User)
{
    die("Il nome utente è già in uso.");
}
elseif (is_string($userResult))
{
    die("Impossibile verificare la disponibilità del nome utente.");
}

if ($password !== $confermaPassword)
{
    die("Password differenti.");
}

if(strlen($password) < 8)
{
    die("La password deve essere lunga almeno 8 caratteri");
}
elseif (PasswordStrength($password) < 18)
{
    die("La password è troppo debole. Si consiglia di mescolare maiuscole, minuscole, numeri, e simboli.");
}

$registerResult = User::Register($nomeUtente, $password, $nome, $cognome);
if ($registerResult instanceof User)
{
    Session::Init($registerResult);
    header("Location: ../index.php");
    die();
}
