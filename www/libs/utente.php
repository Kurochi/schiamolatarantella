<?php
require_once "conn.php";
class User
{
    private $username;
    private $tarantelleSubite;
    private $tarantelleIniziate;

    public static function Get($id)
    {
        global $conn;
        $statement = $conn->prepare("SELECT * FROM slc_utenti WHERE ID = ?");
    }

    public static function Register($username, $password)
    {
        global $conn;
        global $conn;
        $statement = $conn->prepare("SELECT * FROM slc_utenti WHERE NomeUtente = ?");
        if (!$statement->execute())
        {
            return $statement->error;
        }
        else
        {
            
        }
    }

    public static function Login($username, $password)
    {
        global $conn;

    }
}