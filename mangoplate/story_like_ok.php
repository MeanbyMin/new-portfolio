<?php
    session_start();
    include "./include/dbconn.php";
    include "./include/sessionCheck.php";
    include "./include/getIdxCheck.php";

    $ms_idx = $_GET['ms_idx'];

    if($conn){
        $sql = "UPDATE mango_restaurant SET r_wannago = r_wannago + 1 WHERE r_idx = '$r_idx'";
        $result = mysqli_query($conn, $sql);

        $sql = "SELECT r_wannago FROM mango_restaurant WHERE r_idx = '$r_idx'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);
        echo $row['r_wannago'];
    }else{
        echo "데이터베이스 연결 실패!";
    }
?>