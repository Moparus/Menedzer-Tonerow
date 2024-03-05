<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/libs/Model.php';
class PrintModel extends Model
{
    function __construct()
    {
        parent::__construct();
    }
    function __destruct()
    {
        parent::__destruct();
    }
    public function returnPrint1()
    {
        $sql = "SELECT querry1.dm AS modelDrukarki, querry1.iloscD AS iloscDrukarek, querry2.tm AS tonerModel, SUM(querry2.tilosc) AS tonerIlosc FROM (SELECT drukarka_model.drukarka_model_id AS dmId,drukarka_model.model AS dm, COUNT(drukarka.drukarka_id) AS iloscD FROM drukarka INNER JOIN drukarka_model ON drukarka.drukarka_model_id = drukarka_model.drukarka_model_id GROUP BY drukarka_model.drukarka_model_id) AS querry1, (SELECT drukarka_toner.drukarka_model_id AS dmId, toner_model.model AS tm, IF(toner.ilosc IS NULL, 0 , toner.ilosc) AS tilosc, drukarka_toner_id FROM drukarka_toner RIGHT JOIN toner_model ON toner_model.toner_model_id = drukarka_toner.toner_model_id LEFT JOIN toner ON toner.toner_model_id = toner_model.toner_model_id) AS querry2 WHERE querry1.dmId = querry2.dmId GROUP BY querry2.drukarka_toner_id ORDER BY querry1.iloscD DESC;";
        $result = mysqli_query($this->conn,$sql);
        $rows = [];
        while($row = mysqli_fetch_array($result))
        {
            $rows[] = $row;
        }
        return $rows;
    }
    public function returnPrint2()
    {
        $sql = "SELECT firma.nazwa, toner_model.model, IF(toner.ilosc IS NULL, 0 , toner.ilosc),  IF(toner_stan.stan IS NULL, 'Brak', toner_stan.stan) FROM toner_model LEFT JOIN toner ON toner.toner_model_id = toner_model.toner_model_id LEFT JOIN toner_stan ON toner_stan.toner_stan_id = toner.toner_stan_id LEFT JOIN firma ON toner_model.firma_id = firma.firma_id ORDER BY firma.firma_id, toner_model.model;";
        $result = mysqli_query($this->conn,$sql);
        $rows = [];
        while($row = mysqli_fetch_array($result))
        {
            $rows[] = $row;
        }
        return $rows;
    }
    public function returnPrint3()
    {
        $sql = "SELECT pokoj.numer, firma.nazwa, drukarka_model.model, drukarka.numer_inwentarzowy, drukarka.adres_ip FROM drukarka INNER JOIN pokoj ON drukarka.pokoj_id = pokoj.pokoj_id INNER JOIN drukarka_model ON drukarka_model.drukarka_model_id = drukarka.drukarka_model_id INNER JOIN firma ON drukarka_model.firma_id = firma.firma_id ORDER BY pokoj.numer, firma.firma_id, drukarka_model.model;";
        $result = mysqli_query($this->conn,$sql);
        $rows = [];
        while($row = mysqli_fetch_array($result))
        {
            $rows[] = $row;
        }
        return $rows;
    }
    public function returnPrint4()
    {
        $sql = "SELECT q1.model, q1.suma, q2.iloscDrukarek FROM (SELECT toner_model.toner_model_id AS id, toner_model.model AS model, SUM(IF(toner.ilosc IS NULL, 0, toner.ilosc)) AS suma FROM toner_model LEFT JOIN toner ON toner_model.toner_model_id = toner.toner_model_id GROUP BY toner_model.toner_model_id) AS q1 JOIN (SELECT drukarka_toner.toner_model_id AS id, drukarka_toner.drukarka_model_id AS modelId, COUNT(drukarka.drukarka_id) AS iloscDrukarek FROM drukarka_toner INNER JOIN drukarka ON drukarka.drukarka_model_id = drukarka_toner.drukarka_model_id GROUP BY drukarka_toner.toner_model_id) AS q2 INNER JOIN drukarka_model ON drukarka_model.drukarka_model_id = q2.modelId WHERE q1.id = q2.id ORDER BY q1.suma-q2.iloscDrukarek, q1.model;";
        $result = mysqli_query($this->conn,$sql);
        $rows = [];
        while($row = mysqli_fetch_array($result))
        {
            $rows[] = $row;
        }
        return $rows;
    }
}