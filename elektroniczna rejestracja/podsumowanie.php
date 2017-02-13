<?php
session_start();
include_once 'dbTools.php';

$dbTools = new dbTools();
if(/*isset($_SESSION['pesel'])*/TRUE){
    $pesel = '94031612657';//$_SESSION['pesel'];
    $daneUzytkownika = $dbTools->select("SELECT imie, nazwisko, uzytkownicy.pesel, login FROM uzytkownicy where pesel = '$pesel'");
    $adresUzytkownika = $dbTools->select("SELECT miasto, ulica, kod_pocztowy, nr_budynku, nr_lokalu FROM adresy WHERE pesel = '$pesel'");
    $wynikiMatury = $dbTools->select("SELECT pesel, wynik, nazwa_przedmiotu from wyniki_matury, przedmioty 
                                    where pesel = '$pesel' and wyniki_matury.id_przedmiotu = przedmioty.id_przedmioty;");
    $kierunkiWydzialyUzytkownika = $dbTools->select("
            SELECT nazwa_wydzialu, nazwa_kierunku, opis, miasto, ulica, kod_pocztowy, nr_budynku
            FROM wydzialy
            RIGHT JOIN (SELECT kierunki.id_wydzialu, nazwa_kierunku, opis
              FROM uzytkownicy_kierunki, kierunki
              WHERE pesel = '$pesel' and uzytkownicy_kierunki.id_kierunku = kierunki.id_kierunku) 
            as tab3 on tab3.id_wydzialu=wydzialy.id_wydzialu");
}
//SELECT nazwa_wydzialu, nazwa_kierunku, opis, miasto, ulica, kod_pocztowy, nr_budynku
// FROM wydzialy
// RIGHT JOIN (SELECT kierunki.id_wydzialu, nazwa_kierunku, opis
//  FROM uzytkownicy_kierunki, kierunki
//  WHERE pesel = '94031612657' and uzytkownicy_kierunki.id_kierunku = kierunki.id_kierunku) as tab3
// on tab3.id_wydzialu=wydzialy.id_wydzialu

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <title>Elektroniczna rejestracja na studia</title>
    <meta charset="utf-8">
    <LINK href="style.css" rel="stylesheet" type="text/css">

</head>

<body bgcolor="#333333">
<script>
function myFunction() {
    location.href='index.php'
    alert("Rejestracja została zakończona");
}
</script>
<div id="container">
    <div id="title">
        <h1>Elektroniczna rejestracja na studia</h1>
    </div>
    <div id="center">
        <div id="left">
            <?php
                echo "<table>";
            foreach ($daneUzytkownika as $value){
                foreach ($value as $key => $v){
//                echo $key."=>".$v."<br>";
                    echo "<tr>
                        <th><label>$key</label></th>
                        <th><input readonly='readonly' value='$v'></th>
                    </tr>";
                }
            }
            foreach ($adresUzytkownika as $value){
                foreach ($value as $key => $v){
//                echo $key."=>".$v."<br>";
                    echo "<tr>
                        <th><label>$key</label></th>
                        <th><input readonly='readonly' value='$v'></th>
                    </tr>";
                }
            }
            echo "</table>"
            ?>
        </div>
        <div id="right">
            <?php
            echo "<table>";
            foreach ($kierunkiWydzialyUzytkownika as $value){
                foreach ($value as $key => $v){
//                echo $key."=>".$v."<br>";
                    echo "<tr>
                        <th><label>$key</label></th>
                        <th><input readonly='readonly' value='$v'></th>
                    </tr>";
                }
            }
            echo "</table>"
            ?>
            <button type="submit" onclick="myFunction()">Zapisz</button>

        </div>

    </div>
    <div id="footer">
        <p>Produkcja Grzegorz Krzeszowski</p>
    </div>
</div>
</body>
