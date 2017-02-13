<?php
session_start();
include_once 'dbTools.php';

$dbTools = new dbTools();

$pesel = null;
$isUser = false;
if(!isset($_POST['pesel']) && !empty($_SESSION['pesel'])){
    $pesel = $_SESSION['pesel'];
    $isUser = true;
}

if(isset($_POST['pesel']) || isset($pesel)){
    if(isset($_POST['pesel'])){
        $pesel = $_POST['pesel'];
    }
//    echo $pesel;
    $daneUzytkownika = $dbTools->select("SELECT imie, nazwisko, uzytkownicy.pesel, login FROM uzytkownicy where pesel = '$pesel'");
    $adresUzytkownika = $dbTools->select("SELECT miasto, ulica, kod_pocztowy, nr_budynku, nr_lokalu FROM adresy WHERE pesel = '$pesel'");

}

if(isset($_POST['imie'])){//edycja uzytkownika
//    $pesel = $_POST['pesel'];
    $updateString = "UPDATE uzytkownicy SET ";
    foreach ($_POST as $key=>$value){
//        $updateString = $updateString." ".$key."=".$value.", ";
        $updateString .= " $key = '$value', ";
    }
    $updateString = preg_replace('/[,][ ]$/', " ", $updateString);
    $updateString .= "WHERE pesel = '$pesel';";
//    echo $updateString;
    $_SESSION['pesel'] = $pesel;
    $daneUzytkownika = $dbTools->select($updateString);
    header("Refresh:0");

}
else if(isset($_POST['miasto'])){//edycja adresu
//    $pesel = $_POST['pesel'];
    $_SESSION['pesel'] = $pesel;
//    echo $pesel;
    $updateString = "UPDATE adresy SET ";
    foreach ($_POST as $key=>$value){
//        $updateString = $updateString." ".$key."=".$value.", ";
        $updateString .= " $key = '$value', ";
    }
    $updateString = preg_replace('/[,][ ]$/', " ", $updateString);
    $updateString .= "WHERE pesel = '$pesel';";
    echo $updateString;

    $daneUzytkownika = $dbTools->select($updateString);
    header("Refresh:0");
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
        <div id="left">
            <form method="post">
                <table>
                <?php
                foreach ($daneUzytkownika as $value){
                    foreach ($value as $key => $v){
    //                echo $key."=>".$v."<br>";
                        echo "<tr>
                            <th><label>$key</label></th>
                            <th><input name='$key' value='$v'></th>
                        </tr>";
                    }
                }
                ?>
                </table>
                <input type="submit" value="Update danych osobowych">
            </form>
        </div>
        <div id="right">
            <form method="post">
                <table>
                    <?php
                    foreach ($adresUzytkownika as $value){
                        foreach ($value as $key => $v){
                            echo "<tr>
                        <th><label>$key</label></th>
                        <th><input name='$key' value='$v'></th>
                    </tr>";
                        }
                    }
                    ?>
                </table>
                <input type="submit" value="Update danych adresowych">
            </form>
            <button type="button" onclick="<?php if($isUser){ echo "location.href='index.php'"; }else {echo "location.href='uzytkownicy.php'";}?>">Powrót</button>
        </div>

    </div>
    <div id="footer">
        <p>Produkcja Grzegorz Krzeszowski</p>
    </div>
</div>
</body>
