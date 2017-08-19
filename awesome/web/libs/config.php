<?php
$debugMode = true;
$rootFolder = "";
$root = $_SERVER['DOCUMENT_ROOT'] . $rootFolder;
$rootURL = $_SERVER['SERVER_NAME'] . $rootFolder;
$indexPageName = "index.php";
$defaultAutomatedMessageEmailAddress = "noreply@{$_SERVER["SERVER_NAME"]}}";
$defaultAutomatedMessageEmailHeader =
    "MIME-Version: 1.0\r\n" .
    "Content-Type: text/html; charset=utf-8\r\n" .
    "From: $defaultAutomatedMessageEmailAddress\r\n" .
    "Reply-To: $defaultAutomatedMessageEmailAddress\r\n" .
    "X-Mailer: PHP/" . phpversion() . "\r\n";