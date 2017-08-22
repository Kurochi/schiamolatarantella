<?php
require_once "../libs/user.php";
require_once "../libs/session.php";
require_once "../libs/tarantella.php";

$_notifica = "";
if (Session::CheckSession() === SessionStatus::User)
{
    $_tarantelle = Tarantella::GetByDestinatario(Session::GetUserID(), false);
    $_numeroTarantelle = count($_tarantelle);
    $_notifica = $_numeroTarantelle > 0 ? " - <span style='font-weight: bold; color: lime'>$_numeroTarantelle</span>" : "";
}
?>

<ul id="profileBar">
    <li class="topBarButton"><a href="index.php">Pagina Principale</a></li>
    <li class="topBarButton"><a href="tarantellericevute.php">Tarantelle Ricevute<?= $_notifica ?></a></li>
    <li class="topBarButton"><a href="tarantelleschiate.php">Tarantelle Schiate</a></li>
</ul>