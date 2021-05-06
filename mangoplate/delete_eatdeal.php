<?php
    header('Content-Type: text/html; charset=UTF-8');
    session_start();
    include "./include/dbconn.php";
    include "./include/adminsessionCheck.php";
    include "./include/edIdxCheck.php";

    $ed_idx = $_GET['ed_idx'];
    $sql = "DELETE FROM eat_deals WHERE ed_idx = $ed_idx";
    $result = mysqli_query($conn, $sql);
    echo "<script>alert('삭제되었습니다.'); location.href='./EatDeal.php';</script>"
?>