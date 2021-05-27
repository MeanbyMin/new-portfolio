<?php
    header('Content-Type: text/html; charset=UTF-8');
    session_start();
    include "./include/dbconn.php";

    $r_idx = $_POST['r_idx'];
    $sql = "SELECT r_menuphoto FROM mango_restaurant WHERE r_idx = '$r_idx'";
    $result = mysqli_query($conn, $sql);
    $row  = mysqli_fetch_array($result);

    echo $row['r_menuphoto']
?>