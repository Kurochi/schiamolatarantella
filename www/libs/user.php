<?php
require_once "conn.php";
require_once "arraypacking.php";
require_once "enums/loginresult.php";
require_once "enums/registerresult.php";

class User
{
    private $id;
    private $nome;
    private $cognome;
    private $nomeUtente;
    private $tarantelleSubite;
    private $tarantelleSchiate;

    public static function GetByUsername($username)
    {
        global $conn;
        $statement = $conn->prepare("SELECT * FROM slc_utenti WHERE NomeUtente = ?");
        $statement->bind_param("s", $username);
        if (!$statement->execute())
        {
            return $statement->error;
        }

        if (($result = $statement->get_result())->num_rows > 0)
        {
            $row = $result->fetch_assoc();
            $user = new User();
            $user->SetID($row["ID"]);
            $user->SetNome($row["Nome"]);
            $user->SetCognome($row["Cognome"]);
            $user->SetNomeUtente($row["Username"]);
            $user->SetTarantelleSchiate($row["TarantelleSchiate"]);
            $user->SetTarantelleSubite($row["TarantelleSubite"]);
            return $user;
        }
        else
        {
            return false;
        }
    }

    public static function GetByID($id)
    {
        global $conn;
        $statement = $conn->prepare("SELECT * FROM slc_utenti WHERE ID = ?");
        $statement->bind_param("i", $id);
        if (!$statement->execute())
        {
            return $statement->error;
        }

        if (($result = $statement->get_result())->num_rows > 0)
        {
            $row = $result->fetch_assoc();
            $user = new User();
            $user->SetID($row["ID"]);
            $user->SetNome($row["Nome"]);
            $user->SetCognome($row["Cognome"]);
            $user->SetNomeUtente($row["Username"]);
            $user->SetTarantelleSchiate($row["TarantelleSchiate"]);
            $user->SetTarantelleSubite($row["TarantelleSubite"]);
            return $user;
        }
        else
        {
            return false;
        }
    }

    public static function GetAll()
    {
        global $conn;
        $statement = $conn->prepare("SELECT * FROM slc_utenti");
        if (!$statement->execute())
        {
            return $statement->error;
        }

        $usrArr = [];
        $result = $statement->get_result();
        while ($row = $result->fetch_assoc())
        {
            $user = new User();
            $user->SetID($row["ID"]);
            $user->SetNome($row["Nome"]);
            $user->SetCognome($row["Cognome"]);
            $user->SetNomeUtente($row["Username"]);
            $user->SetTarantelleSchiate($row["TarantelleSchiate"]);
            $user->SetTarantelleSubite($row["TarantelleSubite"]);
            $usrArr[] = $user;
        }
        return $usrArr;
    }

    public static function Register($username, $password, $nome = "", $cognome = "")
    {
        global $conn;
        $statement = $conn->prepare("SELECT * FROM slc_utenti WHERE NomeUtente = ?");
        $statement->bind_param("s", $username);
        if ($statement->execute())
        {
            if ($statement->get_result()->num_rows > 0)
            {
                return RegisterResult::UsernameTaken;
            }
        }
        else
        {
            return $statement->error;
        }

        $password = password_hash($password, PASSWORD_BCRYPT);
        $statement = $conn->prepare("INSERT INTO slc_utenti (Nome, Cognome, NomeUtente, Password) VALUES (?, ?, ?, ?)");
        $statement->bind_param("ssss", $nome, $cognome, $username, $password);
        if (!$statement->execute())
        {
            return $statement->error;
        }
        else
        {
            $user = new User();
            $user->SetID($statement->insert_id);
            $user->SetNome($nome);
            $user->SetCognome($cognome);
            $user->SetNomeUtente($username);
            $user->SetTarantelleSchiate("");
            $user->SetTarantelleSubite("");
            return $user;
        }
    }

    public static function Login($username, $password)
    {
        global $conn;
        $statement = $conn->prepare("SELECT * FROM slc_utenti WHERE NomeUtente = ?");
        $statement->bind_param("s", $username);
        if (!$statement->execute())
        {
            return $statement->error;
        }
        else
        {
            if (($result = $statement->get_result())->num_rows > 0)
            {
                $row = $result->fetch_assoc();
                if (password_verify($row["Password"], $password))
                {
                    $user = new User();
                    $user->SetID($row["ID"]);
                    $user->SetNome($row["Nome"]);
                    $user->SetCognome($row["Cognome"]);
                    $user->SetNomeUtente($row["Username"]);
                    $user->SetTarantelleSchiate($row["TarantelleSchiate"]);
                    $user->SetTarantelleSubite($row["TarantelleSubite"]);
                    return $user;
                }
                else
                {
                    return LoginResult::WrongLogin;
                }
            }
            else
            {
                return LoginResult::NoUser;
            }
        }
    }

    public function GetID()
    {
        return $this->id;
    }

    public function GetNome()
    {
        return $this->nome;
    }

    public function GetCognome()
    {
        return $this->cognome;
    }

    public function GetNomeUtente()
    {
        return $this->nomeUtente;
    }

    public function GetTarantelleSubite()
    {
        return $this->tarantelleSubite;
    }

    public function GetTarantelleSchiate()
    {
        return $this->tarantelleSchiate;
    }

    protected function SetID($newVal)
    {
        $this->id = $newVal;
    }

    public function SetNome($newVal)
    {
        $this->nome = $newVal;
    }

    public function SetCognome($newVal)
    {
        $this->cognome = $newVal;
    }

    public function SetNomeUtente($newVal)
    {
        $this->nomeUtente = $newVal;
    }

    public function ChangePassword($newPassword)
    {
        global $conn;
        $statement = $conn->prepare("UPDATE slc_utenti SET Password=? WHERE ID=?");
        $newPassword = password_hash($newPassword, PASSWORD_BCRYPT);
        $statement->bind_param("si", $newPassword, $username);
        if ($statement->execute())
        {
            return $statement->affected_rows > 0;
        }
        else
        {
            return $statement->error;
        }
    }

    protected function SetTarantelleSubite($newVal)
    {
        $this->tarantelleSubite = $newVal;
    }

    protected function SetTarantelleSchiate($newVal)
    {
        $this->tarantelleSchiate = $newVal;
    }
}