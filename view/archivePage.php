<?php
    include_once $_SERVER['DOCUMENT_ROOT'].'/view/header.php';
?>
<body>
<div class="m-3 text-center d-print-none">
    <form method="POST" action="">
        <button type="submit" name="archiveButton" value="1" class="btn btn-outline-dark mb-1">Archiwum Tonery</button>
        <button type="submit" name="archiveButton" value="2" class="btn btn-outline-dark mb-1">Archiwum Drukarki</button>
    </form>
    <hr>
</div>
<div class="m-3 p-3 text-center">
    <?php
        include_once $_SERVER['DOCUMENT_ROOT'].'/controller/archiveController.php';
    ?>
</div>
<?php
    include_once $_SERVER['DOCUMENT_ROOT'].'/view/footer.php';
?>