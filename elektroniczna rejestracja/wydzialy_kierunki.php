<?php
/**
 * Created by IntelliJ IDEA.
 * User: grzegorz
 * Date: 27.12.16
 * Time: 20:27
 */
session_start();
include_once 'dbTools.php';
?>

<!DOCTYPE html>
<html lang="pl">
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
<head>
    <title>Elektroniczna rejestracja na studia</title>
    <meta charset="utf-8">
    <LINK href="style.css" rel="stylesheet" type="text/css">
</head>

<body bgcolor="#333333">

<?php


$nazwa_wydzialu = 'nazwa_wydzialu';

$dbTools = new dbTools();
//if(!empty($_POST)){
//    echo "foo<br>";
//
//}

//foreach ($_POST as $key=>$value){
//    echo $key."=>".$value."<br>";
//}

if (isset($_POST['nazwa_kierunku']) && $_POST['id_kierunku'] != 0 && isset($_POST['opis'])) {
    $nazwa_kierunku = $_POST['nazwa_kierunku'];
    $opis = $_POST['opis'];
    $id_kierunku = $_POST['id_kierunku'];
    $dbTools->insert("UPDATE kierunki SET nazwa_kierunku = '$nazwa_kierunku', opis = '$opis' WHERE id_kierunku = $id_kierunku");
//    header("Refresh:0");
}

if (isset($_POST['nazwa_wydzialu'])) {
    $nazwa_wydzialu = $_POST['nazwa_wydzialu'];
    $id_wydzialu = $_POST['id_wydzialu'];
    $miasto = $_POST['miasto'];
    $kod_pocztowy = $_POST['kod_pocztowy'];
    $nr_budynku = $_POST['nr_budynku'];
    $dbTools->insert("UPDATE wydzialy SET nazwa_wydzialu = '$nazwa_wydzialu', miasto = '$miasto', kod_pocztowy = '$kod_pocztowy', nr_budynku='$nr_budynku' WHERE id_wydzialu = $id_wydzialu");
//    header("Refresh:0");

}
?>


<div id="container" ng-app="myApp" ng-controller="myController">

    <div id="getWydzialy" style="display: none">
        <?php
        $output = null;
        $arrWydzialy = $dbTools->select("Select * From wydzialy order by id_wydzialu;");
        foreach ($arrWydzialy as $key => $wydzial) {
            $output[$key] = $wydzial;
            $id = $wydzial['id_wydzialu'];
            $arrKierunki = $dbTools->select("Select * From kierunki where '$id ' = id_wydzialu;");
            $output[$key]['kierunki'] = [];

            foreach ($arrKierunki as $kierunki) {
                array_push($output[$key]['kierunki'], ['kierunek' => $kierunki['nazwa_kierunku'],
                    'opis' => $kierunki['opis'],
                    'id_kierunku' => $kierunki['id_kierunku']]);
            }
        }
        // [$key => ['id_wydzialu' => int, ... 'kierunki' => [] ]]
        ?>
    </div>

    <div id="title">
        <h1>Elektroniczna rejestracja na studia</h1>
    </div>

    <div id="center">
        <form method="post" style="text-align: center">
            <div id="left">
                <label>Wydziały</label>
                <select name="wydzialy" style="min-width:90%"
                        ng-options="wydzial as wydzial.nazwa_wydzialu for wydzial in sqlDataArray track by wydzial.id_wydzialu"
                        ng-model="wybranyWydzial" ></select>
                <table>
                    <tr>
                        <th><label>nazwa wydzialu</label></th>
                        <th><input type="text" value="nazwa wydzialu" ng-model="wybranyWydzial.nazwa_wydzialu"
                                   /></th>
                    </tr>
                    <tr>
                        <th><label>Miasto</label></th>
                        <th><input type="text" value="miasto" ng-model="wybranyWydzial.miasto" />
                        </th>
                    </tr>
                    <tr>
                        <th><label>ulica</label></th>
                        <th><input type="text" value="ulica" ng-model="wybranyWydzial.ulica" /></th>
                    </tr>
                    <tr>
                        <th><label>kod pocztowy</label></th>
                        <th><input type="text" value="kod pocztowy" ng-model="wybranyWydzial.kod_pocztowy"
                                   /></th>
                    </tr>
                    <tr>
                        <th><label>numer budynku</label></th>
                        <th><input type="text" value="numer budynku" ng-model="wybranyWydzial.nr_budynku"/><br></th>
                    </tr>
                </table>
                <!--                <button type="submit" onclick="location.href='wyniki_matur.php'">Cofnij</button>-->

            </div>
            <div id="right">

                <label>Kierunki</label><br>
                <select name="kierunek" style="min-width:90%"
                        ng-model="wybranyKierunek"
                        ng-options="kierunki as kierunki.kierunek for kierunki in wybranyWydzial.kierunki track by kierunki.id_kierunku">
                </select><br>
                <label>Kierunek</label>
                <input type="text" value="nazwa_kierunku" ng-model="wybranyKierunek.kierunek"/><br>
                <label>Opis:</label>
                <textarea value="opis" rows="7" cols="50" ng-model="wybranyKierunek.opis">
                    {{kieruneki.opis}}
                </textarea>



                <input  type="submit" ng-click="check_credentials()" value="Zapisz">
            </div>

        </form>
    </div>
    <div id="footer">
        <p>Produkcja Grzegorz Krzeszowski</p>
    </div>

</div>

</body>

<script>
    var app = angular.module('myApp', []);
    app.controller('myController', function($scope, $http, $window){

<!--         wydzialOnChange = function(){-->
<!--            angular.element(document.querySelector('[ng-controller="myController"]')).scope().wybranyKierunek = angular.element(document.querySelector('[ng-controller="myController"]')).scope().wybranyWydzial.kierunki[0];-->
<!--         }-->


        $.extend(
        {
            redirectPost: function(location, args)
            {
                var form = '';
                $.each( args, function( key, value ) {
                    value = value.toString().split('"').join('\"')
                    form += '<input type="hidden" name="'+key+'" value="'+value+'">';
                });
                $('<form action="' + location + '" method="POST">' + form + '</form>').appendTo($(document.body)).submit();
            }
        });



         $scope.check_credentials = function(){
            var url = 'http://localhost:8080/elektroniczna%20rejestracja/wydzialy_kierunki.php';
            $.redirectPost(url, {
                id_wydzialu: $scope.wybranyWydzial.id_wydzialu,
                nazwa_wydzialu: $scope.wybranyWydzial.nazwa_wydzialu,
                miasto: $scope.wybranyWydzial.miasto,
                kod_pocztowy: $scope.wybranyWydzial.kod_pocztowy,
                nr_budynku: $scope.wybranyWydzial.nr_budynku,
                id_kierunku: $scope.wybranyKierunek.id_kierunku,
                nazwa_kierunku: $scope.wybranyKierunek.kierunek,
                opis: $scope.wybranyKierunek.opis,
            });
         }

        $scope.sqlDataArray = <?php echo json_encode($output)?>;

        for (var i = 0 ; i < $scope.sqlDataArray.length; i++){
        $scope.sqlDataArray[i].kierunki = [{kierunek : "wybierz kierunek", id_kierunku: 0, opis: ""}].concat($scope.sqlDataArray[i].kierunki);
        }

        $scope.wybranyWydzial = $scope.sqlDataArray[0];

        $scope.kierunki = ($scope.wybranyWydzial.kierunki);
        $scope.wybranyKierunek = $scope.kierunki[0];

    });


</script>