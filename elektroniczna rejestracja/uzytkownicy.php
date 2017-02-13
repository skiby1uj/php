<?php
session_start();
include_once 'dbTools.php';

$dbTools = new dbTools();


if(isset($_POST['sort'])){
    echo "sortowanie";
    $sort = $_POST['sort'];
    $uzytkownicy = $dbTools->select("SELECT imie, nazwisko, uzytkownicy.pesel, login, miasto, ulica, kod_pocztowy, nr_budynku, nr_lokalu 
                                  FROM uzytkownicy, adresy WHERE uzytkownicy.pesel = adresy.pesel ORDER BY $sort;
");
}
else{
    $uzytkownicy = $dbTools->select("SELECT imie, nazwisko, uzytkownicy.pesel, login, miasto, ulica, kod_pocztowy, nr_budynku, nr_lokalu 
                                  FROM uzytkownicy, adresy WHERE uzytkownicy.pesel = adresy.pesel ORDER BY imie;
");
}

?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <title>Elektroniczna rejestracja na studia</title>
    <meta charset="utf-8">
    <LINK href="style.css" rel="stylesheet" type="text/css">

</head>

<body bgcolor="#333333">
<div id="container">
    <div id="title">
        <h1>Elektroniczna rejestracja na studia</h1>
    </div>
    <div id="center">
        <form method="post" action="edytuj_uzytkownika.php">
            <label>Pesel</label>
            <input name="pesel" placeholder="Podaj pesel do edycji uzytkownika">
            <input type="submit" value="Edytuj"><br>


        </form>

        <form method="post">
            <label>Sortowanie: </label>
            <input type="radio" name="sort" value="imie" checked><label>Po imieniu: </label>
            <input type="radio" name="sort" value="nazwisko" <?php if(isset($_POST['sort']) && $_POST['sort'] == 'nazwisko') echo "checked";?>><label>Po nazwisku:</label>
            <input type="radio" name="sort" value="pesel" <?php if(isset($_POST['sort']) && $_POST['sort'] == 'pesel') echo "checked";?>><label>Po peselu:</label>
            <input type="radio" name="sort" value="login" <?php if(isset($_POST['sort']) && $_POST['sort'] == 'login') echo "checked";?>><label>Po loginie:</label>
            <input type="radio" name="sort" value="miasto" <?php if(isset($_POST['sort']) && $_POST['sort'] == 'miasto') echo "checked";?>><label>Po miescie:</label>
            <input type="radio" name="sort" value="ulica" <?php if(isset($_POST['sort']) && $_POST['sort'] == 'ulica') echo "checked";?>><label>Po ulicy:</label>
            <input type="submit" value="sortuj">
        </form>


        <div style="height:400px; overflow:scroll">



            <table>
                <th>imie</th>
                <th>nazwisko</th>
                <th>pesel</th>
                <th>login</th>
                <th>miasto</th>
                <th>ulica</th>
                <th>kod_pocztowy</th>
                <th>nr_budynku</th>
                <th>nr_lokalu</th>
                <?php
            foreach ($uzytkownicy as $value){
                echo "<tr>";
                foreach ($value as $key => $v){
//                echo $key."=>".$v."<br>";
                    echo "<td style='white-space: nowrap'><input readonly='readonly' value='$v'></td>";
                }
                echo "</tr>";
            }
            ?>
            </table>
        </div>
        <button type="button" onclick="location.href='wybierz_dzialanie.php'">Powrót</button>


    </div>
    <div id="footer">
        <p>Produkcja Grzegorz Krzeszowski</p>
    </div>
</div>
</body>
