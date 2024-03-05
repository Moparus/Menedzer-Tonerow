<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/libs/Database.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/libs/Session.php';
class Model
{
  public $conn;
  function __construct()
  {
    $this->conn = OpenCon();
    ini_set('display_errors', 0);
  }
  function __destruct()
  {
    CloseCon($this->conn);
  }
}

/**
     * Funkcja wyświetla tabele zawierającą podane dane
     * @param array $headers Nagłówki kolumn.
     * @param array $data Tablica zawierająca dane, które chcemy wyświetlić.
     * @param array $antyReapet Tablica zawierająca indexy kolumn, w których nie chcemy powtórzeń (od 0 do n). Wazna kolejnosc.
     */
    function generateTable($headers, $data, $antyReapet=array(-1)){
        echo '<table id="dataTable" class="table text-center display" style="width:100%"><thead><tr id="mainRow">';
        for($i=0; $i<sizeof($headers); $i++)
        {
            echo '<th scope="col"  class="text-center">'.$headers[$i].'</th>';
        }
        echo '<th scope="col" class="d-none d-print-table-cell">-</th>';
        echo '</tr></thead><tbody>';
        for($i=0; $i<sizeof($data); $i++)
        {
            echo('<tr>');
            for($j=0; $j<sizeof($headers); $j++)
            {
                if($i!=0&&in_array($j, $antyReapet))
                    if($j==$antyReapet[0])
                        if($data[$i-1][$j]==$data[$i][$j])
                            echo '<td>╍</td>';
                        else
                            echo '<td>'.$data[$i][$j].'</td>';
                    else
                        if($data[$i-1][$antyReapet[0]]==$data[$i][$antyReapet[0]])
                        {
                            if($data[$i-1][$j]==$data[$i][$j])
                                echo '<td>╍</td>';
                            else
                                echo '<td>'.$data[$i][$j].'</td>';
                        }
                        else
                            echo '<td>'.$data[$i][$j].'</td>';
                else
                    echo '<td>'.$data[$i][$j].'</td>';
            }
            echo '<td class="d-none d-print-table-cell">◻</td>';
            echo('</tr>');
        }
        echo '</tbody></table>';
  }
function generateSortTableScript(){
    echo '<script>
    var table = $("#dataTable").DataTable({
        language: {
            url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/pl.json",
        },
        paging: false,
        "order": []
    });
    $(document).ready(function() {
    document.getElementById("dataTable_filter").classList.add("d-print-none");
    document.getElementById("dataTable_info").classList.add("d-print-none");
    });
    </script>';
}