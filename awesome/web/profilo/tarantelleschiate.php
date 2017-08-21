<?php
require_once "../libs/user.php";
require_once "../libs/session.php";
$session = Session::CheckSession();
if ($session != SessionStatus::User)
{
    header("Location: ../login.php");
    die();
}
?>
<!doctype html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
<?php include "../header.php" ?>
<?php include "barra_profilo.php" ?>
<div id="bodyContainer">
    <h1>Il mio profilo</h1>
</div>
</body>
</html>