<?php
    header('Content-Type: text/html; charset=UTF-8');
    if(!isset($_GET['r_idx'])){
        echo "<script>alert('잘못된 접근입니다.'); location.href='./index.php'</script>";
    }else{
        include "./include/dbconn.php";
        $r_idx = $_GET['r_idx'];
        $sql = "SELECT * FROM mango_restaurant WHERE r_idx = '$r_idx' AND r_status = '등록'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);
        if(!isset($row)){
            echo "<script>alert('잘못된 접근입니다.'); location.href='./index.php'</script>";
        }
    }
?>