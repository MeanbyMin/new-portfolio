<?php
    header('Content-Type: text/html; charset=UTF-8');
    session_start();
    include "./include/dbconn.php";
    include "./include/adminsessionCheck.php";
    include "./include/msIdxCheck.php";

    $ms_idx = $_GET['ms_idx'];
    $sql = "DELETE FROM mango_story WHERE ms_idx = $ms_idx";
    $result = mysqli_query($conn, $sql);
    echo "<script>alert('삭제되었습니다.'); location.href='./MangoStory.php';</script>"
?>