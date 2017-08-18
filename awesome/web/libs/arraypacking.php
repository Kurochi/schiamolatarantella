<?php
function IntArrayToBytes($arr)
{
    $str = "";
    for($i = 0; $i < count($arr); $i++)
    {
        $curInt = $arr[$i];
        $str .= chr(($curInt >> 24) & 0xFF) . chr(($curInt >> 16) & 0xFF) . chr(($curInt >> 8) & 0xFF) . chr($curInt & 0xFF);
    }
    return $str;
}

function BytesToIntArray($str)
{
    $arr = [];
    for($i = 0; $i < strlen($str); $i += 4)
    {
        $arr[] = (ord($str[$i])<<24) + (ord($str[$i + 1])<<16) + (ord($str[$i + 2])<<8) + ord($str[$i + 3]);
    }
    return $arr;
}