<?php
    header('Content-Type: text/html; charset=UTF-8');

    session_start();
    include "./include/dbconn.php";

    $userid = $_POST['userid'];
    $userpw = $_POST['userpw'];

    if(!$conn){
        echo "DB 연결 실패!";
    }else{
        $sql = "SELECT min_idx, min_userid, min_name FROM min_member WHERE min_userid='$userid' AND min_userpw='$userpw'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);
        if($row['min_idx'] == ""){
            echo "<script>alert('아이디 또는 비밀번호를 확인하세요.'); history.back();</script>";
        }else{
            $_SESSION['idx'] = $row['min_idx'];
            $_SESSION['id'] = $row['min_userid'];
            $_SESSION['name'] = $row['min_name'];
            echo "<script>alert('로그인 되었습니다.'); location.href='./login.php';</script>";
        }
    }
?>