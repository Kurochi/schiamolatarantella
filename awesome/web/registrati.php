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
?>
<!doctype html>
<html>
<head>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="https://nibirumail.com/docs/scripts/nibirumail.cookie.min.js" defer></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
    <script src="js/passwordstrengthdisplay.js"></script>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<?php include "header.php" ?>
<div id="bodyContainer">
    <h2>Noi di www.schiamolatarantella.it non useremo i tuoi dati personali in alcun modo.</h2>
    <form action="prg/registrazione.php" method="post"> <!-- Da fare: Impostare attributi, aggiungere validazione degli input -->
        <p>
            <b>
                <span style="text-transform: uppercase">Campi opzionali<br></span>
            </b>
        </p>
        <p>
            <label>
                Nome<br>
                <input type="text" name="nome" data-validation="custom" data-validation-regexp="^([A-Za-z\s]*)$" data-validation-error-msg="Hai inserito caratteri non validi!"/>
            </label>
        </p>
        <p>
            <label>
                Cognome<br>
                <input type="text" name="cognome" data-validation="custom" data-validation-regexp="^([A-Za-z\s]*)$" data-validation-error-msg="Hai inserito caratteri non validi!"/>
            </label>
        </p>
        <br>
        <p>
            <span style="text-transform: uppercase"><b>Campi obbligatori</b></span>
        </p>
        <p>
            <label>
                Nome Utente<br>
                <input type="text" name="nomeUtente" maxlength="16" data-validation="server" data-validation-url="validate/username.php" />
            </label>
        </p>
        <p>
            <label>
                Password<br>
                <input name="password" type="password" id="password" maxlength="18" data-validation="server" data-validation-url="validate/password.php"/>
            </label>
        </p>
        <p>
            <label>
                Conferma Password<br>
                <input name="confermaPassword" type="password" maxlength="18" data-validation="confirmation" data-validation-confirm="password" data-validation-error-msg="Le password non combaciano!"/>
            </label>
        </p>
        <p>
            <label>
                Inserisci il testo dell'immagine<br>
                <img id="captcha" src="libs/securimage/securimage_show.php" alt="CAPTCHA Image" /><br>
                <a href="#" onclick="document.getElementById('captcha').src = 'libs/securimage/securimage_show.php?' + Math.random(); return false">Genera un'altro codice</a><br>
                <input type="text" name="captcha_code" maxlength="6" /> <?php if (isset($_GET["captchaError"])) echo "<span class=\"help-block form-error\">Il codice che hai inserito è errato!</span>"; ?>
            </label>
        </p>
        <p>
            <label>
                <input type="checkbox" data-validation="required" data-validation-error-msg="Devi essere maggiorenne per iscriverti!">
                Dichiaro di essere maggiorenne
            </label>
        </p>
        <input type="submit" value="Registrati">
    </form>
</div>
</body>
<script>
    PasswordStrengthDisplay($("input[id=\"password\"]"), 18, null, "Potenza");

    $.validate({
        modules : 'security'
    });
</script>
</html>