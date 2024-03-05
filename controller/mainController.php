<?php
include_once $_SERVER['DOCUMENT_ROOT'].("/model/mainModel.php");
/*function generate(){
    $MainModel = new MainModel();
    $toners = $MainModel->returnToners();
    if(isset($_POST['scannerText']))
    {
        if(in_array($_POST['scannerText'],$toners)){
            $text = "'".$_POST['scannerText']."'";
            setcookie('tonersBarCodes', $text, time() + (86400 * 30), "/");
            echo($_POST['scannerText'].'<br>');
            header("Refresh:0");
        }
        else{
            echo('<script>var audio = new Audio("../resources/bad.wav"); audio.play();</script>');
            echo('<section class="text-danger">'.$_POST['scannerText'].'</section>');
        }
    }
    if(isset($_POST['cookieButton'])) {
        switch($_POST['cookieButton']) {
            case "send":
                break;
            case "delete":
                setcookie('tonersBarCodes', ' ', time() - (86400 * 30), "/");
                header("Refresh:0");
                break;
        }
    }
    if(isset($_COOKIE['tonersBarCodes']))
    {
        $MainModel = new MainModel();
        $selectedToners = $MainModel->returnSelectedToners($_COOKIE['tonersBarCodes']);
        echo('<hr>Zeskanowane: ');
        for($i=0; $i<sizeof($selectedToners); $i++)
        {
            echo($selectedToners[$i][0]);
        }
    }
}*/


function generateRoomsList(){
    $MainModel = new MainModel();
    $rooms = $MainModel->returnRooms();
    if(isset($_COOKIE['tonersBarCodes'])){
        $activeRooms = $MainModel->returnActiveRooms($_COOKIE['tonersBarCodes']);
        for($i=0; $i<sizeof($rooms); $i++)
        {
            if(in_array($rooms[$i][0],$activeRooms))
                echo ('<button type="submit" name="roomButton" value="'.$rooms[$i][0].'" class="btn btn-outline-dark btn-lg m-1">'.$rooms[$i][1].'</button>');
        }
    } else {
        if(!isset($_POST['roomButton']))
            for($i=0; $i<sizeof($rooms); $i++)
            {
                echo ('<button type="submit" name="roomButton" value="'.$rooms[$i][0].'" class="btn btn-outline-dark btn-lg m-1">'.$rooms[$i][1].'</button>');
            }
        else
            for($i=0; $i<sizeof($rooms); $i++)
            {    
                if($rooms[$i][0]==$_POST['roomButton'])
                    echo ('<button type="submit" name="roomButton" value="'.$rooms[$i][0].'" class="btn btn-dark btn-lg m-1">'.$rooms[$i][1].'</button>');
                else
                    echo ('<button type="submit" name="roomButton" value="'.$rooms[$i][0].'" class="btn btn-outline-dark btn-lg m-1">'.$rooms[$i][1].'</button>');
            }
    }

}

function generatePrintersList(){
    if(isset($_POST['roomButton'])) {
        $MainModel = new MainModel();
        if(isset($_COOKIE['tonersBarCodes']))
            $printers = $MainModel->returnPrintersToners($_POST['roomButton'],$_COOKIE['tonersBarCodes']);
        else
            $printers = $MainModel->returnPrinters($_POST['roomButton']);
        for($i=0; $i<sizeof($printers); $i++)
        {
            echo($printers[$i][1].' ');
            echo($printers[$i][2].' ');
            echo('<a rel="noopener noreferrer" target="_blank" href=" http://'.$printers[$i][4].'/">'.$printers[$i][3].'</a>');
            echo ('<button type="submit" name="printerButton" value="'.$printers[$i][0].'" class="btn btn-outline-info m-1">Wybierz</button><br>');
        }
    }
    if(isset($_POST['printerButton'])) {
        echo('<script>document.querySelector("body").setAttribute("onclick", null);</script>');
        $MainModel = new MainModel();
        $printer = $MainModel->returnPrinterInfo($_POST['printerButton']);
        echo('<input name="printerId" value="'.$_POST['printerButton'].'" class="d-none"></input>');
        echo($printer[4].' - '.$printer[0].' '.$printer[1].' <a rel="noopener noreferrer" target="_blank" href=" http://'.$printer[3].'/">'.$printer[2].'</a><br><br>');
        $toners = $MainModel->returnPrinterToners($_POST['printerButton']);
        for($i= 0; $i<sizeof($toners); $i++) {
            switch($toners[$i][2])
            {
                case 'cyan':
                    echo('<span style="border: 1px solid cyan; padding: 3px;">'.$toners[$i][1].'</span> ');
                    break;
                case 'magenta':
                    echo('<span style="border: 1px solid magenta; padding: 3px;">'.$toners[$i][1].'</span> ');
                    break;
                case 'yellow':
                    echo('<span style="border: 1px solid yellow; padding: 3px;">'.$toners[$i][1].'</span> ');
                    break;
                default:
                echo('<span style="border: 1px solid black; padding: 3px;">'.$toners[$i][1].'</span> ');
                    break;
            }
            echo('Ilość: '.$toners[$i][3].' ');
            echo($toners[$i][4].' ');
            echo('<button type="submit" name="tonersButton" value="'.$toners[$i][0].'" class="btn btn-sm btn-outline-info m-1">Przypisz</button>');
            echo("<br>");
        }
        echo("<br><section class='text-danger'>Pamiętaj o sprawdzeniu stanu licznika!</section>");
        echo('<input class="border border-dark rounded p-1 w-50" name="counterState" type="number" placeholder="Wpisz stan licznika" required></input><br>');
        $tonersArchive = $MainModel->returnPrinterTonersArchive($_POST['printerButton']);
        if(!empty($tonersArchive)){
            echo('<br><h3>Historia</h3>');
            for($i= 0; $i<sizeof($tonersArchive); $i++) {
                $newDate = date("d-m-Y", strtotime($tonersArchive[$i][2]));
                echo('<b>'.$newDate.'</b>  '.$tonersArchive[$i][0].' '.$tonersArchive[$i][1].'<br>');
            }
        }

    }
    if(isset($_POST['tonersButton'])) {
        $MainModel = new MainModel();
        $counter = $MainModel->returnCounterState($_POST['printerId']);
        if(intval($counter['stan_licznika'])>intval($_POST['counterState'])){
            echo('<section class="text-danger">Nie przypisano Tonera :(<br>Podano zły stan licznika.<section>');
        } else {
            $MainModel->setPrinterToner($_POST['tonersButton'],$_POST['printerId'],$_POST['counterState']);
            echo('Przypisano Toner :D');
        }
    }
}
?>