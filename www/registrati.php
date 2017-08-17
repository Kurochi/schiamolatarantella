<!doctype html>
<html>
<head>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
</head>
<body>
<form> <!-- Da fare: Impostare attributi, aggiungere validazione degli input -->
    <p>
        <label>
            Nome Utente
            <input name="captcha_code" size="10" maxlength="6" />
        </label>
    </p>
    <p>
        <label>
            Password
            <input name="captcha_code" size="10" maxlength="6" />
        </label>
    </p>
    <p>
        <label>
            Conferma Password
            <input name="captcha_code" size="10" maxlength="6" />
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
</html>