<?php
include_once 'dbTools.php';
session_start();

?>

<!--http://localhost:8080/elektroniczna%20rejestracja/index.php-->

<!DOCTYPE html>
<html lang="pl">
<head>
    <title>Elektroniczna rejestracja na studia</title>
    <meta charset="utf-8">
    <LINK href="style.css" rel="stylesheet" type="text/css">
</head>

<?php
    if(isset($_POST['login']) && isset($_POST['password'])){
        $login = $_POST['login'];
        $pass = $_POST['password'];
        $dbTools = new dbTools();
        $db = $dbTools->select("SELECT prawo_dostepu, haslo, pesel FROM uzytkownicy WHERE login = '$login'");
        foreach ($db as $key=>$value){
            if(isset($value['pesel'])){
                $_SESSION['pesel'] = $value['pesel'];
            }
            if($value['haslo'] == $pass && $value['prawo_dostepu'] == 1){//admin
                unset($_SESSION['pesel']);
                header("Location: wybierz_dzialanie.php");
            }
            else if($value['haslo'] == $pass && $value['prawo_dostepu'] == 2){//uzytkownik
                header("Location: edytuj_uzytkownika.php");
            }
            echo $value['haslo'];
            echo $value['prawo_dostepu'];
        }
    }

?>

<body bgcolor="#333333">
<div id="container">
    <div id="title">
        <h1>Elektroniczna rejestracja na studia</h1>
    </div>
    <div id="center">
        <form method="post">
            <table  style="margin: auto">
                <tr>
                    <th>
                        <label>Login: </label>
                    </th>
                    <th>
                        <input name="login" type="text">
                    </th>
                </tr>
                <tr>
                    <th>
                        <label>Hasło: </label>
                    </th>
                    <th>
                        <input name="password" type="password">
                    </th>
                </tr>
                <tr>
                    <th>
                        <input name="signIn" type="submit" value="Zaloguj">
                    </th>
                    <th>
                        <button name="signUp" type="button" onclick="location.href='zarejestruj.php'">Zarejestruj</button>
                    </th>
                </tr>
            </table>
        </form>
    </div>
    <div id="footer">
        <p>Produkcja Grzegorz Krzeszowski</p>
    </div>
</div>
</body>
