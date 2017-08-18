<?php
class Session
{
    const SessionExpireTime = 86400; // 24 Ore
    static $UserID;
    static $Nome;
    static $Cognome;
    static $NomeUtente;
    static $LastActivity;

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
        return Session::$UserID;
    }

    public static function GetNome()
    {
        return Session::$Nome;
    }

    public static function GetCognome()
    {
        return Session::$Cognome;
    }

    public static function GetNomeUtente()
    {
        return Session::$NomeUtente;
    }

    public static function GetLastActivity()
    {
        return Session::$LastActivity;
    }

    protected static function SetUserID($newVal)
    {
        Session::$UserID = $newVal;
    }

    protected static function SetNome($newVal)
    {
        Session::$Nome = $newVal;
    }

    protected static function SetCognome($newVal)
    {
        Session::$Cognome = $newVal;
    }

    protected static function SetNomeUtente($newVal)
    {
        Session::$NomeUtente = $newVal;
    }

    public static function UpdateLastActivity()
    {
        Session::$LastActivity = time();
    }

    public static function GetUser()
    {
        return User::GetByID(Session::GetUserID());
    }

    public static function CheckSession()
    {
        if (Session::GetUserID() == null || Session::GetCognome() == null || Session::GetNomeUtente() == null || Session::GetNome() == null || Session::GetLastActivity() == null)
        {
            Session::End();
            return SessionStatus::None;
        }
        else
        {
            if (time() > Session::GetLastActivity() + Session::SessionExpireTime)
            {
                Session::End();
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
                    Session::End();
                    return SessionStatus::Expired;
                }
            }
        }
    }
}