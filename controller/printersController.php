<?php
    include_once $_SERVER['DOCUMENT_ROOT'].("/model/printersModel.php");
    $PrintersModel = new PrintersModel();

    if(isset($_POST['addMenuButton'])) {
        switch($_POST['addMenuButton']) {
            case "addCompany":
                $PrintersModel->addCompany($_POST['companyName']);
                break;
            case "addModel":
                $PrintersModel->addModel($_POST['companySelect'],$_POST['modelName']);
                break;
            case "addRoom":
                $PrintersModel->addRoom($_POST['addRoom']);
                break;
        }
    }

    if(isset($_POST['printerButton'])) {
        switch($_POST['printerButton']) {
            case "addPrinter":
                $PrintersModel->addPrinter($_POST['printersSelect'],$_POST['roomsSelect'],$_POST['inventoryNumber'],$_POST['barCode'],$_POST['counterState'],$_POST['adressIp'],$_POST['mac'],$_POST['buyDate'],$_POST['serialNumber']);
                break;
            case "editPrinter":
                $PrintersModel->editPrinter($_POST['printerId'],$_POST['printersSelect'],$_POST['roomsSelect'],$_POST['inventoryNumber'],$_POST['barCode'],$_POST['counterState'],$_POST['adressIp'],$_POST['mac'],$_POST['buyDate'],$_POST['serialNumber']);
                break;
            case "deletePrinter":
                $PrintersModel->deletePrinter($_POST['printerId']);
                break;
            case "editPrinterModel":
                $PrintersModel->editPrinterModel($_POST['modelId'],$_POST['companySelect'],$_POST['printerModel']);
                break;
            case "deletePrinterModel":
                $PrintersModel->deletePrinterModel($_POST['modelId']);
                break;
            case "servicePrinter":
                $PrintersModel->servicePrinter($_POST['printerSelect']);
                break;
            case "backServicePrinter":
                $PrintersModel->backServicePrinter($_POST['printerSelect']);
                break;
            case "addPrinterToner":
                $PrintersModel->addPrinterToners($_POST['printerModelId'], $_POST['tonerSelect']);
                break;
            case "deletePrinterToner":
                $PrintersModel->deletePrinterToners($_POST['printerModelId'], $_POST['tonerSelect']);
                break;
        }
    }

    function editForm()
    {
        if(isset($_POST['chooseButton'])) {
            switch($_POST['chooseButton'])
            {
                case 'choosePrinter':
                    echo '<script>document.getElementById("editPrinter").className = "d-block";</script>';
                    generateEditPrinterForm($_POST['printerSelect']);
                    break;
                case 'choosePrinterModel':
                    echo '<script>document.getElementById("editPrinter").className = "d-block";</script>';
                    generateEditPrinterModelForm($_POST['printerModelSelect']);
                    break;
            }
        }
    }

    function getCompanyList($company = -1)
    {
        include_once $_SERVER['DOCUMENT_ROOT'].("/model/printersModel.php");
        $PrintersModel = new PrintersModel();
        $companies = $PrintersModel->getCompanyList();
        for($i=0; $i<sizeof($companies); $i++)
        {
            if($company == $companies[$i][0])
                echo ('<option value="'.$companies[$i][0].'" selected>'.$companies[$i][1].'</option>');
            else
                echo ('<option value="'.$companies[$i][0].'">'.$companies[$i][1].'</option>');
        }
    }

    function getPrintersModelsList($printerModelId = -1)
    {
        include_once $_SERVER['DOCUMENT_ROOT'].("/model/printersModel.php");
        $PrintersModel = new PrintersModel();
        $printers = $PrintersModel->getPrintersModelsList();
        for($i=0; $i<sizeof($printers); $i++)
        {
            if($printerModelId == $printers[$i][0])
                echo ('<option value="'.$printers[$i][0].'" selected>'.$printers[$i][1].' '.$printers[$i][2].'</option>');
            else
                echo ('<option value="'.$printers[$i][0].'">'.$printers[$i][1].' '.$printers[$i][2].'</option>');

        }
    }

    function getRoomsList($roomId = -1)
    {
        include_once $_SERVER['DOCUMENT_ROOT'].("/model/printersModel.php");
        $PrintersModel = new PrintersModel();
        $rooms = $PrintersModel->getRoomsList();
        for($i=0; $i<sizeof($rooms); $i++)
        {
            if($roomId == $rooms[$i][0])
                echo ('<option value="'.$rooms[$i][0].'" selected>'.$rooms[$i][1].'</option>');
            else
                echo ('<option value="'.$rooms[$i][0].'">'.$rooms[$i][1].'</option>');
        }
    }

    function getPrintersList($selectedPrinter = -1)
    {
        include_once $_SERVER['DOCUMENT_ROOT'].("/model/printersModel.php");
        $PrintersModel = new PrintersModel();
        $printers = $PrintersModel->getPrintersList();
        for($i=0; $i<sizeof($printers); $i++)
        {
            if( $selectedPrinter == $printers[$i][0])
                echo ('<option value="'.$printers[$i][0].'" selected>'.$printers[$i][1].' '.$printers[$i][2].' '.$printers[$i][3].' '.$printers[$i][4].'</option>');
            else
                echo ('<option value="'.$printers[$i][0].'">'.$printers[$i][1].' '.$printers[$i][2].' '.$printers[$i][3].' '.$printers[$i][4].'</option>');
        }
    }

    function getServicePrintersList($selectedPrinter = -1)
    {
        include_once $_SERVER['DOCUMENT_ROOT'].("/model/printersModel.php");
        $PrintersModel = new PrintersModel();
        $printers = $PrintersModel->getServicePrintersList();
        for($i=0; $i<sizeof($printers); $i++)
        {
            if( $selectedPrinter == $printers[$i][0])
                echo ('<option value="'.$printers[$i][0].'" selected>Serwis -> '.$printers[$i][1].' | '.$printers[$i][2].' '.$printers[$i][3].' '.$printers[$i][4].'</option>');
            else
                echo ('<option value="'.$printers[$i][0].'">Serwis -> '.$printers[$i][1].' | '.$printers[$i][2].' '.$printers[$i][3].' '.$printers[$i][4].'</option>');
        }
    }

    function getTonersModelsList($selectedModel = -1)
    {
        include_once $_SERVER['DOCUMENT_ROOT'].("/model/printersModel.php");
        $PrintersModel = new PrintersModel();
        $toners = $PrintersModel->getTonersModelsList($selectedModel);
        for($i=0; $i<sizeof($toners); $i++)
        {
            echo ('<option value="'.$toners[$i][0].'">'.$toners[$i][1].' '.$toners[$i][2].' '.$toners[$i][3].' - '.$toners[$i][4].'</option>');
        }
    }

    function generateEditPrinterForm($selectedPrinter)
    {
        $PrintersModel = new PrintersModel();
        $printerInfo = $PrintersModel->getPrinterInfo($selectedPrinter);
        echo '<div class="m-2 border shadow p-3 text-center flex-column rounded">';
        echo '<form method="POST" action="">
                <input type="text" class="d-none" name="printerId" value="'.$printerInfo[0].'">
                Model
                <select class="custom-select my-2" name="printersSelect" required>';
                    getPrintersModelsList($printerInfo[7]);
                echo '</select>
                <hr>
                Pokój
                <select class="custom-select my-2" name="roomsSelect" required>';
                    getRoomsList($printerInfo[8]);
                echo '</select>
                <hr>
                Numer Seryjny
                <input type="text" class="form-control my-2" name="serialNumber" placeholder="'.$printerInfo[5].'" value="'.$printerInfo[5].'" required>
                <hr>
                Numer Inwentarzowy
                <input type="text" class="form-control my-2" name="inventoryNumber" placeholder="'.$printerInfo[1].'" value="'.$printerInfo[1].'" required>
                <hr>
                Kod Kreskowy
                <input type="text" class="form-control my-2" name="barCode" placeholder="'.$printerInfo[3].'" value="'.$printerInfo[3].'" required>
                <hr>
                Stan licznika
                <input type="text" class="form-control my-2" name="counterState" placeholder="'.$printerInfo[9].'" value="'.$printerInfo[9].'" required>
                <hr>
                Adres IP
                <input type="text" class="form-control my-2" name="adressIp" placeholder="'.$printerInfo[2].'" value="'.$printerInfo[2].'">
                <hr>
                Mac
                <input type="text" class="form-control my-2" name="mac" placeholder="'.$printerInfo[4].'" value="'.$printerInfo[4].'">
                <hr>
                Data Zakupu
                <input type="date" class="form-control my-2" name="buyDate" placeholder="'.$printerInfo[6].'" value="'.$printerInfo[6].'" required>
                <hr>
                <button type="submit" name="printerButton" value="editPrinter" class="btn btn-outline-info">Edytuj Drukarkę</button>
                <button type="submit" name="printerButton" value="deletePrinter" class="btn btn-outline-danger">Usuń Drukarkę</button>
             </form>';
        echo '</div>';
    }

    function generateEditPrinterModelForm($selectedModel)
    {
        $PrintersModel = new PrintersModel();
        $printerInfo = $PrintersModel->getPrinterModelInfo($selectedModel);
        echo '<div class="m-2 border shadow p-3 text-center flex-column rounded">';
        echo '<form method="POST" action="">
                <input type="text" class="d-none" name="modelId" value="'.$printerInfo[0].'">
                Firma
                <select class="custom-select my-2" name="companySelect" required>';
                    getCompanyList($printerInfo[1]);
                echo '</select>
                <hr>
                Model
                <input type="text" class="form-control my-2" name="printerModel" placeholder="'.$printerInfo[2].'" value="'.$printerInfo[2].'" required>
                <hr>
                <button type="submit" name="printerButton" value="editPrinterModel" class="btn btn-outline-info">Edytuj Model</button>
                <button type="submit" name="printerButton" value="deletePrinterModel" class="btn btn-outline-danger">Usuń Model</button>
             </form>';
        echo '</div>';
    }

    function generateModelTonerForm($selectedModel)
    {
        $PrintersModel = new PrintersModel();
        echo '<div class="m-2 border shadow p-3 text-center flex-column rounded">';
        echo '<form method="POST" action="">
        <input type="text" class="d-none" name="printerModelId" value="'.$selectedModel.'">
        Wybierz toner, który chcesz przypisać.
        <select class="custom-select my-2" name="tonerSelect" required>';
            getTonersModelsList(-1);
        echo '</select>';
        echo '<button type="submit" name="printerButton" value="addPrinterToner" class="btn btn-outline-success">Dodaj Toner</button>';
        echo '</form></div>';

        echo '<div class="m-2 border shadow p-3 text-center flex-column rounded">';
        echo 'Przypisane Tonery';
        $print = $PrintersModel->getPrinterToners($selectedModel);
        $headers = array("Nazwa","Model","kolor","Kod Kreskowy");
        generateTable($headers, $print);
        echo '</div>';

        echo '<div class="m-2 border shadow p-3 text-center flex-column rounded">';
        echo '<form method="POST" action="">
        <input type="text" class="d-none" name="printerModelId" value="'.$selectedModel.'">
        Wybierz toner, którego przypisanie chcesz usunąć.
        <select class="custom-select my-2" name="tonerSelect" required>';
            getTonersModelsList($selectedModel);
        echo '</select>';
        echo '<button type="submit" name="printerButton" value="deletePrinterToner" class="btn btn-outline-danger">Usuń Toner</button>';
        echo '</form></div>';
    }
?>
