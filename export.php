<?php
//export.php  
include 'config.php';
$output = '';
if (isset($_POST["export"])) {
     $query = "SELECT * FROM student order by 1 desc";
     $result = mysqli_query($con, $query);
     if (mysqli_num_rows($result) > 0) {
          $output .= '
   <table class="table" bordered="1">  
                    <tr>  
                         <th>Redni broj</th>  
                         <th>Broj indeksa</th>  
                         <th>Ime studenta</th>  
                         <th>Ime oca</th>  
                         <th>Ime majke</th>  
                         <th>JMBG</th>
                         <th>Pol</th>  
                         <th>Datum rodjenja</th>
                         <th>Email</th>  
                         <th>Broj telefona</th>
                         <th>Napomena</th>  
                         <th>Adresa</th>
                         <th>ID sluzbenika</th>  
                         <th>Upisan</th>

                    </tr>
  ';
          $i = 0;
          while ($row = mysqli_fetch_array($result)) {
               $sl = ++$i;
               $output .= '
    <tr>  
                         <td > ' . $sl . ' </td>
                         <td>' . $row["broj_indeksa"] . '</td>  
                         <td>' . $row["ime_studenta"]  . $row["prezime_studenta"] . '</td>  
                         <td>' . $row["ime_oca"] . '</td>  
                         <td>' . $row["ime_majke"] . '</td>  
                         <td>' . $row["jmbg"] . '</td>  
                         <td>' . $row["pol"] . '</td> 
                         <td>' . $row["datum_rodjenja"] . '</td>  
                         <td>' . $row["email"] . '</td>  
                         <td>' . $row["broj_telefona"] . '</td> 
                         <td>' . $row["napomena"] . '</td>  
                         <td>' . $row["ulica"] . $row["opstina"] . $row["grad"] . $row["drzavljanstvo"] . $row["postanski_broj"] . '</td>  
                        <td>' . $row["id_sluzbenika"] . '</td>  
                        <td>' . $row["upisan"] . '</td>
                    </tr>
   ';
          }
          $output .= '</table>';
          header('Content-Type: application/xls');
          header('Content-Disposition: attachment; filename=StudentPodaci.xls');
          echo $output;
     }
}
