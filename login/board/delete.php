<?php
    header('Content-Type: text/html; charset=UTF-8');
    session_start();
    include "../include/dbconn.php";
    include "../include/sessionCheck.php";

    $b_idx = $_GET['b_idx'];
    $sql = "DELETE FROM min_board WHERE b_idx=$b_idx";
    $result = mysqli_query($conn, $sql);
    echo "<script>alert('삭제되었습니다.'); location.href='list.php';</script>";
?>