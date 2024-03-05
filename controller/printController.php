<?php 
    include_once $_SERVER['DOCUMENT_ROOT'].("/model/printModel.php");
    $PrintModel = new PrintModel();
    if(isset($_POST['printButton'])) {
        switch($_POST['printButton']) {
            case "1":
                $print = $PrintModel->returnPrint1();
                $headers = array("Model","Ilość Drukarek","Toner","Ilość Tonera");
                //$antyReapeter = array(0,1);
                generateTable($headers, $print);
                generateSortTableScript();
                break;
            case "2":
                $print = $PrintModel->returnPrint2();
                $headers = array("Firma","Model","Ilość Tonera","Stan");
                generateTable($headers, $print);
                generateSortTableScript();
                break;
            case "3":
                $print = $PrintModel->returnPrint3();
                $headers = array("Pokój","Firma","Model","Numer Inw.","Adres IP");
                generateTable($headers, $print);
                generateSortTableScript();
                break;
            case "4":
                $print = $PrintModel->returnPrint4();
                $headers = array("Toner","Ilość Tonera","Ilość Drukarek");
                generateTable($headers, $print);
                generateSortTableScript();
                break;
            default:
                echo "Brak danych";
                break;    
        }
    } else {
        echo "Brak danych";
    }
?>