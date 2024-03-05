<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/libs/Model.php';
class MainModel extends Model
{
    function __construct()
    {
        parent::__construct();
    }
    function __destruct()
    {
        parent::__destruct();
    }
    public function returnToners()
    {
        $sql = "SELECT toner.toner_id, IF(dodatkowy_kod IS NULL, toner_model.kod_kreskowy, toner.dodatkowy_kod) AS kod FROM toner INNER JOIN toner_model ON toner_model.toner_model_id = toner.toner_model_id;";
        $result = mysqli_query($this->conn,$sql);
        $items = array();
        while($row = mysqli_fetch_array($result))
        {
            $items[$row['toner_id']] = $row['kod'];
        }
        return $items;
    }
    public function returnPrintersToners($room, $toners)
    {
        $sql = "SELECT drukarka.drukarka_id, firma.nazwa, drukarka_model.model, drukarka.numer_inwentarzowy, drukarka.adres_ip FROM drukarka INNER JOIN pokoj ON drukarka.pokoj_id = pokoj.pokoj_id INNER JOIN drukarka_model ON drukarka_model.drukarka_model_id = drukarka.drukarka_model_id INNER JOIN firma ON drukarka_model.firma_id = firma.firma_id WHERE drukarka.drukarka_model_id IN (SELECT q1.drukarka_model_id FROM (SELECT * FROM drukarka_toner) AS q1 WHERE q1.toner_model_id IN (SELECT toner.toner_model_id FROM toner INNER JOIN toner_model ON toner_model.toner_model_id = toner.toner_model_id WHERE IF(toner.dodatkowy_kod IS NULL, toner_model.kod_kreskowy, toner.dodatkowy_kod) IN ($toners))) AND drukarka.pokoj_id = $room;";
        $result = mysqli_query($this->conn,$sql);
        $rows = [];
        while($row = mysqli_fetch_array($result))
        {
            $rows[] = $row;
        }
        return $rows;
    }
    public function returnPrinters($room)
    {
        $sql = "SELECT drukarka.drukarka_id, firma.nazwa, drukarka_model.model, drukarka.numer_inwentarzowy, drukarka.adres_ip FROM drukarka INNER JOIN pokoj ON drukarka.pokoj_id = pokoj.pokoj_id INNER JOIN drukarka_model ON drukarka_model.drukarka_model_id = drukarka.drukarka_model_id INNER JOIN firma ON drukarka_model.firma_id = firma.firma_id WHERE drukarka.pokoj_id = $room;";
        $result = mysqli_query($this->conn,$sql);
        $rows = [];
        while($row = mysqli_fetch_array($result))
        {
            $rows[] = $row;
        }
        return $rows;
    }
    public function returnRooms()
    {
        $sql = "SELECT * FROM pokoj WHERE pokoj_id IN (SELECT pokoj_id FROM drukarka);";
        $result = mysqli_query($this->conn,$sql);
        $rows = [];
        while($row = mysqli_fetch_array($result))
        {
            $rows[] = $row;
        }
        return $rows;
    }
    public function returnActiveRooms($scannerText)
    {
        $sql = "SELECT pokoj_id FROM drukarka WHERE drukarka_model_id IN (SELECT drukarka_model_id FROM drukarka_toner WHERE toner_model_id IN (SELECT toner.toner_model_id FROM toner INNER JOIN toner_model ON toner_model.toner_model_id = toner.toner_model_id WHERE IF(toner.dodatkowy_kod IS NULL, toner_model.kod_kreskowy, toner.dodatkowy_kod) IN ($scannerText))) GROUP BY pokoj_id;";
        $result = mysqli_query($this->conn,$sql);
        $items = array();
        while($row = mysqli_fetch_array($result))
        {
            $items[$row['pokoj_id']] = $row['pokoj_id'];
        }
        return $items;
    }
    public function returnSelectedToners($scannerText)
    {
        $sql = "SELECT toner_model.model FROM toner INNER JOIN toner_model ON toner_model.toner_model_id = toner.toner_model_id WHERE IF(toner.dodatkowy_kod IS NULL, toner_model.kod_kreskowy, toner.dodatkowy_kod) IN ($scannerText);";
        $result = mysqli_query($this->conn,$sql);
        $rows = [];
        while($row = mysqli_fetch_array($result))
        {
            $rows[] = $row;
        }
        return $rows;
    }

