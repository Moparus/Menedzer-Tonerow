<?php
    include_once $_SERVER['DOCUMENT_ROOT'].("/model/stockModel.php");
    $StockModel = new StockModel();

    if(isset($_POST['stockButton'])) {
        switch($_POST['stockButton']) {
            case "start":
                $StockModel -> stopStockTaking();
                $StockModel -> startStockTaking();
                break;
            case "stop":
                $StockModel -> stopStockTaking();
                break;
        }
    }

    function generateStockList()
    {
        $StockModel = new StockModel();
        $StockList = $StockModel -> getAllStockList();
        $headers = array("Nazwa","Model","Stan","Oczekiwana","Aktualna");
        generateTable($headers, $StockList);
    }

    function generateScannedStockList()
    {
        $StockModel = new StockModel();
        $StockList = $StockModel -> getScannedStockList();
        $headers = array("Nazwa","Model","Stan","Oczekiwana","Aktualna");
        generateTable($headers, $StockList);
    }

    function generate(){
        $StockModel = new StockModel();
        if(isset($_POST['scannerText'])) {
            $tonerID = $StockModel->getTonerIdFromBarCode1($_POST['scannerText']);
            if(!empty($tonerID)) {
                $StockModel->addStockToner($tonerID[0]);
              echo("<section class='text-success'>Poprawny skan.</section>");
            }
            else {
                $tonerID = $StockModel->getTonerIdFromBarCode2($_POST['scannerText']);
                if(!empty($tonerID)) {
                    $StockModel->addStockToner($tonerID[0]);
                  echo("<section class='text-success'>Poprawny skan.</section>");
                }
                else {
                    echo('<script>var audio = new Audio("../resources/bad.wav"); audio.play();</script>');
                    echo("<section class='text-danger'>Podano zły kod, albo tonera nie ma na liście modeli.</section>");
                }
            }
        }
    }

?>