<?php
    header('Content-Type: text/html; charset=UTF-8');
    session_start();
    include "./include/dbconn.php";
    include "./inlcude/mangosessionCheck.php";
    include "./include/getIdxCheck.php";

    $r_idx = $_POST['r_idx'];
    $mm_userid = $_POST['mm_userid'];

    if($conn){
        $sql = "UPDATE mango_restaurant SET r_wannago = r_wannago + 1 WHERE r_idx = '$r_idx'";
        $result = mysqli_query($conn, $sql);
        $sql = "SELECT r_wannago FROM mango_restaurant WHERE r_idx = '$r_idx'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);
        $sql = "SELECT mm_wannago FROM mango_member WHERE mm_userid = '$mm_userid'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);
        if($row['mm_wannago'] !== ""){
            $mm_wannago = $row['mm_wannago'];
            $mm_wannago = $mm_wannago.",".$r_idx;
        }else{
            $mm_wannago = $r_idx;
        }
        $sql = "UPDATE mango_member SET mm_wannago = '$mm_wannago' WHERE mm_userid = '$mm_userid'";
        $result = mysqli_query($conn, $sql);
    }else{
        echo "<script>console.log('데이터베이스 연결 실패!')</script>";
    }

?>