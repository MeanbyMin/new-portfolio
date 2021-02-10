<?php
    header('Content-Type: text/html; charset=UTF-8');
    session_start();
    if(!isset($_SESSION['idx'])){
        echo "<script>alert('잘못된 접근입니다. 로그인 하세요.'); location.href='./login.php'</script>";
    }
    session_unset();

    echo "<script>alert('로그아웃 되었습니다.'); location.href='./login.php';</script>";
    // setcookie('id', '', time()-10, '/');
    // echo "<script>alert('로그아웃 되었습니다.'); location.href = 'login.php';</script>";
?>