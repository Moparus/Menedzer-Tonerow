<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/libs/Model.php';
class TonerModel extends Model
{
    function __construct()
    {
        parent::__construct();
    }
    function __destruct()
    {
        parent::__destruct();
    }
    function addCompany($data)
    {
        $data = mysqli_real_escape_string($this->conn, $data);
        $this->conn->execute_query('INSERT INTO firma (firma_id, nazwa) VALUES (NULL, ?)', [$data]);
    }
    function addToner($tonerModelSelect, $tonerAmount, $tonerStateSelect, $tonerBarCode)
    {
        $tonerModel = mysqli_escape_string($this->conn, $tonerModelSelect);
        $amount = mysqli_escape_string($this->conn, $tonerAmount);
        $state = mysqli_escape_string($this->conn, $tonerStateSelect);
        $barCode = mysqli_escape_string($this->conn, $tonerBarCode);
        $sql = '';
        if(empty($barCode))
        {
            $barCode = NULL;
            $sql = "SELECT COUNT(*) AS ilosc FROM toner WHERE toner_model_id = '$tonerModel' AND toner_stan_id = '$state';";
        }
        else
        {
            $sql = "SELECT COUNT(*) AS ilosc FROM toner WHERE toner_model_id = '$tonerModel' AND toner_stan_id = '$state' AND dodatkowy_kod = '$barCode';";
        }
        //Liczy takie same tonery
        $result = mysqli_query($this->conn,$sql);
        $rows = [];
        while($row = mysqli_fetch_array($result))
        {
            $rows[] = $row;
        }
        //Sprawdza czy już istnieje taki toner
        if($rows[0]['ilosc'] == 0)
        { 
            $sql1 = "INSERT INTO toner (toner_id, toner_model_id, ilosc, toner_stan_id, dodatkowy_kod) VALUES (NULL, '$tonerModel', '$amount', '$state', '$barCode');";
            mysqli_query($this->conn,$sql1);
        }
        else
        {
            $sql1 = "";
            if(empty($barCode))
                $sql1 = "UPDATE toner SET ilosc = ((SELECT ton.ilosc FROM (SELECT * FROM toner) AS ton WHERE ton.toner_model_id = $tonerModel AND ton.toner_stan_id = $state) + $amount) WHERE toner.toner_model_id = $tonerModel AND toner.toner_stan_id = $state;";
            else
                $sql1 = "UPDATE toner SET ilosc = ((SELECT ton.ilosc FROM (SELECT * FROM toner) AS ton WHERE ton.toner_model_id = $tonerModel AND ton.toner_stan_id = $state AND ton.dodatkowy_kod = '$barCode') + $amount) WHERE toner.toner_model_id = $tonerModel AND toner.toner_stan_id = $state AND toner.dodatkowy_kod = '$barCode';";
            mysqli_query($this->conn,$sql1);
        }
    }

