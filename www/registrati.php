<!doctype html>
<html>
<head>

</head>
<body>
<form>
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