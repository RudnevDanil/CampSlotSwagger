<?php
    $mysqli = new mysqli("localhost", "h96046yr__base", "HeL1UVYS", "h96046yr__base");

    // проверяем соединение
    if (mysqli_connect_errno() || !$mysqli) {
        echo "Connect failed: ", mysqli_connect_error();
        exit();
    }
?>