    function addTonerModel($companySelect, $modelName, $barCode, $colourSelect)
    {
        $company = mysqli_escape_string($this->conn, $companySelect);
        $model = strtoupper(mysqli_escape_string($this->conn, $modelName));
        $code = mysqli_escape_string($this->conn, $barCode);
        $colour = mysqli_escape_string($this->conn, $colourSelect);
        
        $sql = "SELECT COUNT(*) AS ilosc FROM toner_model WHERE firma_id = '$company' AND model = '$model';";
        $result = mysqli_query($this->conn,$sql);
        $rows = [];
        while($row = mysqli_fetch_array($result))
        {
            $rows[] = $row;
        }
        //Sprawdza czy już istnieje taki toner
        if($rows[0]['ilosc'] == 0) { 
            $sql = "INSERT INTO toner_model (toner_model_id, firma_id, model, toner_kolor_id, kod_kreskowy) VALUES (NULL, '$company', '$model', '$colour', '$code')";
            mysqli_query($this->conn,$sql);
            echo('<div class="alert alert-success alert-dismissible fade show m-2 text-center border" role="alert"><strong>Powodzenie:</strong> Toner został dodany.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        }
        else {
            echo('<div class="alert alert-warning alert-dismissible fade show m-2 text-center border" role="alert"><strong>Anulowano:</strong> Już istnieje taki toner.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        }
    }

    function editToner($tonerId, $tonerAmount, $tonerState, $barCode = 0)
    {
        $amount = mysqli_escape_string($this->conn, $tonerAmount);
        $state = strtoupper(mysqli_escape_string($this->conn, $tonerState));
        $code = mysqli_escape_string($this->conn, $barCode);
        $sql = "";
        if($code == 0)
            $sql = "UPDATE toner SET ilosc = '$amount', toner_stan_id = '$state' WHERE toner.toner_id = $tonerId";
        else
            $sql = "UPDATE toner SET ilosc = '$amount', toner_stan_id = '$state', dodatkowy_kod = '$code' WHERE toner.toner_id = $tonerId";
        mysqli_query($this->conn,$sql);
    }

    function deleteToner($tonerId)
    {
        $sql = "DELETE FROM toner WHERE toner.toner_id = $tonerId;";
        mysqli_query($this->conn,$sql);
        echo('<div class="alert alert-info alert-dismissible fade show m-2 text-center border" role="alert"><strong>Usunięto</strong> Toner.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }
    function editTonerModel($tonerId, $companySelect, $tonerModel, $tonerColour ,$barCode)
    {
        $model = mysqli_escape_string($this->conn, $tonerModel);
        $code = strtoupper(mysqli_escape_string($this->conn, $barCode));
        $sql = "UPDATE toner_model SET firma_id = '$companySelect', model = '$model', toner_kolor_id = '$tonerColour', kod_kreskowy = '$code' WHERE toner_model.toner_model_id = $tonerId";
        mysqli_query($this->conn,$sql);
    }
    function deleteTonerModel($tonerId)
    {
        $sql = "DELETE FROM toner WHERE toner.toner_model_id = $tonerId;";
        mysqli_query($this->conn,$sql);
        $sql = "DELETE FROM toner_model WHERE toner_model.toner_model_id = $tonerId;";
        mysqli_query($this->conn,$sql);
        echo('<div class="alert alert-info alert-dismissible fade show m-2 text-center border" role="alert"><strong>Usunięto</strong> Model Tonera.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    public function getTonersModelsList()
    {
        $sql = "SELECT toner_model.toner_model_id, firma.nazwa, toner_model.model, toner_kolor.kolor FROM toner_model INNER JOIN firma ON firma.firma_id = toner_model.firma_id INNER JOIN toner_kolor ON toner_kolor.toner_kolor_id = toner_model.toner_kolor_id ORDER BY firma.firma_id, toner_model.model;";
        $result = mysqli_query($this->conn,$sql);
        $rows = [];
        while($row = mysqli_fetch_array($result))
        {
            $rows[] = $row;
        }
        return $rows;
    }

    public function getTonerStateList()
    {
        $sql = "SELECT * FROM toner_stan";
        $result = mysqli_query($this->conn,$sql);
        $rows = [];
        while($row = mysqli_fetch_array($result))
        {
            $rows[] = $row;
        }
        return $rows;
    }

    function getCompanyList()
    {
        $sql = "SELECT * FROM firma;";
        $result = mysqli_query($this->conn,$sql);
        $rows = [];
        while($row = mysqli_fetch_array($result))
        {
            $rows[] = $row;
        }
        return $rows;
    }

    function getColourList()
    {
        $sql = "SELECT * FROM toner_kolor;";
        $result = mysqli_query($this->conn,$sql);
        $rows = [];
        while($row = mysqli_fetch_array($result))
        {
            $rows[] = $row;
        }
        return $rows;
    }

    function getTonersList()
    {
        $sql = "SELECT toner.toner_id, firma.nazwa, toner_model.model, toner.ilosc, toner_stan.stan, IF(toner.dodatkowy_kod IS NULL, toner_model.kod_kreskowy, toner.dodatkowy_kod) AS kod FROM toner INNER JOIN toner_model ON toner_model.toner_model_id = toner.toner_model_id INNER JOIN toner_stan ON toner_stan.toner_stan_id = toner.toner_stan_id INNER JOIN firma ON firma.firma_id = toner_model.firma_id ORDER BY toner_model.firma_id, toner_model.model;";
        $result = mysqli_query($this->conn,$sql);
        $rows = [];
        while($row = mysqli_fetch_array($result))
        {
            $rows[] = $row;
        }
        return $rows;
    }

    function getTonerInfo($tonerId)
    {
        $sql = "SELECT * FROM toner WHERE toner_id = $tonerId;";
        $result = mysqli_query($this->conn,$sql);
        $rows = [];
        while($row = mysqli_fetch_array($result))
        {
            $rows[] = $row;
        }
        return $rows[0];
    }

    function getTonerModelInfo($modelId)
    {
        $sql = "SELECT * FROM toner_model WHERE toner_model_id = $modelId;";
        $result = mysqli_query($this->conn,$sql);
        $rows = [];
        while($row = mysqli_fetch_array($result))
        {
            $rows[] = $row;
        }
        return $rows[0];
    }

    function getTonerModelInfoFromCode($barCode)
    {
        $sql = "SELECT toner_model_id, firma_id, model FROM toner_model WHERE kod_kreskowy = '$barCode' LIMIT 1;";
        $result = mysqli_query($this->conn,$sql);
        $rows = [];
        while($row = mysqli_fetch_array($result))
        {
            $rows[] = $row;
        }
        if(!empty($rows))
            return $rows[0];
        else
            return null;
    }
}