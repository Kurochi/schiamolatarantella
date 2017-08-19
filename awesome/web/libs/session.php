<?php
require_once "enums/sessionstatus.php";
class Session
{
    const SessionExpireTime = 86400; // 24 Ore
    public static function Start()
    {
        if (session_status() == PHP_SESSION_NONE)
        {
            session_start();
        }
    }

    /**
     * @param $user User
     */
    public static function Init($user)
    {
        Session::Start();
        Session::SetUserID($user->GetID());
        Session::SetNomeUtente($user->GetNomeUtente());
        Session::SetNome($user->GetNome());
        Session::SetCognome($user->GetCognome());
        Session::UpdateLastActivity();
    }

    public static function End()
    {
        if (session_status() == PHP_SESSION_ACTIVE)
        {
            session_unset();
        }
    }

    public static function GetUserID()
    {
        return $_SESSION["UserID"] ?? null;
    }

    public static function GetNome()
    {
        return $_SESSION["Nome"] ?? null;
    }

    public static function GetCognome()
    {
        return $_SESSION["Cognome"] ?? null;
    }

    public static function GetNomeUtente()
    {
        return $_SESSION["NomeUtente"] ?? null;
    }

    public static function GetLastActivity()
    {
        return $_SESSION["LastActivity"] ?? null;
    }

    protected static function SetUserID($newVal)
    {
        $_SESSION["UserID"] = $newVal;
    }

    protected static function SetNome($newVal)
    {
        $_SESSION["Nome"] = $newVal;
    }

    protected static function SetCognome($newVal)
    {
        $_SESSION["Cognome"] = $newVal;
    }

    protected static function SetNomeUtente($newVal)
    {
        $_SESSION["NomeUtente"] = $newVal;
    }

    public static function UpdateLastActivity()
    {
        $_SESSION["LastActivity"] = time();
    }

    public static function GetUser()
    {
        return User::GetByID(Session::GetUserID());
    }

    public static function CheckSession()
    {
        Session::Start();

        if (Session::GetUserID() == null || Session::GetCognome() == null || Session::GetNomeUtente() == null || Session::GetNome() == null || Session::GetLastActivity() == null)
        {
            return SessionStatus::None;
        }
        else
        {
            if (time() > Session::GetLastActivity() + Session::SessionExpireTime)
            {
                return SessionStatus::Expired;
            }
            else
            {
                $user = Session::GetUser();
                if ($user instanceof User)
                {
                    Session::UpdateLastActivity();
                    return SessionStatus::User;
                }
                else
                {
                    return SessionStatus::Expired;
                }
            }
        }
    }
}