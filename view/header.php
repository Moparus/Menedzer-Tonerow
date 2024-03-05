<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/libs/Session.php';
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="../resources/icon.png" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TONERY</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/v/bs4-4.6.0/jq-3.7.0/dt-1.13.8/b-2.4.2/b-colvis-2.4.2/b-html5-2.4.2/fc-4.3.0/datatables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/v/bs4-4.6.0/jq-3.7.0/dt-1.13.8/b-2.4.2/b-colvis-2.4.2/b-html5-2.4.2/fc-4.3.0/datatables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>
    <style>
        @media print {
            * { background: transparent !important; color: black !important; box-shadow:none !important; text-shadow: none !important; filter:none !important; -ms-filter: none !important; } /* Black prints faster: h5bp.com/s */
            a, a:visited { text-decoration: underline; }
            a[href]:after { content: " (" attr(href) ")"; }
            abbr[title]:after { content: " (" attr(title) ")"; }
            .ir a:after, a[href^="javascript:"]:after, a[href^="#"]:after { content: ""; } /* Don't show links for images, or javascript/internal links */
            pre, blockquote { border: 1px solid #999; page-break-inside: avoid; }
            thead { display: table-header-group; } /* h5bp.com/t */
            tr, img { page-break-inside: avoid; }
            img { max-width: 100% !important; }
            @page { margin: 0.5cm; }
            p, h2, h3 { orphans: 3; widows: 3; }
            h2, h3 { page-break-after: avoid; }
        }
    </style>
</head>
<header>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <a class="navbar-brand" href="mainPage.php"><img src="../resources/icon.png" alt="Tonery" style="height: 50px;"></a>
        <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-collapse collapse" id="navbarsExample04">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="mainPage.php">Główna</a>
                </li>
              <?php 
               if(checkIfAdmin($_SESSION['user']))
               {
                   echo '<li class="nav-item">
                    <a class="nav-link" href="tonerPage.php">Tonery</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="printersPage.php">Drukarki</a>
                </li>';
               }
              ?>           
                <li class="nav-item">
                    <a class="nav-link" href="archivePage.php">Archiwum</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="printPage.php">Dane</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="stockPage.php">Inwentaryzacja</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <form action="" method="POST">
                        <button type="submit" name="logoutButton" value="logout" class="btn text-danger">Wyloguj</button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>
</header>
