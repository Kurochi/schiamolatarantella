<!doctype html>
<html>
<head>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
    <script src="js/passwordstrengthdisplay.js"></script>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<style>
    .password_strength_display
    {
        display: inline-block;
        margin-left: 10px;
        transition: 1s;
    }

    .password_strength_display.p0
    {
        background: #ff7f7f;
    }

    .password_strength_display.p25
    {
        background: #ff7f7f;
    }
    .password_strength_display.p50
    {
        background: #ff7f7f;
    }

    .password_strength_display.p75
    {
        background: #ff7f7f;
    }

    .password_strength_display.p100
    {
        color: white;
        background: green;
    }
</style>
<body>
<?php include "header.php" ?>
<div id="bodyContainer">
    <form> <!-- Da fare: Impostare attributi, aggiungere validazione degli input -->
        <p>
            <label>
                Nome Utente<br>
                <input name="nomeUtente" maxlength="16" data-validation="server" data-validation-url="validate/username.php" />
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
                <input name="confermaPassword" type="password" maxlength="18" data-validation="confirmation" data-validation-confirm="password" />
            </label>
        </p>
        <p>
            <label>
                Inserisci il testo dell'immagine<br>
                <img id="captcha" src="libs/securimage/securimage_show.php" alt="CAPTCHA Image" /><br>
                <a href="#" onclick="document.getElementById('captcha').src = 'libs/securimage/securimage_show.php?' + Math.random(); return false">Genera un'altro codice</a><br>
                <input name="captcha_code" size="10" maxlength="6" /><br>
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