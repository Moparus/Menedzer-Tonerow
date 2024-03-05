<?php 
    include_once $_SERVER['DOCUMENT_ROOT'].("/model/archiveModel.php");
    $ArchiveModel = new ArchiveModel();
    if(isset($_POST['archiveButton'])) {
        switch($_POST['archiveButton']) {
            case "1":
                $print = $ArchiveModel->returnPrint1();
                $headers = array("Pokój","Firma","Drukarka","Licznik","Toner","Toner Stan","Data");
                generateTable($headers, $print);
                generateSortTableScript();
                break;
            case "2":
                $print = $ArchiveModel->returnPrint2();
                $headers = array("Pokój","Model","Numer Inw.","Data");
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