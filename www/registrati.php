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
<form> <!-- Da fare: Impostare attributi, aggiungere validazione degli input -->
    <p>
        <label>
            Nome Utente
            <input name="nomeUtente" maxlength="16" />
        </label>
    </p>
    <p>
        <label>
            Password
            <input name="password" id="password" maxlength="18" />
        </label>
    </p>
    <p>
        <label>
            Conferma Password
            <input name="confermaPassword" maxlength="18" />
        </label>
    </p>
    <p>
        <label>
            Inserisci il testo dell'immagine
            <input name="captcha_code" size="10" maxlength="6" /><br>
            <img id="captcha" src="libs/securimage/securimage_show.php" alt="CAPTCHA Image" /><br>
            <a href="#" onclick="document.getElementById('captcha').src = 'libs/securimage/securimage_show.php?' + Math.random(); return false">Genera un'altro codice</a>
        </label>
    </p>
</form>
</body>
<script>
    PasswordStrengthDisplay($("input[id=\"password\"]"), 18, null, "Potenza");
</script>
</html>