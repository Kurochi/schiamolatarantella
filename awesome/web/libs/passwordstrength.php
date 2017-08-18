<?php
function PasswordStrength($password)
{
    $matches = array();
    preg_match_all("/[a-z]+/", $password, $matches);
    $lowerCaseChars = 0;
    foreach ($matches[0] as $match)
    {
        $lowerCaseChars += strlen($match);
    }

    preg_match_all("/[A-Z]+/", $password, $matches);
    $upperCaseChars = 0;
    foreach ($matches[0] as $match)
    {
        $upperCaseChars += strlen($match);
    }

    preg_match_all("/\\d+/", $password, $matches);
    $numberChars = 0;
    foreach ($matches[0] as $match)
    {
        $numberChars += strlen($match);
    }

    preg_match_all("/\\W+/", $password, $matches);
    $nonWordChars = 0;
    foreach ($matches[0] as $match)
    {
        $nonWordChars += strlen($match);
    }

    $length = $lowerCaseChars + $upperCaseChars + $numberChars + $nonWordChars;
    $strength = $length;

    $charTypes = 0;
    $charTypes = ($lowerCaseChars > 0) ? ++$charTypes : $charTypes;
    $charTypes = ($upperCaseChars > 0) ? ++$charTypes : $charTypes;
    $charTypes = ($numberChars > 0) ? ++$charTypes : $charTypes;
    $charTypes = ($nonWordChars > 0) ? ++$charTypes : $charTypes;
    $strength += max($charTypes - 1, 0) * 3;

    return $strength;
}