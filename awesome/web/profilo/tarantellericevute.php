<?php
require_once "../libs/user.php";
require_once "../libs/session.php";
require_once "../libs/tarantella.php";

$session = Session::CheckSession();
$user = Session::$User;
if ($session !== SessionStatus::User)
{
    header("Location: ../login.php");
    die();
}

$numeroTarantelle = 0;
$htmlTarantelle = [];

$tarantelle = Tarantella::GetByDestinatario(Session::GetUserID(), false);
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
        $idTarantella = $tarantella->GetID();
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

        $htmlTarantelle[] = "<div class=\"tarantella cliccabile\" key=\"$idTarantella\"><div class=\"tarantellaInviata\">$nomeVisibile$corpoTarantella</div>$rispostaTarantella</div>";
    }
}

$numeroTarantelle = count($htmlTarantelle);
if ($numeroTarantelle == 0)
{
    $htmlTarantelle[] = "<div class=\"tarantella\"><div class=\"tarantellaInviata\"><div class=\"mittenteTarantella\">Nessuna tarantella ricevuta!</div><div class=\"corpoTarantella\">Che c'hai paura? Non condividi il tuo profilo?</div></div></div>";
    $numeroTarantelle = 1;
}
?>
<!doctype html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
</head>
<body>
<?php include "../header.php" ?>
<?php include "barra_profilo.php" ?>
<div id="bodyContainer">
    <h1>Tarantelle ricevute</h1>
    <div id="contenitoreTarantelle">
        <?php
        for ($i = 0; $i < $numeroTarantelle; $i++)
        {
            echo $htmlTarantelle[$i];
        }
        ?>
    </div>
</div>
<div id="contenitoreRisposta">
    <div id="contenitoreRispostaSfondo">
    </div>
    <div id="contenitoreRispostaSfondoForm">
        <form>
            <h1>Fagliela pagare!</h1>

            <input type="hidden">
            <p>
                <textarea id="corpoRisposta" maxlength="500" rows="5"></textarea>
                <span id="conteggioCaratteri">Caratteri restanti: 500</span>
            </p>
            <p>
                <input id="tastoRispondi" type="button" value="Sputagli in faccia!">
                <input id="tastoChiudi" type="button" value="Lascia stare">
            </p>
        </form>
    </div>
</div>
</body>
<script>
    var messaggiErrore = {
        "richiestaIncompleta" : "Non ci hai inviato tutti i dati!",
        "corpoVuoto" : "Non hai inserito un testo nella tua risposta!",
        "impossibileRispondere" : "Errore nell'inviare la risposta!",
        "nonLoggato" : "Eseguire l'accesso.",
        "tarantellaInvalida" : "Impossibile trovare tarantella!"
    };

    var azioni = [
        "Sputagli in faccia!",
        "Ammazzagli la testa!",
        "Pugnalalo in culo!",
        "Alabarda spaziale!",
        "Spaccagli i denti!",
        "Tiragli un calcio in bocca!",
        "Uccidilo finchè non muore!",
        "Eliminagli i salvataggi dalla playstation!",
        "Chiama mammina!",
        "Spezzagli le cosce!",
        "Attorcirgliagli il ditino del piede!"
    ];
    $(document).ready(function () {
        var tarantellaAttuale = -1;

        $(".tarantella.cliccabile").click(function () {
            tarantellaAttuale = $(this)[0].getAttribute("key");
            $("#tastoRispondi")[0].setAttribute("value", azioni[Math.floor(Math.random()*azioni.length)]);
            $("#contenitoreRisposta").show();
        });

        $("#tastoChiudi").click(function () {
            $("#contenitoreRisposta").hide();
        });

        $("#tastoRispondi").click(function () {
            $.ajax({
                type: 'POST',
                url: '../prg/risponditarantella.php',
                data: {
                    'corpo' : $("#corpoRisposta").val(),
                    'id': tarantellaAttuale
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
                        alert("Risposta inviata!");
                        location.reload();
                    }
                },
                error: function () {
                    alert(messaggiErrore["impossibileRispondere"]);
                }
            });
        });

        $("#corpoRisposta").on("keyup propertychange paste", function () {
            $("#conteggioCaratteri").html("Caratteri restanti: " + (500 - $(this).val().length));
        });
    });
</script>
</html>