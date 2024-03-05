<?php
    include_once $_SERVER['DOCUMENT_ROOT'].'/view/header.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/controller/stockController.php';
?>
<body  onclick="focusScript()">
<div class="m-3 text-center d-print-none">
    <form method="POST" action="">
        <button type="submit" name="stockButton" value="start" class="btn mb-1 btn-outline-success">Rozpocznij</button>
        <button type="submit" name="stockButton" value="stop" class="btn mb-1 btn-outline-danger">Zakończ</button>
    </form>
    <hr>
</div>
<div class="m-2 shadow p-3 text-center flex-column rounded d-print-none">
    <img src="../resources/barcode_scan.gif" alt="Tonery" style="height: 80px;">
    <!-- Skrypt do obsługi skanera -->
    <?php
        generate();   
    ?>
    <form method="POST" action="">
        <input id="scannerInput" type="text" name="scannerText" class="bg-success" style="position: absolute; left: -999em;" autofocus/>
        <button type="submit" class="d-none"></button>
    </form>
</div>
<div class="m-3 p-3 text-center">
    <h3>Zeskanowane</h3>
    <div class="row">
        <?php
            generateScannedStockList();
        ?>
    </div>
</div>
<div class="m-3 p-3 text-center">
    <h3>Pozostałe</h3>
    <div class="row">
        <?php
            generateStockList();
        ?>
    </div>
</div>
<?php
    include_once $_SERVER['DOCUMENT_ROOT'].'/view/footer.php';
?>
<script>
    function focusScript() {
        document.getElementById("scannerInput").focus();
    }
</script>