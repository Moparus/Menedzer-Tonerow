<?php
function OpenCon()
{
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $dbname = "tonery";
    try {
      $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
      mysqli_set_charset($conn, "utf8");
      return $conn; 
    } catch(\Exception $e) { 
      echo('Nie udało się połączyć z bazą <br>');
    }
}
function CloseCon($conn)
{
    mysqli_close($conn);
}

