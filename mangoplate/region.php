<?php
    header('Content-Type: text/html; charset=UTF-8');
    session_start();
    include "./include/dbconn.php"; //php 파일 삽입

    $data = $_GET['data'];
    $sql = "SELECT $data FROM mango_region";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    echo ($row[$data]);
?>