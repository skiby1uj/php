<?php
/**
 * Created by IntelliJ IDEA.
 * User: grzegorz
 * Date: 27.12.16
 * Time: 20:23
 */

session_start();
include_once 'dbTools.php';
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <title>Elektroniczna rejestracja na studia</title>
    <meta charset="utf-8">
    <LINK href="style.css" rel="stylesheet" type="text/css">
</head>

<body bgcolor="#333333">

<?php

$nazwa_przedmiotu = 'nazwa_przedmiotu';
$id_przedmioty = 'id_przedmioty';

$dbTools = new dbTools();
$arrPrzedmioty = $dbTools->select("Select * From przedmioty;");

if(isset($_SESSION['pesel'])){
    $count = $dbTools->select("SELECT count(*) FROM przedmioty");
    $pesel = $_SESSION["pesel"];
    $isGood = false;

    for($i = 1; $i <= $count; $i++){
        echo $_POST[$i];
        if (is_numeric($_POST[$i])){
            $isGood = true;
            $wynik = $_POST[$i];
            $insert = "INSERT INTO wyniki_matury VALUES('$pesel', '$i', '$wynik')";
            echo $insert;
            $dbTools->insert($insert);
        }
    }
    if($isGood){
    header("Location: wybor_kierunku.php");
    }
}
?>



<div id="container">
    <div id="title">
        <h1>Elektroniczna rejestracja na studia</h1>
    </div>

    <div id="center">

        <form method="post" style="text-align: center">
            <table style="margin: auto">
                <?php
                foreach ($arrPrzedmioty as $arrRzedmiotId){//nie wiem jak wyciagnac dane z tqablicy asocjacyjnej
                    echo "<tr><th><label>$arrRzedmiotId[$nazwa_przedmiotu]</label></th>".
                        "<th><input min='0' type='number' name='$arrRzedmiotId[$id_przedmioty]'></th></tr>";
                }
                ?>
            </table>
            <input type="submit" value="Zapisz">
        </form>
    </div>
    <div id="footer">
        <p>Produkcja Grzegorz Krzeszowski</p>
    </div>
</div>
</body>