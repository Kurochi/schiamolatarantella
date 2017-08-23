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

$tarantelle = Tarantella::GetByMittente(Session::GetUserID());
$numeroTarantelle = count($tarantelle);
for ($i = 0; $i < $numeroTarantelle; $i++)
{
    $tarantella = $tarantelle[$i];
    $destinatarioTarantella = User::GetByID($tarantella->GetDestinatario());
    if ($destinatarioTarantella instanceof User)
    {
        $nomeVisibile = $destinatarioTarantella->GetNome() . " " . $destinatarioTarantella->GetCognome() . " (" . $destinatarioTarantella->GetNomeUtente() . ")";
        $uniqID = $destinatarioTarantella->GetUniqID();
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
    $htmlTarantelle[] = "<div class=\"tarantella\"><div class=\"tarantellaInviata\"><div class=\"mittenteTarantella\">Nessuna tarantella schiata!</div><div class=\"corpoTarantella\">Ma sei un coglione? Vai a schiare subito delle tarantelle!</div></div></div>";
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
    <h1>Tarantelle schiate</h1>
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