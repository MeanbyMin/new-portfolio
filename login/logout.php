<?php
    header('Content-Type: text/html; charset=UTF-8');
    session_start();
    session_unset();

    echo "<script>alert('로그아웃 되었습니다.'); location.href='./login.php';</script>";
    // setcookie('id', '', time()-10, '/');
    // echo "<script>alert('로그아웃 되었습니다.'); location.href = 'login.php';</script>";
?>