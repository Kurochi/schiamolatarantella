<?php
require_once "libs/user.php";
require_once "libs/session.php";
require_once "libs/tarantella.php";
require_once "libs/ssl.php";
RequireSSL();

$session = Session::CheckSession();
$user = Session::$User;
if ($session == SessionStatus::User)
{
    if (isset($_GET["i"]) && $_GET["i"] == Session::GetUniqID())
    {
        header("Location: profilo/index.php");
        die();
    }
}
else
{
    header("Location: login.php");
    die();
}

$numeroTarantelle = 0;
$htmlTarantelle = [];
$nomeUtente = "";
if (isset($_GET["i"]))
{
    $profileUser = User::GetByUniqID($_GET["i"]);
    if ($profileUser instanceof User)
    {
        $nomeUtente = $profileUser->GetAnonimo() ? $profileUser->GetNomeUtente() : $profileUser->GetNome() . " " . $profileUser->GetCognome() . " (" . $profileUser->GetNomeUtente() . ")";
        $tarantelle = Tarantella::GetByDestinatario($profileUser->GetID(), true);
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
                    $nomeVisibile = "<div class=\"mittenteTarantella\"><a href=\"profilo.php?i=$uniqID\">$nomeVisibile</a></div>";
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
    }

    $numeroTarantelle = count($htmlTarantelle);
    if ($numeroTarantelle == 0)
    {
        $htmlTarantelle[] = "<div class=\"tarantella\"><div class=\"tarantellaInviata\"><div class=\"mittenteTarantella\">Nessuna tarantella schiata!</div><div class=\"corpoTarantella\">Sembra che nessuno abbia schiato una tarantella con questa persona! Cosa aspetti?</div></div></div>";
        $numeroTarantelle = 1;
    }
}
?>
<!doctype html>
<html>
<head>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="https://nibirumail.com/docs/scripts/nibirumail.cookie.min.js" defer></script>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="js/requests.js"></script>
</head>
<body>
<?php include "header.php" ?>
<div id="bodyContainer">
    <?php
    if (isset($profileUser) && $profileUser instanceof User)
    {
    ?>
        <h1>Profilo di <?= $nomeUtente ?></h1>
        <div id="contenitoreTarantelle">
            <?php
            for ($i = 0; $i < $numeroTarantelle; $i++)
            {
                echo $htmlTarantelle[$i];
            }
            ?>
        </div>
        <h1>Schia una tarantella!</h1>
        <form>
            <input type="hidden">
            <p>
                <textarea id="corpoTarantella" maxlength="500" rows="5"></textarea>
                <span id="conteggioCaratteri">Caratteri restanti: 500</span>
            </p>
            <p>
                <label>
                    <input id="checkboxTarantellaAnonima" type="checkbox">Schia anonimamente
                </label>
            </p>
            <p>
                <label>
                    <input id="tastoSchia" type="button" value="Vai, schia!">
                </label>
            </p>
        </form>
    <?php
    }
    else
    {
    ?>
        <h1>Profilo non trovato!</h1>
    <?php
    }
    ?>
</div>
</body>
<script>
    var messaggiErrore = {
        "richiestaIncompleta" : "Non ci hai inviato tutti i dati!",
        "corpoVuoto" : "Non hai inserito un testo nella tua tarantella!",
        "opzioneAnonimoInvalida" : "Opzione anonimato invalida!",
        "mittenteUgualeDestinatario" : "Non puoi schiare una tarantella con te stesso!",
        "nessunDestinatario" : "Impossibile trovare il destinatario!",
        "impossibileSchiareTarantella" : "Errore nello schiare la tarantella!",
        "nonLoggato" : "Eseguire l'accesso."
    };

    $(document).ready(function () {
        var getParams = processGetString();
        $("#tastoSchia").click(function () {
            $.ajax({
                type: 'POST',
                url: 'prg/schiatarantella.php',
                data: {
                    'corpo' : $("#corpoTarantella").val(),
                    'anonimo': $("#checkboxTarantellaAnonima").is(':checked') ? 1 : 0,
                    'destinatario': getParams["i"]
                },
                success: function(msg){
                    if (msg !== "success")
                    {
                        alert(messaggiErrore[msg]);
                        if (msg === "nonLoggato")
                        {
                            location.href = 'login.php';
                        }
                    }
                    else
                    {
                        alert("Tarantella schiata!");
                        location.reload();
                    }
                },
                error: function () {
                    alert(messaggiErrore["impossibileSchiareTarantella"]);
                }
            });
        });

        $("#corpoTarantella").on("keyup propertychange paste", function () {
           $("#conteggioCaratteri").html("Caratteri restanti: " + (500 - $(this).val().length));
        });
    });
</script>
</html>