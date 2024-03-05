<!-- Menu -->
<?php
    include_once $_SERVER['DOCUMENT_ROOT'].'/view/header.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/controller/mainController.php'; 
?>
<body onclick="focusScript()" class="h-100 d-flex flex-column">
<!-- <div class="m-2 shadow p-3 text-center flex-column rounded">
    Zeskanuj toner lub wybierz pokój z listy<br><img src="../resources/barcode_scan.gif" alt="Tonery" style="height: 80px;">
    <!-- Skrypt do obsługi skanera -->
    <?php
        //generate();   
    ?>
    <!--<form method="POST" action="">
        <button type="submit" name="cookieButton" value="delete" class="btn btn-danger mt-2">Wyczyść</button>
    </form>
    <form method="POST" action="">
        <input id="scannerInput" type="text" name="scannerText" class="bg-success" style="position: absolute; left: -999em;" autofocus/>
        <button type="submit" class="d-none"></button>
    </form>
</div> -->
<div class="m-2 shadow p-3 text-center flex-column rounded">
    <form action="" method="POST">
        <h3>Pokoje</h3>
        <?php
            generateRoomsList();
        ?>
    </form>
</div>

<div class="m-2 shadow p-3 text-center flex-column flex-grow-1 overflow-auto rounded">
    <form action="" method="POST">
        <h3>Lista</h3>
        <?php
            generatePrintersList();
        ?>
    </form>
</div>

<?php
    include_once $_SERVER['DOCUMENT_ROOT'].'/view/footer.php';
?>
<script>
    function focusScript() {
        document.getElementById("scannerInput").focus();
    }
</script>

