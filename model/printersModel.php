<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/libs/Model.php';
class PrintersModel extends Model
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
        $sql = "INSERT INTO firma (firma_id, nazwa) VALUES (NULL, '$data');";
        mysqli_query($this->conn,$sql);
    }

    function addModel($companyId, $data)
    {
        $data = mysqli_real_escape_string($this->conn, $data);
        $sql = "INSERT INTO drukarka_model (drukarka_model_id, firma_id, model) VALUES (NULL, '$companyId', '$data');";
        mysqli_query($this->conn,$sql);
    }

    function addRoom($data)
    {
        $data = mysqli_real_escape_string($this->conn, $data);
        $sql = "INSERT INTO pokoj (pokoj_id, numer) VALUES (NULL, '$data');";
        mysqli_query($this->conn,$sql);
    }

    function addPrinter($pSelected, $rSelected, $invNumber, $bCode, $count, $adIp, $mac, $date, $serial)
    {
        $printersSelected = mysqli_escape_string($this->conn, $pSelected);
        $roomsSelected = mysqli_escape_string($this->conn, $rSelected);
        $inventoryNumber = mysqli_escape_string($this->conn, $invNumber);
        $barCode = mysqli_escape_string($this->conn, $bCode);
        $adressIp = mysqli_escape_string($this->conn, $adIp);
        $counter = mysqli_escape_string($this->conn, $count);
        $macCode = mysqli_escape_string($this->conn, $mac);
        $buyDate = mysqli_escape_string($this->conn, $date);
        $serialNumber = mysqli_escape_string($this->conn, $serial);
        if(empty($adressIp))
            $adressIp = NULL;
        if(empty($macCode))
            $macCode = NULL;
        $sql = "INSERT INTO drukarka (drukarka_id, numer_inwentarzowy, adres_ip, kod_kreskowy, mac, numer_seryjny, data_zakupu, drukarka_model_id, pokoj_id, stan_licznika) VALUES (NULL, '$inventoryNumber', '$adressIp', '$barCode', '$macCode', '$serialNumber', '$buyDate', '$printersSelected', '$roomsSelected', '$counter');";
        mysqli_query($this->conn,$sql);
    }

    function editPrinter($printerId, $pSelected, $rSelected, $invNumber, $bCode, $count, $adIp, $mac, $date, $serial)
    {
        $printersSelected = mysqli_escape_string($this->conn, $pSelected);
        $roomsSelected = mysqli_escape_string($this->conn, $rSelected);
        $inventoryNumber = mysqli_escape_string($this->conn, $invNumber);
        $barCode = mysqli_escape_string($this->conn, $bCode);
        $adressIp = mysqli_escape_string($this->conn, $adIp);
        $counter = mysqli_escape_string($this->conn, $count);
        $macCode = mysqli_escape_string($this->conn, $mac);
        $buyDate = mysqli_escape_string($this->conn, $date);
        $serialNumber = mysqli_escape_string($this->conn, $serial);

        if(empty($adressIp))
            $adressIp = NULL;
        
        $row = mysqli_fetch_array(mysqli_query($this->conn, "SELECT pokoj_id FROM drukarka WHERE drukarka_id = $printerId LIMIT 1;"));
        if($row['pokoj_id']!=$roomsSelected)
        {
            $time = date('Y-m-d H:i:s');
            $sql = "INSERT INTO archiwum_drukarka_pokoj (archiwum_drukarka_pokoj_id, drukarka_id, pokoj_id, `data`) VALUES (NULL, '$printerId', '$roomsSelected', '$time');";
            mysqli_query($this->conn,$sql);
        }
        $sql = "UPDATE drukarka SET numer_inwentarzowy = '$inventoryNumber', adres_ip = '$adressIp', kod_kreskowy = '$barCode', drukarka_model_id = '$printersSelected', pokoj_id = '$roomsSelected', stan_licznika = '$counter', mac = '$macCode', data_zakupu = '$buyDate', numer_seryjny = '$serialNumber' WHERE drukarka.drukarka_id = $printerId";
        mysqli_query($this->conn,$sql);
    }

    function deletePrinter($printerId)
    {
        $sql = "DELETE FROM drukarka WHERE drukarka.drukarka_id = $printerId";
        mysqli_query($this->conn,$sql);
    }

    function servicePrinter($printerId)
    {
        $sql = "UPDATE drukarka SET pokoj_id = '1' WHERE drukarka.drukarka_id = $printerId";
        mysqli_query($this->conn,$sql);
        $time = date('Y-m-d');
        $sql = "INSERT INTO archiwum_drukarka_pokoj (archiwum_drukarka_pokoj_id, drukarka_id, pokoj_id, `data`) VALUES (NULL, '$printerId', '1', '$time');";
        mysqli_query($this->conn,$sql);
    }

    function backServicePrinter($printerId)
    {
        $sql = "UPDATE drukarka SET pokoj_id = (SELECT adp.pokoj_id FROM (SELECT * FROM archiwum_drukarka_pokoj) AS adp WHERE adp.pokoj_id!=1 AND adp.drukarka_id = $printerId ORDER BY adp.`data` DESC LIMIT 1) WHERE drukarka.drukarka_id = $printerId;";
        mysqli_query($this->conn,$sql);
        $time = date('Y-m-d');
        $sql = "INSERT INTO archiwum_drukarka_pokoj (archiwum_drukarka_pokoj_id, drukarka_id, pokoj_id, `data`) VALUES (NULL, '$printerId', (SELECT drukarka.pokoj_id FROM drukarka WHERE drukarka_id = $printerId), '$time');";
        mysqli_query($this->conn,$sql);
    }

    function addPrinterToners($printerModelId, $selectedtonerId)
    {
        $sql = "INSERT INTO drukarka_toner (drukarka_toner_id, drukarka_model_id, toner_model_id) VALUES (NULL, '$printerModelId', '$selectedtonerId')";
        mysqli_query($this->conn,$sql);
    }

    function deletePrinterToners($printerModelId, $selectedtonerId)
    {
        $sql = "DELETE FROM drukarka_toner WHERE drukarka_toner.drukarka_model_id = $printerModelId AND drukarka_toner.toner_model_id = $selectedtonerId";
        mysqli_query($this->conn,$sql); 
    }

    function editPrinterModel($printerModelId, $companySelect, $printerModel)
    {
        $model = mysqli_escape_string($this->conn, $printerModel);
        $sql = "UPDATE drukarka_model SET firma_id = '$companySelect', model = '$model' WHERE drukarka_model.drukarka_model_id = $printerModelId";
        mysqli_query($this->conn,$sql);
    }

    function deletePrinterModel($printerModelId)
    {
        $sql = "DELETE FROM drukarka WHERE drukarka.drukarka_model_id = $printerModelId";
        mysqli_query($this->conn,$sql);
        $sql = "DELETE FROM drukarka_toner WHERE drukarka_toner.drukarka_model_id = $printerModelId";
        mysqli_query($this->conn,$sql);
        $sql = "DELETE FROM drukarka_model WHERE drukarka_model.drukarka_model_id = $printerModelId";
        mysqli_query($this->conn,$sql);
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

    function getPrintersModelsList()
    {
        $sql = "SELECT drukarka_model.drukarka_model_id, firma.nazwa, drukarka_model.model FROM drukarka_model INNER JOIN firma ON firma.firma_id = drukarka_model.firma_id;";
        $result = mysqli_query($this->conn,$sql);
        $rows = [];
        while($row = mysqli_fetch_array($result))
        {
            $rows[] = $row;
        }
        return $rows;
    }

    function getRoomsList()
    {
        $sql = "SELECT * FROM pokoj";
        $result = mysqli_query($this->conn,$sql);
        $rows = [];
        while($row = mysqli_fetch_array($result))
        {
            $rows[] = $row;
        }
        return $rows;
    }
    function getPrintersList()
    {
        $sql = "SELECT drukarka.drukarka_id, pokoj.numer, firma.nazwa, drukarka_model.model, drukarka.numer_inwentarzowy FROM drukarka INNER JOIN drukarka_model ON drukarka_model.drukarka_model_id = drukarka.drukarka_model_id INNER JOIN firma ON firma.firma_id = drukarka_model.firma_id INNER JOIN pokoj ON pokoj.pokoj_id = drukarka.pokoj_id ORDER BY pokoj.numer;";
        $result = mysqli_query($this->conn,$sql);
        $rows = [];
        while($row = mysqli_fetch_array($result))
        {
            $rows[] = $row;
        }
        return $rows;
    }

    function getServicePrintersList()
    {
        $sql = "SELECT drukarka.drukarka_id, pokoj.numer, firma.nazwa, drukarka_model.model, drukarka.numer_inwentarzowy FROM drukarka INNER JOIN drukarka_model ON drukarka_model.drukarka_model_id = drukarka.drukarka_model_id INNER JOIN firma ON firma.firma_id = drukarka_model.firma_id INNER JOIN pokoj ON pokoj.pokoj_id = (SELECT adp.pokoj_id FROM (SELECT * FROM archiwum_drukarka_pokoj) AS adp WHERE adp.pokoj_id!=1 AND adp.drukarka_id = drukarka.drukarka_id ORDER BY adp.`data` DESC LIMIT 1) WHERE drukarka.pokoj_id = 1 ORDER BY pokoj.numer;";
        $result = mysqli_query($this->conn,$sql);
        $rows = [];
        while($row = mysqli_fetch_array($result))
        {
            $rows[] = $row;
        }
        return $rows;
    }
    
    function getPrinterInfo($printerId)
    {
        $sql = "SELECT * FROM drukarka WHERE drukarka_id = $printerId;";
        $result = mysqli_query($this->conn,$sql);
        $rows = [];
        while($row = mysqli_fetch_array($result))
        {
            $rows[] = $row;
        }
        return $rows[0];
    }

    function getPrinterModelInfo($modelId)
    {
        $sql = "SELECT * FROM drukarka_model WHERE drukarka_model_id = $modelId;";
        $result = mysqli_query($this->conn,$sql);
        $rows = [];
        while($row = mysqli_fetch_array($result))
        {
            $rows[] = $row;
        }
        return $rows[0]; 
    }

    function getPrinterToners($printerModelId)
    {
        $sql = "SELECT firma.nazwa, toner_model.model, toner_kolor.kolor, toner_model.kod_kreskowy FROM drukarka_toner INNER JOIN toner_model ON toner_model.toner_model_id = drukarka_toner.toner_model_id INNER JOIN firma ON firma.firma_id = toner_model.firma_id INNER JOIN toner_kolor ON toner_kolor.toner_kolor_id = toner_model.toner_kolor_id WHERE drukarka_toner.drukarka_model_id = $printerModelId;";
        $result = mysqli_query($this->conn,$sql);
        $rows = [];
        while($row = mysqli_fetch_array($result))
        {
            $rows[] = $row;
        }
        return $rows;
    }

    function getTonersModelsList($selectedModel)
    {
        if($selectedModel!=-1)
            $sql = "SELECT toner_model.toner_model_id, firma.nazwa, toner_model.model, toner_kolor.kolor, toner_model.kod_kreskowy FROM toner_model INNER JOIN firma ON firma.firma_id = toner_model.firma_id INNER JOIN toner_kolor ON toner_kolor.toner_kolor_id = toner_model.toner_kolor_id WHERE toner_model.toner_model_id IN (SELECT dt.toner_model_id FROM (SELECT * FROM drukarka_toner) AS dt WHERE dt.drukarka_model_id = $selectedModel) ORDER BY firma.firma_id, toner_model.model;";
        else
            $sql = "SELECT toner_model.toner_model_id, firma.nazwa, toner_model.model, toner_kolor.kolor, toner_model.kod_kreskowy FROM toner_model INNER JOIN firma ON firma.firma_id = toner_model.firma_id INNER JOIN toner_kolor ON toner_kolor.toner_kolor_id = toner_model.toner_kolor_id ORDER BY firma.firma_id, toner_model.model;";
        $result = mysqli_query($this->conn,$sql);
        $rows = [];
        while($row = mysqli_fetch_array($result))
        {
            $rows[] = $row;
        }
        return $rows;
    }
}