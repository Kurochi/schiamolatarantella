<?php
require_once "libs/session.php";
require_once "libs/ssl.php";
RequireSSL();

Session::Start();
Session::Kill();

header("Location: index.php");
die();