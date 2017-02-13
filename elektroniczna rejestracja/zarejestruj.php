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
    <!--<meta name="viewport" content="width=device-width, initial-scale=1">-->
    <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>-->
    <!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->

</head>
<body bgcolor="#333333">




<?php

$isgood = true;
if(isset($_POST["login"])){
    if(empty($_POST["login"])){
        $isgood = false;
        $_SESSION['err_login'] = 'Login jest wymagany';
    }
}
if(isset($_POST["password"])){
    if(empty($_POST["password"])){
        $isgood = false;
        $_SESSION['err_password'] = 'Haslo jest wymagane';
    }
    if(isset($_POST['password2']) && $_POST['password'] != $_POST['password2']){
        $isgood = false;
        $_SESSION['err_password2'] = 'Hasla musza byc identyczne';
    }
}
if(isset($_POST['imie'])){
    if(empty($_POST['imie'])){
        $isgood = false;
        $_SESSION['err_imie'] = 'Imie jest wymagany';
    }
    elseif (!preg_match("/^[A-Z][a-z]+$/", $_POST['imie'])){
        $isgood = false;
        $_SESSION['err_imie'] = "Imie może składać się tylko z liter.<br>Pierwsza litera musi być duża";
    }
}

if(isset($_POST['nazwisko'])){
    if(empty($_POST['nazwisko'])){
        $isgood = false;
        $_SESSION['err_nazwisko'] = 'Nazwisko jest wymagany';
    }
    elseif (!preg_match("/^[A-Z][a-z]+$/", $_POST['nazwisko'])){
        $isgood = false;
        $_SESSION['err_nazwisko'] = "Nazwisko może składać się tylko z liter. <br>Pierwsza litera musi być duża";
    }
}
if(isset($_POST['pesel'])){
    if(empty($_POST['pesel'])){
        $isgood = false;
        $_SESSION['err_pesel'] = 'Pesel jest wymagany';
    }
    elseif (!preg_match("/^[0-9]{11}$/", $_POST['pesel'])){
        $isgood = false;
        $_SESSION['err_pesel'] = 'Pesel musi sie skladac z 11 cyfr';
    }
}
if(isset($_POST['miasto'])){
    if(empty($_POST['miasto'])){
        $isgood = false;
        $_SESSION['err_miasto'] = 'Miasto jest wymagane';
    }
}
if(isset($_POST['ulica'])){
    if (empty($_POST['ulica'])){
        $isgood = false;
        $_SESSION['err_ulica'] = 'Ulica jest wymagana';
    }
}
if(isset($_POST['kod_pocztowy'])){
    if(empty($_POST['kod_pocztowy'])){
        $_SESSION['err_kod_pocztowy'] = 'Kod pocztowy jest wymagany';
    }
    elseif (!preg_match("/^[0-9]{2}-[0-9]{3}$/", $_POST['kod_pocztowy'])){
        $_SESSION['err_kod_pocztowy'] = 'Kod pocztowy musi być w formie xx-xxx gdzie x jest cyfrą';
    }
}
if(isset($_POST['nr_budynku'])){
    if(empty($_POST['nr_budynku'])){
        $_SESSION['err_nr_budynku'] = 'Numer budynku jest wymagany';
    }
}
if(isset($_POST['nr_lokalu'])){
    if(empty($_POST['nr_lokalu'])){
        $_SESSION['err_nr_lokalu'] = 'Numer lokalu jest wymagany';
    }
}



if($isgood == true && isset($_POST['login'])){
    $dbTools = new dbTools();

    //uzytkownicy
    $imie = $_POST['imie'];
    $nazwisko = $_POST['nazwisko'];
    $pesel = $_POST['pesel'];
    $login = $_POST['login'];
    $haslo = $_POST["password"];
    $_SESSION['pesel'] = $pesel;

    //adresy
    $miasto = $_POST['miasto'];
    $ulica = $_POST['ulica'];
    $kodPocztowy = $_POST['kod_pocztowy'];
    $nrBudynku = $_POST['nr_budynku'];
    $nrLokalu = $_POST['nr_lokalu'];
    $dbTools->insert("INSERT INTO uzytkownicy VALUES('$imie', '$nazwisko', '$pesel', '$login', '$haslo')");
    $dbTools->insert("INSERT INTO adresy values('$miasto', '$ulica', '$kodPocztowy', '$nrBudynku', '$nrLokalu', '$pesel')");
    header("Location: wyniki_matur.php");
}





