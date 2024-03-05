<!-- Menu -->
<?php
    include_once $_SERVER['DOCUMENT_ROOT'].'/view/header.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/controller/printersController.php';
    if(!checkIfAdmin($_SESSION['user'])){
      header('location: ../index.php');
      session_destroy();
    } 
?>
<body class="h-100 d-flex flex-column">
<div class="m-2 shadow p-1 pb-3 text-center border flex-column rounded">
    <h5 class="mt-2 mb-0">Drukarki</h5>
    <button onclick="showForm('addPrinter')" type="submit" class="btn btn-outline-dark mt-3">Dodaj</button>
    <button onclick="showForm('editPrinter')" type="submit" class="btn btn-outline-dark mt-3">Edytuj</button>
    <button onclick="showForm('servicePrinter')" type="submit" class="btn btn-outline-dark mt-3">Serwisuj</button>
    <button onclick="showForm('addTonersPrinter')" type="submit" class="btn btn-outline-dark mt-3">Przypisz Tonery</button>
</div>
<script>
    function showForm($form) {
        var printerMenuButtons = document.getElementsByName("printerMenuButtons");
        printerMenuButtons.forEach(element => {
            element.className = 'd-none';
        });
        document.getElementById($form).className = 'd-block';
    }
</script>  

<!-- Jeżeli wybrano dodawanie -->
<section id="addPrinter" class="d-none border" name="printerMenuButtons">
    <div class="m-2 shadow p-1 pb-3 text-center flex-column rounded border">
        <h5 class="mt-2 mb-0">Dodatkowe</h5>
        <button type="button" class="btn btn-outline-dark mt-3" data-toggle="modal" data-target=".addCompanyModal">Dodaj Firmę</button>
        <button type="button" class="btn btn-outline-dark mt-3" data-toggle="modal" data-target=".addModelModal">Dodaj Model</button>
        <button type="button" class="btn btn-outline-dark mt-3" data-toggle="modal" data-target=".addRoomModal">Dodaj Pokój</button>
    </div>
    <div class="m-2 shadow p-3 text-center flex-column rounded border">
        <form method="POST" action="">
            Model
            <select class="custom-select my-2" name="printersSelect" required>
                <?php
                    getPrintersModelsList();
                ?>
            </select>
            <hr>
            Pokój
            <select class="custom-select my-2" name="roomsSelect" required>
                <?php
                    getRoomsList();
                ?>
            </select>
            <hr>
            Numer Seryjny
            <input type="text" class="form-control my-2" name="serialNumber" placeholder="np. A1B2C3D4" required>
            <hr>
            Numer Inwentarzowy
            <input type="text" class="form-control my-2" name="inventoryNumber" placeholder="np. N/123/1234" required>
            <hr>
            Kod Kreskowy
            <input type="text" class="form-control my-2" name="barCode" placeholder="np. 1LJ" required>
            <hr>
            Stan licznika
            <input type="text" class="form-control my-2" name="counterState" placeholder="np. 12345" required>
            <hr>
            Adres IP
            <input type="text" class="form-control my-2" name="adressIp" placeholder="np. 10.100.1.100">
            <hr>
            Mac
            <input type="text" class="form-control my-2" name="mac" placeholder="np. 00:AA:11:BB:22:CC">
            <hr>
            Data Zakupu
            <input type="date" class="form-control my-2" name="buyDate" required>
            <hr>
            <button type="submit" name="printerButton" value="addPrinter" class="btn btn-outline-success">Dodaj Drukarkę</button>
        </form>
    </div>

    <!-- Dodaj Firme -->
    <div class="modal fade addCompanyModal text-center" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content p-2">
                <form method="POST" action="">
                    <h5 class="mt-3">Dodaj firmę</h5><hr>
                    <input type="text" class="form-control" name="companyName" placeholder="Wprowadź nazwę"><hr>
                    <button type="submit" name="addMenuButton" value="addCompany" class="btn btn-outline-success mb-2">Dodaj</button>  
                </form>
            </div>
        </div>
    </div>
    <!-- Dodaj Model -->
    <div class="modal fade addModelModal text-center" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content p-2">
                <form method="POST" action="">
                    <h5 class="mt-3">Dodaj Model Drukarki</h5><hr>
                    Firma
                    <select class="custom-select mb-2" name="companySelect">
                        <?php
                            getCompanyList();
                        ?>
                    </select>
                    Model
                    <input type="text" class="form-control" name="modelName" placeholder="Wprowadź model"><hr>
                    <button type="submit" name="addMenuButton" value="addModel" class="btn btn-outline-success mb-2">Dodaj</button>
                </form>
            </div>
        </div>
    </div>
    <!-- Dodaj Pokój -->
    <div class="modal fade addRoomModal text-center" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content p-2">
                <form method="POST" action="">
                    <h5 class="mt-3">Dodaj Pokój</h5><hr>
                    <input type="text" class="form-control" name="roomName" placeholder="Wprowadź numer"><hr>
                    <button type="submit" name="addMenuButton" value="addRoom" class="btn btn-outline-success mb-2">Dodaj</button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Jeżeli wybrano edycję -->
