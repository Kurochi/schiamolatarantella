<ul id="topBar">
    <li class="topBarButton"><a href="/index.php">Home</a></li>
    <li class="topBarButton"><a href="/cherobae.php">Che roba è</a></li>
    <li class="topBarButton"><a href="/contattaci.php">Contattaci</a></li>
    <?php
    require_once "libs/session.php";
    require_once "libs/user.php";
    if (Session::CheckSession() === SessionStatus::User)
    {
        ?>
        <li class="topBarButton"><a href="/profilo/index.php">Il Mio Profilo</a></li>
        <li class="topBarButton"><a href="/logout.php">Esci</a></li>
        <?php
    }
    else
    {
        ?>
        <li class="topBarButton"><a href="/login.php">Accedi</a></li>
        <li class="topBarButton"><a href="/registrati.php">Registrati</a></li>
        <?php
    }
    ?>
</ul>