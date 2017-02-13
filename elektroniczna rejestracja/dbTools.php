<?php

/**
 * Created by IntelliJ IDEA.
 * User: grzegorz
 * Date: 27.01.17
 * Time: 22:59
 */
class dbTools
{
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "rekrutacja";

    function __construct() {}

    public function dbConnect(){
        $dbConnect = new mysqli($this->servername, $this->username, $this->password, $this->dbname);//polaczenie przez dbTools nie dziala nie wiem czemu
        return $dbConnect;
    }

    public function insert($query){
        $dbConnect = $this->dbConnect();
//        if(isset($dbConnect)){
//            echo 'dbConnect is set'."<br>";
//        }
//        echo $query.PHP_EOL;
        if(mysqli_query($dbConnect, $query)){
//            echo 'dodano nowego uzytkownika'."<br>";
        }
        else{
//            echo 'Nie udało się dodać nowego użytkownika'."<br>";
//            die("Error nie dodano uzytkownika");
        }
        mysqli_close($dbConnect);
    }

    public function select($query){
        $dbConnect = $this->dbConnect();
        $output = $dbConnect->query($query);
        mysqli_close($dbConnect);
        return $output;
    }
}