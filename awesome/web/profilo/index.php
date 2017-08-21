<?php
require_once "../libs/user.php";
require_once "../libs/session.php";
require_once "../libs/tarantella.php";
require_once "../libs/ssl.php";
RequireSSL();

$session = Session::CheckSession();
$user = Session::$User;
if ($session !== SessionStatus::User)
{
    header("Location: ../login.php");
    die();
}

$numeroTarantelle = 0;
$htmlTarantelle = [];

$tarantelle = Tarantella::GetByDestinatario(Session::GetUserID(), true);
$numeroTarantelle = count($tarantelle);
for ($i = 0; $i < $numeroTarantelle; $i++)
{
    $tarantella = $tarantelle[$i];
    $mittenteTarantella = User::GetByID($tarantella->GetMittente());
    if ($mittenteTarantella instanceof User)
    {
        $nomeVisibile = $tarantella->GetAnonimo() ? "Anonimo" : ($mittenteTarantella->GetAnonimo() ? "Anonimo (" . $mittenteTarantella->GetNomeUtente() . ")" : $mittenteTarantella->GetNome() . " " . $mittenteTarantella->GetCognome() . " (" . $mittenteTarantella->GetNomeUtente() . ")");
        $uniqID = $mittenteTarantella->GetUniqID();
        $corpoTarantella = $tarantella->GetCorpo();
        $rispostaTarantella = $tarantella->GetRisposta();
        if (!$tarantella->GetAnonimo())
        {
            $nomeVisibile = "<div class=\"mittenteTarantella\"><a href=\"../profilo.php?i=$uniqID\">$nomeVisibile</a></div>";
        }
        else
        {
            $nomeVisibile = "<div class=\"mittenteTarantella\">$nomeVisibile</div>";
        }
        $corpoTarantella = "<div class=\"corpoTarantella\">$corpoTarantella</div>";
        $rispostaTarantella = "<div class=\"rispostaTarantella\">$rispostaTarantella</div>";

        $htmlTarantelle[] = "<div class=\"tarantella\"><div class=\"tarantellaInviata\">$nomeVisibile$corpoTarantella</div>$rispostaTarantella</div>";
    }
}

$numeroTarantelle = count($htmlTarantelle);
if ($numeroTarantelle == 0)
{
    $htmlTarantelle[] = "<div class=\"tarantella\"><div class=\"tarantellaInviata\"><div class=\"mittenteTarantella\">Nessuna tarantella!</div><div class=\"corpoTarantella\">Che c'hai paura? Non condividi il tuo profilo?</div></div></div>";
    $numeroTarantelle = 1;
}
?>
<!doctype html>
<html>
<head>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="https://nibirumail.com/docs/scripts/nibirumail.cookie.min.js" defer></script>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
<?php include "../header.php" ?>
<?php include "barra_profilo.php" ?>
<div id="bodyContainer">
    <h1>Il mio profilo</h1>
    <span style="font-weight: bold">https://www.<?= $_SERVER["SERVER_NAME"] ?>/profilo.php?i=<?= Session::GetUniqID() ?></span>
    <div id="contenitoreTarantelle">
        <?php
        for ($i = 0; $i < $numeroTarantelle; $i++)
        {
            echo $htmlTarantelle[$i];
        }
        ?>
    </div>
</div>
</body>
</html>