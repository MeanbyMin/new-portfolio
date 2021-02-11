<?php
    header('Content-Type: text/html; charset=UTF-8');
    session_start();
    include "../include/dbconn.php";
    include "../include/sessionCheck.php";

    $re_boardidx    = $_GET['re_boardidx'];
    $re_idx         = $_GET['re_idx'];

    $sql = "DELETE FROM min_reply WHERE re_idx='$re_idx'";
    $result = mysqli_query($conn, $sql);

    // echo $sql;
    echo "<script>alert('삭제되었습니다.'); location.href='view.php?b_idx=".$re_boardidx."';</script>";
?>