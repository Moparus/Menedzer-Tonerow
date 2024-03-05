<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/libs/Model.php';
class StockModel extends Model
{
    function __construct()
    {
        parent::__construct();
    }
    function __destruct()
    {
        parent::__destruct();
    }

    function getTonerIds()
    {
        $sql = 'SELECT toner_id FROM toner;';
        $result = mysqli_query($this->conn,$sql);
        $rows = [];
        while($row = mysqli_fetch_array($result))
        {
            $rows[] = $row;
        }
        return $rows;
    }

    function getAllStockList()
    {
        $sql = 'SELECT f.nazwa,tmod.model,st.stan,ton.ilosc,inv.ilosc FROM inwentaryzacja AS inv INNER JOIN toner AS ton ON ton.toner_id = inv.toner_id INNER JOIN toner_model AS tmod ON tmod.toner_model_id = ton.toner_model_id INNER JOIN firma AS f ON f.firma_id = tmod.firma_id INNER JOIN toner_stan AS st ON st.toner_stan_id = ton.toner_stan_id  WHERE ton.ilosc NOT LIKE inv.ilosc ORDER BY f.firma_id, tmod.toner_model_id;';
        $result = mysqli_query($this->conn,$sql);
        $rows = [];
        while($row = mysqli_fetch_array($result))
        {
            $rows[] = $row;
        }
        return $rows;
    }

    function getScannedStockList()
    {
        $sql = 'SELECT f.nazwa,tmod.model,st.stan,ton.ilosc,inv.ilosc FROM inwentaryzacja AS inv INNER JOIN toner AS ton ON ton.toner_id = inv.toner_id INNER JOIN toner_model AS tmod ON tmod.toner_model_id = ton.toner_model_id INNER JOIN firma AS f ON f.firma_id = tmod.firma_id INNER JOIN toner_stan AS st ON st.toner_stan_id = ton.toner_stan_id WHERE ton.ilosc LIKE inv.ilosc ORDER BY f.firma_id, tmod.toner_model_id;';
        $result = mysqli_query($this->conn,$sql);
        $rows = [];
        while($row = mysqli_fetch_array($result))
        {
            $rows[] = $row;
        }
        return $rows;
    }

    function getTonerIdFromBarCode1($barCode)
    {
        $sql = "SELECT toner_id FROM toner INNER JOIN toner_model ON toner_model.toner_model_id = toner.toner_model_id WHERE toner_model.kod_kreskowy = '$barCode' AND toner.toner_stan_id = 1 LIMIT 1;";
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

    function getTonerIdFromBarCode2($barCode)
    {
        $sql = "SELECT toner_id FROM toner INNER JOIN toner_model ON toner_model.toner_model_id = toner.toner_model_id WHERE toner.dodatkowy_kod = '$barCode' LIMIT 1;";
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

    function addStockToner($tonerId)
    {
        $sql = "UPDATE `inwentaryzacja` SET `ilosc` = (SELECT inv.ilosc+1 FROM (SELECT * FROM inwentaryzacja) AS inv WHERE inv.toner_id = '$tonerId') WHERE `inwentaryzacja`.`toner_id` = '$tonerId';";
        mysqli_query($this->conn,$sql);
    }

    function startStockTaking()
    {
        $tonersIds = $this->getTonerIds();
        for($i=0; $i<sizeof($tonersIds); $i++)
        {
            $id = $tonersIds[$i][0];
            $sql = "INSERT INTO `inwentaryzacja` (`inwentaryzacja_id`, `toner_id`, `ilosc`) VALUES (NULL, '$id', '0');";
            mysqli_query($this->conn,$sql);
        }
    }

    function stopStockTaking()
    {
        $sql = "DELETE FROM m1475_tonery.inwentaryzacja;";
        mysqli_query($this->conn,$sql);
        $sql = "ALTER TABLE m1475_tonery.inwentaryzacja AUTO_INCREMENT=1;";
        mysqli_query($this->conn,$sql);
    }
}