<section id="editPrinter" class="d-none" name="printerMenuButtons">
    <div class="border shadow m-2 p-3 text-center flex-column rounded">
        Wybierz drukarkę do edycji
        <form method="POST" action="">
            <select class="custom-select my-2" name="printerSelect">
                <?php
                if(isset($_POST['printerSelect']))
                    getPrintersList($_POST['printerSelect']);
                else
                    getPrintersList();
                ?>
            </select>
            <button type="submit" name="chooseButton" value="choosePrinter" class="btn btn-outline-dark">Wybierz</button>
        </form>
    </div>
    <div class="border shadow m-2 p-3 text-center flex-column rounded">
        Wybierz model drukarki do edycji
        <form method="POST" action="">
            <select class="custom-select my-2" name="printerModelSelect">
                <?php
                if(isset($_POST['printerModelSelect']))
                    getPrintersModelsList($_POST['printerModelSelect']);
                else
                    getPrintersModelsList();
                ?>
            </select>
            <button type="submit" name="chooseButton" value="choosePrinterModel" class="btn btn-outline-dark">Wybierz</button>
        </form>
    </div>
    <?php
        editForm();
    ?>
</section>

<!-- Jeżeli wybrano serwis -->
<section id="servicePrinter" class="d-none" name="printerMenuButtons">
    <div class="border shadow m-2 p-3 text-center flex-column rounded">
        Wybierz drukarkę do serwisu
        <form method="POST" action="">
            <select class="custom-select my-2" name="printerSelect">
                <?php
                if(isset($_POST['printerSelect']))
                    getPrintersList($_POST['printerSelect']);
                else
                    getPrintersList();
                ?>
            </select>
            <button type="submit" name="printerButton" value="servicePrinter" class="btn btn-outline-info">Serwisuj</button>
        </form>
    </div>
    <!-- Powrót do ostatniej sali przed serwisem -->
    <div class="border shadow m-2 p-3 text-center flex-column rounded">
        Po naprawie powrót do ostatniej sali
        <form method="POST" action="">
            <select class="custom-select my-2" name="printerSelect">
                <?php
                if(isset($_POST['printerSelect']))
                    getServicePrintersList($_POST['printerSelect']);
                else
                    getServicePrintersList();
                ?>
            </select>
            <button type="submit" name="printerButton" value="backServicePrinter" class="btn btn-outline-info">Zatwierdź</button>
        </form>
    </div>
</section>

<!-- Jeżeli wybrano dodawanie tonerów -->
<section id="addTonersPrinter" class="d-none" name="printerMenuButtons">
    <div class="border shadow m-2 p-3 text-center flex-column rounded">
        Wybierz model drukarki do którego chcesz przypisać tonery
        <form method="POST" action="">
            <select class="custom-select my-2" name="printerModelSelect">
                <?php
                if(isset($_POST['printerModelSelect']))
                    getPrintersModelsList($_POST['printerModelSelect']);
                else
                    getPrintersModelsList(); 
                ?>
            </select>
            <button type="submit" name="chooseModelButton" value="servicePrinter" class="btn btn-outline-dark">Wybierz</button>
        </form>
    </div>
    <?php
    if(isset($_POST['chooseModelButton'])) {
        echo '<script>document.getElementById("addTonersPrinter").className = "d-block";</script>';
        generateModelTonerForm($_POST['printerModelSelect']);
    }
    ?>
</section>
<?php
    include_once $_SERVER['DOCUMENT_ROOT'].'/view/footer.php';
?>

