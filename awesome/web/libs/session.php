<?php
require_once "enums/sessionstatus.php";
class Session
{
    const SessionExpireTime = 86400; // 24 Ore

    /**
     * @var User $User
     */
    static $User;

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
        Session::SetUniqID($user->GetUniqID());
        Session::SetNomeUtente($user->GetNomeUtente());
        Session::SetNome($user->GetNome());
        Session::SetCognome($user->GetCognome());
        Session::UpdateLastActivity();
    }

    /**
     * @param $user User
     */
    public static function Update($user)
    {
        Session::SetNomeUtente($user->GetNomeUtente());
        Session::SetNome($user->GetNome());
        Session::SetCognome($user->GetCognome());
        Session::UpdateLastActivity();
    }

    public static function Kill()
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

    public static function GetUniqID()
    {
        return $_SESSION["UniqID"] ?? null;
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

    protected static function SetUniqID($newVal)
    {
        $_SESSION["UniqID"] = $newVal;
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

    protected static function GetUserFromDatabase()
    {
        return User::GetByID(Session::GetUserID());
    }

    public static function GetUser()
    {
        return Session::$User;
    }

    public static function CheckSession()
    {
        Session::Start();

        if (Session::GetUniqID() == null || Session::GetUserID() == null || Session::GetCognome() == null || Session::GetNomeUtente() == null || Session::GetNome() == null || Session::GetLastActivity() == null)
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
                Session::$User = Session::GetUserFromDatabase();
                if (Session::$User instanceof User)
                {
                    Session::Update(Session::$User);
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