<?php
require_once "libs/session.php";

Session::Start();
Session::Kill();

header("Location: index.php");
die();