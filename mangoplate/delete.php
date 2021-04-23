<?php
    header('Content-Type: text/html; charset=UTF-8');
    session_start();
    include "./include/dbconn.php";
    include "./include/adminsessionCheck.php";
    include "./include/getIdxCheck.php";

    $r_idx = $_GET['r_idx'];
    $sql = "DELETE FROM mango_restaurant WHERE r_idx=$r_idx";
    $result = mysqli_query($conn, $sql);
    echo "<script>alert('삭제되었습니다.'); location.href='RestaurantList.php';</script>";
?>