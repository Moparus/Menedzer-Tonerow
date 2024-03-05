<!-- Menu -->
<?php
    include_once $_SERVER['DOCUMENT_ROOT'].'/view/header.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/controller/tonerController.php';
    if(!checkIfAdmin($_SESSION['user'])){
      header('location: ../index.php');
      session_destroy();
    } 
?>
<body onclick="focusScript()" class="h-100 d-flex flex-column">
<div class="m-2 shadow p-1 pb-3 text-center border flex-column rounded">
    <h5 class="mt-2 mb-0">Tonery</h5>
    <button onclick="showForm('addToner')" type="submit" class="btn btn-outline-dark mt-3">Dodaj</button>
    <button onclick="showForm('editToner')" type="submit" class="btn btn-outline-dark mt-3">Edytuj</button>
    <button onclick="showForm('multiAddToner')" type="submit" class="btn btn-outline-dark mt-3">Hurtowe Dodawanie</button>
</div>
<script>
    function showForm($form) {
        var tonerMenuButtons = document.getElementsByName("tonerMenuButtons");
        tonerMenuButtons.forEach(element => {
            element.className = 'd-none';
        });
        document.getElementById($form).className = 'd-block';
    }
</script>  

<!-- Jeżeli wybrano  -->
<section id="addToner" class="d-none border" name="tonerMenuButtons">
    <div class="m-2 shadow p-1 pb-3 text-center flex-column rounded border">
        <h5 class="mt-2 mb-0">Dodatkowe</h5>
        <button type="button" class="btn btn-outline-dark mt-3" data-toggle="modal" data-target=".addCompanyModal">Dodaj Firmę</button>
        <button type="button" class="btn btn-outline-dark mt-3" data-toggle="modal" data-target=".addModelModal">Dodaj Model</button>
    </div>
    <div class="m-2 shadow p-3 text-center flex-column rounded border">
        <form method="POST" action="">
            Model
            <select class="custom-select my-2" name="tonerModelSelect" required>
                <?php
                    getTonersModelsList();
                ?>
            </select>
            <hr>
            Ilość
            <input type="number" class="form-control my-2" name="tonerAmount" placeholder="0" required>
            <hr>
            Toner Stan
            <select class="custom-select my-2" name="tonerStateSelect" required>
                <?php
                    getTonerStateList();
                ?>
            </select>
            <hr>
            Dodatkowy kod kreskowy (Puste jeśli brak)
            <input type="text" class="form-control my-2" name="tonerBarCode" placeholder="Przy zamiennikach i otwarych tonerach">
            <hr>
            <button type="submit" name="tonerButton" value="addToner" class="btn btn-outline-success">Dodaj Toner</button>
        </form>
    </div>

    <!-- Dodaj Firme -->
    <div class="modal fade addCompanyModal text-center" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content p-2">
                <form method="POST" action="">
                    <h5 class="mt-3">Dodaj firmę</h5><hr>
                    <input type="text" class="form-control" name="companyName" placeholder="Wprowadź nazwę" required>
                    <hr><button type="submit" name="addMenuButton" value="addCompany" class="btn btn-outline-success mb-2">Dodaj</button>  
                </form>
            </div>
        </div>
    </div>
    <!-- Dodaj Model -->
    <div class="modal fade addModelModal text-center" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content p-2">
                <form method="POST" action="">
                    <h5 class="mt-3">Dodaj Model Tonera</h5><hr>
                    Firma
                    <select class="custom-select mb-2" name="companySelect">
                        <?php
                            getCompanyList();
                        ?>
                    </select>
                    Model
                    <input type="text" class="form-control mb-2" name="modelName" placeholder="Wprowadź model" required>
                    Kod Kreskowy
                    <input type="text" class="form-control mb-2" name="barCode" placeholder="Wprowadź kod kreskowy">
                    Kolor
                    <select class="custom-select mb-2" name="colourSelect">
                        <?php
                            getColourList();
                        ?>
                    </select>
                    <hr><button type="submit" name="addMenuButton" value="addModel" class="btn btn-outline-success mb-2">Dodaj</button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Jeżeli wybrano  -->
<section id="editToner" class="d-none border" name="tonerMenuButtons">
    <div class="border shadow m-2 p-3 text-center flex-column rounded">
        Wybierz toner do edycji
        <form method="POST" action="">
            <select class="custom-select my-2" name="tonerSelect">
                <?php
                if(isset($_POST['tonerSelect']))
                    getTonersList($_POST['tonerSelect']);
                else
                    getTonersList();
                ?>
            </select>
            <button type="submit" name="chooseButton" value="chooseToner" class="btn btn-outline-dark">Wybierz</button>
        </form>
    </div>
    <div class="border shadow m-2 p-3 text-center flex-column rounded">
        Wybierz model do edycji
        <form method="POST" action="">
            <select class="custom-select my-2" name="tonerModelSelect">
                <?php
                if(isset($_POST['tonerModelSelect']))
                    getTonersModelsList($_POST['tonerModelSelect']);
                else
                    getTonersModelsList();
                ?>
            </select>
            <button type="submit" name="chooseButton" value="chooseTonerModel" class="btn btn-outline-dark">Wybierz</button>
        </form>
    </div>
    <?php
        editForm();
    ?>
</section>

<!-- Jeżeli wybrano hurtowe dodawanie -->
<section id="multiAddToner" class="d-none border" name="tonerMenuButtons">
    <div class="m-2 shadow p-3 text-center flex-column rounded border">
        Zeskanuj toner aby go dodać<br><img src="../resources/barcode_scan.gif" alt="Tonery" style="height: 80px;">
        <form method="POST" action="">
            <input id="scannerInput" type="text" name="scannerText" class="bg-success" style="position: absolute; left: -999em;" autofocus/>
            Wybierz stan
            <select class="custom-select my-2" size="5" name="stateSelect" required>
                <?php
                    getTonerStateList(1);
                ?>
            </select>
            <button type="submit" class="d-none"></button>
        </form>
    </div>
    <div class="m-2 shadow p-3 text-center flex-column rounded border">
        <?php
            generateResponse();
        ?>
    </div>
</section>

<?php
    include_once $_SERVER['DOCUMENT_ROOT'].'/view/footer.php';
?>
<script>
    function focusScript() {
        document.getElementById("scannerInput").focus();
    }
</script>