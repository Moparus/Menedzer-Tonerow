<?php
    include_once $_SERVER['DOCUMENT_ROOT'].'/view/header.php';
?>
<body>
<div class="m-3 text-center d-print-none">
    <form method="POST" action="">
        <button type="submit" name="printButton" value="1" class="btn mb-1 btn-outline-dark">Ilość Drukarek/Tonerów</button>
        <button type="submit" name="printButton" value="4" class="btn mb-1 btn-outline-dark">Lista Tonerów/Drukarek</button>
        <button type="submit" name="printButton" value="2" class="btn mb-1 btn-outline-dark">Lista Tonerów</button>
        <button type="submit" name="printButton" value="3" class="btn mb-1 btn-outline-dark">Lista Drukarek</button>
        <button class="btn mb-1 btn-outline-primary d-print-none float-right" onclick="window.print()">Drukuj</button>
    </form>
    <hr>
</div>
<div class="m-3 p-3 text-center">
    <?php
        include_once $_SERVER['DOCUMENT_ROOT'].'/controller/printController.php';
    ?>
</div>
<?php
    include_once $_SERVER['DOCUMENT_ROOT'].'/view/footer.php';
?>
