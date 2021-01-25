<?php
    header('Content-Type: text/html; charset=UTF-8');
    $userid = $_POST['userid'];
    $userpw = $_POST['userpw'];

    if($userid == "admin" && $userpw == "1234"){
        setcookie("id", $userid, time()+(60*60*24), "/");
        echo "<script>alert('로그인 되었습니다.'); location.href='login.php';</script>";
    }else{
        echo "<script>alert('아이디 또는 비밀번호를 확인하세요.'); history.back();</script>";
    }
?>