<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="resources/icon.png" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TONERY</title>
    <link rel="stylesheet" href="resources/mainStyle.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>
<body>
     <section class="container">
        <div class="row justify-content-center text-center">
            <form action="controller\loginController.php" method="POST" class="rounded shadow-lg p-3" id="formLogin">
                <img src="resources/logo.png" alt="Tonery">
                <input class="form-control transparent-input" placeholder="Login" type="text" name="userName" required/><br>
                <input class="form-control transparent-input" placeholder="Hasło" type="password" name="userPassword" required/><br>
                <input class="btn btn-outline-dark px-5 my-2" type="submit" name="submit" value="Zaloguj"/>
                <?php
                    include_once $_SERVER['DOCUMENT_ROOT'].'/libs/Cookie.php';
                    if(isset($_COOKIE['alert'])) {
                        echo "<p class='text-danger'>".$_COOKIE['alert']."</p>";
                    }
                    clearAlertCookie();
                ?>
            </form>
        </div>
    </section>
<?php
    include_once $_SERVER['DOCUMENT_ROOT'].'/view/footer.php';
?>