?>


<div id="container">
    <div id="title">
        <h1>Elektroniczna rejestracja na studia</h1>
    </div>
    <!--    <div id="left">-->
    <!--        Lorem ipsum dolor sit amet enim. Etiam ullamcorper. Suspendisse a pellentesque dui, non felis. Maecenas malesuada elit lectus felis, malesuada ultricies. Curabitur et ligula. Ut molestie a, ultricies porta urna. Vestibulum commodo volutpat a, convallis ac, laoreet enim. Phasellus fermentum in, dolor. Pellentesque facilisis. Nulla imperdiet sit amet magna. Vestibulum dapibus, mauris nec malesuada fames ac turpis velit, rhoncus eu, luctus et interdum adipiscing wisi. Aliquam erat ac ipsum. Integer aliquam purus. Quisque lorem tortor fringilla sed, vestibulum id, eleifend justo vel bibendum sapien massa ac turpis faucibus orci luctus non, consectetuer lobortis quis, varius in, purus. Integer ultrices posuere cubilia Curae, Nulla ipsum dolor lacus, suscipit adipiscing. Cum sociis natoque penatibus et ultrices volutpat. Nullam wisi ultricies a, gravida vitae, dapibus risus ante sodales lectus blandit eu, tempor diam pede cursus vitae, ultricies eu, faucibus quis, porttitor eros cursus lectus, pellentesque eget, bibendum a, gravida ullamcorper quam. Nullam viverra consectetuer. Quisque cursus et, porttitor risus. Aliquam sem. In hendrerit nulla quam nunc, accumsan congue. Lorem ipsum primis in nibh vel risus. Sed vel lectus. Ut sagittis, ipsum dolor quam.-->
    <!--    </div>-->

    <div id="center">
        <form method="post" style="text-align: center">
            <div id="left">
                <label>
                    Login: <br><input type="text" name="login" placeholder="login" value="<?php if(isset($_POST["login"])) echo $_POST["login"]; ?>"><br>
                    <div class="hasError">
                        <?php if(isset($_SESSION['err_login'])){
                            echo $_SESSION['err_login'];
                            unset($_SESSION['err_login']);
                        } ?>
                    </div>
                </label>

                <label>
                    Hasło: <br><input type="password" name="password" placeholder="haslo" value="<?php if(isset($_POST["password"])) echo $_POST["password"]; ?>"><br>
                    <div class="hasError">
                        <?php if(isset($_SESSION['err_password'])){
                            echo $_SESSION['err_password'];
                            unset($_SESSION['err_password']);
                        } ?>
                    </div>
                </label>
                <label>
                    Powtórz hasło: <br><input type="password" name="password2" placeholder="powtórz haslo" value="<?php if(isset($_POST["password2"])) echo $_POST["password2"]; ?>">
                    <div class="hasError">
                        <?php if(isset($_SESSION['err_password2'])){
                            echo $_SESSION['err_password2'];
                            unset($_SESSION['err_password2']);
                        } ?>
                    </div>
                    Miasto:<br>
                    <input type="text" name="miasto" placeholder="Miasto zamieszkania" value="<?php if(isset($_POST['miasto'])) echo $_POST['miasto']; ?>"/><br>
                    <div class="hasError">
                        <?php if (isset($_SESSION['err_miasto']))
                            echo $_SESSION['err_miasto'];
                        unset($_SESSION['err_miasto']); ?>
                    </div>
                    Ulica:<br>
                    <input type="text" name="ulica" placeholder="Ulica" value="<?php if(isset($_POST['ulica'])) echo $_POST['ulica']; ?>" /><br>
                    <div class="hasError">
                        <?php if (isset($_SESSION['err_ulica']))
                            echo $_SESSION['err_ulica'];
                        unset($_SESSION['err_ulica']); ?>
                    </div>
                    Kod pocztowy: <br>
                    <input type="text" name="kod_pocztowy" placeholder="Kod-pocztowy" value="<?php if(isset($_POST['kod_pocztowy'])) echo $_POST['kod_pocztowy']; ?>"/><br>
                    <div class="hasError">
                        <?php if (isset($_SESSION['err_kod_pocztowy']))
                            echo $_SESSION['err_kod_pocztowy'];
                        unset($_SESSION['err_kod_pocztowy']); ?>
                    </div>
                </label>
                <input type="submit" value="Zarejestruj">

            </div>
            <div id="right">
                <label>
                    Imię: <br><input type="text" name="imie" placeholder="imie" value="<?php if(isset($_POST["imie"])) echo $_POST["imie"]; ?>"><br>
                    <div class="hasError">
                        <?php if (isset($_SESSION['err_imie']))
                            echo $_SESSION['err_imie'];
                        unset($_SESSION['err_imie']); ?>
                    </div>
                    Nazwisko: <br><input type="text" name="nazwisko" placeholder="nazwisko" value="<?php if(isset($_POST["nazwisko"])) echo $_POST["nazwisko"];?>"<br>
                    <div class="hasError">
                        <?php if (isset($_SESSION['err_nazwisko']))
                            echo $_SESSION['err_nazwisko'];
                        unset($_SESSION['err_nazwisko']); ?>
                    </div>
                    Pesel: <br><input type="text" name="pesel" placeholder="pesel" value="<?php if(isset($_POST["pesel"])) echo $_POST["pesel"];?>"<br>
                    <div class="hasError">
                        <?php if (isset($_SESSION['err_pesel']))
                            echo $_SESSION['err_pesel'];
                        unset($_SESSION['err_pesel']); ?>
                    </div>

                    Numer budynku: <br>
                    <input type="number" name="nr_budynku" placeholder="Numer budynku" value="<?php if(isset($_POST['nr_budynku'])) echo $_POST['nr_budynku']; ?>"/><br>
                    <div class="hasError">
                        <?php if (isset($_SESSION['err_nr_budynku']))
                            echo $_SESSION['err_nr_budynku'];
                        unset($_SESSION['err_nr_budynku']); ?>
                    </div>
                    Numer lokalu: <br>
                    <input type="number" name="nr_lokalu" placeholder="Numer lokalu" value="<?php if (isset($_POST['nr_lokalu'])) echo $_POST['nr_lokalu']; ?>"/><br>
                    <div class="hasError">
                        <?php if (isset($_SESSION['err_nr_lokalu']))
                            echo $_SESSION['err_nr_lokalu'];
                        unset($_SESSION['err_nr_lokalu']); ?>
                    </div>



                </label>
            </div>
        </form>
    </div>
    <!--    <div id="right">-->
    <!--        Lorem ipsum dolor sit amet enim. Etiam ullamcorper. Suspendisse a pellentesque dui, non felis. Maecenas malesuada elit lectus felis, malesuada ultricies. Curabitur et ligula. Ut molestie a, ultricies porta urna. Vestibulum commodo volutpat a, convallis ac, laoreet enim. Phasellus fermentum in, dolor. Pellentesque facilisis. Nulla imperdiet sit amet magna. Vestibulum dapibus, mauris nec malesuada fames ac turpis velit, rhoncus eu, luctus et interdum adipiscing wisi. Aliquam erat ac ipsum. Integer aliquam purus. Quisque lorem tortor fringilla sed, vestibulum id, eleifend justo vel bibendum sapien massa ac turpis faucibus orci luctus non, consectetuer lobortis quis, varius in, purus. Integer ultrices posuere cubilia Curae, Nulla ipsum dolor lacus, suscipit adipiscing. Cum sociis natoque penatibus et ultrices volutpat. Nullam wisi ultricies a, gravida vitae, dapibus risus ante sodales lectus blandit eu, tempor diam pede cursus vitae, ultricies eu, faucibus quis, porttitor eros cursus lectus, pellentesque eget, bibendum a, gravida ullamcorper quam. Nullam viverra consectetuer. Quisque cursus et, porttitor risus. Aliquam sem. In hendrerit nulla quam nunc, accumsan congue. Lorem ipsum primis in nibh vel risus. Sed vel lectus. Ut sagittis, ipsum dolor quam.-->
    <div id="footer">
        <p>Produkcja Grzegorz Krzeszowski</p>
    </div>
</div>



</body>
</html>