    public function returnPrinterInfo($printerId)
    {
        $sql = "SELECT firma.nazwa, drukarka_model.model, numer_inwentarzowy, adres_ip, pokoj.numer FROM drukarka INNER JOIN drukarka_model ON drukarka_model.drukarka_model_id = drukarka.drukarka_model_id INNER JOIN firma ON firma.firma_id = drukarka_model.firma_id INNER JOIN pokoj ON pokoj.pokoj_id = drukarka.pokoj_id WHERE drukarka.drukarka_id = $printerId;";
        $result = mysqli_query($this->conn,$sql);
        $rows = [];
        while($row = mysqli_fetch_array($result))
        {
            $rows[] = $row;
        }
        return $rows[0];
    }

    public function returnPrinterToners($printerId)
    {
        $sql = "SELECT toner.toner_id, toner_model.model, toner_kolor.kolor, toner.ilosc, toner_stan.stan FROM drukarka_toner INNER JOIN toner_model ON toner_model.toner_model_id = drukarka_toner.toner_model_id INNER JOIN toner ON toner.toner_model_id = toner_model.toner_model_id INNER JOIN drukarka ON drukarka.drukarka_model_id = drukarka_toner.drukarka_model_id INNER JOIN toner_stan ON toner_stan.toner_stan_id = toner.toner_stan_id INNER JOIN toner_kolor ON toner_kolor.toner_kolor_id = toner_model.toner_kolor_id WHERE drukarka.drukarka_id = $printerId;";
        $result = mysqli_query($this->conn,$sql);
        $rows = [];
        while($row = mysqli_fetch_array($result))
        {
            $rows[] = $row;
        }
        return $rows;
    }

    public function returnPrinterTonersArchive($printerId)
    {
        $sql = "SELECT toner_model.model, toner_stan.stan, archiwum_toner.data FROM archiwum_toner INNER JOIN toner_model ON toner_model.toner_model_id = archiwum_toner.toner_model_id INNER JOIN toner_stan ON toner_stan.toner_stan_id = archiwum_toner.toner_stan_id WHERE archiwum_toner.drukarka_id = $printerId ORDER BY archiwum_toner.data DESC;";
        $result = mysqli_query($this->conn,$sql);
        $rows = [];
        while($row = mysqli_fetch_array($result))
        {
            $rows[] = $row;
        }
        return $rows;
    }
    public function returnCounterState($printerId)
    {
        $sql = "SELECT stan_licznika FROM drukarka WHERE drukarka_id = $printerId;";
        $result = mysqli_query($this->conn,$sql);
        $rows = [];
        while($row = mysqli_fetch_array($result))
        {
            $rows[] = $row;
        }
        return $rows[0];
    }

    public function setPrinterToner($tonerId, $printerId, $counter)
    {
        $time = date('Y-m-d H:i:s');
        $sql = "INSERT INTO archiwum_toner (archiwum_toner_id, toner_model_id, toner_stan_id, drukarka_id, stan_licznika, `data`) VALUES (NULL, (SELECT toner_model_id FROM toner WHERE toner.toner_id = '$tonerId'), (SELECT toner.toner_stan_id FROM toner WHERE toner.toner_id = '$tonerId'), '$printerId', '$counter', '$time');";
        mysqli_query($this->conn,$sql);
        $sql = "UPDATE toner SET ilosc = (SELECT ton.ilosc-1 FROM (SELECT * FROM toner) AS ton WHERE ton.toner_id = '$tonerId') WHERE toner.toner_id = '$tonerId';";
        mysqli_query($this->conn,$sql);
        $sql = "UPDATE drukarka SET stan_licznika = '$counter' WHERE drukarka.drukarka_id = '$printerId';";
        mysqli_query($this->conn,$sql);
        $result = mysqli_query($this->conn,"SELECT ilosc FROM toner WHERE toner_id = $tonerId;");
        $row = mysqli_fetch_assoc($result);
        if($row['ilosc']==0)
        {
            $sql = "DELETE FROM toner WHERE toner.toner_id = $tonerId;";
            mysqli_query($this->conn,$sql);
        }    
    }
}