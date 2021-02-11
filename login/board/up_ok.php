<?php
    header('Content-Type: text/html; charset=UTF-8');
    session_start();
    include "../include/dbconn.php";
    include "../include/sessionCheck.php";

    $b_idx = $_GET['b_idx'];

    if(!$conn){
        echo "데이터베이스 연결 실패";
    }else{
        $sql = "UPDATE min_board SET b_up = b_up + 1 WHERE b_idx='$b_idx'";
        $result = mysqli_query($conn, $sql);

        $sql = "SELECT b_up FROM min_board WHERE b_idx='$b_idx'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);
        echo $row['b_up'];
    }
?>