<?php
    session_start();
    include "./include/dbconn.php";
    include "./include/sessionCheck.php";
    include "./include/msIdxCheck.php";

    $ms_idx = $_GET['ms_idx'];

    if($conn){
        $sql = "UPDATE mango_story SET ms_like = ms_like + 1 WHERE ms_idx = '$ms_idx'";
        $result = mysqli_query($conn, $sql);

        $sql = "SELECT ms_like FROM mango_story WHERE ms_idx = '$ms_idx'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);
        echo $row['ms_like'];
    }else{
        echo "데이터베이스 연결 실패!";
    }
?>