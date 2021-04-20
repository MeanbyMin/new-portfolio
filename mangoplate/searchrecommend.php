<?php
    header('Content-Type: text/html; charset=UTF-8');

    include "./include/dbconn.php";
    $sql = "SELECT msr_recommend FROM mango_search";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    echo $row['msr_recommend'];
?>