<?php
    include "./include/dbconn.php";
    $min_userid = $_GET['min_userid'];

    if(!$conn){
        echo "연결 객체 생성 실패 !";
    }else{
        $sql = "SELECT min_idx FROM min_member WHERE min_userid = '$min_userid'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);
        if($row['min_idx']){
            echo "y";   // 이미 가입된 아이디가 있음
        }else{
            echo "n";   // 가입된 아이디가 없음
        }
    }
?>