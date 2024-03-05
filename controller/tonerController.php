<?php
    include_once $_SERVER['DOCUMENT_ROOT'].("/model/tonerModel.php");
    $TonerModel = new TonerModel();

    if(isset($_POST['tonerButton'])) {
        switch($_POST['tonerButton']) {
            case "addToner":
                $TonerModel->addToner($_POST['tonerModelSelect'],$_POST['tonerAmount'],$_POST['tonerStateSelect'],$_POST['tonerBarCode']);
                break;
            case 'editToner':
                if(isset($_POST['barCode']))
                    $TonerModel->editToner($_POST['tonerId'],$_POST['tonerAmount'],$_POST['tonerState'],$_POST['barCode']);
                else
                    $TonerModel->editToner($_POST['tonerId'],$_POST['tonerAmount'],$_POST['tonerState']);
                break;
            case 'deleteToner':
                $TonerModel->deleteToner($_POST['tonerId']);
                break;
            case 'editTonerModel':
                $TonerModel->editTonerModel($_POST['tonerModelId'],$_POST['companySelect'],$_POST['tonerModel'],$_POST['tonerColour'],$_POST['barCode']);
                break;
            case 'deleteTonerModel':
                $TonerModel->deleteTonerModel($_POST['tonerModelId']);
                break;
        }
    }

    if(isset($_POST['addMenuButton'])) {
        switch($_POST['addMenuButton']) {
            case "addCompany":
                $TonerModel->addCompany($_POST['companyName']);
                break;
            case "addModel":
                $TonerModel->addTonerModel($_POST['companySelect'],$_POST['modelName'],$_POST['barCode'],$_POST['colourSelect']);
                break;
        }
    }

    function generateResponse()
    {
        include_once $_SERVER['DOCUMENT_ROOT'].("/model/tonerModel.php");
        $TonerModel = new TonerModel();
        if(isset($_POST['scannerText'])) {
            echo '<script>document.getElementById("multiAddToner").className = "d-block";</script>';
            $model = $TonerModel->getTonerModelInfoFromCode($_POST['scannerText']);
            if(!empty($model)) {
                if($_POST['stateSelect'] == 1) {
                    $TonerModel->addToner($model['toner_model_id'],1,$_POST['stateSelect'],"");
                }
                else {
                    $TonerModel->addToner($model['toner_model_id'],1,$_POST['stateSelect'],$_POST['scannerText']);
                }
                echo("Dodano Toner: ".$model['model']);
            }
            else {
                echo('<script>var audio = new Audio("../resources/bad.wav"); audio.play();</script>');
                echo("<section class='text-danger'>Podano zły kod, albo tonera nie ma na liście modeli.</section>");
            }
        }
    }

    function getTonersModelsList($selected = -1)
    {
        include_once $_SERVER['DOCUMENT_ROOT'].("/model/tonerModel.php");
        $TonerModel = new TonerModel();
        $models = $TonerModel->getTonersModelsList();
        for($i=0; $i<sizeof($models); $i++)
        {
            if($selected == $models[$i][0])
                echo ('<option value="'.$models[$i][0].'" selected>'.$models[$i][1].' '.$models[$i][2].' '.$models[$i][3].' '.$models[$i][4].'</option>');
            else
                echo ('<option value="'.$models[$i][0].'">'.$models[$i][1].' '.$models[$i][2].' '.$models[$i][3].' '.$models[$i][4].'</option>');
        }
    }

    function getTonerStateList($selected = -1)
    {
        include_once $_SERVER['DOCUMENT_ROOT'].("/model/tonerModel.php");
        $TonerModel = new TonerModel();
        $states = $TonerModel->getTonerStateList();
        for($i=0; $i<sizeof($states); $i++)
        {
            if($selected == $states[$i][0])
                echo ('<option value="'.$states[$i][0].'" selected>'.$states[$i][1].'</option>');
            else
                echo ('<option value="'.$states[$i][0].'">'.$states[$i][1].'</option>');
        }
    }

    function getCompanyList($selected = -1)
    {
        include_once $_SERVER['DOCUMENT_ROOT'].("/model/tonerModel.php");
        $TonerModel = new TonerModel();
        $companies = $TonerModel->getCompanyList();
        for($i=0; $i<sizeof($companies); $i++)
        {
            if($selected == $companies[$i][0])
                echo ('<option value="'.$companies[$i][0].'" selected>'.$companies[$i][1].'</option>');
            else
                echo ('<option value="'.$companies[$i][0].'">'.$companies[$i][1].'</option>');
        }
    }

    function getColourList($selected = -1)
    {
        include_once $_SERVER['DOCUMENT_ROOT'].("/model/tonerModel.php");
        $TonerModel = new TonerModel();
        $colours = $TonerModel->getColourList();
        for($i=0; $i<sizeof($colours); $i++)
        {
            if($selected == $colours[$i][0])
                echo ('<option value="'.$colours[$i][0].'" selected>'.$colours[$i][1].'</option>');
            else 
                echo ('<option value="'.$colours[$i][0].'">'.$colours[$i][1].'</option>');
        }
    }

    
    function getTonersList($selectedToner = -1)
    {
        include_once $_SERVER['DOCUMENT_ROOT'].("/model/tonerModel.php");
        $TonerModel = new TonerModel();
        $toners = $TonerModel->getTonersList();
        for($i=0; $i<sizeof($toners); $i++)
        {
            if($selectedToner == $toners[$i][0])
                echo ('<option value="'.$toners[$i][0].'" selected>'.$toners[$i][1].' '.$toners[$i][2].' '.$toners[$i][3].' '.$toners[$i][4].' '.$toners[$i][5].'</option>');
            else
                echo ('<option value="'.$toners[$i][0].'">'.$toners[$i][1].' '.$toners[$i][2].' '.$toners[$i][3].' '.$toners[$i][4].' '.$toners[$i][5].'</option>');
        }
    }

    function editForm()
    {
        if(isset($_POST['chooseButton'])) {
            switch($_POST['chooseButton'])
            {
                case 'chooseToner':
                    echo '<script>document.getElementById("editToner").className = "d-block";</script>';
                    generateTonerEditForm($_POST['tonerSelect']);
                    break;
                case 'chooseTonerModel':
                    echo '<script>document.getElementById("editToner").className = "d-block";</script>';
                    generateTonerModelEditForm($_POST['tonerModelSelect']);
                    break;
            }
            
        }
    }
    function generateTonerEditForm($selectedToner)
    {
        $TonerModel = new TonerModel();
        $tonersInfo = $TonerModel->getTonerInfo($selectedToner);
        echo '<div class="m-2 border shadow p-3 text-center flex-column rounded">';
        echo '<form method="POST" action="">
                <input type="text" class="d-none" name="tonerId" value="'.$tonersInfo[0].'">
                Model
                <select class="custom-select my-2" name="modelSelect" disabled>';
                    getTonersModelsList($tonersInfo[1]);
                echo '</select>
                <hr>
                Ilość
                <input type="text" class="form-control my-2" name="tonerAmount" placeholder="'.$tonersInfo[2].'" value="'.$tonersInfo[2].'" required>
                <hr>
                Stan Tonera
                <select class="custom-select my-2" name="tonerState" required>';
                    getTonerStateList($tonersInfo[3]);
                echo '</select>
                <hr>';
                if(isset($tonersInfo[4]))
                    echo'Kod Kreskowy<input type="text" class="form-control my-2" name="barCode" placeholder="'.$tonersInfo[4].'" value="'.$tonersInfo[4].'" required><hr>';
                echo '<button type="submit" name="tonerButton" value="editToner" class="btn btn-outline-info">Edytuj Toner</button>
                <button type="submit" name="tonerButton" value="deleteToner" class="btn btn-outline-danger">Usuń Toner</button>
             </form>';
        echo '</div>';
    }
    function generateTonerModelEditForm($selectedTonerModel)
    {
        $TonerModel = new TonerModel();
        $tonersInfo = $TonerModel->getTonerModelInfo($selectedTonerModel);
        echo '<div class="m-2 border shadow p-3 text-center flex-column rounded">';
        echo '<form method="POST" action="">
            <input type="text" class="d-none" name="tonerModelId" value="'.$tonersInfo[0].'">
            Firma
            <select class="custom-select my-2" name="companySelect">';
                getCompanyList($tonersInfo[1]);
            echo '</select>
            <hr>
            Model
            <input type="text" class="form-control my-2" name="tonerModel" placeholder="'.$tonersInfo[2].'" value="'.$tonersInfo[2].'" required>
            <hr>
            Kolor
            <select class="custom-select my-2" name="tonerColour" required>';
                getColourList($tonersInfo[3]);
            echo '</select>
            <hr>';
            echo'Kod Kreskowy<input type="text" class="form-control my-2" name="barCode" placeholder="'.$tonersInfo[4].'" value="'.$tonersInfo[4].'" required><hr>';
            echo '<button type="submit" name="tonerButton" value="editTonerModel" class="btn btn-outline-info">Edytuj Toner</button>
            <button type="submit" name="tonerButton" value="deleteTonerModel" class="btn btn-outline-danger">Usuń Toner</button>
        </form>';
        echo '</div>';
    }
?>