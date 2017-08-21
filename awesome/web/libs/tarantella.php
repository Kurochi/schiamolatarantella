<?php
require_once "conn.php";

class Tarantella
{
    private $id;
    private $destinatario;
    private $mittente;
    private $corpo;
    private $anonimo;
    private $risposta;
    private $dataCreazione;

    /**
     * @param $id
     * @return Tarantella[]|Tarantella|bool|string
     */
    public static function GetByID($id)
    {
        global $conn;
        if (is_int($id))
        {
            $statement = $conn->prepare("SELECT * FROM slc_tarantelle WHERE ID = ?");
            $statement->bind_param("i", $id);
            if ($statement->execute())
            {
                $result = $statement->get_result();
                if ($result->num_rows > 0)
                {
                    $row = $result->fetch_assoc();
                    $tarantella = new Tarantella();
                    $tarantella->SetID($row["ID"]);
                    $tarantella->SetDestinatario($row["Destinatario"]);
                    $tarantella->SetMittente($row["Mittente"]);
                    $tarantella->SetCorpo($row["Corpo"]);
                    $tarantella->SetAnonimo($row["Anonimo"]);
                    $tarantella->SetRisposta($row["Risposta"]);
                    $tarantella->SetDataCreazione($row["DataCreazione"]);

                    return $tarantella;
                }
                return false;
            }
            else
            {
                return $statement->error;
            }
        }
        elseif (is_array($id))
        {
            $idCount = count($id);
            $argString = substr(str_repeat("?,", $idCount), 0, ($idCount * 2) - 1);
            $statement = $conn->prepare("SELECT * FROM slc_tarantelle WHERE ID IN(" . $argString . ")");

            $types = str_repeat("i", $idCount);
            BindParamsArray($statement, $types, $id);

            if ($statement->execute())
            {
                $result = $statement->get_result();
                if ($result->num_rows > 0)
                {
                    $returnArr = [];

                    while ($row = $result->fetch_assoc())
                    {
                        $tarantella = new Tarantella();
                        $tarantella->SetID($row["ID"]);
                        $tarantella->SetDestinatario($row["Destinatario"]);
                        $tarantella->SetMittente($row["Mittente"]);
                        $tarantella->SetCorpo($row["Corpo"]);
                        $tarantella->SetAnonimo($row["Anonimo"]);
                        $tarantella->SetRisposta($row["Risposta"]);
                        $tarantella->SetDataCreazione($row["DataCreazione"]);
                        $returnArr[] = $tarantella;
                    }

                    return $returnArr;
                }
                else
                {
                    return false;
                }
            }
            else
            {
                return $statement->error;
            }
        }
        return false;
    }

    /**
     * @param $id
     * @param null $bRisposte
     * @return Tarantella[]|bool|string
     */
    public static function GetByMittente($id, $bRisposte = null)
    {
        global $conn;
        $statement = $conn->prepare("SELECT * FROM slc_tarantelle WHERE Mittente = ?" . (is_bool($bRisposte) ? ($bRisposte ? " AND Risposta IS NOT NULL" : " AND Risposta IS NULL") : ""));
        $statement->bind_param("i", $id);
        if ($statement->execute())
        {
            $result = $statement->get_result();
            if ($result->num_rows > 0)
            {
                $returnArr = [];
                while ($row = $result->fetch_assoc())
                {
                    $tarantella = new Tarantella();
                    $tarantella->SetID($row["ID"]);
                    $tarantella->SetDestinatario($row["Destinatario"]);
                    $tarantella->SetMittente($row["Mittente"]);
                    $tarantella->SetCorpo($row["Corpo"]);
                    $tarantella->SetAnonimo($row["Anonimo"]);
                    $tarantella->SetRisposta($row["Risposta"]);
                    $tarantella->SetDataCreazione($row["DataCreazione"]);
                    $returnArr[] = $tarantella;
                }

                return $returnArr;
            }
            else
            {
                return [];
            }
        }
        else
        {
            return $statement->error;
        }
    }

