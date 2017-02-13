<?php
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
<div id="container">
    <div id="title">
        <h1>Elektroniczna rejestracja na studia</h1>
    </div>
    <div id="center">
        <table style="margin: auto">
            <tr>
                <th>
                    <button onclick="location.href='uzytkownicy.php'">Pokaz uzytkownikow</button>
                </th>
                <th>
                    <button onclick="location.href='wydzialy_kierunki.php'">Pokaz wydzialy i kierunki</button>
                </th>
            </tr>
        </table>

    </div>
    <div id="footer">
        <p>Produkcja Grzegorz Krzeszowski</p>
    </div>
</div>
</body>
