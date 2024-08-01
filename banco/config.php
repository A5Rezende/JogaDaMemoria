<?php
    $sname = "localhost";
    $uname = "root";
    $pwd = "";
    $dbname = "memory_game";

    try {
        $conn = new PDO("mysql:host=$sname;dbname=" . $dbname, $uname, $pwd);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $ex) {
        echo "Connection failed: " . $ex->getMessage();
    }
?>