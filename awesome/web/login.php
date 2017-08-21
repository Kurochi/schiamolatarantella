<?php
require_once "libs/ssl.php";
require_once "libs/user.php";
require_once "libs/session.php";
RequireSSL();

$session = Session::CheckSession();
if ($session == SessionStatus::User)
{
    header("Location: index.php");
    die();
}

$risultatiLogin = [
    "wrongLogin" => "Credenziali errate!",
    "error" => "Errore sconosciuto."
];
$error = $_GET["error"] ?? null;
$risultatoLogin = isset($error) ? ($error == "db" ? urldecode($_GET["dbError"] ?? "Errore MySQL") : $risultatiLogin[$error] ?? "Eseguire l'accesso") : "Eseguire l'accesso.";
?>
<!doctype html>
<html>
<head>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="https://nibirumail.com/docs/scripts/nibirumail.cookie.min.js" defer></script>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<?php include "header.php" ?>
<div id="bodyContainer">
    <span id="loginResult"><?= $risultatoLogin ?></span>
    <form action="prg/login.php" method="post" style="">
        <p>
            <label>
                Nome Utente<br>
                <input type="text" name="nomeUtente" maxlength="16" data-validation="server" data-validation-url="validate/username.php" />
            </label>
        </p>
        <p>
            <label>
                Password<br>
                <input name="password" type="password" id="password" maxlength="18"/>
            </label>
        </p>
        <input type="submit" value="Entra">
    </form>
</div>
</body>
</html>