    /**
     * @param $id
     * @param null $bRisposte
     * @return Tarantella[]|bool|string
     */
    public static function GetByDestinatario($id, $bRisposte = null)
    {
        global $conn;
        $statement = $conn->prepare("SELECT * FROM slc_tarantelle WHERE Destinatario = ?" . (is_bool($bRisposte) ? ($bRisposte ? " AND Risposta IS NOT NULL" : " AND Risposta IS NULL") : ""));
        $statement->bind_param("i", $id);
        if ($statement->execute())
        {
            $result = $statement->get_result();
            if ($result->num_rows > 0)
            {
                $returnArr = [];
                while ($row = $result->fetch_assoc())
                {
                    $tarantella = new Tarantella();
                    $tarantella->SetID($row["ID"]);
                    $tarantella->SetDestinatario($row["Destinatario"]);
                    $tarantella->SetMittente($row["Mittente"]);
                    $tarantella->SetCorpo($row["Corpo"]);
                    $tarantella->SetAnonimo($row["Anonimo"]);
                    $tarantella->SetRisposta($row["Risposta"]);
                    $tarantella->SetDataCreazione($row["DataCreazione"]);
                    $returnArr[] = $tarantella;
                }

                return $returnArr;
            }
            else
            {
                return [];
            }
        }
        else
        {
            return $statement->error;
        }
    }

    public static function GetAll()
    {
        global $conn;
        $statement = $conn->prepare("SELECT * FROM slc_tarantelle");
        if ($statement->execute())
        {
            $result = $statement->get_result();
            if ($result->num_rows > 0)
            {
                $returnArr = [];

                while ($row = $result->fetch_assoc())
                {
                    $tarantella = new Tarantella();
                    $tarantella->SetID($row["ID"]);
                    $tarantella->SetDestinatario($row["Destinatario"]);
                    $tarantella->SetMittente($row["Mittente"]);
                    $tarantella->SetCorpo($row["Corpo"]);
                    $tarantella->SetAnonimo($row["Anonimo"]);
                    $tarantella->SetRisposta($row["Risposta"]);
                    $tarantella->SetDataCreazione($row["DataCreazione"]);
                    $returnArr[] = $tarantella;
                }

                return $returnArr;
            }
            else
            {
                return [];
            }
        }
        else
        {
            return $statement->error;
        }
    }

    public function GetID()
    {
        return $this->id;
    }

    public function GetDestinatario()
    {
        return $this->destinatario;
    }
    public function GetMittente()
    {
        return $this->mittente;
    }
    public function GetCorpo()
    {
        return $this->corpo;
    }
    public function GetAnonimo()
    {
        return $this->anonimo;
    }
    public function GetRisposta()
    {
        return $this->risposta;
    }
    public function GetDataCreazione()
    {
        return $this->dataCreazione;
    }

    protected function SetID($newVal)
    {
        $this->id = $newVal;
    }
    public function SetDestinatario($newVal)
    {
        $this->destinatario = $newVal;
    }
    public function SetMittente($newVal)
    {
        $this->mittente = $newVal;
    }
    public function SetCorpo($newVal)
    {
        $this->corpo = $newVal;
    }
    public function SetAnonimo($newVal)
    {
        $this->anonimo = $newVal;
    }
    protected function SetRisposta($newVal)
    {
        $this->risposta = $newVal;
    }
    protected function SetDataCreazione($newVal)
    {
        $this->dataCreazione = $newVal;
    }

    public function Insert()
    {
        global $conn;
        $statement = $conn->prepare("INSERT INTO slc_tarantelle (Destinatario, Mittente, Corpo, Anonimo) VALUES(?, ?, ?, ?)");

        $destinatario = $this->GetDestinatario();
        $mittente = $this->GetMittente();
        $corpo = $this->GetCorpo();
        $anonimo = $this->GetAnonimo();

        $statement->bind_param("iisi", $destinatario, $mittente, $corpo, $anonimo);

        if ($statement->execute())
        {
            if ($statement->affected_rows > 0)
            {
                return $statement->insert_id;
            }
            return false;
        }
        else
        {
            return $statement->error;
        }
    }

    public function Rispondi($newVal)
    {
        global $conn;
        $this->risposta = $newVal;

        $id = $this->GetID();
        $statement = $conn->prepare("UPDATE slc_tarantelle SET Risposta=? WHERE ID=?");
        $statement->bind_param("si", $newVal, $id);

        if ($statement->execute())
        {
            return $statement->affected_rows > 0;
        }
        else
        {
            return $statement->error;
        }
    }
}