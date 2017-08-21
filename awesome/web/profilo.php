<?php
require_once "libs/user.php";
require_once "libs/session.php";
require_once "libs/tarantella.php";

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
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
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
                <textarea id="#corpoTarantella" maxlength="500" rows="5"></textarea>
                Caratteri restanti: 500
            </p>
            <p>
                <label>
                    <input id="#checkboxTarantellaAnonima" type="checkbox">Schia anonimamente
                </label>
            </p>
            <p>
                <label>
                    <input id="tastoSchia" type="submit" value="Vai, schia!">
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
    $(document).ready(function () {
        $("#tastoSchia").click(function () {
            $.ajax({
                type: 'POST',
                // make sure you respect the same origin policy with this url:
                // http://en.wikipedia.org/wiki/Same_origin_policy
                url: 'http://nakolesah.ru/',
                data: {
                    'foo': 'bar',
                    'ca$libri': 'no$libri' // <-- the $ sign in the parameter name seems unusual, I would avoid it
                },
                success: function(msg){

                },
                error: function () {
                    
                }
            });
        })
    });
</script>
</html>