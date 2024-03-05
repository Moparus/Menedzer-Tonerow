<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/libs/Model.php';
class ArchiveModel extends Model
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
        $sql = "SELECT pokoj.numer, firma.nazwa, drukarka_model.model, archiwum_toner.stan_licznika, toner_model.model, toner_stan.stan, archiwum_toner.data FROM archiwum_toner INNER JOIN toner_model ON archiwum_toner.toner_model_id = toner_model.toner_model_id INNER JOIN firma ON toner_model.firma_id = firma.firma_id INNER JOIN drukarka ON drukarka.drukarka_id = archiwum_toner.drukarka_id INNER JOIN pokoj ON drukarka.pokoj_id = pokoj.pokoj_id INNER JOIN drukarka_model ON drukarka.drukarka_model_id = drukarka_model.drukarka_model_id INNER JOIN toner_stan ON toner_stan.toner_stan_id = archiwum_toner.toner_stan_id  ORDER BY archiwum_toner.data DESC;";
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
        $sql = "SELECT pokoj.numer, drukarka_model.model, drukarka.numer_inwentarzowy, archiwum_drukarka_pokoj.data FROM archiwum_drukarka_pokoj INNER JOIN pokoj ON pokoj.pokoj_id = archiwum_drukarka_pokoj.pokoj_id INNER JOIN drukarka ON drukarka.drukarka_id = archiwum_drukarka_pokoj.drukarka_id INNER JOIN drukarka_model ON drukarka_model.drukarka_model_id = drukarka.drukarka_model_id ORDER BY archiwum_drukarka_pokoj.archiwum_drukarka_pokoj_id DESC, archiwum_drukarka_pokoj.data DESC;";
        $result = mysqli_query($this->conn,$sql);
        $rows = [];
        while($row = mysqli_fetch_array($result))
        {
            $rows[] = $row;
        }
        return $rows;
    }
}